<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryServiceModel extends Model
{
    protected $table            = 'delivery_service';
    protected $primaryKey       = 'id_delivery_service';
    protected $allowedFields    = [
        'id_delivery_service',
        'nama',
        'kode',
        'status',
    ];
    protected $useTimestamps    = false; // karena kamu belum aktifkan created_at / updated_at

    // Validasi rules
    protected $validationRules = [
        'nama'                => 'required|max_length[255]',
        'kode'                => 'required|max_length[255]',
    ];

    // Pesan error custom
    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama wajib diisi.',
            'max_length' => 'Nama maksimal 255 karakter.',
        ],
        'kode' => [
            'required'   => 'Kode wajib diisi.',
            'max_length' => 'Kode maksimal 255 karakter.',
        ],
    ];
}
