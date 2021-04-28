<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo "<!DOCTYPE html>
<!--[if IE 8]> <html lang=\"ptbr\" class=\"ie8 no-js\"> <![endif]-->
<!--[if IE 9]> <html lang=\"ptbr\" class=\"ie9 no-js\"> <![endif]-->
<!--[if !IE]><!-->
<html lang=\"ptbr\">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
            <meta charset=\"utf-8\"/>
            <title>".$this -> config -> item('nome')."</title>
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
            <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\"/>
            <meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
            <meta content=\"Sistema do ".$this -> config -> item('nome')."\" name=\"description\"/>
            <meta content=\"Cristiano de Magalhães Barros\" name=\"author\"/>

            <!-- Style.css -->
            <link rel=\"stylesheet\" type=\"text/css\" href=\"" . base_url('assets/css/sb-admin-2.min.css') . "\" />
            <link rel=\"stylesheet\" type=\"text/css\" href=\"" . base_url('assets/css/transforma-minas-override.css') . "\" />
            <link rel=\"shortcut icon\" href=\"" . base_url('images/favicon.ico') . "\" />
            <!-- END THEME STYLES -->

            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-929704-18\"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-929704-18');
            </script>

    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class=\"fix-menu\" style=\"background-image:url('".base_url('images/camg.png')."');background-repeat: no-repeat; background-size: cover;\">";
?>