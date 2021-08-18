<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this->load->view('templates/internaCabecalho', $pagina);

echo "
                        <div class=\"col-12\">
                            <div class=\"tsm-inner-content\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper\">
                                        <div class=\"page-body\">
                                            <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                    <div class=\"card\">
                                                        <div class=\"card-block\">
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"kt_table_1\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Data</th>
                                                                                            <th>Tipo</th>
                                                                                            <th>Local</th>
                                                                                            <th>IP</th>
                                                                                            <th>Texto</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($log);
        if(isset($log)){
                foreach ($log as $linha){
                        $dt_log = mysql_to_unix($linha -> dt_log);
                        echo "
                                                                                            <tr>
                                                                                                    <td class=\"centralizado\" data-search=\"".show_date($linha -> dt_log,true)."\" data-order=\"$dt_log\">".show_date($linha -> dt_log,true)."</td>";
                        if($linha -> en_tipo == 'sucesso'){
                                echo "
                                                                                                    <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Sucesso</span></td>";
                        }
                        else if($linha -> en_tipo == 'seguranca'){
                                echo "
                                                                                                    <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Violação de segurança</span></td>";
                        }
                        else if($linha -> en_tipo == 'erro'){
                                echo "
                                                                                                    <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Erro</span></td>";
                        }
                        else if($linha -> en_tipo == 'advertencia'){
                                echo "
                                                                                                    <td class=\"text-center\"><span class=\"badge badge-warning badge-lg\">Advertência leve</span></td>";
                        }
                        echo "
                                                                                                    <td>".$linha -> vc_local."</td>
                                                                                                    <td>".$linha -> vc_ip."</td>
                                                                                                    <td>".$linha -> tx_texto."</td>
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
                                                    var KTDatatablesBasicHeaders = function() {
                                                            var initTable1 = function() {
                                                                    var table = $('#kt_table_1');
                                                                    table.DataTable({
                                                                            responsive: true,
                                                                            order: [
                                                                                [0, 'desc']
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
                                                                            },
                                                                    });
                                                            };
                                                            return {
                                                                    init: function() {
                                                                            initTable1();
                                                                    },
                                                            };
                                                    }();
                                                    jQuery(document).ready(function() {
                                                            KTDatatablesBasicHeaders.init();
                                                    });
                                            </script>";


echo "
                                            </div>";
?>

<?php
$dbtime = $this->db->select('NOW() as hora_banco')->get()->result()[0];
?>
<input id="hora_php" type="hidden" value="<?= date("Y-m-d H:i:s") ?>" />
<input id="hora_banco" type="hidden" value="<?= $dbtime->hora_banco ?>" />

<?php
$this->load->view('templates/internaRodape', $pagina);
?>