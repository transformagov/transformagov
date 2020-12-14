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

$this -> load -> view('internaCabecalho', $pagina);
$this -> load -> view('internaMenu', $pagina);

echo "
                        <div class=\"pcoded-content\">
                            <div class=\"pcoded-inner-content\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper\">
                                        <div class=\"page-body\">
                                            <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                    <div class=\"card\">
                                                        <div class=\"card-block\">";
if($menu2 == 'index'){ //lista de candidaturas - perfil candidato
        echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                            <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>";
        if($num_vagas > 0){
                echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <a href=\"".base_url('Candidaturas/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-edit\"></i> Candidatar-se a uma nova vaga </a>
                                                                    </div>";
        }
        else{
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
                                                                                            <th>Prazo</th>
                                                                                            <th>Status</th>
                                                                                            <th>Ações</th
>                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        $atual =time();                                                                    
        if(isset($candidaturas)){

                foreach ($candidaturas as $linha){
                        $dt_candidatura = mysql_to_unix($linha -> dt_candidatura);
                        $dt_fim = mysql_to_unix($linha -> dt_fim);
                        $dt_aderencia = strtotime($linha -> dt_aderencia);
                        echo "
                                                                                    <tr>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_candidatura)."\" data-order=\"$dt_candidatura\">".show_date($linha -> dt_candidatura)."</td>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_fim, true)."\" data-order=\"$dt_fim\">".show_date($linha -> dt_fim, true)."</td>";
                        if(isset($linha -> es_status) && ($linha -> es_status == 1 || $linha -> es_status == 4 || $linha -> es_status == 6)){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-warning badge-lg\">Pendente</span></td>";
                        }
                        else{
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Concluído</span></td>";
                        }
                        if(($linha -> es_status == 10 || $linha -> es_status == 11 || $linha -> es_status == 12) && $linha -> en_aderencia == '1'){
                                echo "
                                                                                            <td class=\"text-center\">";
                                if($dt_aderencia > $atual || strlen($linha -> dt_aderencia) == 0){
                                        echo anchor('Candidaturas/TesteAderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check-o">Teste de aderência</i>', " class=\"btn btn-sm btn-square btn-danger\" title=\"Teste de aderência\"");
                                }                                                            
                                
                        }
                        else if($dt_fim > time()){ //dentro do prazo
                                echo "
                                                                                            <td class=\"text-center\">";
                                
                                if($linha -> es_status == 1){
                                        echo anchor('Candidaturas/Prova/'.$linha -> es_vaga, '<i class="fa fa-lg mr-0 fa-edit">Continuar preenchimento</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Continuar preenchimento\"");
                                }
                                if($linha -> es_status == 4){
                                        echo anchor('Candidaturas/Curriculo/'.$linha -> es_vaga, '<i class="fa fa-lg mr-0 fa-edit">Continuar preenchimento</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Continuar preenchimento\"");
                                }
                                if($linha -> es_status == 6){
                                        echo anchor('Candidaturas/Questionario/'.$linha -> es_vaga, '<i class="fa fa-lg mr-0 fa-edit">Continuar preenchimento</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Continuar preenchimento\"");
                                }
								
                        }
                        else{
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
        }
        else{
                echo "
                                                                                    <tr>
                                                                                            <td colspan=\"5\">Você não possui candidaturas registradas</td>
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
}
else{
        echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                <div class=\"col-lg-8\">
                                                                    <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                </div>
                                                            </div>
                                                            <div class=\"row\">
                                                                <div class=\"col-md-12\">";
        
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert background-danger\">
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br/>$erro<br />
                                                                            </div>
                                                                    </div>";
                //$erro='';
        }
        else if(strlen($sucesso) > 0){
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
        if($menu2 == 'Curriculo'){
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
                if(strlen(set_value('num_formacao')) > 0){
                       
                        $num_formacao = set_value('num_formacao');
                }
                if(!($num_formacao>0)){
                        $num_formacao = 1;
                }
                if(strlen(set_value('num_experiencia')) > 0){
                        
                        $num_experiencia = set_value('num_experiencia');
                }
                if(!($num_experiencia>0)){
                        $num_experiencia = 1;
                }
                echo form_open_multipart($url, $attributes, array('vaga' => $vaga, 'num_formacao' => $num_formacao, 'num_experiencia' => $num_experiencia));
        }
        else{
				
                if(isset($vaga)&&$vaga>0){
						if($menu2 == 'Prova' || $menu2 == 'Questionario'){
								/*if($menu2 == 'Questionario'){
										$attributes["onsubmit"]="return(valida_formulario(this));";
								}*/
								echo form_open_multipart($url, $attributes, array('vaga' => $vaga));
						}
						else{
								echo form_open($url, $attributes, array('vaga' => $vaga));
						}
                        
                }
                else if(isset($candidatura)&&$candidatura>0){
						if($menu2 == 'Prova' || $menu2 == 'Questionario'){
								echo form_open_multipart($url, $attributes, array('candidatura' => $candidatura));
						}
						else{
								echo form_open($url, $attributes, array('candidatura' => $candidatura));
						}
                        
                }
                else{
                        echo form_open($url, $attributes);
                }
        }
        if($menu2 != 'TesteAderencia' && $menu2!= 'delete' && $menu2 != 'editDossie'){
                echo "
                                                                            <div class=\"steps clearfix\">
                                                                                <ul role=\"tablist\">";
                if($menu2 == 'create'){
                        echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
                }
                else{
                        echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
                }
				if($menu2 != 'delete')
                echo "
                                                                                        <a href=\"#\">
                                                                                            <span class=\"number\">1.</span>  
                                                                                            Escolha da vaga 
                                                                                        </a>
                                                                                    </li>";
                if($menu2 == 'Prova'){
                        echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
                        echo "
                                                                                        <a id=\"example-advanced-form-t-1\" href=\"#example-advanced-form-h-1\" aria-controls=\"example-advanced-form-p-1\">
                                                                                            <span class=\"number\">2.</span>  Pré-requisitos
                                                                                        </a>
                                                                                    </li>";                                                            
                }
                else{
                        echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
                        if(isset($candidatura) && ($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6')){
                                echo "
                                                                                        <a id=\"example-advanced-form-t-1\" href=\"".base_url('Candidaturas/Prova/'.$vaga)."\" aria-controls=\"example-advanced-form-p-1\">
                                                                                            <span class=\"number\">2.</span>  Pré-requisitos
                                                                                        </a>
                                                                                    </li>";
                        }
                        else{
                                echo "
                                                                                        <a id=\"example-advanced-form-t-1\" href=\"#example-advanced-form-h-1\" aria-controls=\"example-advanced-form-p-1\">
                                                                                            <span class=\"number\">2.</span>  Pré-requisitos
                                                                                        </a>
                                                                                    </li>"; 
                        }
                                                                                            
                }
                
                if($menu2 == 'Curriculo'){
                        echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
                        
                        echo "
                                                                                        <a id=\"example-advanced-form-t-2\" href=\"#example-advanced-form-h-2\" aria-controls=\"example-advanced-form-p-2\">
                                                                                            <span class=\"number\">3.</span>  Currículo 
                                                                                        </a>
                                                                                    </li>";
                                                                                   
                                

                }
                else{
                        echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
                        if(isset($candidatura) && ($candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6')){
                                echo "
                                                                                        <a id=\"example-advanced-form-t-2\" href=\"".base_url('Candidaturas/Curriculo/'.$vaga)."\" aria-controls=\"example-advanced-form-p-2\">
                                                                                            <span class=\"number\">3.</span>  Currículo 
                                                                                        </a>
                                                                                    </li>";
                        }
                        else{
                                echo "
                                                                                        <a id=\"example-advanced-form-t-2\" href=\"#example-advanced-form-h-2\" aria-controls=\"example-advanced-form-p-2\">
                                                                                            <span class=\"number\">3.</span>  Currículo 
                                                                                        </a>
                                                                                    </li>";
                        }
                }
                
                if($menu2 == 'Questionario'){
                        echo "
                                                                                    <li role=\"tab\" class=\"first current\" aria-disabled=\"false\" aria-selected=\"true\">";
                        echo "
                                                                                        <a id=\"example-advanced-form-t-3\" href=\"#example-advanced-form-h-3\" aria-controls=\"example-advanced-form-p-3\">
                                                                                            <span class=\"number\">4.</span>  Requisitos desejáveis
                                                                                        </a>
                                                                                    </li>";                                                            
                }
                else{
                        echo "
                                                                                    <li role=\"tab\" class=\"disabled\" aria-disabled=\"true\">";
                        if(isset($candidatura) && ($candidatura[0] -> es_status == '6')){
                                echo "
                                                                                        <a id=\"example-advanced-form-t-3\" href=\"".base_url('Candidaturas/Questionario/'.$vaga)."\" aria-controls=\"example-advanced-form-p-3\">
                                                                                            <span class=\"number\">4.</span>  Requisitos desejáveis
                                                                                        </a>
                                                                                    </li>";
                        }
                        else{
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
        if($menu2 == 'create'){ //cadastro de candidatura
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
        }
        else if($menu2 == 'Prova'){ //prova
                if(!isset($questoes)){
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
                if(strlen($sucesso) == 0 || (strlen($sucesso) > 0 && isset($_POST['cadastrar']) && $_POST['cadastrar'] == "Salvar dados")){
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
                        
                        if(isset($questoes)){
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
        }
        else if($menu2 == 'Curriculo'){ //currículo
                
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
                        for($i = 1; $i <= $num_formacao; $i++){
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
                                if(!isset($en_tipo[$i]) || (strlen($en_tipo[$i]) == 0 && strlen(set_value("tipo{$i}")) > 0) || (strlen(set_value("tipo{$i}")) > 0 && $en_tipo != set_value("tipo{$i}"))){
                                        $en_tipo[$i] = set_value("tipo{$i}");
                                }
                                if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" required=\"required\" oninvalid=\"this.scrollIntoView({block:'center'});\" id=\"tipo{$i}\" onchange=\"mostra_carga_horaria({$i})\"");
                                }
                                else{
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
                                if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});");
                                if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
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
                                if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});");
                                if(strstr($erro, "instituição de ensino da 'Formação acadêmica {$i}'")){
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
                                if(!isset($dt_conclusao[$i]) || (strlen($dt_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $dt_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $dt_conclusao[$i] = set_value("conclusao{$i}");
                                }
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});",
                                                    'type' => 'date',
                                                    'class' => 'form-control');
                                if(strstr($erro, "data da conclusão da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
                                echo form_input($attributes, $dt_conclusao[$i]);
                                if(!isset($pr_formacao[$i]) || (strlen($pr_formacao[$i]) == 0 && strlen(set_value("codigo_formacao{$i}")) > 0) || (strlen(set_value("codigo_formacao{$i}")) > 0 && $pr_formacao[$i] != set_value("codigo_formacao{$i}"))){
                                        $pr_formacao[$i] = set_value("codigo_formacao{$i}");
                                }
                                echo form_input(array('name' => 'codigo_formacao'.$i, 'type'=>'hidden', 'id' =>'codigo_formacao'.$i,'value'=>$pr_formacao[$i]));
                                
                                if(!isset($es_formacao_pai[$i]) || (strlen($es_formacao_pai[$i]) == 0 && strlen(set_value("codigo_formacao_pai{$i}")) > 0) || (strlen(set_value("codigo_formacao_pai{$i}")) > 0 && $es_formacao_pai[$i] != set_value("codigo_formacao_pai{$i}"))){
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
                                if(!isset($in_cargahoraria[$i]) || (strlen($in_cargahoraria[$i]) == 0 && strlen(set_value("cargahoraria{$i}")) > 0) || (strlen(set_value("cargahoraria{$i}")) > 0 && $in_cargahoraria[$i] != set_value("conclusao{$i}"))){
                                                $in_cargahoraria[$i] = set_value("cargahoraria{$i}");
                                }
                                $attributes = array('name' => "cargahoraria{$i}",
                                                                        'id' => "cargahoraria{$i}",
                                                                        'maxlength' => '10',
                                                                        'type' => 'number',
                                                                        'class' => 'form-control');
                                if(strstr($erro, "carga horária da 'Formação acadêmica {$i}'")){
                                                $attributes['class'] = 'form-control is-invalid';
                                }

                                echo form_input($attributes, $in_cargahoraria[$i]);
                                if(!isset($pr_formacao[$i]) || (strlen($pr_formacao[$i]) == 0 && strlen(set_value("codigo_formacao{$i}")) > 0) || (strlen(set_value("codigo_formacao{$i}")) > 0 && $pr_formacao[$i] != set_value("codigo_formacao{$i}"))){
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
                                if(strstr($erro, "diploma / certificado da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }
								if(isset($anexos_formacao[$i])){
										$vc_anexo = $anexos_formacao[$i][0]->vc_arquivo;
										$pr_arquivo = $anexos_formacao[$i][0]->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
								else if(isset($anexos2_formacao2[$i])){
										$vc_anexo = $anexos_formacao2[$i][0]->vc_arquivo;
										$pr_arquivo = $anexos_formacao2[$i][0]->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
                                else{
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
                        for($i = 1; $i <= $num_experiencia; $i++){
                                if($i == 1){
                                        echo "
                                                                                        <div id=\"row_experiencia{$i}\">
                                                                                            <fieldset>
                                                                                                <legend>Experiência profissional {$i}<abbr title=\"Prezado(a) candidato (a) atente-se ao preenchimento da experiência profissional, tal informação deve conter, necessariamente, não apenas os nomes das instituições nas quais você trabalhou, mas também o período (ano de início e término do vínculo), o tempo de experiência em determinada atividade, o tipo (se foi de liderança, coordenação, parte da equipe técnica etc), a atividade realizada e o número de liderados (se esta informação for requisito da vaga).\">?</abbr></legend>";
                                }
                                else{
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
                                echo form_label('Instituição / empresa <abbr title="Obrigatório">*</abbr>', "empresa{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                if(!isset($vc_empresa[$i]) || (strlen($vc_empresa[$i]) == 0 && strlen(set_value("empresa{$i}")) > 0) || (strlen(set_value("empresa{$i}")) > 0 && $vc_empresa[$i] != set_value("empresa{$i}"))){
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
                                if(!isset($dt_inicio[$i]) || (strlen($dt_inicio[$i]) == 0 && strlen(set_value("inicio{$i}")) > 0) || (strlen(set_value("inicio{$i}")) > 0 && $dt_inicio[$i] != set_value("inicio{$i}"))){
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
                                if(!isset($bl_emprego_atual[$i]) || (strlen($bl_emprego_atual[$i]) == 0 && strlen(set_value("emprego_atual{$i}")) > 0) || (strlen(set_value("emprego_atual{$i}")) > 0 && $bl_emprego_atual[$i] != set_value("emprego_atual{$i}"))){
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
                                if(!isset($dt_fim[$i]) || (strlen($dt_fim[$i]) == 0 && strlen(set_value("fim{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $dt_fim[$i] != set_value("fim{$i}"))){
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
                                if(!isset($tx_atividades[$i]) || (strlen($tx_atividades[$i]) == 0 && strlen(set_value("atividades{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $tx_atividades[$i] != set_value("atividades{$i}"))){
                                        $tx_atividades[$i] = set_value("atividades{$i}");
                                }
                                $attributes = array('name' => "atividades{$i}",
                                                    'id' => "atividades{$i}",
                                                    'rows' => '4',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'oninvalid' => "this.scrollIntoView({block:'center'});");
                                echo form_textarea($attributes, $tx_atividades[$i]);
                                if(!isset($pr_experienca[$i]) || (strlen($pr_experienca[$i]) == 0 && strlen(set_value("codigo_experiencia{$i}")) > 0) || (strlen(set_value("codigo_experiencia{$i}")) > 0 && $pr_experienca[$i] != set_value("codigo_experiencia{$i}"))){
                                        $pr_experienca[$i] = set_value("codigo_experiencia{$i}");
                                }
                                echo form_input(array('name' => 'codigo_experiencia'.$i, 'type'=>'hidden', 'id' =>'codigo_experiencia'.$i,'value'=>$pr_experienca[$i]));
                                
                                if(!isset($es_experiencia_pai[$i]) || (strlen($es_experiencia_pai[$i]) == 0 && strlen(set_value("codigo_experiencia_pai{$i}")) > 0) || (strlen(set_value("codigo_experiencia_pai{$i}")) > 0 && $es_experiencia_pai[$i] != set_value("codigo_experiencia_pai{$i}"))){
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
								if(strstr($erro, "comprovante da 'Experiência profissional {$i}'")){
										$attributes['class'] = 'form-control is-invalid';
								}
								if(isset($anexos_experiencia[$i])){
										$vc_anexo = $anexos_experiencia[$i][0]->vc_arquivo;
										$pr_arquivo = $anexos_experiencia[$i][0]->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
								else if(isset($anexos_experiencia2[$i])){
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
                        for($i = 1; $i <= $num_formacao; $i++){

                                $pagina['js'].="
                            
                                $('#div_carga_horaria{$i}').hide();
                                mostra_carga_horaria({$i});
                                esconde_data_termino({$i});
                                
                              
                                ";
                        }
                        for($i = 1;$i <= $num_experiencia; $i++){
                                $pagina['js'].="                            
                                esconde_data_termino({$i});
                              
                                ";
                        }
                        $pagina['js'].="
                });
        </script>
        
        ";
                //}
        }
        else if($menu2 == 'Questionario'){ //questionário
                if(!isset($questoes)){
                        /*echo "
                                                <script type=\"text/javascript\">
                                                        alert('O criador dessa vaga deve inserir as questões relativa a esse formulário.');
                                                        window.location='/';
                                                </script>";*/
						if(strlen($sucesso) == 0 || (strlen($sucesso) > 0 && isset($_POST['cadastrar']) && $_POST['cadastrar'] == "Salvar dados")){

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
                }
                else{
                        if(strlen($sucesso) == 0 || (strlen($sucesso) > 0 && isset($_POST['cadastrar']) && $_POST['cadastrar'] == "Salvar dados")){
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
                                if(isset($questoes)){
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
        }
        else if($menu2 == 'TesteAderencia'){ //Teste de aderência
                
                if(strlen($sucesso) == 0){
                        $CI =& get_instance();
                        $CI -> mostra_questoes($questoes, $respostas, $opcoes, $erro, true);
                        echo form_fieldset_close();
                        
                        echo " 
                                                                                
                                                                            </div>
                                                                            <div class=\"actions clearfix text-center\">";
                
                        
                        if(isset($questoes)){
                                $attributes = array('class' => 'btn btn-primary');
                                $attributes['formnovalidate'] = 'formnovalidate';
                                echo form_submit('salvar', 'Salvar', $attributes);
                                unset($attributes['formnovalidate']);
                                echo form_submit('salvar', 'Concluir', $attributes);
                        }
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
                        
                        
                }
        }
        else if($menu2 == 'editDossie'){
                if(strlen($sucesso) == 0){
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
                        if(strlen($candidaturas[0] -> tx_expectativa_momento) > 0){
                                $tx_expectativa_momento = $candidaturas[0] -> tx_expectativa_momento;
                        }
                        if(strlen(set_value('expectativa_momento')) > 0){
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
                        if(strlen($candidaturas[0] -> tx_observacoes_momento) > 0){
                                $tx_observacoes_momento = $candidaturas[0] -> tx_observacoes_momento;
                        }
                        if(strlen(set_value('observacoes_momento')) > 0){
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
                        if(strlen($candidaturas[0] -> tx_pontos_fortes) > 0){
                                $tx_pontos_fortes = $candidaturas[0] -> tx_pontos_fortes;
                        }
                        if(strlen(set_value('pontos_fortes')) > 0){
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
                        if(strlen($candidaturas[0] -> tx_pontos_melhorias) > 0){
                                $tx_pontos_melhorias = $candidaturas[0] -> tx_pontos_melhorias;
                        }
                        if(strlen(set_value('pontos_melhorias')) > 0){
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
                        if(strlen($candidaturas[0] -> tx_feedback) > 0){
                                $tx_feedback = $candidaturas[0] -> tx_feedback;
                        }
                        if(strlen(set_value('feedback')) > 0){
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
                        if(strlen($candidaturas[0] -> tx_comentarios) > 0){
                                $tx_comentarios = $candidaturas[0] -> tx_comentarios;
                        }
                        if(strlen(set_value('comentarios')) > 0){
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
$this -> load -> view('internaRodape', $pagina);
?>