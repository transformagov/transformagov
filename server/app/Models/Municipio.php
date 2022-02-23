<?php

namespace App\Models;

use CodeIgniter\Model;

class Municipio extends Model
{
    protected $table = "municipios";
    protected $primaryKey = "municipio_id";

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
}
