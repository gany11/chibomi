<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_images' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null'       => false,
            ],
            'id_product' => [
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

        $this->forge->addKey('id_images', true);
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->createTable('images');
    }

    public function down()
    {
        $this->forge->dropTable('images');
    }
}
