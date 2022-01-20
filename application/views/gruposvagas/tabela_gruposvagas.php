<?php

defined("BASEPATH") or exit("No direct script access allowed");
	echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" " .
		($inativo == 1 ? "checked=\"checked\" " : "") .
		" /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"gruposvagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Instituição</th>
                                                                                            <th>Vagas</th>
                                                                                            <th>Questões</th>
                                                                                            <th>Status</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>"; //var_dump($grupos);
	if (isset($grupos)) {
		foreach ($grupos as $linha) {
			echo "
                                                                                    <tr>
                                                                                            <td class=\"align-middle\">" .
				$linha->vc_grupovaga .
				"</td>
                                                                                            <td class=\"align-middle text-center\">" .
				$linha->vc_sigla .
				"</td>
                                                                                            <td class=\"align-middle text-center\">" .
				$linha->cont_vagas .
				"</td>
                                                                                            <td class=\"align-middle text-center\">" .
				$linha->cont_questoes .
				"</td>";
			if ($linha->bl_removido == "0") {
				echo "
                                                                                            <td class=\"align-middle text-center\"><span class=\"badge badge-success badge-lg\">Ativo</span></td>";
			} else {
				echo "
                                                                                            <td class=\"align-middle text-center\"><span class=\"badge badge-danger badge-lg\">Desativado</span></td>";
			}
			echo "
                                                                                            <td class=\"align-middle text-center\" style=\"white-space:nowrap\">";
			if ($linha->bl_removido == "0") {
				/*
                echo anchor('Questoes/index/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-check-square">Definir questões</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Definir questões\"");
                echo anchor('GruposVagas/edit/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-edit">Editar</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar grupo\"");
                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar grupo de vagas\" onclick=\"confirm_delete(".$linha -> pr_grupovaga.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar</i></a>";
                echo anchor('GruposVagas/duplicate/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-check-square">Duplicar questões</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Duplicar questões\"");
                if($linha -> etapa7 == '0'){
                        echo anchor('GruposVagas/create_motivacao/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-check-square">Criar questões do formulário de motivação</i>', " class=\"btn btn-sm btn-square btn-danger\" title=\"Criar questões do formulário de motivação\"");
                }
                */ echo '
                                <div class="input-group-prepend">
                                        <button
                                                class="btn btn-square btn-outline-secondary dropdown-toggle"
                                                type="button"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                        >
                                                Selecione uma ação
                                        </button>
                                        <div class="dropdown-menu">
                                '; // Definir questões
				echo anchor(
					"Questoes/index/" . $linha->pr_grupovaga,
					'<i class="fa fa-lg mr-0 fa-check-square">Definir questões</i>',
					" class=\"btn btn-sm dropdown-item\" title=\"Definir questões\""
				);
				// Editar
				echo anchor(
					"GruposVagas/edit/" . $linha->pr_grupovaga,
					'<i class="fa fa-lg mr-0 fa-edit">Editar</i>',
					" class=\"btn btn-sm dropdown-item\" title=\"Editar grupo\""
				); // Desativar
				echo "<a href=\"javascript:/\" class=\"btn btn-sm dropdown-item\" title=\"Desativar grupo de vagas\" onclick=\"confirm_delete(" .
					$linha->pr_grupovaga .
					");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar</i></a>"; // Duplicar questões
				echo anchor(
					"GruposVagas/duplicate/" . $linha->pr_grupovaga,
					'<i class="fa fa-lg mr-0 fa-check-square">Duplicar questões</i>',
					" class=\"btn btn-sm dropdown-item\" title=\"Duplicar questões\""
				);
				if ($linha->etapa7 == "0") {
					// Criar questões do formulário de motivação
					echo anchor(
						"GruposVagas/create_motivacao/" . $linha->pr_grupovaga,
						'<i class="fa fa-lg mr-0 fa-check-square">Criar questões do formulário de motivação</i>',
						" class=\"btn btn-sm dropdown-item\" title=\"Criar questões do formulário de motivação\""
					);
				}
				echo '</div>
                                </div>';
			} else {
				echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar grupo de vagas\" onclick=\"confirm_reactivate(" .
					$linha->pr_grupovaga .
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
		base_url("GruposVagas/index/") .
		"1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '" .
		base_url("GruposVagas/index/") .
		"')        
                                                            }
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'O grupo de vagas em questão será marcada como desativado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("GruposVagas/delete/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'O grupo de vagas em questão voltará a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("GruposVagas/reactivate/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#gruposvagas_table').DataTable({
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

