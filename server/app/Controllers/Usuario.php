<?php

namespace App\Controllers;

class Usuario extends BaseController
{
    public function index() 
    {
        helper('html');
        helper('sessao');
        $session = session();
        $data = array( 'sessao' => $session);
        echo view('generics/cabecalho_usuario', $data);
        echo view('usuario/interna');
        echo view('generics/rodape_usuario');
    }


    public function logout() {
        $session = session();
        unset($session);
        return redirect()->to('/');
    }
}
