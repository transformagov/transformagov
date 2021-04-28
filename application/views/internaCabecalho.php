<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*if($this -> session -> trocasenha && $menu2 != 'inicial'){
        redirect(base_url("Interna"));
}*/
if(strlen($this -> session -> nome) > 0){
        $nome=explode(' ', $this -> session -> nome);
        $primeironome=$nome[0];
        $ultimonome=$nome[count($nome)-1];
        if(strlen($primeironome) + strlen($ultimonome) > 30){
                $ultimonome=substr($ultimonome, 0, 1).'.';
        }
}
echo "<!DOCTYPE html>
<html lang=\"pt-br\" >
        <head>
                <meta charset=\"utf-8\"/>
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

                <title>".$this -> config -> item('nome')."</title>
                <meta name=\"description\" content=\"Sistema do ".$this -> config -> item('nome')."\"> 
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

                <!--begin::Fonts -->
                <link href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,600,800\" rel=\"stylesheet\">
                <!-- Required Fremwork -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components/bootstrap/css/bootstrap.min.css')."\">
                <!-- feather Awesome -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/icon/feather/css/feather.css')."\">
                <!-- Font Awesome -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/icon/font-awesome/css/font-awesome.min.css')."\">
                <!-- animation nifty modal window effects css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/component.css')."\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
                <script src=\"https://kit.fontawesome.com/f7bac64a2c.js\" crossorigin=\"anonymous\"></script>    

                <!--begin::Page Vendors Styles(used by this page) -->";
if(isset($adicionais['ico'])){
        echo "
                <!-- ico font -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/icon/icofont/css/icofont.css')."\">";
}
if(isset($adicionais['themify'])){
        echo "
                <!-- themify icon -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/icon/themify-icons/themify-icons.css')."\">";
}
if(isset($adicionais['prism'])){
        echo "
                <!-- Syntax highlighter Prism css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/pages/prism/prism.css')."\">";
}
if(isset($adicionais['flags'])){
        echo "
                <!-- flag icon framework css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/pages/flag-icon/flag-icon.min.css')."\">";
}
if(isset($adicionais['datatables'])){
        echo "
                <!-- Data Table Css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')."\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets\pages\data-table\css\buttons.dataTables.min.css')."\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')."\">";
}
if(isset($adicionais['rangeslider'])){
        echo "
                <!-- Range slider css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\seiyria-bootstrap-slider\css\bootstrap-slider.css')."\">";
}
if(isset($adicionais['calendar'])){
        echo "
        <!-- Calender css -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\fullcalendar\css\fullcalendar.css')."\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\fullcalendar\css\fullcalendar.print.css')."\" media='print'>";
}
/*
if(isset($adicionais['pickers'])){
        echo "
                <!-- Date-time picker css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets\pages\advance-elements\css\bootstrap-datetimepicker.css')."\">";
}*/
if(isset($adicionais['pickers'])){
        echo "
		<link href=\"".base_url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')."\" rel=\"stylesheet\" type=\"text/css\" />
		<link href=\"".base_url('bower_components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')."\" rel=\"stylesheet\" type=\"text/css\" />
		<link href=\"".base_url('bower_components/bootstrap-timepicker/css/bootstrap-timepicker.css')."\" rel=\"stylesheet\" type=\"text/css\" />
		<link href=\"".base_url('bower_components/bootstrap-daterangepicker/daterangepicker.css')."\" rel=\"stylesheet\" type=\"text/css\" />";
}
if(isset($adicionais['wizard'])){
        echo "
                <!--forms-wizard css-->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\jquery.steps\css\jquery.steps.css')."\">";
}
if(isset($adicionais['select2'])){
    echo "
    <!-- Select2 css -->
    <link href=\"//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css\" rel=\"stylesheet\" />
";
}
echo "
                <link href=\"".base_url('bower_components/sweetalert2/dist/sweetalert2.css')."\" rel=\"stylesheet\" type=\"text/css\" />

                <!-- Style.css -->
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/style.min.css')."\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets\css\jquery.mCustomScrollbar.css')."\">
                    
                <!--end::Layout Skins -->
                <link rel=\"shortcut icon\" href=\"".base_url('images/favicon.ico')."\" />
                                <!-- Estilo para tabs de conteúdo -->    
                <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/melhorias.css')."\"> 
                <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-929704-18\"></script>
                <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
    
                gtag('config', 'UA-929704-18');
                </script>   

    </head>
    <!-- end::Head -->

    <!-- begin::Body -->
    <body class=\"page-footer-fixed\">
            <!-- Pre-loader start -->
            <div class=\"theme-loader\">
                <div class=\"loader-block\">
                    <svg id=\"loader2\" viewbox=\"0 0 100 100\">
                            <circle id=\"circle-loader2\" cx=\"50\" cy=\"50\" r=\"45\"></circle>
                    </svg>
                </div>
            </div>
            <!-- Pre-loader end -->
            <!-- Menu header start -->
            <div id=\"pcoded\" class=\"pcoded\">
                <div class=\"pcoded-overlay-box\"></div>
                <div class=\"pcoded-container navbar-wrapper\">
                    <nav class=\"navbar header-navbar pcoded-header\" header-theme=\"theme6\">
                        <div class=\"navbar-wrapper\">

                            <div class=\"navbar-logo\">
                                <a class=\"mobile-menu\" id=\"mobile-collapse\" href=\"#!\">
                                    <i class=\"feather icon-menu\"></i>
                                </a>
                                <a href=\"".base_url()."\">
                                    <img class=\"img-fluid\" alt=\"Logo\" src=\"".base_url('images/logo2.png')."\" width=\"150\" style=\"margin-left:15px\">
                                </a>
                                <a class=\"mobile-options\">
                                    <i class=\"feather icon-more-horizontal\"></i>
                                </a>
                            </div>

                            <div class=\"navbar-container container-fluid\">
                                <ul class=\"nav-left\">";
/*
echo "
                                    <li class=\"header-search\">
                                        <div class=\"main-search morphsearch-search\">
                                            <div class=\"input-group\">
                                                <span class=\"input-group-addon search-close\"><i class=\"feather icon-x\"></i></span>
                                                <input type=\"text\" class=\"form-control\">
                                                <span class=\"input-group-addon search-btn\"><i class=\"feather icon-search\"></i></span>
                                            </div>
                                        </div>
                                    </li>";
*/
echo "
                                    <li>
                                        <a href=\"#!\" onclick=\"javascript:toggleFullScreen()\">
                                            <i class=\"feather icon-maximize full-screen\"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <div style=\"align-items:center;align-self:center;\"><span style=\"font-weight:500;font-size:1rem;color:#fff;padding-left:20px;\">";
if($this -> session -> perfil == 'candidato'){
        echo 'Candidato';
}
else if($this -> session -> perfil == 'avaliador'){
        echo 'Avaliador';
}
else if($this -> session -> perfil == 'sugesp'){
        echo 'Gestor SEPLAG';
}
else if($this -> session -> perfil == 'orgaos'){
        echo 'Gestor Outros Órgãos';
}
else if($this -> session -> perfil == 'administrador'){
        echo 'Administrador';
}
echo "</span>
                                        </div>
                                    </li>
                                </ul>
                                <ul class=\"nav-right\">
                                    <li class=\"header-notification\">
                                        <div class=\"dropdown-primary dropdown\">
                                            <div class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                                <i class=\"feather icon-bell\"></i>";
/*
echo "
                                                <span class=\"badge bg-c-pink\">5</span>";
*/
echo "
                                            </div>
                                            <ul class=\"show-notification notification-view dropdown-menu\" data-dropdown-in=\"fadeIn\" data-dropdown-out=\"fadeOut\">
                                                <li>
                                                    <h6>Notificações</h6>";
/*
echo "
                                                    <label class=\"label label-danger\">New</label>";
*/
echo "
                                                </li>";
/*
echo "
                                                <li>
                                                    <div class=\"media\">
                                                        <img class=\"d-flex align-self-center img-radius\" src=\"".base_url('assets\images\avatar-4.jpg')."\" alt=\"Generic placeholder image\">
                                                        <div class=\"media-body\">
                                                            <h5 class=\"notification-user\">John Doe</h5>
                                                            <p class=\"notification-msg\">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                            <span class=\"notification-time\">30 minutes ago</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class=\"media\">
                                                        <img class=\"d-flex align-self-center img-radius\" src=\"".base_url('assets\images\avatar-3.jpg')."\" alt=\"Generic placeholder image\">
                                                        <div class=\"media-body\">
                                                            <h5 class=\"notification-user\">Joseph William</h5>
                                                            <p class=\"notification-msg\">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                            <span class=\"notification-time\">30 minutes ago</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class=\"media\">
                                                        <img class=\"d-flex align-self-center img-radius\" src=\"".base_url('assets\images\avatar-4.jpg')."\" alt=\"Generic placeholder image\">
                                                        <div class=\"media-body\">
                                                            <h5 class=\"notification-user\">Sara Soudein</h5>
                                                            <p class=\"notification-msg\">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                            <span class=\"notification-time\">30 minutes ago</span>
                                                        </div>
                                                    </div>
                                                </li>";
*/
echo "
                                            </ul>
                                        </div>
                                    </li>";
/*
echo "
                                    <li class=\"header-notification\">
                                        <div class=\"dropdown-primary dropdown\">
                                            <div class=\"displayChatbox dropdown-toggle\" data-toggle=\"dropdown\">
                                                <i class=\"feather icon-message-square\"></i>
                                                <span class=\"badge bg-c-green\">3</span>
                                            </div>
                                        </div>
                                    </li>";
*/
echo "
                                    <li class=\"user-profile header-notification\">
                                        <div class=\"dropdown-primary dropdown\">
                                            <div class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                                <img src=\"".base_url('Interna/avatar')."\" class=\"img-radius\" alt=\"User-Profile-Image\">
                                                <span>{$primeironome} {$ultimonome}</span>
                                                <i class=\"feather icon-chevron-down\"></i>
                                            </div>
                                            <ul class=\"show-notification profile-notification dropdown-menu\" data-dropdown-in=\"fadeIn\" data-dropdown-out=\"fadeOut\">";
if($this -> session -> perfil == 'candidato'){ //candidato
        echo "
                                                <li>
                                                    <a href=\"".base_url('Candidatos/index')."\">
                                                        <i class=\"fa fa-user\"></i> Seus dados
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href=\"".base_url('Candidatos/curriculo_base')."\">
                                                        <i class=\"fa fa-book\"></i> Currículo base
                                                    </a>
                                                </li>
                                                ";
}
echo "
                                                <li>
                                                    <a href=\"javascript://\" data-toggle=\"modal\" data-target=\"#trocarsenha\">
                                                        <i class=\"fa fa-key\"></i> Alterar senha
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href=\"".base_url('Interna/logout')."\">
                                                        <i class=\"fa fa-sign-out\"></i> Sair
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>";
/*
echo "
                    <!-- Sidebar chat start -->
                    <div id=\"sidebar\" class=\"users p-chat-user showChat\">
                        <div class=\"had-container\">
                            <div class=\"card card_main p-fixed users-main\">
                                <div class=\"user-box\">
                                    <div class=\"chat-inner-header\">
                                        <div class=\"back_chatBox\">
                                            <div class=\"right-icon-control\">
                                                <input type=\"text\" class=\"form-control  search-text\" placeholder=\"Search Friend\" id=\"search-friends\">
                                                <div class=\"form-icon\">
                                                    <i class=\"icofont icofont-search\"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"main-friend-list\">
                                        <div class=\"media userlist-box\" data-id=\"1\" data-status=\"online\" data-username=\"Josephin Doe\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Josephin Doe\">
                                            <a class=\"media-left\" href=\"#!\">
                                                <img class=\"media-object img-radius img-radius\" src=\"".base_url('assets\images\avatar-3.jpg')."\" alt=\"Generic placeholder image \">
                                                <div class=\"live-status bg-success\"></div>
                                            </a>
                                            <div class=\"media-body\">
                                                <div class=\"f-13 chat-header\">Josephin Doe</div>
                                            </div>
                                        </div>
                                        <div class=\"media userlist-box\" data-id=\"2\" data-status=\"online\" data-username=\"Lary Doe\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Lary Doe\">
                                            <a class=\"media-left\" href=\"#!\">
                                                <img class=\"media-object img-radius\" src=\"".base_url('assets\images\avatar-2.jpg')."\" alt=\"Generic placeholder image\">
                                                <div class=\"live-status bg-success\"></div>
                                            </a>
                                            <div class=\"media-body\">
                                                <div class=\"f-13 chat-header\">Lary Doe</div>
                                            </div>
                                        </div>
                                        <div class=\"media userlist-box\" data-id=\"3\" data-status=\"online\" data-username=\"Alice\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Alice\">
                                            <a class=\"media-left\" href=\"#!\">
                                                <img class=\"media-object img-radius\" src=\"".base_url('assets\images\avatar-4.jpg')."\" alt=\"Generic placeholder image\">
                                                <div class=\"live-status bg-success\"></div>
                                            </a>
                                            <div class=\"media-body\">
                                                <div class=\"f-13 chat-header\">Alice</div>
                                            </div>
                                        </div>
                                        <div class=\"media userlist-box\" data-id=\"4\" data-status=\"online\" data-username=\"Alia\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Alia\">
                                            <a class=\"media-left\" href=\"#!\">
                                                <img class=\"media-object img-radius\" src=\"".base_url('assets\images\avatar-3.jpg')."\" alt=\"Generic placeholder image\">
                                                <div class=\"live-status bg-success\"></div>
                                            </a>
                                            <div class=\"media-body\">
                                                <div class=\"f-13 chat-header\">Alia</div>
                                            </div>
                                        </div>
                                        <div class=\"media userlist-box\" data-id=\"5\" data-status=\"online\" data-username=\"Suzen\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Suzen\">
                                            <a class=\"media-left\" href=\"#!\">
                                                <img class=\"media-object img-radius\" src=\"".base_url('assets\images\avatar-2.jpg')."\" alt=\"Generic placeholder image\">
                                                <div class=\"live-status bg-success\"></div>
                                            </a>
                                            <div class=\"media-body\">
                                                <div class=\"f-13 chat-header\">Suzen</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar inner chat start-->
                    <div class=\"showChat_inner\">
                        <div class=\"media chat-inner-header\">
                            <a class=\"back_chatBox\">
                                <i class=\"feather icon-chevron-left\"></i> Josephin Doe
                            </a>
                        </div>
                        <div class=\"media chat-messages\">
                            <a class=\"media-left photo-table\" href=\"#!\">
                                <img class=\"media-object img-radius img-radius m-t-5\" src=\"".base_url('assets\images\avatar-3.jpg')."\" alt=\"Generic placeholder image\">
                            </a>
                            <div class=\"media-body chat-menu-content\">
                                <div class=\"\">
                                    <p class=\"chat-cont\">I'm just looking around. Will you tell me something about yourself?</p>
                                    <p class=\"chat-time\">8:20 a.m.</p>
                                </div>
                            </div>
                        </div>
                        <div class=\"media chat-messages\">
                            <div class=\"media-body chat-menu-reply\">
                                <div class=\"\">
                                    <p class=\"chat-cont\">I'm just looking around. Will you tell me something about yourself?</p>
                                    <p class=\"chat-time\">8:20 a.m.</p>
                                </div>
                            </div>
                            <div class=\"media-right photo-table\">
                                <a href=\"#!\">
                                    <img class=\"media-object img-radius img-radius m-t-5\" src=\"".base_url('assets\images\avatar-4.jpg')."\" alt=\"Generic placeholder image\">
                                </a>
                            </div>
                        </div>
                        <div class=\"chat-reply-box p-b-20\">
                            <div class=\"right-icon-control\">
                                <input type=\"text\" class=\"form-control search-text\" placeholder=\"Share Your Thoughts\">
                                <div class=\"form-icon\">
                                    <i class=\"feather icon-navigation\"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar inner chat end-->";";
*/
/*
echo "
        
        
        
        
        
            <!-- begin::Page loader -->
            <div class=\"kt-page-loader kt-page-loader--base\">
                    <div class=\"blockui\">
                            <span>Aguarde...</span>
                            <span><div class=\"kt-spinner kt-spinner--brand\"></div></span>
                    </div>
            </div>	
            <!-- end::Page Loader -->   
            
            <!-- begin:: Page -->	
            <!-- begin:: Header Mobile -->
            <div id=\"kt_header_mobile\" class=\"kt-header-mobile  kt-header-mobile--fixed \">
                    <div class=\"kt-header-mobile__logo\">
                            <a href=\"".base_url()."\">
                                    <img alt=\"Logo\" src=\"".base_url('images/logo2.png')."\" width=\"150\">
                            </a>
                    </div>
                    <div class=\"kt-header-mobile__toolbar\">
                            <button class=\"kt-header-mobile__toggler kt-header-mobile__toggler--left\" id=\"kt_aside_mobile_toggler\"><span></span></button>
                            <button class=\"kt-header-mobile__topbar-toggler\" id=\"kt_header_mobile_topbar_toggler\"><i class=\"flaticon-more\"></i></button>
                    </div>
            </div>
            <!-- end:: Header Mobile -->
            
            <div class=\"kt-grid kt-grid--hor kt-grid--root\">
                    <div class=\"kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page\">

                            <!-- begin:: Aside -->
                            <button class=\"kt-aside-close \" id=\"kt_aside_close_btn\"><i class=\"la la-close\"></i></button>
                            <div class=\"kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop\" id=\"kt_aside\">

                                    <!-- begin:: Aside -->
                                    <div class=\"kt-aside__brand kt-grid__item \" id=\"kt_aside_brand\">
                                            <div class=\"kt-aside__brand-logo\">
                                                    <a href=\"".base_url()."\">
                                                            <img alt=\"Logo\" src=\"".base_url('images/logo2.png')."\" width=\"150\">
                                                    </a>
                                            </div>
                                            <div class=\"kt-aside__brand-tools\">
                                                    <button class=\"kt-aside__brand-aside-toggler\" id=\"kt_aside_toggler\">
                                                            <span>
                                                                    <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" version=\"1.1\" class=\"kt-svg-icon\">
                                                                            <g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
                                                                                    <polygon id=\"Shape\" points=\"0 0 24 0 24 24 0 24\" />
                                                                                    <path d=\"M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z\" id=\"Path-94\" fill=\"#000000\" fill-rule=\"nonzero\" transform=\"translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) \" />
                                                                                    <path d=\"M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z\" id=\"Path-94\" fill=\"#000000\" fill-rule=\"nonzero\" opacity=\"0.3\" transform=\"translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) \" />
                                                                            </g>
                                                                    </svg>
                                                            </span>
                                                            <span>
                                                                    <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" version=\"1.1\" class=\"kt-svg-icon\">
                                                                            <g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
                                                                                    <polygon id=\"Shape\" points=\"0 0 24 0 24 24 0 24\" />
                                                                                    <path d=\"M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z\" id=\"Path-94\" fill=\"#000000\" fill-rule=\"nonzero\" />
                                                                                    <path d=\"M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z\" id=\"Path-94\" fill=\"#000000\" fill-rule=\"nonzero\" opacity=\"0.3\" transform=\"translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) \" />
                                                                            </g>
                                                                    </svg>
                                                            </span>
                                                    </button>

                                                    <!--
                                                    <button class=\"kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left\" id=\"kt_aside_toggler\"><span></span></button>
                                                    -->
                                            </div>
                                    </div>
                                    <!-- end:: Aside -->";

 */
?>