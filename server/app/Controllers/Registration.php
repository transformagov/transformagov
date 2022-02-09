<?php

namespace App\Controllers;

class Registration extends BaseController
{
    public function index()
    {
        helper('form');
        helper('html');
        $db = \Config\Database::connect();
        //$unidadesFederativasModel = model('UnidadesFederativasModel');
        $estados=[array(0 => '')];
        $estados_query = $db->table('unidades_federativas')->get();
        foreach ($estados_query->getResult() as $row) {
            array_push($estados, $row->uf_nome);
        }
        $data = [
            'erro' => '',
            'sucesso' => '',
            'url' => 'cadastro',
            'Estados' => $estados,
        ];
        echo view('generics/cabeçalho_publico', $data);
        echo view('registration', $data);
        echo view('generics/rodape_publico', $data);
    }

    public function recupera_municipios($uf_id) {
        $municipios=[];
        $db = \Config\Database::connect();
        $query_builder = $db->table('municipios');
        $query_builder->select('*');
        $query_builder->join('unidades_federativas', "unidades_federativas.uf_id=municipios.municipio_uf");
        $query_builder->where("unidades_federativas.uf_id=$uf_id");
        $uf_municipios = $query_builder->get();
        echo '<option value=""></option>';
        foreach ($uf_municipios->getResult() as $row) {
            array_push($municipios, $row->municipio_nome);
            echo '<option value="'.$row->municipio_id.'">'.$row->municipio_nome.'</option>';
        }
    }

    public function new()
    {

    }
}
