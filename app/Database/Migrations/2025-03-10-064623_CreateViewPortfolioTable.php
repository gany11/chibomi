<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViewPortfolioTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_view_portfolio' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'tanggal' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            'id_portofolio' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false
            ],
            'id_account' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => true
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_view_portfolio', true);
        $this->forge->addForeignKey('id_portofolio', 'portofolio', 'id_portofolio', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_account', 'accounts', 'id_account', 'SET NULL', 'CASCADE');
        $this->forge->createTable('view_portfolio', true);
    }

    public function down()
    {
        $this->forge->dropTable('view_portfolio', true);
    }
}
