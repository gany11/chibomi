<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImagesPortofolioTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_images_portofolio' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null'       => false,
            ],
            'id_portofolio' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'alt' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'keterangan' => [
                'type'       => 'ENUM',
                'constraint' => ['Cover', 'Pendukung'],
                'default'    => 'Pendukung',
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id_images_portofolio', true);
        $this->forge->addForeignKey('id_portofolio', 'portofolio', 'id_portofolio', 'CASCADE', 'CASCADE');
        $this->forge->createTable('images_portofolio');
    }

    public function down()
    {
        $this->forge->dropTable('images_portofolio');
    }
}
