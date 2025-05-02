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

}
