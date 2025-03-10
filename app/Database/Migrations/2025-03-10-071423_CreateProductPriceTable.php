<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductPriceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_product_price' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false,
            ],
            'id_product' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false,
            ],
            'tanggal_awal' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'tanggal_berakhir' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'modal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
            ],
            'price_unit' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id_product_price', true);
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_price');
    }

    public function down()
    {
        $this->forge->dropTable('product_price');
    }
}
