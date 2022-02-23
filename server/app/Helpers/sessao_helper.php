<?php

function usuarioLogado($session)
{
	return $session->get("cpf") != "" and
		$session->get("nome") != "" and
		$session->get("loggedIn") == true;
}

function atualizaSesssao($session, $usuarioLogado)
{
	$session->set([
		"cpf" => $usuarioLogado['cpf'],
		"nome" => $usuarioLogado['nome'],
		"perfil" => $usuarioLogado['perfil'],
		"loggedIn" => true,
	]);
}

function limpaSesssao($session)
{
		$session->remove('nome');
		$session->remove('loggedIn');
		$session->remove('cpf');
}

function formataNomeDoUsuario($session) {
	$primeironome = "";
	$ultimonome = "";
	if (strlen($session->nome) > 0) {
		$nome = explode(" ", $session->nome);
		$primeironome = $nome[0];
		$ultimonome = $nome[count($nome) - 1];
		if (strlen($primeironome) + strlen($ultimonome) > 30) {
			$ultimonome = substr($ultimonome, 0, 1) . ".";
		}
	}
	return $primeironome . " " . $ultimonome;
}

function recuperaPerfilDoUsuario($session)
{
  $tiposDePerfil = \App\Models\Usuario::PERFIS;
	$perfil = "";
	if (in_array($session->perfil, array_keys($tiposDePerfil))) {
		$perfil = $tiposDePerfil[$session->perfil];
	}
	return $perfil;
}

function menuDoPerfil($session)
{
  $tiposDeMenu = \App\Models\Usuario::MENUS;
	try {
		return $tiposDeMenu[$session->perfil];
	} catch (Exception $e) {
		return Null;
	}
}
