<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePortofolioTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_portofolio' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'klien' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'tools' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => true
            ],
            'drafted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'url_proyek' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'status' => [
                'type' => "ENUM('Proses', 'Selesai')",
                'null' => false,
                'default' => 'Proses'
            ],
            'tag' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
        ]);

        $this->forge->addKey('id_portofolio', true);
        $this->forge->createTable('portofolio', true);
    }

    public function down()
    {
        $this->forge->dropTable('portofolio', true);
    }
}
