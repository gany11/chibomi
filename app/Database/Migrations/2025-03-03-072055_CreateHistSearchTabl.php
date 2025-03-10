<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHistSearchTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hist_search' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'id_account' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false
            ],
            'tanggal' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            'search' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            // 'created_at' => [
            //     'type' => 'DATETIME',
            //     'null' => false,
            //     'default' => 'CURRENT_TIMESTAMP'
            // ],
            // 'updated_at' => [
            //     'type' => 'DATETIME',
            //     'null' => true,
            //     'on update' => 'CURRENT_TIMESTAMP'
            // ]
        ]);

        $this->forge->addKey('id_hist_search', true);
        $this->forge->addForeignKey('id_account', 'accounts', 'id_account', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hist_search', true);
    }

    public function down()
    {
        $this->forge->dropTable('hist_search', true);
    }
}
