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
        $estados= [];
        $query = $db->table('unidades_federativas')->get();
        foreach ($query->getResult() as $row) {
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

    public function new()
    {

    }
}
