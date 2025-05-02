<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentPortofolioTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_comment_portofolio' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unique'     => true,
                'null' => false
            ],
            'id_portofolio' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false
            ],
            'komentar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'rating' => [
                'type' => 'INT',
                'null' => true,
                'constraint' => 1
            ],
            'id_account' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false
            ]
        ]);

        $this->forge->addKey('id_comment_portofolio', true);
        $this->forge->addForeignKey('id_portofolio', 'portofolio', 'id_portofolio', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_account', 'accounts', 'id_account', 'CASCADE', 'CASCADE');
        $this->forge->createTable('comment_portofolio', true);
    }

    public function down()
    {
        $this->forge->dropTable('comment_portofolio', true);
    }
}
