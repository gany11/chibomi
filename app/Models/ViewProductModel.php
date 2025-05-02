<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ViewProductModel extends Model
{
    protected $table            = 'view_product';
    protected $primaryKey       = 'id_view_product';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_view_product',
        'id_account',
        'id_product',
        'ip_address',
        'tanggal',
    ];

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        $data['data']['id_view_product'] = Uuid::uuid4()->toString();
        return $data;
    }
}
