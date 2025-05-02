<?php

namespace App\Controllers;

use App\Models\PortofolioModel;
use App\Models\ImagesPortofolioModel;
use App\Models\ViewPortfolioModel;
use App\Models\CommentPortofolioModel;
use CodeIgniter\Controller;
use Ramsey\Uuid\Uuid;
use CodeIgniter\Config\Services;

class Portofolio extends BaseController
{
    protected $portofolioModel;
    protected $imagesPortofolioModel;
    protected $viewPortfolioModel;
    protected $commentPortofolioModel;

    public function __construct()
    {
        $this->portofolioModel = new PortofolioModel();
        $this->imagesPortofolioModel = new ImagesPortofolioModel();
        $this->viewPortfolioModel = new ViewPortfolioModel();
        $this->commentPortofolioModel = new CommentPortofolioModel();
    }

    // Portofolio
    public function indexPortofolio()
    {
        $data['portofolio'] = $this->portofolioModel->getPortofolioWithImages();

        return view('portofolio/portofolio', $data);
    }

    // Method untuk menampilkan detail portofolio
    public function indexDetailPortofolio($slug)
    {
        // Ambil data portofolio berdasarkan slug
        $portofolio = $this->portofolioModel
            ->where('slug', $slug)
            ->where('deleted_at', null)
            ->where('drafted_at', null)
            ->first();

        if (!$portofolio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $images = $this->imagesPortofolioModel
        ->where('id_portofolio', $portofolio['id_portofolio'])
        ->whereIn('keterangan', ['Cover', 'Pendukung'])
        ->orderBy('FIELD(keterangan, "Cover", "Pendukung")')
        ->findAll();

        $session = session();

        $dataview = [
            'tanggal'=> date('Y-m-d H:i:s'),
            'id_portofolio'=> $portofolio['id_portofolio'],
            'id_account'=> $session->get('id_account') ?: null,
            'ip_address'=> request()->getIPAddress(),
        ];
        $this->viewPortfolioModel->insert($dataview);

            // Ambil komentar dan nama akun
        $comments = $this->commentPortofolioModel
        ->select('comment_portofolio.*, accounts.nama')
        ->join('accounts', 'accounts.id_account = comment_portofolio.id_account', 'left')
        ->where('comment_portofolio.id_portofolio', $portofolio['id_portofolio'])
        ->limit(15)
        ->findAll();

        $imageFiles = !empty($images) ? array_column($images, 'file') : ['1.png'];

        $data = [
            'portofolio' => $portofolio,
            'images'     => $imageFiles,
            'comments'   => $comments,
            'error' => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
        ];

        return view('portofolio/portofolio-detail', $data);
    }

    public function saveUlasan()
    {
        $validation = \Config\Services::validation();

        $validationRules = [
            'rating' => 'required|in_list[1,2,3,4,5]',
            'komentar' => 'required|min_length[5]',
        ];

        $validationMessages = [
            'rating' => [
                'required'    => 'Rating wajib diisi.',
                'in_list'     => 'Rating 1-5'
            ],
            'komentar' => [
                'required'    => 'Komentar wajib diisi.',
                'min_length'  => 'Komentar minimum 5 karakter.'
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $session = session();

        $portofolio = $this->portofolioModel
            ->where('id_portofolio', $this->request->getPost('portofolio_id'))
            ->where('deleted_at', null)
            ->where('drafted_at', null)
            ->first();

        if (!$portofolio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'id_portofolio' => $this->request->getPost('portofolio_id'),
            'id_account' => $session->get('id_account'),
            'rating' => $this->request->getPost('rating'),
            'komentar' => $this->request->getPost('komentar'),
        ];

        $this->commentPortofolioModel->insert($data);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }

    public function deleteUlasan($id)
    {
        $comment = $this->commentPortofolioModel->find($id);

        if (!$comment) {
            return redirect()->back()->with('eror', 'Ulasan tidak ditemukan.');
        }

        $this->commentPortofolioModel->delete($id);

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }

    // Admin
    // Menampilkan form tambah portofolio
    public function indexFormTambahPortofolio()
    {
        return view('admin/chibomi/add-portofolio', [
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function saveFormTambahPortofolio()
    {
        $cover = $this->request->getFile('cover');
        $coverRequired = $cover && $cover->isValid();

        $validationRules = [
            'judul'           => 'required|string|max_length[255]|is_unique[portofolio.judul]',
            'kategori'        => 'permit_empty|string|max_length[255]',
            'klien'           => 'permit_empty|string|max_length[255]',
            'url_proyek'      => 'permit_empty|valid_url|max_length[255]',
            'deskripsi'       => 'required|string',
            'tag'             => 'permit_empty|string|max_length[255]',
            'tools'           => 'permit_empty|string|max_length[255]',
            'status'          => 'required|in_list[Proses,Selesai]',
            'tanggal_mulai'   => 'permit_empty|valid_date[Y-m-d]',
            'tanggal_selesai' => 'permit_empty|valid_date[Y-m-d]',
            'cover' => ($coverRequired ? 'uploaded[cover]|' : '') . 'max_size[cover,2048]|is_image[cover]|mime_in[cover,image/jpeg,image/png,image/jpg]',
        ];

        $validationMessages = [
            'judul' => [
                'required'    => 'Judul wajib diisi.',
                'string'      => 'Judul harus berupa teks.',
                'max_length'  => 'Judul maksimal 255 karakter.',
                'is_unique'   => 'Judul sudah digunakan. Harap pilih judul lain.'
            ],
            'cover' => [
                'uploaded'    => 'Cover wajib diupload.',
                'max_size'    => 'Ukuran cover maksimal 2MB.',
                'is_image'    => 'File harus berupa gambar.',
                'mime_in'     => 'Format gambar harus JPG, JPEG, PNG.'
            ],
            'kategori' => [
                'string'      => 'Kategori harus berupa teks.',
                'max_length'  => 'Kategori maksimal 255 karakter.'
            ],
            'klien' => [
                'string'      => 'Klien harus berupa teks.',
                'max_length'  => 'Klien maksimal 255 karakter.'
            ],
            'url_proyek' => [
                'valid_url'   => 'URL Proyek harus berupa URL yang valid.',
                'max_length'  => 'URL Proyek maksimal 255 karakter.'
            ],
            'deskripsi' => [
                'required'    => 'Deskripsi wajib diisi.',
                'string'      => 'Deskripsi harus berupa teks.'
            ],
            'tag' => [
                'string'      => 'Tag harus berupa teks.',
                'max_length'  => 'Tag maksimal 255 karakter.'
            ],
            'tools' => [
                'string'      => 'Tools harus berupa teks.',
                'max_length'  => 'Tools maksimal 255 karakter.'
            ],
            'status' => [
                'required'    => 'Status wajib dipilih.',
                'in_list'     => 'Status harus bernilai Proses atau Selesai.'
            ],
            'tanggal_mulai' => [
                'valid_date'  => 'Tanggal Mulai harus berupa tanggal yang valid (format Y-m-d).'
            ],
            'tanggal_selesai' => [
                'valid_date'  => 'Tanggal Selesai harus berupa tanggal yang valid (format Y-m-d).'
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('error', 'Ada kesalahan pada form.')->with('errors', $this->validator->getErrors());
        }

        $idPortofolio = Uuid::uuid4()->toString();

        $data = [
            'id_portofolio'   => $idPortofolio,
            'judul'           => $this->request->getPost('judul'),
            'slug'            => url_title($this->request->getPost('judul'), '-', true),
            'kategori'        => $this->request->getPost('kategori') ?: null,
            'klien'           => $this->request->getPost('klien') ?: null,
            'url_proyek'      => $this->request->getPost('url_proyek') ?: null,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'tag'             => $this->request->getPost('tag') ?: null,
            'tools'           => $this->request->getPost('tools') ?: null,
            'status'          => $this->request->getPost('status'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai') ?: null,
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai') ?: null,
            'drafted_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ];

        if (!$this->portofolioModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
        }

        $file = $this->request->getFile('cover');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newFileName = $idPortofolio . '_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'assets/img/portofolio/', $newFileName);

            // Save ke ImagesPortofolioModel
            $this->imagesPortofolioModel->insert([
                'id_images_portofolio' => Uuid::uuid4()->toString(),
                'id_portofolio'        => $idPortofolio,
                'file'                 => $newFileName,
                'alt'                  => $data['judul'],
                'keterangan'           => 'Cover',
            ]);
        }

        return redirect()->to('/admin/portofolio/list')->with('message', 'Portofolio berhasil ditambahkan.');
    }

    //Edit
    public function indexDetailPortofolioAdmin($id)
    {
        $portofolio = $this->portofolioModel
        ->where('id_portofolio', $id)
        ->where('deleted_at', null)
        ->first();;

        if (!$portofolio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $images = $this->imagesPortofolioModel
        ->where('id_portofolio', $portofolio['id_portofolio'])
        ->whereIn('keterangan', ['Cover', 'Pendukung'])
        ->orderBy('FIELD(keterangan, "Cover", "Pendukung")')
        ->findAll();

        $imageFiles = empty($images) ? ['1.png'] : array_column($images, 'file');

        $data = [
            'portofolio' => $portofolio,
            'images' => $imageFiles,
            'message' => session()->getFlashdata('message'),
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error')
        ];

        return view('admin/chibomi/detail-portofolio', $data);
    }

    public function saveDetailPortofolioAdmin($id)
    {
        $validationRules = [
            'kategori'        => 'permit_empty|string|max_length[255]',
            'klien'           => 'permit_empty|string|max_length[255]',
            'url_proyek'      => 'permit_empty|valid_url|max_length[255]',
            'deskripsi'       => 'required|string',
            'tag'             => 'permit_empty|string|max_length[255]',
            'tools'           => 'permit_empty|string|max_length[255]',
            'status'          => 'required|in_list[Proses,Selesai]',
            'tanggal_mulai'   => 'permit_empty|valid_date[Y-m-d]',
            'tanggal_selesai' => 'permit_empty|valid_date[Y-m-d]',
        ];
        
        $validationMessages = [
            'kategori' => [
                'string'      => 'Kategori harus berupa teks.',
                'max_length'  => 'Kategori maksimal 255 karakter.',
            ],
            'klien' => [
                'string'      => 'Klien harus berupa teks.',
                'max_length'  => 'Klien maksimal 255 karakter.',
            ],
            'url_proyek' => [
                'valid_url'   => 'URL Proyek harus berupa URL yang valid.',
                'max_length'  => 'URL Proyek maksimal 255 karakter.',
            ],
            'deskripsi' => [
                'required'    => 'Deskripsi wajib diisi.',
                'string'      => 'Deskripsi harus berupa teks.',
            ],
            'tag' => [
                'string'      => 'Tag harus berupa teks.',
                'max_length'  => 'Tag maksimal 255 karakter.',
            ],
            'tools' => [
                'string'      => 'Tools harus berupa teks.',
                'max_length'  => 'Tools maksimal 255 karakter.',
            ],
            'status' => [
                'required'    => 'Status wajib dipilih.',
                'in_list'     => 'Status harus bernilai Proses atau Selesai.',
            ],
            'tanggal_mulai' => [
                'valid_date'  => 'Tanggal Mulai harus berupa tanggal yang valid (format Y-m-d).',
            ],
            'tanggal_selesai' => [
                'valid_date'  => 'Tanggal Selesai harus berupa tanggal yang valid (format Y-m-d).',
            ],
        ];   

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', 'Ada kesalahan pada form.')->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'kategori'        => $this->request->getPost('kategori') ?: null,
            'klien'           => $this->request->getPost('klien') ?: null,
            'url_proyek'      => $this->request->getPost('url_proyek') ?: null,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'tag'             => $this->request->getPost('tag') ?: null,
            'tools'           => $this->request->getPost('tools') ?: null,
            'status'          => $this->request->getPost('status'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai') ?: null,
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai') ?: null
        ];
    
        $portofolio = $this->portofolioModel
            ->where('id_portofolio', $id)
            ->where('deleted_at', null)
            ->first();
    
        if (!$portofolio) {
            return redirect()->to('/admin/portofolio/list')->with('error', 'Data portofolio tidak ditemukan');
        }

        if (!$this->portofolioModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
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
                    $file->move(FCPATH . 'assets/img/portofolio/', $newFileName);

                    $this->imagesPortofolioModel->insert([
                        'id_images_portofolio' => Uuid::uuid4()->toString(),
                        'id_portofolio'        => $id,
                        'file'                 => $newFileName,
                        'alt'                  => $portofolio['judul'],
                        'keterangan'           => 'Pendukung',
                    ]);
                }
            }
        }

        return redirect()->to('/admin/portofolio/detail/' . $id)->with('message', 'Portofolio berhasil diperbarui.');
    }

    // Menampilkan daftar portofolio
    public function indexListPortofolio()
    {
        $data['portofolio'] = $this->portofolioModel
        ->where('deleted_at', null)
        ->findAll();

        return view('admin/chibomi/list-portofolio', $data);
    }

    // Fungsi untuk mengarsipkan portofolio
    public function archive()
    {
        $id = $this->request->getVar('id_portofolio');

        // Validasi id
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID portofolio tidak valid']);
        }

        $data = [
            'drafted_at' => date('Y-m-d H:i:s')
        ];

        $update = $this->portofolioModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'message' => 'Portofolio berhasil diarsipkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengarsipkan portofolio']);
        }
    }

    // Fungsi untuk memulihkan portofolio
    public function restore()
    {
        $id = $this->request->getVar('id_portofolio');

        // Validasi id
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID portofolio tidak valid']);
        }

        // Perbarui status portofolio dan hapus timestamp draft_at
        $data = [
            'drafted_at' => null
        ];

        $update = $this->portofolioModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'message' => 'Portofolio berhasil dipulihkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memulihkan portofolio']);
        }
    }

    // Fungsi untuk menghapus portofolio (soft delete)
    public function delete()
    {
        $id = $this->request->getVar('id_portofolio');

        // Validasi id
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID portofolio tidak valid']);
        }

        // Tambahkan timestamp deleted_at untuk soft delete
        $data = [
            'deleted_at' => date('Y-m-d H:i:s')
        ];

        $update = $this->portofolioModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'message' => 'Portofolio berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus portofolio']);
        }
    }
}