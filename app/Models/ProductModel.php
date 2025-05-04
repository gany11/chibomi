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

    public function getRecommendedProducts($idAccount = null)
    {
        if ($idAccount) {
            // Ambil produk yang baru dilihat oleh user dengan akun
            $builder = $this->db->table('view_product vp')
                ->select('vp.id_product')
                ->where('vp.id_account', $idAccount)
                ->orderBy('vp.tanggal', 'DESC')
                ->limit(5);

            $subQuery = $builder->getCompiledSelect();

            return $this->select('
                            products.nama_produk,
                            products.slug,
                            products.jenis,
                            pp.price_unit,
                            i.file AS image_file,
                            AVG(po.rating) AS avg_rating
                        ')
                ->join('view_product vp2', 'vp2.id_product = products.id_product')
                ->join('images i', 'i.id_product = products.id_product AND i.keterangan = "Cover"', 'left')
                ->join('product_price pp', 'pp.id_product = products.id_product AND pp.tanggal_berakhir IS NULL', 'left')
                ->join('product_order po', 'po.id_product = products.id_product AND po.hide_at IS NULL', 'left')
                ->where("vp2.id_account IN (
                    SELECT DISTINCT id_account FROM ($subQuery) AS recent_views WHERE id_account IS NOT NULL
                )")
                ->where('products.deleted_at', null)
                ->where('products.drafted_at', null)
                ->groupBy('products.id_product')
                ->limit(4)
                ->findAll();
        } else {
            // Rekomendasi universal berdasarkan produk terlaris atau terbaru
            return $this->select('
                            products.nama_produk,
                            products.slug,
                            products.jenis,
                            pp.price_unit,
                            i.file AS image_file,
                            AVG(po.rating) AS avg_rating
                        ')
                ->join('images i', 'i.id_product = products.id_product AND i.keterangan = "Cover"', 'left')
                ->join('product_price pp', 'pp.id_product = products.id_product AND pp.tanggal_berakhir IS NULL', 'left')
                ->join('product_order po', 'po.id_product = products.id_product AND po.hide_at IS NULL', 'left')
                ->where('products.deleted_at', null)
                ->where('products.drafted_at', null)
                ->groupBy('products.id_product')
                ->orderBy('AVG(po.rating)', 'DESC') // Atau bisa diganti dengan jumlah penjualan jika ada
                ->limit(4)
                ->findAll();
        }
    }

    public function searchProductWithImagesHargaRating($keyword)
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
                ->groupStart()
                    ->like('products.kategori', $keyword)
                    ->orLike('products.nama_produk', $keyword)
                    ->orLike('products.deskripsi', $keyword)
                    ->orLike('products.tag', $keyword)
                ->groupEnd()
                ->groupBy('products.id_product')
                ->findAll();
    }

}
