<?php

namespace App\Controllers;

class Publico extends BaseController
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
        echo view('login', $data);
        echo view('generics/rodape_publico', $data);
    }

    public function realiza_login()
    {
        helper('sessao_usuario');
        $db = \Config\Database::connect();
        $builder = $db->table("candidato");
        $session = session();
        if(usuario_logado($session)) {
            echo view('candidato/interna');
        } else {

        }
    }
}
