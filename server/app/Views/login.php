<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex justify-content-center">
                <?php
                $attributes = ["class" => "md-float-material form-material"];
                echo form_open("Publico/realiza_login", $attributes);
                ?>
                <div class="text-center">
                    <?php echo img(['src' => 'images/logo.png', 'alt' => 'TransformaGov']) ?>
                </div>
                <div class="card col-lg-8 mt-3 p-3 mx-auto">
                    <div class="card-block">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="h3 text-gray-800 mb-4 text-center">Entre no Sistema</h3>
                            </div>
                        </div>
                        <?php if (strlen($erro) > 0): ?>
                            <div class="alert alert-danger background-danger">
                                    <div class="alert-text">
                                    <strong>ERRO</strong>: <?= esc($erro) ?>
                                    </div>
                            </div>
                        <?php endif; ?>
                        <?php if (strlen($sucesso) > 0): ?>
                            <div class="alert background-success">
                                    <div class="alert-text">
                                    <strong><?= esc($sucesso) ?></strong>
                                    </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group form-primary">
                            <?php
                            $attributes = [
                                "name" => "cpf",
                                "id" => "cpf",
                                "type" => "tel",
                                "maxlength" => "14",
                                "class" => "form-control",
                                "autocomplete" => "off",
                                "placeholder" => "CPF",
                            ];
                            if (strstr($erro, "CPF")) {
                                $attributes["class"] = "form-control is-invalid";
                            }
                            echo form_input($attributes, set_value("cpf"));
                            ?>
                        </div>
                        <div class="form-group form-primary">
                            <?php
                            $attributes = [
                                "name" => "senha",
                                "id" => "senha",
                                "class" => "form-control",
                                "value" => "",
                                "placeholder" => "Senha",
                            ];
                            if (strstr($erro, "Senha")) {
                                $attributes["class"] = "form-control is-invalid";
                            }
                            echo form_password($attributes);
                            ?>
                            <span class="form-bar"><input type="checkbox" onclick="mostrarSenha()" style="padding-left:10px; margin-top:10px; text-align:center;"> Mostrar senha </span>
                        </div>
                        <div class="text-center center-block">
                            <?php
                            $attributes = [
                                "class" =>
                                    "btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase",
                                "style" => "width:60%",
                            ];
                            echo form_submit("logar_sistema", "Login", $attributes);
                            ?>
                            <button type="button" name="cadastrar" class="btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase" style="width:60%"><a href="/candidato">Cadastre-se</a></button>
                        </div>
                        <hr>
                        <div class="row m-t-25 text-center">
                            <div class="col-12">
                                <a href="">Esqueceu sua senha?</a><br/>
                                <a href="" class="kt-login__link" alt="Fale conosco">Fale conosco</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php form_close() ?>
        </div>
    </div>
                    <div class="text-center" style="margin-top: 10px">
                            <br/>SUGESP - Fundação Lemann - Pencillabs
                    </div>
                </div>
            </div>
</section>

<?php //   echo "
//   if ($menu2 == 'index' || $menu2 == 'recuperar') {
//       $attributes = array('name' => 'cpf',
//                               'id' => 'cpf',
//                               'type' => 'tel',
//                               'maxlength'=>'14',
//                               'class' => 'form-control',
//                               'autocomplete'=>'off',
//                               'placeholder'=>'CPF');
//       if (strstr($erro, 'CPF')) {
//           $attributes['class'] = 'form-control is-invalid';
//       }
//       echo form_input($attributes, set_value('cpf'));
//       echo "
//                                                   <span class=\"form-bar\"></span>
//                                               </div>";
//   }
//   if ($menu2 == 'contato') {
//       echo "
//                                               <div class=\"form-group form-primary\">
//                                                                                   ";
//       $attributes = array('name' => 'nome',
//                               'id' => 'nome',
//                               'maxlength'=>'100',
//                               'class' => 'form-control',
//                               'placeholder'=>'Nome completo');
//       echo form_input($attributes, set_value('nome'));
//       echo "
//                                               </div>
//                                               <div class=\"form-group form-primary\">
//                                                                                   ";
//       $attributes = array('name' => 'email',
//                               'id' => 'email',
//                               'maxlength'=>'100',
//                               'class' => 'form-control',
//                               'placeholder'=>'E-mail');
//       echo form_input($attributes, set_value('email'));
//       echo "
//                                               </div>
//                                               <div class=\"form-group form-primary\">
//                                                                                   ";
//       $attributes = array('name' => 'assunto',
//                               'id' => 'assunto',
//                               'maxlength'=>'100',
//                               'class' => 'form-control',
//                               'placeholder'=>'Assunto');
//       echo form_input($attributes, set_value('assunto'));
//       echo "
//                                               </div>
//                                               <div class=\"form-group form-primary\">
//                                                                                   ";
//       $attributes = array('name' => 'msg',
//                               'id' => 'msg',
//                               'rows'=>'3',
//                               'class' => 'form-control',
//                               'placeholder' => 'Mensagem',
//                               'style' => 'height:100px');
//       echo form_textarea($attributes, set_value('msg'));
//
//       echo '<div class="text-center center-block"><br />';
//       $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
//                               'style'=>'width:60%');
//       echo form_submit('Publico/contato', 'Enviar', $attributes);
//       echo '
//           <hr />
//           <a
//           href="'.base_url("Publico/index").'"
//           >
//           Voltar
//           </a>
//           ';
//       echo '</div>';
//       echo "
//                                               </div>
//                                           </div>";
//   }
//   elseif ($menu2 == 'recuperar') {
//       echo "
//                                               <div class=\"text-center center-block\">";
//       $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
//                               'style'=>'width:60%');
//       echo form_submit('enviado', 'Recuperar', $attributes);
//       echo "
//                                               </div>
//                                               <hr>
//                                               <div class=\"row m-t-25 text-center\">
//                                                       <div class=\"col-12\">
//                                                               <a href=\"".base_url('Publico/index')."\">Login</a>
//                                                       </div>
//                                               </div>";
//   } elseif ($menu2 == 'recuperar') {
//       echo "
//                                               <div class=\"text-center center-block\">";
//       $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
//                               'style'=>'width:60%');
//       echo form_submit('enviado', 'Enviar', $attributes);
//       echo "
//                                               </div>
//                                               <hr>
//                                               <div class=\"row m-t-25 text-center\">
//                                                       <div class=\"col-12\">
//                                                               <a href=\"".base_url('Publico/index')."\">Login</a>
//                                                       </div>
//                                               </div>";
//   }
$pagina["js"] = "
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
//$this -> load -> view('templates/publicoRodape', $pagina);
