<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryModel extends Model
{
    protected $table            = 'pengiriman';
    protected $primaryKey       = 'id_pengiriman';
    protected $allowedFields    = [
        'id_pengiriman',
        'id_delivery_service',
        'id_transaksi',
        'nama_tujuan',
        'telepon',
        'alamat',
        'shipping_cost',
        'resi',
    ];
    protected $useTimestamps    = false;

    // Validasi rules
    protected $validationRules = [
        'id_pengiriman'        => 'required|is_unique[pengiriman.id_pengiriman]|max_length[36]',
        'id_delivery_service'  => 'required|max_length[36]',
        'id_transaksi'         => 'required|max_length[36]',
        'nama_tujuan'          => 'required|max_length[255]',
        'telepon'              => 'required|max_length[20]',
        'alamat'               => 'required',
        'shipping_cost'        => 'required|decimal',
        'resi'                 => 'permit_empty|max_length[255]',
    ];

    // Pesan custom untuk validasi
    protected $validationMessages = [
        'id_pengiriman' => [
            'required'   => 'ID Pengiriman wajib diisi.',
            'is_unique'  => 'ID Pengiriman sudah digunakan.',
            'max_length' => 'ID Pengiriman maksimal 36 karakter.',
        ],
        'id_delivery_service' => [
            'required'   => 'ID Delivery Service wajib diisi.',
            'max_length' => 'ID Delivery Service maksimal 36 karakter.',
        ],
        'id_transaksi' => [
            'required'   => 'ID Transaksi wajib diisi.',
            'max_length' => 'ID Transaksi maksimal 36 karakter.',
        ],
        'nama_tujuan' => [
            'required'   => 'Nama tujuan wajib diisi.',
            'max_length' => 'Nama tujuan maksimal 255 karakter.',
        ],
        'telepon' => [
            'required'   => 'Telepon wajib diisi.',
            'max_length' => 'Telepon maksimal 20 karakter.',
        ],
        'alamat' => [
            'required' => 'Alamat wajib diisi.',
        ],
        'shipping_cost' => [
            'required' => 'Biaya pengiriman wajib diisi.',
            'decimal'  => 'Biaya pengiriman harus berupa angka desimal.',
        ],
        'resi' => [
            'max_length' => 'Nomor resi maksimal 255 karakter.',
        ],
    ];
}
