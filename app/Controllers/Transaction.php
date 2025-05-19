<?php

namespace App\Controllers;

use App\Models\AddressModel;
use App\Models\DeliveryServiceModel;
use App\Models\StockModel;
use App\Models\TransaksiModel;
use App\Models\DeliveryModel;
use App\Models\CartModel;
use App\Models\ProductOrderModel;
use App\Models\PaymentsModel;
use App\Models\DokumenJasaModel;
use CodeIgniter\Controller;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use Midtrans\Snap;
use Midtrans\Config;
use Config\Midtrans as MidtransConfig;

class Transaction extends BaseController
{
    use ResponseTrait;
    protected $addressModel;
    protected $deliveryServiceModel;
    protected $transaksiModel, $pengirimanModel, $stockModel, $productOrderModel;
    protected $cartModel;
    protected $paymentsModel;
    protected $dokumenJasaModel;
    
    public function __construct()
    {
        $this->addressModel = new AddressModel();
        $this->deliveryServiceModel = new DeliveryServiceModel();
        $this->transaksiModel = new TransaksiModel();
        $this->cartModel = new CartModel();
        $this->pengirimanModel = new DeliveryModel();
        $this->stockModel = new StockModel();
        $this->productOrderModel = new ProductOrderModel();
        $this->paymentsModel = new PaymentsModel();
        $this->dokumenJasaModel = new DokumenJasaModel();


        $midtransConfig = new MidtransConfig();

        Config::$serverKey = $midtransConfig->serverKey;
        Config::$isProduction = $midtransConfig->isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function callback()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            log_message('debug', 'Callback STARTED');
            log_message('debug', 'Raw: ' . $json);
            log_message('debug', 'Decoded: ' . print_r($data, true));

            if (!is_array($data)) {
                throw new \Exception('Invalid JSON payload');
            }

            $signatureKey = $data['signature_key'] ?? '';
            $expectedSignature = hash('sha512',
                $data['order_id'] .
                $data['status_code'] .
                $data['gross_amount'] .
                KEY_MIDTRANS_SERVER
            );

            if ($signatureKey !== $expectedSignature) {
                throw new \Exception('Invalid signature');
            }

            //....
            // Validasi field wajib
            if (!isset($data['order_id'], $data['transaction_status'])) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid payload']);
            }

            $orderId = $data['order_id'];
            $idTransaksi = preg_replace('/-\d{3}$/', '', $orderId);

            // Cegah duplikasi
            if ($this->paymentsModel->where('id_transaksi', $idTransaksi)->first()) {
                $this->paymentsModel->where('id_transaksi', $idTransaksi)->set(['midtrans_transaction_id' => $data['transaction_id'],
                                                                                'payment_method' => $data['payment_type'],
                                                                                'status_pembayaran' => $data['transaction_status'],
                                                                                'amount' => $data['gross_amount'],
                                                                                'fee' => 0])->update();
            } else {
                $this->paymentsModel->insert([
                    'id_payments' => Uuid::uuid4()->toString(),
                    'id_transaksi' => $idTransaksi,
                    'midtrans_transaction_id' => $data['transaction_id'],
                    'payment_method' => $data['payment_type'],
                    'status_pembayaran' => $data['transaction_status'],
                    'amount' => $data['gross_amount'],
                    'fee' => 0,
                ]);
            }
            
            if ($data['transaction_status'] === 'settlement') {
                $this->paymentsModel->where('id_transaksi', $idTransaksi)->set(['paid_at' => date('Y-m-d H:i:s', strtotime($data['settlement_time']))])->update();
                $this->transaksiModel->update($idTransaksi, ['status' => 'Proses']);
            }
            //....

            return $this->response->setJSON(['message' => 'Callback processed']);
        } catch (\Throwable $e) {
            log_message('critical', 'Callback error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function bayar($id_transaksi)
    {
        $idAccount = session()->get('id_account');
        $pesanan = $this->transaksiModel->find($id_transaksi);

        if (!$pesanan || $pesanan['id_account'] !== $idAccount || $pesanan['status'] !== 'Pending') {
            return $this->response->setJSON(['error' => 'Data tidak valid atau pembayaran tidak tersedia.']);
        }

        $grossAmount = $pesanan['total_price_producta'];
        $item_details = [];
        $listOrder = $this->productOrderModel
            ->select('product_order.*, products.nama_produk')
            ->join('products', 'products.id_product = product_order.id_product')
            ->where('product_order.id_transaksi', $pesanan['id_transaksi'])
            ->findAll();

        foreach ($listOrder as $item) {
            $item_details[] = [
                'id' => $item['id_product'],
                'price' => $item['total_price'] / $item['qty'],
                'quantity' => $item['qty'],
                'name' => $item['nama_produk'],
            ];
        }
        if ($pesanan['jenis'] === 'Barang') {
            $pengiriman = $this->pengirimanModel
                ->select('pengiriman.*, delivery_service.nama, delivery_service.kode')
                ->join('delivery_service', 'delivery_service.id_delivery_service = pengiriman.id_delivery_service')
                ->where('pengiriman.id_transaksi', $pesanan['id_transaksi'])
                ->first();
        
            if ($pengiriman) {
                $item_details[] = [
                    'id' => $pengiriman['id_pengiriman'],
                    'price' => $pengiriman['shipping_cost'],
                    'quantity' => 1,
                    'name' => $pengiriman['nama'],
                ];
            }
        }        

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan['id_transaksi'].'-'.rand(101,999),
                'invoice' => $pesanan['invoice_number'],
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => session()->get('nama'),
                'email' => session()->get('email'),
                'phone' => session()->get('telepon'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $this->response->setJSON(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function pembayaran($status)
    {
        if($status === 'error'){
            return redirect()->back()->with('error', 'Pembayaran Gagal.');
        }if($status === 'finish'){
            return redirect()->back()->with('success', 'Pembayaran Berhasil.');
        }if($status === 'unfinish'){
            return redirect()->back()->with('error', 'Pembayaran Tertunda.');
        }
        
    }

    public function pesanan()
    {
        $idAccount = session()->get('id_account');

        $data['pesanan'] = $this->transaksiModel
            ->where('id_account', $idAccount)
            ->orderBy("FIELD(status, 'Pending', 'Proses', 'Kirim', 'Selesai', 'Batal')", '', false)
            ->findAll();

        return view('transaction/pesanan', $data);
    }

    public function kirimUlasan()
    {
        $idOrder = $this->request->getPost('id_product_order');
        $rating = $this->request->getPost('rating');
        $ulasan = $this->request->getPost('ulasan');

        if (!$this->validate([
            'id_product_order' => 'required',
            'rating' => 'required|in_list[1,2,3,4,5]',
            'ulasan' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->with('error', 'Input ulasan tidak valid.');
        }

        $productOrder = $this->productOrderModel->find($idOrder);

        if (!$productOrder) {
            return redirect()->back()->with('error', 'Data produk tidak ditemukan.');
        }

        if (!empty($productOrder['rating']) && !empty($productOrder['ulasan'])) {
            return redirect()->back()->with('error', 'Anda sudah memberi ulasan.');
        }

        $this->productOrderModel->update($idOrder, [
            'rating' => $rating,
            'ulasan' => $ulasan,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }


    public function pesananDetail($id)
    {
        $idAccount = session()->get('id_account');

        $pesanan = $this->transaksiModel->find($id);

        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Data tidak ditemukan.');
        }

        if ($pesanan['id_account'] !== $idAccount) {
            return redirect()->to('/pesanan')->with('error', 'Anda tidak memiliki izin untuk melihat pesanan ini.');
        }

        $data['pesanan'] = $pesanan;
        $data['listOrder'] = $this->productOrderModel
            ->select('product_order.*, products.nama_produk')
            ->join('products', 'products.id_product = product_order.id_product')
            ->where('product_order.id_transaksi', $pesanan['id_transaksi'])
            ->findAll();

        $data['payment'] = $this->paymentsModel
            ->where('id_transaksi', $pesanan['id_transaksi'])
            ->where('paid_at IS NOT', null, false)
            ->findAll();
        if ($pesanan['jenis'] === 'Jasa'){
            $data['dokumen'] = $this->dokumenJasaModel->where('id_transaksi', $pesanan['id_transaksi'])->first();
        } else {
            $data['pengiriman'] = $this->pengirimanModel
                ->select('pengiriman.*, delivery_service.nama, delivery_service.kode')
                ->join('delivery_service', 'delivery_service.id_delivery_service = pengiriman.id_delivery_service')
                ->where('pengiriman.id_transaksi', $pesanan['id_transaksi'])
                ->findAll();
        }
        return view('transaction/detail-pesanan', $data);
    }

    public function cek()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON(true);
            $cartItems = $json['cartItems'];

            session()->set('checkout_items', $cartItems);

            return $this->response->setJSON(['success' => true]);
        }

        // Ambil data dari session
        $allItems = session()->get('checkout_items') ?? [];

        // Pisahkan jenis Barang dan Jasa
        $barangItems = [];
        $jasaItems = [];

        foreach ($allItems as $item) {
            if (strtolower($item['jenis']) === 'barang') {
                $barangItems[] = $item;
            } else {
                $jasaItems[] = $item;
            }
        }

        $alamat = [];
        $deliveryServices = [];

        if (!empty($barangItems)) {
            $id_account = session()->get('id_account');

            $alamat = $this->addressModel
                ->where('id_account', $id_account)
                ->findAll();

            if (!$alamat) {
                return redirect()->to('/alamat')->with('error', 'Alamat tidak ditemukan.');
            }

            $selectedAlamatId = null;
            if (!empty($alamat)) {
                // Pilih alamat secara acak
                $randomKey = array_rand($alamat);
                $selectedAlamatId = $alamat[$randomKey]['id_address'];
            }

            $deliveryServices = $this->deliveryServiceModel
                ->where('status', 'Aktif')
                ->findAll();

            if (!$deliveryServices) {
                return redirect()->to('/keranjang')->with('error', 'Tidak ada jasa pengiriman yang aktif. Silahkan hubungi admin!');
            }
        }

        $data = [
            'barang_items'      => $barangItems,
            'jasa_items'        => $jasaItems,
            'selectedAlamatId' => ($selectedAlamatId ?? ''),
            'alamat'            => ($alamat),
            'delivery_services' => ($deliveryServices)
        ];

        return view('transaction/konfirmasi', $data);
    }

    public function cekOngkir()
    {
        $json = $this->request->getJSON(true);

        $origin = '11480';  // Kode Pos asal (sesuaikan dengan kode pos yang benar)
        $destination = $json['destination'] ?? null;  // Kode Pos tujuan
        $weight = (int) ($json['weight'] ?? 0);  // Berat dalam gram
        $couriers = $json['courier'] ?? null;  // Kode kurir

        // Validasi input
        if (empty($destination) || empty($weight) || empty($couriers)) {
            return $this->response->setJSON([
                'status' => 400,
                'message' => 'Data tidak lengkap untuk menghitung ongkir.'
            ]);
        }

        try {
            // Inisialisasi Guzzle client
            $client = new \GuzzleHttp\Client();

            // Mengirim data dalam format multipart/form-data
            $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'multipart' => [
                    ['name' => 'origin', 'contents' => $origin],  // Asal
                    ['name' => 'destination', 'contents' => $destination],  // Tujuan
                    ['name' => 'weight', 'contents' => $weight],  // Berat
                    ['name' => 'courier', 'contents' => $couriers],  // Kurir
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => KEY  // Ganti dengan API key yang valid
                ]
            ]);

            // Mendapatkan hasil respons dari API
            $result = json_decode($response->getBody(), true);
            return $this->response->setJSON($result);

        } catch (\Exception $e) {
            // Menangani kesalahan jika gagal
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Gagal mengambil data ongkir: ' . $e->getMessage()
            ]);
        }
    }

    public function simpan()
    {
        $json = $this->request->getJSON(true);
        log_message('debug', 'Data yang diterima di backend: ' . print_r($json, true)); // Log data yang diterima
        $idAccount = session()->get('id_account');
        $datetime = date('Y-m-d H:i:s');

        $responses = [];

        if (isset($json['listbarang'])) {
            $idTransaksiBarang = Uuid::uuid4()->toString();
            $invoiceBarang = 'INV-BRG-' . date('YmdHis').'-'.rand(101,999);
            $shippingCost = $json['shipping_cost'] ?? 0;

            // Total barang
            $totalBarang = array_sum(array_column($json['listbarang'], 'total_price')) + $shippingCost;

            $datatransaksi = [
                'id_transaksi' => $idTransaksiBarang,
                'id_account' => $idAccount,
                'invoice_number' => $invoiceBarang,
                'status' => 'Pending',
                'jenis' => 'Barang',
                'total_price_producta' => $totalBarang,
            ];
            $this->transaksiModel->insert($datatransaksi);

            // Simpan pengiriman
            $alamat = $json['alamat'];
            $alamatString = "{$alamat['alamat_lengkap']}, {$alamat['kelurahan']}, {$alamat['kecamatan']}, {$alamat['kota_kabupaten']}, {$alamat['provinsi']} {$alamat['kode_pos']}";

            $datapengiriman = [
                'id_pengiriman' => Uuid::uuid4()->toString(),
                'id_delivery_service' => $json['code'],
                'id_transaksi' => $idTransaksiBarang,
                'nama_tujuan' => $json['nama_tujuan'],
                'telepon' => $json['telepon'],
                'alamat' => $alamatString,
                'shipping_cost' => $shippingCost,
                'resi' => null
            ];

            $this->pengirimanModel->insert($datapengiriman);

            // Simpan produk barang & update stok
            foreach ($json['listbarang'] as $item) {
                $productId = $item['id_product'];
                $qty = $item['qty'];

                // Cek stok tersedia
                $stokTersedia = $this->stockModel
                    ->where('id_product', $productId)
                    ->where('perubahan_stock !=', 0)
                    ->selectSum('perubahan_stock')
                    ->first();

                if (!$stokTersedia || $stokTersedia['perubahan_stock'] < $qty) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => "Stok produk ID $productId tidak mencukupi."
                    ]);
                }

                // Update stok
                $this->stockModel->insert([
                    'id_stock' => Uuid::uuid4()->toString(),
                    'id_product' => $productId,
                    'perubahan_stock' => -$qty,
                    'tanggal' => $datetime,
                    'keterangan' => 'Transaksi ' . $idTransaksiBarang
                ]);

                // Simpan order barang
                $this->productOrderModel->insert([
                    'id_product' => $productId,
                    'id_transaksi' => $idTransaksiBarang,
                    'qty' => $qty,
                    'total_price' => $item['total_price'],
                    'rating' => null,
                    'ulasan' => null,
                    'hide_at' => null
                ]);
            }
        }

        // === 2. SIMPAN TRANSAKSI JASA ===
        if (isset($json['listjasa'])) {
            $idTransaksiJasa = Uuid::uuid4()->toString();
            $invoiceJasa = 'INV-JSA-' . date('YmdHis').'-'.rand(101,999);
            $totalJasa = array_sum(array_column($json['listjasa'], 'total_price'));

            $this->transaksiModel->insert([
                'id_transaksi' => $idTransaksiJasa,
                'id_account' => $idAccount,
                'invoice_number' => $invoiceJasa,
                'status' => 'Pending',
                'jenis' => 'Jasa',
                'total_price_producta' => $totalJasa,
            ]);

            foreach ($json['listjasa'] as $item) {
                $this->productOrderModel->insert([
                    'id_product' => $item['id_product'],
                    'id_transaksi' => $idTransaksiJasa,
                    'qty' => $item['qty'],
                    'total_price' => $item['total_price'],
                    'rating' => null,
                    'ulasan' => null,
                    'hide_at' => null
                ]);
            }
        }

        $this->cartModel->where('id_account', $idAccount)->delete();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'redirect_url' => $responses[0] ?? base_url('pesanan')
        ]);
    }

    public function simpanJasa()
    {
        $json = $this->request->getJSON(true);
        log_message('debug', 'Data yang diterima di backend: ' . print_r($json, true));
        $idAccount = session()->get('id_account');
        $datetime = date('Y-m-d H:i:s');

        $responses = [];

        if (isset($json['listjasa'])) {
            $idTransaksiJasa = Uuid::uuid4()->toString();
            $invoiceJasa = 'INV-JSA-' . date('YmdHis').'-'.rand(101,999);
            $totalJasa = array_sum(array_column($json['listjasa'], 'total_price'));

            $this->transaksiModel->insert([
                'id_transaksi' => $idTransaksiJasa,
                'id_account' => $idAccount,
                'invoice_number' => $invoiceJasa,
                'status' => 'Pending',
                'jenis' => 'Jasa',
                'total_price_producta' => $totalJasa,
            ]);

            foreach ($json['listjasa'] as $item) {
                $this->productOrderModel->insert([
                    'id_product' => $item['id_product'],
                    'id_transaksi' => $idTransaksiJasa,
                    'qty' => $item['qty'],
                    'total_price' => $item['total_price'],
                    'rating' => null,
                    'ulasan' => null,
                    'hide_at' => null
                ]);
            }
        }

        $this->cartModel->where('id_account', $idAccount)->delete();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'redirect_url' => $responses[0] ?? base_url('pesanan')
        ]);
    }

    // Admin
    public function indexTransaksiAdmin($jenis, $status)
    {
        $transaksi = $this->transaksiModel->where('jenis', ucwords($jenis))->where('status', ucwords($status))->findAll();

        return view('admin/chibomi/list-transaksi', [
            'transaksi' => $transaksi,
            'jenis' => $jenis,
            'status' => $status,
        ]);
    }

    public function pesananDetailAdmin($id)
    {
        $pesanan = $this->transaksiModel->find($id);

        if (!$pesanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data tidak ditemukan.');
        }

        $data['transaksi'] = $pesanan;
        $data['listOrder'] = $this->productOrderModel
            ->select('product_order.*, products.nama_produk')
            ->join('products', 'products.id_product = product_order.id_product')
            ->where('product_order.id_transaksi', $pesanan['id_transaksi'])
            ->findAll();

        $data['payment'] = $this->paymentsModel
            ->where('id_transaksi', $pesanan['id_transaksi'])
            ->first();

        if ($pesanan['jenis'] === 'Jasa'){
            $data['dokumen'] = $this->dokumenJasaModel->where('id_transaksi', $pesanan['id_transaksi'])->first();
        } else {
            $data['pengiriman'] = $this->pengirimanModel
                ->select('pengiriman.*, delivery_service.nama, delivery_service.kode')
                ->join('delivery_service', 'delivery_service.id_delivery_service = pengiriman.id_delivery_service')
                ->where('pengiriman.id_transaksi', $pesanan['id_transaksi'])
                ->first();
        }
        return view('admin/chibomi/detail-transaksi', $data);
    }

    public function lacakPengiriman($id)
    {
        $idAccount = session()->get('id_account');
        $role = session()->get('role');

        $pesanan = $this->transaksiModel->find($id);

        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Data tidak ditemukan.');
        }

        if (!in_array($role, ['Admin', 'Pemilik']) && $pesanan['id_account'] !== $idAccount) {
            return redirect()->to('/pesanan')->with('error', 'Anda tidak memiliki izin untuk melihat pesanan ini.');
        }

        $data['transaksi'] = $pesanan;

        if ($pesanan['jenis'] === 'Jasa') {
            $data['error'] = 'Tidak ada pengiriman untuk pesanan jasa.';
        } else {
            $pengiriman = $this->pengirimanModel
                ->select('pengiriman.*, delivery_service.nama, delivery_service.kode')
                ->join('delivery_service', 'delivery_service.id_delivery_service = pengiriman.id_delivery_service')
                ->where('pengiriman.id_transaksi', $pesanan['id_transaksi'])
                ->first();

            $data['pengiriman'] = $pengiriman;

            // Panggil API tracking jika nomor resi tersedia
            if ($pengiriman && $pengiriman['resi'] && $pengiriman['kode']) {
                try {
                    $client = new \GuzzleHttp\Client();
                    $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/track/waybill', [
                        'headers' => [
                            'accept' => 'application/json',
                            'key' => KEY,
                        ],
                        'query' => [
                            'awb' => $pengiriman['resi'],
                            'courier' => $pengiriman['kode'],
                        ],
                    ]);

                    $body = json_decode($response->getBody(), true);
                    $data['tracking'] = $body['data'] ?? null;
                } catch (\Exception $e) {
                    $data['tracking'] = null;
                    $data['error'] = 'Gagal mengambil data tracking: ' . $e->getMessage();
                }
            } else {
                $data['error'] = 'Informasi resi atau kurir tidak tersedia.';
            }
        }

        return view('transaction/lacak', $data);
    }

    public function kirim_barang($id)
    {
        $resi = $this->request->getPost('no_resi');

        if (empty($resi)) {
            return redirect()->back()->with('error', 'No. Resi wajib diisi');
        }

        $pesanan = $this->transaksiModel->find($id);

        if (!$pesanan) {
            return redirect()->to()->back()->with('error', 'Data tidak ditemukan.');
        }
        $this->transaksiModel->update($id, ['status' => 'Kirim']);

        $pengiriman = $this->pengirimanModel
            ->where('id_transaksi', $pesanan['id_transaksi'])
            ->first();

        if (!$pengiriman) {
            return redirect()->back()->with('error', 'Data pengiriman tidak ditemukan.');
        }

        if (!$this->pengirimanModel->update($pengiriman['id_pengiriman'], ['resi' => $resi])) {
            return redirect()->back()->with('error', 'Gagal mengupdate No. Resi.');
        }

        return redirect()->to("/admin/pesanan/list/barang/kirim")->with('message', 'Barang berhasil dikirim dengan No. Resi.');
    }

    public function selesai_jasa($id)
    {
        $link = $this->request->getPost('link_dokumen');

        if (empty($link)) {
            return redirect()->back()->with('error', 'Link dokumen wajib diisi');
        }

        $pesanan = $this->transaksiModel->find($id);

        if (!$pesanan) {
            return redirect()->to()->back()->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'id_dokumen_jasa' => Uuid::uuid4()->toString(),
            'id_transaksi' => $id,
            'url_dokumen' => $link,
        ];

        $dokumen = $this->dokumenJasaModel->where('id_transaksi', $id)->findAll();
        if (!$dokumen){
            $this->transaksiModel->update($id, ['status' => 'Selesai']);
            $this->dokumenJasaModel->insert($data);
    
            return redirect()->to("/admin/pesanan/list/jasa/selesai")->with('message', 'Jasa berhasil diselesaikan dengan dokumen terlampir.');
        }
        return redirect()->to()->back()->with('error', 'Dokumen sudah tersedia.');
    }


    public function ubahStatus()
    {
        $json = $this->request->getJSON(true);

        $id = $json['id'] ?? null;
        $status = $json['status'] ?? null;
        $statusawal = $json['statusawal'] ?? null;

        if (!$id || !$status || !$statusawal) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap.'
            ]);
        }

        $data = $this->transaksiModel->where('id_transaksi', $id)->where('status', $statusawal)->first();

        if (!$data) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status transaksi.'
            ]);
        }

        $updated = $this->transaksiModel->where('id_transaksi', $id)->set(['status' => $status])->update();

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status transaksi berhasil diperbarui.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status transaksi.'
            ]);
        }
    }
}
