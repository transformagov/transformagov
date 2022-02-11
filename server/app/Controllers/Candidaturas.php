<?php

namespace App\Controllers;

class Candidaturas extends BaseController
{
    public function index()
    {
        helper('html');
        helper('sessao');
        $session = session();
        $data = array( 'sessao' => $session);
        echo view('generics/cabecalho_usuario', $data);
        echo view('candidaturas/candidaturas');
        echo view('generics/rodape_usuario');
    }

    public function agendamentos()
    {
        helper('html');
        helper('sessao');
        $session = session();
        $data = array( 'sessao' => $session);
        echo view('generics/cabecalho_usuario', $data);
        echo view('candidaturas/agendamentos');
        echo view('generics/rodape_usuario');
    }
}
