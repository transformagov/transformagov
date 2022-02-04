<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnidadesFederativasSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            array('uf_id' => 1, 'uf_sigla' => 'AC', 'uf_nome' => 'Acre'),
            array('uf_id' => 2, 'uf_sigla' => 'AL', 'uf_nome' => 'Alagoas'),
            array('uf_id' => 3, 'uf_sigla' => 'AM', 'uf_nome' => 'Amazonas'),
            array('uf_id' => 4, 'uf_sigla' => 'AP', 'uf_nome' => 'Amapá'),
            array('uf_id' => 5, 'uf_sigla' => 'BA', 'uf_nome' => 'Bahia'),
            array('uf_id' => 6, 'uf_sigla' => 'CE', 'uf_nome' => 'Ceará'),
            array('uf_id' => 7, 'uf_sigla' => 'DF', 'uf_nome' => 'Distrito Federal'),
            array('uf_id' => 8, 'uf_sigla' => 'ES', 'uf_nome' => 'Espírito Santo'),
            array('uf_id' => 9, 'uf_sigla' => 'GO', 'uf_nome' => 'Goiás'),
            array('uf_id' => 10, 'uf_sigla' => 'MA', 'uf_nome' => 'Maranhão'),
            array('uf_id' => 11, 'uf_sigla' => 'MG', 'uf_nome' => 'Minas Gerais'),
            array('uf_id' => 12, 'uf_sigla' => 'MS', 'uf_nome' => 'Mato Grosso do Sul'),
            array('uf_id' => 13, 'uf_sigla' => 'MT', 'uf_nome' => 'Mato Grosso'),
            array('uf_id' => 14, 'uf_sigla' => 'PA', 'uf_nome' => 'Pará'),
            array('uf_id' => 15, 'uf_sigla' => 'PB', 'uf_nome' => 'Paraíba'),
            array('uf_id' => 16, 'uf_sigla' => 'PE', 'uf_nome' => 'Pernambuco'),
            array('uf_id' => 17, 'uf_sigla' => 'PI', 'uf_nome' => 'Piauí'),
            array('uf_id' => 18, 'uf_sigla' => 'PR', 'uf_nome' => 'Paraná'),
            array('uf_id' => 19, 'uf_sigla' => 'RJ', 'uf_nome' => 'Rio de Janeiro'),
            array('uf_id' => 20, 'uf_sigla' => 'RN', 'uf_nome' => 'Rio Grande do Norte'),
            array('uf_id' => 21, 'uf_sigla' => 'RO', 'uf_nome' => 'Rondônia'),
            array('uf_id' => 22, 'uf_sigla' => 'RR', 'uf_nome' => 'Roraima'),
            array('uf_id' => 23, 'uf_sigla' => 'RS', 'uf_nome' => 'Rio Grande do Sul'),
            array('uf_id' => 24, 'uf_sigla' => 'SC', 'uf_nome' => 'Santa Catarina'),
            array('uf_id' => 25, 'uf_sigla' => 'SE', 'uf_nome' => 'Sergipe'),
            array('uf_id' => 26, 'uf_sigla' => 'SP', 'uf_nome' => 'São Paulo'),
            array('uf_id' => 27, 'uf_sigla' => 'TO', 'uf_nome' => 'Tocantins'),
        );
        foreach ($data as $uf) {
            $this->db->table('unidades_federativas')->insert($uf);
        }
    }
}


