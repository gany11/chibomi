<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ProductOrderModel extends Model
{
    protected $table            = 'product_order';
    protected $primaryKey       = 'id_product_order';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_product_order',
        'id_product',
        'id_transaksi',
        'qty',
        'total_price',
        'rating',
        'ulasan',
        'hide_at',
    ];

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        if (empty($data['data']['id_product_order'])) {
            $data['data']['id_product_order'] = Uuid::uuid4()->toString();
        }
        return $data;
    }

    public function getUlasanByProduct($id)
    {
        $db = \Config\Database::connect();

        return $db->table('product_order')
            ->select('accounts.nama, product_order.rating, product_order.ulasan')
            ->join('transaksi', 'transaksi.id_transaksi = product_order.id_transaksi')
            ->join('accounts', 'accounts.id_account = transaksi.id_account')
            ->where('product_order.id_product', $id)
            ->where('product_order.rating IS NOT NULL')
            ->where('product_order.ulasan IS NOT NULL')
            ->where('product_order.hide_at IS NULL')
            ->get()
            ->getResultArray();
    }

    public function getRataRataRating($id)
    {
        return $this->selectAvg('rating', 'avg_rating')
                    ->where('id_product', $id)
                    ->where('rating IS NOT NULL')
                    ->where('hide_at IS NULL')
                    ->first();
    }
}
