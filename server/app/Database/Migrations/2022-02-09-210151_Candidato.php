<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Candidato extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '250'
            ],
            'nome_social' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => '14'
            ],
            'rg' => [
                'type' => 'VARCHAR',
                'constraint' => '15'
            ],
            'genero' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'genero_optativo' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true
            ],
            'raca' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true
            ],
            'orgao_emissor' => [
                'type' => 'VARCHAR',
                'constraint' => '15'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '250'
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '15'
            ],
            'telefone_opcional' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true
            ],
            'linkedin' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true
            ],
            'data_nascimento' => [
                'type' => 'date',
                'null' => true
            ],
            'pais' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'cidade_estrangeira' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true
            ],
            'logradouro' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true
            ],
            'bairo' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'complemento' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
            ],
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true
            ],
            'municipio' => [
                'type' => 'INT',
                'null' => true
            ],
            'informacoes_academicas' => [
                'type' => 'MEDIUMTEXT',
                'null' => true
            ],
            'experiencia_setor_publico' => [
                'type' => 'MEDIUMTEXT',
                'null' => true
            ],
            'experiencia_profissionais' => [
                'type' => 'MEDIUMTEXT',
                'null' => true
            ],
            'atividades_voluntarias' => [
                'type' => 'MEDIUMTEXT',
                'null' => true
            ],
            'referencias_profissionais' => [
                'type' => 'MEDIUMTEXT',
                'null' => true
            ],
            'usuario_cadastro' => [
                'type' => 'INT',
                'null' => true
            ],
            'usuario_alteracao' => [
                'type' => 'INT',
                'null' => true
            ],
            'brumadinho' => [
                'type' => 'INT',
                'null' => true
            ],
            'data_cadastro' => [
                'type' => 'datetime',
            ],
        ]);
        $this->forge->addField("exigencias_comuns enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("sentenciado enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("processo_disciplinar enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("ajustamento_funcional_por_doenca enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("elegivel enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("politica_privacidade enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("bl_removido enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0'");
        $this->forge->addField("aceito_termo enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addField("aceite_privacidade enum('0','1') COLLATE utf8_bin DEFAULT NULL");
        $this->forge->addKey('id', true);
        $this->forge->createTable('candidato');
    }

    public function down()
    {
        $this->forge->dropTable('candidato');
    }
}
