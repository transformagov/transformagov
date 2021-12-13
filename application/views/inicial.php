<?php

defined('BASEPATH') or exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if (isset($adicionais)) {
    $pagina['adicionais']=$adicionais;
}

$this -> load -> view('templates/internaCabecalho', $pagina);
//print_r($adicionais);


echo "
                        <div class=\"col-12\">
                            <div class=\"tsm-inner-content\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper\">
                                        <div class=\"page-body\">
                                            <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                    <div class=\"card\">
                                                        <div class=\"card-block\">
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>
                                                            <div class=\"col-lg-12\">
                                                                <!-- Default card start -->
                                                                <div class=\"card\">
                                                                    <div class=\"card-block\">
                                                                        Bem vindo ao Sistema do ".$this -> config -> item('nome').".<br/><br/>
                                                                        Verifique se o seu nome completo está correto: <span class=\"alert-danger\">".$this -> session -> nome."</span>.<br/>
                                                                        Data e hora atual do sistema: <span class=\"alert-danger\">".date('d/m/Y - H:i:s')."</span>.<br/><br/>
                                                                        Caso haja algum problema com as verificações acima, saia do sistema e informe os responsáveis pelo sistema por meio do fale conosco (link na página de login).<br/><br/>
                                                                        Se os dados acima estiverem corretos, utilize o menu ao lado para iniciar suas atividades.

                                                                        <h5 style=\"text-align:left\">AVISOS</h4>
                                                                        1) A utilização do sistema é monitorada constantemente, sendo que para entrar você deve concordar em ceder dados de uso e informações pessoais que podem ficar registradas para aplicações legais.<br/>
                                                                        2) O uso não autorizado do sistema é proibido.
                                                                    </div>
                                                                </div>";
echo "
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";

$this -> load -> view('templates/internaRodape', $pagina);
