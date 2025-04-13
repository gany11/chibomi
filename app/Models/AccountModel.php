<?php
namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class AccountModel extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'id_account';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id_account', 'email', 'nama', 'status_akun', 'telepon', 'foto_profil', 'role', 'password'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $skipValidation = true;

    // Validasi otomatis di Model
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[accounts.email]',
        'nama' => 'required|string|max_length[255]',
        'telepon' => 'required|regex_match[/^[0-9]{10,20}$/]',
        'password' => 'required|min_length[8]',
        'confirm_password' => 'required|matches[password]',
    ];

    // Pesan error khusus
    protected $validationMessages = [
        'email' => [
            'required' => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email sudah terdaftar.',
        ],
        'nama' => [
            'required' => 'Nama wajib diisi.',
        ],
        'telepon' => [
            'required' => 'Nomor telepon wajib diisi.',
            'regex_match' => 'Format nomor telepon tidak valid.',
        ],
        'password' => [
            'required' => 'Password wajib diisi.',
            'min_length' => 'Password minimal 8 karakter.',
        ],
        'confirm_password' => [
            'required' => 'Konfirmasi password wajib diisi.',
            'matches' => 'Konfirmasi password tidak cocok.',
        ],
    ];

    protected function beforeInsert(array $data)
    {
        if (!isset($data['data']['id_account'])) {
            $data['data']['id_account'] = Uuid::uuid4()->toString();
        }
        return $data;
    }
    
    public function getAccountByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

}