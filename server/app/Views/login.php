<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex justify-content-center">
                <?php
                $attributes = ["class" => "md-float-material form-material"];
                echo form_open("Publico/realiza_login", $attributes);
                ?>
                <div class="text-center">
                    <?php echo img(['src' => 'images/logo-descricao.png', 'alt' => 'TransformaGov']) ?>
                </div>
                <div class="card col-lg-12 mt-3 p-3 mx-auto">
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
                    <div class="organizations text-center white">
                            <br/>SUGESP - Fundação Lemann - Pencillabs
                    </div>
                </div>
            </div>
</section>

<script>
    function mostrarSenha() {
        var x = document.getElementById("senha");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    $(document).ready(function() {
        var selector = document.getElementById("cpf");
        Inputmask('999.999.999-99').mask(selector);
    });
</script>
