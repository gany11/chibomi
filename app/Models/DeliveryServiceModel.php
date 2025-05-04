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
    protected $useTimestamps    = false;

    // Validasi rules
    protected $validationRules = [
        'nama' => 'required|max_length[255]',
        'kode' => 'required|max_length[255]|in_list[jne,sicepat,ide,sap,jnt,ninja,tiki,lion,anteraja,pos,ncs,rex,rpx,sentral,star,wahana,dse]|is_unique[delivery_service.kode]',
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
            'in_list'    => 'Kode kurir tidak valid.',
            'is_unique'  => 'Kode kurir sudah digunakan.',
        ],
    ];
}
