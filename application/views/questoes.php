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
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}";
if($menu2 == 'index' || $menu2 == 'create'){
        echo ' - Grupo de vagas: '.$grupos[0] -> vc_grupovaga;
}
echo "</h4>
                                                                    </div>";
if($menu2 == 'index'){
        $vigente = 1;
        /*foreach($vagas as $vaga){
                
                if($vaga -> bl_liberado == '1'){
                        $vigente = 1;
                        break;
                }
        }
        if($vigente == 0){*/
        $vigente_etapa = array();
        $chaves = array_keys($etapas);    
        foreach($chaves as $chave){
                $vigente_etapa[$chave]=0;
                
        }
        if(!is_array($questoes)) {
                $questoes = array();
        }
        foreach ($questoes as $linha){
                if($linha -> cont_respostas > 0){
                       $vigente_etapa[$linha -> es_etapa] = 1; 
                       
                }   
        }
        foreach($chaves as $chave){
        
                if($vigente_etapa[$chave] == 0){
                        $vigente = 0;
                        break;
                }
        }
        if($vigente == 0){    
                echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <a href=\"".base_url('Questoes/create/'.$grupo)."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Nova questão neste grupo </a>
                                                                    </div>";
        }
        //}
}
if($menu2 != 'index' && strlen($sucesso) == 0 && ($menu2 == 'create' || $menu2 == 'edit' || $menu2 == 'questoes')){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_questoes').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Questoes/index/'.$grupo)."'\">Cancelar</button>
                                                                    </div>";
}
echo "
                                                            </div>";

if($menu2 == 'index'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
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
                                                                            <tbody>";
        //var_dump($questoes);
        if(isset($questoes)){
                foreach ($questoes as $linha){
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> tx_questao."</td>
                                                                                            <td class=\"text-center\">".$linha -> vc_etapa."</td>
                                                                                            <td class=\"text-center\">";
                        if($linha -> in_tipo == 1){
                                echo 'Customizadas';
                        }
                        else if($linha -> in_tipo == 2){
                                echo 'Aberta';
                        }
                        else if($linha -> in_tipo == 3){
                                echo 'Sim/Não (sim positivo)';
                        }
                        else if($linha -> in_tipo == 4){
                                echo 'Sim/Não (não positivo)';
                        }
                        else if($linha -> in_tipo == 5){
                                echo 'Nenhum/Básico/Intermediário/Avançado';
                        }
						else if($linha -> in_tipo == 6){
                                echo 'Intervalo';
                        }
						else if($linha -> in_tipo == 7){
                                echo 'Upload de arquivo';
                        }
                        echo '</td>';
                        if($linha -> bl_eliminatoria == '1'){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Sim";
                        }
                        else{
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Não";
                        }
                        echo '</span></td>';
                        if($linha -> bl_obrigatorio == '1'){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Sim";
                        }
                        else{
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Não";
                        }
                        echo "</span></td>
                                                                                            <td class=\"text-center\">".$linha -> cont_respostas."</td>";
                        if($linha -> bl_removido == '0'){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">Ativo</span></td>
                                                                                            <td class=\"text-center\" style=\"white-space:nowrap\">
                                                                                                            ";
                                if($linha -> cont_respostas == 0){
                                        echo anchor('Questoes/edit/'.$linha -> pr_questao."/$grupo", '<i class="fa fa-lg mr-0 fa-edit">Editar</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar\"");
                                        echo "
                                                                                                    <a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar questão\" onclick=\"confirm_delete(".$linha -> pr_questao.", {$grupo});\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar questão</i></a>";
                                }
								else{
										 echo anchor('Questoes/view/'.$linha -> pr_questao."/$grupo", '<i class="fa fa-lg mr-0 fa-edit">Visualizar</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Visualizar\"");
								}
                        }
                        else{
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
}
else if($menu2 == 'create' || $menu2 == 'edit'){
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
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
        }
        if(strlen($sucesso) == 0){
                $attributes = array('id' => 'form_questoes');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo, 'grupo' => $grupo, 'num' => set_value('num')));
                }
                else{
                        echo form_open($url, $attributes, array('grupo' => $grupo, 'num' => set_value('num')));
                }
                echo "
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Descrição <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);
                echo "
                                                                            <div class=\"col-lg-6\">";
                if(!isset($tx_questao) || (strlen($tx_questao) == 0 && strlen(set_value('descricao')) > 0)){
                        $tx_questao = set_value('descricao');
                }
                $attributes = array('name' => 'descricao',
                                    
                                    'rows'=>'3',
                                    'class' => 'form-control');
                if(strstr($erro, "'Descrição'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_textarea($attributes, $tx_questao);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Etapa <abbr title="Obrigatório">*</abbr>', 'grupo', $attributes);
                echo "
                                                                            <div class=\"col-lg-3\">";
                //var_dump($etapas);
                $etapas=array(0 => '')+$etapas;
                //unset($etapas[2]);
                if(!isset($es_etapa) || (strlen($es_etapa) == 0 && strlen(set_value('etapa')) > 0)){
                        $es_etapa = set_value('etapa');
                }
                if(strstr($erro, "'Etapa'")){
                        echo form_dropdown('etapa', $etapas, $es_etapa, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('etapa', $etapas, $es_etapa, "class=\"form-control\"");
                }
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Competência', 'grupo', $attributes);
                echo "
                                                                            <div class=\"col-lg-3\">";
                //var_dump($etapas);
                $competencias=array(0 => '')+$competencias;
                //unset($etapas[2]);
                if(!isset($es_competencia) || (strlen($es_competencia) == 0 && strlen(set_value('competencia')) > 0)){
                        $es_competencia = set_value('competencia');
                }
                
                echo form_dropdown('competencia', $competencias, $es_competencia, "class=\"form-control\"");
                
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Obrigatória? <abbr title="Obrigatório">*</abbr>', 'obrigatorio', $attributes);
                echo "
                                                                            <div class=\"col-lg-3\">";
                if(!isset($bl_obrigatorio) || (strlen($bl_obrigatorio) == 0 && strlen(set_value('obrigatorio')) > 0)){
                        $bl_obrigatorio = set_value('obrigatorio');
                }
                $attributes = array('name' => 'obrigatorio',
                                    'value'=>'1');
                echo form_radio($attributes, $bl_obrigatorio, (strlen($bl_obrigatorio)>0 && $bl_obrigatorio=='1'));
                echo ' Sim<br/>';
                $attributes = array('name' => 'obrigatorio',
                                    'value'=>'0');
                echo form_radio($attributes, $bl_obrigatorio, (strlen($bl_obrigatorio)>0 && $bl_obrigatorio=='0'));
                echo ' Não<br/>';
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Eliminatória? <abbr title="Obrigatório">*</abbr>', 'eliminatoria', $attributes);
                echo "
                                                                            <div class=\"col-lg-3\">";
                if(!isset($bl_eliminatoria) || (strlen($bl_eliminatoria) == 0 && strlen(set_value('eliminatoria')) > 0)){
                        $bl_eliminatoria = set_value('eliminatoria');
                }
                $attributes = array('name' => 'eliminatoria',
                                    'value'=>'1');
                echo form_radio($attributes, $bl_eliminatoria, (strlen($bl_eliminatoria)>0 && $bl_eliminatoria=='1'));
                echo ' Sim<br/>';
                $attributes = array('name' => 'eliminatoria',
                                    'value'=>'0');
                echo form_radio($attributes, $bl_eliminatoria, (strlen($bl_eliminatoria)>0 && $bl_eliminatoria=='0'));
                echo ' Não<br/>';
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Peso (desconsiderar se for questão personalizada, já que a pontuação é feita na própria opção)', 'peso', $attributes);
                echo "
                                                                            <div class=\"col-lg-1\">";
                if(!isset($in_peso) || (strlen($in_peso) == 0 && strlen(set_value('peso')) > 0)){
                        $in_peso = set_value('peso');
                }
                $attributes = array('name' => 'peso',
                                    'id'=>'peso',
                                    'maxlength'=>'1',
                                    'class' => 'form-control',
									'min' => '0',
									'max' => '100',
									'oninput' => "if(document.getElementById('peso').value>100){document.getElementById('peso').value=100;}else{if(document.getElementById('peso').value<0){document.getElementById('peso').value=0;}}",
                                    'type' => 'number');
                echo form_input($attributes, $in_peso);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                if(!isset($in_tipo) || (strlen($in_tipo) == 0 && strlen(set_value('tipo')) > 0)){
                        $in_tipo = set_value('tipo');
                }
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Tipo <abbr title="Obrigatório">*</abbr>', 'tipo', $attributes);
                echo "
                                                                            <div class=\"col-lg-4\">";
                $attributes = array(
                            0 => '',
                            1 => 'Customizadas',
                            2 => 'Aberta',
                            3 => 'Sim/Não (sim positivo)',
                            4 => 'Sim/Não (não positivo)',
                            5 => 'Nenhum/Básico/Intermediário/Avançado',
							6 => 'Intervalo (limite definido pelo peso)',
							7 => 'Upload de arquivo'
                            );
                if(strstr($erro, "'Tipo'")){
                        echo form_dropdown('tipo', $attributes, $in_tipo, "class=\"form-control is-invalid\" id=\"tipo\"");
                }
                else{
                        echo form_dropdown('tipo', $attributes, $in_tipo, "class=\"form-control\" id=\"tipo\"");
                }
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Indicação da resposta aceita', 'respostaaceita', $attributes);
                echo "
                                                                            <div class=\"col-lg-6\">";
                if(!isset($vc_respostaAceita) || (strlen($vc_respostaAceita) == 0 && strlen(set_value('respostaaceita')) > 0)){
                        $vc_respostaAceita = set_value('respostaaceita');
                }
                $attributes = array('name' => 'respostaaceita',
                                    'maxlength'=>'250',
                                    'class' => 'form-control');
                echo form_input($attributes, $vc_respostaAceita);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div id=\"div_respostas\">";
                //var_dump($opcoes);
                if(isset($opcoes)){
                        $c=1;
                        foreach ($opcoes as $linha){
                                echo "
                                                                            <fieldset>
                                                                                    <legend>Resposta $c</legend>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-9\">
                                                                                                    <label>Texto</label>
                                                                                                    <input type=\"text\" class=\"form-control\" name=\"texto_".$linha -> pr_opcao."\" value=\"".$linha -> tx_opcao."\" />
                                                                                            </div>
                                                                                            <div class=\"col-lg-3\">
                                                                                                    <label>Valor</label>
                                                                                                    <input type=\"number\" class=\"form-control\" name=\"valor_".$linha -> pr_opcao."\" id=\"slider_input_".$linha -> pr_opcao."\" value=\"".$linha -> in_valor."\" placeholder=\"Valor\"/>
                                                                                            </div>
                                                                                    </div>
                                                                            </fieldset>";
                                $c++;
                        }
                }
                for($i = 1 ; $i <= set_value('num'); $i++){
                        echo "
                                                                            <fieldset>
                                                                                    <legend>Nova resposta $i</legend>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-9\">
                                                                                                    <label>Texto</label>
                                                                                                    <input type=\"text\" class=\"form-control\" name=\"texto{$i}\" value=\"".set_value("texto{$i}")."\" />
                                                                                            </div>
                                                                                            <div class=\"col-lg-3\">
                                                                                                    <label>Valor</label>
                                                                                                    <input type=\"number\" class=\"form-control\" name=\"valor{$i}\" id=\"slider_input{$i}\" value=\"".set_value("valor{$i}")."\" placeholder=\"Valor\"/>
                                                                                            </div>
                                                                                    </div>
                                                                            </fieldset>";
                }
                echo "
                                                                            </div>
                                                                            <hr/>
                                                                            <div id=\"div_adicionar\" style=\"display:none\"><div class=\"j-footer\"><div class=\"row\"><div class=\"col-lg-12 text-center\"><button type=\"button\" id=\"adicionar_resposta\" class=\"btn btn-inverse\"><i class=\"fa fa-plus\"></i> Adicionar resposta</button><br/><br/></div></div></div></div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"row\">
                                                                                            <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_questao', 'Salvar', $attributes);
                echo "
                                                                                                    <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Questoes/index/'.$grupo)."'\">Cancelar</button>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                $pagina['js']="
        <script type=\"text/javascript\">
                $('#tipo').change(function() {
                        if($(this).val()=='1'){
                                $( '#div_adicionar' ).show();
                                $( '#div_respostas' ).show();
                        }
                        else{
                                $( '#div_adicionar' ).hide();
                                $( '#div_respostas' ).hide();
                        }
                });
                $( '#adicionar_resposta' ).click(function() {
                        var valor_num = $('input[name=num]').val();
                        valor_num++;
                        var newElement = '<div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div><fieldset><legend>Nova resposta ' + valor_num + '</legend><div class=\"form-group row\"><div class=\"col-lg-9\"><label>Texto</label><input type=\"text\" class=\"form-control\" name=\"texto' + valor_num + '\" /></div><div class=\"col-lg-3\"><label>Valor</label><div class=\"row align-items-center\"><div class=\"col-6\"><input type=\"number\" class=\"form-control\" name=\"valor' + valor_num + '\" id=\"slider_input' + valor_num + '\" placeholder=\"Valor\"/></div></div></div></div></fieldset>';
                        $( '#div_respostas' ).append( $(newElement) );
                        $('input[name=num]').val(valor_num);
                });
                
                
                ";
                if(strlen($in_peso)==0){
                        $in_peso=0;
                }
                $pagina['js'].="
                $('#tipo').trigger('change');
        </script>";
        }
}
else if($menu2 == 'view'){
		
        
		$attributes = array('id' => 'form_questoes');
		
		echo form_open($url, $attributes, array('codigo' => $codigo, 'grupo' => $grupo, 'num' => set_value('num')));
		
		
		echo "
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Descrição', 'descricao', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
                
		$attributes = array('name' => 'descricao',
							'rows'=>'3',
							'class' => 'form-control',
							'disabled' => 'disabled');
                
		echo form_textarea($attributes, $tx_questao);
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Etapa', 'grupo', $attributes);
		
		$attributes = array('name' => 'etapa',
							
							'class' => 'form-control text-box single-line',
							'disabled' => 'disabled');
		
		echo "        
                                                                    <div class=\"col-lg-6\">";
		//var_dump($etapas);
		$etapas=array(0 => '')+$etapas;
		
		echo form_input($attributes, $etapas[$es_etapa]);
		
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Competência', 'grupo', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
		//var_dump($etapas);
		$competencias=array('' => '')+$competencias;
		
		$attributes = array('name' => 'competencia',
					
					'class' => 'form-control text-box single-line',
					'disabled' => 'disabled');
		
		echo form_input($attributes, $competencias[$es_competencia]);
		
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Obrigatória?', 'obrigatorio', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
        $obrigatorios=array(''=>'','0'=>'Não','1'=>'Sim');

		$attributes = array('name' => 'obrigatorio',
					
					'class' => 'form-control text-box single-line',
					'disabled' => 'disabled');	
		echo form_input($attributes, $obrigatorios[$bl_obrigatorio]);			
               
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Eliminatória?', 'eliminatoria', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
        $eliminatorias=array(''=>'','0'=>'Não','1'=>'Sim');

		$attributes = array('name' => 'eliminatoria',
					
					'class' => 'form-control text-box single-line',
					'disabled' => 'disabled');	
        echo form_input($attributes, $eliminatorias[$bl_eliminatoria]);        
                
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Peso', 'peso', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
                
		$attributes = array('name' => 'peso',
							'id'=>'peso',
							'maxlength'=>'1',
							'class' => 'form-control',
							'min' => '0',
							'max' => '100',
							'disabled' => 'disabled',
							'type' => 'number');
		echo form_input($attributes, $in_peso);
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Tipo', 'tipo', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
		$tipos = array(
					0 => '',
					1 => 'Customizadas',
					2 => 'Aberta',
					3 => 'Sim/Não (sim positivo)',
					4 => 'Sim/Não (não positivo)',
					5 => 'Nenhum/Básico/Intermediário/Avançado',
					6 => 'Intervalo (limite definido pelo peso)',
					7 => 'Upload de arquivo'
					);
					
		$attributes = array('name' => 'tipo',
					
					'class' => 'form-control text-box single-line',
					'disabled' => 'disabled');	
        echo form_input($attributes, $tipos[$in_tipo]);  			
                
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
		$attributes = array('class' => 'col-lg-3 col-form-label text-right');
		echo form_label('Indicação da resposta aceita', 'respostaaceita', $attributes);
		echo "
                                                                            <div class=\"col-lg-6\">";
		if(!isset($vc_respostaAceita) || (strlen($vc_respostaAceita) == 0 && strlen(set_value('respostaaceita')) > 0)){
				$vc_respostaAceita = set_value('respostaaceita');
		}
		$attributes = array('name' => 'respostaaceita',
							'disabled' => 'disabled',
							'class' => 'form-control text-box single-line');
		echo form_input($attributes, $vc_respostaAceita);
		echo "
                                                                            </div>
                                                                    </div>
                                                                    <div id=\"div_respostas\">";
                //var_dump($opcoes);
                if(isset($opcoes)){
                        $c=1;
                        foreach ($opcoes as $linha){
                                echo "
                                                                            <fieldset>
                                                                                    <legend>Resposta $c</legend>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-9\">
                                                                                                    <label>Texto</label>
                                                                                                    <input type=\"text\" class=\"form-control\" name=\"texto_".$linha -> pr_opcao."\" value=\"".$linha -> tx_opcao."\"  disabled=\"disabled\"/>
                                                                                            </div>
                                                                                            <div class=\"col-lg-3\">
                                                                                                    <label>Valor</label>
                                                                                                    <input type=\"number\" class=\"form-control\" name=\"valor_".$linha -> pr_opcao."\" id=\"slider_input_".$linha -> pr_opcao."\" value=\"".$linha -> in_valor."\"  disabled=\"disabled\" />
                                                                                            </div>
                                                                                    </div>
                                                                            </fieldset>";
                                $c++;
                        }
                }
                
                echo "
                                                                            </div>
                                                                            <hr/>
                                                                            <div id=\"div_adicionar\" style=\"display:none\"><div class=\"j-footer\"><div class=\"row\"><div class=\"col-lg-12 text-center\"><button type=\"button\" id=\"adicionar_resposta\" class=\"btn btn-inverse\"><i class=\"fa fa-plus\"></i> Adicionar resposta</button><br/><br/></div></div></div></div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"row\">
                                                                                            <div class=\"col-lg-12 text-center\">
                                                                                                    <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Questoes/index/'.$grupo)."'\">Voltar</button>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                
        
}
/*
else if($menu2 == 'questoes'){
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-exclamation-triangle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br /> $erro
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
                                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_questoes');
                echo form_open($url, $attributes, array('codigo' => $codigo, 'num' => 0));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Vaga');
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                echo form_label('Nome', 'nome', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                $attributes = array('name' => 'nome',
                                    'class' => 'form-control',
                                    'disabled' => 'disabled');
                echo form_input($attributes, $vc_vaga);
                echo "
                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                //var_dump($questoes_atuais);
                $x=0;
                foreach ($questoes_atuais as $linha){
                        $x++;
                        echo form_fieldset('Questão atual '.$x);
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Descrição', 'nome_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'nome_'.$linha -> pr_questao,
                                            'class' => 'form-control',
                                            'rows' => '2');
                        echo form_textarea($attributes, strip_tags($linha -> tx_questao));
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Etapa', 'etapa_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-4\">";
                        $etapas=array(0 => '')+$etapas;
                        if(strstr($erro, "'Etapa'")){
                                echo form_dropdown('etapa_'.$linha -> pr_questao, $etapas, $linha -> es_etapa, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('etapa_'.$linha -> pr_questao, $etapas, $linha -> es_etapa, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Tipo de resposta', 'tipo_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-4\">";
                        $attributes = array(
                                    '' => '',
                                    1 => 'Customizadas',
                                    2 => 'Aberta',
                                    3 => 'Sim/Não (Sim positivo)',
                                    4 => 'Sim/Não (Não positivo)',
                                    5 => 'Nenhum/Básico/Intermediário/Avançado'
                                    );
                        if(strstr($erro, "'Tipo de resposta'")){
                                echo form_dropdown('tipo_'.$linha -> pr_questao, $attributes, $linha -> in_tipo, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('tipo_'.$linha -> pr_questao, $attributes, $linha -> in_tipo, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Resposta aceita', 'resposta_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'resposta_'.$linha -> pr_questao,
                                            'class' => 'form-control',
                                            'maxlength' => '500');
                        echo form_input($attributes, strip_tags($linha -> vc_respostaAceita));
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Eliminatória?', 'eliminatoria_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='1' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='0' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Não
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Obrigatória?', 'obrigatorio_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='1' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='0' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Não
                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                }

                echo "
                                                                                    <div id=\"div_questoes\"></div>
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">
                                                                                                            <button type=\"button\" id=\"adicionar_questao\" class=\"btn btn-default\"><i class=\"la la-plus\"></i> Adicionar questão</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_usuario', 'Salvar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                $pagina['js']="
        <script type=\"text/javascript\">
                $( '#adicionar_questao' ).click(function() {
                        var valor_num = $('input[name=num]').val();
                        valor_num++;
                        var newElement = '<fieldset><legend>Nova questão ' + valor_num + '</legend>";
                //$pagina['js'].=form_fieldset('Requisitos mínimos');
                $pagina['js'].="<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                $pagina['js'].= form_label('Questão pré-cadastrada', 'grupo', $attributes);
                $pagina['js'].= "<div class=\"col-lg-9\">";
                $pagina['js'].="<select name=\"outras_questoes_' + valor_num + '\" class=\"form-control\"><option value=\"\"> -- ESCOLHA AQUI OU DEFINA OS PARÂMETROS ABAIXO -- </option><optgroup label=\"Etapa 1\">";
                foreach ($outras_questoes1 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="<optgroup label=\"Etapa 2\">";
                foreach ($outras_questoes2 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="<optgroup label=\"Etapa 3\">";
                foreach ($outras_questoes3 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"nome2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Descrição</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><textarea name=\"nome2_' + valor_num + '\" cols=\"40\" rows=\"2\" class=\"form-control\" ></textarea></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"etapa2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Etapa</label>";
                $pagina['js'].= "<div class=\"col-lg-4\"><select name=\"etapa2_' + valor_num + '\" class=\"form-control\" >";
                //var_dump($etapas);
                for($x=0;$x<count($etapas);$x++){
                        $pagina['js'].= "<option value=\"{$x}\">".$etapas[$x]."</option>";
                }
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"tipo2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Tipo de resposta</label>";
                $pagina['js'].= "<div class=\"col-lg-4\"><select name=\"tipo2_' + valor_num + '\" class=\"form-control\" >";
                $pagina['js'].= "<option value=\"\"></option>";
                $pagina['js'].= "<option value=\"2\">Aberta</option>";
                $pagina['js'].= "<option value=\"3\">Sim/Não (Sim positivo)</option>";
                $pagina['js'].= "<option value=\"4\">Sim/Não (Não positivo)</option>";
                $pagina['js'].= "<option value=\"5\">Nenhum/Básico/Intermediário/Avançado</option>";
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"resposta2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Resposta aceita</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"text\" name=\"resposta2_' + valor_num + '\" class=\"form-control\" /></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"eliminatoria2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Eliminatória?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"0\" /> Não</div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"obrigatorio2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Obrigatória?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"0\" /> Não</div></div>";

                echo form_fieldset_close();
                $pagina['js'].= "<div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                $pagina['js'].="';
                        $( '#div_questoes' ).append( $(newElement) );
                        $('input[name=num]').val(valor_num);
                });
        </script>";
        }
}*/
else{
        echo "
                                                                    <div class=\"kt-portlet__body\">";
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger\" role=\"alert\">
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
}
echo "
                                                            </div>
                                                    </div>";

$this->load->view('templates/internaRodape', $pagina);

?>