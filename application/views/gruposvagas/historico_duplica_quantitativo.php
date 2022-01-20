<?php

defined("BASEPATH") or exit("No direct script access allowed");
	echo "
                                                        <div class=\"dt-responsive table-responsive\">
                                                                                                                        
                                                                <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
                                                                        <thead>
                                                                                <tr>                                                                                        
                                                                                        
                                                                                        <th>Enunciado</th>
                                                                                        <th>Etapa</th>
                                                                                        
                                                                                        <th>Tipo</th>
                                                                                        <th>Grupo de origem</th>
                                                                                        <th>Total</th>
                                                                                        
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
            ";
	if (is_array($questoes_duplicadas)) {
		foreach ($questoes_duplicadas as $questao_duplicada) {
			echo "
                                                                                        <tr>
                                                                                                
                                                                                                <td>
                                                                                                        {$questao_duplicada->tx_questao}
                                                                                                </td>
                                                                                                <td>
                                                                                                        " .
				$questao_duplicada->es_etapa .
				"ª Etapa
                                                                                                </td>
                                                                                                
                                                                                                <td>";
			if ($questao_duplicada->in_tipo == 1) {
				echo "Customizadas";
			} elseif ($questao_duplicada->in_tipo == 2) {
				echo "Aberta";
			} elseif ($questao_duplicada->in_tipo == 3) {
				echo "Sim/Não (sim positivo)";
			} elseif ($questao_duplicada->in_tipo == 4) {
				echo "Sim/Não (não positivo)";
			} elseif ($questao_duplicada->in_tipo == 5) {
				echo "Nenhum/Básico/Intermediário/Avançado";
			} elseif ($questao_duplicada->in_tipo == 6) {
				echo "Intervalo";
			} elseif ($questao_duplicada->in_tipo == 7) {
				echo "Upload de arquivo";
			}
			echo "</td>
                                                                                                <td>
                                                                                                        {$questao_duplicada->vc_grupovaga}
                                                                                                </td>
                                                                                                <td>
                                                                                                        {$questao_duplicada->quantitativo}
                                                                                                </td>
                                                                                                
                                                                                        </tr>";
		}
	}
	echo "
                                                                        </tbody>
                                                                </table>
                                                                
                                                        </div>
                                                        <div class=\"j-footer\">
                                                                <hr>
                                                                <div class=\"row\">
                                                                        <div class=\"col-lg-12 text-center\">
                                                                                        
                                                                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='" .
		base_url("GruposVagas/index") .
		"'\">Voltar</button>
                                                                        </div>
                                                                </div>
                                                        </div>
        ";
	$pagina["js"] = "
                                                            
                                                        <script type=\"text/javascript\">
                                                                $('#questoes_table').DataTable({
                                                                        order: [
                                                                        [4, 'desc']
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

