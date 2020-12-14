<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}
        
$this -> load -> view('internaCabecalho', $pagina);
$this -> load -> view('internaMenu', $pagina);
//print_r($adicionais);


echo "
                        <div class=\"pcoded-content\">
                            <div class=\"pcoded-inner-content\">
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
                                                                        1) Você está acessando um sistema governamental, de responsabilidade do Governo do Estado de Minas Gerais, que deverá ser utilizado de acordo com a legislação vigente.<br/>
                                                                        2) A utilização do sistema é monitorada constantemente, sendo que para entrar você deve concordar em ceder dados de uso e informações pessoais que podem ficar registradas para aplicações legais.<br/>
                                                                        3) O uso não autorizado do sistema é proibido.
                                                                    </div>
                                                                </div>";
if($this -> session -> perfil == 'candidato'){ //candidato
        echo "
																
                                                                <div class=\"card\">
                                                                    <div class=\"card-header\">
                                                                        <h5>O GOVERNO DE MINAS GERAIS ESTÁ INOVANDO NA FORMA DE SELECIONAR TALENTOS</h5>
                                                                    </div>
                                                                    <div class=\"card-block\">
                                                                        O estado estruturará processos seletivos para as posições de liderança de diversos Órgãos e Entidades. Faça parte desse time e ajude a transformar a realidade dos mineiros!<br/><br/>
                                                                        O Governo do Estado de Minas Gerais lançou no dia 08/03/2019 o Transforma Minas. Programa inovador que tem como os objetivos transformar a cultura de gestão de pessoas no setor público; replicar as mais atualizadas práticas de RH e prestar melhores serviços aos cidadãos. Trata-se de um programa inspirado em modelos já consagrados em países como Austrália, Chile e Reino Unido.<br/><br/>
                                                                        Esse processo seletivo está sendo realizado pelo Governo de Minas Gerais.<br/><br/><br/>
                                                                        GOVERNO DO ESTADO DE MINAS GERAIS<br/><br/>
                                                                        MG Cidade Administrativa - Rodovia Papa João Paulo II, 3777<br/>
                                                                        Serra Verde, Belo Horizonte, MG - CEP 31630-903
                                                                    

                                                                        
                                                                    </div>
                                                                </div>																
																";
}
echo "
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";

$this -> load -> view('internaRodape', $pagina);
?>