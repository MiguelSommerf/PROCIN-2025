<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Documento extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_documento'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_pais'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'nome_documento'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ]
        ]);
        $this->forge->addKey('id_documento', true);
        $this->forge->addForeignKey('id_pais', 'tb_pais', 'id_pais');
        $this->forge->createTable('tb_documento');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_documento');
    }
}
