<?php

defined("BASEPATH") or exit("No direct script access allowed");
	//agendamento da entrevista
	if (strlen($erro) > 0) {
		echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
		//$erro='';
	} elseif (strlen($sucesso) > 0) {
		echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
	}
	if (strlen($sucesso) == 0) {
		$attributes = ["class" => "kt-form", "id" => "form_avaliacoes"];
		echo form_open($url, $attributes, [
			"codigo" => $codigo,
			"tipo_entrevista" => $tipo_entrevista,
		]);
		echo "
                                                                            <div class=\"kt-portlet__body\">";
		echo form_fieldset("Dados da candidatura");
		echo "
                                                                                    <div class=\"row\">";
		$attributes = ["class" => "col-lg-3 direito bolder"];
		echo form_label("Candidato(a):", "NomeCompleto", $attributes);
		echo "
                                                                                            <div class=\"col-lg-9\">";
		echo $candidato->vc_nome;
		echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
		$attributes = ["class" => "col-lg-3 direito bolder"];
		echo form_label("E-mail:", "Email", $attributes);
		echo "
                                                                                            <div class=\"col-lg-9\">";
		echo $candidato->vc_email;
		echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
		$attributes = ["class" => "col-lg-3 direito bolder"];
		echo form_label("Telefone(s):", "Telefones", $attributes);
		echo "
                                                                                            <div class=\"col-lg-6\">";
		echo $candidato->vc_telefone;
		if (strlen($candidato->vc_telefoneOpcional) > 0) {
			echo " - " . $candidato->vc_telefoneOpcional;
		}
		echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
		$attributes = ["class" => "col-lg-3 direito bolder"];
		echo form_label("Vaga:", "Vaga", $attributes);
		echo "
                                                                                            <div class=\"col-lg-9\">";
		echo $candidatura[0]->vc_vaga;
		echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
		$attributes = ["class" => "col-lg-3 direito bolder"];
		echo form_label("Status da candidatura:", "status", $attributes);
		echo "
                                                                                            <div class=\"col-lg-6\">";
		echo $candidatura[0]->vc_status;
		echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
		echo form_fieldset_close();
		echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
		echo form_fieldset("Entrevista");
		//var_dump($entrevista);
		echo "
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label direito"];
		echo form_label(
			'Avaliador 1 <abbr title="Obrigatório">*</abbr>',
			"avaliador1",
			$attributes
		);
		echo "
                                                                                            <div class=\"col-lg-3\">";
		//var_dump($usuarios);
		//$usuarios=array(0 => '')+$usuarios;
		$dados_usuarios[0] = "";
		foreach ($usuarios as $linha) {
			$dados_usuarios[$linha->pr_usuario] = $linha->vc_nome;
		}
		$avaliador1 = "";
		if (isset($entrevista[0]->es_avaliador1) && strlen($entrevista[0]->es_avaliador1) > 0) {
			$avaliador1 = $entrevista[0]->es_avaliador1;
		}

		if (strlen(set_value("avaliador1")) > 0) {
			$avaliador1 = set_value("avaliador1");
		}
		if (strstr($erro, "'Avaliador 1'")) {
			echo form_dropdown(
				"avaliador1",
				$dados_usuarios,
				$avaliador1,
				"class=\"form-control is-invalid\" id=\"avaliador1\""
			);
		} else {
			echo form_dropdown(
				"avaliador1",
				$dados_usuarios,
				$avaliador1,
				"class=\"form-control\" id=\"avaliador1\""
			);
		}
		echo "
                                                                                            </div>
                                                                                    </div>";
		if ($tipo_entrevista == "competencia") {
			echo "
                                                                                    <div class=\"form-group row\">";
			$attributes = ["class" => "col-lg-3 col-form-label direito"];
			echo form_label(
				'Avaliador 2 <abbr title="Obrigatório">*</abbr>',
				"avaliador2",
				$attributes
			);
			echo "
                                                                                                    <div class=\"col-lg-3\">";
			//var_dump($usuarios);
			//$usuarios=array(0 => '')+$usuarios;
			$avaliador2 = "";
			if (isset($entrevista[0]->es_avaliador2) && strlen($entrevista[0]->es_avaliador2) > 0) {
				$avaliador2 = $entrevista[0]->es_avaliador2;
			}

			if (strlen(set_value("avaliador2")) > 0) {
				$avaliador2 = set_value("avaliador2");
			}
			if (strstr($erro, "'Avaliador 2'")) {
				echo form_dropdown(
					"avaliador2",
					$dados_usuarios,
					$avaliador2,
					"class=\"form-control is-invalid\" id=\"avaliador2\""
				);
			} else {
				echo form_dropdown(
					"avaliador2",
					$dados_usuarios,
					$avaliador2,
					"class=\"form-control\" id=\"avaliador2\""
				);
			}
			echo "
                                                                                            </div>
                                                                                    </div>";
			if (isset($questoes2)) {
				echo "
                                                                                    <div class=\"form-group row\">";
				$attributes = ["class" => "col-lg-3 col-form-label direito"];
				echo form_label(
					'Data/Horário máximo para preenchimento do teste de aderência <abbr title="Obrigatório">*</abbr>',
					"data2",
					$attributes
				);
				echo "
                                                                                            <div class=\"col-lg-3\">";
				$data_aderencia = "";
				if (
					isset($candidatura[0]->dt_aderencia) &&
					strlen($candidatura[0]->dt_aderencia) > 0
				) {
					$data_aderencia = $candidatura[0]->dt_aderencia;
				}

				if (strlen(set_value("data2")) > 0) {
					$data_aderencia = show_sql_date(set_value("data2"), true);
				}
				$attributes = ["name" => "data2", "id" => "data2", "class" => "form-control"];
				if (strstr($erro, "'Data/Horário máximo'")) {
					$attributes["class"] = "form-control is-invalid";
				}
				echo form_input($attributes, show_date($data_aderencia, true));
				echo "
                                                                                            </div>
                                                                                    </div>";
			}
		}
		echo "
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label direito"];
		echo form_label(
			'Horário da entrevista <abbr title="Obrigatório">*</abbr>',
			"data",
			$attributes
		);
		echo "
                                                                                            <div class=\"col-lg-3\">";
		$data_entrevista = "";
		if (isset($entrevista[0]->dt_entrevista) && strlen($entrevista[0]->dt_entrevista) > 0) {
			$data_entrevista = $entrevista[0]->dt_entrevista;
		}

		if (strlen(set_value("data")) > 0) {
			$data_entrevista = show_sql_date(set_value("data"), true);
		}
		$attributes = ["name" => "data", "id" => "data", "class" => "form-control"];
		if (strstr($erro, "'Horário da entrevista'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		echo form_input($attributes, show_date($data_entrevista, true));
		echo "
                                                                                            </div>
                                                                                    </div>";

		echo "
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label direito"];
		echo form_label(
			'Link para a entrevista <abbr title="Obrigatório">*</abbr>',
			"link",
			$attributes
		);
		echo "
                                                                                            <div class=\"col-lg-3\">";
		$link = "";
		if (isset($entrevista[0]->vc_link) && strlen($entrevista[0]->vc_link) > 0) {
			$link = $entrevista[0]->vc_link;
		}

		if (strlen(set_value("link")) > 0) {
			$link = set_value("link");
		}
		$attributes = [
			"name" => "link",
			"id" => "link",
			"type" => "text",
			"maxlength" => "600",
			"class" => "form-control",
		];
		if (strstr($erro, "'Horário da entrevista'")) {
			$attributes["class"] = "form-control is-invalid";
		}
		echo form_input($attributes, $link);
		echo "
                                                                                            </div>
                                                                                    </div>";

		echo "
                                                                                    <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-3 col-form-label direito"];
		echo form_label("Observações", "link", $attributes);
		echo "
                                                                                            <div class=\"col-lg-3\">";
		$observacoes = "";
		if (isset($entrevista[0]->tx_observacoes) && strlen($entrevista[0]->tx_observacoes) > 0) {
			$observacoes = $entrevista[0]->tx_observacoes;
		}

		if (strlen(set_value("observacoes")) > 0) {
			$observacoes = set_value("observacoes");
		}
		$attributes = [
			"name" => "observacoes",
			"id" => "observacoes",
			"rows" => "4",
			"class" => "form-control",
		];

		echo form_textarea($attributes, $observacoes);

		echo "
                                                                                            </div>
                                                                                    </div>";

		echo form_fieldset_close();
		echo "
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
		$attributes = ["class" => "btn btn-primary"];
		if ($tipo_entrevista == "competencia") {
			if (!isset($questoes2)) {
				$attributes["id"] = "salvar_entrevista";
			}
		}
		echo form_submit("salvar_entrevista", "Salvar", $attributes);
		echo "
                                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='" .
			base_url("Vagas/resultado/" . $candidatura[0]->es_vaga) .
			"'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
		$pagina["js"] = "
                <script type=\"text/javascript\">
                     jQuery(':submit').click(function (event) {
                        if (this.id == 'salvar_entrevista') {
                                event.preventDefault();
                                $(document).ready(function(){
                                        event.preventDefault();
                                        swal.fire({
                                                title: 'Aviso de não inserção dos testes',
                                                text: 'Não existem questões para a etapa de Teste de Aderência e/ou Teste de Motivação, por essa razão eles não estarão disponíveis para o candidato. Deseja continuar?',
                                                type: 'warning',
                                                showCancelButton: true,
                                                cancelButtonText: 'Não',
                                                confirmButtonText: 'Sim, desejo salvar'
                                        })
                                        .then(function(result) {
                                                if (result.value) {
                                                        //desfaz as configurações do botão
                                                        $('#salvar_entrevista').unbind(\"click\");
                                                        //clica, concluindo o processo
                                                        $('#salvar_entrevista').click();
                                                }
                                                
                                        });
                                        
                                        
                        });
                                                                                                                                                                                                        }
                    });
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });";
		if (isset($questoes2)) {
			$pagina["js"] .= "
                    $('#data2').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });";
		}
		$pagina["js"] .= "
                    $('#avaliador1').select2();";
		if ($tipo_entrevista == "competencia") {
			$pagina["js"] .= "
                        $('#avaliador2').select2();";
		}
		$pagina["js"] .= "
                </script>";
	}

	echo "
                                                    </div>
                                            </div>";
