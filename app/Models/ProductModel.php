<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id_product';
    protected $useAutoIncrement = false;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_product',
        'jenis',
        'kategori',
        'nama_produk',
        'deskripsi',
        'tag',
        'slug',
        'deleted_at',
        'drafted_at'
    ];

    public function getProductWithImagesHargaRating()
{
    return $this->select('
                products.nama_produk,
                products.jenis,
                products.slug,
                product_price.price_unit,
                images.file AS image_file,
                AVG(product_order.rating) AS avg_rating
            ')
            ->join('images', 'images.id_product = products.id_product AND images.keterangan = "Cover"', 'left')
            ->join('product_price', 'product_price.id_product = products.id_product AND product_price.tanggal_berakhir IS NULL', 'left')
            ->join('product_order', 'product_order.id_product = products.id_product AND product_order.hide_at IS NULL', 'left')
            ->where('products.deleted_at', null)
            ->where('products.drafted_at', null)
            ->groupBy('products.id_product')
            ->findAll();
}

}
