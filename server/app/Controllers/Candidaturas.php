<?php

namespace App\Controllers;

class Candidaturas extends BaseController
{
    public function index()
    {
        helper('html');
        echo view('generics/cabecalho_usuario');
        echo view('candidaturas/candidaturas');
        echo view('generics/rodape_usuario');
    }

    public function agendamentos()
    {
        helper('html');
        echo view('generics/cabecalho_usuario');
        echo view('candidaturas/agendamentos');
        echo view('generics/rodape_usuario');
    }
}
