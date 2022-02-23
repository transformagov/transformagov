<?php

namespace App\Controllers;

class Usuario extends BaseController
{
    public function index() 
    {
        helper('html');
        helper('sessao');
        echo view('generics/cabecalho_usuario');
        echo view('usuario/interna');
        echo view('generics/rodape_usuario');
    }


    public function logout() {
        helper('sessao');
        $session = session();
        limpaSesssao($session);
        return redirect()->to('/');
    }
}
