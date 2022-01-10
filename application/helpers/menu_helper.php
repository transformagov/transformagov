<?php

function menuVcVaga($menu2, $vagas) 
{
    if ($menu2 == 'questoes' || $menu2 == 'resultado' || $menu2 == 'resultado2' || $menu2 == 'resultado3') 
    {
        return ' - '.$vagas[0] -> vc_vaga;
    }
    return;
}

function perfilPodeADicionarVaga($menu2, $perfil)
{
    return $menu2 == 'index' && $perfil != 'avaliador';
}

function criarOuEditarVaga($menu2, $sucesso)
{
    return $menu2 != 'index' && strlen($sucesso) == 0 && ($menu2 == 'create' || $menu2 == 'edit');
}

