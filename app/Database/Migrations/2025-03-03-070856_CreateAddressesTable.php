<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_address' => [
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
            'nama_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'telp_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'alamat_lengkap' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'kota_kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'kode_pos' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => false
            ],
        ]);

        $this->forge->addKey('id_address', true);
        $this->forge->addForeignKey('id_account', 'accounts', 'id_account', 'CASCADE', 'CASCADE');
        $this->forge->createTable('addresses', true);
    }

    public function down()
    {
        $this->forge->dropTable('addresses', true);
    }
}