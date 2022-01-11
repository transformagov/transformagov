<?php

defined("BASEPATH") or exit("No direct script access allowed");
	echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            ";
	foreach ($competencias as $competencia) {
		echo " 
                                                                                            <th>{$competencia}</th>
                ";
	}
	echo "
                                                                                            
                                                                                            <th>Nota total</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
	//var_dump($vagas);
	$chaves = array_keys($competencias);
	if (isset($candidaturas)) {
		foreach ($candidaturas as $linha) {
			echo "
                                                                                    <tr>
                                                                                            <td>" .
				$linha->vc_nome .
				"</td>";

			echo "
                                                                                            <td class=\"text-center\">-</td>";

			$total = 0;
			$divisor = 0;
			foreach ($chaves as $chave) {
				if (isset($notas[$linha->pr_candidatura][$chave])) {
					$total += $notas[$linha->pr_candidatura][$chave];
					++$divisor;
				} else {
					$notas[$linha->pr_candidatura][$chave] = 0;
				}
				echo "
                                                                                            <td class=\"text-center\">{$notas[$linha->pr_candidatura][$chave]}</td>";
			}
			if ($divisor == 0) {
				$divisor = 1;
			}
			$total = $total / $divisor;
			echo "
                                                                                            <td class=\"text-center\">
                                                                                                    {$total}
                                                                                            </td>
                                                                                    </tr>";
		}
	}
	echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

	$pagina["js"] = "
                                            
                                            <script type=\"text/javascript\">
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
