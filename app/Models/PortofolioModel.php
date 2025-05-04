<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PortofolioModel extends Model
{
    protected $table = 'portofolio';
    protected $primaryKey = 'id_portofolio';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'id_portofolio', 'deskripsi', 'klien', 'kategori', 'tools',
        'slug', 'tanggal_selesai', 'tanggal_mulai', 'drafted_at', 'deleted_at',
        'judul', 'url_proyek', 'status', 'tag'
    ];
    
    protected $useTimestamps = false;
    protected $createdField = ''; 
    protected $updatedField = '';
    protected $deletedField = 'deleted_at';

    public function getPortofolioWithImages()
    {
        return $this->select('portofolio.judul, portofolio.slug, images_portofolio.file')
                    ->join('images_portofolio', 'images_portofolio.id_portofolio = portofolio.id_portofolio AND images_portofolio.keterangan = "Cover"', 'left')
                    ->where('portofolio.deleted_at', null)
                    ->where('portofolio.drafted_at', null)
                    ->findAll();
    }

    public function searchPortofolioWithImages($keyword)
    {
        return $this->select('portofolio.judul, portofolio.slug, images_portofolio.file')
                    ->join('images_portofolio', 'images_portofolio.id_portofolio = portofolio.id_portofolio AND images_portofolio.keterangan = "Cover"', 'left')
                    ->where('portofolio.deleted_at', null)
                    ->where('portofolio.drafted_at', null)
                    ->groupStart()
                        ->like('portofolio.deskripsi', $keyword)
                        ->orLike('portofolio.klien', $keyword)
                        ->orLike('portofolio.kategori', $keyword)
                        ->orLike('portofolio.tools', $keyword)
                        ->orLike('portofolio.judul', $keyword)
                        ->orLike('portofolio.url_proyek', $keyword)
                        ->orLike('portofolio.status', $keyword)
                        ->orLike('portofolio.tag', $keyword)
                    ->groupEnd()
                    ->findAll();
    }

    public function getRecommendedPortofolio($idAccount = null, $ip = null)
    {
        $builder = $this->db->table('view_portfolio vp')
            ->select('vp.id_portofolio')
            ->orderBy('vp.tanggal', 'DESC')
            ->limit(4);

        if ($idAccount) {
            $builder->where('vp.id_account', $idAccount);
        } elseif ($ip) {
            $builder->where('vp.ip_address', $ip);
        }

        $subQuery = $builder->getCompiledSelect();

        return $this->select('portofolio.judul, portofolio.slug, ip.file')
            ->join('view_portfolio vp2', 'vp2.id_portofolio = portofolio.id_portofolio')
            ->join('images_portofolio ip', 'ip.id_portofolio = portofolio.id_portofolio AND ip.keterangan = "Cover"', 'left')
            ->where("vp2.id_account IN (
                SELECT DISTINCT id_account FROM ($subQuery) AS recent_views WHERE id_account IS NOT NULL
            )")
            ->where('portofolio.deleted_at', null)
            ->where('portofolio.drafted_at', null)
            ->groupBy('portofolio.id_portofolio')
            ->limit(4)
            ->findAll();
    }

}
