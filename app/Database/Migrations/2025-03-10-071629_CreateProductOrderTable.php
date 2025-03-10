<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_product_order' => [
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
            'id_transaksi' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'qty' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'total_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'rating' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'ulasan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'hide_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_product_order', true);
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_order');
    }

    public function down()
    {
        $this->forge->dropTable('product_order');
    }
}
