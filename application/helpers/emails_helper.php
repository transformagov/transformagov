<?php

define("TEMPLATES_PATH", APPPATH . "helpers/templates");


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
        ":cpf" => $senha,
        ":senha" => $cpf,
        ":urlBase" => base_url(""),
        ":urlContato" => base_url("Publico/contato")
    );

    return strtr($template, $data);
}
