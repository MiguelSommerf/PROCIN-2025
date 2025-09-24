<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocumentoLoja extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_documento_loja'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_documento'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'id_loja'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'documento_loja'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ]
        ]);
        $this->forge->addKey('id_documento_loja', true);
        $this->forge->addForeignKey('id_documento', 'tb_documento', 'id_documento');
        $this->forge->addForeignKey('id_loja', 'tb_loja', 'id_loja');
        $this->forge->createTable('tb_documento_loja');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_documento_loja');
    }
}
