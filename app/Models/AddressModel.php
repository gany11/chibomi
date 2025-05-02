<?php
namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'id_address';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_address', 'id_account', 'nama_penerima', 'telp_penerima',
        'alamat_lengkap', 'provinsi', 'kota_kabupaten', 'kecamatan',
        'kelurahan', 'kode_pos'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $skipValidation = false;

    protected $validationRules = [
        'id_account'      => 'required',
        'nama_penerima'   => 'required|string|max_length[255]',
        'telp_penerima'   => 'required|regex_match[/^[0-9]{10,20}$/]',
        'alamat_lengkap'  => 'required|string',
        'provinsi'        => 'required|string|max_length[255]',
        'kota_kabupaten'  => 'required|string|max_length[255]',
        'kecamatan'       => 'required|string|max_length[255]',
        'kelurahan'       => 'required|string|max_length[255]',
        'kode_pos'        => 'required|regex_match[/^[0-9]{5}$/]',
    ];

    protected $validationMessages = [
        'id_account' => [
            'required' => 'Akun wajib disertakan.',
            'exists'   => 'Akun tidak ditemukan.',
        ],
        'nama_penerima' => [
            'required' => 'Nama penerima wajib diisi.',
            'max_length' => 'Nama penerima tidak boleh lebih dari 255 karakter.',
        ],
        'telp_penerima' => [
            'required' => 'Nomor telepon penerima wajib diisi.',
            'regex_match' => 'Nomor telepon harus berupa angka (10-20 digit).',
        ],
        'alamat_lengkap' => [
            'required' => 'Alamat lengkap wajib diisi.',
        ],
        'provinsi' => [
            'required' => 'Provinsi wajib diisi.',
            'max_length' => 'Nama provinsi tidak boleh lebih dari 255 karakter.',
        ],
        'kota_kabupaten' => [
            'required' => 'Kota/Kabupaten wajib diisi.',
            'max_length' => 'Nama kota/kabupaten tidak boleh lebih dari 255 karakter.',
        ],
        'kecamatan' => [
            'required' => 'Kecamatan wajib diisi.',
            'max_length' => 'Nama kecamatan tidak boleh lebih dari 255 karakter.',
        ],
        'kelurahan' => [
            'required' => 'Kelurahan wajib diisi.',
            'max_length' => 'Nama kelurahan tidak boleh lebih dari 255 karakter.',
        ],
        'kode_pos' => [
            'required' => 'Kode pos wajib diisi.',
            'regex_match' => 'Kode pos harus terdiri dari 5 angka.',
        ],
    ];  
    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        $data['data']['id_address'] = Uuid::uuid4()->toString();

        $accountId = $data['data']['id_account'] ?? null;
        if ($accountId) {
            $count = $this->where('id_account', $accountId)->countAllResults();
            if ($count >= 3) {
                throw new \RuntimeException('Setiap akun hanya dapat memiliki maksimal 3 alamat.');
            }
        }

        return $data;
    }
}
