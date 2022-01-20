<?php

defined("BASEPATH") or exit("No direct script access allowed");

?>


<div class="dt-responsive table-responsive">
        <table class="table table-striped table-bordered table-hover" id="questoes_table">
                <thead>
                        <tr>
                                <th>Nome</th>
                                <th>Etapa</th>
                                <th>Tipo</th>
                                <th>Eliminatória</th>
                                <th>Obrigatória</th>
                                <th>Respostas</th>
                                <th>Status</th>
                                <th>Ações</th>
                        </tr>
                </thead>
                <tbody>
<?php

    //var_dump($questoes);
    if (isset($questoes)) {
        foreach ($questoes as $linha) {
            echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> tx_questao."</td>
                                                                                            <td class=\"text-center\">".$linha -> vc_etapa."</td>
                                                                                            <td class=\"text-center\">";
            if ($linha -> in_tipo == 1) {
                echo 'Customizadas';
            } elseif ($linha -> in_tipo == 2) {
                echo 'Aberta';
            } elseif ($linha -> in_tipo == 3) {
                echo 'Sim/Não (sim positivo)';
            } elseif ($linha -> in_tipo == 4) {
                echo 'Sim/Não (não positivo)';
            } elseif ($linha -> in_tipo == 5) {
                echo 'Nenhum/Básico/Intermediário/Avançado';
            } elseif ($linha -> in_tipo == 6) {
                echo 'Intervalo';
            } elseif ($linha -> in_tipo == 7) {
                echo 'Upload de arquivo';
            }
            echo '</td>';
            if ($linha -> bl_eliminatoria == '1') {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Sim";
            } else {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Não";
            }
            echo '</span></td>';
            if ($linha -> bl_obrigatorio == '1') {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Sim";
            } else {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Não";
            }
            echo "</span></td>
                                                                                            <td class=\"text-center\">".$linha -> cont_respostas."</td>";
            if ($linha -> bl_removido == '0') {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Ativo</span></td>
                                                                                            <td class=\"text-center\" style=\"white-space:nowrap\">
                                                                                                            ";
                if ($linha -> cont_respostas == 0) {
                    echo anchor('Questoes/edit/'.$linha -> pr_questao."/$grupo", '<i class="fa fa-lg mr-0 fa-edit">Editar</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar\"");
                    echo "
                                                                                                    <a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar questão\" onclick=\"confirm_delete(".$linha -> pr_questao.", {$grupo});\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar questão</i></a>";
                } else {
                    echo anchor('Questoes/view/'.$linha -> pr_questao."/$grupo", '<i class="fa fa-lg mr-0 fa-edit">Visualizar</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Visualizar\"");
                }
            } else {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Desativado</span></td>
                                                                                            <td class=\"text-center\" style=\"white-space:nowrap\">
                                                                                                    <a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar questão\" onclick=\"confirm_reactivate(".$linha -> pr_questao.", {$grupo});\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Reativar</i></a>";
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

    $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function confirm_delete(id, id2){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'A questão será marcada como desativada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Questoes/delete/')."' + id + '/' + id2)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id, id2){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'A questão voltará a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Questoes/reactivate/')."' + id + '/' + id2)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#questoes_table').DataTable({
                                                            order: [
                                                                [1, 'asc']
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
