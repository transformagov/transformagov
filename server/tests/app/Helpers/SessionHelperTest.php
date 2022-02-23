<?php

namespace App\Helpers;
use Config\Services;

use CodeIgniter\Test\CIUnitTestCase;

class SesssaoHelperTest extends CIUnitTestCase
{
    public function testFormataNomeDoUsuario()
    {
        helper('sessao');
        $session = Services::session();
        $session->set('nome', 'Pencillabs Empresa limitada');
        $this->assertSame('Pencillabs limitada', formataNomeDoUsuario($session));
    }

    public function testRecuperaPerfil()
    {
        helper('sessao');
        $session = Services::session();
        $session->set('perfil', 'administrador');
        $this->assertSame('Administrador', recuperaPerfilDoUsuario($session));
    }

    public function testRecuperaPerfilInexistente()
    {
        helper('sessao');
        $session = Services::session();
        $session->set('perfil', 'qualquer');
        $this->assertSame('', recuperaPerfilDoUsuario($session));
    }

    public function testRecuperaMenuLateralDoPerfilCandidato()
    {
        helper('sessao');
        $session = Services::session();
        $session->set('perfil', 'candidato');
        $menu = menuDoPerfil($session);
        $this->assertSame('candidato/menu', $menu);
    }

    public function testRecuperaMenuLateralDoPerfilAdm()
    {
        helper('sessao');
        $session = Services::session();
        $session->set('perfil', 'administrador');
        $menu = menuDoPerfil($session);
        $this->assertNull($menu);
    }
}
