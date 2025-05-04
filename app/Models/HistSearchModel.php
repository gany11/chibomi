<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class HistSearchModel extends Model
{
    protected $table      = 'hist_search';
    protected $primaryKey = 'id_hist_search';
    protected $allowedFields = ['id_hist_search', 'id_account', 'tanggal', 'search'];
    protected $useTimestamps = false;

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        $data['data']['id_hist_search'] = Uuid::uuid4()->toString();
        return $data;
    }
}
