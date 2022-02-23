<?php


echo script_tag('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
echo script_tag('transforma-minas.js');
echo script_tag("//cdn.jsdelivr.net/npm/sweetalert2@11");
echo link_tag("sb-admin-2.min.css");
echo link_tag("transforma-minas-override.css");
echo link_tag("cabeçalho_publico.css");
echo link_tag("component.css");
echo link_tag("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css");
echo link_tag("https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i");
echo link_tag("sweetalert2.min.css");

$session = session();
$perfil = recuperaPerfilDoUsuario($session);
$nomeDoUsuario = formataNomeDoUsuario($session);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link rel="shortcut icon" href="<?= base_url('images/favicon.ico') ?>" /> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> TransformaGov </title>
    <meta name="description" content="Sistema do TransformaGov">

<!--
    <?php if (isset($adicionais['datatables'])): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets\pages\data-table\css\buttons.dataTables.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') ?>">
    <?php endif ?>
-->

<!--
    <?php if (isset($adicionais['wizard'])): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\jquery.steps\css\jquery.steps.css') ?>">
    <?php endif ?>
-->

<!--
    <?php if (isset($adicionais['select2'])): ?>
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/transforma-minas-select2.css') ?>" />
    <?php endif ?>
-->

<!--
    <?php if (isset($adicionais['calendar'])): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\fullcalendar\css\fullcalendar.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('bower_components\fullcalendar\css\fullcalendar.print.css') ?>" media='print'>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/transforma-minas-calendar.css') ?>" />
    <?php endif ?>
-->

</head>

<body id="page-top">
    <div class="theme-loader">
        <div class="loader"></div>
    </div>
    <div id="wrapper">

        <?php 
            echo view(menuDoPerfil($session));
        ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <a href="javascript:void(0)" id="toggleMinMaxScreen" class="mr-5">
                            <i id="minMaxScreenIcon" class="fa fa-window-maximize"></i>
                        </a>
                        <?= $perfil ?>
                    </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notificações
                                </h6>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline small nav-username">
                                    <?= esc($nomeDoUsuario) ?>
                                </span>
                                <?php echo img(['src' => 'images/nopic.jpg', 'alt' => 'Avatar', 'class' => "img-profile rounded-circle"]) ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <?php if ($session->perfil == "candidato"): ?>
                                    <a class="dropdown-item" href="/candidato">
                                        <i class="fa fa-user"></i> Seus dados
                                    </a>

                                    <a class="dropdown-item" href="/candidato/curriculo_base">
                                        <i class="fa fa-book"></i> Currículo base
                                    </a>
                                <?php endif ?>

                                <a class="dropdown-item" href="javascript://" data-toggle="modal" data-target="#trocarsenha">
                                    <i class="fa fa-key"></i>
                                    Alterar senha
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/usuario/logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">
                    <div class="page-wrapper p-2">
                        <div class="row">

