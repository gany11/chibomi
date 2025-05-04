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

    public function hideUlasan($id)
    {
        $produk = $this->productOrderModel->find($id);

        if (!$produk) {
            return redirect()->back()->with('eror', 'Ulasan tidak ditemukan.');
        }

        $this->productOrderModel->update($id, [
            'hide_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
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
            'kategori'       => 'required|string|max_length[255]',
            'nama_produk'    => 'required|string|max_length[255]|is_unique[products.nama_produk]',
            'deskripsi'      => 'required|string',
            'tag'            => 'required|string|max_length[255]',
            'harga_beli'     => 'required|decimal',
            'harga_jual'     => 'required|decimal',
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
            'deskripsi' => [
                'required'    => 'Deskripsi wajib diisi.',
                'string'      => 'Deskripsi harus berupa teks.',
            ],
            'harga_beli' => [
                'required' => 'Harga beli wajib diisi.',
                'decimal'  => 'Harga beli harus berupa angka desimal.'
            ],
            'tag' => [
                'required'  => 'Tag wajib diisi.'
            ],
            'kategori' => [
                'required'  => 'Kategori wajib diisi.'
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
                'id_product_size'     => Uuid::uuid4()->toString(),
                'id_product'        => $idProduk,
                'panjang_cm'       => $this->request->getPost('panjang') ?: null,
                'lebar_cm'         => $this->request->getPost('lebar') ?: null,
                'tinggi_cm'        => $this->request->getPost('tinggi') ?: null,
                'berat_gram'        => $this->request->getPost('berat') ?: null,
            ];

            if (!$this->stockModel->insert($stok)) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
            }

            if (!$this->productSizeModel->insert($dimensi)) {
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
        $data['barang'] = $this->productModel
        ->where('deleted_at', null)
        ->where('jenis', 'Barang')
        ->findAll();

        return view('admin/chibomi/list-barang', $data);
    }

    //Edit
    public function indexDetailBarangAdmin($id)
    {
        $produk = $this->productModel
            ->where('id_product', $id)
            ->where('deleted_at', null)
            ->where('jenis', 'Barang')
            ->first();

        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $images = $this->imagesProductModel
        ->where('id_product', $produk['id_product'])
        ->whereIn('keterangan', ['Cover', 'Pendukung'])
        ->orderBy('FIELD(keterangan, "Cover", "Pendukung")')
        ->findAll();

        $imageFiles = empty($images) ? ['1.png'] : array_column($images, 'file');

        $harga = $this->productPriceModel
            ->where('id_product', $produk['id_product'])
            ->where('tanggal_berakhir', null)
            ->first();

        $dimensi = $this->productSizeModel
        ->where('id_product', $produk['id_product'])
        ->first();

        $data = [
            'barang' => $produk,
            'images' => $imageFiles,
            'harga' => $harga,
            'dimensi' => $dimensi,
            'message' => session()->getFlashdata('message'),
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ];

        return view('admin/chibomi/detail-barang', $data);
    }

    public function saveDetailBarangAdmin($id)
    {
        $validationRules = [
            'kategori'       => 'required|string|max_length[255]',
            'deskripsi'      => 'required|string',
            'tag'            => 'required|string|max_length[255]',
            'harga_beli'     => 'required|decimal',
            'harga_jual'     => 'required|decimal',
            'stok_awal'      => 'permit_empty|integer',
            'panjang'        => 'required|decimal',
            'lebar'          => 'required|decimal',
            'tinggi'         => 'required|decimal',
            'berat'          => 'required|decimal',
        ];

        $validationMessages = [
            'harga_beli' => [
                'required' => 'Harga beli wajib diisi.',
                'decimal'  => 'Harga beli harus berupa angka desimal.'
            ],
            
            'kategori' => [
                'required'    => 'Kategori wajib diisi.',
            ],
            'deskripsi' => [
                'required'    => 'Deskripsi wajib diisi.',
                'string'      => 'Deskripsi harus berupa teks.',
            ],
            'tag' => [
                'required'  => 'Tag wajib diisi.'
            ],
            'harga_jual' => [
                'decimal'  => 'Harga jual harus berupa angka desimal.'
            ],
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

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', 'Ada kesalahan pada form.')->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'kategori'        => $this->request->getPost('kategori') ?: null,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'tag'             => $this->request->getPost('tag') ?: null,
        ];

        $harga = [
            'id_product_price'      => Uuid::uuid4()->toString(),
            'modal'                 => $this->request->getPost('harga_beli'),
            'price_unit'            => $this->request->getPost('harga_jual'),
            'id_product'            => $id,
            'tanggal_awal'          => date('Y-m-d H:i:s'),
        ];

        $dimensi = [
            'panjang_cm'       => $this->request->getPost('panjang') ?: null,
            'lebar_cm'         => $this->request->getPost('lebar') ?: null,
            'tinggi_cm'        => $this->request->getPost('tinggi') ?: null,
            'berat_gram'        => $this->request->getPost('berat') ?: null,
        ];
    
        $produk = $this->productModel
            ->where('id_product', $id)
            ->where('deleted_at', null)
            ->where('jenis', 'Barang')
            ->first();
    
        if (!$produk) {
            return redirect()->to('/admin/barang/list')->with('error', 'Data barang tidak ditemukan');
        }

        if (!$this->productModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
        }

        $dataDimensi = $this->productSizeModel
                ->where('id_product', $produk['id_product'])
                ->first();

        if (!$this->productSizeModel->update($dataDimensi['id_product_size'], $dimensi)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
        }

        $dataHarga = $this->productPriceModel
            ->where('id_product', $produk['id_product'])
            ->where('tanggal_berakhir', null)
            ->first();

        $harga2 = [
            'tanggal_berakhir'      => date('Y-m-d H:i:s'),
        ];

        if ($this->productPriceModel->update($dataHarga['id_product_price'], $harga2)) {
            if (!$this->productPriceModel->insert($harga)) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
        }

        $stokTambah = $this->request->getPost('stok_awal');
        if (!empty($stokTambah)){
            $stok = [
                'id_product'     => $produk['id_product'],
                'id_stock'      => Uuid::uuid4()->toString(),
                'perubahan_stock'     =>  $stokTambah ?: null,
                'keterangan'       => 'Penambahan Awal',
                'tanggal'    => date('Y-m-d H:i:s'),
            ];
            if (!$this->stockModel->insert($stok)) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
            }
        }

    
        $gambarFiles = $this->request->getFileMultiple('gambar');

        if ($gambarFiles && is_array($gambarFiles)) {
            foreach ($gambarFiles as $file) {
                // Lewati file kosong (tanpa upload)
                if ($file->getError() === 4) {
                    continue;
                }

                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->getSize() > 2097152 || !in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                        return redirect()->back()->with('error', 'File gambar tidak valid atau melebihi 2MB.');
                    }

                    $newFileName = $id . '_' . time() . '.' . $file->getExtension();
                    $file->move(FCPATH . 'assets/img/product/', $newFileName);

                    $this->imagesProductModel->insert([
                        'id_images' => Uuid::uuid4()->toString(),
                        'id_product'        =>  $id,
                        'file'                 => $newFileName,
                        'alt'                  => $produk['nama_produk'],
                        'keterangan'           => 'Pendukung',
                    ]);
                }
            }
        }

        return redirect()->to('/admin/barang/detail/' . $produk['id_product'])->with('message', 'Data berhasil diperbarui.');
    }

    public function indexDetailJasaAdmin($id)
    {
        $produk = $this->productModel
            ->where('id_product', $id)
            ->where('deleted_at', null)
            ->where('jenis', 'Jasa')
            ->first();

        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $images = $this->imagesProductModel
        ->where('id_product', $produk['id_product'])
        ->whereIn('keterangan', ['Cover', 'Pendukung'])
        ->orderBy('FIELD(keterangan, "Cover", "Pendukung")')
        ->findAll();

        $imageFiles = empty($images) ? ['1.png'] : array_column($images, 'file');

        $harga = $this->productPriceModel
            ->where('id_product', $produk['id_product'])
            ->where('tanggal_berakhir', null)
            ->first();

        $data = [
            'jasa' => $produk,
            'images' => $imageFiles,
            'harga' => $harga,
            'message' => session()->getFlashdata('message'),
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ];

        return view('admin/chibomi/detail-jasa', $data);
    }

    public function saveDetailJasaAdmin($id)
    {
        $validationRules = [
            'kategori'       => 'required|string|max_length[255]',
            'deskripsi'      => 'required|string',
            'tag'            => 'required|string|max_length[255]',
            'harga_beli'     => 'required|decimal',
            'harga_jual'     => 'required|decimal',
        ];

        $validationMessages = [
            'harga_beli' => [
                'required' => 'Harga beli wajib diisi.',
                'decimal'  => 'Harga beli harus berupa angka desimal.'
            ],            
            'kategori' => [
                'required'    => 'Kategori wajib diisi.',
            ],
            'deskripsi' => [
                'required'    => 'Deskripsi wajib diisi.',
                'string'      => 'Deskripsi harus berupa teks.',
            ],
            'tag' => [
                'required'  => 'Tag wajib diisi.'
            ],
            'harga_jual' => [
                'required' => 'Harga jual wajib diisi.',
                'decimal'  => 'Harga jual harus berupa angka desimal.'
            ],
        ]; 

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', 'Ada kesalahan pada form.')->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'kategori'        => $this->request->getPost('kategori') ?: null,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'tag'             => $this->request->getPost('tag') ?: null,
        ];

        $harga = [
            'id_product_price'      => Uuid::uuid4()->toString(),
            'modal'                 => $this->request->getPost('harga_beli'),
            'price_unit'            => $this->request->getPost('harga_jual'),
            'id_product'            => $id,
            'tanggal_awal'          => date('Y-m-d H:i:s'),
        ];
    
        $produk = $this->productModel
            ->where('id_product', $id)
            ->where('deleted_at', null)
            ->where('jenis', 'Jasa')
            ->first();
    
        if (!$produk) {
            return redirect()->to('/admin/jasa/list')->with('error', 'Data jasa tidak ditemukan');
        }

        if (!$this->productModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
        }
        $dataHarga = $this->productPriceModel
            ->where('id_product', $produk['id_product'])
            ->where('tanggal_berakhir', null)
            ->first();

        $harga2 = [
            'tanggal_berakhir'      => date('Y-m-d H:i:s'),
        ];

        if ($this->productPriceModel->update($dataHarga['id_product_price'], $harga2)) {
            if (!$this->productPriceModel->insert($harga)) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
        }

        $stokTambah = $this->request->getPost('stok_awal');
        if (!empty($stokTambah)){
            $stok = [
                'id_product'     => $produk['id_product'],
                'id_stock'      => Uuid::uuid4()->toString(),
                'perubahan_stock'     =>  $stokTambah ?: null,
                'keterangan'       => 'Penambahan Awal',
                'tanggal'    => date('Y-m-d H:i:s'),
            ];
            if (!$this->stockModel->insert($stok)) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk');
            }
        }
    
        $gambarFiles = $this->request->getFileMultiple('gambar');

        if ($gambarFiles && is_array($gambarFiles)) {
            foreach ($gambarFiles as $file) {
                // Lewati file kosong (tanpa upload)
                if ($file->getError() === 4) {
                    continue;
                }

                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->getSize() > 2097152 || !in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                        return redirect()->back()->with('error', 'File gambar tidak valid atau melebihi 2MB.');
                    }

                    $newFileName = $id . '_' . time() . '.' . $file->getExtension();
                    $file->move(FCPATH . 'assets/img/product/', $newFileName);

                    $this->imagesProductModel->insert([
                        'id_images' => Uuid::uuid4()->toString(),
                        'id_product'        =>  $id,
                        'file'                 => $newFileName,
                        'alt'                  => $produk['nama_produk'],
                        'keterangan'           => 'Pendukung',
                    ]);
                }
            }
        }

        return redirect()->to('/admin/jasa/detail/' . $produk['id_product'])->with('message', 'Data berhasil diperbarui.');
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