<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocumentoUsuario extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_documento_usuario' => [
                'type'             => 'INT',
                'constraint'       => 11,
                'unsigned'         => true,
                'auto_increment'   => true
            ],
            'id_documento'         => [
                'type'             => 'INT',
                'constraint'       => 11,
                'unsigned'         => true
            ],
            'id_usuario'           => [
                'type'             => 'INT',
                'constraint'       => 11,
                'unsigned'         => true
            ],
            'documento_usuario'    => [
                'type'             => 'VARCHAR',
                'constraint'       => 255
            ]
        ]);
        $this->forge->addKey('id_documento_usuario', true);
        $this->forge->addForeignKey('id_documento', 'tb_documento', 'id_documento');
        $this->forge->addForeignKey('id_usuario', 'tb_usuario', 'id_usuario');
        $this->forge->createTable('tb_documento_usuario');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_documento_usuario');
    }
}
