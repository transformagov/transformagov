<?php

defined("BASEPATH") or exit("No direct script access allowed");
	echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            
                                                                                            
                                                                                            <th>Nota - Anál. Curricular</th>
                                                                                            
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
	//var_dump($vagas);
	if (isset($candidaturas)) {
		foreach ($candidaturas as $linha) {
			echo "
                                                                                    <tr>
                                                                                            <td>" .
				$linha->vc_nome .
				"</td>";

			echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">" .
				$linha->vc_status .
				"</span></td>";

			/*
            echo "
                                                                                <td class=\"text-center\">".$linha -> cont."</td>";
            */

			if (!isset($linha->in_nota3) || !(strlen($linha->in_nota3) > 0)) {
				$linha->in_nota3 = 0;
			}

			echo "
                                                                                            
                                                                                            <td class=\"text-center\">" .
				$linha->in_nota3 .
				"</td>
                                                                                            
                                                                                            <td class=\"text-center\">";

			echo anchor(
				"Candidaturas/DetalheAvaliacao/" . $linha->pr_candidatura . "/" . $linha->es_vaga,
				'<i class="fa fa-lg mr-0 fa-search">Detalhes</i>',
				" class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\""
			);
			/*
            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\"></i></a>";
            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar currículo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
            */

			echo anchor(
				"Candidaturas/AvaliacaoCurriculo/" . $linha->pr_candidatura . "/" . $linha->es_vaga,
				'<i class="fa fa-lg mr-0 fa-file-alt">Currículo</i>',
				" class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\""
			);
			if ($linha->es_status == 20 && $this->session->perfil != "avaliador") {
				echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprovação por habilitação\" onclick=\"confirm_reprovacao_habilitacao(" .
					$linha->pr_candidatura .
					");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar reprovação por habilitação</i></a>";
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
													function confirm_reprovacao_habilitacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma que esse candidato perdeu o recurso e será reprovado definitivamente',
                                                                        text: 'Esse candidato será eliminado no teste de habilitação em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, confirma'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reprovar_habilitacao/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [2, 'desc']
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
