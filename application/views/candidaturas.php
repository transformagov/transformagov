<?php

defined('BASEPATH') or exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if (isset($adicionais)) {
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
                                                        <div class=\"card-block\">";
if ($menu2 == 'index') { //lista de candidaturas - perfil candidato
    echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                            <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>";
    if ($num_vagas > 0) {
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <a href=\"".base_url('Candidaturas/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-edit\"></i> Candidatar-se a uma nova vaga </a>
                                                                    </div>";
    } else {
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <a href=\"#\" class=\"btn btn-danger btn-square\"> Sem vagas abertas para inscrição </a>
                                                                    </div>";
    }
    echo "
                                                            </div>
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table id=\"candidaturas_table\" class=\"table table-striped table-bordered table-hover nowrap\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Data</th>
                                                                                            <th>Vaga</th>
                                                                                            <th>Fim do período de inscrições</th>
                                                                                            <th>Prazo limite para o Teste de Aderência/HBDI/Teste de Motivação</th>
                                                                                            <th>Status</th>
                                                                                            <th>Ações</th
>                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
    $atual =time();
    if (isset($candidaturas)) {
        foreach ($candidaturas as $linha) {
            $dt_candidatura = mysql_to_unix($linha -> dt_candidatura);
            $dt_fim = mysql_to_unix($linha -> dt_fim);
            $dt_aderencia = strtotime($linha -> dt_aderencia);
            echo "
                                                                                    <tr>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_candidatura)."\" data-order=\"$dt_candidatura\">".show_date($linha -> dt_candidatura)."</td>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_fim, true)."\" data-order=\"$dt_fim\">".show_date($linha -> dt_fim, true)."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_aderencia, true)."\" data-order=\"$dt_aderencia\">".show_date($linha -> dt_aderencia, true)."</td>
                                                                                            ";
            if (isset($linha -> es_status) && ($linha -> es_status == 1 || $linha -> es_status == 4 || $linha -> es_status == 6)) {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-warning badge-lg\">Pendente</span></td>";
            } else {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Concluído</span></td>";
            }
            if (($linha -> es_status == 10 || $linha -> es_status == 11 || $linha -> es_status == 12)) {
                echo "
                                                                                            <td class=\"text-center\">";
                if (($dt_aderencia > $atual || strlen($linha -> dt_aderencia) == 0) && $linha -> en_aderencia == '1') {
                    echo anchor('Candidaturas/TesteAderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check">Teste de aderência</i>', " class=\"btn btn-sm btn-square btn-danger\" title=\"Teste de aderência\"");
                }
                if (($dt_aderencia > $atual || strlen($linha -> dt_aderencia) == 0) && $linha -> en_hbdi == 1) {
                    echo anchor('Candidaturas/HBDI/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check">HBDI</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"HBDI\"");
                }
                if (($dt_aderencia > $atual || strlen($linha -> dt_aderencia) == 0) && $linha -> en_motivacao == 1) {
                    echo anchor('Candidaturas/TesteMotivacao/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check">Teste de Motivação</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Teste de Motivação\"");
                }
            } elseif ($dt_fim > time()) { //dentro do prazo
                echo "
                                                                                            <td class=\"text-center\">";

                if ($linha -> es_status == 1) {
                    echo anchor('Candidaturas/Prova/'.$linha -> es_vaga, '<i class="fa fa-lg mr-0 fa-edit">Continuar preenchimento</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Continuar preenchimento\"");
                }
                if ($linha -> es_status == 4) {
                    echo anchor('Candidaturas/Curriculo/'.$linha -> es_vaga, '<i class="fa fa-lg mr-0 fa-edit">Continuar preenchimento</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Continuar preenchimento\"");
                }
                if ($linha -> es_status == 6) {
                    echo anchor('Candidaturas/Questionario/'.$linha -> es_vaga, '<i class="fa fa-lg mr-0 fa-edit">Continuar preenchimento</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Continuar preenchimento\"");
                }
            } else {
                echo "
                                                                                            <td class=\"text-center\">";
            }
            echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-search">Detalhes</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
            /*echo "
                                                                                        <a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Excluir candidatura\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";*/

            echo "
                                                                                            </td>
                                                                                    </tr>";
        }
    } else {
        echo "
                                                                                    <tr>
                                                                                            <td colspan=\"6\">Você não possui candidaturas registradas</td>
                                                                                    </tr>
                ";
    }
    echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

    $pagina['js'] = "
											<script type=\"text/javascript\">
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Aviso de exclusão de candidatura',
                                                                        text: 'Prezado candidato(a), caso deseje confirmar a exclusão de sua candidatura para essa vaga, você não poderá se candidatar na mesma vaga novamente. Deseja Confirmar?',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, exclui'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Candidaturas/delete/')."' + id )
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#candidaturas_table').DataTable({
                                                            columnDefs: [
                                                                    {  // set default column settings
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            order: [
                                                                [0, 'asc']
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
                                                        }
                                                    });
                                            </script>";
} else {
    echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                <div class=\"col-lg-8\">
                                                                    <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                </div>
                                                            </div>
                                                            <div class=\"row\">
                                                                <div class=\"col-md-12\">";

    if (strlen($erro)>0) {
        echo "
                                                                    <div class=\"alert background-danger\">
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br/>$erro<br />
                                                                            </div>
                                                                    </div>";
    //$erro='';
    } elseif (strlen($sucesso) > 0) {
        echo "
                                                                    <div class=\"alert background-success\">
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
    }

    echo "
                                                                <div id=\"wizard\">
                                                                    <section>
                                                                        ";

    $attributes = array('class' => 'wizard-form wizard clearfix',
                            'id' => 'form_candidatura');
    //array('vaga' => $vaga)
    //echo form_open_multipart($url, $attributes, array('vaga' => $vaga, 'num_formacao' => $num_formacao, 'num_experiencia' => $num_experiencia));
    if ($menu2 == 'Curriculo') {
        /*$attributes = array('class' => 'kt-form kt-form--label-right',
                                    'id' => 'form_candidatura');*/
        /*if($num_formacao == 0 || $num_experiencia == 0){
                echo "
                                                                    <script type=\"text/javascript\">
                                                                            alert('Preencha a formação e experiência em dados pessoais para continuar.');
                                                                            window.location='/';
                                                                    </script>
            ";
        }*/
        if (strlen(set_value('num_formacao')) > 0) {
            $num_formacao = set_value('num_formacao');
        }
        if (!($num_formacao>0)) {
            $num_formacao = 1;
        }
        if (strlen(set_value('num_experiencia')) > 0) {
            $num_experiencia = set_value('num_experiencia');
        }
        if (!($num_experiencia>0)) {
            $num_experiencia = 1;
        }
        echo form_open_multipart($url, $attributes, array('vaga' => $vaga, 'num_formacao' => $num_formacao, 'num_experiencia' => $num_experiencia));
    } else {
        if (isset($vaga)&&$vaga>0) {
            if ($menu2 == 'Prova' || $menu2 == 'Questionario') {
                /*if($menu2 == 'Questionario'){
                        $attributes["onsubmit"]="return(valida_formulario(this));";
                }*/
                echo form_open_multipart($url, $attributes, array('vaga' => $vaga));
            } else {
                echo form_open($url, $attributes, array('vaga' => $vaga));
            }
        } elseif (isset($candidatura)&&$candidatura>0) {
            if ($menu2 == 'Prova' || $menu2 == 'Questionario') {
                echo form_open_multipart($url, $attributes, array('candidatura' => $candidatura));
            } else {
                echo form_open($url, $attributes, array('candidatura' => $candidatura));
            }
        } else {
            echo form_open($url, $attributes);
        }
    }
    if ($menu2 != 'TesteAderencia' && $menu2!= 'delete' && $menu2 != 'editDossie' && $menu2 != 'HBDI' && $menu2 != 'TesteMotivacao') {
        echo "
                                                                            <div class=\"steps clearfix\">
                                                                                <ul role=\"tablist\">";
        if ($menu2 == 'create') {
            echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
        } else {
            echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
        }
        if ($menu2 != 'delete') {
            echo "
                                                                                        <a href=\"#\">
                                                                                            <span class=\"number\">1.</span>  
                                                                                            Escolha da vaga 
                                                                                        </a>
                                                                                    </li>";
        }
        if ($menu2 == 'Prova') {
            echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
            echo "
                                                                                        <a id=\"example-advanced-form-t-1\" href=\"#example-advanced-form-h-1\" aria-controls=\"example-advanced-form-p-1\">
                                                                                            <span class=\"number\">2.</span>  Pré-requisitos
                                                                                        </a>
                                                                                    </li>";
        } else {
            echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
            if (isset($candidatura) && ($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6')) {
                echo "
                                                                                        <a id=\"example-advanced-form-t-1\" href=\"".base_url('Candidaturas/Prova/'.$vaga)."\" aria-controls=\"example-advanced-form-p-1\">
                                                                                            <span class=\"number\">2.</span>  Pré-requisitos
                                                                                        </a>
                                                                                    </li>";
            } else {
                echo "
                                                                                        <a id=\"example-advanced-form-t-1\" href=\"#example-advanced-form-h-1\" aria-controls=\"example-advanced-form-p-1\">
                                                                                            <span class=\"number\">2.</span>  Pré-requisitos
                                                                                        </a>
                                                                                    </li>";
            }
        }

        if ($menu2 == 'Curriculo') {
            echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";

            echo "
                                                                                        <a id=\"example-advanced-form-t-2\" href=\"#example-advanced-form-h-2\" aria-controls=\"example-advanced-form-p-2\">
                                                                                            <span class=\"number\">3.</span>  Currículo 
                                                                                        </a>
                                                                                    </li>";
        } else {
            echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
            if (isset($candidatura) && ($candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6')) {
                echo "
                                                                                        <a id=\"example-advanced-form-t-2\" href=\"".base_url('Candidaturas/Curriculo/'.$vaga)."\" aria-controls=\"example-advanced-form-p-2\">
                                                                                            <span class=\"number\">3.</span>  Currículo 
                                                                                        </a>
                                                                                    </li>";
            } else {
                echo "
                                                                                        <a id=\"example-advanced-form-t-2\" href=\"#example-advanced-form-h-2\" aria-controls=\"example-advanced-form-p-2\">
                                                                                            <span class=\"number\">3.</span>  Currículo 
                                                                                        </a>
                                                                                    </li>";
            }
        }

        if ($menu2 == 'Questionario') {
            echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
            echo "
                                                                                        <a id=\"example-advanced-form-t-3\" href=\"#example-advanced-form-h-3\" aria-controls=\"example-advanced-form-p-3\">
                                                                                            <span class=\"number\">4.</span>  Requisitos desejáveis
                                                                                        </a>
                                                                                    </li>";
        } else {
            echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
            if (isset($candidatura) && ($candidatura[0] -> es_status == '6')) {
                echo "
                                                                                        <a id=\"example-advanced-form-t-3\" href=\"".base_url('Candidaturas/Questionario/'.$vaga)."\" aria-controls=\"example-advanced-form-p-3\">
                                                                                            <span class=\"number\">4.</span>  Requisitos desejáveis
                                                                                        </a>
                                                                                    </li>";
            } else {
                echo "
                                                                                        <a id=\"example-advanced-form-t-3\" href=\"#example-advanced-form-h-3\" aria-controls=\"example-advanced-form-p-3\">
                                                                                            <span class=\"number\">4.</span>  Requisitos desejáveis
                                                                                        </a>
                                                                                    </li>";
            }
        }

        echo "
                                                                                </ul>
                                                                            </div>
                                                                            ";
    }

    echo "
                                                                            <div class=\"clearfix\">
                                                                                <fieldset class=\"body current\">";
    if ($menu2 == 'create') { //cadastro de candidatura
        echo "
																					
                                                                                    <div class=\"form-group row\">
                                                                                        <div class=\"col-md-4 col-lg-2\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Vaga <abbr title="Obrigatório">*</abbr>', 'Vaga', $attributes);
        echo "
                                                                                        </div>
                                                                                        <div class=\"col-md-8 col-lg-10\">";
        if (isset($vagas)) {
            $vagas=array(0 => '')+$vagas;
            if (strstr($erro, "'Vaga'")) {
                echo form_dropdown('Vaga', $vagas, set_value('Vaga'), "class=\"form-control is-invalid\" id=\"Vaga\"");
            } else {
                echo form_dropdown('Vaga', $vagas, set_value('Vaga'), "class=\"form-control\" id=\"Vaga\"");
            }
        }
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";
        $attributes = array('class' => 'btn btn-primary');
        echo form_submit('cadastrar', 'Candidatar-se', $attributes);
        echo "
                                                                                <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";

        echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
    } elseif ($menu2 == 'Prova') { //prova
        if (!isset($questoes)) {
            echo "
                                                <script type=\"text/javascript\">
                                                        alert('O criador dessa vaga deve inserir as questões relativa a esse formulário.');
                                                        window.location='/';
                                                </script>";
        }
        /*if(strlen($erro)>0){
                echo "
                                                    <div class=\"alert background-danger background-danger\" role=\"alert\">
                                                            <div class=\"alert-text\">
                                                                    <strong>ERRO</strong>:<br /> $erro
                                                            </div>
                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                            <div class=\"alert-text\">
                                                                    $sucesso
                                                            </div>
                                                    </div>";
        }*/
        /*
        echo "
                                                                            <div class=\"form-group row\">
                                                                                <div class=\"col-md-4 col-lg-2\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Vaga <abbr title="Obrigatório">*</abbr>', 'Vaga', $attributes);
        echo "
                                                                                </div>
                                                                                <div class=\"col-md-8 col-lg-10\">";
        if(isset($vagas)){
                $vagas=array(0 => '')+$vagas;
                if(strstr($erro, "'Vaga'")){
                        echo form_dropdown('Vaga', $vagas, set_value('Vaga'), "class=\"form-control is-invalid\" id=\"Vaga\"");
                }
                else{
                        echo form_dropdown('Vaga', $vagas, set_value('Vaga'), "class=\"form-control\" id=\"Vaga\"");
                }
        }
        echo "
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <div class=\"actions clearfix text-center\">";
        $attributes = array('class' => 'btn btn-primary');
        echo form_submit('cadastrar', 'Candidatar-se', $attributes);
        echo "
                                                                        <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";

        echo "
                                                                    </div>
                                                                </form>

                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
         */
        //var_dump($anexos);
        if (strlen($sucesso) == 0 || (strlen($sucesso) > 0 && isset($_POST['cadastrar']) && $_POST['cadastrar'] == "Salvar dados")) {
            echo "
                                                                                    <div class=\"alert background-warning\">
                                                                                            Link para o Fale Conosco: <a href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" class=\"kt-login__link\" target=\"_blank\">Fale conosco</a><br/><br />
                                                                                            
                                                                                    </div>

                        ";
            $CI =& get_instance();
            $CI -> mostra_questoes($questoes, $respostas, $opcoes, $erro, true, '', $anexos);
            echo form_fieldset_close();
            /*if(isset($questoes)){
                    $x=0;
                    foreach ($questoes as $row){
                            $x++;
                            echo "
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-md-4 col-lg-2\">";
                            $attributes = array('class' => 'esquerdo control-label');
                            $label=$x.') '.strip_tags($row -> tx_questao);
                            if($row -> bl_obrigatorio){
                                    $label.=' <abbr title="Obrigatório">*</abbr>';
                            }
                            echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                            //echo '<br/>';
                            echo "
                                                                            </div>
                                                                            <div class=\"col-md-8 col-lg-10\">";
                            if(!isset($Questao[$row -> pr_questao]) || (strlen($Questao[$row -> pr_questao]) == 0 && strlen(set_value('Questao'.$row -> pr_questao)) > 0) || (strlen(set_value('Questao'.$row -> pr_questao)) > 0 && $Questao[$row -> pr_questao] != set_value('Questao'.$row -> pr_questao))){
                                    $Questao[$row -> pr_questao] = set_value('Questao'.$row -> pr_questao);
                            }

                            if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){

                                    $valores=array(""=>"",0=>"Não",1=>"Sim");


                                    //echo form_hidden('codigo_experiencia'.$i, $pr_experienca[$i]);

                                    if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                            echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control is-invalid\" id=\"{Questao'.$row -> pr_questao}\""
                                    }
                                    else{
                                            echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control\" id=\"{Questao'.$row -> pr_questao}\""
                                    }

                            }
                            else if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                    $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                                    if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                            echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                    }
                                    else{
                                            echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                    }


                            }
                            else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                    $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                        'rows'=>'5');
                                    echo form_textarea($attributes, $Questao[$row -> pr_questao], 'class="form-control"');
                            }
                            else if(isset($opcoes)){
                                    $valores = array(""=>"");
                                    foreach($opcoes as $opcao){
                                            if($opcao->es_questao==$row -> pr_questao){
                                                    $valores[$opcao->pr_opcao]=$opcao->tx_opcao;
                                            }
                                    }

                                    if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                            echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                    }
                                    else{
                                            echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                    }
                            }
                            if(!isset($pr_resposta[$row -> pr_questao]) || (strlen($pr_resposta[$row -> pr_questao]) == 0 && strlen(set_value("codigo_experiencia{$row -> pr_questao}")) > 0) || (strlen(set_value("codigo_experiencia{$row -> pr_questao}")) > 0 && $pr_resposta[$row -> pr_questao] != set_value("codigo_experiencia{$row -> pr_questao}"))){
                                    $pr_resposta[$row -> pr_questao] = set_value("codigo_experiencia{$row -> pr_questao}");
                            }
                            echo form_hidden('codigo_resposta'.$row -> pr_questao, $pr_resposta[$row -> pr_questao]);
                            if(strstr($erro, 'questão '.$x.' ')){
                                    echo "
                                                                                                                                        <div class=\"invalid-feedback\">
                                                                                                                                                Preencha essa questão!
                                                                                                                                        </div>";
                            }
                            echo "
                                                                                </div>
                                                                        </div>";
                    }
            }*/
            echo " 
                                                                                <!--</fieldset>-->
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";

            //echo form_submit('cadastrar', 'Candidatar-se', $attributes);

            if (isset($questoes)) {
                $attributes = array('class' => 'btn btn-primary');
                $attributes['formnovalidate'] = 'formnovalidate';
                echo form_submit('cadastrar', 'Salvar dados', $attributes);
                unset($attributes['formnovalidate']);
                echo form_submit('cadastrar', 'Avançar', $attributes);
            }
            echo "
                                                                                        <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Interromper preenchmento</button>";

            echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
            $pagina['js'] = "
                                                <script type=\"text/javascript\">
                                                        function checkFile(oFile){
                                                            
                                                            if (oFile.files[0].size > 2097152) // 2 mb for bytes.
                                                            {
                                                                alert(\"O arquivo deve ter tamanho máximo de 2mb!\");
                                                                oFile.value='';
                                                            }
                                                            else if(oFile.files[0].size == 0){
                                                                alert(\"O arquivo não pode ser vazio!\");
                                                                oFile.value='';
                                                            }
                                                        }

                                                </script>";
        }
    } elseif ($menu2 == 'Curriculo') { //currículo

        /*if(strlen($erro)>0){
                echo "
                                                    <div class=\"alert background-danger background-danger\" role=\"alert\">
                                                            <div class=\"alert-text\">
                                                                    <strong>ERRO</strong>:<br /> $erro
                                                            </div>
                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                            <div class=\"alert-text\">
                                                                    $sucesso
                                                            </div>
                                                    </div>";
        }*/
        //if(strlen($sucesso) == 0){

        echo "
																					<div class=\"alert background-warning\">
																							ATENÇÃO<br />
																							Caso o Formulário de Dados Pessoais tenha sido preenchido antes de iniciar a inscrição nas vagas, o sistema apresentará aqui uma cópia dos dados e comprovantes inseridos nele.<br />
																							Os dados copiados para a vaga poderão ser alterados pelo candidato durante a inscrição, mas essas alterações NÃO serão refletidas no currículo base, ou seja, no formulário de Dados Pessoais.<br />
																							Após a escolha da vaga, qualquer alteração no currículo base (o formulário de Dados Pessoais) NÃO será refletida no Currículo que aparece na vaga.<br />
																							Observação: caso tenha problema para salvar os anexos, salve os dados digitados para inserir posteriormente os anexos e prosseguir.
																					</div>
                                                                                    <div class=\"alert background-warning\">
                                                                                            Link para o Fale Conosco: <a href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" class=\"kt-login__link\" target=\"_blank\">Fale conosco</a><br/><br />
                                                                                            
                                                                                    </div>	
                                                                                    <div class=\"kt-wizard-v4__form\" id=\"div_formacao\">";
        for ($i = 1; $i <= $num_formacao; $i++) {
            echo "
                                                                                        <div id=\"row_formacao{$i}\">
                                                                                            <fieldset>
                                                                                                <legend>Formação acadêmica {$i}</legend>";
            /*<div class=\"form-group row validated\">
                    ";*/
            echo "
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Tipo <abbr title="Obrigatório">*</abbr>', "tipo{$i}", $attributes);
            /*echo "
                                                                                                                                <div class=\"col-lg-4\">";*/
            echo " 
                                                                                                        <br />";
            //var_dump($etapas);
            $attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            'seminario' => 'Curso/Seminário',
                                            );
            if (!isset($en_tipo[$i]) || (strlen($en_tipo[$i]) == 0 && strlen(set_value("tipo{$i}")) > 0) || (strlen(set_value("tipo{$i}")) > 0 && $en_tipo != set_value("tipo{$i}"))) {
                $en_tipo[$i] = set_value("tipo{$i}");
            }
            if (strstr($erro, "tipo da 'Formação acadêmica {$i}'")) {
                echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" required=\"required\" oninvalid=\"this.scrollIntoView({block:'center'});\" id=\"tipo{$i}\" onchange=\"mostra_carga_horaria({$i})\"");
            } else {
                echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\" required=\"required\" oninvalid=\"this.scrollIntoView({block:'center'});\" onchange=\"mostra_carga_horaria({$i})\"");
            }
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Nome do curso <abbr title="Obrigatório">*</abbr>', "curso{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))) {
                $vc_curso[$i] = set_value("curso{$i}");
            }
            $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});");
            if (strstr($erro, "curso da 'Formação acadêmica {$i}'")) {
                $attributes['class'] = 'form-control is-invalid';
            }
            echo form_input($attributes, $vc_curso[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Instituição de ensino <abbr title="Obrigatório">*</abbr>', "instituicao{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))) {
                $vc_instituicao[$i] = set_value("instituicao{$i}");
            }
            $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});");
            if (strstr($erro, "instituição de ensino da 'Formação acadêmica {$i}'")) {
                $attributes['class'] = 'form-control is-invalid';
            }
            echo form_input($attributes, $vc_instituicao[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Data de conclusão <abbr title="Obrigatório">*</abbr>', "conclusao{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($dt_conclusao[$i]) || (strlen($dt_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $dt_conclusao[$i] != set_value("conclusao{$i}"))) {
                $dt_conclusao[$i] = set_value("conclusao{$i}");
            }
            $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});",
                                                    'type' => 'date',
                                                    'class' => 'form-control');
            if (strstr($erro, "data da conclusão da 'Formação acadêmica {$i}'")) {
                $attributes['class'] = 'form-control is-invalid';
            }
            echo form_input($attributes, $dt_conclusao[$i]);
            if (!isset($pr_formacao[$i]) || (strlen($pr_formacao[$i]) == 0 && strlen(set_value("codigo_formacao{$i}")) > 0) || (strlen(set_value("codigo_formacao{$i}")) > 0 && $pr_formacao[$i] != set_value("codigo_formacao{$i}"))) {
                $pr_formacao[$i] = set_value("codigo_formacao{$i}");
            }
            echo form_input(array('name' => 'codigo_formacao'.$i, 'type'=>'hidden', 'id' =>'codigo_formacao'.$i,'value'=>$pr_formacao[$i]));

            if (!isset($es_formacao_pai[$i]) || (strlen($es_formacao_pai[$i]) == 0 && strlen(set_value("codigo_formacao_pai{$i}")) > 0) || (strlen(set_value("codigo_formacao_pai{$i}")) > 0 && $es_formacao_pai[$i] != set_value("codigo_formacao_pai{$i}"))) {
                $es_formacao_pai[$i] = set_value("codigo_formacao_pai{$i}");
            }
            echo form_input(array('name' => 'codigo_formacao_pai'.$i, 'type'=>'hidden', 'id' =>'codigo_formacao_pai'.$i,'value'=>$es_formacao_pai[$i]));

            //echo form_hidden('codigo_formacao'.$i, $pr_formacao[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                                
																								<div class=\"form-group row\" id=\"div_carga_horaria{$i}\">
																									<div class=\"col-lg-12\">
                                                                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Carga Horária total (considerando 1 dia = 8h) <abbr title="Obrigatório no caso de ser \'Curso/Seminário\'">*</abbr>', "cargahoraria{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($in_cargahoraria[$i]) || (strlen($in_cargahoraria[$i]) == 0 && strlen(set_value("cargahoraria{$i}")) > 0) || (strlen(set_value("cargahoraria{$i}")) > 0 && $in_cargahoraria[$i] != set_value("conclusao{$i}"))) {
                $in_cargahoraria[$i] = set_value("cargahoraria{$i}");
            }
            $attributes = array('name' => "cargahoraria{$i}",
                                                                        'id' => "cargahoraria{$i}",
                                                                        'maxlength' => '10',
                                                                        'type' => 'number',
                                                                        'class' => 'form-control');
            if (strstr($erro, "carga horária da 'Formação acadêmica {$i}'")) {
                $attributes['class'] = 'form-control is-invalid';
            }

            echo form_input($attributes, $in_cargahoraria[$i]);
            if (!isset($pr_formacao[$i]) || (strlen($pr_formacao[$i]) == 0 && strlen(set_value("codigo_formacao{$i}")) > 0) || (strlen(set_value("codigo_formacao{$i}")) > 0 && $pr_formacao[$i] != set_value("codigo_formacao{$i}"))) {
                $pr_formacao[$i] = set_value("codigo_formacao{$i}");
            }
            echo form_input(array('name' => 'codigo_formacao'.$i, 'type'=>'hidden', 'id' =>'codigo_formacao'.$i,'value'=>$pr_formacao[$i]));
            //echo form_hidden('codigo_formacao'.$i, $pr_formacao[$i]);
            echo "
																									</div>
																								</div>
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                        ";
            $attributes = array('class' => 'esquerdo control-label');
            /*$texto = "";
            if(isset($anexos_formacao[$i]) || isset($anexos_formacao2[$i])){
                            $texto = "(já inserido)";
            }*/
            /*
            if($res == '1'){
                                    if(isset($anexos_questao[$row -> pr_questao])){
                                            $vc_anexo = $anexos_questao[$row -> pr_questao]->vc_arquivo;
                                            $pr_arquivo = $anexos_questao[$row -> pr_questao]->pr_anexo;
                                    }
                                    echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                    //echo '(já enviado anteriormente)';
                            }
            */

            echo form_label('Diploma / certificado <abbr title="Obrigatório">*</abbr> (inserir arquivo pdf com tamanho máximo de 2MB)', "diploma{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            $attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'onchange' => 'checkFile(this)');
            if (strstr($erro, "diploma / certificado da 'Formação acadêmica {$i}'")) {
                $attributes['class'] = 'form-control is-invalid';
            }
            if (isset($anexos_formacao[$i])) {
                $vc_anexo = $anexos_formacao[$i][0]->vc_arquivo;
                $pr_arquivo = $anexos_formacao[$i][0]->pr_anexo;
                echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
            } elseif (isset($anexos_formacao2[$i])) {
                $vc_anexo = $anexos_formacao2[$i][0]->vc_arquivo;
                $pr_arquivo = $anexos_formacao2[$i][0]->pr_anexo;
                echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
            } else {
                $attributes['required'] = 'required';
                $attributes['oninvalid'] = "this.scrollIntoView({block:'center'});";
            }

            echo form_upload($attributes, '', 'class="form-control"');
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>
                                                                        ";
        }
        echo "
                                                                                    </div>";
        echo " 
                                                                                    <div class=\"j-footer\">
                                                                                        <div class=\"kt-form__actions\">
                                                                                            <div class=\"col-lg-12 text-center\">
                                                                                                <button type=\"button\" id=\"adicionar_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar formação</button>
                                                                                                <button type=\"button\" id=\"remover_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-minus\"></i> Remover formação</button></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>";
        echo " 
                                                                                    <div class=\"kt-wizard-v4__form\" id=\"div_experiencia\">
                        ";
        for ($i = 1; $i <= $num_experiencia; $i++) {
            if ($i == 1) {
                echo "
                                                                                        <div id=\"row_experiencia{$i}\">
                                                                                            <fieldset>
                                                                                                <legend>Experiência profissional {$i}<abbr title=\"Prezado(a) candidato (a) atente-se ao preenchimento da experiência profissional, tal informação deve conter, necessariamente, não apenas os nomes das instituições nas quais você trabalhou, mas também o período (ano de início e término do vínculo), o tempo de experiência em determinada atividade, o tipo (se foi de liderança, coordenação, parte da equipe técnica etc), a atividade realizada e o número de liderados (se esta informação for requisito da vaga).\">?</abbr></legend>";
            } else {
                echo "
                                                                                        <div id=\"row_experiencia{$i}\">
                                                                                            <fieldset>
                                                                                                <legend>Experiência profissional {$i}</legend>";
            }
            /*echo "
                                                                                                                <fieldset>
                                                                                                                        <legend>Experiência profissional {$i}</legend>
                                                                                                                        <div class=\"form-group row validated\">
                                                                                                                                ";*/
            echo "
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Cargo <abbr title="Obrigatório">*</abbr>', "cargo{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($vc_cargo[$i]) || (strlen($vc_cargo[$i]) == 0 && strlen(set_value("cargo{$i}")) > 0) || (strlen(set_value("cargo{$i}")) > 0 && $vc_cargo[$i] != set_value("cargo{$i}"))) {
                $vc_cargo[$i] = set_value("cargo{$i}");
            }
            $attributes = array('name' => "cargo{$i}",
                                                    'id' => "cargo{$i}",
                                                    'maxlength' => '100',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});",
                                                    'class' => 'form-control');
            echo form_input($attributes, $vc_cargo[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Instituição / empresa <abbr title="Obrigatório">*</abbr>', "empresa{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($vc_empresa[$i]) || (strlen($vc_empresa[$i]) == 0 && strlen(set_value("empresa{$i}")) > 0) || (strlen(set_value("empresa{$i}")) > 0 && $vc_empresa[$i] != set_value("empresa{$i}"))) {
                $vc_empresa[$i] = set_value("empresa{$i}");
            }
            $attributes = array('name' => "empresa{$i}",
                                                    'id' => "empresa{$i}",
                                                    'maxlength' => '100',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});",
                                                    'class' => 'form-control');
            echo form_input($attributes, $vc_empresa[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Data de início <abbr title="Obrigatório">*</abbr>', "inicio{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($dt_inicio[$i]) || (strlen($dt_inicio[$i]) == 0 && strlen(set_value("inicio{$i}")) > 0) || (strlen(set_value("inicio{$i}")) > 0 && $dt_inicio[$i] != set_value("inicio{$i}"))) {
                $dt_inicio[$i] = set_value("inicio{$i}");
            }
            $attributes = array('name' => "inicio{$i}",
                                                    'id' => "inicio{$i}",
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});",
                                                    'type' => 'date',
                                                    'class' => 'form-control');
            echo form_input($attributes, $dt_inicio[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
																								
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Emprego atual?', "emprego_atual{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($bl_emprego_atual[$i]) || (strlen($bl_emprego_atual[$i]) == 0 && strlen(set_value("emprego_atual{$i}")) > 0) || (strlen(set_value("emprego_atual{$i}")) > 0 && $bl_emprego_atual[$i] != set_value("emprego_atual{$i}"))) {
                $bl_emprego_atual[$i] = set_value("emprego_atual{$i}");
            }
            $attributes=array('0'=>'Não','1'=>'Sim');
            echo form_dropdown("emprego_atual{$i}", $attributes, $bl_emprego_atual[$i], "class=\"form-control\" id=\"emprego_atual{$i}\" onchange=\"esconde_data_termino({$i})\"");
            echo "
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class=\"form-group row\" id=\"div_termino{$i}\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Data de término', "fim{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($dt_fim[$i]) || (strlen($dt_fim[$i]) == 0 && strlen(set_value("fim{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $dt_fim[$i] != set_value("fim{$i}"))) {
                $dt_fim[$i] = set_value("fim{$i}");
            }
            $attributes = array('name' => "fim{$i}",
                                                    'id' => "fim{$i}",

                                                    'type' => 'date',
                                                    'class' => 'form-control');
            echo form_input($attributes, $dt_fim[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
																								
                                                                                                <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                    ";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Principais atividades desenvolvidas <abbr title="Obrigatório">*</abbr>', "atividades{$i}", $attributes);
            echo " 
                                                                                                        <br />";
            if (!isset($tx_atividades[$i]) || (strlen($tx_atividades[$i]) == 0 && strlen(set_value("atividades{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $tx_atividades[$i] != set_value("atividades{$i}"))) {
                $tx_atividades[$i] = set_value("atividades{$i}");
            }
            $attributes = array('name' => "atividades{$i}",
                                                    'id' => "atividades{$i}",
                                                    'rows' => '4',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});");
            echo form_textarea($attributes, $tx_atividades[$i]);
            if (!isset($pr_experienca[$i]) || (strlen($pr_experienca[$i]) == 0 && strlen(set_value("codigo_experiencia{$i}")) > 0) || (strlen(set_value("codigo_experiencia{$i}")) > 0 && $pr_experienca[$i] != set_value("codigo_experiencia{$i}"))) {
                $pr_experienca[$i] = set_value("codigo_experiencia{$i}");
            }
            echo form_input(array('name' => 'codigo_experiencia'.$i, 'type'=>'hidden', 'id' =>'codigo_experiencia'.$i,'value'=>$pr_experienca[$i]));

            if (!isset($es_experiencia_pai[$i]) || (strlen($es_experiencia_pai[$i]) == 0 && strlen(set_value("codigo_experiencia_pai{$i}")) > 0) || (strlen(set_value("codigo_experiencia_pai{$i}")) > 0 && $es_experiencia_pai[$i] != set_value("codigo_experiencia_pai{$i}"))) {
                $es_experiencia_pai[$i] = set_value("codigo_experiencia_pai{$i}");
            }
            echo form_input(array('name' => 'codigo_experiencia_pai'.$i, 'type'=>'hidden', 'id' =>'codigo_experiencia_pai'.$i,'value'=>$es_experiencia_pai[$i]));

            //echo form_hidden('codigo_experiencia'.$i, $pr_experienca[$i]);
            echo "
                                                                                                    </div>
                                                                                                </div>
																								<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																										";
            $attributes = array('class' => 'esquerdo control-label');
            /*$texto = "";
            if(isset($anexos_experiencia[$i]) || isset($anexos_experiencia2[$i])){
                    $texto = "(já inserido)";
            }*/
            echo form_label('Comprovante (inserir arquivo pdf com tamanho máximo de 2MB)', "comprovante{$i}", $attributes);
            echo " 
																									   <br />";
            $attributes = array('name' => "comprovante{$i}",
                                                    'class' => 'form-control',
                                                    'onchange' => 'checkFile(this)');
            if (strstr($erro, "comprovante da 'Experiência profissional {$i}'")) {
                $attributes['class'] = 'form-control is-invalid';
            }
            if (isset($anexos_experiencia[$i])) {
                $vc_anexo = $anexos_experiencia[$i][0]->vc_arquivo;
                $pr_arquivo = $anexos_experiencia[$i][0]->pr_anexo;
                echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
            } elseif (isset($anexos_experiencia2[$i])) {
                $vc_anexo = $anexos_experiencia2[$i][0]->vc_arquivo;
                $pr_arquivo = $anexos_experiencia2[$i][0]->pr_anexo;
                echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
            }
            /*else{
                    $attributes['required'] = 'required';
            }*/
            echo form_upload($attributes, '', 'class="form-control"');
            echo "
																									</div>
																								</div>
                                                                                            </fieldset>
                                                                                        </div>
                                                                        ";
        }
        echo " 
                                                                                    </div>";
        echo " 
                                                                                    <div class=\"j-footer\">
                                                                                        <div class=\"kt-form__actions\">
                                                                                            <div class=\"col-lg-12 text-center\">
                                                                                                <button type=\"button\" id=\"adicionar_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar exp. profissional</button>
                                                                                                <button type=\"button\" id=\"remover_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-minus\"></i> Remover exp. profissional</button></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>";
        echo "
                                                                                </fieldset>
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";
        echo "
                                                                                        <button type=\"reset\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Candidaturas/Prova/'.$vaga)."';\">Voltar</button>";
        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
        //if(isset($questoes)){
        $attributes = array('class' => 'btn btn-primary');
        $attributes['formnovalidate'] = 'formnovalidate';
        echo form_submit('cadastrar', 'Salvar dados', $attributes);
        unset($attributes['formnovalidate']);
        echo form_submit('cadastrar', 'Avançar', $attributes);
        //}
        echo "
                                                                                        <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Interromper preenchimento</button>";

        echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                        </div>";
        /*echo "
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <div class=\"j-footer\">
                                                                                                            <div class=\"kt-form__actions\">
                                                                                                                    <div class=\"col-lg-12 text-center\">
                                                                                                                            <button type=\"button\" id=\"adicionar_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar formação</button>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div>
                                                                                                    <div class=\"kt-form__section\">
                                                                                                            <div class=\"kt-wizard-v4__form\" id=\"div_experiencia\">";
        for($i = 1; $i <= $num_experiencia; $i++){
                echo "
                                                                                                                    <fieldset>
                                                                                                                            <legend>Experiência profissional {$i}</legend>
                                                                                                                            <div class=\"form-group row validated\">
                                                                                                                                    ";
                $attributes = array('class' => 'col-lg-3 col-form-label');
                echo form_label('Instituição / empresa <abbr title="Obrigatório">*</abbr>', "empresa{$i}", $attributes);
                echo "
                                                                                                                                    <div class=\"col-lg-6\">";
                if(!isset($vc_empresa) || (strlen($vc_empresa) == 0 && strlen(set_value("empresa{$i}")) > 0) || (strlen(set_value("empresa{$i}")) > 0 && $vc_empresa != set_value("empresa{$i}"))){
                        $vc_empresa = set_value("empresa{$i}");
                }
                $attributes = array('name' => "empresa{$i}",
                                    'id' => "empresa{$i}",
                                    'maxlength' => '100',
                                    'class' => 'form-control');
                echo form_input($attributes, $vc_empresa);
                echo "
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                            <div class=\"form-group row validated\">
                                                                                                                                    ";
                $attributes = array('class' => 'col-lg-3 col-form-label');
                echo form_label('Ano de início <abbr title="Obrigatório">*</abbr>', "inicio{$i}", $attributes);
                echo "
                                                                                                                                    <div class=\"col-lg-3\">";
                if(!isset($ye_inicio) || (strlen($ye_inicio) == 0 && strlen(set_value("inicio{$i}")) > 0) || (strlen(set_value("inicio{$i}")) > 0 && $ye_inicio != set_value("inicio{$i}"))){
                        $ye_inicio = set_value("inicio{$i}");
                }
                $attributes = array('name' => "inicio{$i}",
                                    'id' => "inicio{$i}",
                                    'maxlength' => '4',
                                    'type' => 'number',
                                    'class' => 'form-control');
                echo form_input($attributes, $ye_inicio);
                echo "
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                            <div class=\"form-group row validated\">
                                                                                                                                    ";
                $attributes = array('class' => 'col-lg-3 col-form-label');
                echo form_label('Ano de término', "fim{$i}", $attributes);
                echo "
                                                                                                                                    <div class=\"col-lg-3\">";
                if(!isset($ye_fim) || (strlen($ye_fim) == 0 && strlen(set_value("fim{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $ye_fim != set_value("fim{$i}"))){
                        $ye_fim = set_value("fim{$i}");
                }
                $attributes = array('name' => "fim{$i}",
                                    'id' => "fim{$i}",
                                    'maxlength' => '4',
                                    'type' => 'number',
                                    'class' => 'form-control');
                echo form_input($attributes, $ye_fim);
                echo "
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                            <div class=\"form-group row validated\">
                                                                                                                                    ";
                $attributes = array('class' => 'col-lg-3 col-form-label');
                echo form_label('Principais atividades desenvolvidas <abbr title="Obrigatório">*</abbr>', "atividades{$i}", $attributes);
                echo "
                                                                                                                                    <div class=\"col-lg-8 col-sm-6\">";
                if(!isset($tx_atividades) || (strlen($tx_atividades) == 0 && strlen(set_value("atividades{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $tx_atividades != set_value("atividades{$i}"))){
                        $tx_atividades = set_value("atividades{$i}");
                }
                $attributes = array('name' => "atividades{$i}",
                                    'id' => "atividades{$i}",
                                    'rows' => '4',
                                    'class' => 'form-control');
                echo form_textarea($attributes, $tx_atividades);
                echo "
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                    </fieldset>";
        }
        echo "
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <div class=\"j-footer\">
                                                                                                            <div class=\"kt-form__actions\">
                                                                                                                    <div class=\"col-lg-12 text-center\">
                                                                                                                            <button type=\"button\" id=\"adicionar_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar exp. profissional</button>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"kt-form__actions\">
                                                                                                    <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";
        $attributes = array('class' => 'btn btn-primary');
        echo form_submit('cadastrar', 'Avançar', $attributes);

        echo "
                                                                                            </div>
                                                                                    </form>
                                                                            </div>
                                                                    </div>
                                                            </div>";*/
        $pagina['js'] = "
        <script type=\"text/javascript\">
                function mostra_carga_horaria(i){
                        var tipo = $('#tipo'+i).val();
                        if(tipo == 'seminario'){
                                $('#div_carga_horaria'+i).show();
                        }
                        else{
                                $('#div_carga_horaria'+i).hide();
                        }
                }
                function esconde_data_termino(i){
                        var emprego_atual = $('#emprego_atual'+i).val();
                        
                        if(emprego_atual == '1'){
                                $('#div_termino'+i).hide();
                        }
                        else{
                                $('#div_termino'+i).show();
                        }
                }
                function checkFile(oFile){
                                                            
                        if (oFile.files[0].size > 2097152) // 2 mb for bytes.
                        {
                            alert(\"O arquivo deve ter tamanho máximo de 2mb!\");
                            oFile.value='';
                        }
                        else if(oFile.files[0].size == 0){
                            alert(\"O arquivo não pode ser vazio!\");
                            oFile.value='';
                        }
                    }
                $( '#adicionar_formacao' ).click(function() {
                        var valor_num = $('input[name=num_formacao]').val();
                        valor_num++;
                        var newElement = '<div id=\"row_formacao' + valor_num + '\"><div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div><fieldset><legend>Formação acadêmica ' + valor_num + '</legend><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Tipo <abbr title="Obrigatório">*</abbr>', "tipo' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><select name=\"tipo' + valor_num + '\" class=\"form-control\" required=\"required\" id=\"tipo' + valor_num + '\" onchange=\"mostra_carga_horaria('+valor_num+')\"><option value=\"\" selected=\"selected\"></option><option value=\"bacharelado\">Graduação - Bacharelado</option><option value=\"tecnologo\">Graduação - Tecnológo</option><option value=\"especializacao\">Pós-graduação - Especialização</option><option value=\"mba\">MBA</option><option value=\"mestrado\">Mestrado</option><option value=\"doutorado\">Doutorado</option><option value=\"posdoc\">Pós-doutorado</option><option value=\"seminario\">Curso/Seminário</option></select></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Nome do curso <abbr title="Obrigatório">*</abbr>', "curso' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"text\" name=\"curso' + valor_num + '\" required=\"required\" value=\"\" id=\"curso' + valor_num + '\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Instituição de ensino <abbr title="Obrigatório">*</abbr>', "instituicao' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"text\" name=\"instituicao' + valor_num + '\" value=\"\" required=\"required\" id=\"instituicao' + valor_num + '\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Data de conclusão <abbr title="Obrigatório">*</abbr>', "conclusao' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"date\" name=\"conclusao' + valor_num + '\" value=\"\" required=\"required\" id=\"conclusao' + valor_num + '\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\" id=\"div_carga_horaria' + valor_num + '\"><div class=\"col-lg-12\">";


        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Carga Horária total (considerando 1 dia = 8h) <abbr title="Obrigatório no caso de ser Curso/Seminário">*</abbr>', "conclusao' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"number\" name=\"cargahoraria' + valor_num + '\" value=\"\" id=\"cargahoraria' + valor_num + '\" maxlength=\"4\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Diploma / comprovante <abbr title="Obrigatório">*</abbr> (inserir arquivo pdf com tamanho máximo de 2MB)', "diploma' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><input type=\"file\" name=\"diploma' + valor_num + '\" required=\"required\" class=\"form-control\" onchange=\"checkFile(this)\" /></div>";
        $pagina['js'] .= "</div></fieldset>";
        $pagina['js'] .= "</div>';
                        $( '#div_formacao' ).append( $(newElement) );
                        $('input[name=num_formacao]').val(valor_num);
                        $('#div_carga_horaria'+valor_num).hide(); 
                });
                $( '#remover_formacao' ).click(function() {
                        var valor_num = $('input[name=num_formacao]').val();
						if($('#codigo_formacao'+valor_num).val()>0 || !($('#codigo_formacao_pai'+valor_num).val()>0)){
							if($('#codigo_formacao'+valor_num).val()>0){
								$.get( \"/Candidaturas/delete_formacao/\"+$('#codigo_formacao'+valor_num).val() );
							}
							
							$( '#row_formacao' + valor_num ).remove();

							valor_num--;

							$('input[name=num_formacao]').val(valor_num);
						}
						else{
							alert('Salve essa candidatura para executar a exclusão');
						}
                });  
                $( '#adicionar_experiencia' ).click(function() {
                        var valor_num = $('input[name=num_experiencia]').val();
                        valor_num++;
                        var newElement = '<div id=\"row_experiencia' + valor_num + '\"><div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div><fieldset><legend>Experiência profissional ' + valor_num + '</legend><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Cargo <abbr title="Obrigatório">*</abbr>', "cargo' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";

        $pagina['js'] .= "<input type=\"text\" name=\"cargo' + valor_num + '\" required=\"required\" value=\"\" id=\"cargo' + valor_num + '\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Instituição / empresa <abbr title="Obrigatório">*</abbr>', "empresa' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";

        $pagina['js'] .= "<input type=\"text\" name=\"empresa' + valor_num + '\" required=\"required\" value=\"\" id=\"empresa' + valor_num + '\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Data de início <abbr title="Obrigatório">*</abbr>', "inicio' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><input type=\"date\" name=\"inicio' + valor_num + '\" value=\"\" required=\"required\" id=\"inicio' + valor_num + '\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";


        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Emprego atual?', "emprego_atual' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><select name=\"emprego_atual' + valor_num + '\" id=\"emprego_atual' + valor_num + '\"class=\"form-control\" onchange=\"esconde_data_termino(' + valor_num + ')\"><option value=\"0\">Não</option><option value=\"1\">Sim</option></select></div></div><div class=\"form-group row validated\" id=\"div_termino' + valor_num + '\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Data de término', "fim' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><input type=\"date\" name=\"fim' + valor_num + '\" value=\"\" id=\"fim' + valor_num + '\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Principais atividades desenvolvidas <abbr title="Obrigatório">*</abbr>', "atividades' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><textarea name=\"atividades' + valor_num + '\" rows=\"4\" required=\"required\" id=\"atividades' + valor_num + '\" class=\"form-control\" ></textarea></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'col-lg-12 col-form-label');
        $pagina['js'] .= form_label('Comprovante (inserir arquivo pdf com tamanho máximo de 2MB)', "comprovante' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><input type=\"file\" name=\"comprovante' + valor_num + '\"  class=\"form-control\" onchange=\"checkFile(this)\" /></div>";
        $pagina['js'] .= "</div></fieldset>";
        $pagina['js'] .= "</div>';
                        $( '#div_experiencia' ).append( $(newElement) );
                        $('input[name=num_experiencia]').val(valor_num);
                });
                $( '#remover_experiencia' ).click(function() {
                        var valor_num = $('input[name=num_experiencia]').val();
						if($('#codigo_experiencia'+valor_num).val()>0 || !($('#codigo_experiencia_pai'+valor_num).val()>0)){
							if($('#codigo_experiencia'+valor_num).val()>0){								
								$.get( \"/Candidaturas/delete_experiencia/\"+$('#codigo_experiencia'+valor_num).val() );
							}
							
							$( '#row_experiencia' + valor_num ).remove();
							valor_num--;                                    
							$('input[name=num_experiencia]').val(valor_num);
						}
						else{
							alert('Salve essa candidatura para executar a exclusão');
						}
                });


                $(document).ready(function(){
                        ";
        for ($i = 1; $i <= $num_formacao; $i++) {
            $pagina['js'].="
                            
                                $('#div_carga_horaria{$i}').hide();
                                mostra_carga_horaria({$i});
                                esconde_data_termino({$i});
                                
                              
                                ";
        }
        for ($i = 1;$i <= $num_experiencia; $i++) {
            $pagina['js'].="                            
                                esconde_data_termino({$i});
                              
                                ";
        }
        $pagina['js'].="
                });
        </script>
        
        ";
    //}
    } elseif ($menu2 == 'Questionario') { //questionário
                if (!isset($questoes)) {
                    /*echo "
                                            <script type=\"text/javascript\">
                                                    alert('O criador dessa vaga deve inserir as questões relativa a esse formulário.');
                                                    window.location='/';
                                            </script>";*/
                    if (strlen($sucesso) == 0 || (strlen($sucesso) > 0 && isset($_POST['cadastrar']) && $_POST['cadastrar'] == "Salvar dados")) {
                        echo "
                                                                                    <div class=\"alert background-warning\">
                                                                                            Link para o Fale Conosco: <a href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" class=\"kt-login__link\" target=\"_blank\">Fale conosco</a><br/><br />
                                                                                            
                                                                                    </div>
																					<div class=\"actions clearfix text-center\">
																								Essa vaga não possui requisitos opcionais/desejáveis
																					</div>
																					<div class=\"actions clearfix text-center\">";

                        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
                        echo "
																								
																								<button type=\"reset\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Candidaturas/Curriculo/'.$vaga)."';\">Voltar</button>";
                        //if(isset($questoes)){
                        $attributes = array('class' => 'btn btn-primary');
                        $attributes['id'] = "Salvar";
                        echo form_submit('cadastrar', 'Salvar dados', $attributes);
                        $attributes['id'] = "Concluir";
                        //$attributes["onclick"] = "return false";
                        echo form_submit('cadastrar', 'Finalizar inscrição', $attributes);
                        //}
                        echo "
                                                                                        <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Interromper preenchimento</button>";
                    }
                    echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                } else {
                    if (strlen($sucesso) == 0 || (strlen($sucesso) > 0 && isset($_POST['cadastrar']) && $_POST['cadastrar'] == "Salvar dados")) {
                        echo "
                                                                                    <div class=\"alert background-warning\">
                                                                                            Link para o Fale Conosco: <a href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" class=\"kt-login__link\" target=\"_blank\">Fale conosco</a><br/><br />
                                                                                            
                                                                                    </div>
                                ";
                        /*echo "
                                                                                                                                                                <div class=\"kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper\">
                                                                                                                                                                                ";
                        //var_dump($questoes);
                        $attributes = array('class' => 'kt-form kt-form--label-right',
                                                                'id' => 'form_candidatura');
                        echo form_open($url, $attributes, array('vaga' => $vaga));

                        echo "
                                                                    <div class=\"kt-wizard-v4__content\" data-ktwizard-type=\"step-content\" data-ktwizard-state=\"current\">
                                                                            <div class=\"kt-heading kt-heading--md\">Responda as perguntas abaixo</div>
                                                                            <div class=\"kt-form__section kt-form__section--first\">
                                                                                    <div class=\"kt-wizard-v4__form\">";*/
                        $CI =& get_instance();
                        $CI -> mostra_questoes($questoes, $respostas, $opcoes, $erro, true, '', $anexos);
                        echo form_fieldset_close();
                        /*if(isset($questoes)){
                                $x=0;
                                foreach ($questoes as $row){
                                        $x++;

                                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                        <div class=\"col-md-4 col-lg-2\">";
                                        $attributes = array('class' => 'esquerdo control-label');
                                        $label=$x.') '.strip_tags($row -> tx_questao);
                                        if($row -> bl_obrigatorio){
                                                $label.=' <abbr title="Obrigatório">*</abbr>';
                                        }
                                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                                        echo "
                                                                                        </div>
                                                                                        <div class=\"col-md-8 col-lg-10\">";
                                        if(!isset($Questao[$row -> pr_questao]) || (strlen($Questao[$row -> pr_questao]) == 0 && strlen(set_value('Questao'.$row -> pr_questao)) > 0) || (strlen(set_value('Questao'.$row -> pr_questao)) > 0 && $Questao[$row -> pr_questao] != set_value('Questao'.$row -> pr_questao))){
                                                $Questao[$row -> pr_questao] = set_value('Questao'.$row -> pr_questao);
                                        }

                                        if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){

                                                $valores=array(""=>"",0=>"Não",1=>"Sim");
                                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control is-invalid\" id=\"{Questao'.$row -> pr_questao}\""
                                                }
                                                else{
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control\" id=\"{Questao'.$row -> pr_questao}\""
                                                }
                                        }
                                        else if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){

                                                $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                                }
                                                else{
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                                }
                                        }
                                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'rows'=>'5');
                                                echo form_textarea($attributes, $Questao[$row -> pr_questao], 'class="form-control"');
                                        }
                                        else if(isset($opcoes)){
                                                $valores = array(""=>"");
                                                foreach($opcoes as $opcao){
                                                        if($opcao->es_questao==$row -> pr_questao){
                                                                $valores[$opcao->pr_opcao]=$opcao->tx_opcao;
                                                        }
                                                }

                                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                                }
                                                else{
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $Questao[$row -> pr_questao], "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                                }
                                        }
                                        if(!isset($pr_resposta[$row -> pr_questao]) || (strlen($pr_resposta[$row -> pr_questao]) == 0 && strlen(set_value("codigo_experiencia{$row -> pr_questao}")) > 0) || (strlen(set_value("codigo_experiencia{$row -> pr_questao}")) > 0 && $pr_resposta[$row -> pr_questao] != set_value("codigo_experiencia{$row -> pr_questao}"))){
                                                $pr_resposta[$row -> pr_questao] = set_value("codigo_experiencia{$row -> pr_questao}");
                                        }
                                        echo form_hidden('codigo_resposta'.$row -> pr_questao, $pr_resposta[$row -> pr_questao]);
                                        if(strstr($erro, 'questão '.$x.' ')){
                                                echo "
                                                                                                                                                    <div class=\"invalid-feedback\">
                                                                                                                                                            Preencha essa questão!
                                                                                                                                                    </div>";
                                        }
                                        echo "
                                                                                        </div>
                                                                                    </div>";
                                }
                        }*/


                        echo " 
                                                                                <!--</fieldset>-->
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";

                        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
                        echo "
                                                                                        <button type=\"reset\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Candidaturas/Curriculo/'.$vaga)."';\">Voltar</button>";
                        if (isset($questoes)) {
                            $attributes = array('class' => 'btn btn-primary');
                            $attributes['id'] = "Salvar";
                            $attributes['formnovalidate'] = 'formnovalidate';
                            echo form_submit('cadastrar', 'Salvar dados', $attributes);
                            unset($attributes['formnovalidate']);
                            $attributes['id'] = "Concluir";
                            //$attributes["onclick"] = "return false";
                            echo form_submit('cadastrar', 'Finalizar inscrição', $attributes);
                        }
                        echo "
                                                                                        <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Interromper preenchimento</button>";

                        echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                    }
                    /*echo "
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <div class=\"kt-form__actions\">
                                                                                                                <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";
                    if(isset($questoes)){
                            $attributes = array('class' => 'btn btn-primary');
                            echo form_submit('cadastrar', 'Concluir', $attributes);
                    }

                    echo "
                                                                                                        </div>
                                                                                                </form>
                                                                                        </div>
                                                                                </div>
                                                                        </div>";*/
                }

        //valida_formulario
        $pagina['js'] = "
																			<script type=\"text/javascript\">
																					function checkFile(oFile){
                    
                                                                                        if (oFile.files[0].size > 2097152) // 2 mb for bytes.
                                                                                        {
                                                                                            alert(\"O arquivo deve ter tamanho máximo de 2mb!\");
                                                                                            oFile.value='';
                                                                                        }
                                                                                        else if(oFile.files[0].size == 0){
                                                                                            alert(\"O arquivo não pode ser vazio!\");
                                                                                            oFile.value='';
                                                                                        }
                                                                                    }
																					jQuery(':submit').click(function (event) {
																						if (this.id == 'Concluir') {
																							event.preventDefault();
																							$(document).ready(function(){
																								event.preventDefault();
																								swal.fire({
																									title: 'Aviso de conclusão da candidatura',
																									text: 'Prezado candidato(a), ao concluir a candidatura NÃO será possível editar respostas ou inserir documentos, deseja prossegir? Será enviado um e-mail confirmando a candidatura.',
																									type: 'warning',
																									showCancelButton: true,
																									cancelButtonText: 'Não',
																									confirmButtonText: 'Sim, desejo concluir'
																								})
																								.then(function(result) {
																									if (result.value) {
																										//desfaz as configurações do botão
																										$('#Concluir').unbind(\"click\");
																										//clica, concluindo o processo
																										$('#Concluir').click();
																									}
																									
																								});
																								
																								
																						});
																																												}
																					});
																			</script>
				";
    } elseif ($menu2 == 'TesteAderencia') { //Teste de aderência

        if (strlen($sucesso) == 0) {
            $CI =& get_instance();
            $CI -> mostra_questoes($questoes, $respostas, $opcoes, $erro, true);
            echo form_fieldset_close();

            echo " 
                                                                                
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";


            if (isset($questoes)) {
                $attributes = array('class' => 'btn btn-primary');
                $attributes['formnovalidate'] = 'formnovalidate';
                echo form_submit('salvar', 'Salvar', $attributes);
                unset($attributes['formnovalidate']);
                echo form_submit('salvar', 'Concluir', $attributes);
            }
            echo "
                                                                                        <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";

            echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
        }
    } elseif ($menu2 == 'TesteMotivacao') { //Teste de aderência

        if (strlen($sucesso) == 0) {
            $CI =& get_instance();
            $CI -> mostra_questoes($questoes, $respostas, $opcoes, $erro, true);
            echo form_fieldset_close();

            echo " 
                                                                                
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";


            if (isset($questoes)) {
                $attributes = array('class' => 'btn btn-primary');
                $attributes['formnovalidate'] = 'formnovalidate';
                echo form_submit('salvar', 'Salvar', $attributes);
                unset($attributes['formnovalidate']);
                echo form_submit('salvar', 'Concluir', $attributes);
            }
            echo "
                                                                                        <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";

            echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
        }
    } elseif ($menu2 == 'editDossie') {
        if (strlen($sucesso) == 0) {
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Quais são as expectativas em relação a atuação nesta posição? Quais os resultados quer entregar? Que tipos de desafios acredita que enfrentará? E como pretende transpô-los?", 'expectativa_momento');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";


            $attributes = array('name' => 'expectativa_momento',
                                            'rows'=>'5');
            $tx_expectativa_momento = "";
            if (strlen($candidaturas[0] -> tx_expectativa_momento) > 0) {
                $tx_expectativa_momento = $candidaturas[0] -> tx_expectativa_momento;
            }
            if (strlen(set_value('expectativa_momento')) > 0) {
                $tx_expectativa_momento = set_value('expectativa_momento');
            }

            echo form_textarea($attributes, $tx_expectativa_momento, 'class="form-control"');

            echo "
                                                                                            </div>
                                                                                    </div>";
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Observações relativas ao momento da carreira", 'observacoes_momento');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";


            $attributes = array('name' => 'observacoes_momento',
                                            'rows'=>'5');

            $tx_observacoes_momento = "";
            if (strlen($candidaturas[0] -> tx_observacoes_momento) > 0) {
                $tx_observacoes_momento = $candidaturas[0] -> tx_observacoes_momento;
            }
            if (strlen(set_value('observacoes_momento')) > 0) {
                $tx_observacoes_momento = set_value('observacoes_momento');
            }

            echo form_textarea($attributes, $tx_observacoes_momento, 'class="form-control"');

            echo "
                                                                                            </div>
                                                                                    </div>";
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Pontos fortes", 'pontos_fortes');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";


            $attributes = array('name' => 'pontos_fortes',
                                            'rows'=>'5');

            $tx_pontos_fortes = "";
            if (strlen($candidaturas[0] -> tx_pontos_fortes) > 0) {
                $tx_pontos_fortes = $candidaturas[0] -> tx_pontos_fortes;
            }
            if (strlen(set_value('pontos_fortes')) > 0) {
                $tx_pontos_fortes = set_value('pontos_fortes');
            }

            echo form_textarea($attributes, $tx_pontos_fortes, 'class="form-control"');

            echo "
                                                                                            </div>
                                                                                    </div>";
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Pontos de melhorias", 'pontos_melhorias');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";


            $attributes = array('name' => 'pontos_melhorias',
                                            'rows'=>'5');

            $tx_pontos_melhorias = "";
            if (strlen($candidaturas[0] -> tx_pontos_melhorias) > 0) {
                $tx_pontos_melhorias = $candidaturas[0] -> tx_pontos_melhorias;
            }
            if (strlen(set_value('pontos_melhorias')) > 0) {
                $tx_pontos_melhorias = set_value('pontos_melhorias');
            }

            echo form_textarea($attributes, $tx_pontos_melhorias, 'class="form-control"');

            echo "
                                                                                            </div>
                                                                                    </div>";
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Feedback ao(à) candidato(a)", 'feedback');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";


            $attributes = array('name' => 'feedback',
                                            'rows'=>'5');
            $tx_feedback = "";
            if (strlen($candidaturas[0] -> tx_feedback) > 0) {
                $tx_feedback = $candidaturas[0] -> tx_feedback;
            }
            if (strlen(set_value('feedback')) > 0) {
                $tx_feedback = set_value('feedback');
            }
            echo form_textarea($attributes, $tx_feedback, 'class="form-control"');

            echo "
                                                                                            </div>
                                                                                    </div>";

            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Comentário dos entrevistadores", 'feedback');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";


            $attributes = array('name' => 'comentarios',
                                            'rows'=>'5');
            $tx_comentarios = "";
            if (strlen($candidaturas[0] -> tx_comentarios) > 0) {
                $tx_comentarios = $candidaturas[0] -> tx_comentarios;
            }
            if (strlen(set_value('comentarios')) > 0) {
                $tx_comentarios = set_value('comentarios');
            }
            echo form_textarea($attributes, $tx_comentarios, 'class="form-control"');

            echo "
                                                                                            </div>
                                                                                    </div>";
            echo "
                         
                                                                                
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";


            //if(isset($questoes)){
            $attributes = array('class' => 'btn btn-primary');
            echo form_submit('salvar', 'Salvar e gerar o dossiê', $attributes);
            //echo form_submit('salvar', 'Concluir', $attributes);
            //}
            echo "
                                                                                        <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";

            echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
        }
    } elseif ($menu2 == 'HBDI') {
        if (strlen($sucesso) == 0) {
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Quais sentidos ou situações fazem você se sentir mais motivado no trabalho? (Assinale cinco alternativas):", 'MotivacaoTrabalho1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";
            $MotivacaoTrabalho1 = '';
            if (isset($hbdi -> bl_motivacao_trabalho1) && strlen($hbdi -> bl_motivacao_trabalho1) > 0) {
                $MotivacaoTrabalho1 = $hbdi -> bl_motivacao_trabalho1;
            }
            if (strlen(set_value('MotivacaoTrabalho1')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho1 = set_value('MotivacaoTrabalho1');
            }
            $attributes = array('id'=>'MotivacaoTrabalho1','name' => 'MotivacaoTrabalho1', 'value' => '1','onchange'=>"questao20(1,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho1, ($MotivacaoTrabalho1=='1' && strlen($MotivacaoTrabalho1)>0));
            echo "
                                                                                                <span>1.1 Trabalhar sozinho</span><br />";
            $MotivacaoTrabalho2 = '';
            if (isset($hbdi -> bl_motivacao_trabalho2) && strlen($hbdi -> bl_motivacao_trabalho2) > 0) {
                $MotivacaoTrabalho2 = $hbdi -> bl_motivacao_trabalho2;
            }
            if (strlen(set_value('MotivacaoTrabalho2')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho2 = set_value('MotivacaoTrabalho2');
            }
            $attributes = array('id'=>'MotivacaoTrabalho2','name' => 'MotivacaoTrabalho2', 'value' => '1','onchange'=>"questao20(2,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho2, ($MotivacaoTrabalho2=='1' && strlen($MotivacaoTrabalho2)>0));
            echo "
                                                                                                <span>1.2 Expressar minhas ideias</span><br />";
            $MotivacaoTrabalho3 = '';
            if (isset($hbdi -> bl_motivacao_trabalho3) && strlen($hbdi -> bl_motivacao_trabalho3) > 0) {
                $MotivacaoTrabalho3 = $hbdi -> bl_motivacao_trabalho3;
            }
            if (strlen(set_value('MotivacaoTrabalho3')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho3 = set_value('MotivacaoTrabalho3');
            }
            $attributes = array('id'=>'MotivacaoTrabalho3','name' => 'MotivacaoTrabalho3', 'value' => '1','onchange'=>"questao20(3,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho3, ($MotivacaoTrabalho3=='1' && strlen($MotivacaoTrabalho3)>0));
            echo "
                                                                                                <span>1.3 Estar no controle da situação</span><br />";
            $MotivacaoTrabalho4 = '';
            if (isset($hbdi -> bl_motivacao_trabalho4) && strlen($hbdi -> bl_motivacao_trabalho4) > 0) {
                $MotivacaoTrabalho4 = $hbdi -> bl_motivacao_trabalho4;
            }
            if (strlen(set_value('MotivacaoTrabalho4')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho4 = set_value('MotivacaoTrabalho4');
            }
            $attributes = array('id'=>'MotivacaoTrabalho4','name' => 'MotivacaoTrabalho4', 'value' => '1','onchange'=>"questao20(4,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho4, ($MotivacaoTrabalho4=='1' && strlen($MotivacaoTrabalho4)>0));
            echo "
                                                                                                <span>1.4 Provocar mudanças</span><br />";
            $MotivacaoTrabalho5 = '';
            if (isset($hbdi -> bl_motivacao_trabalho5) && strlen($hbdi -> bl_motivacao_trabalho5) > 0) {
                $MotivacaoTrabalho5 = $hbdi -> bl_motivacao_trabalho5;
            }
            if (strlen(set_value('MotivacaoTrabalho5')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho5 = set_value('MotivacaoTrabalho5');
            }
            $attributes = array('id'=>'MotivacaoTrabalho5','name' => 'MotivacaoTrabalho5', 'value' => '1','onchange'=>"questao20(5,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho5, ($MotivacaoTrabalho5=='1' && strlen($MotivacaoTrabalho5)>0));
            echo "
                                                                                                <span>1.5 Ouvir e falar</span><br />";
            $MotivacaoTrabalho6 = '';
            if (isset($hbdi -> bl_motivacao_trabalho6) && strlen($hbdi -> bl_motivacao_trabalho6) > 0) {
                $MotivacaoTrabalho6 = $hbdi -> bl_motivacao_trabalho6;
            }
            if (strlen(set_value('MotivacaoTrabalho6')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho6 = set_value('MotivacaoTrabalho6');
            }
            $attributes = array('id'=>'MotivacaoTrabalho6','name' => 'MotivacaoTrabalho6', 'value' => '1','onchange'=>"questao20(6,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho6, ($MotivacaoTrabalho6=='1' && strlen($MotivacaoTrabalho6)>0));
            echo "
                                                                                                <span>1.6 Criar ou usar recursos visuais</span><br />";
            $MotivacaoTrabalho7 = '';
            if (isset($hbdi -> bl_motivacao_trabalho7) && strlen($hbdi -> bl_motivacao_trabalho7) > 0) {
                $MotivacaoTrabalho7 = $hbdi -> bl_motivacao_trabalho7;
            }
            if (strlen(set_value('MotivacaoTrabalho7')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho7 = set_value('MotivacaoTrabalho7');
            }
            $attributes = array('id'=>'MotivacaoTrabalho7','name' => 'MotivacaoTrabalho7', 'value' => '1','onchange'=>"questao20(7,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho7, ($MotivacaoTrabalho7=='1' && strlen($MotivacaoTrabalho7)>0));
            echo "
                                                                                                <span>1.7 Prestar atenção aos detalhes</span><br />";
            $MotivacaoTrabalho8 = '';
            if (isset($hbdi -> bl_motivacao_trabalho8) && strlen($hbdi -> bl_motivacao_trabalho8) > 0) {
                $MotivacaoTrabalho8 = $hbdi -> bl_motivacao_trabalho8;
            }
            if (strlen(set_value('MotivacaoTrabalho8')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho8 = set_value('MotivacaoTrabalho8');
            }
            $attributes = array('id'=>'MotivacaoTrabalho8','name' => 'MotivacaoTrabalho8', 'value' => '1','onchange'=>"questao20(8,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho8, ($MotivacaoTrabalho8=='1' && strlen($MotivacaoTrabalho8)>0));
            echo "
                                                                                                <span>1.8 Aspectos técnicos</span><br />";
            $MotivacaoTrabalho9 = '';
            if (isset($hbdi -> bl_motivacao_trabalho9) && strlen($hbdi -> bl_motivacao_trabalho9) > 0) {
                $MotivacaoTrabalho9 = $hbdi -> bl_motivacao_trabalho9;
            }
            if (strlen(set_value('MotivacaoTrabalho9')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho9 = set_value('MotivacaoTrabalho9');
            }
            $attributes = array('id'=>'MotivacaoTrabalho9','name' => 'MotivacaoTrabalho9', 'value' => '1','onchange'=>"questao20(9,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, set_value('MotivacaoTrabalho9'), ($MotivacaoTrabalho9=='1' && strlen($MotivacaoTrabalho9)>0));
            echo "
                                                                                                <span>1.9 Trabalhar com pessoas</span><br />";
            $MotivacaoTrabalho10 = '';
            if (isset($hbdi -> bl_motivacao_trabalho10) && strlen($hbdi -> bl_motivacao_trabalho10) > 0) {
                $MotivacaoTrabalho10 = $hbdi -> bl_motivacao_trabalho10;
            }
            if (strlen(set_value('MotivacaoTrabalho10')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho10 = set_value('MotivacaoTrabalho10');
            }
            $attributes = array('id'=>'MotivacaoTrabalho10','name' => 'MotivacaoTrabalho10', 'value' => '1','onchange'=>"questao20(10,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho10, ($MotivacaoTrabalho10=='1' && strlen($MotivacaoTrabalho10)>0));
            echo "
                                                                                                <span>1.10 Usar números e estatísticas</span><br />";
            $MotivacaoTrabalho11 = '';
            if (isset($hbdi -> bl_motivacao_trabalho11) && strlen($hbdi -> bl_motivacao_trabalho11) > 0) {
                $MotivacaoTrabalho11 = $hbdi -> bl_motivacao_trabalho11;
            }
            if (strlen(set_value('MotivacaoTrabalho11')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho11 = set_value('MotivacaoTrabalho11');
            }
            $attributes = array('id'=>'MotivacaoTrabalho11','name' => 'MotivacaoTrabalho11', 'value' => '1','onchange'=>"questao20(11,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho11, ($MotivacaoTrabalho11=='1' && strlen($MotivacaoTrabalho11)>0));
            echo "
                                                                                                <span>1.11 Oportunidades para fazer experiências</span><br />";
            $MotivacaoTrabalho12 = '';
            if (isset($hbdi -> bl_motivacao_trabalho12) && strlen($hbdi -> bl_motivacao_trabalho12) > 0) {
                $MotivacaoTrabalho12 = $hbdi -> bl_motivacao_trabalho12;
            }
            if (strlen(set_value('MotivacaoTrabalho12')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho12 = set_value('MotivacaoTrabalho12');
            }
            $attributes = array('id'=>'MotivacaoTrabalho12','name' => 'MotivacaoTrabalho12', 'value' => '1','onchange'=>"questao20(12,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho12, ($MotivacaoTrabalho12=='1' && strlen($MotivacaoTrabalho12)>0));
            echo "
                                                                                                <span>1.12 Planejar</span><br />";
            $MotivacaoTrabalho13 = '';
            if (isset($hbdi -> bl_motivacao_trabalho13) && strlen($hbdi -> bl_motivacao_trabalho13) > 0) {
                $MotivacaoTrabalho13 = $hbdi -> bl_motivacao_trabalho13;
            }
            if (strlen(set_value('MotivacaoTrabalho13')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho13 = set_value('MotivacaoTrabalho13');
            }
            $attributes = array('id'=>'MotivacaoTrabalho13','name' => 'MotivacaoTrabalho13', 'value' => '1','onchange'=>"questao20(13,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho13, ($MotivacaoTrabalho13=='1' && strlen($MotivacaoTrabalho13)>0));
            echo "
                                                                                                <span>1.13 Trabalhar com comunicação</span><br />";
            $MotivacaoTrabalho14 = '';
            if (isset($hbdi -> bl_motivacao_trabalho14) && strlen($hbdi -> bl_motivacao_trabalho14) > 0) {
                $MotivacaoTrabalho14 = $hbdi -> bl_motivacao_trabalho14;
            }
            if (strlen(set_value('MotivacaoTrabalho14')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho14 = set_value('MotivacaoTrabalho14');
            }
            $attributes = array('id'=>'MotivacaoTrabalho14','name' => 'MotivacaoTrabalho14', 'value' => '1','onchange'=>"questao20(14,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho14, ($MotivacaoTrabalho14=='1' && strlen($MotivacaoTrabalho14)>0));
            echo "
                                                                                                <span>1.14 Fazer algo funcionar</span><br />";
            $MotivacaoTrabalho15 = '';
            if (isset($hbdi -> bl_motivacao_trabalho15) && strlen($hbdi -> bl_motivacao_trabalho15) > 0) {
                $MotivacaoTrabalho15 = $hbdi -> bl_motivacao_trabalho15;
            }
            if (strlen(set_value('MotivacaoTrabalho15')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho15 = set_value('MotivacaoTrabalho15');
            }
            $attributes = array('id'=>'MotivacaoTrabalho15','name' => 'MotivacaoTrabalho15', 'value' => '1','onchange'=>"questao20(15,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho15, ($MotivacaoTrabalho15=='1' && strlen($MotivacaoTrabalho15)>0));
            echo "
                                                                                                <span>1.15 Arriscar-se</span><br />";
            $MotivacaoTrabalho16 = '';
            if (isset($hbdi -> bl_motivacao_trabalho16) && strlen($hbdi -> bl_motivacao_trabalho16) > 0) {
                $MotivacaoTrabalho16 = $hbdi -> bl_motivacao_trabalho16;
            }
            if (strlen(set_value('MotivacaoTrabalho16')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho16 = set_value('MotivacaoTrabalho16');
            }
            $attributes = array('id'=>'MotivacaoTrabalho16','name' => 'MotivacaoTrabalho16', 'value' => '1','onchange'=>"questao20(16,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho16, ($MotivacaoTrabalho16=='1' && strlen($MotivacaoTrabalho16)>0));
            echo "
                                                                                                <span>1.16 Analisar dados</span><br />";
            $MotivacaoTrabalho17 = '';
            if (isset($hbdi -> bl_motivacao_trabalho17) && strlen($hbdi -> bl_motivacao_trabalho17) > 0) {
                $MotivacaoTrabalho17 = $hbdi -> bl_motivacao_trabalho17;
            }
            if (strlen(set_value('MotivacaoTrabalho17')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho17 = set_value('MotivacaoTrabalho17');
            }
            $attributes = array('id'=>'MotivacaoTrabalho17','name' => 'MotivacaoTrabalho17', 'value' => '1','onchange'=>"questao20(17,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho17, ($MotivacaoTrabalho17=='1' && strlen($MotivacaoTrabalho17)>0));
            echo "
                                                                                                <span>1.17 Lidar com o futuro</span><br />";
            $MotivacaoTrabalho18 = '';
            if (isset($hbdi -> bl_motivacao_trabalho18) && strlen($hbdi -> bl_motivacao_trabalho18) > 0) {
                $MotivacaoTrabalho18 = $hbdi -> bl_motivacao_trabalho18;
            }
            if (strlen(set_value('MotivacaoTrabalho18')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho18 = set_value('MotivacaoTrabalho18');
            }
            $attributes = array('id'=>'MotivacaoTrabalho18','name' => 'MotivacaoTrabalho18', 'value' => '1','onchange'=>"questao20(18,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho18, ($MotivacaoTrabalho18=='1' && strlen($MotivacaoTrabalho18)>0));
            echo "
                                                                                                <span>1.18 Produzir e organizar</span><br />";
            $MotivacaoTrabalho19 = '';
            if (isset($hbdi -> bl_motivacao_trabalho19) && strlen($hbdi -> bl_motivacao_trabalho19) > 0) {
                $MotivacaoTrabalho19 = $hbdi -> bl_motivacao_trabalho19;
            }
            if (strlen(set_value('MotivacaoTrabalho19')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho19 = set_value('MotivacaoTrabalho19');
            }
            $attributes = array('id'=>'MotivacaoTrabalho19','name' => 'MotivacaoTrabalho19', 'value' => '1','onchange'=>"questao20(19,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho19, ($MotivacaoTrabalho19=='1' && strlen($MotivacaoTrabalho19)>0));
            echo "
                                                                                                <span>1.19 Fazer parte de uma equipe</span><br />";
            $MotivacaoTrabalho20 = '';
            if (isset($hbdi -> bl_motivacao_trabalho20) && strlen($hbdi -> bl_motivacao_trabalho20) > 0) {
                $MotivacaoTrabalho20 = $hbdi -> bl_motivacao_trabalho20;
            }
            if (strlen(set_value('MotivacaoTrabalho20')) > 0 || strlen(set_value('salvar'))>0) {
                $MotivacaoTrabalho20 = set_value('MotivacaoTrabalho20');
            }
            $attributes = array('id'=>'MotivacaoTrabalho20','name' => 'MotivacaoTrabalho20', 'value' => '1','onchange'=>"questao20(20,'MotivacaoTrabalho')");
            echo form_checkbox($attributes, $MotivacaoTrabalho20, ($MotivacaoTrabalho20=='1' && strlen($MotivacaoTrabalho20)>0));
            echo "
                                                                                                <span>1.20 Fazer as coisas sempre no prazo previsto</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("2. Quando aprendo, gosto de... (Assinale cinco alternativas):", 'Gosto1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Gosto1 = '';
            if (isset($hbdi -> bl_gosto1) && strlen($hbdi -> bl_gosto1) > 0) {
                $Gosto1 = $hbdi -> bl_gosto1;
            }
            if (strlen(set_value('Gosto1')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto1 = set_value('Gosto1');
            }
            $attributes = array('id'=>'Gosto1','name' => 'Gosto1', 'value' => '1','onchange'=>"questao20(1,'Gosto')");
            echo form_checkbox($attributes, $Gosto1, ($Gosto1=='1' && strlen($Gosto1)>0));
            echo "
                                                                                                <span>2.1 Avaliar e testar teorias</span><br />";
            $Gosto2 = '';
            if (isset($hbdi -> bl_gosto2) && strlen($hbdi -> bl_gosto2) > 0) {
                $Gosto2 = $hbdi -> bl_gosto2;
            }
            if (strlen(set_value('Gosto2')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto2 = set_value('Gosto2');
            }
            $attributes = array('id'=>'Gosto2','name' => 'Gosto2', 'value' => '1','onchange'=>"questao20(2,'Gosto')");
            echo form_checkbox($attributes, $Gosto2, ($Gosto2=='1' && strlen($Gosto2)>0));
            echo "
                                                                                                <span>2.2 Obter e quantificar fatos</span><br />";
            $Gosto3 = '';
            if (isset($hbdi -> bl_gosto3) && strlen($hbdi -> bl_gosto3) > 0) {
                $Gosto3 = $hbdi -> bl_gosto3;
            }
            if (strlen(set_value('Gosto3')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto3 = set_value('Gosto3');
            }
            $attributes = array('id'=>'Gosto3','name' => 'Gosto3', 'value' => '1','onchange'=>"questao20(3,'Gosto')");
            echo form_checkbox($attributes, $Gosto3, ($Gosto3=='1' && strlen($Gosto3)>0));
            echo "
                                                                                                <span>2.3 Ouvir e compartilhar ideias</span><br />";
            $Gosto4 = '';
            if (isset($hbdi -> bl_gosto4) && strlen($hbdi -> bl_gosto4) > 0) {
                $Gosto4 = $hbdi -> bl_gosto4;
            }
            if (strlen(set_value('Gosto4')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto4 = set_value('Gosto4');
            }
            $attributes = array('id'=>'Gosto4','name' => 'Gosto4', 'value' => '1','onchange'=>"questao20(4,'Gosto')");
            echo form_checkbox($attributes, $Gosto4, ($Gosto4=='1' && strlen($Gosto4)>0));
            echo "
                                                                                                <span>2.4 Usar minha imaginação</span><br />";
            $Gosto5 = '';
            if (isset($hbdi -> bl_gosto5) && strlen($hbdi -> bl_gosto5) > 0) {
                $Gosto5 = $hbdi -> bl_gosto5;
            }
            if (strlen(set_value('Gosto5')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto5 = set_value('Gosto5');
            }
            $attributes = array('id'=>'Gosto5','name' => 'Gosto5', 'value' => '1','onchange'=>"questao20(5,'Gosto')");
            echo form_checkbox($attributes, $Gosto5, ($Gosto5=='1' && strlen($Gosto5)>0));
            echo "
                                                                                                <span>2.5 Aplicar análise e lógica</span><br />";
            $Gosto6 = '';
            if (isset($hbdi -> bl_gosto6) && strlen($hbdi -> bl_gosto6) > 0) {
                $Gosto6 = $hbdi -> bl_gosto6;
            }
            if (strlen(set_value('Gosto6')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto6 = set_value('Gosto6');
            }
            $attributes = array('id'=>'Gosto6','name' => 'Gosto6', 'value' => '1','onchange'=>"questao20(6,'Gosto')");
            echo form_checkbox($attributes, $Gosto6, ($Gosto6=='1' && strlen($Gosto6)>0));
            echo "
                                                                                                <span>2.6 Ambiente bem informal</span><br />";
            $Gosto7 = '';
            if (isset($hbdi -> bl_gosto7) && strlen($hbdi -> bl_gosto7) > 0) {
                $Gosto7 = $hbdi -> bl_gosto7;
            }
            if (strlen(set_value('Gosto7')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto7 = set_value('Gosto7');
            }
            $attributes = array('id'=>'Gosto7','name' => 'Gosto7', 'value' => '1','onchange'=>"questao20(7,'Gosto')");
            echo form_checkbox($attributes, $Gosto7, ($Gosto7=='1' && strlen($Gosto7)>0));
            echo "
                                                                                                <span>2.7 Verificar meu entendimento</span><br />";
            $Gosto8 = '';
            if (isset($hbdi -> bl_gosto8) && strlen($hbdi -> bl_gosto8) > 0) {
                $Gosto8 = $hbdi -> bl_gosto8;
            }
            if (strlen(set_value('Gosto8')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto8 = set_value('Gosto8');
            }
            $attributes = array('id'=>'Gosto8','name' => 'Gosto8', 'value' => '1','onchange'=>"questao20(8,'Gosto')");
            echo form_checkbox($attributes, $Gosto8, ($Gosto8=='1' && strlen($Gosto8)>0));
            echo "
                                                                                                <span>2.8 Fazer experiências práticas</span><br />";
            $Gosto9 = '';
            if (isset($hbdi -> bl_gosto9) && strlen($hbdi -> bl_gosto9) > 0) {
                $Gosto9 = $hbdi -> bl_gosto9;
            }
            if (strlen(set_value('Gosto9')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto9 = set_value('Gosto9');
            }
            $attributes = array('id'=>'Gosto9','name' => 'Gosto9', 'value' => '1','onchange'=>"questao20(9,'Gosto')");
            echo form_checkbox($attributes, $Gosto9, ($Gosto9=='1' && strlen($Gosto9)>0));
            echo "
                                                                                                <span>2.9 Pensar sobre as ideias</span><br />";
            $Gosto10 = '';
            if (isset($hbdi -> bl_gosto10) && strlen($hbdi -> bl_gosto10) > 0) {
                $Gosto10 = $hbdi -> bl_gosto10;
            }
            if (strlen(set_value('Gosto10')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto10 = set_value('Gosto10');
            }
            $attributes = array('id'=>'Gosto10','name' => 'Gosto10', 'value' => '1','onchange'=>"questao20(10,'Gosto')");
            echo form_checkbox($attributes, $Gosto10, ($Gosto10=='1' && strlen($Gosto10)>0));
            echo "
                                                                                                <span>2.10 Confiar nas intuições</span><br />";
            $Gosto11 = '';
            if (isset($hbdi -> bl_gosto11) && strlen($hbdi -> bl_gosto11) > 0) {
                $Gosto11 = $hbdi -> bl_gosto11;
            }
            if (strlen(set_value('Gosto11')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto11 = set_value('Gosto11');
            }
            $attributes = array('id'=>'Gosto11','name' => 'Gosto11', 'value' => '1','onchange'=>"questao20(11,'Gosto')");
            echo form_checkbox($attributes, $Gosto11, ($Gosto11=='1' && strlen($Gosto11)>0));
            echo "
                                                                                                <span>2.11 Receber informações passo a passo</span><br />";
            $Gosto12 = '';
            if (isset($hbdi -> bl_gosto12) && strlen($hbdi -> bl_gosto12) > 0) {
                $Gosto12 = $hbdi -> bl_gosto12;
            }
            if (strlen(set_value('Gosto12')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto12 = set_value('Gosto12');
            }
            $attributes = array('id'=>'Gosto12','name' => 'Gosto12', 'value' => '1','onchange'=>"questao20(12,'Gosto')");
            echo form_checkbox($attributes, $Gosto12, ($Gosto12=='1' && strlen($Gosto12)>0));
            echo "
                                                                                                <span>2.12 Tomar iniciativas</span><br />";
            $Gosto13 = '';
            if (isset($hbdi -> bl_gosto13) && strlen($hbdi -> bl_gosto13) > 0) {
                $Gosto13 = $hbdi -> bl_gosto13;
            }
            if (strlen(set_value('Gosto13')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto13 = set_value('Gosto13');
            }
            $attributes = array('id'=>'Gosto13','name' => 'Gosto13', 'value' => '1','onchange'=>"questao20(13,'Gosto')");
            echo form_checkbox($attributes, $Gosto13, ($Gosto13=='1' && strlen($Gosto13)>0));
            echo "
                                                                                                <span>2.13 Elaborar teorias</span><br />";
            $Gosto14 = '';
            if (isset($hbdi -> bl_gosto14) && strlen($hbdi -> bl_gosto14) > 0) {
                $Gosto14 = $hbdi -> bl_gosto14;
            }
            if (strlen(set_value('Gosto14')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto14 = set_value('Gosto14');
            }
            $attributes = array('id'=>'Gosto14','name' => 'Gosto14', 'value' => '1','onchange'=>"questao20(14,'Gosto')");
            echo form_checkbox($attributes, $Gosto14, ($Gosto14=='1' && strlen($Gosto14)>0));
            echo "
                                                                                                <span>2.14 Envolvimento emocional</span><br />";
            $Gosto15 = '';
            if (isset($hbdi -> bl_gosto15) && strlen($hbdi -> bl_gosto15) > 0) {
                $Gosto15 = $hbdi -> bl_gosto15;
            }
            if (strlen(set_value('Gosto15')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto15 = set_value('Gosto15');
            }
            $attributes = array('id'=>'Gosto15','name' => 'Gosto15', 'value' => '1','onchange'=>"questao20(15,'Gosto')");
            echo form_checkbox($attributes, $Gosto15, ($Gosto15=='1' && strlen($Gosto15)>0));
            echo "
                                                                                                <span>2.15 Trabalhar em grupo</span><br />";
            $Gosto16 = '';
            if (isset($hbdi -> bl_gosto16) && strlen($hbdi -> bl_gosto16) > 0) {
                $Gosto16 = $hbdi -> bl_gosto16;
            }
            if (strlen(set_value('Gosto16')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto16 = set_value('Gosto16');
            }
            $attributes = array('id'=>'Gosto16','name' => 'Gosto16', 'value' => '1','onchange'=>"questao20(16,'Gosto')");
            echo form_checkbox($attributes, $Gosto16, ($Gosto16=='1' && strlen($Gosto16)>0));
            echo "
                                                                                                <span>2.16 Orientações claras</span><br />";
            $Gosto17 = '';
            if (isset($hbdi -> bl_gosto17) && strlen($hbdi -> bl_gosto17) > 0) {
                $Gosto17 = $hbdi -> bl_gosto17;
            }
            if (strlen(set_value('Gosto17')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto17 = set_value('Gosto17');
            }
            $attributes = array('id'=>'Gosto17','name' => 'Gosto17', 'value' => '1','onchange'=>"questao20(17,'Gosto')");
            echo form_checkbox($attributes, $Gosto17, ($Gosto17=='1' && strlen($Gosto17)>0));
            echo "
                                                                                                <span>2.17 Fazer descobertas</span><br />";
            $Gosto18 = '';
            if (isset($hbdi -> bl_gosto18) && strlen($hbdi -> bl_gosto18) > 0) {
                $Gosto18 = $hbdi -> bl_gosto18;
            }
            if (strlen(set_value('Gosto18')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto18 = set_value('Gosto18');
            }
            $attributes = array('id'=>'Gosto18','name' => 'Gosto18', 'value' => '1','onchange'=>"questao20(18,'Gosto')");
            echo form_checkbox($attributes, $Gosto18, ($Gosto18=='1' && strlen($Gosto18)>0));
            echo "
                                                                                                <span>2.18 Criticar</span><br />";
            $Gosto19 = '';
            if (isset($hbdi -> bl_gosto19) && strlen($hbdi -> bl_gosto19) > 0) {
                $Gosto19 = $hbdi -> bl_gosto19;
            }
            if (strlen(set_value('Gosto19')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto19 = set_value('Gosto19');
            }
            $attributes = array('id'=>'Gosto19','name' => 'Gosto19', 'value' => '1','onchange'=>"questao20(19,'Gosto')");
            echo form_checkbox($attributes, $Gosto19, ($Gosto19=='1' && strlen($Gosto19)>0));
            echo "
                                                                                                <span>2.19 Perceber logo o quadro geral (o objetivo final)</span><br />";
            $Gosto20 = '';
            if (isset($hbdi -> bl_gosto20) && strlen($hbdi -> bl_gosto20) > 0) {
                $Gosto20 = $hbdi -> bl_gosto20;
            }
            if (strlen(set_value('Gosto20')) > 0 || strlen(set_value('salvar'))>0) {
                $Gosto20 = set_value('Gosto20');
            }
            $attributes = array('id'=>'Gosto20','name' => 'Gosto20', 'value' => '1','onchange'=>"questao20(20,'Gosto')");
            echo form_checkbox($attributes, $Gosto20, ($Gosto20=='1' && strlen($Gosto20)>0));
            echo "
                                                                                                <span>2.20 Adquirir habilidades pela prática</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("3. Prefiro aprender por meio de… (Assinale cinco alternativas):", 'Prefiro1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Prefiro1 = '';
            if (isset($hbdi -> bl_prefiro1) && strlen($hbdi -> bl_prefiro1) > 0) {
                $Prefiro1 = $hbdi -> bl_prefiro1;
            }
            if (strlen(set_value('Prefiro1')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro1 = set_value('Prefiro1');
            }
            $attributes = array('id'=>'Prefiro1','name' => 'Prefiro1', 'value' => '1','onchange'=>"questao20(1,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro1, ($Prefiro1=='1' && strlen($Prefiro1)>0));
            echo "
                                                                                                <span>3.1 Materiais visuais</span><br />";
            $Prefiro2 = '';
            if (isset($hbdi -> bl_prefiro2) && strlen($hbdi -> bl_prefiro2) > 0) {
                $Prefiro2 = $hbdi -> bl_prefiro2;
            }
            if (strlen(set_value('Prefiro2')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro2 = set_value('Prefiro2');
            }
            $attributes = array('id'=>'Prefiro2','name' => 'Prefiro2', 'value' => '1','onchange'=>"questao20(2,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro2, ($Prefiro2=='1' && strlen($Prefiro2)>0));
            echo "
                                                                                                <span>3.2 Demonstrações</span><br />";
            $Prefiro3 = '';
            if (isset($hbdi -> bl_prefiro3) && strlen($hbdi -> bl_prefiro3) > 0) {
                $Prefiro3 = $hbdi -> bl_prefiro3;
            }
            if (strlen(set_value('Prefiro3')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro3 = set_value('Prefiro3');
            }
            $attributes = array('id'=>'Prefiro3','name' => 'Prefiro3', 'value' => '1','onchange'=>"questao20(3,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro3, ($Prefiro3=='1' && strlen($Prefiro3)>0));
            echo "
                                                                                                <span>3.3 Debates estruturados pelo instrutor</span><br />";
            $Prefiro4 = '';
            if (isset($hbdi -> bl_prefiro4) && strlen($hbdi -> bl_prefiro4) > 0) {
                $Prefiro4 = $hbdi -> bl_prefiro4;
            }
            if (strlen(set_value('Prefiro4')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro4 = set_value('Prefiro4');
            }
            $attributes = array('id'=>'Prefiro4','name' => 'Prefiro4', 'value' => '1','onchange'=>"questao20(4,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro4, ($Prefiro4=='1' && strlen($Prefiro4)>0));
            echo "
                                                                                                <span>3.4 Palestras formais</span><br />";
            $Prefiro5 = '';
            if (isset($hbdi -> bl_prefiro5) && strlen($hbdi -> bl_prefiro5) > 0) {
                $Prefiro5 = $hbdi -> bl_prefiro5;
            }
            if (strlen(set_value('Prefiro5')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro5 = set_value('Prefiro5');
            }
            $attributes = array('id'=>'Prefiro5','name' => 'Prefiro5', 'value' => '1','onchange'=>"questao20(5,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro5, ($Prefiro5=='1' && strlen($Prefiro5)>0));
            echo "
                                                                                                <span>3.5 Experiências</span><br />";
            $Prefiro6 = '';
            if (isset($hbdi -> bl_prefiro6) && strlen($hbdi -> bl_prefiro6) > 0) {
                $Prefiro6 = $hbdi -> bl_prefiro6;
            }
            if (strlen(set_value('Prefiro6')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro6 = set_value('Prefiro6');
            }
            $attributes = array('id'=>'Prefiro6','name' => 'Prefiro6', 'value' => '1','onchange'=>"questao20(6,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro6, ($Prefiro6=='1' && strlen($Prefiro6)>0));
            echo "
                                                                                                <span>3.6 Utilizando histórias e música</span><br />";
            $Prefiro7 = '';
            if (isset($hbdi -> bl_prefiro7) && strlen($hbdi -> bl_prefiro7) > 0) {
                $Prefiro7 = $hbdi -> bl_prefiro7;
            }
            if (strlen(set_value('Prefiro7')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro7 = set_value('Prefiro7');
            }
            $attributes = array('id'=>'Prefiro7','name' => 'Prefiro7', 'value' => '1','onchange'=>"questao20(7,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro7, ($Prefiro7=='1' && strlen($Prefiro7)>0));
            echo "
                                                                                                <span>3.7 Exercícios que usam a intuição</span><br />";
            $Prefiro8 = '';
            if (isset($hbdi -> bl_prefiro8) && strlen($hbdi -> bl_prefiro8) > 0) {
                $Prefiro8 = $hbdi -> bl_prefiro8;
            }
            if (strlen(set_value('Prefiro8')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro8 = set_value('Prefiro8');
            }
            $attributes = array('id'=>'Prefiro8','name' => 'Prefiro8', 'value' => '1','onchange'=>"questao20(8,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro8, ($Prefiro8=='1' && strlen($Prefiro8)>0));
            echo "
                                                                                                <span>3.8 Debate em grupo</span><br />";
            $Prefiro9 = '';
            if (isset($hbdi -> bl_prefiro9) && strlen($hbdi -> bl_prefiro9) > 0) {
                $Prefiro9 = $hbdi -> bl_prefiro9;
            }
            if (strlen(set_value('Prefiro9')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro9 = set_value('Prefiro9');
            }
            $attributes = array('id'=>'Prefiro9','name' => 'Prefiro9', 'value' => '1','onchange'=>"questao20(9,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro9, ($Prefiro9=='1' && strlen($Prefiro9)>0));
            echo "
                                                                                                <span>3.9 Exercícios de análise</span><br />";
            $Prefiro10 = '';
            if (isset($hbdi -> bl_prefiro10) && strlen($hbdi -> bl_prefiro10) > 0) {
                $Prefiro10 = $hbdi -> bl_prefiro10;
            }
            if (strlen(set_value('Prefiro10')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro10 = set_value('Prefiro10');
            }
            $attributes = array('id'=>'Prefiro10','name' => 'Prefiro10', 'value' => '1','onchange'=>"questao20(10,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro10, ($Prefiro10=='1' && strlen($Prefiro10)>0));
            echo "
                                                                                                <span>3.10 Atividades sequenciais bem planejadas</span><br />";
            $Prefiro11 = '';
            if (isset($hbdi -> bl_prefiro11) && strlen($hbdi -> bl_prefiro11) > 0) {
                $Prefiro11 = $hbdi -> bl_prefiro11;
            }
            if (strlen(set_value('Prefiro11')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro11 = set_value('Prefiro11');
            }
            $attributes = array('id'=>'Prefiro11','name' => 'Prefiro11', 'value' => '1','onchange'=>"questao20(11,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro11, ($Prefiro11=='1' && strlen($Prefiro11)>0));
            echo "
                                                                                                <span>3.11 Analisando números; dados e fatos</span><br />";
            $Prefiro12 = '';
            if (isset($hbdi -> bl_prefiro12) && strlen($hbdi -> bl_prefiro12) > 0) {
                $Prefiro12 = $hbdi -> bl_prefiro12;
            }
            if (strlen(set_value('Prefiro12')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro12 = set_value('Prefiro12');
            }
            $attributes = array('id'=>'Prefiro12','name' => 'Prefiro12', 'value' => '1','onchange'=>"questao20(12,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro12, ($Prefiro12=='1' && strlen($Prefiro12)>0));
            echo "
                                                                                                <span>3.12 Exemplos com metáforas</span><br />";
            $Prefiro13 = '';
            if (isset($hbdi -> bl_prefiro13) && strlen($hbdi -> bl_prefiro13) > 0) {
                $Prefiro13 = $hbdi -> bl_prefiro13;
            }
            if (strlen(set_value('Prefiro13')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro13 = set_value('Prefiro13');
            }
            $attributes = array('id'=>'Prefiro13','name' => 'Prefiro13', 'value' => '1','onchange'=>"questao20(13,'Prefiro')");
            echo form_checkbox($attributes, set_value('Prefiro13'), (set_value('Prefiro13')=='1' && strlen(set_value('Prefiro13'))>0));
            echo "
                                                                                                <span>3.13 Atividades passo a passo de reforço do conteúdo</span><br />";
            $Prefiro14 = '';
            if (isset($hbdi -> bl_prefiro14) && strlen($hbdi -> bl_prefiro14) > 0) {
                $Prefiro14 = $hbdi -> bl_prefiro14;
            }
            if (strlen(set_value('Prefiro14')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro14 = set_value('Prefiro14');
            }
            $attributes = array('id'=>'Prefiro14','name' => 'Prefiro14', 'value' => '1','onchange'=>"questao20(14,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro14, ($Prefiro14=='1' && strlen($Prefiro14)>0));
            echo "
                                                                                                <span>3.14 Leitura de livros-textos</span><br />";
            $Prefiro15 = '';
            if (isset($hbdi -> bl_prefiro15) && strlen($hbdi -> bl_prefiro15) > 0) {
                $Prefiro15 = $hbdi -> bl_prefiro15;
            }
            if (strlen(set_value('Prefiro15')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro15 = set_value('Prefiro15');
            }
            $attributes = array('id'=>'Prefiro15','name' => 'Prefiro15', 'value' => '1','onchange'=>"questao20(15,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro15, ($Prefiro15=='1' && strlen($Prefiro15)>0));
            echo "
                                                                                                <span>3.15 Discussões de casos voltados para as pessoas</span><br />";
            $Prefiro16 = '';
            if (isset($hbdi -> bl_prefiro16) && strlen($hbdi -> bl_prefiro16) > 0) {
                $Prefiro16 = $hbdi -> bl_prefiro16;
            }
            if (strlen(set_value('Prefiro16')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro16 = set_value('Prefiro16');
            }
            $attributes = array('id'=>'Prefiro16','name' => 'Prefiro16', 'value' => '1','onchange'=>"questao20(16,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro16, ($Prefiro16=='1' && strlen($Prefiro16)>0));
            echo "
                                                                                                <span>3.16 Discussões de casos voltados para os números e fatos</span><br />";
            $Prefiro17 = '';
            if (isset($hbdi -> bl_prefiro17) && strlen($hbdi -> bl_prefiro17) > 0) {
                $Prefiro17 = $hbdi -> bl_prefiro17;
            }
            if (strlen(set_value('Prefiro17')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro17 = set_value('Prefiro17');
            }
            $attributes = array('id'=>'Prefiro17','name' => 'Prefiro17', 'value' => '1','onchange'=>"questao20(17,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro17, ($Prefiro17=='1' && strlen($Prefiro17)>0));
            echo "
                                                                                                <span>3.17 Métodos tradicionais comprovados</span><br />";
            $Prefiro18 = '';
            if (isset($hbdi -> bl_prefiro18) && strlen($hbdi -> bl_prefiro18) > 0) {
                $Prefiro18 = $hbdi -> bl_prefiro18;
            }
            if (strlen(set_value('Prefiro18')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro18 = set_value('Prefiro18');
            }
            $attributes = array('id'=>'Prefiro18','name' => 'Prefiro18', 'value' => '1','onchange'=>"questao20(18,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro18, ($Prefiro18=='1' && strlen($Prefiro18)>0));
            echo "
                                                                                                <span>3.18 Agenda bem flexível</span><br />";
            $Prefiro19 = '';
            if (isset($hbdi -> bl_prefiro19) && strlen($hbdi -> bl_prefiro19) > 0) {
                $Prefiro19 = $hbdi -> bl_prefiro19;
            }
            if (strlen(set_value('Prefiro19')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro19 = set_value('Prefiro19');
            }
            $attributes = array('id'=>'Prefiro19','name' => 'Prefiro19', 'value' => '1','onchange'=>"questao20(19,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro19, ($Prefiro19=='1' && strlen($Prefiro19)>0));
            echo "
                                                                                                <span>3.19 Agenda estruturada com antecedência</span><br />";
            $Prefiro20 = '';
            if (isset($hbdi -> bl_prefiro20) && strlen($hbdi -> bl_prefiro20) > 0) {
                $Prefiro20 = $hbdi -> bl_prefiro20;
            }
            if (strlen(set_value('Prefiro20')) > 0 || strlen(set_value('salvar'))>0) {
                $Prefiro20 = set_value('Prefiro20');
            }
            $attributes = array('id'=>'Prefiro20','name' => 'Prefiro20', 'value' => '1','onchange'=>"questao20(20,'Prefiro')");
            echo form_checkbox($attributes, $Prefiro20, ($Prefiro20=='1' && strlen($Prefiro20)>0));
            echo "
                                                                                                <span>3.20 Trabalhos bem estruturados</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("4. Qual o tipo de pergunta que você mais gosta de fazer? (Assinale somente uma alternativa):", 'Pergunta');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";
            $Pergunta = '';
            if (isset($hbdi -> in_pergunta) && strlen($hbdi -> in_pergunta) > 0) {
                $Pergunta = $hbdi -> in_pergunta;
            }
            if (strlen(set_value('Pergunta')) > 0 || strlen(set_value('salvar'))>0) {
                $Pergunta = set_value('Pergunta');
            }

            $attributes = array('id'=>'Pergunta1','name' => 'Pergunta', 'value' => '1','onchange'=>"questao4(1,'Pergunta')");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='1' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.1 O que?</span><br />";
            $attributes = array('id'=>'Pergunta2','name' => 'Pergunta', 'value' => '2','onchange'=>"questao4(2,'Pergunta')");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='2' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.2 Como?</span><br />";
            $attributes = array('id'=>'Pergunta3','name' => 'Pergunta', 'value' => '3','onchange'=>"questao4(3,'Pergunta')");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='3' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.3 Por que?</span><br />";
            $attributes = array('id'=>'Pergunta4','name' => 'Pergunta', 'value' => '4','onchange'=>"questao4(4,'Pergunta')");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='4' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.4 Quem?</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("5. O que você mais gosta de fazer? (Assinale quatro alternativas):", 'Fazer1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Fazer1 = '';
            if (isset($hbdi -> bl_fazer1) && strlen($hbdi -> bl_fazer1) > 0) {
                $Fazer1 = $hbdi -> bl_fazer1;
            }
            if (strlen(set_value('Fazer1')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer1 = set_value('Fazer1');
            }
            $attributes = array('id'=>'Fazer1','name' => 'Fazer1', 'value' => '1','onchange'=>"questao16(1,'Fazer')");
            echo form_checkbox($attributes, $Fazer1, ($Fazer1=='1' && strlen($Fazer1)>0));
            echo "
                                                                                                <span>5.1 Descobrir</span><br />";
            $Fazer2 = '';
            if (isset($hbdi -> bl_fazer2) && strlen($hbdi -> bl_fazer2) > 0) {
                $Fazer2 = $hbdi -> bl_fazer2;
            }
            if (strlen(set_value('Fazer2')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer2 = set_value('Fazer2');
            }
            $attributes = array('id'=>'Fazer2','name' => 'Fazer2', 'value' => '1','onchange'=>"questao16(2,'Fazer')");
            echo form_checkbox($attributes, $Fazer2, ($Fazer2=='1' && strlen($Fazer2)>0));
            echo "
                                                                                                <span>5.2 Quantificar</span><br />";
            $Fazer3 = '';
            if (isset($hbdi -> bl_fazer3) && strlen($hbdi -> bl_fazer3) > 0) {
                $Fazer3 = $hbdi -> bl_fazer3;
            }
            if (strlen(set_value('Fazer3')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer3 = set_value('Fazer3');
            }
            $attributes = array('id'=>'Fazer3','name' => 'Fazer3', 'value' => '1','onchange'=>"questao16(3,'Fazer')");
            echo form_checkbox($attributes, $Fazer3, ($Fazer3=='1' && strlen($Fazer3)>0));
            echo "
                                                                                                <span>5.3 Envolver</span><br />";
            $Fazer4 = '';
            if (isset($hbdi -> bl_fazer4) && strlen($hbdi -> bl_fazer4) > 0) {
                $Fazer4 = $hbdi -> bl_fazer4;
            }
            if (strlen(set_value('Fazer4')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer4 = set_value('Fazer4');
            }
            $attributes = array('id'=>'Fazer4','name' => 'Fazer4', 'value' => '1','onchange'=>"questao16(4,'Fazer')");
            echo form_checkbox($attributes, $Fazer4, ($Fazer4=='1' && strlen($Fazer4)>0));
            echo "
                                                                                                <span>5.4 Organizar</span><br />";
            $Fazer5 = '';
            if (isset($hbdi -> bl_fazer5) && strlen($hbdi -> bl_fazer5) > 0) {
                $Fazer5 = $hbdi -> bl_fazer5;
            }
            if (strlen(set_value('Fazer5')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer5 = set_value('Fazer5');
            }
            $attributes = array('id'=>'Fazer5','name' => 'Fazer5', 'value' => '1','onchange'=>"questao16(5,'Fazer')");
            echo form_checkbox($attributes, $Fazer5, ($Fazer5=='1' && strlen($Fazer5)>0));
            echo "
                                                                                                <span>5.5 Conceituar</span><br />";
            $Fazer6 = '';
            if (isset($hbdi -> bl_fazer6) && strlen($hbdi -> bl_fazer6) > 0) {
                $Fazer6 = $hbdi -> bl_fazer6;
            }
            if (strlen(set_value('Fazer6')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer6 = set_value('Fazer6');
            }
            $attributes = array('id'=>'Fazer6','name' => 'Fazer6', 'value' => '1','onchange'=>"questao16(6,'Fazer')");
            echo form_checkbox($attributes, $Fazer6, ($Fazer6=='1' && strlen($Fazer6)>0));
            echo "
                                                                                                <span>5.6 Analisar</span><br />";
            $Fazer7 = '';
            if (isset($hbdi -> bl_fazer7) && strlen($hbdi -> bl_fazer7) > 0) {
                $Fazer7 = $hbdi -> bl_fazer7;
            }
            if (strlen(set_value('Fazer7')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer7 = set_value('Fazer7');
            }
            $attributes = array('id'=>'Fazer7','name' => 'Fazer7', 'value' => '1','onchange'=>"questao16(7,'Fazer')");
            echo form_checkbox($attributes, $Fazer7, ($Fazer7=='1' && strlen($Fazer7)>0));
            echo "
                                                                                                <span>5.7 Sentir</span><br />";
            $Fazer8 = '';
            if (isset($hbdi -> bl_fazer8) && strlen($hbdi -> bl_fazer8) > 0) {
                $Fazer8 = $hbdi -> bl_fazer8;
            }
            if (strlen(set_value('Fazer8')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer8 = set_value('Fazer8');
            }
            $attributes = array('id'=>'Fazer8','name' => 'Fazer8', 'value' => '1','onchange'=>"questao16(8,'Fazer')");
            echo form_checkbox($attributes, $Fazer8, ($Fazer8=='1' && strlen($Fazer8)>0));
            echo "
                                                                                                <span>5.8 Praticar</span><br />";
            $Fazer9 = '';
            if (isset($hbdi -> bl_fazer9) && strlen($hbdi -> bl_fazer9) > 0) {
                $Fazer9 = $hbdi -> bl_fazer9;
            }
            if (strlen(set_value('Fazer9')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer9 = set_value('Fazer9');
            }
            $attributes = array('id'=>'Fazer9','name' => 'Fazer9', 'value' => '1','onchange'=>"questao16(9,'Fazer')");
            echo form_checkbox($attributes, $Fazer9, ($Fazer9=='1' && strlen($Fazer9)>0));
            echo "
                                                                                                <span>5.9 Teorizar</span><br />";
            $Fazer10 = '';
            if (isset($hbdi -> bl_fazer10) && strlen($hbdi -> bl_fazer10) > 0) {
                $Fazer10 = $hbdi -> bl_fazer10;
            }
            if (strlen(set_value('Fazer10')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer10 = set_value('Fazer10');
            }
            $attributes = array('id'=>'Fazer10','name' => 'Fazer10', 'value' => '1','onchange'=>"questao16(10,'Fazer')");
            echo form_checkbox($attributes, $Fazer10, ($Fazer10=='1' && strlen($Fazer10)>0));
            echo "
                                                                                                <span>5.10 Sintetizar</span><br />";
            $Fazer11 = '';
            if (isset($hbdi -> bl_fazer11) && strlen($hbdi -> bl_fazer11) > 0) {
                $Fazer11 = $hbdi -> bl_fazer11;
            }
            if (strlen(set_value('Fazer11')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer11 = set_value('Fazer11');
            }
            $attributes = array('id'=>'Fazer11','name' => 'Fazer11', 'value' => '1','onchange'=>"questao16(11,'Fazer')");
            echo form_checkbox($attributes, $Fazer11, ($Fazer11=='1' && strlen($Fazer11)>0));
            echo "
                                                                                                <span>5.11 Avaliar</span><br />";
            $Fazer12 = '';
            if (isset($hbdi -> bl_fazer12) && strlen($hbdi -> bl_fazer12) > 0) {
                $Fazer12 = $hbdi -> bl_fazer12;
            }
            if (strlen(set_value('Fazer12')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer12 = set_value('Fazer12');
            }
            $attributes = array('id'=>'Fazer12','name' => 'Fazer12', 'value' => '1','onchange'=>"questao16(12,'Fazer')");
            echo form_checkbox($attributes, $Fazer12, ($Fazer12=='1' && strlen($Fazer12)>0));
            echo "
                                                                                                <span>5.12 Interiorizar</span><br />";
            $Fazer13 = '';
            if (isset($hbdi -> bl_fazer13) && strlen($hbdi -> bl_fazer13) > 0) {
                $Fazer13 = $hbdi -> bl_fazer13;
            }
            if (strlen(set_value('Fazer13')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer13 = set_value('Fazer13');
            }
            $attributes = array('id'=>'Fazer13','name' => 'Fazer13', 'value' => '1','onchange'=>"questao16(13,'Fazer')");
            echo form_checkbox($attributes, $Fazer13, ($Fazer13=='1' && strlen($Fazer13)>0));
            echo "
                                                                                                <span>5.13 Processar</span><br />";
            $Fazer14 = '';
            if (isset($hbdi -> bl_fazer14) && strlen($hbdi -> bl_fazer14) > 0) {
                $Fazer14 = $hbdi -> bl_fazer14;
            }
            if (strlen(set_value('Fazer14')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer14 = set_value('Fazer14');
            }
            $attributes = array('id'=>'Fazer14','name' => 'Fazer14', 'value' => '1','onchange'=>"questao16(14,'Fazer')");
            echo form_checkbox($attributes, $Fazer14, ($Fazer14=='1' && strlen($Fazer14)>0));
            echo "
                                                                                                <span>5.14 Ordenar</span><br />";
            $Fazer15 = '';
            if (isset($hbdi -> bl_fazer15) && strlen($hbdi -> bl_fazer15) > 0) {
                $Fazer15 = $hbdi -> bl_fazer15;
            }
            if (strlen(set_value('Fazer15')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer15 = set_value('Fazer15');
            }
            $attributes = array('id'=>'Fazer15','name' => 'Fazer15', 'value' => '1','onchange'=>"questao16(15,'Fazer')");
            echo form_checkbox($attributes, $Fazer15, ($Fazer15=='1' && strlen($Fazer15)>0));
            echo "
                                                                                                <span>5.15 Explorar</span><br />";
            $Fazer16 = '';
            if (isset($hbdi -> bl_fazer16) && strlen($hbdi -> bl_fazer16) > 0) {
                $Fazer16 = $hbdi -> bl_fazer16;
            }
            if (strlen(set_value('Fazer16')) > 0 || strlen(set_value('salvar'))>0) {
                $Fazer16 = set_value('Fazer16');
            }
            $attributes = array('id'=>'Fazer16','name' => 'Fazer16', 'value' => '1','onchange'=>"questao16(16,'Fazer')");
            echo form_checkbox($attributes, $Fazer16, ($Fazer16=='1' && strlen($Fazer16)>0));
            echo "
                                                                                                <span>5.16 Compartilhar</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("6. Ao comprar um carro você… (Assinale cinco alternativas):", 'Comprar1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Comprar1 = '';
            if (isset($hbdi -> bl_comprar1) && strlen($hbdi -> bl_comprar1) > 0) {
                $Comprar1 = $hbdi -> bl_comprar1;
            }
            if (strlen(set_value('Comprar1')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar1 = set_value('Comprar1');
            }
            $attributes = array('id'=>'Comprar1','name' => 'Comprar1', 'value' => '1','onchange'=>"questao20(1,'Comprar')");
            echo form_checkbox($attributes, $Comprar1, ($Comprar1=='1' && strlen($Comprar1)>0));
            echo "
                                                                                                <span>6.1 Compra com base na recomendação de amigos</span><br />";
            $Comprar2 = '';
            if (isset($hbdi -> bl_comprar2) && strlen($hbdi -> bl_comprar2) > 0) {
                $Comprar2 = $hbdi -> bl_comprar2;
            }
            if (strlen(set_value('Comprar2')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar2 = set_value('Comprar2');
            }
            $attributes = array('id'=>'Comprar2','name' => 'Comprar2', 'value' => '1','onchange'=>"questao20(2,'Comprar')");
            echo form_checkbox($attributes, $Comprar2, ($Comprar2=='1' && strlen($Comprar2)>0));
            echo "
                                                                                                <span>6.2 Se preocupa com o consumo de combustível</span><br />";
            $Comprar3 = '';
            if (isset($hbdi -> bl_comprar3) && strlen($hbdi -> bl_comprar3) > 0) {
                $Comprar3 = $hbdi -> bl_comprar3;
            }
            if (strlen(set_value('Comprar3')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar3 = set_value('Comprar3');
            }
            $attributes = array('id'=>'Comprar3','name' => 'Comprar3', 'value' => '1','onchange'=>"questao20(3,'Comprar')");
            echo form_checkbox($attributes, $Comprar3, ($Comprar3=='1' && strlen($Comprar3)>0));
            echo "
                                                                                                <span>6.3 Se preocupa com as forma; a cor e a tecnologia</span><br />";
            $Comprar4 = '';
            if (isset($hbdi -> bl_comprar4) && strlen($hbdi -> bl_comprar4) > 0) {
                $Comprar4 = $hbdi -> bl_comprar4;
            }
            if (strlen(set_value('Comprar4')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar4 = set_value('Comprar4');
            }
            $attributes = array('id'=>'Comprar4','name' => 'Comprar4', 'value' => '1','onchange'=>"questao20(4,'Comprar')");
            echo form_checkbox($attributes, $Comprar4, ($Comprar4=='1' && strlen($Comprar4)>0));
            echo "
                                                                                                <span>6.4 Verifica equipamento de segurança e durabilidade</span><br />";
            $Comprar5 = '';
            if (isset($hbdi -> bl_comprar5) && strlen($hbdi -> bl_comprar5) > 0) {
                $Comprar5 = $hbdi -> bl_comprar5;
            }
            if (strlen(set_value('Comprar5')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar5 = set_value('Comprar5');
            }
            $attributes = array('id'=>'Comprar5','name' => 'Comprar5', 'value' => '1','onchange'=>"questao20(5,'Comprar')");
            echo form_checkbox($attributes, $Comprar5, ($Comprar5=='1' && strlen($Comprar5)>0));
            echo "
                                                                                                <span>6.5 Dá importância à \"sensação\" de conforto do veículo</span><br />";
            $Comprar6 = '';
            if (isset($hbdi -> bl_comprar6) && strlen($hbdi -> bl_comprar6) > 0) {
                $Comprar6 = $hbdi -> bl_comprar6;
            }
            if (strlen(set_value('Comprar6')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar6 = set_value('Comprar6');
            }
            $attributes = array('id'=>'Comprar6','name' => 'Comprar6', 'value' => '1','onchange'=>"questao20(6,'Comprar')");
            echo form_checkbox($attributes, $Comprar6, ($Comprar6=='1' && strlen($Comprar6)>0));
            echo "
                                                                                                <span>6.6 Faz comparações com outros veículos</span><br />";
            $Comprar7 = '';
            if (isset($hbdi -> bl_comprar7) && strlen($hbdi -> bl_comprar7) > 0) {
                $Comprar7 = $hbdi -> bl_comprar7;
            }
            if (strlen(set_value('Comprar7')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar7 = set_value('Comprar7');
            }
            $attributes = array('id'=>'Comprar7','name' => 'Comprar7', 'value' => '1','onchange'=>"questao20(7,'Comprar')");
            echo form_checkbox($attributes, $Comprar7, ($Comprar7=='1' && strlen($Comprar7)>0));
            echo "
                                                                                                <span>6.7 Verificar tamanho do porta-malas</span><br />";
            $Comprar8 = '';
            if (isset($hbdi -> bl_comprar8) && strlen($hbdi -> bl_comprar8) > 0) {
                $Comprar8 = $hbdi -> bl_comprar8;
            }
            if (strlen(set_value('Comprar8')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar8 = set_value('Comprar8');
            }
            $attributes = array('id'=>'Comprar8','name' => 'Comprar8', 'value' => '1','onchange'=>"questao20(8,'Comprar')");
            echo form_checkbox($attributes, $Comprar8, ($Comprar8=='1' && strlen($Comprar8)>0));
            echo "
                                                                                                <span>6.8 Verifica se encaixa no seu sonho de vida</span><br />";
            $Comprar9 = '';
            if (isset($hbdi -> bl_comprar9) && strlen($hbdi -> bl_comprar9) > 0) {
                $Comprar9 = $hbdi -> bl_comprar9;
            }
            if (strlen(set_value('Comprar9')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar9 = set_value('Comprar9');
            }
            $attributes = array('id'=>'Comprar9','name' => 'Comprar9', 'value' => '1','onchange'=>"questao20(9,'Comprar')");
            echo form_checkbox($attributes, $Comprar9, ($Comprar9=='1' && strlen($Comprar9)>0));
            echo "
                                                                                                <span>6.9 Pesquisa e planeja antecipadamente como vai utilizá-lo</span><br />";
            $Comprar10 = '';
            if (isset($hbdi -> bl_comprar10) && strlen($hbdi -> bl_comprar10) > 0) {
                $Comprar10 = $hbdi -> bl_comprar10;
            }
            if (strlen(set_value('Comprar10')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar10 = set_value('Comprar10');
            }
            $attributes = array('id'=>'Comprar10','name' => 'Comprar10', 'value' => '1','onchange'=>"questao20(10,'Comprar')");
            echo form_checkbox($attributes, $Comprar10, ($Comprar10=='1' && strlen($Comprar10)>0));
            echo "
                                                                                                <span>6.10 Se preocupa com o custo e o valor de troca</span><br />";
            $Comprar11 = '';
            if (isset($hbdi -> bl_comprar11) && strlen($hbdi -> bl_comprar11) > 0) {
                $Comprar11 = $hbdi -> bl_comprar11;
            }
            if (strlen(set_value('Comprar11')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar11 = set_value('Comprar11');
            }
            $attributes = array('id'=>'Comprar11','name' => 'Comprar11', 'value' => '1','onchange'=>"questao20(11,'Comprar')");
            echo form_checkbox($attributes, $Comprar11, ($Comprar11=='1' && strlen($Comprar11)>0));
            echo "
                                                                                                <span>6.11 Quer \"amar\" o carro</span><br />";
            $Comprar12 = '';
            if (isset($hbdi -> bl_comprar12) && strlen($hbdi -> bl_comprar12) > 0) {
                $Comprar12 = $hbdi -> bl_comprar12;
            }
            if (strlen(set_value('Comprar12')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar12 = set_value('Comprar12');
            }
            $attributes = array('id'=>'Comprar12','name' => 'Comprar12', 'value' => '1','onchange'=>"questao20(12,'Comprar')");
            echo form_checkbox($attributes, $Comprar12, ($Comprar12=='1' && strlen($Comprar12)>0));
            echo "
                                                                                                <span>6.12 Prefere carros lançados recentemente</span><br />";
            $Comprar13 = '';
            if (isset($hbdi -> bl_comprar13) && strlen($hbdi -> bl_comprar13) > 0) {
                $Comprar13 = $hbdi -> bl_comprar13;
            }
            if (strlen(set_value('Comprar13')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar13 = set_value('Comprar13');
            }
            $attributes = array('id'=>'Comprar13','name' => 'Comprar13', 'value' => '1','onchange'=>"questao20(13,'Comprar')");
            echo form_checkbox($attributes, $Comprar13, ($Comprar13=='1' && strlen($Comprar13)>0));
            echo "
                                                                                                <span>6.13 Se preocupa com os requisitos técnicos</span><br />";
            $Comprar14 = '';
            if (isset($hbdi -> bl_comprar14) && strlen($hbdi -> bl_comprar14) > 0) {
                $Comprar14 = $hbdi -> bl_comprar14;
            }
            if (strlen(set_value('Comprar14')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar14 = set_value('Comprar14');
            }
            $attributes = array('id'=>'Comprar14','name' => 'Comprar14', 'value' => '1','onchange'=>"questao20(14,'Comprar')");
            echo form_checkbox($attributes, $Comprar14, ($Comprar14=='1' && strlen($Comprar14)>0));
            echo "
                                                                                                <span>6.14 Verifica a facilidade de manutenção</span><br />";
            $Comprar15 = '';
            if (isset($hbdi -> bl_comprar15) && strlen($hbdi -> bl_comprar15) > 0) {
                $Comprar15 = $hbdi -> bl_comprar15;
            }
            if (strlen(set_value('Comprar15')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar15 = set_value('Comprar15');
            }
            $attributes = array('id'=>'Comprar15','name' => 'Comprar15', 'value' => '1','onchange'=>"questao20(15,'Comprar')");
            echo form_checkbox($attributes, $Comprar15, ($Comprar15=='1' && strlen($Comprar15)>0));
            echo "
                                                                                                <span>6.15 Gosta de experimentar um novo modelo ou fabricante</span><br />";
            $Comprar16 = '';
            if (isset($hbdi -> bl_comprar16) && strlen($hbdi -> bl_comprar16) > 0) {
                $Comprar16 = $hbdi -> bl_comprar16;
            }
            if (strlen(set_value('Comprar16')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar16 = set_value('Comprar16');
            }
            $attributes = array('id'=>'Comprar16','name' => 'Comprar16', 'value' => '1','onchange'=>"questao20(16,'Comprar')");
            echo form_checkbox($attributes, $Comprar16, ($Comprar16=='1' && strlen($Comprar16)>0));
            echo "
                                                                                                <span>6.16 Se preocupa com o nome do fabricante</span><br />";
            $Comprar17 = '';
            if (isset($hbdi -> bl_comprar17) && strlen($hbdi -> bl_comprar17) > 0) {
                $Comprar17 = $hbdi -> bl_comprar17;
            }
            if (strlen(set_value('Comprar17')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar17 = set_value('Comprar17');
            }
            $attributes = array('id'=>'Comprar17','name' => 'Comprar17', 'value' => '1','onchange'=>"questao20(17,'Comprar')");
            echo form_checkbox($attributes, $Comprar17, ($Comprar17=='1' && strlen($Comprar17)>0));
            echo "
                                                                                                <span>6.17 Dá importância à opinião das pessoas</span><br />";
            $Comprar18 = '';
            if (isset($hbdi -> bl_comprar18) && strlen($hbdi -> bl_comprar18) > 0) {
                $Comprar18 = $hbdi -> bl_comprar18;
            }
            if (strlen(set_value('Comprar18')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar18 = set_value('Comprar18');
            }
            $attributes = array('id'=>'Comprar18','name' => 'Comprar18', 'value' => '1','onchange'=>"questao20(18,'Comprar')");
            echo form_checkbox($attributes, $Comprar18, ($Comprar18=='1' && strlen($Comprar18)>0));
            echo "
                                                                                                <span>6.18 Quer ver dados e estatísticas sobre o desempenho</span><br />";
            $Comprar19 = '';
            if (isset($hbdi -> bl_comprar19) && strlen($hbdi -> bl_comprar19) > 0) {
                $Comprar19 = $hbdi -> bl_comprar19;
            }
            if (strlen(set_value('Comprar19')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar19 = set_value('Comprar19');
            }
            $attributes = array('id'=>'Comprar19','name' => 'Comprar19', 'value' => '1','onchange'=>"questao20(19,'Comprar')");
            echo form_checkbox($attributes, $Comprar19, ($Comprar19=='1' && strlen($Comprar19)>0));
            echo "
                                                                                                <span>6.19 Se preocupa com a qualidade do atendimento do revendedor</span><br />";
            $Comprar20 = '';
            if (isset($hbdi -> bl_comprar20) && strlen($hbdi -> bl_comprar20) > 0) {
                $Comprar20 = $hbdi -> bl_comprar20;
            }
            if (strlen(set_value('Comprar20')) > 0 || strlen(set_value('salvar'))>0) {
                $Comprar20 = set_value('Comprar20');
            }
            $attributes = array('id'=>'Comprar20','name' => 'Comprar20', 'value' => '1','onchange'=>"questao20(20,'Comprar')");
            echo form_checkbox($attributes, $Comprar20, ($Comprar20=='1' && strlen($Comprar20)>0));
            echo "
                                                                                                <span>6.20 Analisa como o carro vai ser útil no seu dia-a-dia</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("7. Como você define seu comportamento? (Assinale apenas uma alternativa):", 'Comportamento');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Comportamento = '';
            if (isset($hbdi -> in_comportamento) && strlen($hbdi -> in_comportamento) > 0) {
                $Comportamento = $hbdi -> in_comportamento;
            }
            if (strlen(set_value('Comportamento')) > 0 || strlen(set_value('salvar'))>0) {
                $Comportamento = set_value('Comportamento');
            }
            $attributes = array('id'=>'Comportamento1','name' => 'Comportamento', 'value' => '1','onchange'=>"questao4(1,'Comportamento')");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='1' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.1 Gosto de organizar</span><br />";
            $attributes = array('id'=>'Comportamento2','name' => 'Comportamento', 'value' => '2','onchange'=>"questao4(2,'Comportamento')");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='2' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.2 Gosto de compartilhar</span><br />";
            $attributes = array('id'=>'Comportamento3','name' => 'Comportamento', 'value' => '3','onchange'=>"questao4(3,'Comportamento')");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='3' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.3 Gosto de analisar</span><br />";
            $attributes = array('id'=>'Comportamento4','name' => 'Comportamento', 'value' => '4','onchange'=>"questao4(4,'Comportamento')");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='4' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.4 Gosto de descobrir</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("8. Palavras que definem meu estilo... (Assinale quatro alternativas):", 'Estilo1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Estilo1 = '';
            if (isset($hbdi -> bl_estilo1) && strlen($hbdi -> bl_estilo1) > 0) {
                $Estilo1 = $hbdi -> bl_estilo1;
            }
            if (strlen(set_value('Estilo1')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo1 = set_value('Estilo1');
            }
            $attributes = array('id'=>'Estilo1','name' => 'Estilo1', 'value' => '1','onchange'=>"questao16(1,'Estilo')");
            echo form_checkbox($attributes, $Estilo1, ($Estilo1=='1' && strlen($Estilo1)>0));
            echo "
                                                                                                <span>8.1 Organizado</span><br />";
            $Estilo2 = '';
            if (isset($hbdi -> bl_estilo2) && strlen($hbdi -> bl_estilo2) > 0) {
                $Estilo2 = $hbdi -> bl_estilo2;
            }
            if (strlen(set_value('Estilo2')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo2 = set_value('Estilo2');
            }
            $attributes = array('id'=>'Estilo2','name' => 'Estilo2', 'value' => '1','onchange'=>"questao16(2,'Estilo')");
            echo form_checkbox($attributes, $Estilo2, ($Estilo2=='1' && strlen($Estilo2)>0));
            echo "
                                                                                                <span>8.2 Analítico</span><br />";
            $Estilo3 = '';
            if (isset($hbdi -> bl_estilo3) && strlen($hbdi -> bl_estilo3) > 0) {
                $Estilo3 = $hbdi -> bl_estilo3;
            }
            if (strlen(set_value('Estilo3')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo3 = set_value('Estilo3');
            }
            $attributes = array('id'=>'Estilo3','name' => 'Estilo3', 'value' => '1','onchange'=>"questao16(3,'Estilo')");
            echo form_checkbox($attributes, $Estilo3, ($Estilo3=='1' && strlen($Estilo3)>0));
            echo "
                                                                                                <span>8.3 Emocional</span><br />";
            $Estilo4 = '';
            if (isset($hbdi -> bl_estilo4) && strlen($hbdi -> bl_estilo4) > 0) {
                $Estilo4 = $hbdi -> bl_estilo4;
            }
            if (strlen(set_value('Estilo4')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo4 = set_value('Estilo4');
            }
            $attributes = array('id'=>'Estilo4','name' => 'Estilo4', 'value' => '1','onchange'=>"questao16(4,'Estilo')");
            echo form_checkbox($attributes, $Estilo4, ($Estilo4=='1' && strlen($Estilo4)>0));
            echo "
                                                                                                <span>8.4 Experimental</span><br />";
            $Estilo5 = '';
            if (isset($hbdi -> bl_estilo5) && strlen($hbdi -> bl_estilo5) > 0) {
                $Estilo5 = $hbdi -> bl_estilo5;
            }
            if (strlen(set_value('Estilo5')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo5 = set_value('Estilo5');
            }
            $attributes = array('id'=>'Estilo5','name' => 'Estilo5', 'value' => '1','onchange'=>"questao16(5,'Estilo')");
            echo form_checkbox($attributes, $Estilo5, ($Estilo5=='1' && strlen($Estilo5)>0));
            echo "
                                                                                                <span>8.5 Lógico</span><br />";
            $Estilo6 = '';
            if (isset($hbdi -> bl_estilo6) && strlen($hbdi -> bl_estilo6) > 0) {
                $Estilo6 = $hbdi -> bl_estilo6;
            }
            if (strlen(set_value('Estilo6')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo6 = set_value('Estilo6');
            }
            $attributes = array('id'=>'Estilo6','name' => 'Estilo6', 'value' => '1','onchange'=>"questao16(6,'Estilo')");
            echo form_checkbox($attributes, $Estilo6, ($Estilo6=='1' && strlen($Estilo6)>0));
            echo "
                                                                                                <span>8.6 Conceitual</span><br />";
            $Estilo7 = '';
            if (isset($hbdi -> bl_estilo7) && strlen($hbdi -> bl_estilo7) > 0) {
                $Estilo7 = $hbdi -> bl_estilo7;
            }
            if (strlen(set_value('Estilo7')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo7 = set_value('Estilo7');
            }
            $attributes = array('id'=>'Estilo7','name' => 'Estilo7', 'value' => '1','onchange'=>"questao16(7,'Estilo')");
            echo form_checkbox($attributes, $Estilo7, ($Estilo7=='1' && strlen($Estilo7)>0));
            echo "
                                                                                                <span>8.7 Perceptivo</span><br />";
            $Estilo8 = '';
            if (isset($hbdi -> bl_estilo8) && strlen($hbdi -> bl_estilo8) > 0) {
                $Estilo8 = $hbdi -> bl_estilo8;
            }
            if (strlen(set_value('Estilo8')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo8 = set_value('Estilo8');
            }
            $attributes = array('id'=>'Estilo8','name' => 'Estilo8', 'value' => '1','onchange'=>"questao16(8,'Estilo')");
            echo form_checkbox($attributes, $Estilo8, ($Estilo8=='1' && strlen($Estilo8)>0));
            echo "
                                                                                                <span>8.8 Sequencial</span><br />";
            $Estilo9 = '';
            if (isset($hbdi -> bl_estilo9) && strlen($hbdi -> bl_estilo9) > 0) {
                $Estilo9 = $hbdi -> bl_estilo9;
            }
            if (strlen(set_value('Estilo9')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo9 = set_value('Estilo9');
            }
            $attributes = array('id'=>'Estilo9','name' => 'Estilo9', 'value' => '1','onchange'=>"questao16(9,'Estilo')");
            echo form_checkbox($attributes, $Estilo9, ($Estilo9=='1' && strlen($Estilo9)>0));
            echo "
                                                                                                <span>8.9 Teórico</span><br />";
            $Estilo10 = '';
            if (isset($hbdi -> bl_estilo10) && strlen($hbdi -> bl_estilo10) > 0) {
                $Estilo10 = $hbdi -> bl_estilo10;
            }
            if (strlen(set_value('Estilo10')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo10 = set_value('Estilo10');
            }
            $attributes = array('id'=>'Estilo10','name' => 'Estilo10', 'value' => '1','onchange'=>"questao16(10,'Estilo')");
            echo form_checkbox($attributes, $Estilo10, ($Estilo10=='1' && strlen($Estilo10)>0));
            echo "
                                                                                                <span>8.10 Explorador</span><br />";
            $Estilo11 = '';
            if (isset($hbdi -> bl_estilo11) && strlen($hbdi -> bl_estilo11) > 0) {
                $Estilo11 = $hbdi -> bl_estilo11;
            }
            if (strlen(set_value('Estilo11')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo11 = set_value('Estilo11');
            }
            $attributes = array('id'=>'Estilo11','name' => 'Estilo11', 'value' => '1','onchange'=>"questao16(11,'Estilo')");
            echo form_checkbox($attributes, $Estilo11, ($Estilo11=='1' && strlen($Estilo11)>0));
            echo "
                                                                                                <span>8.11 Avaliador</span><br />";
            $Estilo12 = '';
            if (isset($hbdi -> bl_estilo12) && strlen($hbdi -> bl_estilo12) > 0) {
                $Estilo12 = $hbdi -> bl_estilo12;
            }
            if (strlen(set_value('Estilo12')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo12 = set_value('Estilo12');
            }
            $attributes = array('id'=>'Estilo12','name' => 'Estilo12', 'value' => '1','onchange'=>"questao16(12,'Estilo')");
            echo form_checkbox($attributes, $Estilo12, ($Estilo12=='1' && strlen($Estilo12)>0));
            echo "
                                                                                                <span>8.12 Cinestésico</span><br />";
            $Estilo13 = '';
            if (isset($hbdi -> bl_estilo13) && strlen($hbdi -> bl_estilo13) > 0) {
                $Estilo13 = $hbdi -> bl_estilo13;
            }
            if (strlen(set_value('Estilo13')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo13 = set_value('Estilo13');
            }
            $attributes = array('id'=>'Estilo13','name' => 'Estilo13', 'value' => '1','onchange'=>"questao16(13,'Estilo')");
            echo form_checkbox($attributes, $Estilo13, ($Estilo13=='1' && strlen($Estilo13)>0));
            echo "
                                                                                                <span>8.13 Sentimental</span><br />";
            $Estilo14 = '';
            if (isset($hbdi -> bl_estilo14) && strlen($hbdi -> bl_estilo14) > 0) {
                $Estilo14 = $hbdi -> bl_estilo14;
            }
            if (strlen(set_value('Estilo14')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo14 = set_value('Estilo14');
            }
            $attributes = array('id'=>'Estilo14','name' => 'Estilo14', 'value' => '1','onchange'=>"questao16(14,'Estilo')");
            echo form_checkbox($attributes, $Estilo14, ($Estilo14=='1' && strlen($Estilo14)>0));
            echo "
                                                                                                <span>8.14 Preparado</span><br />";
            $Estilo15 = '';
            if (isset($hbdi -> bl_estilo15) && strlen($hbdi -> bl_estilo15) > 0) {
                $Estilo15 = $hbdi -> bl_estilo15;
            }
            if (strlen(set_value('Estilo15')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo15 = set_value('Estilo15');
            }
            $attributes = array('id'=>'Estilo15','name' => 'Estilo15', 'value' => '1','onchange'=>"questao16(15,'Estilo')");
            echo form_checkbox($attributes, $Estilo15, ($Estilo15='1' && strlen($Estilo15)>0));
            echo "
                                                                                                <span>8.15 Quantitativo</span><br />";
            $Estilo16 = '';
            if (isset($hbdi -> bl_estilo16) && strlen($hbdi -> bl_estilo16) > 0) {
                $Estilo16 = $hbdi -> bl_estilo16;
            }
            if (strlen(set_value('Estilo16')) > 0 || strlen(set_value('salvar'))>0) {
                $Estilo16 = set_value('Estilo16');
            }
            $attributes = array('id'=>'Estilo16','name' => 'Estilo16', 'value' => '1','onchange'=>"questao16(16,'Estilo')");
            echo form_checkbox($attributes, $Estilo16, ($Estilo16=='1' && strlen($Estilo16)>0));
            echo "
                                                                                                <span>8.16 Sintético</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("9. Quais as frases que você mais ouve dos outros em relação a seus \"pontos fracos\"? (Assinale cinco alternativas):", 'PontoFraco1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $PontoFraco1 = '';
            if (isset($hbdi -> bl_ponto_fraco1) && strlen($hbdi -> bl_ponto_fraco1) > 0) {
                $PontoFraco1 = $hbdi -> bl_ponto_fraco1;
            }
            if (strlen(set_value('PontoFraco1')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco1 = set_value('PontoFraco1');
            }
            $attributes = array('id'=>'PontoFraco1','name' => 'PontoFraco1', 'value' => '1','onchange'=>"questao20(1,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco1, ($PontoFraco1=='1' && strlen($PontoFraco1)>0));
            echo "
                                                                                                <span>9.1 Viciado em números</span><br />";
            $PontoFraco2 = '';
            if (isset($hbdi -> bl_ponto_fraco2) && strlen($hbdi -> bl_ponto_fraco2) > 0) {
                $PontoFraco2 = $hbdi -> bl_ponto_fraco2;
            }
            if (strlen(set_value('PontoFraco2')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco2 = set_value('PontoFraco2');
            }
            $attributes = array('id'=>'PontoFraco2','name' => 'PontoFraco2', 'value' => '1','onchange'=>"questao20(2,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco2, ($PontoFraco2=='1' && strlen($PontoFraco2)>0));
            echo "
                                                                                                <span>9.2 Coração mole</span><br />";
            $PontoFraco3 = '';
            if (isset($hbdi -> bl_ponto_fraco3) && strlen($hbdi -> bl_ponto_fraco3) > 0) {
                $PontoFraco3 = $hbdi -> bl_ponto_fraco3;
            }
            if (strlen(set_value('PontoFraco3')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco3 = set_value('PontoFraco3');
            }
            $attributes = array('id'=>'PontoFraco3','name' => 'PontoFraco3', 'value' => '1','onchange'=>"questao20(3,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco3, ($PontoFraco3=='1' && strlen($PontoFraco3)>0));
            echo "
                                                                                                <span>9.3 Exigente; esforçado</span><br />";
            $PontoFraco4 = '';
            if (isset($hbdi -> bl_ponto_fraco4) && strlen($hbdi -> bl_ponto_fraco4) > 0) {
                $PontoFraco4 = $hbdi -> bl_ponto_fraco4;
            }
            if (strlen(set_value('PontoFraco4')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco4 = set_value('PontoFraco4');
            }
            $attributes = array('id'=>'PontoFraco4','name' => 'PontoFraco4', 'value' => '1','onchange'=>"questao20(4,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco4, ($PontoFraco4=='1' && strlen($PontoFraco4)>0));
            echo "
                                                                                                <span>9.4 Vive no mundo da lua</span><br />";
            $PontoFraco5 = '';
            if (isset($hbdi -> bl_ponto_fraco5) && strlen($hbdi -> bl_ponto_fraco5) > 0) {
                $PontoFraco5 = $hbdi -> bl_ponto_fraco5;
            }
            if (strlen(set_value('PontoFraco5')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco5 = set_value('PontoFraco5');
            }
            $attributes = array('id'=>'PontoFraco5','name' => 'PontoFraco5', 'value' => '1','onchange'=>"questao20(5,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco5, ($PontoFraco5=='1' && strlen($PontoFraco5)>0));
            echo "
                                                                                                <span>9.5 Tem sede de poder</span><br />";
            $PontoFraco6 = '';
            if (isset($hbdi -> bl_ponto_fraco6) && strlen($hbdi -> bl_ponto_fraco6) > 0) {
                $PontoFraco6 = $hbdi -> bl_ponto_fraco6;
            }
            if (strlen(set_value('PontoFraco6')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco6 = set_value('PontoFraco6');
            }
            $attributes = array('id'=>'PontoFraco6','name' => 'PontoFraco6', 'value' => '1','onchange'=>"questao20(6,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco6, ($PontoFraco6=='1' && strlen($PontoFraco6)>0));
            echo "
                                                                                                <span>9.6 Fala demais</span><br />";
            $PontoFraco7 = '';
            if (isset($hbdi -> bl_ponto_fraco7) && strlen($hbdi -> bl_ponto_fraco7) > 0) {
                $PontoFraco7 = $hbdi -> bl_ponto_fraco7;
            }
            if (strlen(set_value('PontoFraco7')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco7 = set_value('PontoFraco7');
            }
            $attributes = array('id'=>'PontoFraco7','name' => 'PontoFraco7', 'value' => '1','onchange'=>"questao20(7,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco7, ($PontoFraco7=='1' && strlen($PontoFraco7)>0));
            echo "
                                                                                                <span>9.7 Não decide sozinho</span><br />";
            $PontoFraco8 = '';
            if (isset($hbdi -> bl_ponto_fraco8) && strlen($hbdi -> bl_ponto_fraco8) > 0) {
                $PontoFraco8 = $hbdi -> bl_ponto_fraco8;
            }
            if (strlen(set_value('PontoFraco8')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco8 = set_value('PontoFraco8');
            }
            $attributes = array('id'=>'PontoFraco8','name' => 'PontoFraco8', 'value' => '1','onchange'=>"questao20(8,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco8, ($PontoFraco8=='1' && strlen($PontoFraco8)>0));
            echo "
                                                                                                <span>9.8 Não sabe se concentrar</span><br />";
            $PontoFraco9 = '';
            if (isset($hbdi -> bl_ponto_fraco9) && strlen($hbdi -> bl_ponto_fraco9) > 0) {
                $PontoFraco9 = $hbdi -> bl_ponto_fraco9;
            }
            if (strlen(set_value('PontoFraco9')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco9 = set_value('PontoFraco9');
            }
            $attributes = array('id'=>'PontoFraco9','name' => 'PontoFraco9', 'value' => '1','onchange'=>"questao20(9,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco9, ($PontoFraco9=='1' && strlen($PontoFraco9)>0));
            echo "
                                                                                                <span>9.9 Frio; insensível</span><br />";
            $PontoFraco10 = '';
            if (isset($hbdi -> bl_ponto_fraco10) && strlen($hbdi -> bl_ponto_fraco10) > 0) {
                $PontoFraco10 = $hbdi -> bl_ponto_fraco10;
            }
            if (strlen(set_value('PontoFraco10')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco10 = set_value('PontoFraco10');
            }
            $attributes = array('id'=>'PontoFraco10','name' => 'PontoFraco10', 'value' => '1','onchange'=>"questao20(10,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco10, ($PontoFraco10=='1' && strlen($PontoFraco10)>0));
            echo "
                                                                                                <span>9.10 Fácil de convencer</span><br />";
            $PontoFraco11 = '';
            if (isset($hbdi -> bl_ponto_fraco11) && strlen($hbdi -> bl_ponto_fraco11) > 0) {
                $PontoFraco11 = $hbdi -> bl_ponto_fraco11;
            }
            if (strlen(set_value('PontoFraco11')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco11 = set_value('PontoFraco11');
            }
            $attributes = array('id'=>'PontoFraco11','name' => 'PontoFraco11', 'value' => '1','onchange'=>"questao20(11,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco11, ($PontoFraco11=='1' && strlen($PontoFraco11)>0));
            echo "
                                                                                                <span>9.11 Sem imaginação</span><br />";
            $PontoFraco12 = '';
            if (isset($hbdi -> bl_ponto_fraco12) && strlen($hbdi -> bl_ponto_fraco12) > 0) {
                $PontoFraco12 = $hbdi -> bl_ponto_fraco12;
            }
            if (strlen(set_value('PontoFraco12')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco12 = set_value('PontoFraco12');
            }
            $attributes = array('id'=>'PontoFraco12','name' => 'PontoFraco12', 'value' => '1','onchange'=>"questao20(12,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco12, ($PontoFraco12=='1' && strlen($PontoFraco12)>0));
            echo "
                                                                                                <span>9.12 Maluco</span><br />";
            $PontoFraco13 = '';
            if (isset($hbdi -> bl_ponto_fraco13) && strlen($hbdi -> bl_ponto_fraco13) > 0) {
                $PontoFraco13 = $hbdi -> bl_ponto_fraco13;
            }
            if (strlen(set_value('PontoFraco13')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco13 = set_value('PontoFraco13');
            }
            $attributes = array('id'=>'PontoFraco13','name' => 'PontoFraco13', 'value' => '1','onchange'=>"questao20(13,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco13, ($PontoFraco13=='1' && strlen($PontoFraco13)>0));
            echo "
                                                                                                <span>9.13 Calculista</span><br />";
            $PontoFraco14 = '';
            if (isset($hbdi -> bl_ponto_fraco14) && strlen($hbdi -> bl_ponto_fraco14) > 0) {
                $PontoFraco14 = $hbdi -> bl_ponto_fraco14;
            }
            if (strlen(set_value('PontoFraco14')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco14 = set_value('PontoFraco14');
            }
            $attributes = array('id'=>'PontoFraco14','name' => 'PontoFraco14', 'value' => '1','onchange'=>"questao20(14,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco14, ($PontoFraco14=='1' && strlen($PontoFraco14)>0));
            echo "
                                                                                                <span>9.14 Ingênuo</span><br />";
            $PontoFraco15 = '';
            if (isset($hbdi -> bl_ponto_fraco15) && strlen($hbdi -> bl_ponto_fraco15) > 0) {
                $PontoFraco15 = $hbdi -> bl_ponto_fraco15;
            }
            if (strlen(set_value('PontoFraco15')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco15 = set_value('PontoFraco15');
            }
            $attributes = array('id'=>'PontoFraco15','name' => 'PontoFraco15', 'value' => '1','onchange'=>"questao20(15,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco15, ($PontoFraco15=='1' && strlen($PontoFraco15)>0));
            echo "
                                                                                                <span>9.15 Bitolado</span><br />";
            $PontoFraco16 = '';
            if (isset($hbdi -> bl_ponto_fraco16) && strlen($hbdi -> bl_ponto_fraco16) > 0) {
                $PontoFraco16 = $hbdi -> bl_ponto_fraco16;
            }
            if (strlen(set_value('PontoFraco16')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco16 = set_value('PontoFraco16');
            }
            $attributes = array('id'=>'PontoFraco16','name' => 'PontoFraco16', 'value' => '1','onchange'=>"questao20(16,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco16, ($PontoFraco16=='1' && strlen($PontoFraco16)>0));
            echo "
                                                                                                <span>9.16 Inconsequente</span><br />";
            $PontoFraco17 = '';
            if (isset($hbdi -> bl_ponto_fraco17) && strlen($hbdi -> bl_ponto_fraco17) > 0) {
                $PontoFraco17 = $hbdi -> bl_ponto_fraco17;
            }
            if (strlen(set_value('PontoFraco17')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco17 = set_value('PontoFraco17');
            }
            $attributes = array('id'=>'PontoFraco17','name' => 'PontoFraco17', 'value' => '1','onchange'=>"questao20(17,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco17, ($PontoFraco17=='1' && strlen($PontoFraco17)>0));
            echo "
                                                                                                <span>9.17 Não se mistura</span><br />";
            $PontoFraco18 = '';
            if (isset($hbdi -> bl_ponto_fraco18) && strlen($hbdi -> bl_ponto_fraco18) > 0) {
                $PontoFraco18 = $hbdi -> bl_ponto_fraco18;
            }
            if (strlen(set_value('PontoFraco18')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco18 = set_value('PontoFraco18');
            }
            $attributes = array('id'=>'PontoFraco18','name' => 'PontoFraco18', 'value' => '1','onchange'=>"questao20(18,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco18, ($PontoFraco18=='1' && strlen($PontoFraco18)>0));
            echo "
                                                                                                <span>9.18 Ultrassensível</span><br />";
            $PontoFraco19 = '';
            if (isset($hbdi -> bl_ponto_fraco19) && strlen($hbdi -> bl_ponto_fraco19) > 0) {
                $PontoFraco19 = $hbdi -> bl_ponto_fraco19;
            }
            if (strlen(set_value('PontoFraco19')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco19 = set_value('PontoFraco19');
            }
            $attributes = array('id'=>'PontoFraco19','name' => 'PontoFraco19', 'value' => '1','onchange'=>"questao20(19,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco19, ($PontoFraco19=='1' && strlen($PontoFraco19)>0));
            echo "
                                                                                                <span>9.19 Quadrado</span><br />";
            $PontoFraco20 = '';
            if (isset($hbdi -> bl_ponto_fraco20) && strlen($hbdi -> bl_ponto_fraco20) > 0) {
                $PontoFraco20 = $hbdi -> bl_ponto_fraco20;
            }
            if (strlen(set_value('PontoFraco20')) > 0 || strlen(set_value('salvar'))>0) {
                $PontoFraco20 = set_value('PontoFraco20');
            }
            $attributes = array('id'=>'PontoFraco20','name' => 'PontoFraco20', 'value' => '1','onchange'=>"questao20(20,'PontoFraco')");
            echo form_checkbox($attributes, $PontoFraco20, ($PontoFraco20=='1' && strlen($PontoFraco20)>0));
            echo "
                                                                                                <span>9.20 Sem disciplina</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("10. Quando tenho que resolver um problema, eu geralmente… (Assinale apenas uma alternativa):", 'Resolver');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Resolver = '';
            if (isset($hbdi -> in_resolver) && strlen($hbdi -> in_resolver) > 0) {
                $Resolver = $hbdi -> in_resolver;
            }
            if (strlen(set_value('Resolver')) > 0 || strlen(set_value('salvar'))>0) {
                $Resolver = set_value('Resolver');
            }
            $attributes = array('id'=>'Resolver1','name' => 'Resolver', 'value' => '1','onchange'=>"questao4(1,'Resolver')");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='1' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.1 Visualizo os fatos; tratando-os de forma intuitiva e holística</span><br />";
            $attributes = array('id'=>'Resolver2','name' => 'Resolver', 'value' => '2','onchange'=>"questao4(2,'Resolver')");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='2' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.2 Organizo os fatos; tratando os detalhes de forma realista e cronológica</span><br />";
            $attributes = array('id'=>'Resolver3','name' => 'Resolver', 'value' => '3','onchange'=>"questao4(3,'Resolver')");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='3' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.3 Sinto os fatos; tratando-os de forma expressiva e interpessoal</span><br />";
            $attributes = array('id'=>'Resolver4','name' => 'Resolver', 'value' => '4','onchange'=>"questao4(4,'Resolver')");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='4' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.4 Analiso os fatos; tratando-os de forma lógica e racional</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("11. Quando tenho que resolver um problema, eu procuro… (Assinale apenas uma alternativa):", 'Procuro');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Procuro = '';
            if (isset($hbdi -> in_procuro) && strlen($hbdi -> in_procuro) > 0) {
                $Procuro = $hbdi -> in_procuro;
            }
            if (strlen(set_value('Procuro')) > 0 || strlen(set_value('salvar'))>0) {
                $Procuro = set_value('Procuro');
            }
            $attributes = array('id'=>'Procuro1','name' => 'Procuro', 'value' => '1','onchange'=>"questao4(1,'Procuro')");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='1' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.1 Uma visão interpessoal; emocional; humana</span><br />";
            $attributes = array('id'=>'Procuro2','name' => 'Procuro', 'value' => '2','onchange'=>"questao4(2,'Procuro')");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='2' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.2 Uma visão organizada; detalhada; cronológica</span><br />";
            $attributes = array('id'=>'Procuro3','name' => 'Procuro', 'value' => '3','onchange'=>"questao4(3,'Procuro')");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='3' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.3 Uma visão analítica; lógica; racional; de resultados</span><br />";
            $attributes = array('id'=>'Procuro4','name' => 'Procuro', 'value' => '4','onchange'=>"questao4(4,'Procuro')");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='4' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.4 Uma visão intuitiva; conceitual; visual; de contexto geral</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("12. Quais as frases que mais se aproximam do que você diz? (Assinale três alternativas):", 'Frase1');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Frase1 = '';
            if (isset($hbdi -> bl_frase1) && strlen($hbdi -> bl_frase1) > 0) {
                $Frase1 = $hbdi -> bl_frase1;
            }
            if (strlen(set_value('Frase1')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase1 = set_value('Frase1');
            }
            $attributes = array('id'=>'Frase1','name' => 'Frase1', 'value' => '1','onchange'=>"questao12(1,'Frase')");
            echo form_checkbox($attributes, $Frase1, ($Frase1=='1' && strlen($Frase1)>0));
            echo "
                                                                                                <span>12.1 Sempre fazemos desta forma</span><br />";
            $Frase2 = '';
            if (isset($hbdi -> bl_frase2) && strlen($hbdi -> bl_frase2) > 0) {
                $Frase2 = $hbdi -> bl_frase2;
            }
            if (strlen(set_value('Frase2')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase2 = set_value('Frase2');
            }
            $attributes = array('id'=>'Frase2','name' => 'Frase2', 'value' => '1','onchange'=>"questao12(2,'Frase')");
            echo form_checkbox($attributes, $Frase2, ($Frase2=='1' && strlen($Frase2)>0));
            echo "
                                                                                                <span>12.2 Vamos ao ponto-chave do problema</span><br />";
            $Frase3 = '';
            if (isset($hbdi -> bl_frase3) && strlen($hbdi -> bl_frase3) > 0) {
                $Frase3 = $hbdi -> bl_frase3;
            }
            if (strlen(set_value('Frase3')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase3 = set_value('Frase3');
            }
            $attributes = array('id'=>'Frase3','name' => 'Frase3', 'value' => '1','onchange'=>"questao12(3,'Frase')");
            echo form_checkbox($attributes, $Frase3, ($Frase3=='1' && strlen($Frase3)>0));
            echo "
                                                                                                <span>12.3 Vejamos os valores humanos</span><br />";
            $Frase4 = '';
            if (isset($hbdi -> bl_frase4) && strlen($hbdi -> bl_frase4) > 0) {
                $Frase4 = $hbdi -> bl_frase4;
            }
            if (strlen(set_value('Frase4')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase4 = set_value('Frase4');
            }
            $attributes = array('id'=>'Frase4','name' => 'Frase4', 'value' => '1','onchange'=>"questao12(4,'Frase')");
            echo form_checkbox($attributes, $Frase4, ($Frase4=='1' && strlen($Frase4)>0));
            echo "
                                                                                                <span>12.4 Vamos analisar</span><br />";
            $Frase5 = '';
            if (isset($hbdi -> bl_frase5) && strlen($hbdi -> bl_frase5) > 0) {
                $Frase5 = $hbdi -> bl_frase5;
            }
            if (strlen(set_value('Frase5')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase5 = set_value('Frase5');
            }
            $attributes = array('id'=>'Frase5','name' => 'Frase5', 'value' => '1','onchange'=>"questao12(5,'Frase')");
            echo form_checkbox($attributes, $Frase5, ($Frase5=='1' && strlen($Frase5)>0));
            echo "
                                                                                                <span>12.5 Vamos ver o quadro geral</span><br />";
            $Frase6 = '';
            if (isset($hbdi -> bl_frase6) && strlen($hbdi -> bl_frase6) > 0) {
                $Frase6 = $hbdi -> bl_frase6;
            }
            if (strlen(set_value('Frase6')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase6 = set_value('Frase6');
            }
            $attributes = array('id'=>'Frase6','name' => 'Frase6', 'value' => '1','onchange'=>"questao12(6,'Frase')");
            echo form_checkbox($attributes, set_value('Frase6'), (set_value('Frase6')=='1' && strlen(set_value('Frase6'))>0));
            echo "
                                                                                                <span>12.6 Vamos ver o desenvolvimento de equipe</span><br />";
            $Frase7 = '';
            if (isset($hbdi -> bl_frase7) && strlen($hbdi -> bl_frase7) > 0) {
                $Frase7 = $hbdi -> bl_frase7;
            }
            if (strlen(set_value('Frase7')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase7 = set_value('Frase7');
            }
            $attributes = array('id'=>'Frase7','name' => 'Frase7', 'value' => '1','onchange'=>"questao12(7,'Frase')");
            echo form_checkbox($attributes, $Frase7, ($Frase7=='1' && strlen($Frase7)>0));
            echo "
                                                                                                <span>12.7 Vamos conhecer o resultado</span><br />";
            $Frase8 = '';
            if (isset($hbdi -> bl_frase8) && strlen($hbdi -> bl_frase8) > 0) {
                $Frase8 = $hbdi -> bl_frase8;
            }
            if (strlen(set_value('Frase8')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase8 = set_value('Frase8');
            }
            $attributes = array('id'=>'Frase8','name' => 'Frase8', 'value' => '1','onchange'=>"questao12(8,'Frase')");
            echo form_checkbox($attributes, $Frase8, ($Frase8=='1' && strlen($Frase8)>0));
            echo "
                                                                                                <span>12.8 Este é o grande sucesso conceitual</span><br />";
            $Frase9 = '';
            if (isset($hbdi -> bl_frase9) && strlen($hbdi -> bl_frase9) > 0) {
                $Frase9 = $hbdi -> bl_frase9;
            }
            if (strlen(set_value('Frase9')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase9 = set_value('Frase9');
            }
            $attributes = array('id'=>'Frase9','name' => 'Frase9', 'value' => '1','onchange'=>"questao12(9,'Frase')");
            echo form_checkbox($attributes, $Frase9, ($Frase9=='1' && strlen($Frase9)>0));
            echo "
                                                                                                <span>12.9 Vamos manter a lei e a ordem</span><br />";
            $Frase10 = '';
            if (isset($hbdi -> bl_frase10) && strlen($hbdi -> bl_frase10) > 0) {
                $Frase10 = $hbdi -> bl_frase10;
            }
            if (strlen(set_value('Frase10')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase10 = set_value('Frase10');
            }
            $attributes = array('id'=>'Frase10','name' => 'Frase10', 'value' => '1','onchange'=>"questao12(10,'Frase')");
            echo form_checkbox($attributes, $Frase10, ($Frase10=='1' && strlen($Frase10)>0));
            echo "
                                                                                                <span>12.10 Vamos inovar e criar sinergia</span><br />";
            $Frase11 = '';
            if (isset($hbdi -> bl_frase11) && strlen($hbdi -> bl_frase11) > 0) {
                $Frase11 = $hbdi -> bl_frase11;
            }
            if (strlen(set_value('Frase11')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase11 = set_value('Frase11');
            }
            $attributes = array('id'=>'Frase11','name' => 'Frase11', 'value' => '1','onchange'=>"questao12(11,'Frase')");
            echo form_checkbox($attributes, $Frase11, ($Frase11=='1' && strlen($Frase11)>0));
            echo "
                                                                                                <span>12.11 Vamos participar e envolver</span><br />";
            $Frase12 = '';
            if (isset($hbdi -> bl_frase12) && strlen($hbdi -> bl_frase12) > 0) {
                $Frase12 = $hbdi -> bl_frase12;
            }
            if (strlen(set_value('Frase12')) > 0 || strlen(set_value('salvar'))>0) {
                $Frase12 = set_value('Frase12');
            }
            $attributes = array('id'=>'Frase12','name' => 'Frase12', 'value' => '1','onchange'=>"questao12(12,'Frase')");
            echo form_checkbox($attributes, $Frase12, ($Frase12=='1' && strlen($Frase12)>0));
            echo "
                                                                                                <span>12.12 É mais seguro desta forma</span><br />";


            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    ";

            echo "
                         
                                                                                
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";


            //if(isset($questoes)){
            $attributes = array('class' => 'btn btn-primary');
            echo form_submit('salvar', 'Salvar', $attributes);
            echo form_submit('salvar', 'Concluir', $attributes);
            //}
            echo "
                                                                                        <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">Cancelar</button>";

            echo "
                                                                            </div>
                                                                        </form>
                                                                        
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
            $pagina['js']="
                                                <script type=\"text/javascript\">
                                                        function questao20(questao,enunciado){
                                                                var soma = 0;
                                                                for(var i = 1;i<=20;i++){
                                                                        
                                                                        if(document.getElementById(enunciado+i).checked == 1){
                                                                                soma+=1;
                                                                        }
                                                                }
                                                                if(soma>5){
                                                                        
                                                                        document.getElementById(enunciado+questao).checked=false;
                                                                }
                                                                
                                                        }
                                                        function questao4(questao,enunciado){
                                                                for(var i = 1;i<=4;i++){
                                                                        if(i!=questao){
                                                                                document.getElementById(enunciado+i).checked=false;
                                                                        }
                                                                        
                                                                }
                                                                //document.getElementById(enunciado+questao).checked=true;
                                                        }
                                                        function questao16(questao,enunciado){
                                                                var soma = 0;
                                                                for(var i = 1;i<=16;i++){
                                                                        
                                                                        if(document.getElementById(enunciado+i).checked == 1){
                                                                                soma+=1;
                                                                        }
                                                                }
                                                                if(soma>4){
                                                                        
                                                                        document.getElementById(enunciado+questao).checked=false;
                                                                }
                                                                
                                                        }
                                                        function questao12(questao,enunciado){
                                                                var soma = 0;
                                                                for(var i = 1;i<=12;i++){
                                                                        
                                                                        if(document.getElementById(enunciado+i).checked == 1){
                                                                                soma+=1;
                                                                        }
                                                                }
                                                                if(soma>3){                                                                   
                                                                        document.getElementById(enunciado+questao).checked=false;
                                                                }
                                                                
                                                        }
                                                </script>
                                                ";
        }
    }
    /*else{
            echo "
                                            <div class=\"kt-portlet__body\">";
            if(strlen($erro)>0){
                    echo "
                                                <div class=\"alert background-danger\" role=\"alert\">
                                                    <div class=\"alert-icon\">
                                                        <i class=\"fa fa-exclamation-triangle\"></i>
                                                    </div>
                                                    <div class=\"alert-text\">
                                                        <strong>ERRO</strong>:<br /> $erro
                                                    </div>
                                                </div>
                                            </div>";
    //$erro='';
            }
            else if(strlen($sucesso) > 0){
                    echo "
                                                <div class=\"alert alert-success\" role=\"alert\">
                                                    <div class=\"alert-icon\">
                                                        <i class=\"fa fa-check-circle\"></i>
                                                    </div>
                                                    <div class=\"alert-text\">
                                                        $sucesso
                                                    </div>
                                                </div>
                                            </div>";
            }
    }*/
}

echo "
                                            </div>";

$this->load->view('templates/internaRodape', $pagina);
