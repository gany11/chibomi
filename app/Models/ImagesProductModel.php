<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ImagesProductModel extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id_images';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_images',
        'id_product',
        'file',
        'alt',
        'keterangan'
    ];
}