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
        $candidato = new \App\Models\Candidato();
        $data = [
            'erro' => '',
            'sucesso' => '',
            'url' => '/candidato/cadastrar',
            'Estados' => $estados,
            'candidato' => $candidato,
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
        $dadosDoCandidato = array(
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
        $candidato = new \App\Models\Candidato();
        $candidato->save($dadosDoCandidato);
        return redirect()->to("/");
    }
}
