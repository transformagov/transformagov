<?php

function isActive(bool $check)
{
    if ($check) {
        return "active";
    } else {
        return "";
    }
}

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
        <img class="img-fluid" alt="Logo" src="<?= base_url('images/logo2.png') ?>" width="150">
    </a>
    <a class="mobile-options">
        <i class="feather icon-more-horizontal"></i>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= isActive($menu1 == 'Interna' && $menu2 == 'index') ?>">
        <a class="nav-link" href="<?= base_url('Interna/index') ?>">
            <i class="fas fa-home"></i>
            <span>Página inicial</span>
        </a>
    </li>

    <?php if ($this->session->perfil == 'candidato') : ?>
        <li class="nav-item <?= isActive($menu1 == 'Candidaturas' && $menu2 != 'AgendamentoEntrevista') ?>">
            <a class="nav-link" href="<?= base_url('Candidaturas/index') ?>">
                <i class="fas fa-edit"></i>
                <span>Suas candidaturas</span>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->session->perfil == 'avaliador' || $this->session->perfil == 'avaliador_curriculo' || $this->session->perfil == 'sugesp' || $this->session->perfil == 'orgaos' || $this->session->perfil == 'administrador') : ?>
        <li class="nav-item <?= isActive(($this->session->perfil == 'avaliador' && $menu1 == 'Candidaturas' && $menu2 != 'AgendamentoEntrevista') || ($this->session->perfil != 'avaliador' && $menu1 == 'Candidaturas'  && $menu2 != 'AgendamentoEntrevista')) ?>">
            <a class="nav-link" href="<?= base_url('Candidaturas/ListaAvaliacao') ?>">
                <i class="fas fa-edit"></i>
                <span>Candidaturas</span>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->session->perfil == 'candidato' || $this->session->perfil == 'avaliador' || $this->session->perfil == 'sugesp') : ?>
        <li class="nav-item <?= isActive($menu1 == 'Candidaturas' && $menu2 == 'AgendamentoEntrevista') ?>">
            <a class="nav-link" href="<?= base_url('Candidaturas/AgendamentoEntrevista') ?>">
                <i class="fas fa-calendar"></i>
                <span>Seus agendamentos</span>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->session->perfil == 'sugesp' || $this->session->perfil == 'orgaos' || $this->session->perfil == 'administrador') : ?>
        <li class="nav-item <?= isActive($menu1 == 'Candidatos') ?>">
            <a class="nav-link" href="<?= base_url('Candidatos/ListaCandidatos') ?>">
                <i class="fas fa-users"></i>
                <span>Candidatos</span>
            </a>
        </li>

        <li class="nav-item <?= isActive($menu1 == 'Vagas') ?>">
            <a class="nav-link" href="<?= base_url('Vagas/index') ?>">
                <i class="fas fa-thumbtack"></i>
                <span>Vagas</span>
            </a>
        </li>

        <li class="nav-item <?= isActive($menu1 == 'GruposVagas' || $menu1 == 'Questoes') ?>">
            <a class="nav-link" href="<?= base_url('GruposVagas/index') ?>">
                <i class="fas fa-check-square"></i>
                <span>Grupos de vagas e questões</span>
            </a>
        </li>

        <li class="nav-item <?= isActive($menu1 == 'Relatorios') ?>">
            <a class="nav-link" href="<?= base_url('Relatorios/index') ?>">
                <i class="fas fa-chart-line"></i>
                <span>Relatórios</span>
            </a>
        </li>
    <?php elseif ($this->session->perfil == 'avaliador') : ?>
        <li class="nav-item <?= isActive($menu1 == 'Vagas') ?>">
            <a class="nav-link" href="<?= base_url('Vagas/index') ?>">
                <i class="fas fa-thumbtack"></i>
                <span>Vagas</span>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->session->perfil == 'administrador') : ?>
        <li class="nav-item <?= isActive($menu1 == 'Interna' && $menu2 == 'auditoria') ?>">
            <a class="nav-link" href="<?= base_url('Interna/auditoria') ?>">
                <i class="fas fa-cog"></i>
                <span>Auditoria</span>
            </a>
        </li>

        <li class="nav-item <?= isActive($menu1 == 'Usuarios') ?>">
            <a class="nav-link" href="<?= base_url('Usuarios/index') ?>">
                <i class="fas fa-users"></i>
                <span>Usuários</span>
            </a>
        </li>
    <?php endif ?>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Interna/logout') ?>">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sair</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

