<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocumentoVendedor extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_documento_vendedor' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'id_vendedor'           => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'id_documento'          => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'documento_vendedor'     => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ]
        ]);
        $this->forge->addKey('id_documento_vendedor', true);
        $this->forge->addForeignKey('id_vendedor', 'tb_vendedor', 'id_vendedor');
        $this->forge->addForeignKey('id_documento', 'tb_documento', 'id_documento');
        $this->forge->createTable('tb_documento_vendedor');
    }

    public function down(): void
    {
        $this->forge->dropTable('tb_documento_vendedor');
    }
}
