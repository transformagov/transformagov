<?php

define("TEMPLATES_PATH", APPPATH . "helpers/email_templates");


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

function readTemplateFile(string $fileName) {
    $file_path = TEMPLATES_PATH . "/" . $fileName;

    $file = fopen($file_path, "r");
    $template = fread($file, filesize($file_path));
    fclose($file);

    return $template;
}


function loadCadastroHtml($titulo, $subTitulo, $nomeCompleto, $senha, $cpf)
{
    $template = readTemplateFile("cadastro.html");

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
    $template = readTemplateFile("cadastroIndeferido.html");

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
    $template = readTemplateFile("alteracaoDeSenha.html");

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
    $template = readTemplateFile("candidaturaIndeferida.html");

    $data = array(
        ":generoCheck" => $genero == 2 ? "Cara" : "Caro",
        ":nome" => $nome,
        ":vaga" => $vaga,
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}


function loadAguardandoDecisaoFinalHtml($genero, $nome)
{
    $template = readTemplateFile("aguardandoDecisaoFinal.html");

    $data = array(
        ":generoCheck" => $genero == 2 ? "Cara" : "Caro",
        ":nome" => $nome,
        ":urlBase" => base_url(""),
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}


function loadCandidaturaHabilitadaCurriculoAvaliadoHtml($titulo, $subTitulo, $genero, $nome, $vaga)
{
    $template = readTemplateFile("candidaturaHabilitadaCurriculoAvaliado.html");

    $data = array(
        ":titulo" => $titulo,
        ":subTitulo" => $subTitulo,
        ":generoCheck" => $genero == 2 ? "Cara" : "Caro",
        ":nome" => $nome,
        ":vaga" => $vaga,
        ":urlBase" => base_url(""),
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}


function loadTestHtml()
{
    $template = readTemplateFile("test.html");

    return $template;
}
