<?php

function usuarioLogado($session)
{
	return $session->get('cpf') != '' and $session->get('loggedIn') == true;
}
