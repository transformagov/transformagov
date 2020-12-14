<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this -> load -> view('publicoCabecalho');
echo "
            <section class=\"login-block\">
                <!-- Container-fluid starts -->
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-sm-12\">
                            <!-- Authentication card start -->";
$attributes = array('class' => 'md-float-material form-material');
echo form_open($url, $attributes);
echo "
                                    <div class=\"text-center\">
                                        <img src=\"".base_url('images/logo.png')."\" alt=\"".$this -> config -> item('nome')."\" />
                                    </div>
                                    <!--<div class=\"row\" style=\"margin-top: 10px\">";
/*if($menu2 == 'index'){
        echo "
                                        <div class=\"alert background-danger\" style=\"width:90%;margin:0 auto;\">
                                               Prezado(a) candidato(a) dos editais de <strong>Processo Seletivo Simplificado Pró-Brumadinho</strong>, estes processos foram migrados para o sistema Processos Seletivos MG: <a href=\"http://www.processoseletivo.mg.gov.br/\"><strong>http://www.processoseletivo.mg.gov.br/</strong></a>
                                        </div>
                                        ";
}*/
echo "
                                    </div>-->
                                    <div class=\"auth-box card\">
                                        <div class=\"card-block\">
                                            <div class=\"row m-b-20\">
                                                <div class=\"col-md-12\">
                                                    <h3 class=\"text-center\">{$nome_pagina}</h3>
                                                </div>
                                            </div>";


if(strlen($erro)>0){
        echo "
                                            <div class=\"alert background-danger\">
                                                    <div class=\"alert-text\">
                                                            <strong>ERRO</strong>: {$erro}
                                                    </div>
                                            </div>";
}
if(strlen($sucesso)>0){
        echo "
                                            <div class=\"alert background-success\">
                                                    <div class=\"alert-text\">
                                                            <strong>{$sucesso}</strong>
                                                    </div>
                                            </div>";
}
echo "
                                            <div class=\"form-group form-primary\">";
if($menu2 == 'index' || $menu2 == 'recuperar'){
        $attributes = array('name' => 'cpf',
                            'id' => 'cpf',
                            'type' => 'tel',
                            'maxlength'=>'14',
                            'class' => 'form-control',
                            'autocomplete'=>'off',
                            'placeholder'=>'CPF');
        if(strstr($erro, 'CPF')){
                $attributes['class'] = 'form-control is-invalid';
        }
        echo form_input($attributes, set_value('cpf'));
        echo "
                                                <span class=\"form-bar\"></span>
                                            </div>";
}
if($menu2 == 'index'){
        echo "
                                            <div class=\"form-group form-primary\">
                                                                                ";
        //$attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        //echo form_label('Senha', 'senha', $attributes);

        $attributes = array('name' => 'senha',
                            'id' => 'senha',
                            'class' => 'form-control',
                            'value'=>'',
                            'placeholder'=>'Senha');
        echo form_password($attributes);
        echo "
                                                 <span class=\"form-bar\"><input type=\"checkbox\" onclick=\"mostrarSenha()\" style=\"padding-left:10px; margin-top:10px; text-align:center;\"> Mostrar senha </span>
                                            </div>";
}
if($menu2 == 'contato'){
        echo "
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'nome',
                            'id' => 'nome',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'placeholder'=>'Nome completo');
        echo form_input($attributes, set_value('nome'));
        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'email',
                            'id' => 'email',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'placeholder'=>'E-mail');
        echo form_input($attributes, set_value('email'));
        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'assunto',
                            'id' => 'assunto',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'placeholder'=>'Assunto');
        echo form_input($attributes, set_value('assunto'));
        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'msg',
                            'id' => 'msg',
                            'rows'=>'3',
                            'class' => 'form-control',
                            'placeholder' => 'Mensagem',
                            'style' => 'height:100px');
        echo form_textarea($attributes, set_value('msg'));
        echo "
                                            </div>";
}
if($menu2 == 'index'){
        echo "
                                            <div class=\"text-center center-block\">";
        $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
                            'style'=>'width:60%');
        echo form_submit('logar_sistema', 'Login', $attributes);
        echo "
                                                    <button type=\"button\" name=\"cadastrar\" class=\"btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase\" style=\"width:60%\" onclick=\"window.location='".base_url('/Candidatos/cadastro')."'\">Cadastre-se</button>
                                            </div>
                                            <hr>
                                            <div class=\"row m-t-25 text-center\">
                                                    <div class=\"col-12\">
                                                            <a href=\"".base_url('Publico/recuperar')."\">Esqueceu sua senha?</a><br/>
                                                            <a href=\"";
        //echo base_url('Publico/contato');
        echo 'https://www.mg.gov.br/transforma-minas/fale-conosco';
        echo "\" class=\"kt-login__link\" target=\"_blank\">Fale conosco</a><br/>
                                                            <a href=\"https://www.mg.gov.br/transforma-minas/faq\">Perguntas frequentes</a>
                                                    </div>
                                            </div>";
}
else if($menu2 == 'recuperar'){
        echo "
                                            <div class=\"text-center center-block\">";
        $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
                            'style'=>'width:60%');
        echo form_submit('enviado', 'Recuperar', $attributes);
        echo "
                                            </div>
                                            <hr>
                                            <div class=\"row m-t-25 text-center\">
                                                    <div class=\"col-12\">
                                                            <a href=\"".base_url('Publico/index')."\">Login</a>
                                                    </div>
                                            </div>";
}
else if($menu2 == 'recuperar'){
        echo "
                                            <div class=\"text-center center-block\">";
        $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
                            'style'=>'width:60%');
        echo form_submit('enviado', 'Enviar', $attributes);
        echo "
                                            </div>
                                            <hr>
                                            <div class=\"row m-t-25 text-center\">
                                                    <div class=\"col-12\">
                                                            <a href=\"".base_url('Publico/index')."\">Login</a>
                                                    </div>
                                            </div>";
}
echo "
                                        </div>
                                    </div>
                                </form>
                                <!-- end of form -->
                        </div>
                        <!-- end of col-sm-12 -->
                    </div>
                    <!-- end of row -->

                    <div class=\"text-center\" style=\"margin-top: 10px\">
                            <br/>SUGESP - SEPLAG © Layout Adminty
                    </div>
                </div>
                <!-- end of container-fluid -->
            </section>
            <!--[if lt IE 10]>
                <div class=\"ie-warning\">
                    <h1>Alerta!!</h1>
                    <p>Você está usando uma versão desatualizada de um navegador não suportado. Favor fazer o download de algum dos navegadores abaixo.</p>
                    <div class=\"iew-container\">
                        <ul class=\"iew-download\">
                            <li>
                                <a href=\"http://www.google.com/chrome/\">
                                    <img src=\"".base_url('assets/images/browser/chrome.png')."\" alt=\"Chrome\">
                                    <div>Chrome</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"https://www.mozilla.org/en-US/firefox/new/\">
                                    <img src=\"".base_url('assets/images/browser/firefox.png')."\" alt=\"Firefox\">
                                    <div>Firefox</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"http://www.opera.com\">
                                    <img src=\"".base_url('assets/images/browser/opera.png')."\" alt=\"Opera\">
                                    <div>Opera</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"https://www.apple.com/safari/\">
                                    <img src=\"".base_url('assets/images/browser/safari.png')."\" alt=\"Safari\">
                                    <div>Safari</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"http://windows.microsoft.com/en-us/internet-explorer/download-ie\">
                                    <img src=\"".base_url('assets/images/browser/ie.png')."\" alt=\"\">
                                    <div>IE (9 & above)</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <p>Nos desculpe pela inconveniência!</p>
                </div>
            <![endif]-->";
$pagina['js']="
                <script type=\"text/javascript\">
                    $(document).ready(function(){
                            $('#cpf').inputmask('999.999.999-99');
                    });
					function mostrarSenha(){
							var x = document.getElementById(\"senha\");
							  if (x.type === \"password\") {
								x.type = \"text\";
							  } else {
								x.type = \"password\";
							  }
					}
                </script>";
/*
echo "
						<div class=\"kt-login__container\">
                                                        <div class=\"kt-login__signin\">
								<div class=\"kt-login__head\">
                                                                        <h3 class=\"kt-login__title\">{$nome_pagina}</h3>
								</div>";

if(strlen($erro)>0){
        echo "
                                                                <div class=\"alert background-danger\">
                                                                        <div class=\"alert-text\">
                                                                                <strong>ERRO</strong>: {$erro}
                                                                        </div>
                                                                </div>";
}
if(strlen($sucesso)>0){
        echo "
                                                                <div class=\"alert background-success\">
                                                                        <div class=\"alert-text\">
                                                                                <strong>{$sucesso}</strong>
                                                                        </div>
                                                                </div>";
}
echo "
                                                                ";
$attributes = array('class' => 'kt-form');
echo form_open($url, $attributes);
if($menu2 == 'index' || $menu2 == 'recuperar'){
        echo "
									<div class=\"input-group\">
                                                                                ";
        //$attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        //echo form_label('CPF', 'cpf', $attributes);

        $attributes = array('name' => 'cpf',
                            'id' => 'cpf',
                            'maxlength'=>'14',
                            'class' => 'form-control',
                            'autocomplete'=>'off',
                            'placeholder'=>'CPF');
        if(strstr($erro, 'CPF')){
                $attributes['class'] = 'form-control is-invalid';
        }
        echo form_input($attributes, set_value('cpf'));
        echo "
									</div>";
}
if($menu2 == 'index'){
        echo "
                                                                        <div class=\"input-group\">
                                                                                ";
        //$attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        //echo form_label('Senha', 'senha', $attributes);

        $attributes = array('name' => 'senha',
                            'id' => 'senha',
                            'class' => 'form-control',
                            'value'=>'',
                            'placeholder'=>'Senha');
        echo form_password($attributes);
        echo "
                                                                        </div>";
}
if($menu2 == 'contato'){
        echo "
                                                                        <div class=\"input-group\">
                                                                                ";
        $attributes = array('name' => 'nome',
                            'id' => 'nome',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'placeholder'=>'Nome completo');
        echo form_input($attributes, set_value('nome'));
        echo "
                                                                        </div>
                                                                        <div class=\"input-group\">
                                                                                ";
        $attributes = array('name' => 'email',
                            'id' => 'email',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'placeholder'=>'E-mail');
        echo form_input($attributes, set_value('email'));
        echo "
                                                                        </div>
                                                                        <div class=\"input-group\">
                                                                                ";
        $attributes = array('name' => 'assunto',
                            'id' => 'assunto',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'placeholder'=>'Assunto');
        echo form_input($attributes, set_value('assunto'));
        echo "
                                                                        </div>
                                                                        <div class=\"input-group\">
                                                                                ";
        $attributes = array('name' => 'msg',
                            'id' => 'msg',
                            'rows'=>'3',
                            'class' => 'form-control',
                            'placeholder' => 'Mensagem',
                            'style' => 'height:100px');
        echo form_textarea($attributes, set_value('msg'));
        echo "
                                                                        </div>";
}
echo "
									<div class=\"kt-login__actions\">
                                                                                ";
if($menu2 == 'index'){
        $attributes = array('class' => 'btn btn-brand btn-elevate kt-login__btn-primary uppercase');
        echo form_submit('logar_sistema', 'Login', $attributes);
        echo "
                                                                                <button type=\"button\" name=\"cadastrar\" class=\"btn btn-brand btn-elevate kt-login__btn-primary uppercase\" onclick=\"window.location='".base_url('/Candidatos/cadastro')."'\">Cadastre-se</button>
									</div>
									<div class=\"row kt-login__extra\">
										<div class=\"col kt-align-center\">
                                                                                        <a href=\"".base_url('Publico/recuperar')."\" id=\"kt_login_forgot\" class=\"kt-login__link\">Esqueceu sua senha?</a><br/>
                                                                                        <a href=\"";
        //echo base_url('Publico/contato');
        echo 'https://www.mg.gov.br/transforma-minas/fale-conosco';
        echo "\" class=\"kt-login__link\" target=\"_blank\">Fale conosco</a><br/>
                                                                                        <a href=\"https://www.mg.gov.br/transforma-minas/faq\" class=\"kt-login__link\" target=\"_blank\">Perguntas frequentes</a>
                                                                                </div>
									</div>";
}
else if($menu2 == 'recuperar'){
        $attributes = array('class' => 'btn btn-brand btn-elevate kt-login__btn-primary uppercase');
        echo form_submit('enviado', 'Recuperar', $attributes);
        echo "
									</div>
									<div class=\"row kt-login__extra\">
										<div class=\"col kt-align-center\">
                                                                                        <a href=\"".base_url('Publico/index')."\" id=\"kt_login_forgot\" class=\"kt-login__link\">Login</a>
                                                                                </div>
									</div>";
}
else if($menu2 == 'contato'){
        $attributes = array('class' => 'btn btn-brand btn-elevate kt-login__btn-primary uppercase');
        echo form_submit('enviado', 'Enviar', $attributes);
        echo "
									</div>
									<div class=\"row kt-login__extra\">
										<div class=\"col kt-align-center\">
                                                                                        <a href=\"".base_url('Publico/index')."\" id=\"kt_login_forgot\" class=\"kt-login__link\">Login</a>
                                                                                </div>
									</div>";
}
echo "
								</form>
                                                        </div>
						</div>
                                                <div class=\"kt-login__account\">";
if($menu2 == 'index'){
        echo "
                                                        <div class=\"alert alert-warning\" style=\"width:70%;margin:0 auto;background-color:#f9e491;font-size:1.2rem;\">
                                                                <div class=\"alert-text\" style=\"color: #7f6704;\">
                                                                        <h4 style=\"text-align:center\">AVISOS</h4>
                                                                        1) Você está acessando um sistema governamental, de responsabilidade do Governo do Estado de Minas Gerais, que deverá ser utilizado de acordo com a legislação vigente.<br/>
                                                                        2) A utilização do sistema é monitorada constantemente, sendo que para entrar você deve concordar em ceder dados de uso e informações pessoais que podem ficar registradas para aplicações legais.<br/>
                                                                        3) O uso não autorizado do sistema é proibido.
                                                                </div>
                                                        </div>";
}
echo "
                                                        <div class=\"col kt-align-center\">
                                                                <br/>SUGESP - SEPLAG © Layout Metronic
                                                        </div>
                                                </div>
					</div>
				</div>
			</div>
		</div>
                <script src=\"".base_url('assets_6.0.3/vendors/general/jquery/dist/jquery.js')."\" type=\"text/javascript\"></script>
                <script src=\"".base_url('assets_6.0.3/vendors/general/bootstrap/dist/js/bootstrap.min.js')."\" type=\"text/javascript\"></script>
                <script src=\"".base_url('assets_6.0.3/vendors/general/inputmask/dist/jquery.inputmask.bundle.js')."\" type=\"text/javascript\"></script>

                <script type=\"text/javascript\">
                    $(document).ready(function(){
                            $('#cpf').inputmask('999.999.999-99');
                    });
					
                </script>";

 */
$this -> load -> view('publicoRodape', $pagina);
?>