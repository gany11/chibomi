<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDeliveryServiceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_delivery_service' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Pasif'],
                'null' => false,
                'default' => 'Aktif'
            ]
        ]);

        $this->forge->addKey('id_delivery_service', true);
        $this->forge->createTable('delivery_service', true);
    }

    public function down()
    {
        $this->forge->dropTable('delivery_service', true);
    }
}
