<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stock extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_stock' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'id_product' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false
            ],
            'perubahan_stock' => [
                'type' => 'INT',
                'null' => false
            ],
            'tanggal' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
        ]);
        
        $this->forge->addKey('id_stock', true);
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stock');
    }

    public function down()
    {
        $this->forge->dropTable('stock');
    }
}
