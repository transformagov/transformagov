<?php

namespace App\Models;

use CodeIgniter\Model;

class Candidato extends Model
{
    protected $table = "candidato";
    protected $primaryKey = "id";
    protected $afterInsert = ["criaUsuario"];
    protected $allowedFields = [
        "nome",
        "cpf",
        "rg",
        "orgao_emissor",
        "genero",
        "genero_optativo",
        "raca",
        "email",
        "telefone",
        "data_nascimento",
        "cep",
        "logradouro",
        "numero",
        "municipio",
        "exigencias_comuns",
        "sentenciado",
        "processo_disciplinar",
        "ajustamento_funcional_por_doenca",
        "aceito_termo",
        "data_cadastro",
    ];

    public function recuperaMunicipios(int $uf_id)
    {
        $municipios = [];
        $query_builder = $this;
        $query_builder->select("*");
        $query_builder->join(
            "unidades_federativas",
            "unidades_federativas.uf_id=municipios.municipio_uf"
        );
        $query_builder->where("unidades_federativas.uf_id=$uf_id");
        $uf_municipios = $query_builder->get();
        foreach ($uf_municipios->getResult() as $row) {
            array_push($municipios, $row->municipio_nome);
            echo '<option value="' . $row->municipio_id . '">' . $row->municipio_nome . "</option>";
        }
    }

    public static function opcoesDeGenero()
    {
        return [
            0 => "",
            1 => "Não informado",
            2 => "Masculino",
            3 => "Feminino",
            4 => "Prefiro não declarar",
        ];
    }
    public static function opcoesDeRaca()
    {
        return [
            0 => "",
            1 => "Não informado",
            2 => "Amarela",
            3 => "Branca",
            4 => "Indígena",
            5 => "Parda",
            6 => "Preta",
            7 => "Prefiro não declarar",
        ];
    }

    protected function criaUsuario(array $data)
    {
        if (!isset($data["data"])) {
            return $data;
        }
        $usuario = new \App\Models\Usuario();
        $dadosCandidato = $data["data"];
        $dadosUsuario = [
            "nome" => $dadosCandidato['nome'],
            "cpf" => $dadosCandidato['cpf'],
            "email" => $dadosCandidato['email'],
            "telefone" => $dadosCandidato['telefone'],
            "senha_temporaria" => "123456",
            "candidato_id" => $data["id"],
            "data_cadastro" => date("Y-m-d H:i:s"),
            "perfil" => "candidato",
        ];
        $usuario->save($dadosUsuario);
    }
}
