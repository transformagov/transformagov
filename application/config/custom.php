<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['email']=isset($_SERVER['ENV_CONTACT_EMAIL']) ? $_SERVER['ENV_CONTACT_EMAIL'] : 'test@mail.com';
$config['administrador']=isset($_SERVER['ENV_ADMIN_EMAIL']) ? $_SERVER['ENV_ADMIN_EMAIL'] : 'test@mail.com'; 

$config['nome']='Transforma Gov';
$config['subTituloPlataforma'] = "Programa de Gestão de Pessoas por Mérito e Competência";
