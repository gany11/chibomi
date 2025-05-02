<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ImagesPortofolioModel extends Model
{
    protected $table = 'images_portofolio';
    protected $primaryKey = 'id_images_portofolio';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_images_portofolio',
        'id_portofolio',
        'file',
        'alt',
        'keterangan'
    ];
}