<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PortofolioModel;
use App\Models\HistSearchModel;
use App\Models\AccountModel;


class Home extends BaseController
{
    protected $productModel;
    protected $portofolioModel;
    protected $histSearchModel;
    protected $accountModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->portofolioModel = new PortofolioModel();
        $this->histSearchModel = new HistSearchModel();
        $this->accountModel = new AccountModel();
    }

    // Beranda
    public function indexBeranda()
    {
        $idAccount = session()->get('id_account');

        // Ambil data rekomendasi
        $rekomendasiProduk = $this->productModel->getRecommendedProducts($idAccount);
        $rekomendasiPortofolio = $this->portofolioModel->getRecommendedPortofolio($idAccount);

        return view('home', [
            'produk' => $rekomendasiProduk,
            'portofolio' => $rekomendasiPortofolio
        ]);
    }

    public function indexBerandaAdmin()
    {
        $topSearches = $this->histSearchModel->select('search, COUNT(*) as total')
            ->groupBy('search')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->findAll();

        $userByStatus = $this->accountModel->select('status_akun, COUNT(*) as total')
            ->groupBy('status_akun')
            ->findAll();

        $userByRole = $this->accountModel->select('role, COUNT(*) as total')
            ->groupBy('role')
            ->findAll();

        $db = \Config\Database::connect();
        $topViewedProducts = $db->table('view_product vp')
            ->select('vp.id_product, p.nama_produk, COUNT(*) as views')
            ->join('products p', 'p.id_product = vp.id_product')
            ->groupBy('vp.id_product, p.nama_produk')
            ->orderBy('views', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $topOrderedProducts = $db->table('product_order po')
            ->select('po.id_product, p.nama_produk, SUM(po.qty) as total_ordered')
            ->join('products p', 'p.id_product = po.id_product')
            ->groupBy('po.id_product, p.nama_produk')
            ->orderBy('total_ordered', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $topViewedPortfolios = $db->table('view_portfolio vp')
            ->select('vp.id_portofolio, pf.judul, COUNT(*) as views')
            ->join('portofolio pf', 'pf.id_portofolio = vp.id_portofolio')
            ->groupBy('vp.id_portofolio, pf.judul')
            ->orderBy('views', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $transaksiStats = $db->table('transaksi')
            ->select('status, COUNT(*) as total_transaksi, SUM(total_price_producta) as total_uang')
            ->groupBy('status')
            ->get()
            ->getResult();
        
        $transaksiStats2 = $db->table('transaksi')
            ->select('status, COUNT(*) as total_transaksi, SUM(total_price_producta) as total_uang')
            ->whereNotIn('status', ['Pending', 'Batal'])
            ->groupBy('status')
            ->get()
            ->getResult();
        
        // Transaksi valid (tidak termasuk Pending dan Batal)
        $transaksiValid = $db->table('transaksi t')
        ->select('t.id_transaksi, t.id_account, p.amount, p.paid_at')
        ->join('payments p', 'p.id_transaksi = t.id_transaksi')
        ->whereNotIn('t.status', ['Pending', 'Batal'])
        ->get()->getResult();

        // Clustering pelanggan: jumlah transaksi dan total belanja
        $clustering = [];
        foreach ($transaksiValid as $row) {
            $id = $row->id_account;
            if (!isset($clustering[$id])) {
                $clustering[$id] = ['jumlah' => 0, 'total' => 0];
            }
            $clustering[$id]['jumlah'] += 1;
            $clustering[$id]['total'] += $row->amount;
        }

        // Ambil info nama dan email akun
        $accounts = $db->table('accounts')->select('id_account, nama, email')->get()->getResult();
        foreach ($accounts as $acc) {
            if (isset($clustering[$acc->id_account])) {
                $clustering[$acc->id_account]['nama'] = $acc->nama;
                $clustering[$acc->id_account]['email'] = $acc->email;
            }
        }

        $clustering = [];
        foreach ($transaksiValid as $row) {
            $id = $row->id_account;
            if (!isset($clustering[$id])) {
                $clustering[$id] = ['jumlah' => 0, 'total' => 0];
            }
            $clustering[$id]['jumlah'] += 1;
            $clustering[$id]['total'] += $row->amount;
        }

        // Ambil nama & email akun dan gabungkan
        $accounts = $db->table('accounts')->select('id_account, nama, email')->get()->getResult();
        foreach ($accounts as $acc) {
            if (isset($clustering[$acc->id_account])) {
                $clustering[$acc->id_account]['nama'] = $acc->nama;
                $clustering[$acc->id_account]['email'] = $acc->email;
            }
        }

        // Siapkan array numerik
        $clusterData = [];      // Untuk view
        $points = [];           // Untuk clustering
        $indexToId = [];        // Mapping index -> id_account

        foreach ($clustering as $id => $val) {
            $clusterData[$id] = [
                'id' => $id,
                'nama' => $val['nama'] ?? 'Tidak diketahui',
                'email' => $val['email'] ?? '-',
                'jumlah' => $val['jumlah'],
                'total' => $val['total'],
                'cluster' => null // default
            ];
            $points[] = [$val['jumlah'], $val['total']];
            $indexToId[] = $id;
        }

        // Lakukan clustering hanya jika ada minimal 2 pelanggan
        if (count($points) >= 2) {
            $k = 2;
            $maxIter = 100;
            $centroids = [$points[0], $points[1]];
            $assignments = [];

            for ($iter = 0; $iter < $maxIter; $iter++) {
                $newAssignments = [];
                foreach ($points as $i => $p) {
                    $dists = [];
                    foreach ($centroids as $c) {
                        $dists[] = pow($p[0] - $c[0], 2) + pow($p[1] - $c[1], 2);
                    }
                    $newAssignments[$i] = array_search(min($dists), $dists);
                }

                if ($assignments === $newAssignments) break;
                $assignments = $newAssignments;

                $sums = array_fill(0, $k, [0, 0]);
                $counts = array_fill(0, $k, 0);
                foreach ($points as $i => $p) {
                    $cluster = $assignments[$i];
                    $sums[$cluster][0] += $p[0];
                    $sums[$cluster][1] += $p[1];
                    $counts[$cluster]++;
                }

                for ($j = 0; $j < $k; $j++) {
                    if ($counts[$j] > 0) {
                        $centroids[$j] = [$sums[$j][0] / $counts[$j], $sums[$j][1] / $counts[$j]];
                    }
                }
            }

            // Gabungkan hasil klaster ke data berdasarkan index
            foreach ($assignments as $i => $clusterIndex) {
                $id = $indexToId[$i];
                $clusterData[$id]['cluster'] = $clusterIndex;
            }
        } else {
            // Hanya satu pelanggan, set cluster = 0
            foreach ($clusterData as &$data) {
                $data['cluster'] = 0;
            }
        }

        // Reset index array agar cocok dengan foreach di view
        $clusterData = array_values($clusterData);

        // Pendapatan harian
        $pendapatan = $db->table('transaksi t')
            ->select('DATE(p.paid_at) as tanggal, SUM(p.amount) as total')
            ->join('payments p', 'p.id_transaksi = t.id_transaksi')
            ->whereNotIn('t.status', ['Pending', 'Batal'])
            ->groupBy('DATE(p.paid_at)')
            ->orderBy('tanggal', 'ASC')
            ->get()->getResult();

        return view('admin/chibomi/index', [
            'topSearches' => $topSearches,
            'userByStatus' => $userByStatus,
            'userByRole' => $userByRole,
            'topViewedProducts' => $topViewedProducts,
            'topOrderedProducts' => $topOrderedProducts,
            'topViewedPortfolios' => $topViewedPortfolios,
            'transaksiStats' => $transaksiStats,
            'transaksiStats2' => $transaksiStats2,
            'clusteredData' => $clusterData,
            'pendapatan' => $pendapatan
        ]);
    }

    public function indexLaporan()
    {
        $range = $this->request->getPost('periode');

        if ($range) {
            if ($range) {
                $dates = explode(' to ', $range);
                $startDate = $dates[0] ?? null;
                $endDate = $dates[1] ?? null;

                if ($startDate && $endDate) {
                    $db = \Config\Database::connect();

                    $builder = $db->table('transaksi');
                        $builder->select('transaksi.*, payments.payment_method, payments.status_pembayaran, payments.paid_at');
                        $builder->join('payments', 'payments.id_transaksi = transaksi.id_transaksi', 'left');
                        $builder->where('payments.paid_at >=', $startDate . ' 00:00:00');
                        $builder->where('payments.paid_at <=', $endDate . ' 23:59:59');
                        $builder->orderBy('payments.paid_at', 'asc');

                    $dataLaporan = $builder->get()->getResultArray();

                    return view('admin/chibomi/laporan', [
                        'dataLaporan' => $dataLaporan,
                        'periode' => $range
                    ]);
                } else {
                    return redirect()->back()->with('error', 'Format tanggal tidak valid.');
                }
            }
        }

        return view('admin/chibomi/laporan');
    }

    // Kontak
    public function indexKontak()
    {
        return view('kontak');
    }

    //Cari
    public function csearch()
    {
        $q = $this->request->getPost('q');

        return redirect()->to('cari/'.$q);
    }

    public function search($keyword = null)
    {
        $produk = $this->productModel->searchProductWithImagesHargaRating($keyword);
        $portofolio = $this->portofolioModel->searchPortofolioWithImages($keyword);
        $session = session();
        
        if (!empty($session->get('id_account'))){
            $data = [
                'tanggal'=> date('Y-m-d H:i:s'),
                'search'=> $keyword,
                'id_account'=> $session->get('id_account') ?: null,
            ];
            $this->histSearchModel->insert($data);
        }

        return view('search_result', [
            'keyword' => $keyword,
            'produk' => $produk,
            'portofolio' => $portofolio
        ]);
    }
}
