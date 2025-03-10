<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_product' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['Barang', 'Jasa'],
                'default' => 'Barang',
                'null' => false
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'tag' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'drafted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_product', true);
        $this->forge->createTable('products', true);
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}