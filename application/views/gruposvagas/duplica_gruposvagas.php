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
		echo form_open($url, $attributes, ["codigo" => $codigo]);
		echo "
                                                                <div class=\"form-group row\">";
		$attributes = ["class" => "col-lg-1 col-form-label text-left"];
		echo form_label(
			'Grupo de vaga de destino <abbr title="Obrigatório">*</abbr>',
			"grupo",
			$attributes
		);
		echo "
                                                                        <div class=\"col-lg-8\">";
		$grupo = "";
		if (strlen(set_value("grupo")) > 0) {
			$grupo = set_value("grupo");
		}
		$array_grupos = ["" => ""];
		foreach ($grupos as $grupo) {
			if ($codigo != $grupo->pr_grupovaga) {
				$array_grupos[$grupo->pr_grupovaga] = $grupo->vc_grupovaga;
			}
		}
		if (strstr($erro, "'Grupo'")) {
			echo form_dropdown(
				"grupo",
				$array_grupos,
				$grupo,
				"class=\"form-control is-invalid\" id=\"grupo\""
			);
		} else {
			echo form_dropdown(
				"grupo",
				$array_grupos,
				$grupo,
				"class=\"form-control\" id=\"grupo\""
			);
		}
		echo "
                                                                        </div>
                                                                        <div class=\"col-lg-3 text-right\">
                ";
		$attributes = ["class" => "btn btn-primary", "id" => "salvar_grupo"];
		echo form_submit("salvar_grupo", "Duplicar selecionadas", $attributes);
		echo "
                                                                        </div>
                                                                </div>
                                                                                                           
                                                                <div class=\"form-group row\">
                                                                        <div class=\"col-lg-12\">
                                                                                <a href=\"#\" onclick=\"check_all();\"> Marcar todas</a> &nbsp; <a href=\"#\" onclick=\"uncheck_all();\"> Desmarcar todas</a>
                                                                        </div>
                                                                </div>

                                                                <div class=\"dt-responsive table-responsive\">
                                                                            
                                                                        <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
                                                                                <thead>
                                                                                        <tr>
                                                                                                <th>Selecionar</th>
                                                                                                <th>Questão duplicada</th>
                                                                                                <th>Etapa</th>
                                                                                                <th>Enunciado</th>
                                                                                                <th>Tipo</th>
                                                                                                <th>Peso</th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                            ";
		foreach ($questoes as $questao) {
			// &nbsp; <a href=\"".base_url('GruposVagas/historico_duplicate/'.$codigo)."\">Histórico de duplicações</a>
			// if($questao -> cont_respostas > 0 || $cont_vagas == 0){
			echo "    
                                                                                        <tr>
                                                                                                <td>";
			$attributes = [
				"id" => "questao" . $questao->pr_questao,
				"name" => "questao" . $questao->pr_questao,

				"value" => "1",
			]; //$attributes['disabled'] = 'disabled';
			echo form_checkbox(
				$attributes,
				set_value("questao" . $questao->pr_questao),
				set_value("questao" . $questao->pr_questao) == "1" &&
					strlen(set_value("questao" . $questao->pr_questao)) > 0
			);
			echo "</td>
                                                                                                <td>
                                                                                                        " .
				($questao->bl_duplicado == "1" ? "Sim" : "Não") .
				"
                                                                                                </td>
                                                                                                <td>
                                                                                                        " .
				$questao->es_etapa .
				"ª Etapa
                                                                                                </td>
                                                                                                <td>
                                                                                                        {$questao->tx_questao}
                                                                                                </td>
                                                                                                <td>";
			if ($questao->in_tipo == 1) {
				echo "Customizadas";
			} elseif ($questao->in_tipo == 2) {
				echo "Aberta";
			} elseif ($questao->in_tipo == 3) {
				echo "Sim/Não (sim positivo)";
			} elseif ($questao->in_tipo == 4) {
				echo "Sim/Não (não positivo)";
			} elseif ($questao->in_tipo == 5) {
				echo "Nenhum/Básico/Intermediário/Avançado";
			} elseif ($questao->in_tipo == 6) {
				echo "Intervalo";
			} elseif ($questao->in_tipo == 7) {
				echo "Upload de arquivo";
			}
			echo "</td>
                                                                                                <td>
                                                                                                        {$questao->in_peso}
                                                                                                </td>
                                                                                        </tr>";
			// }
		}
		echo "
                                                                                </tbody>
                                                                        </table>
                                                                            
                                                                </div>
                                                                
                                                            </form>";
		//paginação retirada pois impede a escolha de todas as questões "check_all"
		$pagina["js"] = "
                                                            <script type=\"text/javascript\">

                                                                        function check_all(){
                                                                                $(':checkbox').prop('checked', true);
                                                                        }
                                                                        function uncheck_all(){
                                                                                $(':checkbox').prop('checked', false);
                                                                        }
                                                                        jQuery(':submit').click(function (event) {
                                                                                var form = document.getElementById('form_gruposvagas');
                                                                                var se_repetido = 0;
                                                                                if(form.elements['grupo'].value==''){
                                                                                        event.preventDefault();
                                                                                        alert('O grupo de destino deve ser escolhido.');
                                                                                        return;
                                                                                }
                                                                                var se_escolhido = 0;

                
                                                                                ";
		if (is_array($questoes_duplicadas)) {
			foreach ($questoes_duplicadas as $questao_duplicada) {
				$pagina["js"] .=
					"
                                                                                        if(form.elements['questao{$questao_duplicada->es_questao_origem}'] && form.elements['questao{$questao_duplicada->es_questao_origem}'].checked == true && form.elements['grupo'] && form.elements['grupo'].value == '" .
					$questao_duplicada->es_grupovaga_destino .
					"'){
                                                                                                se_repetido = 1;
                                                                                                                                                                
                                                                                        }
                                                                                        
                                ";
			}
		}
		foreach ($questoes as $questao) {
			// if($questao -> cont_respostas > 0 || $cont_vagas == 0){
			$pagina["js"] .= "
                                                                                if(form.elements['questao{$questao->pr_questao}'] && form.elements['questao{$questao->pr_questao}'].checked == true){
                                                                                        se_escolhido = 1;
                                                                                                                                                         
                                                                                }
                                                                                
                                ";
			// }
		}
		$pagina["js"] .=
			"
                                                                                if(se_escolhido==0){
                                                                                        event.preventDefault();
                                                                                        alert('Ao menos uma questão deve ser escolhida.');
                                                                                        return;
                                                                                }

                                                                                var titulo = 'Confirmação de duplicação';
                                                                                var grupo = form.elements['grupo'];
                                                                                var texto = 'Deseja confirmar a duplicação das questões selecionadas para o grupo: <u>'+grupo.options[grupo.selectedIndex].text+'</u>?';
                                                                                if(se_repetido == 1){
                                                                                        titulo = 'Aviso de duplicação';
                                                                                        texto = 'Existe questão(s) já duplicada para o grupo <u>'+grupo.options[grupo.selectedIndex].text+'</u>, deseja prosseguir?';
                                                                                }
                                                                                if (this.id == 'salvar_grupo') {
                                                                                        event.preventDefault();
                                                                                        $(document).ready(function(){
                                                                                                event.preventDefault();
                                                                                                swal.fire({
                                                                                                        title: titulo,                                                                                                        
                                                                                                        html: texto,                                                                                                        
                                                                                                        type: 'warning',
                                                                                                        showCancelButton: true,
                                                                                                        cancelButtonText: 'Não',
                                                                                                        confirmButtonText: 'Sim, desejo salvar'
                                                                                                })
                                                                                                .then(function(result) {
                                                                                                        if (result.value) {
                                                                                                                //desfaz as configurações do botão
                                                                                                                $('#salvar_grupo').unbind(\"click\");
                                                                                                                //clica, concluindo o processo
                                                                                                                $('#salvar_grupo').click();
                                                                                                        }
                                                                                                        
                                                                                                });
                                                                                                
                                                                                                
                                                                                        });
                                                                                                                                                                                                                                                                }
                                                                        });
                                                                        

                                                            </script>
                                                            
                                                            <script type=\"text/javascript\">
                                                                jQuery('#questoes_table input:checkbox').change(function() {

                                                                        if(this.checked)  // check if checkbox checked then change color of row
                                                         
                                                                                jQuery(this).closest('td').css('background-color', '#6f6 !important');
                                                                        else
                                                                                jQuery(this).closest('td').css('background-color', '');
                                                         
                                                                 });
                                                                    $('#questoes_table').DataTable({
                                                                            order: [
                                                                                [2, 'asc']
                                                                            ],
                                                                            columnDefs: [
                                                                                    {
                                                                                        'orderable': false,
                                                                                        'targets': [-1]
                                                                                    },
                                                                                    {
                                                                                        'searchable': false,
                                                                                        'targets': [-1]
                                                                                    }
                                                                            ],
                                                                            'rowCallback': function(row, data, index){
                                                                                if(data[1] == 'Sim'){
                                                                                    $(row).find('td:eq(1)').css('background-color', '#f66');
                                                                                }
                                                                                
                                                                              },
                                                                            lengthMenu: [
                                                                                [-1],
										[\"Todos\"]
                                                                            ],
                                                                            language: {
                                                                                        \"decimal\":        \"\",
                                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                                        \"infoPostFix\":    \"\",
                                                                                        \"thousands\":      \",\",
                                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                                        \"loadingRecords\": \"Carregando...\",
                                                                                        \"processing\":     \"Carregando...\",
                                                                                        \"search\":         \"Pesquisar:\",
                                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                                        
                                                                                        \"paginate\": {
                                                                                            \"first\":      \"Primeira\",
                                                                                            \"last\":       \"Última\",
                                                                                            \"next\":       \"Próxima\",
                                                                                            \"previous\":   \"Anterior\"
                                                                                        },
                                                                                        \"aria\": {
                                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                                        }
                                                                            }
                                                                    });
                                                                    $(document).ready(function(){
 
                                                                        $('#grupo').change(function(){
                                                                                var grupo = $(this).val();
                                                                                
                                                                                $.ajax({
                                                                                        url:'" .
			base_url("GruposVagas/getEtapa") .
			"',
                                                                                        method: 'post',
                                                                                        data : {grupo:grupo},
                                                                                        dataType: 'json',
                                                                                        success: function(response){
                                                                                                var len = response.length;
                                                                                                
                                                                                                
                                                                                                        // Read values
                                                                                                ";
		foreach ($questoes as $questao) {
			$pagina["js"] .=
				"
                                                                                                        
                                                                                                        if(response[" .
				$questao->es_etapa .
				"] == 1){
                                                                                                                
                                                                                                                $('#questao" .
				$questao->pr_questao .
				"').prop('checked', false);
                                                                                                                $('#questao" .
				$questao->pr_questao .
				"').prop('disabled', 'disabled');
                                                                                                        }
                                                                                                        else{
                                                                                                                $('#questao" .
				$questao->pr_questao .
				"').prop('disabled','');
                                                                                                        }
                        ";
		}

		$pagina["js"] .= "
                                                                                        
                                                                                                
                                                                                
                                                                                        }
                                                                                });
                                                                        });
                                                                    });
                                                            </script>";
	}

