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
		"cpf" => $usuarioLogado->cpf,
		"nome" => $usuarioLogado->nome,
		"perfil" => $usuarioLogado->perfil,
		"loggedIn" => true,
	]);
}

function recuperaPerfilDoUsuario($session)
{
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

	$tiposDePerfil = [
		"candidato" => "Candidato",
		"avaliador" => "Avaliador",
		"sugesp" => "Gestor SEPLAG",
		"orgaos" => "Gestor Outros Órgãos",
		"administrador" => "Administrador",
	];
	$perfil = "";
	if (in_array($session->perfil, array_keys($tiposDePerfil))) {
		$perfil = $tiposDePerfil[$session->perfil];
	}
	return $perfil;
}

function menuDoPerfil($session)
{
	$tiposDeMenu = array('candidato' => 'candidato/menu');
	return $tiposDeMenu[$session->perfil];
}
