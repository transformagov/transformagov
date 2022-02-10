<?php

function usuario_logado($session)
{
	return $session->get('email') != '' and $session->get('logged_in') => true;
}
