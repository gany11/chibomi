<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class DokumenJasaModel extends Model
{
    protected $table            = 'dokumen_jasa';
    protected $primaryKey       = 'id_dokumen_jasa';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_dokumen_jasa',
        'id_transaksi',
        'url_dokumen',
    ];

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        $data['data']['id_dokumen_jasa'] = Uuid::uuid4()->toString();
        return $data;
    }
}
