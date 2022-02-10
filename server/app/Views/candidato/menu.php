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
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <?php echo img(['src' => 'images/logo.png', 'alt' => 'TransformaGov', 'width' => '100px']) ?>
    </a>
    <a class="mobile-options">
        <i class="feather icon-more-horizontal"></i>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/usuario">
            <i class="fas fa-home"></i>
            <span>Página inicial</span>
        </a>
    </li>

        <li class="nav-item">
            <a class="nav-link" href="/candidaturas">
                <i class="fas fa-edit"></i>
                <span>Suas candidaturas</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="/candidaturas/entrevistas">
                <i class="fas fa-calendar"></i>
                <span>Seus agendamentos</span>
            </a>
        </li>

    <li class="nav-item">
        <a class="nav-link" href="/usuario/logout">
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

