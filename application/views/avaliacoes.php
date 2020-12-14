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

if ($menu2 != 'AvaliacaoCurriculo'){
    //Modelo padrão de página
    echo "              <div class=\"pcoded-content\">
                            <div class=\"pcoded-inner-content\">
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
    
} else {
    //Modelo de página de avaliação de currículo
    echo "              <div class=\"pcoded-content\">
                            <div class=\"pcoded-inner-content p-0\">    
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper p-0\">
                                        <div class=\"page-body\"> 
                                            <div class=\"row\" style=\"position:relative; left:15px;\">               
                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:280px; min-width:240px;\">
                                                    <div class=\"menu1\">
                                                        <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'lkavaliacao')\"><span class=\"pcoded-mclass\">Avaliação</span><span class=\"pcoded-micon\"><i class=\"fas fa-tasks\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                        <hr> 
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkcompleta')\"><span class=\"pcoded-mclass\">Candidatura completa</span><span class=\"pcoded-micon\"><i class=\"fas fa-id-badge\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkdados')\"><span class=\"pcoded-mclass\">Dados da candidatura</span><span class=\"pcoded-micon\"><i class=\"fas fa-address-book\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkprereq')\"><span class=\"pcoded-mclass\">Pré Requisitos da Vaga</span><span class=\"pcoded-micon\"><i class=\"fas fa-address-book\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkformacoes')\"><span class=\"pcoded-mclass\">Formações Acadêmicas</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-graduate\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkcursos')\"><span class=\"pcoded-mclass\">Cursos e Seminários</span><span class=\"pcoded-micon\"><i class=\"fas fa-university\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkexperiencias')\"><span class=\"pcoded-mclass\">Experiências Profissionais</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-tie\" style=\"margin-left: 12px; font-size:1.2em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkdesejaveis')\"><span class=\"pcoded-mclass\">Requisitos Desejáveis</span><span class=\"pcoded-micon\"><i class=\"fas fa-portrait\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                    </div>
                                                </div>
                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">";                                                                                                                                
echo "                                              <div class=\"w-100 h-100 p-3 pb-5\">";
                                                        $attributes = array('class' => 'login-form',
                                                                            'id' => 'form_avaliacoes');
                                                        echo form_open($url, $attributes);
    
// Início Formulário de Avaliação
echo "                                                      <div class=\"menu1conteudo menu1Primeiro\" id=\"lkavaliacao\">";
    
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-tasks\" style=\"font-size:0.9em;\"></i> &nbsp; Avaliação do(a) candidato(a)</h3>";
        
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger\">
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br/>$erro<br />
                                                                                    </div>
                                                                            </div>";
                //$erro='';
        }
        
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', true);

        
        /*if(isset($questoes3)){
                $x=0;
                foreach ($questoes3 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                        echo '<br/>';
                        $res = "";
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                        $codigo_resposta = $row2->pr_resposta;
                                }
                        }
                        if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                
                                $valores=array(""=>"",0=>"Não",1=>"Sim");


                                

                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control is-invalid\" id=\"{Questao'.$row -> pr_questao}\""
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control\" id=\"{Questao'.$row -> pr_questao}\""
                                }
                                
                        }
                        else if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                }

                                
                        }
                        
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'rows'=>'5');
                                echo form_textarea($attributes, $res, 'class="form-control"');
                        }
                        else if(isset($opcoes)){
                                $valores = array(""=>"");
                                foreach($opcoes as $opcao){
                                        if($opcao->es_questao==$row -> pr_questao){
                                                $valores[$opcao->pr_opcao]=$opcao->tx_opcao;
                                        }
                                }
                                
                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                }
                        }
                        echo form_hidden('codigo_resposta'.$row -> pr_questao, $codigo_resposta);
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        /*$CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);*/
        
        //echo form_fieldset_close();
        
        
        
        echo "
                                                                            <div class=\"kt-form__actions\">";
                
                        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
                        if(isset($questoes3)){
                                echo form_input(array('name' => 'codigo_candidatura', 'type'=>'hidden', 'id' =>'codigo_candidatura','value'=>$codigo_candidatura));
                                $attributes = array('class' => 'btn btn-primary');
								
										echo form_submit('salvar', 'Concluir avaliação', $attributes);
								
								$attributes['formnovalidate'] = 'formnovalidate';
								echo form_submit('salvar', 'Salvar dados', $attributes);
								//unset($attributes['formnovalidate']);
								$attributes['id'] = "Reprovar";
								echo form_submit('salvar', 'Reprovar na habilitação', $attributes);
								
								
                                
                        }
                        else{
                                echo "
                                                                                    <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('GruposVagas/index')."';\">Definir questões para essa etapa</button>
                            ";
                        }
						if($id_vaga>0){
																echo "                                                                                
                                                                                    <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$id_vaga)."';\">< Interromper avaliação</button>";
						}
						else{
								echo "                                                                                
                                                                                    <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."';\">< Interromper avaliação</button>";
						}
						echo "
                                                                            </div>";



    
    
echo "                                                      </div>";


// Início Candidatura Completa
echo "  
                                                            <div class=\"menu1conteudo\" id=\"lkcompleta\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-id-badge\" style=\"font-size:0.9em;\"></i> &nbsp; Candidatura Completa</h3>";
    echo "
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidato -> vc_nome;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('E-mail:', 'Email', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidato -> vc_email;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Telefone(s):', 'Telefones', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo $candidato -> vc_telefone;
        if(strlen($candidato -> vc_telefoneOpcional) > 0){
                echo ' - '.$candidato -> vc_telefoneOpcional;
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Vaga:', 'Vaga', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidatura[0] -> vc_vaga;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Status da candidatura:', 'status', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo $candidatura[0] -> vc_status;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Data da candidatura:', 'data', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo show_date($candidatura[0] -> dt_candidatura, true);
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Nota:', 'nota', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        //echo $candidato -> vc_email;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
        /*echo "
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Curriculo:', 'curriculo', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo1[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Diploma da graduação:', 'graduacao', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo2[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo3[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";*/
        echo form_fieldset_close();
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Pré-requisitos básicos');
        
        /*if(isset($questoes1)){
                $x=0;
                
                foreach ($questoes1 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }
                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
		
        $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false,'', $anexos_questao);
        echo form_fieldset_close();
        
        //**************************************
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Currículo');
        
        if(isset($formacoes)){
                $i=0;
                
                
                        foreach($formacoes as $formacao){
                                ++$i;
                                echo "
                                                                                            
                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo " 
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                else if($formacao->en_tipo == 'seminario'){
                                        $res = 'Curso/Seminário';
                                }
                                
                                
                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Nome do curso', "curso{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                $res = $formacao->vc_instituicao;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->dt_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    
                                                    'type' => 'date',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_input($attributes, $res);
                                
                                echo "
                                                                                                    </div>
                                                                                                
                                                                                            </div>
                                                                                            ";

                                if($formacao->en_tipo == 'seminario'){
                                        echo "
																							<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																																					";
        								$attributes = array('class' => 'esquerdo control-label');
        								echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
        								echo " 
																											<br />";
								/*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
										$ye_conclusao[$i] = set_value("conclusao{$i}");
								}*/
        								$res = $formacao->in_cargahoraria;
        								$attributes = array('name' => "cargahoraria{$i}",
													'id' => "cargahoraria{$i}",
													'maxlength' => '10',
													'type' => 'number',
													'class' => 'form-control',
													'disabled' => 'disabled');

								        echo form_input($attributes, $res);

								        echo "
																									</div>
																							</div>";
                                }
                                echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
												echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                        }
                                }
                                
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                        }
                        
        }
        //***********************************
        if(isset($experiencias)){
                $i = 0;
                foreach($experiencias as $experiencia){
                        ++$i;
                        echo "
                                                                                        
                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";                                                            
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "empresa{$i}",
                                            'id' => "empresa{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->vc_empresa);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        
																						<div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Data de início', "inicio{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "inicio{$i}",
                                            'id' => "inicio{$i}",
                                            
                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->dt_inicio);
                        echo "
                                                                                                </div>
                                                                                        </div>
																						";
                        if($experiencia->bl_emprego_atual=='1'){
                                echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Emprego atual', "emprego_atual{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                
                                $attributes = array('name' => "emprego_atual{$i}",
                                            'id' => "emprego_atual{$i}",
                                            
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                                echo form_input($attributes, "Sim");
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        ";
                        }
                        else{
                                echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Data de término1', "fim{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                
                                $attributes = array('name' => "fim{$i}",
                                            'id' => "fim{$i}",
                                            
                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                                echo form_input($attributes, $experiencia->dt_fim);
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        ";  
                        }
                        

                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                            
                        $attributes = array('name' => "atividades{$i}",
                                            'id' => "atividades{$i}",
                                            'rows' => '4',
                                            'class' => 'form-control',
                                        'disabled' => 'disabled');
                        echo form_textarea($attributes, $experiencia->tx_atividades);
                        echo "
                                                                                                </div>
                                                                                        </div>
																						<div class=\"form-group row\">
																								<div class=\"col-lg-12\">
																																			";
						$attributes = array('class' => 'esquerdo control-label');
						echo form_label('Comprovante', "comprovante{$i}", $attributes);
						echo " 
																										<br />";
						/*$attributes = array('name' => "diploma{$i}",
											'class' => 'form-control',
											'disabled' => 'disabled');

						echo form_upload($attributes, '', 'class="form-control"');*/
						$vc_anexo='';
						$pr_arquivo='';
						if($anexos_experiencia[$experiencia->pr_experienca]){
								foreach($anexos_experiencia[$experiencia->pr_experienca] as $anexo){
										$vc_anexo = $anexo->vc_arquivo;
										$pr_arquivo = $anexo->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
						}
						
						echo "
																								</div>
																						</div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                                
                }
        }
        
        //***********************************
        echo "
                                                                                <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Requisitos desejáveis');
        
        /*if(isset($questoes2)){
                $x=0;
                foreach ($questoes2 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }

                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false,'', $anexos_questao);
        echo form_fieldset_close();



echo "                                                      </div>";
// Fim Candidatura Completa

        
// Início conteúdo Dados do Candidato        
echo "                                                      <div class=\"menu1conteudo\" id=\"lkdados\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-address-book\" style=\"font-size:0.9em;\"></i> &nbsp; Dados do candidato</h3>";
echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_nome;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('E-mail:', 'Email', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_email;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Telefone(s):', 'Telefones', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo $candidato -> vc_telefone;
                                                                                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                                                                        echo ' - '.$candidato -> vc_telefoneOpcional;
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				if($this -> session -> perfil == 'candidato'){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Logradouro:', 'logradouro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_logradouro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																						
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Complemento:', 'complemento', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_complemento;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																						
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Número:', 'numero', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_numero;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																						
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Bairro:', 'bairro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_bairro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}																				
																				echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Vaga:', 'Vaga', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidatura[0] -> vc_vaga;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Status da candidatura:', 'status', $attributes);
																				echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																				if(($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6') && $this -> session -> perfil == 'candidato'){
																						echo "Candidatura Pendente";
																				}
																				else{
																						echo $candidatura[0] -> vc_status;
                                                                                
																				}
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data da candidatura:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_candidatura, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Nota Avaliação Curricular:', 'nota', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																				if(isset($notas['3'])){																				
																						echo $notas['3'];
																				}
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							<div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Nota Entrevista por competência:', 'nota', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																				if(isset($notas['4'])){																				
																						echo $notas['4'];
																				}
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																				if(isset($notas['5'])){																			
																						echo "
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota teste de aderência:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																																								
																						echo $notas['5'];
																				
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																				}
																				if(isset($notas['6'])){																			
																						echo "
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota entrevista com especialista:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																																								
																						echo $notas['6'];
																				
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																				}
																				echo "
																																							<div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Nota Geral:', 'nota', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																				echo (isset($notas['3'])?intval($notas['3'].""):0)+(isset($notas['4'])?intval($notas['4'].""):0)+(isset($notas['5'])?intval($notas['5'].""):0)+(isset($notas['6'])?intval($notas['6'].""):0);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																				";
                                                                                /*echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Curriculo:', 'curriculo', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo1[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma da graduação:', 'graduacao', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo2[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo3[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";*/    
    
    
echo "                                                      </div>";
// Fim conteúdo Perfil

// Início Pré Requisitos
echo "                                                      <div class=\"menu1conteudo\" id=\"lkprereq\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-address-book\" style=\"font-size:0.9em;\"></i> &nbsp; Pré-Requisitos</h3>";
    
                                                            $CI =& get_instance();
                                                            $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false,'', $anexos_questao);
    
echo "                                                      </div>";
// Fim Pré Requisitos

// Início Formações Acadêmicas   
echo "                                                      <div class=\"menu1conteudo\" id=\"lkformacoes\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-graduate\" style=\"font-size:0.9em;\"></i> &nbsp; Formações Acadêmicas</h3>";
    
        if(isset($formacoes)){
                $i=0;
                
                
                        foreach($formacoes as $formacao){
                                ++$i;
								if($formacao->en_tipo == 'seminario'){
										continue;
								}
                                echo "
                                                                                            
                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo " 
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                else if($formacao->en_tipo == 'seminario'){
                                        $res = 'Curso/Seminário';
                                }
                                
                                
                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Nome do curso', "curso{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                $res = $formacao->vc_instituicao;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->dt_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    
                                                    'type' => 'date',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_input($attributes, $res);
                                
                                echo "
                                                                                                    </div>
                                                                                                
                                                                                            </div>
                                                                                            ";
                                if($formacao->en_tipo == 'seminario'){
                                        echo "
																							<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																																					";
        								$attributes = array('class' => 'esquerdo control-label');
        								echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
        								echo " 
																											<br />";
        								/*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
        										$ye_conclusao[$i] = set_value("conclusao{$i}");
        								}*/
        								$res = $formacao->in_cargahoraria;
        								$attributes = array('name' => "cargahoraria{$i}",
													'id' => "cargahoraria{$i}",
													'maxlength' => '10',
													'type' => 'number',
													'class' => 'form-control',
													'disabled' => 'disabled');

								        echo form_input($attributes, $res);

								        echo "
																									</div>
																							</div>";
                                }
                                echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
												echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                        }
                                }
                                
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                        }
                        
        }     
    
echo "                                                      </div>";
// Fim Formações Acadêmicas  

// Início Cursos e Seminários  
echo "                                                      <div class=\"menu1conteudo\" id=\"lkcursos\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-university\" style=\"font-size:0.9em;\"></i> &nbsp; Cursos e Seminários</h3>";   
		if(isset($formacoes)){
                $i=0;
                
                
                        foreach($formacoes as $formacao){
                                ++$i;
								if($formacao->en_tipo != 'seminario'){
										continue;
								}
                                echo "
                                                                                            
                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo " 
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                else if($formacao->en_tipo == 'seminario'){
                                        $res = 'Curso/Seminário';
                                }
                                
                                
                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Nome do curso', "curso{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                $res = $formacao->vc_instituicao;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->dt_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    
                                                    'type' => 'date',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_input($attributes, $res);
                                
                                echo "
                                                                                                    </div>
                                                                                                
                                                                                            </div>
                                                                                            ";
                                if($formacao->en_tipo == 'seminario'){
                                        echo "
																							<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																																					";
        								$attributes = array('class' => 'esquerdo control-label');
        								echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
        								echo " 
																											<br />";
        								/*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
        										$ye_conclusao[$i] = set_value("conclusao{$i}");
        								}*/
        								$res = $formacao->in_cargahoraria;
        								$attributes = array('name' => "cargahoraria{$i}",
													'id' => "cargahoraria{$i}",
													'maxlength' => '10',
													'type' => 'number',
													'class' => 'form-control',
													'disabled' => 'disabled');

        								echo form_input($attributes, $res);

        								echo "
																									</div>
																							</div>";
                                }
                                echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
												echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                        }
                                }
                                
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                        }
                        
        } 
    
    
    
echo "                                                      </div>";
// Fim Cursos e Seminários  

// Início Experiências Profissionais  
echo "                                                      <div class=\"menu1conteudo\" id=\"lkexperiencias\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-tie\" style=\"font-size:0.9em;\"></i> &nbsp; Experiências Profissionais</h3>";
    
                                                            
        if(isset($experiencias)){
                $i = 0;
                foreach($experiencias as $experiencia){
                        ++$i;
                        echo "
                                                                                        
                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";                                                            
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "empresa{$i}",
                                            'id' => "empresa{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->vc_empresa);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        
																						<div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Data de início', "inicio{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "inicio{$i}",
                                            'id' => "inicio{$i}",
                                            
                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->dt_inicio);
                        echo "
                                                                                                </div>
                                                                                        </div>
																						
                                                                                        ";
                        if($experiencia->bl_emprego_atual=='1'){
                                echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Emprego atual', "emprego_atual{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                
                                $attributes = array('name' => "emprego_atual{$i}",
                                            'id' => "emprego_atual{$i}",
                                            
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                                echo form_input($attributes, "Sim");
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        ";
                        }
                        else{
                                echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Data de término', "fim{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                
                                $attributes = array('name' => "fim{$i}",
                                            'id' => "fim{$i}",
                                            
                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                                echo form_input($attributes, $experiencia->dt_fim);
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        ";  
                        }
                        

                        echo "
																						
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                            
                        $attributes = array('name' => "atividades{$i}",
                                            'id' => "atividades{$i}",
                                            'rows' => '4',
                                            'class' => 'form-control',
                                        'disabled' => 'disabled');
                        echo form_textarea($attributes, $experiencia->tx_atividades);
                        echo "
                                                                                                </div>
                                                                                        </div>
																						<div class=\"form-group row\">
																								<div class=\"col-lg-12\">
																																			";
						$attributes = array('class' => 'esquerdo control-label');
						echo form_label('Comprovante', "comprovante{$i}", $attributes);
						echo " 
																										<br />";
						/*$attributes = array('name' => "diploma{$i}",
											'class' => 'form-control',
											'disabled' => 'disabled');

						echo form_upload($attributes, '', 'class="form-control"');*/
						$vc_anexo='';
						$pr_arquivo='';
						if($anexos_experiencia[$experiencia->pr_experienca]){
								foreach($anexos_experiencia[$experiencia->pr_experienca] as $anexo){
										$vc_anexo = $anexo->vc_arquivo;
										$pr_arquivo = $anexo->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
						}
						
						echo "
																								</div>
																						</div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                                
                }
        }    
    
    
echo "                                                      </div>";
// Fim Experiências Profissionais                                                             
                                                        
// Início Requisitos Desejáveis
echo "                                                      <div class=\"menu1conteudo\" id=\"lkdesejaveis\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-portrait\" style=\"font-size:0.9em;\"></i> &nbsp; Requisitos Desejáveis</h3>";
    
                                                            $CI =& get_instance();
                                                            $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false,'', $anexos_questao);    
    
    
echo "                                                      </div>";
// Fim Requisitos Desejáveis

// Fim da tela de avaliação
echo "                                              </form>";
echo "                                        </div>";
echo "                                    </div>
                                     </div>
                                </div>";

$pagina['js'] = "
                                                                    <script type=\"text/javascript\">
                                                                            jQuery(':submit').click(function (event) {
                                                                                                                                        if (this.id == 'Reprovar') {
                                                                                                                                                event.preventDefault();
                                                                                                                                                $(document).ready(function(){
                                                                                                                                                        event.preventDefault();
                                                                                                                                                        swal.fire({
                                                                                                                                                                title: 'Aviso de reprovação na habilitação',
                                                                                                                                                                text: 'Prezado avaliador(a), deseja reprovar na habilitação?',
                                                                                                                                                                type: 'warning',
                                                                                                                                                                showCancelButton: true,
                                                                                                                                                                cancelButtonText: 'Não',
                                                                                                                                                                confirmButtonText: 'Sim, desejo reprovar'
                                                                                                                                                        })
                                                                                                                                                        .then(function(result) {
                                                                                                                                                                if (result.value) {
                                                                                                                                                                        //desfaz as configurações do botão
                                                                                                                                                                        $('#Reprovar').unbind(\"click\");
                                                                                                                                                                        //clica, concluindo o processo
                                                                                                                                                                        $('#Reprovar').click();
                                                                                                                                                                }

                                                                                                                                                        });


                                                                                                                                        });
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                });



                                                                        function abreConteudo(evt, link) {
                                                                          var i, tabcontent, tablinks;


                                                                          tabcontent = document.getElementsByClassName(\"menu1conteudo\");
                                                                          for (i = 0; i < tabcontent.length; i++) {
                                                                            tabcontent[i].style.display = \"none\";
                                                                          }


                                                                          tablinks = document.getElementsByClassName(\"tablinks\");
                                                                          for (i = 0; i < tablinks.length; i++) {
                                                                            tablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
                                                                          }


                                                                          document.getElementById(link).style.display = \"block\";
                                                                          evt.currentTarget.className += \" active\";
                                                                        }
                                                                    </script>    
                                                                    ";

} 
// Fim da condição da tela de avaliação
                                                                        
$dados_status[0] = '';
foreach($status as $linha){
        $dados_status[$linha -> pr_status] = $linha -> vc_status;
}

if(strlen(set_value('filtro_instituicao')) > 0){
        echo '<span class="small"> - Instituição: '.$instituicoes[set_value('filtro_instituicao')].'</span>';
}
if(strlen(set_value('filtro_vaga')) > 0){
        echo '<span class="small"> - Vaga: '.$vagas[set_value('filtro_vaga')].'</span>';
}
if(strlen(set_value('filtro_status')) > 0){
        echo '<span class="small"> - Status: '.$dados_status[set_value('filtro_status')].'</span>';
}
echo "</h4>
                                                                    </div>";

if($menu2 == 'index'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                        <a href=\"".base_url('Usuarios/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Novo usuário </a>
                                                                    </div>";
}
else if($menu2 == 'create' || $menu2 == 'edit'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_usuarios').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
                                                                    </div>";
}
echo "
                                                            </div>";
                                                            
/*
if($this -> session -> perfil != 'candidato' && $this -> session -> perfil != 'avaliador' && $menu2 == 'AgendamentoEntrevista' && strlen($sucesso) == 0){
        echo "
                                                            <div class=\"kt-subheader__toolbar\">
                                                                    <a href=\"".base_url('Candidaturas/ListaAvaliacao')."\" class=\"btn btn-default btn-bold\"> Cancelar </a>
                                                                    <button type=\"button\" class=\"btn btn-primary btn-bold\" onclick=\"document.getElementById('form_avaliacoes').submit();\"> Salvar </button>
                                                            </div>";
}
else if($menu2 == 'AvaliacaoEntrevista'){ 
        echo "
                                                            <div class=\"kt-subheader__toolbar\">
                                                                    <a href=\"".base_url('Candidaturas/index')."\" class=\"btn btn-default btn-bold\"> Cancelar </a>
                                                                    <button type=\"button\" class=\"btn btn-primary btn-bold\" onclick=\"document.getElementById('form_avaliacoes').submit();\"> Salvar </button>
                                                                    <button type=\"button\" class=\"btn btn-primary btn-bold\" onclick=\"document.getElementById('form_avaliacoes').submit();\"> Concluir </button>
                                                            </div>";
}
echo "
                                                    </div>
                                                    <div class=\"kt-content kt-grid__item kt-grid__item--fluid\" id=\"kt_content\">
                                                            <div class=\"kt-portlet kt-portlet--mobile\">
                                                                    <div class=\"kt-portlet__head kt-portlet__head--lg\">
                                                                            <div class=\"kt-portlet__head-label\">
                                                                                    <h3 class=\"kt-portlet__head-title\">
                                                                                            <i class=\"$icone\"></i> &nbsp;&nbsp; {$nome_pagina}";*/

//******
if($menu2 == 'ListaAvaliacao'){
        echo "
                                                            <div id=\"accordion\">
                                                                <h3 style=\"font-size:large\">Filtros - Administradores</h3>
                                                                <div>
                                                                    ";
        $attributes = array('id' => 'form_filtros');
        echo form_open($url, $attributes);
        echo "
                                                                        <div class=\"form-group row\">
                                                                            <label for=\"filtro_nome\" class=\"col-lg-2 col-form-label text-right\">Nome</label>
                                                                            <div class=\"col-xl-3 col-lg-4\">";
        $attributes = array('class' => 'form-control',
                            'name' => 'filtro_nome',
                            'id' => 'filtro_nome',
                            'maxlength' => '50');
        echo form_input($attributes, set_value('filtro_nome'));
        echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <label for=\"filtro_vaga\" class=\"col-lg-2 col-form-label text-right\">Vaga</label>
                                                                            <div class=\"col-xl-3 col-lg-4\">";
        $vagas=array('' => 'Todos')+$vagas;

        echo form_dropdown('filtro_vaga', $vagas, $filtro_vaga, "class=\"form-control\" id=\"filtro_vaga\"");
        echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <label for=\"nome\" class=\"col-lg-2 col-form-label text-right\">Status</label>
                                                                            <div class=\"col-xl-3 col-lg-4\">";
        //$status=array('' => 'Todos')+$status;
        $status_array = array(0=>'Todos');
        foreach($status as $linha){
            $status_array[$linha->pr_status] = $linha -> vc_status;
        }
        echo form_dropdown('filtro_status', $status_array, $filtro_status, "class=\"form-control\" id=\"filtro_vaga\"");
        echo "
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                <div class=\"col-lg-12 text-center\">";
        /*$attributes = array('class' => 'btn btn-primary');
        echo form_submit('servidores', 'Filtrar', $attributes);*/
        echo "
                                                                                    <button type=\"button\" class=\"btn btn-primary\" onclick=\"botao_submit();\">Filtrar</button>
                                                                                    <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Limpar</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <hr>";
        $pagina['js']="
                <script type=\"text/javascript\">
                      $( function() {
                        $( '#accordion' ).accordion({ header: 'h3', collapsible: true, active: false });
                        
                      } );
                </script>";
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"candidaturas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Candidato</th>
                                                                                            <th>Data</th>
                                                                                            <th>Vaga</th>
                                                                                            <th>Tipo de Entrevista</th>
                                                                                            <th>Status</th>
                                                                                            <th>Teste de aderência</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($candidatos);
        
        if(isset($candidaturas)){
                $candidatura_anterior = -1;
                $atual = time();
                foreach ($candidaturas as $linha){
                        /*if(($linha -> es_status != 10 && $linha->es_status != 11) && $candidatura_anterior == $linha -> pr_candidatura){
                                continue;
                        }*/
                        $candidatura_anterior = $linha -> pr_candidatura;
                        $dt_candidatura = strtotime($linha -> dt_candidatura);
                        $dt_fim = strtotime($linha -> dt_fim);
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_candidatura)."\" data-order=\"$dt_candidatura\">".show_date($linha -> dt_candidatura)."</td>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td>";
                        if(strlen($linha -> bl_tipo_entrevista)>0){
                                if($linha->bl_tipo_entrevista == 'competencia'){
                                        echo "Competência";
                                }
                                else{
                                        echo "Especialista";
                                }
                        }
                        echo "</td>    
                                ";
                        
                        if($linha -> es_status == 2 || $linha -> es_status == 4 || $linha -> es_status == 8 || $linha -> es_status == 10 || $linha -> es_status == 12 || $linha -> es_status == 13 || $linha -> es_status == 20){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else{
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        echo "
                                                                                            <td class=\"text-center\">".($linha -> en_aderencia == '2'?"Realizado":($linha -> en_aderencia == '1'?"Solicitado":"Não solicitado"))."</td>
                                                                                            <td class=\"text-center\">";
                        //if($linha -> es_status != 1){
                                echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-search">Detalhes</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                                //echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-text"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\"");
                        //}
                        if(($linha -> es_status == 7 || $linha -> es_status == 20) && $dt_fim < $atual){ //aprovado 2ª etapa
                                
                                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
                                        echo "<br />";
                                        echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-text">Currículo</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");
                                       
                                }
                                
                        }
                        if($linha -> es_status == 10){ //entrevista por competência
                                if($linha -> bl_tipo_entrevista == 'competencia' && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && ( strlen($linha -> es_avaliador_competencia1) == 0 ))){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                                else if($linha -> bl_tipo_entrevista == 'especialista' && ((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && $linha -> es_avaliador2 == '')) { //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                                
                                
                                
                                
                        }
                        if($linha -> es_status == 11){ //entrevista por especialista
                                
                                if($linha -> bl_tipo_entrevista == 'especialista' && ((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($linha -> es_avaliador2) == 0 )){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                                
                                
                        }
                        else if($linha -> es_status == 12){
                                if($linha -> bl_tipo_entrevista == 'competencia' && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0))){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                        }
                        
                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }

        echo "
                                                                            </tbody>
                                                                    </table>";
        if($paginacao > 0){
                echo "
                                                                    <div class=\"row\">
                                                                            <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                    <div class=\"dataTables_info\" id=\"vagas_table_info\" role=\"status\" aria-live=\"polite\">Mostrando de ".((($paginacao-1)*30)+1)." até ";
                if(($paginacao*30) > $total){
                        echo $total;
                }
                else{
                        echo ($paginacao*30);
                }
                echo " de {$total} itens</div>
                                                                            </div>
                                                                            <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                    <div class=\"dataTables_paginate paging_simple_numbers\" id=\"vagas_table_paginate\">
                                                                                            <ul class=\"pagination\">";                                                                                             
                $extra='';
                
                if($paginacao > 1){
                        echo "
                                                                                                    <li class=\"paginate_button page-item previous\" id=\"vagas_table_previous\">
                                                                                                            <a onclick=\"ahref_lista(".($paginacao-1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                                    </li>";
                }
                else{
                        echo "
                                                                                                    <li class=\"paginate_button page-item previous disabled\" id=\"vagas_table_previous\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                                    </li>";
                }
                echo "
                                                                                                    <li class=\"paginate_button page-item ";
                if($paginacao == 1){
                        echo 'active';
                }
                echo "\">
                                                                                                            <a onclick=\"ahref_lista(1);\" aria-controls=\"vagas_table\" data-dt-idx=\"1\" tabindex=\"0\" class=\"page-link\">1</a>
                                                                                                    </li>";
                if($paginacao > 3){
                        echo "
                                                                                                    <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                                    </li>";     
                }
                if($paginacao <= 2){
                        $inicio = 2;
                        $termino = 5;
                }
                else{
                        $inicio = $paginacao-1;
                        $termino = $paginacao+4;
                }
                for($i = $inicio; $i <= $total_paginas && $i <= $termino; $i++){
                        echo "
                                                                                                    <li class=\"paginate_button page-item ";
                        if($paginacao == $i){
                                echo 'active';
                        }
                        echo "\">
                                                                                                            <a onclick=\"ahref_lista(".$i.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$i\" tabindex=\"0\" class=\"page-link\">$i</a>
                                                                                                    </li>";
                }
                if($paginacao < ($total_paginas - 5)){
                        echo "
                                                                                                    <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                                    </li>";     
                }
                if($paginacao < ($total_paginas - 4)){
                        echo "
                                                                                                    <li class=\"paginate_button page-item \">
                                                                                                            <a onclick=\"ahref_lista(".$total_paginas.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$total_paginas\" tabindex=\"0\" class=\"page-link\">$total_paginas</a>
                                                                                                    </li>";
                }
                if($paginacao < $total_paginas){
                        echo "
                                                                                                    <li class=\"paginate_button page-item next\" id=\"vagas_table_next\">
                                                                                                            <a onclick=\"ahref_lista(".($paginacao+1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                                    </li>";
                }
                else{
                        echo "
                                                                                                    <li class=\"paginate_button page-item next disabled\" id=\"vagas_table_next\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                                    </li>";
                }
                echo "
                                                                                            </ul>
                                                                                    </div>
                                                                            </div>
                                                                    </div>";
        }
        echo "
                                                            </div>
                                                    </div>";

        $pagina['js'] .= "
                                            <script type=\"text/javascript\">
                                                    function ahref_lista(pagina){
                                                            document.getElementById('form_filtros').action='".base_url('Candidaturas/ListaAvaliacao/')."'+pagina;
                                                            document.getElementById('form_filtros').submit();
                                                    }
                                                    function botao_submit(){
                                                            ahref_lista(1);
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o não comparecimento à entrevista?',
                                                                        text: 'O candidato será eliminado por não comparecimento à entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não',
                                                                        confirmButtonText: 'Sim, elimine'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Candidaturas/eliminar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }        
                                            </script>";

        
}

//******
/*if($menu2 == 'ListaAvaliacao'){ //lista de candidaturas
        echo "
                                                            <div class=\"dt-responsive table-responsive\">";

       
        $attributes = array('class' => 'form-horizontal',
                                    'id' => 'form_filtros');
        echo form_open($url, $attributes);
        echo "
                                                                            <div class=\"modal-body\">
                                                                
                                                                                    <h5>Vaga</h5>
                                                                                    <br />
                                                                ";
        $vagas=array('' => 'Todos')+$vagas;

        echo form_dropdown('filtro_vaga', $vagas, $filtro_vaga, "class=\"form-control\" id=\"filtro_vaga\"");        
        echo "
                                                                            </div>
                                                                            <div class=\"actions clearfix text-left my-5\">
                                                        <button type=\"button\" data-dismiss=\"modal\" class=\"btn default\">Cancelar</button>";
        $attributes = array('class' => 'btn btn-primary');
        echo form_submit('filtrar', 'Filtrar', $attributes);
        echo "
                                                                            </div>
                                                                    </form>
                                ";
        echo "
                                                                    
                                                                    
                                                                    <table id=\"avaliacoes_table\" class=\"table table-striped table-bordered table-hover\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Candidato</th>
                                                                                            <th>Data</th>
                                                                                            <th>Vaga</th>
                                                                                            <th>Tipo de Entrevista</th>
                                                                                            <th>Status</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        
        
       
        if(isset($candidaturas)){
                $candidatura_anterior = -1;
				$atual = time();
                foreach ($candidaturas as $linha){
                        if(($linha -> es_status != 10 && $linha->es_status != 11) && $candidatura_anterior == $linha -> pr_candidatura){
                                continue;
                        }
                        $candidatura_anterior = $linha -> pr_candidatura;
                        $dt_candidatura = strtotime($linha -> dt_candidatura);
                        $dt_fim = strtotime($linha -> dt_fim);
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_candidatura)."\" data-order=\"$dt_candidatura\">".show_date($linha -> dt_candidatura)."</td>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td>";
                        if(strlen($linha -> bl_tipo_entrevista)>0){
                                if($linha->bl_tipo_entrevista == 'competencia'){
                                        echo "Competência";
                                }
                                else{
                                        echo "Especialista";
                                }
                        }
                        echo "</td>    
                                ";
                        
                        if($linha -> es_status == 2 || $linha -> es_status == 4 || $linha -> es_status == 8 || $linha -> es_status == 10 || $linha -> es_status == 12 || $linha -> es_status == 13 || $linha -> es_status == 20){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else{
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        echo "
                                                                                            <td class=\"text-center\">";
                        //if($linha -> es_status != 1){
                                echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-search">Detalhes</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                                //echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-text"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\"");
                        //}
                        if(($linha -> es_status == 7 || $linha -> es_status == 20) && $dt_fim < $atual){ //aprovado 2ª etapa
                                
                                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
                                        echo "<br />";
                                        echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-text">Currículo</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");
                                       
                                }
                                
                        }
                        if($linha -> es_status == 10){ //entrevista por competência
                                if($linha -> bl_tipo_entrevista == 'competencia' && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && ( strlen($linha -> es_avaliador_competencia1) == 0 ))){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                                else if($linha -> bl_tipo_entrevista == 'especialista' && ((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && $linha -> es_avaliador2 == '')) { //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                                
								
                                
                                
                        }
                        if($linha -> es_status == 11){ //entrevista por especialista
                                
                                if($linha -> bl_tipo_entrevista == 'especialista' && ((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($linha -> es_avaliador2) == 0 )){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
                                
                                
                        }
                        else if($linha -> es_status == 12){
                                if($linha -> bl_tipo_entrevista == 'competencia' && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0))){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        //}
                                }
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
                                                    </div>
                                            </div>";
        
        $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o não comparecimento à entrevista?',
                                                                        text: 'O candidato será eliminado por não comparecimento à entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não',
                                                                        confirmButtonText: 'Sim, elimine'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Candidaturas/eliminar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    $('#avaliacoes_table').DataTable({
                                                        'pageLength': 15,
                                                        'lengthMenu': [
                                                            [ 15, 25, 50, -1 ],
                                                            [ '15', '25', '50', 'Todos' ]
                                                        ],
                                                        'order': [
                                                            [1, 'desc']
                                                        ],
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
}*/
if($menu2 == 'DetalheAvaliacao'){ //detalhamento da candidatura
        //var_dump($candidato);
        //var_dump($vaga);
        //var_dump($candidatura);
        //var_dump($anexo3);
        //var_dump($respostas);
		if($this -> session -> perfil == 'candidato'){
				echo "

                                                <!-- Início das tabs superior de navegação de conteúdo -->
                                                        <div class=\"row\">
                                                            <div class=\"col-md-12\">
                                                                <ul class=\"nav nav-tabs tabs\" role=\"tablist\">
                                                                    <li class=\"nav-item\">
                                                                        <a class=\"nav-link active\" data-toggle=\"tab\" href=\"#perfilTab\" aria-expanded=\"true\">Perfil</a>                                                                            
                                                                    </li>

                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>     
                                                <!-- Fim das tabs superior de navegação de conteúdo -->";
		}
		else{
				echo "

                                                <!-- Início das tabs superior de navegação de conteúdo -->
                                                        <div class=\"row\">
                                                            <div class=\"col-md-12\">
                                                                <ul class=\"nav nav-tabs tabs\" role=\"tablist\">
                                                                    <li class=\"nav-item\">
                                                                        <a class=\"nav-link active\" data-toggle=\"tab\" href=\"#perfilTab\" aria-expanded=\"true\">Perfil</a>                                                                            
                                                                    </li>

                                                                    <li class=\"nav-item\">
                                                                        <a class=\"nav-link\" data-toggle=\"tab\" href=\"#avaliacaoTab\" aria-expanded=\"true\">Avaliação do candidato</a>                                                                            
                                                                    </li>

                                                                    <li class=\"nav-item\">
                                                                        <a class=\"nav-link\" data-toggle=\"tab\" href=\"#aderenciaTab\" aria-expanded=\"true\">Teste de Aderência</a>                                                                            
                                                                    </li>

                                                                    <li class=\"nav-item\">
                                                                        <a class=\"nav-link\" data-toggle=\"tab\" href=\"#competenciaTab\" aria-expanded=\"true\">Entrevistas por competências</a>
                                                                    </li>

                                                                    <li class=\"nav-item\">
                                                                        <a class=\"nav-link\" data-toggle=\"tab\" href=\"#especialistaTab\" aria-expanded=\"true\">Entrevista com especialista</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>     
                                                <!-- Fim das tabs superior de navegação de conteúdo -->";
		}
                   
                   

                                                        
                                                                                $attributes = array('class' => 'login-form',
                                                                                                    'id' => 'form_avaliacoes');
                                                                                echo form_open($url, $attributes);
                                                                                
                                            echo "      <!-- Início do conteúdo relacionado às tabs -->        
                                                        <div class=\"tab-content tabs-right-content card-block\">";

                                                                                echo " <!-- Início da navegação por tabs -->";

                                                        echo "<div class=\"tab-pane active\" id=\"perfilTab\" role=\"tabpanel\" aria-expanded=\"false\">";                            

                                                                                echo form_fieldset('Dados da candidatura');
                                                                                echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_nome;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('E-mail:', 'Email', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_email;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Telefone(s):', 'Telefones', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo $candidato -> vc_telefone;
                                                                                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                                                                        echo ' - '.$candidato -> vc_telefoneOpcional;
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				if($this -> session -> perfil == 'candidato'){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Logradouro:', 'logradouro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_logradouro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																						
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Complemento:', 'complemento', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_complemento;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																						
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Número:', 'numero', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_numero;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																						
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Bairro:', 'bairro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_bairro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}																				
																				echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Vaga:', 'Vaga', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidatura[0] -> vc_vaga;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				if(!$this -> session -> perfil == 'candidato'){																			
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Status da candidatura:', 'status', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						/*if(($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6') && $this -> session -> perfil == 'candidato'){
																								echo "Candidatura Pendente";
																						}
																						else{*/
																								echo $candidatura[0] -> vc_status;
																						
																						//}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}																			
																				echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de início:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_cadastro, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de última alteração:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_candidatura, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																																							
																				if($this -> session -> perfil != 'candidato' && $this -> session -> perfil != 'avaliador'){
																						echo "
																																									<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Avaliação Curricular:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['3'])){																				
																								echo $notas['3'];
																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Entrevista por competência:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['4'])){																				
																								echo $notas['4'];
																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						if(isset($notas['5'])){																			
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota teste de aderência:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																																								
																								echo $notas['5'];
																						
																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						if(isset($notas['6'])){																			
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota entrevista com especialista:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																																								
																								echo $notas['6'];
																				
																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						echo "
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Geral:', 'nota', $attributes);
                                                                                        $total = (isset($notas['3'])?intval($notas['3'].""):0)+(isset($notas['4'])?intval($notas['4'].""):0)+(isset($notas['5'])?intval($notas['5'].""):0)+(isset($notas['6'])?intval($notas['6'].""):0);
                                                                                        $nota_final = 0;
                                                                                        if(!isset($notas['6']) || $notas['6'] == '0'){
                                                                                                if($candidatura[0] -> en_aderencia){
                                                                                                        $nota_final = (round($total/3));
                                                                                                }
                                                                                                else{
                                                                                                        $nota_final = (round($total/2));
                                                                                                }
                                                                                        }
                                                                                        else{
                                                                                                if($candidatura[0] -> en_aderencia){
                                                                                                        $nota_final = (round($total/4));
                                                                                                }
                                                                                                else{
                                                                                                        $nota_final = (round($total/3));
                                                                                                }
                                                                                        }
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						echo $nota_final;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																				";
																				}
                                                                                /*echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Curriculo:', 'curriculo', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo1[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma da graduação:', 'graduacao', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo2[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo3[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";*/
                                                                                echo form_fieldset_close();
                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                echo form_fieldset('Pré-requisitos básicos');

                                                                                /*if(isset($questoes1)){
                                                                                        $x=0;

                                                                                        foreach ($questoes1 as $row){
                                                                                                $x++;
                                                                                                echo "
                                                                                                                                                            <div class=\"form-group row\">
                                                                                                                                                                    <div class=\"col-lg-12\">";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                $label=$x.') '.strip_tags($row -> tx_questao);
                                                                                                if($row -> bl_obrigatorio){
                                                                                                        $label.=' <abbr title="Obrigatório">*</abbr>';
                                                                                                }
                                                                                                echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                                                                                                echo '<br/>';
                                                                                                foreach ($respostas as $row2){
                                                                                                        if($row2 -> es_questao == $row -> pr_questao){
                                                                                                                $res = $row2 -> tx_resposta;
                                                                                                        }
                                                                                                }
                                                                                                if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        if($res == '1'){
                                                                                                                $res = 'Sim';
                                                                                                        }
                                                                                                        else if($res == '0'){
                                                                                                                $res = 'Não';
                                                                                                        }
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'rows' => 3,
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_textarea($attributes, $res);
                                                                                                }
                                                                                                echo "
                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
                                                                                        }
                                                                                }*/
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false,'',$anexos_questao);
                                                                                echo form_fieldset_close();

                                                                                //**************************************
                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator-border-dashed kt-separator-space-lg\"></div>";
                                                                                echo form_fieldset('Currículo');
																				
																				
																				
                                                                                if(isset($formacoes)){
                                                                                        $i=0;


                                                                                                foreach($formacoes as $formacao){
                                                                                                        ++$i;
                                                                                                        echo "

                                                                                                                                                            <fieldset>
                                                                                                                                                                    <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                                                                                                /*<div class=\"form-group row validated\">
                                                                                                                                                                                                                        ";*/
                                                                                                echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Tipo', "tipo{$i}", $attributes);
                                                                                                        /*echo "
                                                                                                                                                                                                                            <div class=\"col-lg-4\">";*/
                                                                                                        echo " 
                                                                                                                                                                                    <br />";
                                                                                                        //var_dump($etapas);
                                                                                                        /*$attributes = array(
                                                                                                                    '' => '',
                                                                                                                    'bacharelado' => 'Graduação - Bacharelado',
                                                                                                                    'tecnologo' => 'Graduação - Tecnológo',
                                                                                                                    'especializacao' => 'Pós-graduação - Especialização',
                                                                                                                    'mba' => 'MBA',
                                                                                                                    'mestrado' => 'Mestrado',
                                                                                                                    'doutorado' => 'Doutorado',
                                                                                                                    'posdoc' => 'Pós-doutorado',
                                                                                                                    );*/
                                                                                                        $attributes = array('name' => "tipo{$i}",
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        $res = '';
                                                                                                        if($formacao->en_tipo == 'bacharelado'){
                                                                                                                $res = 'Graduação - Bacharelado';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'tecnologo'){
                                                                                                                $res = 'Graduação - Tecnológo';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'especializacao'){
                                                                                                                $res = 'Pós-graduação - Especialização';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'mba'){
                                                                                                                $res = 'MBA';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'mestrado'){
                                                                                                                $res = 'Mestrado';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'doutorado'){
                                                                                                                $res = 'Doutorado';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'posdoc'){
                                                                                                                $res = 'Pós-doutorado';
                                                                                                        }
																										else if($formacao->en_tipo == 'seminario'){
                                                                                                                $res = 'Curso/Seminário';
                                                                                                        }


                                                                                                        echo form_input($attributes, $res);
                                                                                                        /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                                                                                                echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                                                                                        }
                                                                                                        else{
                                                                                                                echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                                                                                        }*/
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Nome do curso', "curso{$i}", $attributes);
                                                                                                        echo " 
                                                                                                                                                                                    <br />";
                                                                                                        /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                                                                                                $vc_curso[$i] = set_value("curso{$i}");
                                                                                                        }*/
                                                                                                        $attributes = array('name' => "curso{$i}",
                                                                                                                            'id' => "curso{$i}",
                                                                                                                            'maxlength' => '100',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                                                                                                $attributes['class'] = 'form-control is-invalid';
                                                                                                        }*/
                                                                                                        $res = $formacao->vc_curso;                    
                                                                                                        echo form_input($attributes, $res);
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                                                                                        echo " 
                                                                                                                                                                                    <br />";
                                                                                                        /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                                                                                                $vc_instituicao[$i] = set_value("instituicao{$i}");
                                                                                                        }*/
                                                                                                        $attributes = array('name' => "instituicao{$i}",
                                                                                                                            'id' => "instituicao{$i}",
                                                                                                                            'maxlength' => '100',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        $res = $formacao->vc_instituicao;                    
                                                                                                        echo form_input($attributes, $res);
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                                                                                        echo " 
                                                                                                                                                                                    <br />";
                                                                                                        /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                                                                                                $ye_conclusao[$i] = set_value("conclusao{$i}");
                                                                                                        }*/
                                                                                                        $res = $formacao->dt_conclusao;
                                                                                                        $attributes = array('name' => "conclusao{$i}",
                                                                                                                            'id' => "conclusao{$i}",
                                                                                                                            
                                                                                                                            'type' => 'date',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        echo form_input($attributes, $res);

                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
																																									";

                                                                                                        if($formacao->en_tipo == 'seminario'){
                                                                                                                echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                                echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
                                                                                                                echo " 
                                                                                                                                                                                    <br />";
                                                                                                        
                                                                                                                $res = $formacao->in_cargahoraria;
                                                                                                                $attributes = array('name' => "cargahoraria{$i}",
                                                                                                                            'id' => "cargahoraria{$i}",
                                                                                                                            'maxlength' => '10',
                                                                                                                            'type' => 'number',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                                echo form_input($attributes, $res);

                                                                                                                echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>";
                                                                                                        }
                                                                                                        echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                                                                                        echo " 
																																													<br />";
                                                                                                        /*$attributes = array('name' => "diploma{$i}",
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        echo form_upload($attributes, '', 'class="form-control"');*/
                                                                                                        $vc_anexo='';
                                                                                                        $pr_arquivo='';
                                                                                                        if($anexos[$formacao->pr_formacao]){
                                                                                                                foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                                                                                        $vc_anexo = $anexo->vc_arquivo;
                                                                                                                        $pr_arquivo = $anexo->pr_anexo;
																														echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                                                                                                }
                                                                                                        }
																										
                                                                                                        
                                                                                                        echo "
																																											</div>
																																									</div>
																																							</fieldset>

                                                                                                                                                ";
                                                                                                }

                                                                                }
                                                                                //***********************************
                                                                                if(isset($experiencias)){
                                                                                        $i = 0;
                                                                                        foreach($experiencias as $experiencia){
                                                                                                ++$i;
                                                                                                echo "

																																							<fieldset>
																																									<legend>Experiência profissional {$i}</legend>";
																									echo "
																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">";                                                            
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                                                                                                echo " 
																																													<br />";

                                                                                                $attributes = array('name' => "empresa{$i}",
                                                                                                                    'id' => "empresa{$i}",
                                                                                                                    'maxlength' => '100',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                echo form_input($attributes, $experiencia->vc_empresa);
                                                                                                echo "
																																											</div>
																																									</div>
																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Data de início', "inicio{$i}", $attributes);
                                                                                                echo " 
																																													<br />";

                                                                                                $attributes = array('name' => "inicio{$i}",
                                                                                                                    'id' => "inicio{$i}",
                                                                                                                    
                                                                                                                    'type' => 'date',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                echo form_input($attributes, $experiencia->dt_inicio);
                                                                                                echo "
																																											</div>
																																									</div>
																																									";
                                                                                                if($experiencia->bl_emprego_atual=='1'){
                                                                                                        echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Emprego atual', "emprego_atual{$i}", $attributes);
                                                                                                        echo " 
                                                                                                                                                                                    <br />";
                                                                                                        
                                                                                                        $attributes = array('name' => "emprego_atual{$i}",
                                                                                                                    'id' => "emprego_atual{$i}",
                                                                                                                    
                                                                                                                    'type' => 'text',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, "Sim");
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                ";
                                                                                                }
                                                                                                else{
                                                                                                        echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Data de término', "fim{$i}", $attributes);
                                                                                                        echo " 
                                                                                                                                                                                    <br />";
                                                                                                        
                                                                                                        $attributes = array('name' => "fim{$i}",
                                                                                                                    'id' => "fim{$i}",
                                                                                                                    
                                                                                                                    'type' => 'date',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, $experiencia->dt_fim);
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                ";  
                                                                                                }
                                                                                                

                                                                                                echo "
																																									
																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                                                                                                echo " 
																																													<br />";

                                                                                                $attributes = array('name' => "atividades{$i}",
                                                                                                                    'id' => "atividades{$i}",
                                                                                                                    'rows' => '4',
                                                                                                                    'class' => 'form-control',
                                                                                                                'disabled' => 'disabled');
                                                                                                echo form_textarea($attributes, $experiencia->tx_atividades);
                                                                                                echo "
																																											</div>
																																									</div>
																																									<div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Comprovante', "comprovante{$i}", $attributes);
                                                                                                        echo " 
																																													<br />";
                                                                                                        /*$attributes = array('name' => "diploma{$i}",
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        echo form_upload($attributes, '', 'class="form-control"');*/
                                                                                                        $vc_anexo='';
                                                                                                        $pr_arquivo='';
                                                                                                        if($anexos_experiencia[$experiencia->pr_experienca]){
                                                                                                                foreach($anexos_experiencia[$experiencia->pr_experienca] as $anexo){
                                                                                                                        $vc_anexo = $anexo->vc_arquivo;
                                                                                                                        $pr_arquivo = $anexo->pr_anexo;
																														echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                                                                                                }
                                                                                                        }
                                                                                                        
                                                                                                        echo "
																																											</div>
																																									</div>
																																							</fieldset>

                                                                                                                                                ";

                                                                                        }
                                                                                }

                                                                                //***********************************
                                                                                echo "
																																							<div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                echo form_fieldset('Requisitos desejáveis');

                                                                                /*if(isset($questoes2)){
                                                                                        $x=0;
                                                                                        foreach ($questoes2 as $row){
                                                                                                $x++;
                                                                                                echo "
                                                                                                                                                            <div class=\"form-group row\">
                                                                                                                                                                    <div class=\"col-lg-12\">";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                $label=$x.') '.strip_tags($row -> tx_questao);
                                                                                                if($row -> bl_obrigatorio){
                                                                                                        $label.=' <abbr title="Obrigatório">*</abbr>';
                                                                                                }
                                                                                                echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                                                                                                echo '<br/>';
                                                                                                foreach ($respostas as $row2){
                                                                                                        if($row2 -> es_questao == $row -> pr_questao){
                                                                                                                $res = $row2 -> tx_resposta;
                                                                                                        }
                                                                                                }

                                                                                                if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        if($res == '1'){
                                                                                                                $res = 'Sim';
                                                                                                        }
                                                                                                        else if($res == '0'){
                                                                                                                $res = 'Não';
                                                                                                        }
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'rows' => 3,
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_textarea($attributes, $res);
                                                                                                }
                                                                                                echo "
                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
                                                                                        }
                                                                                }*/
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false,'',$anexos_questao);
                                                                                echo form_fieldset_close();
                                                                                
                                                                                
                                                    echo "</div> <!-- Fim 1ª Tab -->";
													if($this -> session -> perfil != 'candidato'){
															echo "<div class=\"tab-pane\" id=\"avaliacaoTab\" role=\"tabpanel\" aria-expanded=\"false\">";
                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                echo form_fieldset('Avaliação do(a) candidato(a) pelo avaliador '.$candidatura[0] -> avaliador_competencia);

                                                                                /*if(isset($questoes3)){
                                                                                        $x=0;
                                                                                        foreach ($questoes3 as $row){
                                                                                                $x++;
                                                                                                echo "
                                                                                                                                                            <div class=\"form-group row\">
                                                                                                                                                                    <div class=\"col-lg-12\">";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                $label=$x.') '.strip_tags($row -> tx_questao);
                                                                                                if($row -> bl_obrigatorio){
                                                                                                        $label.=' <abbr title="Obrigatório">*</abbr>';
                                                                                                }
                                                                                                echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                                                                                                echo '<br/>';
                                                                                                foreach ($respostas as $row2){
                                                                                                        if($row2 -> es_questao == $row -> pr_questao){
                                                                                                                $res = $row2 -> tx_resposta;
                                                                                                        }
                                                                                                }

                                                                                                if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        if($res == '1'){
                                                                                                                $res = 'Sim';
                                                                                                        }
                                                                                                        else if($res == '0'){
                                                                                                                $res = 'Não';
                                                                                                        }
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else{
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'rows' => 3,
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_textarea($attributes, $res);
                                                                                                }
                                                                                                echo "
                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
                                                                                        }
                                                                                }*/
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);
                                                                                echo form_fieldset_close();
                                                                                
                             
                                                                                
														echo "</div> <!-- Fim 2ª Tab -->";
														echo "<div class=\"tab-pane\" id=\"competenciaTab\" role=\"tabpanel\" aria-expanded=\"false\">";                        

                                                                                if($entrevistas){
                                                                                        echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                        //print_r($entrevistas[0]);                                                                    
                                                                                        if($candidatura[0]->es_avaliador_competencia1 == $entrevistas[0]->es_avaliador1){
                                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.$entrevistas[0]->nome1);
                                                                                        }
                                                                                        else if($candidatura[0]->es_avaliador_competencia1 == $entrevistas[0]->es_avaliador2){
                                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.$entrevistas[0]->nome2);
                                                                                        }
                                                                                        
                                                                                        $CI =& get_instance();
                                                                                        $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false);
                                                                                        echo form_fieldset_close();
                                                                                       
                                
                                                                                }
                                                echo "</div> <!-- Fim 3ª Tab -->";
                                                echo "<div class=\"tab-pane\" id=\"aderenciaTab\" role=\"tabpanel\" aria-expanded=\"false\">";                                  
                                                                                
                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                echo form_fieldset('Teste de aderência');
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes5, $respostas, $opcoes, '', false);
                                                                                echo form_fieldset_close();

                                                                                
                                                echo "</div> <!-- Fim 4ª Tab -->";
                                                echo "<div class=\"tab-pane\" id=\"especialistaTab\" role=\"tabpanel\" aria-expanded=\"false\">";                                 

                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                echo form_fieldset('Entrevista com especialista');
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes6, $respostas, $opcoes, '', false);
                                                                                echo form_fieldset_close();


                                                echo "</div> <!-- Fim 5ª Tab -->";
													}
                                                if($this -> session -> perfil == 'candidato'){
														echo "                                                                                          <div class=\"row\">
                                                                                                                                                    <div class=\"col-sm-12\">
                                                                                                                                                        <div class=\"kt-form__actions\">                                                                                
                                                                                                                                                            <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">< Voltar</button>                                                                                                                                                            
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div> ";
												}
												else{
														echo "                                                                                          <div class=\"row\">
                                                                                                                                                    <div class=\"col-sm-12\">
                                                                                                                                                        <div class=\"kt-form__actions\">                                                                                
                                                                                                                                                            <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url($link)."';\">< Voltar</button>                                                                                                                                                            
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div> ";
												}
                                                
                                                echo "                                                                                            </form>";                                                        


                                                
                                                
        echo "                                          </div><!-- Fim div tab conteudo -->  
                                                    </div> <!-- Fim div card block -->
                                                </div>
                                            </div>";
}

if($menu2 == 'RevisaoRequisitos'){ //detalhamento da candidatura
        //var_dump($candidato);
        //var_dump($vaga);
        //var_dump($candidatura);
        //var_dump($anexo3);
        //var_dump($respostas);
        echo "
                                                                                    </h3>
                                                                            </div>
                                                                    
                                                                            ";
        $attributes = array('class' => 'login-form',
                            'id' => 'form_avaliacoes');
        echo form_open($url, $attributes);
        echo form_fieldset('Dados da candidatura');
        echo "
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidato -> vc_nome;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('E-mail:', 'Email', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidato -> vc_email;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Telefone(s):', 'Telefones', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo $candidato -> vc_telefone;
        if(strlen($candidato -> vc_telefoneOpcional) > 0){
                echo ' - '.$candidato -> vc_telefoneOpcional;
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Vaga:', 'Vaga', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidatura[0] -> vc_vaga;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Status da candidatura:', 'status', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo $candidatura[0] -> vc_status;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Data da candidatura:', 'data', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo show_date($candidatura[0] -> dt_candidatura, true);
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Nota:', 'nota', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        //echo $candidato -> vc_email;
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
        /*echo "
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Curriculo:', 'curriculo', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo1[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Diploma da graduação:', 'graduacao', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo2[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo3[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
        }
        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";*/
        echo form_fieldset_close();
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Pré-requisitos básicos');
        
        /*if(isset($questoes1)){
                $x=0;
                
                foreach ($questoes1 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }
                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false);
        echo form_fieldset_close();
        
        //**************************************
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Currículo');
        
        if(isset($formacoes)){
                $i=0;
                
                
                        foreach($formacoes as $formacao){
                                ++$i;
                                echo "
                                                                                            
                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo " 
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                
                                
                                
                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Nome do curso', "curso{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                $res = $formacao->vc_instituicao;                    
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Ano de conclusão', "conclusao{$i}", $attributes);
                                echo " 
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->ye_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    'maxlength' => '4',
                                                    'type' => 'number',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_input($attributes, $res);
                                
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                echo " 
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                
                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
                                        }
                                }
                                echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\">".$vc_anexo."</a>";
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                        }
                        
        }
        //***********************************
        if(isset($experiencias)){
                $i = 0;
                foreach($experiencias as $experiencia){
                        ++$i;
                        echo "
                                                                                        
                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";                                                            
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "empresa{$i}",
                                            'id' => "empresa{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->vc_empresa);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Ano de início', "inicio{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "inicio{$i}",
                                            'id' => "inicio{$i}",
                                            'maxlength' => '4',
                                            'type' => 'number',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->ye_inicio);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Ano de término', "fim{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                                
                        $attributes = array('name' => "fim{$i}",
                                            'id' => "fim{$i}",
                                            'maxlength' => '4',
                                            'type' => 'number',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->ye_fim);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                        echo " 
                                                                                                        <br />";
                            
                        $attributes = array('name' => "atividades{$i}",
                                            'id' => "atividades{$i}",
                                            'rows' => '4',
                                            'class' => 'form-control',
                                        'disabled' => 'disabled');
                        echo form_textarea($attributes, $experiencia->tx_atividades);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>
                                                                                        
                                                                        ";
                                
                }
        }
        
        //***********************************
        echo "
                                                                                <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Requisitos desejáveis');
        
        /*if(isset($questoes2)){
                $x=0;
                foreach ($questoes2 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }

                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false);
        echo form_fieldset_close();
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        //echo form_fieldset('Avaliação do(a) candidato(a)');
        echo form_fieldset('Avaliação curricular');
        
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);
        echo form_fieldset_close();
        
        /*if(isset($questoes3)){
                $x=0;
                foreach ($questoes3 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes); 
                        echo '<br/>';
                        $res = "";
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                        $codigo_resposta = $row2->pr_resposta;
                                }
                        }
                        if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                
                                $valores=array(""=>"",0=>"Não",1=>"Sim");


                                

                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control is-invalid\" id=\"{Questao'.$row -> pr_questao}\""
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control\" id=\"{Questao'.$row -> pr_questao}\""
                                }
                                
                        }
                        else if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                }

                                
                        }
                        
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'rows'=>'5');
                                echo form_textarea($attributes, $res, 'class="form-control"');
                        }
                        else if(isset($opcoes)){
                                $valores = array(""=>"");
                                foreach($opcoes as $opcao){
                                        if($opcao->es_questao==$row -> pr_questao){
                                                $valores[$opcao->pr_opcao]=$opcao->tx_opcao;
                                        }
                                }
                                
                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                }
                        }
                        echo form_hidden('codigo_resposta'.$row -> pr_questao, $codigo_resposta);
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        /*$CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);*/
        
        //echo form_fieldset_close();
        if ($candidatura[0] -> bl_aderencia){
                echo form_fieldset('Teste de aderência');

                $CI =& get_instance();
                $CI -> mostra_questoes($questoes5, $respostas, $opcoes, '', false);
                echo form_fieldset_close();
        }
        
        echo form_fieldset('Entrevista por competência');
        
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false);
        echo form_fieldset_close();
        
        echo form_fieldset('Revisão de requisitos');
        
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes6, $respostas, $opcoes, '', true);
        echo form_fieldset_close();
        
        echo "
                                                                            <div class=\"kt-form__actions\">";
                
                        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
                        if(isset($questoes6)){
                                echo form_input(array('name' => 'codigo_candidatura', 'type'=>'hidden', 'id' =>'codigo_candidatura','value'=>$codigo_candidatura));
                                $attributes = array('class' => 'btn btn-primary');
                                echo form_submit('salvar', 'Salvar', $attributes);
                                
                        }
                        echo "                                                                                
                                                                                    <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."';\">< Voltar</button>
                                                                            </div>
                                                                    </form>
                                                            </div>
                                                    </div>
                                            </div>";
}

if($menu2 == 'AgendamentoEntrevista'){ //agendamento da entrevista ou calendário
        if($this -> session -> perfil == 'candidato' || $this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'sugesp'){ //avaliador
                //var_dump($candidaturas);
                echo "
                                                            <div class=\"row\">
                                                                    <div class=\"col-md-12\">
                                                                            <div id='calendar'>";
                $contador = 0;
                if(isset($candidaturas)){
                        foreach($candidaturas as $linha){
                                if(strlen($linha -> dt_entrevista)>0){
                                        ++$contador;
                                }
                        }
                }
                if($contador == 0){
                        echo "Sem entrevistas agendadas para o seu usuário.";
                }
                echo"</div>
                                                                    </div>
                                                                    
                                                            </div>
                                                    </div>
                                            </div>";
                if($contador > 0){
                        $pagina['js'] = "

        <script type=\"text/javascript\">
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    locale: 'pt-br',
                    
                    
                    axisFormat: 'H:mm',
                    timeFormat: 'H(:mm)',
                    buttonText: {        
                        today: 'Hoje',
                        month: 'Mês',
                        week: 'Semana',
                        day: 'Dia'
                    },
                    header: {
                        left: '',
                        center: 'title'
                    },
                    eventRender: function(eventObj, \$el) {
                        \$el.popover({
                          title: eventObj.title,
                          content: eventObj.description,
                          trigger: 'hover',
                          html: true,
                          placement: 'top',
                          container: 'body'
                        });
                      },
                    events: [";
                
                        foreach($candidaturas as $linha){
                                if(strlen($linha -> dt_entrevista)>0){
                                        if($this -> session -> perfil == 'candidato'){
                                                $pagina['js'] .= " 
                                    {
                                            title: 'Vaga: ".$linha -> vc_vaga."',
                                            start: '".$linha -> dt_entrevista."',
                                            description: 'Tipo:".($linha->bl_tipo_entrevista=='especialista'?"Especialista":"Competência")."',
                                            color: '".($linha->bl_tipo_entrevista=='especialista'?($linha->es_status=='12'?"green":($linha->es_status==15?"red":"#ab8c00")):($linha->es_status=='11'?"green":($linha->es_status==15?"red":"#ab8c00")))."'    
                                    }, ";
                                        }
                                        else{
                                                $pagina['js'] .= " 
                                    {
                                            title: 'Candidato: ".$linha -> vc_nome."',
                                            start: '".$linha -> dt_entrevista."',
                                            description: 'Tipo:".($linha->bl_tipo_entrevista=='especialista'?"Especialista":"Competência")."<br/>Vaga: ".$linha -> vc_vaga."',
                                            color: '".($linha->bl_tipo_entrevista=='especialista'?($linha->es_status=='12'?"green":($linha->es_status==15?"red":"#ab8c00")):($linha->es_status=='11'?"green":($linha->es_status==15?"red":"#ab8c00")))."'   
                                            
                                    }, ";
                                        }
                                }
                        }
                


                        $pagina['js'] .= "
                    ]
                });
            });

        </script>";
                }
        }
        /*else{ //gestores
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
                                            'id' => 'form_avaliacoes');
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                        echo "
                                                                            <div class=\"kt-portlet__body\">";
                        echo form_fieldset('Dados da candidatura');
                        echo "
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        echo $candidato -> vc_nome;
                        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('E-mail:', 'Email', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        echo $candidato -> vc_email;
                        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Telefone(s):', 'Telefones', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-6\">";
                        echo $candidato -> vc_telefone;
                        if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                echo ' - '.$candidato -> vc_telefoneOpcional;
                        }
                        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Vaga:', 'Vaga', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        echo $candidatura[0] -> vc_vaga;
                        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Status da candidatura:', 'status', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-6\">";
                        echo $candidatura[0] -> vc_status;
                        echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                        echo form_fieldset('Entrevista');
                        //var_dump($entrevista);
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 1 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $dados_usuarios[0] = '';
                        foreach($usuarios as $linha){
                                $dados_usuarios[$linha -> pr_usuario] = $linha -> vc_nome;
                        }
                        $avaliador1='';
                        if(isset($entrevista[0] -> es_avaliador1) && strlen($entrevista[0] -> es_avaliador1)>0){
                                $avaliador1=$entrevista[0] -> es_avaliador1;
                        }
                        
                        
                        if(strlen(set_value('avaliador1')) > 0){
                                $avaliador1 = set_value('avaliador1');
                        }
                        if(strstr($erro, "'Avaliador 1'")){
                                echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 2 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador2='';
                        if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                $avaliador2 = $entrevista[0] -> es_avaliador2;
                        }
                        
                        if(strlen(set_value('avaliador2')) > 0){
                                $avaliador2 = set_value('avaliador2');
                        }
                        if(strstr($erro, "'Avaliador 2'")){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Horário da entrevista <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-3\">";
                        $data_entrevista = '';
                        if(isset($entrevista[0] -> dt_entrevista) && strlen($entrevista[0] -> dt_entrevista)>0){
                                $data_entrevista = $entrevista[0] -> dt_entrevista;
                        }
                        
                        if(strlen(set_value('data')) > 0){
                                $data_entrevista = show_sql_date(set_value('data'), true);
                        }
                        $attributes = array('name' => 'data',
                                            'id' => 'data',
                                            'class' => 'form-control');
                        if(strstr($erro, "'Horário da entrevista'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        echo form_input($attributes, show_date($data_entrevista, true));
                        echo "
                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                        $attributes = array('class' => 'btn btn-primary');
                        echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                        $pagina['js']="
                <script type=\"text/javascript\">
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });
                </script>";
                }
        }*/
        echo "
                                                    </div>
                                            </div>";
}
if($menu2 == 'AvaliacaoEntrevista'){ //avaliação da entrevista - 4ª etapa
       
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
                                    'id' => 'form_avaliacoes');
                if(isset($vaga) && $vaga > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo, 'vaga' => $vaga));
                }
                else{
                        echo form_open($url, $attributes, array('codigo' => $codigo)); 
                }
                
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                //var_dump($candidatura);
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($opcoes);
                /*
                if(isset($questoes4)){
                        $x=0;
                        foreach ($questoes4 as $row){
                                $x++;
                                echo "
                                                                                                                                    <div class=\"form-group row validated\">
                                                                                                                                            <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                //$label=$x.') '.strip_tags($row -> tx_questao);
                                echo $row -> tx_questao;
                                echo '<br/>';
                                //echo 'questao: '.$row -> pr_questao.'<br>';
                                if($row -> in_tipo == 1){ //customizadas
                                        foreach ($opcoes as $row2){
                                                //echo $row2 -> es_questao.': '.$row2 -> tx_opcao.'<br>';
                                                if($row2 -> es_questao == $row -> pr_questao){
                                                        //echo 'opcao: '.$row2 -> tx_opcao.'<br>';
                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                            'value'=> $row2 -> in_valor);
                                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)==$row2 -> in_valor && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                                        echo ' '.$row2 -> tx_opcao.'<br/>';
                                                }
                                        }
                                }
                                else if($row -> in_tipo == 2){ //aberta
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'rows'=>'5');
                                        echo form_textarea($attributes, set_value('Questao'.$row -> pr_questao), 'class="form-control"');
                                }
                                else if($row -> in_tipo == 3 || $row -> in_tipo == 4){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Sim<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Não<br/>';
                                }
                                else if($row -> in_tipo == 5){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Nenhum<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Básico<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'2');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='2' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Intermediário<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'3');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='3' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Avançado<br/>';
                                }

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
                }
                */
                $CI =& get_instance();
                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, $erro, true);
                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                $attributes['formnovalidate'] = 'formnovalidate';
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                unset($attributes['formnovalidate']);
                echo form_submit('concluir_entrevista', 'Concluir', $attributes);
                if(isset($vaga) && $vaga > 0){
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vaga)."'\">Cancelar</button>";
                }
                else{
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>";
                }
                

                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
        <script type=\"text/javascript\">
            $('#data').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
        </script>";
        }
        echo "
                                                    </div>
                                            </div>";
}

if($menu2 == 'AvaliacaoEntrevistaEspecialista'){ //avaliação da entrevista especialista - 6ª etapa
        
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
                                    'id' => 'form_avaliacoes');
                if(isset($vaga) && $vaga > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo,'vaga' => $vaga));
                }
                else{
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                //var_dump($candidatura);
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "
                                                                          
                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($opcoes);
                /*
                if(isset($questoes4)){
                        $x=0;
                        foreach ($questoes4 as $row){
                                $x++;
                                echo "
                                                                                                                                    <div class=\"form-group row validated\">
                                                                                                                                            <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                //$label=$x.') '.strip_tags($row -> tx_questao);
                                echo $row -> tx_questao;
                                echo '<br/>';
                                //echo 'questao: '.$row -> pr_questao.'<br>';
                                if($row -> in_tipo == 1){ //customizadas
                                        foreach ($opcoes as $row2){
                                                //echo $row2 -> es_questao.': '.$row2 -> tx_opcao.'<br>';
                                                if($row2 -> es_questao == $row -> pr_questao){
                                                        //echo 'opcao: '.$row2 -> tx_opcao.'<br>';
                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                            'value'=> $row2 -> in_valor);
                                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)==$row2 -> in_valor && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                                        echo ' '.$row2 -> tx_opcao.'<br/>';
                                                }
                                        }
                                }
                                else if($row -> in_tipo == 2){ //aberta
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'rows'=>'5');
                                        echo form_textarea($attributes, set_value('Questao'.$row -> pr_questao), 'class="form-control"');
                                }
                                else if($row -> in_tipo == 3 || $row -> in_tipo == 4){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Sim<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Não<br/>';
                                }
                                else if($row -> in_tipo == 5){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Nenhum<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Básico<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'2');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='2' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Intermediário<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'3');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='3' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Avançado<br/>';
                                }

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
                }
                */
                $CI =& get_instance();
                $CI -> mostra_questoes($questoes6, $respostas, $opcoes, $erro, true);
                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                $attributes['formnovalidate'] = 'formnovalidate';
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                unset($attributes['formnovalidate']);
                echo form_submit('concluir_entrevista', 'Concluir', $attributes);
                if(isset($vaga) && $vaga > 0){
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vaga)."'\">Cancelar</button>";
                }
                else{
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>";
                }
                echo "
                                                                                                            
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
        <script type=\"text/javascript\">
            $('#data').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
        </script>";
        }        
        echo "
                                                    </div>
                                            </div>";
}

echo "
                                    </div>";

$this -> load -> view('internaRodape', $pagina);
?>