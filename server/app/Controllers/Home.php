<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'erro' => '',
            'sucesso' => ''
        ];
        helper('form');
        helper('html');
        echo view('generics/cabeçalho_publico', $data);
        echo view('home', $data);
        echo view('generics/rodape_publico', $data);
    }

    public function login()
    {

    }
}
