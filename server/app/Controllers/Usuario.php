<?php

namespace App\Controllers;

class Usuario extends BaseController
{
    public function index() 
    {
        helper('html');
        echo view('generics/cabecalho_usuario');
        echo view('usuario/interna');
        echo view('generics/rodape_usuario');
    }


    public function logout() {
        $session = session();
        unset($session);
        return redirect()->to('/');
    }
}
