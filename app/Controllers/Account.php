<?php

namespace App\Controllers;

use App\Models\AccountModel;
use CodeIgniter\Controller;
use App\Libraries\EmailService;
use Ramsey\Uuid\Uuid;

class Account extends BaseController
{
    protected $accountModel;
    protected $emailService;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->emailService = new EmailService();
    }

    // Register Pengguna
    public function indexRegister()
    {
        return view('account/registrasi', [
                'errors' => session()->getFlashdata('errors'),
                'error' => session()->getFlashdata('error'),
            ]);
    }

    public function register()
    {
        $postData = $this->request->getPost();

        // Validasi dulu data mentah
        if (!$this->accountModel->validate($postData)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->accountModel->errors())
                ->with('error', 'Registrasi gagal. Silakan coba lagi dengan ketentuan yang berlaku.');
        }

        // Data yang akan disimpan
        $data = [
            'email' => htmlspecialchars($postData['email']),
            'nama' => htmlspecialchars($postData['nama']),
            'telepon' => htmlspecialchars($postData['telepon']),
            'password' => password_hash($postData['password'], PASSWORD_DEFAULT),
            'status_akun' => 'EmailVerif',
            'role' => 'Pelanggan',
        ];
        $data['id_account'] = Uuid::uuid4()->toString();

        // Kirim email verifikasi sebelum insert
        $email = \Config\Services::email();
        $email->setTo($data['email']);
        $email->setSubject('Verifikasi Akun Anda');
        $email->setMailType('html');

        $verificationLink = base_url("verifikasi/" . md5($data['email']));
        $message = "
            <p>Halo <b>{$data['nama']}</b>,</p>
            <p>Terima kasih telah mendaftar. Klik tombol berikut untuk verifikasi akun Anda:</p>
            <p><a href='{$verificationLink}' style='padding:10px 20px; background-color:#FFB200; color:white; text-decoration:none;'>Verifikasi Akun</a></p>
            <p>Atau salin link ini ke browser:</p>
            <p>{$verificationLink}</p>
            <p><i>Terima kasih</i></p>
        ";
        $email->setMessage($message);

        $user = $this->accountModel->where('email', $data['email'])->first();

        if ($user) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        if (!$this->accountModel->insert($data)) {
            $errors = $this->accountModel->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . implode(', ', $errors));
        }

        if (!$email->send()) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi.');
        }

        return redirect()->to('/login')->with('message', 'Registrasi berhasil. Cek email Anda untuk verifikasi.');
    }

    // Register Admin
    public function indexRegisterAdmin()
    {
        return view('auth/register_admin');
    }

    public function registerAdmin()
    {
        $data = $this->request->getPost();

        if (!$this->validate([
            'email' => 'required|valid_email|is_unique[accounts.email]',
            'nama' => 'required|string|max_length[255]',
            'telepon' => 'required|regex_match[/^[0-9]{10,20}$/]',
            'password' => 'required|min_length[8]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = array_map('htmlspecialchars', $data);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['status_akun'] = 'Aktif';
        $data['role'] = 'Admin';
        
        $this->accountModel->insert($data);
        return redirect()->to('/login')->with('message', 'Admin berhasil didaftarkan.');
    }

    // Verifikasi Email
    public function verifyEmail($token)
    {
        // Ambil model akun
        $account = $this->accountModel
            ->where('MD5(email)', $token)
            ->first();

        if (!$account) {
            // Email tidak ditemukan (token tidak valid)
            return redirect()->to('/login')->with('error', 'Link verifikasi tidak valid atau akun tidak ditemukan.');
        }

        if ($account['status_akun'] !== 'EmailVerif') {
            // Sudah diverifikasi atau status bukan EmailVerif
            return redirect()->to('/login')->with('error', 'Akun sudah diverifikasi atau tidak perlu verifikasi.');
        }

        // Update status_akun jadi Aktif
        $this->accountModel->update($account['id_account'], ['status_akun' => 'Aktif']);

        return redirect()->to('/login')->with('message', 'Verifikasi berhasil! Silakan login.');
    }

    // Login
    public function indexLogin()
    {
        return view('account/login', [
                'errors' => session()->getFlashdata('errors'),
                'error'  => session()->getFlashdata('error'),
                'message' => session()->getFlashdata('message'),
            ]);
    }

    public function login()
    {
        $data = $this->request->getPost();

        if (!$this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ], ['email' => [
                'required'     => 'Email wajib diisi.',
                'valid_email'  => 'Format email tidak valid.',
            ],
            'password' => [
                'required'     => 'Password wajib diisi.',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }        

        $user = $this->accountModel->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        // Cek status akun
        if ($user['status_akun'] === 'EmailVerif') {
            return redirect()->back()->withInput()->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
        }

        if ($user['status_akun'] === 'Blokir') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda diblokir.');
        }

        if ($user['status_akun'] !== 'Aktif') {
            return redirect()->back()->withInput()->with('error', 'Status akun tidak valid.');
        }

        session()->set([
            'id_account' => $user['id_account'],
            'email'      => $user['email'],
            'nama'       => $user['nama'],
            'role'       => $user['role'],
            'telepon'    => $user['telepon'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/');
    }

    //Logout
    public function logout()
    {   
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('/login');
    }

    // Profil
    public function indexProfil()
    {
        return view('account/profil');
    }

    public function updateProfil()
    {
        $validation = \Config\Services::validation();
        $accountModel = new \App\Models\AccountModel();

        $userId = session()->get('id_account');
        $user = $accountModel->find($userId);

        $input = $this->request->getPost();

        // Aturan validasi awal
        $rules = [
            'nama' => 'required|min_length[3]',
            'telepon' => 'required|numeric|min_length[10]',
            'email' => 'required|valid_email',
        ];

        // Jika email berubah, validasi keunikan
        if ($input['email'] !== $user['email']) {
            $rules['email'] .= '|is_unique[accounts.email]';
        }

        // Jika password diisi, tambahkan validasi password
        if (!empty($input['password']) || !empty($input['password_lama'])) {
            $rules['password_lama'] = 'required';
            $rules['password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        // Pesan error dalam Bahasa Indonesia
        $validation->setRules($rules, [
            'nama' => [
                'required' => 'Nama wajib diisi.',
                'min_length' => 'Nama minimal 3 karakter.'
            ],
            'telepon' => [
                'required' => 'Telepon wajib diisi.',
                'numeric' => 'Telepon harus berupa angka.',
                'min_length' => 'Telepon minimal 10 digit.'
            ],
            'email' => [
                'required' => 'Email wajib diisi.',
                'valid_email' => 'Email tidak valid.',
                'is_unique' => 'Email sudah digunakan.'
            ],
            'password_lama' => [
                'required' => 'Password lama wajib diisi.'
            ],
            'password' => [
                'required' => 'Password baru wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.'
            ],
            'confirm_password' => [
                'matches' => 'Konfirmasi password tidak cocok.'
            ],
        ]);

        // Jalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors())->with('error', 'Profil gagal diperbarui. Silakan coba lagi dengan ketentuan yang berlaku.');
        }

        // Siapkan data yang akan diupdate
        $updateData = [];

        if ($input['nama'] !== $user['nama']) {
            $updateData['nama'] = $input['nama'];
        }

        if ($input['telepon'] !== $user['telepon']) {
            $updateData['telepon'] = $input['telepon'];
        }

        // Email berubah → perlu verifikasi ulang
        if ($input['email'] !== $user['email']) {
            $updateData['email'] = $input['email'];
            $updateData['status'] = 'Emailverif';

            // Kirim email verifikasi
            $email = \Config\Services::email();
            $email->setTo($input['email']);
            $email->setSubject('Verifikasi Akun Anda');
            $email->setMailType('html');

            $link = base_url("verifikasi/" . md5($input['email']));
            $message = "
                <p>Halo <b>{$input['nama']}</b>,</p>
                <p>Klik tombol berikut untuk verifikasi akun Anda:</p>
                <p><a href='{$link}' style='padding:10px 20px; background-color:#FFB200; color:white;'>Verifikasi Akun</a></p>
                <p>Atau salin link ini: <br> {$link}</p>
            ";
            $email->setMessage($message);
            $email->send();

            $accountModel->update($userId, $updateData);

            // Hancurkan session dan minta login ulang
            session()->destroy();
            return redirect()->to('/login')->with('success', 'Email diubah, silakan verifikasi ulang melalui email.');
        }

        // Ubah password jika diisi
        if (!empty($input['password'])) {
            // Cek password lama
            if (!password_verify($input['password_lama'], $user['password'])) {
                return redirect()->back()->withInput()->with('errors', [
                    'password_lama' => ['Password lama salah.']
                ]);
            }

            $updateData['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        }

        // Jika tidak ada perubahan, beri pesan
        if (empty($updateData)) {
            return redirect()->back()->withInput()->with('errors', [
                'form' => ['Tidak ada perubahan yang disimpan.']
            ]);
        }

        // Simpan perubahan
        $accountModel->update($userId, $updateData);

        // Perbarui session
        $newData = $accountModel->find($userId);
        session()->set([
            'id_account' => $newData['id_account'],
            'email'      => $newData['email'],
            'nama'       => $newData['nama'],
            'role'       => $newData['role'],
            'telepon'    => $newData['telepon'],
            'isLoggedIn' => true,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // Lamat Pengguna
    public function indexAlamat()
    {
        return view('account/alamat');
    }
}
