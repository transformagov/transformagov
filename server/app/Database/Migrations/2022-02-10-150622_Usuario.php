<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuario extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'candidato_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ], 
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true
            ],
            'senha_temporaria' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true
            ],
            'data_cadastro' => [
                'type' => 'date',
                'null' => true
            ],
            'data_alteracao' => [
                'type' => 'date',
                'null' => true
            ],

            'ultimo_acesso' => [
                'type' => 'datetime',
                'null' => true
            ]
        ]);

        $this->forge->addField("FOREIGN KEY(candidato_id) REFERENCES candidato(id)");
        $this->forge->addField("perfil enum('candidato','avaliador','sugesp','orgaos','administrador') COLLATE utf8_bin NOT NULL");
        $this->forge->addField("troca_senha enum('0','1') COLLATE utf8_bin DEFAULT '1'");
        $this->forge->addField("erros tinyint(3) UNSIGNED NOT NULL DEFAULT 0");
        $this->forge->addField("removido enum('0','1') COLLATE utf8_bin DEFAULT '0'");
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuario');
    }

    public function down()
    {
        $this->forge->dropTable('usuario');
    }
}
