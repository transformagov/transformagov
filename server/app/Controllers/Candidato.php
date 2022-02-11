<?php

namespace App\Controllers;

class Candidato extends BaseController
{
    public function index()
    {
        helper('form');
        helper('html');
        $db = \Config\Database::connect();
        $estados=[array(0 => '')];
        $estados_query = $db->table('unidades_federativas')->get();
        foreach ($estados_query->getResult() as $row) {
            array_push($estados, $row->uf_nome);
        }
        $data = [
            'erro' => '',
            'sucesso' => '',
            'url' => '/candidato/cadastrar',
            'Estados' => $estados,
        ];
        echo view('generics/cabeçalho_publico', $data);
        echo view('candidato/cadastro', $data);
        echo view('generics/rodape_publico', $data);
    }

    public function recupera_municipios($uf_id)
    {
        $municipios=[];
        $db = \Config\Database::connect();
        $query_builder = $db->table('municipios');
        $query_builder->select('*');
        $query_builder->join('unidades_federativas', "unidades_federativas.uf_id=municipios.municipio_uf");
        $query_builder->where("unidades_federativas.uf_id=$uf_id");
        $uf_municipios = $query_builder->get();
        echo '<option value=""></option>';
        foreach ($uf_municipios->getResult() as $row) {
            array_push($municipios, $row->municipio_nome);
            echo '<option value="'.$row->municipio_id.'">'.$row->municipio_nome.'</option>';
        }
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
