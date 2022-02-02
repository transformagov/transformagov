<?php

namespace App\Controllers;

class Registration extends BaseController
{
    public function index()
    {
        $data = [
            'erro' => '',
            'sucesso' => '',
            'url' => 'cadastro'
        ];
        helper('form');
        helper('html');
        echo view('generics/cabeçalho_publico', $data);
        echo view('registration', $data);
        echo view('generics/rodape_publico', $data);
    }

    public function new()
    {

    }
}
