<?php

defined("BASEPATH") or exit("No direct script access allowed");

	if (strlen($erro) > 0) {
		echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
		//$erro='';
	} elseif (strlen($sucesso) > 0) {
		echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
	}
	if (strlen($sucesso) == 0) {
		if (isset($dt_inicio)) {
			$inicio = strtotime($dt_inicio);
		} else {
			$inicio = 0;
		}

		$atual = time();

		if (!isset($bl_liberado)) {
			$bl_liberado = "0";
		}
		$attributes = ["class" => "kt-form", "id" => "form_vagas"];
		if ($menu2 == "edit" && isset($codigo) && $codigo > 0) {
			echo form_open($url, $attributes, ["codigo" => $codigo]);
		} else {
			echo form_open($url, $attributes);
		}
		echo "
                                                                            <div class=\"kt-portlet__body\">
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label('Nome <abbr title="Obrigatório">*</abbr>', "nome", $attributes);
		echo "
                                                                                            <div class=\"col-lg-6\">";
		if (!isset($vc_vaga) || (strlen($vc_vaga) == 0 && strlen(set_value("nome")) > 0)) {
			$vc_vaga = set_value("nome");
		}

		$attributes = ["name" => "nome", "maxlength" => "250", "class" => "form-control"];

		if (strstr($erro, "'Nome'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		if ($bl_liberado == "1" && $atual > $inicio) {
			$attributes[
				"onclick"
			] = "this.value = '{$vc_vaga}';alert('Não pode modificar o nome uma vaga já liberada para inscrições!')";
		}
		echo form_input($attributes, $vc_vaga);
		echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label('Descrição <abbr title="Obrigatório">*</abbr>', "descricao", $attributes);
		echo "
                                                                                                    <div class=\"col-lg-6\">";
		if (
			!isset($tx_descricao) ||
			(strlen($tx_descricao) == 0 && strlen(set_value("descricao")) > 0)
		) {
			$tx_descricao = set_value("descricao");
		}
		$attributes = ["name" => "descricao", "rows" => "3", "class" => "form-control"];
		if (strstr($erro, "'Descrição'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		if ($bl_liberado == "1" && $atual > $inicio) {
			$attributes[
				"onclick"
			] = "this.value = '{$tx_descricao}';alert('Não pode modificar a descrição de uma vaga já liberada para inscrições!')";
		}
		echo form_textarea($attributes, $tx_descricao);
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
                                                                                            <div class=\"col-lg-3\">";
		$instituicoes = [0 => ""] + $instituicoes;
		if (
			!isset($es_instituicao) ||
			(strlen($es_instituicao) == 0 && strlen(set_value("instituicao")) > 0)
		) {
			$es_instituicao = set_value("instituicao");
		}
		if ($bl_liberado == "1" && $atual > $inicio) {
			echo form_dropdown(
				"instituicao",
				$instituicoes,
				$es_instituicao,
				"class=\"form-control\" onchange=\"this.value = '{$es_instituicao}';alert('Não pode modificar a instituição de vaga de uma vaga já liberada para inscrições!')\""
			);
		} elseif (strstr($erro, "'Instituição'")) {
			echo form_dropdown(
				"instituicao",
				$instituicoes,
				$es_instituicao,
				"class=\"form-control is-invalid\""
			);
		} else {
			echo form_dropdown(
				"instituicao",
				$instituicoes,
				$es_instituicao,
				"class=\"form-control\""
			);
		}
		echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label('Grupo da vaga <abbr title="Obrigatório">*</abbr>', "grupo", $attributes);
		echo "
                                                                                            <div class=\"col-lg-5\">";
		//var_dump($grupos);
		foreach ($grupos as $linha) {
			$dados_grupos[$linha->pr_grupovaga] = $linha->vc_grupovaga;
		}
		if (!isset($dados_grupos)) {
			$dados_grupos = [];
		}
		$dados_grupos = [0 => ""] + $dados_grupos;
		if (
			!isset($es_grupoVaga) ||
			(strlen($es_grupoVaga) == 0 && strlen(set_value("grupo")) > 0)
		) {
			$es_grupoVaga = set_value("grupo");
		}

		if ($bl_liberado == "1" && $atual > $inicio) {
			echo form_dropdown(
				"grupo",
				$dados_grupos,
				$es_grupoVaga,
				"class=\"form-control\"  onchange=\"this.value = '{$es_grupoVaga}';alert('Não pode modificar o grupo de vaga de uma vaga já liberada para inscrições!')\""
			);
		} else {
			if (strstr($erro, "'Grupo da vaga'")) {
				echo form_dropdown(
					"grupo",
					$dados_grupos,
					$es_grupoVaga,
					"class=\"form-control is-invalid\""
				);
			} else {
				echo form_dropdown("grupo", $dados_grupos, $es_grupoVaga, "class=\"form-control\"");
			}
		}
		echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label(
			'Início das inscrições <abbr title="Obrigatório">*</abbr>',
			"inicio",
			$attributes
		);
		echo "
                                                                                            <div class=\"col-lg-3\">";
		if (!isset($dt_inicio) || (strlen($dt_inicio) == 0 && strlen(set_value("inicio")) > 0)) {
			$dt_inicio = show_sql_date(set_value("inicio"), true);
		}
		$attributes = ["name" => "inicio", "id" => "inicio", "class" => "form-control"];
		if (strstr($erro, "'Início das inscrições'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		if ($bl_liberado == "1" && $atual > $inicio) {
			$attributes["onclick"] =
				"this.value = '" .
				show_date($dt_inicio, true) .
				"';alert('Não pode modificar a data de início de uma vaga já liberada para inscrições!')";
		}
		echo form_input($attributes, show_date($dt_inicio, true));
		echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label text-right"];
		echo form_label(
			'Término das inscrições <abbr title="Obrigatório">*</abbr>',
			"fim",
			$attributes
		);
		echo "
                                                                                            <div class=\"col-lg-3\">";
		if (!isset($dt_fim) || (strlen($dt_fim) == 0 && strlen(set_value("inicio")) > 0)) {
			$dt_fim = show_sql_date(set_value("fim"), true);
		}
		$attributes = ["name" => "fim", "id" => "fim", "class" => "form-control"];
		if (strstr($erro, "'Término das inscrições'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		echo form_input($attributes, show_date($dt_fim, true));

		echo "
                                                                                            </div>
                                                                                    </div>";

		/*echo "
                                                                            <div class=\"form-group row\">";
        $attributes = array('class' => 'col-lg-3 col-form-label text-right');
        echo form_label('Tipo de vaga <abbr title="Obrigatório">*</abbr>', 'brumadinho', $attributes);
        echo "
                                                                                    <div class=\"col-lg-5\">";

        $dados_tipo=array('0' => 'Transforma Minas','1' => 'Editais');
        if(!isset($bl_brumadinho) || (strlen($bl_brumadinho) == 0 && strlen(set_value('brumadinho')) > 0)){
                $bl_brumadinho = set_value('brumadinho');
        }


        if(strstr($erro, "'Tipo de vaga'")){
                echo form_dropdown('brumadinho', $dados_tipo, $bl_brumadinho, "class=\"form-control is-invalid\"");
        }
        else{
                echo form_dropdown('brumadinho', $dados_tipo, $bl_brumadinho, "class=\"form-control\"");
        }

        echo "
                                                                                    </div>
                                                                            </div>";*/

		echo "
                                                                                    <div class=\"row\" style=\"margin-top: 20px; margin-bottom: 10px;\">
                                                                                            <legend>Avaliadores de currículo</legend>
                                                                                            
                ";

		foreach ($usuarios as $usuario) {
			echo "
                                                                                    
                                                                                            <div class=\"col-md-12\">";
			$attributes = ["class" => "col-lg-3 col-form-label text-right"];

			echo form_label($usuario->vc_nome, "usuario" . $usuario->pr_usuario, $attributes);
			if (
				!isset($avaliador[$usuario->pr_usuario]) ||
				(strlen($avaliador[$usuario->pr_usuario]) == 0 &&
					strlen(set_value("usuario" . $usuario->pr_usuario)) > 0)
			) {
				$avaliador[$usuario->pr_usuario] = show_sql_date(
					set_value("usuario" . $usuario->pr_usuario),
					true
				);
			}
			if ($avaliador[$usuario->pr_usuario] == $usuario->pr_usuario) {
				echo form_checkbox("usuario" . $usuario->pr_usuario, $usuario->pr_usuario, true);
			} else {
				echo form_checkbox("usuario" . $usuario->pr_usuario, $usuario->pr_usuario, false);
			}

			echo "</div>
                                                                                    ";
		}
		echo "
                                                                                    
                                                                                    
                                                                                    </div>         
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div class=\"row\">
                                                                                            <div class=\"col-lg-12 text-center\">";
		$attributes = ["class" => "btn btn-primary"];
		echo form_submit("salvar_vaga", "Salvar", $attributes);
		echo "
                                                                                                    <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='" .
			base_url("Vagas/index") .
			"'\">Cancelar</button>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
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

