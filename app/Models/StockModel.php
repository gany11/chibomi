<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table      = 'stock';
    protected $primaryKey = 'id_stock';

    protected $useAutoIncrement = false;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Fields that can be mass assigned
    protected $allowedFields = [
        'id_stock',
        'id_product',
        'perubahan_stock',
        'tanggal',
        'keterangan'
    ];
}
