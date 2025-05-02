<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ViewPortfolioModel extends Model
{
    protected $table      = 'view_portfolio';
    protected $primaryKey = 'id_view_portfolio';

    protected $useAutoIncrement = false;

    // Fields that can be mass assigned
    protected $allowedFields = [
        'id_view_portfolio',
        'tanggal',
        'id_portofolio',
        'id_account',
        'ip_address'
    ];

    protected $beforeInsert = ['generateUUID'];

    // Fungsi untuk membuat UUID sebelum insert
    protected function generateUUID(array $data)
    {
        $data['data']['id_view_portfolio'] = Uuid::uuid4()->toString();
        return $data;
    }
}