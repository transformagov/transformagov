<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Municipios extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'municipio_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'municipio_uf' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'municipio_codigo' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'municipio_nome' => [
                'type' => 'VARCHAR',
                'constraint' => '30'
            ],
            'bl_removido' => [
                'type' => 'VARCHAR',
                'constraint' => '1'
            ]
        ]);
        $this->forge->addKey('municipio_id', true);
        $this->forge->createTable('municipios');
    }

    public function down()
    {
        $this->forge->dropTable('municipios');
    }
}
