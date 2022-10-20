<?php

defined('BASEPATH') or exit('No direct script access allowed');
$this -> load -> view('templates/publicoCabecalho');
echo "
                                                        <div class=\"kt-login__signin\">
								<div class=\"kt-login__head\">
									<h3 class=\"kt-login__title\">Recupere sua senha</h3>
								</div>";

if (strlen($erro)>0) {
    echo "
                                                                <div class=\"alert alert-danger\">
                                                                        <div class=\"alert-text\">
                                                                                <strong>ERRO</strong>: $erro<br />
                                                                        </div>
                                                                </div>";
    $erro='';
}
if ($sucesso=='1') {
    echo "
                                                                <div class=\"alert alert-success\">
                                                                        <div class=\"alert-text\">
                                                                                <strong>Senha recuperada com sucesso. Favor verificar seu e-mail.<br />
                                                                        </div>
                                                                </div>";
} else {
    echo "
                                                                ";
    $attributes = array('class' => 'kt-form');
    echo form_open($pagina, $attributes);

    echo "
									<div class=\"input-group\">
                                                                                ";
    $attributes = array('name' => 'cpf',
                            'id' => 'cpf',
                            'maxlength'=>'14',
                            'class' => 'form-control',
                            'placeholder'=>'CPF');
    echo form_input($attributes, set_value('cpf'));

    echo "
                                                                        </div>
									<div class=\"kt-login__actions\">
                                                                                ";
    $attributes = array('class' => 'btn btn-brand btn-elevate kt-login__btn-primary uppercase');
    echo form_submit('enviado', 'Recuperar', $attributes);
    echo "
                                                                        </div>
									<div class=\"row kt-login__extra\">
                                                                                <a href=\"".base_url()."\" id=\"forget-password\" class=\"forget-password\">Login</a>
                                                                        </div>
								</form>                                                
                                                        </div>
						</div>
                                                <div class=\"kt-login__account\">
                                                        <div class=\"col kt-align-center\">
                                                                <br/>Desenvolvido pela SEPLAG/MG - Fundação Lemann - Pencillabs© Layout Metronic
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
}
$this -> load -> view('templates/publicoRodape');
