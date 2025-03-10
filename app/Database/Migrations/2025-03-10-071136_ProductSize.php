<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductSize extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_product_size' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null'       => false
            ],
            'id_product' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => false
            ],
            'panjang_cm' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false
            ],
            'lebar_cm' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false
            ],
            'tinggi_cm' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false
            ],
            'berat_gram' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false
            ]
        ]);
        
        $this->forge->addKey('id_product_size', true);
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_size');
    }

    public function down()
    {
        $this->forge->dropTable('product_size');
    }
}
