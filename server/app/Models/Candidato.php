<?php

namespace App\Models;

use CodeIgniter\Model;

class Candidato extends Model
{
    protected $table = "candidato";
    protected $primaryKey = "id";

    public function recuperaMunicipios(int $uf_id)
    {
        $municipios=[];
        $query_builder = $this;
        $query_builder->select('*');
        $query_builder->join('unidades_federativas', "unidades_federativas.uf_id=municipios.municipio_uf");
        $query_builder->where("unidades_federativas.uf_id=$uf_id");
        $uf_municipios = $query_builder->get();
        foreach ($uf_municipios->getResult() as $row) {
            array_push($municipios, $row->municipio_nome);
            echo '<option value="'.$row->municipio_id.'">'.$row->municipio_nome.'</option>';
        }
    }

    public static function opcoesDeGenero() 
    {
        return array(
            0 => '',
            1 => 'Não informado',
            2 => 'Masculino',
            3 => 'Feminino',
            4 => 'Prefiro não declarar'
        );
    }
    public static function opcoesDeRaca() 
    {
        return array(
            0 => '',
            1 => 'Não informado',
            2 => 'Amarela',
            3 => 'Branca',
            4 => 'Indígena',
            5 => 'Parda',
            6 => 'Preta',
            7 => 'Prefiro não declarar',
        );
    }
}
