<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnidadesFederativas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'uf_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'uf_sigla' => [
                'type' => 'VARCHAR',
                'constraint'=> '2',
            ],
            'uf_nome' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ]
        ]);
        $this->forge->addKey('uf_id', true);
        $this->forge->createTable('unidades_federativas');
    }

    public function down()
    {
        $this->forge->dropTable('unidades_federativas');
    }
}


