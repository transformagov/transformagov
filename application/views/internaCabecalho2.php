<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if($this -> session -> trocasenha && ($menu1 != 'Interna' || $menu2 != 'index')){
        redirect(base_url('Interna/index'));
}
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
        <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-929704-14\"></script>
        <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'UA-929704-14');
        </script>
        <meta charset=\"utf-8\"/>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

        <title>".$this -> config -> item('nome')."</title>
        <meta content=\"Sistema de gestão de frequência do Poder Executivo do Governo do Estado de Minas Gerais\" name=\"description\"/>
        <meta content=\"Cristiano de Magalhães Barros\" name=\"author\"/>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

        <!--begin::Fonts -->
        <link href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,600,800\" rel=\"stylesheet\">
        <!-- Required Fremwork -->
        <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\" integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\" crossorigin=\"anonymous\">";
/*
echo "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components/bootstrap/css/bootstrap.min.css')."\">";
*/
echo "
        <!-- feather Awesome -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/icon/feather/css/feather.css')."\">
        <!-- Font Awesome -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/icon/font-awesome/css/font-awesome.min.css')."\">
        <!-- animation nifty modal window effects css -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/component.css')."\">

        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/pages/list-scroll\list.css')."\">";
/*
echo "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components/jquery-ui/jquery-ui.min.css')."\">";
*/
echo "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">

        <!--begin::Page Vendors Styles(used by this page) -->";
if(isset($adicionais['jquery-ui'])){
        echo "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components/jquery-ui/jquery-ui.min.css')."\">";
}
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
        <!-- Select 2 css -->
        <link rel=\"stylesheet\" href=\"".base_url('bower_components/select2/css/select2.min.css')."\">";
}
if(isset($adicionais['calendar'])){
        echo "
        <!-- Calender css -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\fullcalendar\css\fullcalendar.css')."\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('bower_components\fullcalendar\css\fullcalendar.print.css')."\" media='print'>";
}
echo "
        <link href=\"".base_url('bower_components/sweetalert2/dist/sweetalert2.css')."\" rel=\"stylesheet\" type=\"text/css\" />

        <!-- Style.css -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/style.min.css')."\">";
if($this -> session -> altocontraste){
        echo "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/black.min.css')."\">";
}
echo "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/jquery.mCustomScrollbar.css')."\">

        <!--end::Layout Skins -->
        <!-- FAVICON -->
        <link rel=\"icon\" type=\"image/png\" href=\"".base_url('images/favicon3.ico')."\"/>
        <link rel=\"shortcut icon\" type=\"image/png\" href=\"".base_url('images/favicon3.ico')."\"/>
    </head>
    <body class=\"page-footer-fixed\">
        <div class=\"theme-loader\">
            <div class=\"text-center loader-block\">
                <div class=\"preloader4\">
                    <div class=\"double-bounce1\"></div>
                    <div class=\"double-bounce2\"></div>
                </div>
            </div>
        </div>";
/*
echo "
        <!-- Pre-loader start -->
        <div class=\"theme-loader\">
            <div class=\"loader-block\">
                <svg id=\"loader2\" viewbox=\"0 0 100 100\">
                        <circle id=\"circle-loader2\" cx=\"50\" cy=\"50\" r=\"45\"></circle>
                </svg>
            </div>
        </div>
        <!-- Pre-loader end -->";
*/
echo "
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
                                <img alt=\"Logo\" src=\"".base_url('images/logo3b.png')."\" style=\"width:100px;margin-left:50px\">
                            </a>
                            <a class=\"mobile-options\">
                                <i class=\"feather icon-more-horizontal\"></i>
                            </a>
                        </div>
                        <div class=\"navbar-container container-fluid\">
                            <ul class=\"nav-left\">";
        /*
        //preloader antigo
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
        
        //preloader corrente
        echo "
                                <li>
                                    <a href=\"#!\" onclick=\"javascript:toggleFullScreen()\">
                                        <i class=\"feather icon-maximize full-screen\"></i>
                                    </a>
                                </li>";
        
        echo "
                                <li>
                                    <div style=\"align-items:center;align-self:center;\">
                                        <div class=\"alto-contraste\">
                                            <a href=\"".base_url('Interna/index/altocontraste')."\" onclick=\"JaxonFuncoesJaxon.alto_contraste()\">Alto contraste</a>
                                        </div>
                                        <span style=\"font-weight:500;font-size:0.9rem;color:#fff;padding-left:20px;\">";
        $algum = false;
        if($this -> session -> superadmin == '1'){
                echo 'Superadmin';
                $algum = true;
        }
        else if($this -> session -> administrador == '1'){
                echo 'Administrador';
                $algum = true;
        }
        else{
                if($this -> session -> gestorfrequencia == '1'){
                        echo 'FR, ';
                        $algum = true;
                }
                if($this -> session -> gestorferias == '1'){
                        echo 'FE, ';
                        $algum = true;
                }
                if($this -> session -> gestorausencias == '1'){
                        echo 'AU, ';
                        $algum = true;
                }
                if($this -> session -> gestorrequerimentos == '1'){
                        echo 'RQ, ';
                        $algum = true;
                }
                if($this -> session -> gestorestrutura == '1'){
                        echo 'ES, ';
                        $algum = true;
                }
                if($this -> session -> gestorestagiarios == '1'){
                        echo 'ET, ';
                        $algum = true;
                }
                if($this -> session -> gestorpht == '1'){
                        echo 'PH, ';
                        $algum = true;
                }
                if($this -> session -> gestorcedidos == '1'){
                        echo 'CE, ';
                        $algum = true;
                }
                if($this -> session -> gestorgreves == '1'){
                        echo 'GR, ';
                        $algum = true;
                }
                if($this -> session -> sindical == '1'){
                        echo 'SI, ';
                        $algum = true;
                }
                if($this -> session -> gestorrelatorios == '1'){
                        echo 'RE, ';
                        $algum = true;
                }
                if($this -> session -> auditoriacge == '1'){
                        echo 'CG, ';
                        $algum = true;
                }
        }
        if(!$algum){
                echo 'Geral';
        }
        if(strlen($this -> session -> sigla) > 0){
                echo ' - '.$this -> session -> sigla;
        }
        if(strlen($this -> session -> vc_municipio) > 0){
                echo ' - '.$this -> session -> vc_municipio;
        }
        echo "</span>
                                    </div>
                                </li>
                            </ul>
                            <ul class=\"nav-right\">";
        /*
        echo "
                                <li class=\"header-notification\">
                                    <div class=\"dropdown-primary dropdown\">
                                        <div class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                            <i class=\"feather icon-bell\"></i>";
        
        echo "
                                            <span class=\"badge bg-c-pink\">5</span>";
        
        echo "
                                        </div>
                                        <ul class=\"show-notification notification-view dropdown-menu\" data-dropdown-in=\"fadeIn\" data-dropdown-out=\"fadeOut\">
                                            <li>
                                                <h6>Avisos</h6>";
        
        echo "
                                                <label class=\"label label-danger\">Novo</label>";
        
        echo "
                                            </li>";
        
        echo "
                                            <li>
                                                <div class=\"media\">
                                                    <div class=\"media-body\">
                                                        <h5 class=\"notification-user\">John Doe</h5>
                                                        <p class=\"notification-msg\">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                        <span class=\"notification-time\">30 minutes ago</span>
                                                    </div>
                                                </div>
                                            </li>";
        
        echo "
                                        </ul>
                                    </div>
                                </li>";
        */
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
                                        <ul class=\"show-notification profile-notification dropdown-menu\" data-dropdown-in=\"fadeIn\" data-dropdown-out=\"fadeOut\">
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

?>