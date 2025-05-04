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

    public function getRecommendedPortofolio($idAccount = null)
    {
        if ($idAccount) {
            // Subquery berdasarkan aktivitas user (akun atau IP)
            $builder = $this->db->table('view_portfolio vp')
                ->select('vp.id_portofolio')
                ->where('vp.id_account', $idAccount)
                ->orderBy('vp.tanggal', 'DESC')
                ->limit(4);

            $subQuery = $builder->getCompiledSelect();

            return $this->select('portofolio.judul, portofolio.slug, ip.file')
                ->join('view_portfolio vp2', 'vp2.id_portofolio = portofolio.id_portofolio')
                ->join('images_portofolio ip', 'ip.id_portofolio = portofolio.id_portofolio AND ip.keterangan = "Cover"', 'left')
                ->where("vp2.id_portofolio IN (
                    SELECT id_portofolio FROM ($subQuery) AS recent_views
                )")
                ->where('portofolio.deleted_at', null)
                ->where('portofolio.drafted_at', null)
                ->groupBy('portofolio.id_portofolio')
                ->limit(4)
                ->findAll();
        } else {
            // Rekomendasi universal: portofolio dengan view terbanyak
            return $this->select('
                    portofolio.judul,
                    portofolio.slug,
                    ip.file,
                    COUNT(vp.id_portofolio) AS total_view
                ')
                ->join('view_portfolio vp', 'vp.id_portofolio = portofolio.id_portofolio', 'left')
                ->join('images_portofolio ip', 'ip.id_portofolio = portofolio.id_portofolio AND ip.keterangan = "Cover"', 'left')
                ->where('portofolio.deleted_at', null)
                ->where('portofolio.drafted_at', null)
                ->groupBy('portofolio.id_portofolio')
                ->orderBy('total_view', 'DESC')
                ->limit(4)
                ->findAll();
        }
    }

}
