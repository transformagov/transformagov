<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model
{
    protected $table = "usuario";
    protected $primaryKey = "id";
    protected $allowedFields = [
        "nome",
        "cpf",
        "email",
        "telefone",
        "senha_temporaria",
        "candidato_id",
        "data_cadastro",
        "perfil",
    ];

    const PERFIS = [
        "candidato" => "Candidato",
        "avaliador" => "Avaliador",
        "sugesp" => "Gestor SEPLAG",
        "orgaos" => "Gestor Outros Órgãos",
        "administrador" => "Administrador",
    ];

    const MENUS = [
        'candidato' => 'candidato/menu'
    ];
}
