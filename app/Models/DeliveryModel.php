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

}
