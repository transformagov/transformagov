<?php

defined("BASEPATH") or exit("No direct script access allowed");


	if (strlen($erro) > 0) {
		echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>"; //$erro='';
	} elseif (strlen($sucesso) > 0) {
		echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
	}
	if (strlen($sucesso) == 0) {
		$attributes = ["id" => "form_gruposvagas"];
		if ($menu2 == "edit" && isset($codigo) && $codigo > 0) {
			echo form_open($url, $attributes, ["codigo" => $codigo]);
		} else {
			echo form_open($url, $attributes);
		}
		echo "
                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label('Nome <abbr title="Obrigatório">*</abbr>', "nome", $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
		if (
			!isset($vc_grupovaga) ||
			(strlen($vc_grupovaga) == 0 && strlen(set_value("nome")) > 0)
		) {
			$vc_grupovaga = set_value("nome");
		}
		$attributes = ["name" => "nome", "maxlength" => "250", "class" => "form-control"];
		if (strstr($erro, "'Nome'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		echo form_input($attributes, $vc_grupovaga);
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label(
			'Instituição <abbr title="Obrigatório">*</abbr>',
			"instituicao",
			$attributes
		);
		echo "
                                                                            <div class=\"col-lg-6\">";
		if (
			!isset($es_instituicao) ||
			(strlen($es_instituicao) == 0 && strlen(set_value("instituicao")) > 0)
		) {
			$es_instituicao = set_value("instituicao");
		}
		$vazio = ["" => ""];
		$valores =
			$vazio +
			$instituicoes; /*foreach($instituicoes as $opcao){
                $valores[] = $opcao;
        }*/
		if (strstr($erro, "'instituicao'")) {
			echo form_dropdown(
				"instituicao",
				$valores,
				$es_instituicao,
				"class=\"form-control is-invalid\" id=\"instituicao\""
			);
		} else {
			echo form_dropdown(
				"instituicao",
				$valores,
				$es_instituicao,
				"class=\"form-control\" id=\"instituicao\""
			);
		}
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                    <div class=\"col-lg-12 text-center\">";
		$attributes = [
			"class" => "btn btn-primary",
		];
		echo form_submit("salvar_grupo", "Salvar", $attributes);
		echo "
                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='" .
			base_url("GruposVagas/index") .
			"'\">Cancelar</button>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </form>";
		$pagina["js"] = "
        <script type=\"text/javascript\">
            $('#inicio').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
            $('#fim').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
        </script>";
	}

