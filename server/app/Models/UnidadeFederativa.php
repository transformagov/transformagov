<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadeFederativa extends Model
{
    protected $table = "unidades_federativas";
    protected $primaryKey = "uf_id";
    protected $useAutoIncrement = true;

    public function recuperaEstados()
    {
        $estados=[array(0 => '')];
        $query = $this->findAll();
        foreach ($query as $row) {
            array_push($estados, $row['uf_nome']);
        }
        return $estados;
    }
}
