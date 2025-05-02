<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ProductSizeModel extends Model
{
    protected $table            = 'product_size';
    protected $primaryKey       = 'id_product_size';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_product_size',
        'id_product',
        'panjang_cm',
        'lebar_cm',
        'tinggi_cm',
        'berat_gram',
    ];

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        $data['data']['id_product_size'] = Uuid::uuid4()->toString();
        return $data;
    }
}
