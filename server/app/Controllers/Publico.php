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
        helper('sessao');
        $session = session();
        if(usuarioLogado($session)) {
            return redirect()->to('/usuario');
        } else {
            $cpf = $this->request->getPost("cpf");
            $senha = $this->request->getPost("senha");
            $db = \Config\Database::connect();
            $query = $db->table("usuario")->getWhere(['cpf' => $cpf, 'senha_temporaria' => $senha]);
            $queryResult = $query->getResult();
            if (count($queryResult)) {
                $usuarioLogado = $queryResult[0];
                atualizaSesssao($session, $usuarioLogado);
                return redirect()->to('/usuario');
            } else {
                echo "USUARIO NÃO EXISTE";
            }
        }
    }
}
