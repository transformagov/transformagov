<?php

function isActive(bool $check)
{
    if ($check) {
        return "active";
    } else {
        return "";
    }
}

$session = session();
$session->set(['perfil' => 'candidato']);
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <?php echo img(['src' => 'images/logo.png', 'alt' => 'TransformaGov', 'class' => 'img-fluid menu-logo']) ?>
    </a>
    <a class="mobile-options">
        <i class="feather icon-more-horizontal"></i>
    </a>

    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= isActive(uri_string() == "usuario") ?>">
        <a class="nav-link" href="/usuario">
            <i class="fas fa-home"></i>
            <span>Página inicial</span>
        </a>
    </li>

        <li class="nav-item <?= isActive(uri_string() == "candidaturas") ?>">
            <a class="nav-link" href="/candidaturas">
                <i class="fas fa-edit"></i>
                <span>Suas candidaturas</span>
            </a>
        </li>


        <li class="nav-item <?= isActive(uri_string() == "candidaturas/agendamentos") ?>">
            <a class="nav-link" href="/candidaturas/agendamentos">
                <i class="fas fa-calendar"></i>
                <span>Seus agendamentos</span>
            </a>
        </li>

    <li class="nav-item <?= isActive(uri_string() == "usuario/logout") ?>">
        <a class="nav-link" href="/usuario/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sair</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

