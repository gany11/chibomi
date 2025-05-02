<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ImagesProductModel;
use App\Models\ProductPriceModel;
use App\Models\ProductSizeModel;
use App\Models\ViewProductModel;
use App\Models\ProductOrderModel;
use App\Models\StockModel;
use CodeIgniter\Controller;
use Ramsey\Uuid\Uuid;

class Product extends BaseController
{
    protected $productModel;
    protected $imagesProductModel;
    protected $productPriceModel;
    protected $productSizeModel;
    protected $stockModel;
    protected $viewProductModel;
    protected $productOrderModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->imagesProductModel = new ImagesProductModel();
        $this->productPriceModel = new ProductPriceModel();
        $this->productOrderModel = new ProductOrderModel();
        $this->productSizeModel = new ProductSizeModel();
        $this->stockModel = new StockModel();
        $this->viewProductModel = new ViewProductModel();
    }

    // Produk
    public function indexProduk()
    {
        $data['produk'] = $this->productModel->getProductWithImagesHargaRating();

        return view('product/produk', $data);
    }

    public function indexDetailProduk($slug)
    {
        $produk = $this->productModel
            ->where('slug', $slug)
            ->where('deleted_at', null)
            ->where('drafted_at', null)
            ->first();

        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $images = $this->imagesProductModel
        ->where('id_product', $produk['id_product'])
        ->whereIn('keterangan', ['Cover', 'Pendukung'])
        ->orderBy('FIELD(keterangan, "Cover", "Pendukung")')
        ->findAll();

        $session = session();

        $dataview = [
            'tanggal'=> date('Y-m-d H:i:s'),
            'id_product'=> $produk['id_product'],
            'id_account'=> $session->get('id_account') ?: null,
            'ip_address'=> request()->getIPAddress(),
        ];
        $this->viewProductModel->insert($dataview);

        $imageFiles = !empty($images) ? array_column($images, 'file') : ['1.png'];

        $harga = $this->productPriceModel
            ->where('id_product', $produk['id_product'])
            ->where('tanggal_berakhir', null)
            ->first();

        $ulasan = $this->productOrderModel->getUlasanByProduct($produk['id_product']);
        $ratingAvg = $this->productOrderModel->getRataRataRating($produk['id_product']);

        $data = [
            'produk' => $produk,
            'images'     => $imageFiles,
            'ulasan'   => $ulasan,
            'ratingAvg'   => $ratingAvg,
            'harga'   => $harga,
            'error' => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
        ];

        return view('product/detail', $data);
    }

    // Admin
    public function indexFormTambahProduct()
    {
        return view('admin/chibomi/add-product', [
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function saveFormTambahProduct()
    {
        $cover = $this->request->getFile('cover');
        $coverRequired = $cover && $cover->isValid();

        $validationRules = [
            'jenis'          => 'required|in_list[Barang,Jasa]',
            'kategori'       => 'permit_empty|string|max_length[255]',
            'nama_produk'    => 'required|string|max_length[255]|is_unique[products.nama_produk]',
            'deskripsi'      => 'required|string',
            'tag'            => 'required|string|max_length[255]',
            'harga_beli'     => 'required|decimal',
            'harga_jual'     => 'required|decimal',
            'stok_awal'      => 'permit_empty|integer',
            'panjang'        => 'permit_empty|decimal',
            'lebar'          => 'permit_empty|decimal',
            'tinggi'         => 'permit_empty|decimal',
            'berat'          => 'permit_empty|decimal',
            'cover'          => ($coverRequired ? 'uploaded[cover]|' : '') . 'max_size[cover,2048]|is_image[cover]|mime_in[cover,image/jpeg,image/png,image/jpg]',
        ];

        $validationMessages = [
            'jenis' => [
                'required' => 'Jenis produk wajib dipilih.',
                'in_list'  => 'Jenis harus berupa Barang atau Jasa.'
            ],
            'nama_produk' => [
                'required'   => 'Nama produk wajib diisi.',
                'max_length' => 'Nama produk maksimal 255 karakter.',
                'is_unique'  => 'Nama produk sudah digunakan.'
            ],
            'harga_beli' => [
                'required' => 'Harga beli wajib diisi.',
                'decimal'  => 'Harga beli harus berupa angka desimal.'
            ],
            'tag' => [
                'required'  => 'Tag wajib diisi.'
            ],
            'harga_jual' => [
                'required' => 'Harga jual wajib diisi.',
                'decimal'  => 'Harga jual harus berupa angka desimal.'
            ],
            'cover' => [
                'uploaded' => 'Cover wajib diupload.',
                'max_size' => 'Ukuran cover maksimal 2MB.',
                'is_image' => 'File harus berupa gambar.',
                'mime_in'  => 'Format gambar harus JPG, JPEG, PNG.'
            ],
        ];

        $jenis = $this->request->getPost('jenis');

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('error', 'Ada kesalahan pada form.')->with('errors', $this->validator->getErrors());
            if ($jenis === 'Barang'){
                $validationRules2 = [
                    'stok_awal'      => 'required|integer',
                    'panjang'        => 'required|decimal',
                    'lebar'          => 'required|decimal',
                    'tinggi'         => 'required|decimal',
                    'berat'          => 'required|decimal',
                ];
    
                $validationMessages2 = [
                    'panjang' => [
                        'required' => 'Panjang wajib diisi.',
                        'decimal'  => 'Panjang harus berupa angka desimal.'
                    ],
                    'stok_awal' => [
                        'required' => 'Stok wajib diisi.',
                        'integer'  => 'Stok harus berupa angka integer.'
                    ],
                    'lebar' => [
                        'required' => 'Lebar wajib diisi.',
                        'decimal'  => 'Lebar harus berupa angka desimal.'
                    ],
                    'tinggi' => [
                        'required' => 'Tinggi wajib diisi.',
                        'decimal'  => 'Tinggi harus berupa angka desimal.'
                    ],
                    'berat' => [
                        'required' => 'Berat wajib diisi.',
                        'decimal'  => 'Berat  harus berupa angka desimal.'
                    ],
                ];

                if (!$this->validate($validationRules2, $validationMessages2)) {
                    return redirect()->back()->withInput()->with('error', 'Ada kesalahan pada form.')->with('errors', $this->validator->getErrors());
                }
            }
        }

        $idProduk = Uuid::uuid4()->toString();

        $data = [
            'id_product'    => $idProduk,
            'jenis'         => $jenis,
            'kategori'      => $this->request->getPost('kategori') ?: null,
            'nama_produk'   => $this->request->getPost('nama_produk'),
            'slug'          => url_title($this->request->getPost('nama_produk'), '-', true),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'tag'           => $this->request->getPost('tag') ?: null,
            'drafted_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ];

        if (!$this->productModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
        }

        $harga = [
            'id_product_price'      => Uuid::uuid4()->toString(),
            'modal'                 => $this->request->getPost('harga_beli'),
            'price_unit'            => $this->request->getPost('harga_jual'),
            'id_product'            => $idProduk,
            'tanggal_awal'          => date('Y-m-d H:i:s'),
            'tanggal_berakhir'      => null,
        ];

        if (!$this->productPriceModel->insert($harga)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
        }
        
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $newFileName = $idProduk . '_' . time() . '.' . $cover->getExtension();
            $cover->move(FCPATH . 'assets/img/product/', $newFileName);

            $this->imagesProductModel->insert([
                'id_images' => Uuid::uuid4()->toString(),
                'id_product'        => $idProduk,
                'file'             => $newFileName,
                'alt'              => $data['nama_produk'],
                'keterangan'       => 'Cover',
            ]);
        }

        if ($jenis === 'Barang') {
            $stok = [
                'id_product'     => $idProduk,
                'id_stock'      => Uuid::uuid4()->toString(),
                'perubahan_stock'     => $this->request->getPost('stok_awal') ?: null,
                'keterangan'       => 'Stok Awal',
                'tanggal'    => date('Y-m-d H:i:s'),
            ];

            $dimensi = [
                'id_product'     => $idProduk,
                'panjang_cm'       => $this->request->getPost('panjang') ?: null,
                'lebar_cm'         => $this->request->getPost('lebar') ?: null,
                'tinggi_cm'        => $this->request->getPost('tinggi') ?: null,
                'berat_gram'        => $this->request->getPost('berat') ?: null,
            ];

            if (!$this->stockModel->insert($stok) && !$this->productSizeModel->insert($dimensi)) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
            }

            return redirect()->to('/admin/barang/list')->with('message', 'Barang berhasil ditambahkan.');
        }

        return redirect()->to('/admin/jasa/list')->with('message', 'Jasa berhasil ditambahkan.');
    }

    public function indexListJasa()
    {
        $data['jasa'] = $this->productModel
        ->where('deleted_at', null)
        ->where('jenis', 'Jasa')
        ->findAll();

        return view('admin/chibomi/list-jasa', $data);
    }

    public function indexListBarang()
    {
        $data['jasa'] = $this->productModel
        ->where('deleted_at', null)
        ->where('jenis', 'Barang')
        ->findAll();

        return view('admin/chibomi/list-barang', $data);
    }



    public function archive()
    {
        $id = $this->request->getVar('id_product');

        // Validasi id
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID produk tidak valid']);
        }

        $data = [
            'drafted_at' => date('Y-m-d H:i:s')
        ];

        $update = $this->productModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'message' => 'Portofolio berhasil diarsipkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengarsipkan product']);
        }
    }

    public function restore()
    {
        $id = $this->request->getVar('id_product');

        // Validasi id
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID produk tidak valid']);
        }

        // Perbarui status product dan hapus timestamp draft_at
        $data = [
            'drafted_at' => null
        ];

        $update = $this->productModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'message' => 'Portofolio berhasil dipulihkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memulihkan product']);
        }
    }

    public function delete()
    {
        $id = $this->request->getVar('id_product');

        // Validasi id
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID produk tidak valid']);
        }

        // Tambahkan timestamp deleted_at untuk soft delete
        $data = [
            'deleted_at' => date('Y-m-d H:i:s')
        ];

        $update = $this->productModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'message' => 'Portofolio berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus product']);
        }
    }
}