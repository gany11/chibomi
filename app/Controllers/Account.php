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

        $validationRules = [
            'email'            => 'required|valid_email|is_unique[accounts.email]',
            'nama'             => 'required|string|max_length[255]',
            'telepon'          => 'required|regex_match[/^[0-9]{10,20}$/]',
            'password'         => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        $validationMessages = [
            'email' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique'   => 'Email sudah terdaftar.',
            ],
            'nama' => [
                'required' => 'Nama wajib diisi.',
            ],
            'telepon' => [
                'required'     => 'Nomor telepon wajib diisi.',
                'regex_match'  => 'Format nomor telepon tidak valid.',
            ],
            'password' => [
                'required'    => 'Password wajib diisi.',
                'min_length'  => 'Password minimal 8 karakter.',
            ],
            'confirm_password' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Registrasi gagal. Silakan periksa kembali data yang diisi.');
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

    // Verifikasi Email
    public function verifyEmail($token)
    {
        // Ambil model akun
        $account = $this->accountModel
            ->where('MD5(email)', $token)
            ->first();

        if (!$account) {
            return redirect()->to('/login')->with('error', 'Link verifikasi tidak valid atau akun tidak ditemukan.');
        }

        if ($account['status_akun'] !== 'EmailVerif') {
            return view('account/verifikasi');
        }

        $this->accountModel->update($account['id_account'], ['status_akun' => 'Aktif']);

        return view('account/verifikasi');
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
            return redirect()->back()->withInput()->with('error', 'Tidak ada perubahan yang disimpan.');
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
    
    // Profil Admin
    public function indexProfilAdmin()
    {
        return view('admin/chibomi/profil');
    }

    // Daftar List Akun
    public function indexListAkun()
    {
        $users = $this->accountModel->findAll();

        return view('admin/chibomi/list-akun', [
            'users' => $users,
        ]);
    }

    // Register Admin
    public function indexRegistrasiAdmin()
    {
        return view('admin/chibomi/add-akun', [
            'errors' => session()->getFlashdata('errors')
        ]);
    }

    public function saveRegistrasiAdmin()
    {
        $postData = $this->request->getPost();

        $validationRules = [
            'email' => 'required|valid_email|is_unique[accounts.email]',
            'nama' => 'required|string|max_length[255]',
            'telepon' => 'required|regex_match[/^[0-9]{10,20}$/]',
        ];

        $validationMessages = [
            'email' => [
                'required' => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email sudah terdaftar.',
            ],
            'nama' => [
                'required' => 'Nama wajib diisi.',
                'string' => 'Nama hanya boleh berisi karakter.',
                'max_length' => 'Nama maksimal 255 karakter.',
            ],
            'telepon' => [
                'required' => 'Nomor telepon wajib diisi.',
                'regex_match' => 'Format nomor telepon tidak valid.',
            ],
        ];

        // Jalankan validasi
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Registrasi gagal. Silakan coba lagi dengan ketentuan yang berlaku.');
        }

        $data = [
            'email' => htmlspecialchars($postData['email']),
            'nama' => htmlspecialchars($postData['nama']),
            'telepon' => htmlspecialchars($postData['telepon']),
            'status_akun' => 'EmailVerif',
            'role' => 'Admin',
        ];
        $data['id_account'] = Uuid::uuid4()->toString();

        $password = bin2hex(random_bytes(8)); 
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);

        $email = \Config\Services::email();
        $email->setTo($data['email']);
        $email->setSubject('Akun Admin Anda');
        $email->setMailType('html');

        // Membuat link verifikasi
        $verificationLink = base_url("verifikasi/" . md5($data['email']));
        $message = "
            <p>Halo <b>{$data['nama']}</b>,</p>
            <p>Terima kasih telah mendaftar sebagai Admin. Berikut adalah detail akun Anda:</p>
            <p>Email: {$data['email']}</p>
            <p>Password: {$password}</p>
            <p>Silakan klik tautan di bawah untuk memverifikasi akun Anda:</p>
            <p><a href='{$verificationLink}' style='padding:10px 20px; background-color:#FFB200; color:white; text-decoration:none;'>Verifikasi Akun</a></p>
            <p>Atau salin link ini ke browser:</p>
            <p>{$verificationLink}</p>
            <p><i>Terima kasih</i></p>
        ";
        $email->setMessage($message);

        // Simpan data akun
        if (!$this->accountModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        }

        // Kirim email verifikasi
        if (!$email->send()) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi.');
        }

        return redirect()->to('/admin/akun/list')->with('message', 'Registrasi Admin berhasil.');
    }

    public function changeStatus()
    {
        $postData = $this->request->getJSON();
        $idAccount = $postData->id_account;
        $action = $postData->action;

        // Only allow Pemilik to perform these actions
        if (session()->get('role') !== 'Pemilik') {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda Tidak Diizinkan']);
        }

        $user = $this->accountModel->find($idAccount);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Tidak Tersedia!']);
        }

        // Change status
        if ($action === 'blokir') {
            $user['status_akun'] = 'Blokir';
        } elseif ($action === 'aktifkan') {
            $user['status_akun'] = 'Aktif';
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Aksi Gagal!']);
        }

        // Update the user status
        if ($this->accountModel->save($user)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status Berhasil Diubah!']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Status Gagal Diubah!']);
    }

    public function sendVerification()
    {
        $postData = $this->request->getJSON();
        $idAccount = $postData->id_account;

        $user = $this->accountModel->find($idAccount);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Tidak Tersedia!']);
        }

        // Kirim email verifikasi
        $email = \Config\Services::email();
        $email->setTo($user['email']);
        $email->setSubject('Verifikasi Akun Anda');
        $email->setMailType('html');

        $verificationLink = base_url("verifikasi/" . md5($user['email']));
        $message = "
            <p>Halo <b>{$user['nama']}</b>,</p>
            <p>Terima kasih telah mendaftar. Klik tombol berikut untuk verifikasi akun Anda:</p>
            <p><a href='{$verificationLink}' style='padding:10px 20px; background-color:#FFB200; color:white; text-decoration:none;'>Verifikasi Akun</a></p>
            <p>Atau salin link ini ke browser:</p>
            <p>{$verificationLink}</p>
            <p><i>Terima kasih</i></p>
        ";
        $email->setMessage($message);

        // Mengirim email
        if ($email->send()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Email Verifikasi Berhasil Terkirim!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim email verifikasi.']);
        }
    }

    public function indexLupaPassword()
    {
        return view('account/lupa-password', [
            'errors' => session()->getFlashdata('errors')
        ]);
    }

    public function saveLupaPassword()
    {
        $postData = $this->request->getPost();

        $validationRules = [
            'email' => 'required|valid_email'
        ];

        $validationMessages = [
            'email' => [
                'required' => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.'
            ]
        ];

        // Jalankan validasi
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Reset Password gagal. Silakan coba lagi dengan ketentuan yang berlaku.');
        }

        $email = $postData['email'];
        $account = $this->accountModel->where('email', $email)->first();

        if (!$account) {
            return redirect()->back()->with('error', 'Akun dengan email tersebut tidak ditemukan.');
        }

        // Generate password baru
        $newPassword = bin2hex(random_bytes(8));
        $account['password'] = password_hash($newPassword, PASSWORD_DEFAULT);

        // Simpan password baru ke dalam database
        if (!$this->accountModel->save($account)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data password baru.');
        }

        // Kirim email dengan password baru
        $emailService = \Config\Services::email();
        $emailService->setTo($account['email']);
        $emailService->setSubject('Reset Password Akun');
        $emailService->setMailType('html');

        $message = "
            <p>Halo <b>{$account['nama']}</b>,</p>
            <p>Berikut adalah password baru untuk akun Anda:</p>
            <p>Email: {$account['email']}</p>
            <p>Password: {$newPassword}</p>
            <p>Silakan login dengan password baru tersebut dan segera lakukan ubah password pada halaman profil.</p>
            <p><i>Terima kasih</i></p>
        ";
        $emailService->setMessage($message);

        // Kirim email
        if (!$emailService->send()) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim email dengan password baru.');
        }

        // Berhasil
        return redirect()->to('/login')->with('message', 'Password baru telah dikirim ke email Anda.');
    }

}
