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
        return view('home', $data);
    }
}
