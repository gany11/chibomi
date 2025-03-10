<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenJasaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dokumen_jasa' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null'       => false,
            ],
            'id_transaksi' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'url_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_dokumen_jasa', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dokumen_jasa');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_jasa');
    }
}
