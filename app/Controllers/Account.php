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
        return view('master/header')
            . view('account/registrasi', [
                'errors' => session()->getFlashdata('errors'),
                'error' => session()->getFlashdata('error'),
            ])
            . view('master/footer');
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
        return view('master/header')
            . view('account/login', [
                'errors' => session()->getFlashdata('errors'),
                'error'  => session()->getFlashdata('error'),
                'message' => session()->getFlashdata('message'),
            ])
            . view('master/footer');
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
}
