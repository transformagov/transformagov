<?php

define("TEMPLATES_PATH", APPPATH . "helpers/templates");


function getEmailEnvConfigs()
{
    $config = array(
        'charset' => $_SERVER['ENV_CHARSET'],
        'wordwrap' => $_SERVER['ENV_WORDWRAP'],
        'mailtype' => $_SERVER['ENV_MAILTYPE'],
        'smtp_host' => $_SERVER['ENV_SMTP_HOST'],
        'smtp_port' => $_SERVER['ENV_SMTP_PORT'],
        'smtp_user' => $_SERVER['ENV_SMTP_USER'],
        'smtp_pass' => $_SERVER['ENV_SMTP_PASS'],
        'protocol' => $_SERVER['ENV_PROTOCOL'],
        'smtp_auth' => $_SERVER['ENV_SMTP_AUTH'],
        'smtp_crypto' => $_SERVER['ENV_SMTP_CRYPTO'],
    );

    return $config;
}


function loadCadastroHtml($titulo, $subTitulo, $nomeCompleto, $senha, $cpf)
{
    $file_path = TEMPLATES_PATH . "/cadastro.html";
    $file = fopen(TEMPLATES_PATH . "/cadastro.html", "r");
    $template = fread($file, filesize($file_path));
    fclose($file);

    $data = array(
        ":titulo" => $titulo,
        ":subTitulo" => $subTitulo,
        ":nomeCompleto" => $nomeCompleto,
        ":cpf" => $cpf,
        ":senha" => $senha,
        ":urlBase" => base_url(""),
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}

function loadCadastroIndeferidoHtml($titulo, $subTitulo, $nomeCompleto)
{
    $file_path = TEMPLATES_PATH . "/cadastroIndeferido.html";
    $file = fopen(TEMPLATES_PATH . "/cadastroIndeferido.html", "r");
    $template = fread($file, filesize($file_path));
    fclose($file);

    $data = array(
        ":titulo" => $titulo,
        ":subTitulo" => $subTitulo,
        ":nomeCompleto" => $nomeCompleto,
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}

function loadAlteracaoDeSenhaHtml($titulo, $subTitulo, $nomeUsuario, $login, $senha)
{
    $file_path = TEMPLATES_PATH . "/alteracaoDeSenha.html";
    $file = fopen(TEMPLATES_PATH . "/alteracaoDeSenha.html", "r");
    $template = fread($file, filesize($file_path));
    fclose($file);

    $data = array(
        ":titulo" => $titulo,
        ":subTitulo" => $subTitulo,
        ":nomeUsuario" => $nomeUsuario,
        ":login" => $login,
        ":cpf" => $senha,
        ":urlBase" => base_url(""),
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}


function loadCandidaturaIndeferidaHtml($genero, $nome, $vaga)
{
    $file_path = TEMPLATES_PATH . "/candidaturaIndeferida.html";
    $file = fopen(TEMPLATES_PATH . "/candidaturaIndeferida.html", "r");
    $template = fread($file, filesize($file_path));
    fclose($file);

    $data = array(
        ":generoCheck" => $genero == 2 ? "Cara" : "Caro",
        ":nome" => $nome,
        ":vaga" => $vaga,
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}


function loadTestHtml()
{
    $file_path = TEMPLATES_PATH . "/test.html";
    $file = fopen(TEMPLATES_PATH . "/test.html", "r");
    $template = fread($file, filesize($file_path));
    fclose($file);

    return $template;
}
