<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ProductPriceModel extends Model
{
    protected $table = 'product_price';
    protected $primaryKey = 'id_product_price';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_product_price',
        'id_product',
        'tanggal_awal',
        'tanggal_berakhir',
        'modal',
        'price_unit',
    ];
}
