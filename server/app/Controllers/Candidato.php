<?php

namespace App\Controllers;

class Candidato extends BaseController
{
    public function index()
    {
        helper('form');
        helper('html');
        $unidadeFederativa =  new \App\Models\UnidadeFederativa();
        $estados = $unidadeFederativa->recuperaEstados();
        $data = [
            'erro' => '',
            'sucesso' => '',
            'url' => '/candidato/cadastrar',
            'Estados' => $estados,
            'candidato' => new \App\Models\Candidato()
        ];
        echo view('generics/cabeçalho_publico', $data);
        echo view('candidato/cadastro', $data);
        echo view('generics/rodape_publico', $data);
    }

    public function recupera_municipios($uf_id)
    {
        echo '<option value=""></option>';
        $municipio = new \App\Models\Municipio();
        return $municipio->recuperaMunicipios($uf_id);
    }

    public function cadastrar()
    {
        $candidato_data = array(
            "nome" => $this->request->getPost("nome"),
            "cpf" => $this->request->getPost("cpf"),
            "rg" => $this->request->getPost("rg"),
            "orgao_emissor" => $this->request->getPost("orgao_emissor"),
            "genero" => $this->request->getPost("genero"),
            "genero_optativo" => "",
            "raca" => $this->request->getPost("raca"),
            "email" => $this->request->getPost("email"),
            "telefone" => $this->request->getPost("telefone"),
            "data_nascimento" => $this->request->getPost("data_nascimento"),
            "cep" => $this->request->getPost("cep"),
            "logradouro" => $this->request->getPost("logradouro"),
            "numero" => $this->request->getPost("numero"),
            "municipio" => $this->request->getPost("municipio"),
            "exigencias_comuns" => $this->request->getPost("exigencias_comuns"),
            "sentenciado" => $this->request->getPost("sentenciado"),
            "processo_disciplinar" => $this->request->getPost("processo_disciplinar"),
            "ajustamento_funcional_por_doenca" => $this->request->getPost("ajustamento_funcional_por_doenca"),
            "aceito_termo" => $this->request->getPost("aceito_termo"),
            "data_cadastro" => date("Y-m-d H:i:s"),
        );
        $db = \Config\Database::connect();
        $db->table("candidato")->insert($candidato_data);
        $candidato_id = $db->insertID();
        $usuario_data = array(
            "nome" => $this->request->getPost("nome"),
            "cpf" => $this->request->getPost("cpf"),
            "email" => $this->request->getPost("email"),
            "telefone" => $this->request->getPost("telefone"),
            "senha_temporaria" => '123456',
            "candidato_id" => $candidato_id,
            "data_cadastro"=> date("Y-m-d H:i:s"),
            "perfil" => "candidato"
        );
        $db->table("usuario")->insert($usuario_data);
        redirect()->to("/");
    }
}
