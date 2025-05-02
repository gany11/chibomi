<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class CommentPortofolioModel extends Model
{
    protected $table = 'comment_portofolio';
    protected $primaryKey = 'id_comment_portofolio';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_comment_portofolio',
        'id_portofolio',
        'komentar',
        'rating',
        'id_account'
    ];

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        $data['data']['id_comment_portofolio'] = Uuid::uuid4()->toString();
        return $data;
    }
}
