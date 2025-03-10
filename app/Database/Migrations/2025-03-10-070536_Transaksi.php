<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => [
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
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Proses', 'Kirim', 'Selesai', 'Batal'],
                'default' => 'Pending',
                'null' => false
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['Barang', 'Jasa'],
                'default' => 'Barang',
                'null' => false
            ],
            'total_price_producta' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false
            ]
        ]);
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_account', 'accounts', 'id_account', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
