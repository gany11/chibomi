<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id_cart';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_cart',
        'id_account',
        'id_product',
        'qty',
    ];

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        if (empty($data['data']['id_cart'])) {
            $data['data']['id_cart'] = Uuid::uuid4()->toString();
        }
        return $data;
    }

    public function getCartWithProduct($idAccount)
    {
        return $this->select('
                cart.*,
                products.nama_produk,
                products.slug,
                product_price.price_unit,
                images.file AS image_file
            ')
            ->join('products', 'products.id_product = cart.id_product')
            ->join('product_price', 'product_price.id_product = products.id_product AND product_price.tanggal_berakhir IS NULL', 'left')
            ->join('images', 'images.id_product = products.id_product AND images.keterangan = "Cover"', 'left')
            ->where('cart.id_account', $idAccount)
            ->findAll();
    }

}
