<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ViewProduct extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_view_product' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => FALSE
            ],
            'id_account' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => TRUE
            ],
            'id_product' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => FALSE
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'tanggal' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
        ]);

        $this->forge->addKey('id_view_product', TRUE);
        $this->forge->addForeignKey('id_account', 'accounts', 'id_account', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('view_product');
    }

    public function down()
    {
        $this->forge->dropTable('view_product');
    }
}