<?php

defined("BASEPATH") or exit("No direct script access allowed");

	echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" " .
		($inativo == 1 ? "checked=\"checked\" " : "") .
		" /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Instituição</th>
                                                                                            <th>Grupo</th>
                                                                                            <th>Status da vaga</th>
                                                                                            <th>Início inscrição</th>
                                                                                            <th>Fim inscrição</th>";
	/*
    echo "
                                                                                        <th>Questões</th>";
    */
	echo "
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
	//var_dump($vagas);
	if (isset($vagas)) {
		$atual = time();
		foreach ($vagas as $linha) {
			$dt_inicio = strtotime($linha->dt_inicio);
			$dt_fim = strtotime($linha->dt_fim);
			echo "
                                                                                    <tr>
                                                                                            <td>" .
				$linha->vc_vaga .
				"</td>
                                                                                            <td class=\"text-center\">" .
				$linha->vc_sigla .
				"</td>
                                                                                            <td>" .
				$linha->vc_grupovaga .
				"</td>
                                                                                            <td>";

			//echo ($linha -> bl_liberado == '1'?'Sim':'Não');
			if ($linha->bl_removido == "0") {
				if ($linha->bl_liberado != "1") {
					echo "Não liberada";
				} elseif ($linha->bl_finalizado == "1") {
					echo "Processo concluído";
				} else {
					if ($dt_fim > $atual) {
						echo "Liberada para inscrição";
					} else {
						if (isset($aguardando_decisao[$linha->pr_vaga])) {
							echo "Aguardando decisão final";
						} else {
							echo "Candidaturas sobre análise";
						}
					}
				}
			} else {
				echo "Vaga removida";
			}
			echo "</td>    
                                                                                            <td class=\"text-center\" data-search=\"" .
				show_date($linha->dt_inicio) .
				"\" data-order=\"$dt_inicio\">" .
				show_date($linha->dt_inicio, true) .
				"</td>
                                                                                            <td class=\"text-center\" data-search=\"" .
				show_date($linha->dt_fim) .
				"\" data-order=\"$dt_fim\">" .
				show_date($linha->dt_fim, true) .
				"</td>";
			/*
            echo "
                                                                                <td class=\"text-center\">".$linha -> cont."</td>";
            */
			echo "
                                                                                            <td class=\"text-center\">";
			if ($linha->bl_removido == "0") {
				if ($atual > $dt_fim) {
					//if(isset($selecao_entrevista[$linha -> pr_vaga])){
					//echo anchor('Vagas/selecionar_entrevista/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-edit"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Selecionar candidatos\"");
					//}
					//echo anchor('Vagas/visualizar_nota/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Visualizar candidato\"");
					echo anchor(
						"Vagas/resultado/" . $linha->pr_vaga,
						'<i class="fa fa-lg mr-0 fa-sort-amount-down">Resultados</i>',
						" class=\"btn btn-sm btn-square btn-info\" title=\"Resultados\""
					);
				}
				if ($linha->bl_finalizado != "1" && $this->session->perfil != "avaliador") {
					echo anchor(
						"Vagas/edit/" . $linha->pr_vaga,
						'<i class="fa fa-lg mr-0 fa-edit">Editar</i>',
						" class=\"btn btn-sm btn-square btn-warning\" title=\"Editar vaga\""
					);
					if (!($linha->bl_liberado == "1")) {
						echo anchor(
							"Vagas/liberar_vaga/" . $linha->pr_vaga,
							'<i class="fa fa-lg mr-0 fa-check-square">Liberar para inscrição</i>',
							" class=\"btn btn-sm btn-square btn-primary\" title=\"Liberar para inscrição\""
						);
					}
					echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar vaga\" onclick=\"confirm_delete(" .
						$linha->pr_vaga .
						");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar</i></a>";
				}
			} else {
				echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar vaga\" onclick=\"confirm_reactivate(" .
					$linha->pr_vaga .
					");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Reativar</i></a>";
			}

			echo "
                                                                                            </td>
                                                                                    </tr>";
		}
	}
	echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

	$pagina["js"] =
		"
                                            <script type=\"text/javascript\">
                                                    function check_inativo(){
                                                            if(document.getElementById('inativo').checked == true){
                                                                    $(location).attr('href', '" .
		base_url("Vagas/index/") .
		"1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '" .
		base_url("Vagas/index/") .
		"')        
                                                            }
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'A vaga em questão será marcada como desativada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/delete/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'A vaga em questão voltará a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reactivate/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [0, 'asc']
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
                                            </script>";

