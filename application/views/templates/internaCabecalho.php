<?php

$pagina['menu1'] = $menu1;
$pagina['menu2'] = $menu2;
$pagina['url'] = $url;
$pagina['nome_pagina'] = $nome_pagina;
$pagina['icone'] = $icone;

if (strlen($this->session->nome) > 0) {
    $nome = explode(' ', $this->session->nome);
    $primeironome = $nome[0];
    $ultimonome = $nome[count($nome) - 1];
    if (strlen($primeironome) + strlen($ultimonome) > 30) {
        $ultimonome = substr($ultimonome, 0, 1) . '.';
    }
}

$perfilTypes = array(
    'candidato' => 'Candidato',
    'avaliador' => 'Avaliador',
    'sugesp' => 'Gestor SEPLAG',
    'orgaos' => 'Gestor Outros Órgãos',
    'administrador' => 'Administrador'
);
$perfil = "";
if (in_array($this->session->perfil, array_keys($perfilTypes))) {
    $perfil = $perfilTypes[$this->session->perfil];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="<?= base_url('images/favicon.ico') ?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> <?= $this->config->item('nome') ?> </title>
    <meta name="description" content="Sistema do <?= $this->config->item('nome') ?>">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/component.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/jquery-ui/jquery-ui.min.css') ?>">
    
    <!-- Custom styles for this template-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sb-admin-2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/transforma-minas-override.css') ?>">

    <!-- sweetalert2 style -->
    <link href="<?= base_url('bower_components/sweetalert2/dist/sweetalert2.css') ?>" rel="stylesheet" type="text/css">

    <?php if(isset($adicionais['datatables'])): ?>
        <!-- Data Table Css -->
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets\pages\data-table\css\buttons.dataTables.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') ?>">
    <?php endif ?>

    <?php if(isset($adicionais['wizard'])): ?>
        <!--forms-wizard css-->
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\jquery.steps\css\jquery.steps.css') ?>">
    <?php endif ?>

    <?php if(isset($adicionais['select2'])): ?>
        <!-- Select2 css -->
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/transforma-minas-select2.css') ?>" />
    <?php endif ?>

</head>

<body id="page-top">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader"></div>
    </div>
    <!-- Pre-loader end -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $this->load->view('templates/internaMenu', $pagina); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <a href="javascript:void(0)" id="toggleMinMaxScreen" class="mr-5">
                            <i id="minMaxScreenIcon" class="fa fa-window-maximize"></i>
                        </a>
                        <?= $perfil ?>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <!--
                                <span class="badge badge-danger badge-counter">3+</span>
                                -->
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notificações
                                </h6>
                                <!--
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>

                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>

                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>

                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                -->
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline small nav-username">
                                    <?= $primeironome . " " . $ultimonome ?>
                                </span>
                                <img class="img-profile rounded-circle" src="<?= base_url('Interna/avatar') ?>" alt="User Profile Image" />
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="javascript://" data-toggle="modal" data-target="#trocarsenha">
                                    <i class="fa fa-key"></i>
                                    Alterar senha
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('Interna/logout') ?>">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="page-wrapper p-2">
                        <div class="row">