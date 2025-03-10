<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_account' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'unique' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'status_akun' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Blokir', 'EmailVerif'],
                'null' => false,
                'default' => 'EmailVerif'
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'foto_profil' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Pemilik', 'Admin', 'Pelanggan'],
                'null' => false,
                'default' => 'Pelanggan'
            ],
            'password' => [
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

        $this->forge->addKey('id_account', true);
        $this->forge->createTable('accounts', true);
    }

    public function down()
    {
        $this->forge->dropTable('accounts', true);
    }
}