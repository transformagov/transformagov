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

if ($menu2 != 'AvaliacaoCurriculo') {
    //Modelo padrão de página
    echo "              <div class=\"col-12\">
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
} else {
    //Modelo de página de avaliação de currículo
    echo "              <div class=\"col-12\">
                            <div class=\"tsm-inner-content p-0\">    
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper p-0\">
                                        <div class=\"page-body\"> 
                                            <div class=\"row\" style=\"position:relative; left:1px;\">
                                                <div class=\"col-sm-3 shadow-lg p-0 avaliacao-tabs\" style=\"max-width:260px; min-width:240px;\">
                                                    <div class=\"menu1\">
                                                        <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'lkavaliacao')\"><span class=\"tsm-mclass\">Avaliação</span><span class=\"tsm-micon\"><i class=\"fas fa-tasks\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                        <hr> 
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkcompleta')\"><span class=\"tsm-mclass\">Candidatura completa</span><span class=\"tsm-micon\"><i class=\"fas fa-id-badge\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkdados')\"><span class=\"tsm-mclass\">Dados da candidatura</span><span class=\"tsm-micon\"><i class=\"fas fa-address-book\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkprereq')\"><span class=\"tsm-mclass\">Pré Requisitos da Vaga</span><span class=\"tsm-micon\"><i class=\"fas fa-address-book\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkformacoes')\"><span class=\"tsm-mclass\">Formações Acadêmicas</span><span class=\"tsm-micon\"><i class=\"fas fa-user-graduate\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkcursos')\"><span class=\"tsm-mclass\">Cursos e Seminários</span><span class=\"tsm-micon\"><i class=\"fas fa-university\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkexperiencias')\"><span class=\"tsm-mclass\">Experiências Profissionais</span><span class=\"tsm-micon\"><i class=\"fas fa-user-tie\" style=\"margin-left: 12px; font-size:1.2em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkdesejaveis')\"><span class=\"tsm-mclass\">Requisitos Desejáveis</span><span class=\"tsm-micon\"><i class=\"fas fa-portrait\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
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

    if (strlen($erro)>0) {
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
    if (isset($questoes3)) {
        echo form_input(array('name' => 'codigo_candidatura', 'type'=>'hidden', 'id' =>'codigo_candidatura','value'=>$codigo_candidatura));
        $attributes = array('class' => 'btn btn-primary');

        echo form_submit('salvar', 'Concluir avaliação', $attributes);

        $attributes['formnovalidate'] = 'formnovalidate';
        echo form_submit('salvar', 'Salvar dados', $attributes);
        //unset($attributes['formnovalidate']);
        $attributes['id'] = "Reprovar";
        echo form_submit('salvar', 'Reprovar na habilitação', $attributes);
    } else {
        echo "
                                                                                    <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('GruposVagas/index')."';\">Definir questões para essa etapa</button>
                            ";
    }
    if ($id_vaga>0) {
        echo "                                                                                
                                                                                    <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/resultado/'.$id_vaga)."';\">< Interromper avaliação</button>";
    } else {
        echo "                                                                                
                                                                                    <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."';\">< Interromper avaliação</button>";
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
    if (strlen($candidato -> vc_telefoneOpcional) > 0) {
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

    $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false, '', $anexos_questao);
    echo form_fieldset_close();

    //**************************************
    echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
    echo form_fieldset('Currículo');

    if (isset($formacoes)) {
        $i=0;


        foreach ($formacoes as $formacao) {
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
            if ($formacao->en_tipo == 'bacharelado') {
                $res = 'Graduação - Bacharelado';
            } elseif ($formacao->en_tipo == 'tecnologo') {
                $res = 'Graduação - Tecnológo';
            } elseif ($formacao->en_tipo == 'especializacao') {
                $res = 'Pós-graduação - Especialização';
            } elseif ($formacao->en_tipo == 'mba') {
                $res = 'MBA';
            } elseif ($formacao->en_tipo == 'mestrado') {
                $res = 'Mestrado';
            } elseif ($formacao->en_tipo == 'doutorado') {
                $res = 'Doutorado';
            } elseif ($formacao->en_tipo == 'posdoc') {
                $res = 'Pós-doutorado';
            } elseif ($formacao->en_tipo == 'seminario') {
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

            if ($formacao->en_tipo == 'seminario') {
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
            if ($anexos[$formacao->pr_formacao]) {
                foreach ($anexos[$formacao->pr_formacao] as $anexo) {
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
    if (isset($experiencias)) {
        $i = 0;
        foreach ($experiencias as $experiencia) {
            ++$i;
            echo "
                                                                                        
                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
            echo "
                                                                                <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Cargo', "cargo{$i}", $attributes);
            echo " 
                                                                                                        <br />";

            $attributes = array('name' => "cargo{$i}",
                                            'id' => "cargo{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
            echo form_input($attributes, $experiencia->vc_cargo);
            echo "
                                                                                                </div>
                                                                                        </div>
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
            if ($experiencia->bl_emprego_atual=='1') {
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
            } else {
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
            if ($anexos_experiencia[$experiencia->pr_experienca]) {
                foreach ($anexos_experiencia[$experiencia->pr_experienca] as $anexo) {
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
    $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false, '', $anexos_questao);
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
    if (strlen($candidato -> vc_telefoneOpcional) > 0) {
        echo ' - '.$candidato -> vc_telefoneOpcional;
    }
    echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
    if ($this -> session -> perfil == 'candidato') {
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
    if (($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6') && $this -> session -> perfil == 'candidato') {
        echo "Candidatura Pendente";
    } else {
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
    if (isset($notas['3'])) {
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
    if (isset($notas['4'])) {
        echo $notas['4'];
    }
    echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
    if (isset($notas['5'])) {
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
    if (isset($notas['6'])) {
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
    echo(isset($notas['3']) ? intval($notas['3']."") : 0)+(isset($notas['4']) ? intval($notas['4']."") : 0)+(isset($notas['5']) ? intval($notas['5']."") : 0)+(isset($notas['6']) ? intval($notas['6']."") : 0);
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
    $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false, '', $anexos_questao);

    echo "                                                      </div>";
    // Fim Pré Requisitos

    // Início Formações Acadêmicas
    echo "                                                      <div class=\"menu1conteudo\" id=\"lkformacoes\">";
    echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-graduate\" style=\"font-size:0.9em;\"></i> &nbsp; Formações Acadêmicas</h3>";

    if (isset($formacoes)) {
        $i=0;


        foreach ($formacoes as $formacao) {
            ++$i;
            if ($formacao->en_tipo == 'seminario') {
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
            if ($formacao->en_tipo == 'bacharelado') {
                $res = 'Graduação - Bacharelado';
            } elseif ($formacao->en_tipo == 'tecnologo') {
                $res = 'Graduação - Tecnológo';
            } elseif ($formacao->en_tipo == 'especializacao') {
                $res = 'Pós-graduação - Especialização';
            } elseif ($formacao->en_tipo == 'mba') {
                $res = 'MBA';
            } elseif ($formacao->en_tipo == 'mestrado') {
                $res = 'Mestrado';
            } elseif ($formacao->en_tipo == 'doutorado') {
                $res = 'Doutorado';
            } elseif ($formacao->en_tipo == 'posdoc') {
                $res = 'Pós-doutorado';
            } elseif ($formacao->en_tipo == 'seminario') {
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
            if ($formacao->en_tipo == 'seminario') {
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
            if ($anexos[$formacao->pr_formacao]) {
                foreach ($anexos[$formacao->pr_formacao] as $anexo) {
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
    if (isset($formacoes)) {
        $i=0;


        foreach ($formacoes as $formacao) {
            ++$i;
            if ($formacao->en_tipo != 'seminario') {
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
            if ($formacao->en_tipo == 'bacharelado') {
                $res = 'Graduação - Bacharelado';
            } elseif ($formacao->en_tipo == 'tecnologo') {
                $res = 'Graduação - Tecnológo';
            } elseif ($formacao->en_tipo == 'especializacao') {
                $res = 'Pós-graduação - Especialização';
            } elseif ($formacao->en_tipo == 'mba') {
                $res = 'MBA';
            } elseif ($formacao->en_tipo == 'mestrado') {
                $res = 'Mestrado';
            } elseif ($formacao->en_tipo == 'doutorado') {
                $res = 'Doutorado';
            } elseif ($formacao->en_tipo == 'posdoc') {
                $res = 'Pós-doutorado';
            } elseif ($formacao->en_tipo == 'seminario') {
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
            if ($formacao->en_tipo == 'seminario') {
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
            if ($anexos[$formacao->pr_formacao]) {
                foreach ($anexos[$formacao->pr_formacao] as $anexo) {
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


    if (isset($experiencias)) {
        $i = 0;
        foreach ($experiencias as $experiencia) {
            ++$i;
            echo "
                                                                                        
                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
            echo "
                                                                                <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Cargo', "cargo{$i}", $attributes);
            echo " 
                                                                                                        <br />";

            $attributes = array('name' => "cargo{$i}",
                                            'id' => "cargo{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
            echo form_input($attributes, $experiencia->vc_cargo);
            echo "
                                                                                                </div>
                                                                                        </div>
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
            if ($experiencia->bl_emprego_atual=='1') {
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
            } else {
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
            if ($anexos_experiencia[$experiencia->pr_experienca]) {
                foreach ($anexos_experiencia[$experiencia->pr_experienca] as $anexo) {
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
    $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false, '', $anexos_questao);


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

                                                                        // clica no menu Avaliação
                                                                        document.addEventListener('DOMContentLoaded', function() {
                                                                          var btn = document.querySelector('.tablinks.primeiro.active');
                                                                          if(btn) btn.click();
                                                                        });
                                                                    </script>
                                                                    ";
}
// Fim da condição da tela de avaliação

$dados_status[0] = '';
foreach ($status as $linha) {
    $dados_status[$linha -> pr_status] = $linha -> vc_status;
}

if (strlen(set_value('filtro_instituicao')) > 0) {
    echo '<span class="small"> - Instituição: '.$instituicoes[set_value('filtro_instituicao')].'</span>';
}
if (strlen(set_value('filtro_vaga')) > 0) {
    echo '<span class="small"> - Vaga: '.$vagas[set_value('filtro_vaga')].'</span>';
}
if (strlen(set_value('filtro_status')) > 0) {
    echo '<span class="small"> - Status: '.$dados_status[set_value('filtro_status')].'</span>';
}
echo "</h4>
                                                                    </div>";

if ($menu2 == 'index') {
    echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                        <a href=\"".base_url('Usuarios/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Novo usuário </a>
                                                                    </div>";
} elseif ($menu2 == 'create' || $menu2 == 'edit') {
    echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_usuarios').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
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
if ($menu2 == 'ListaAvaliacao') {
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
    foreach ($status as $linha) {
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

    if (isset($candidaturas)) {
        $candidatura_anterior = -1;
        $atual = time();
        foreach ($candidaturas as $linha) {
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
            if (strlen($linha -> bl_tipo_entrevista)>0) {
                if ($linha->bl_tipo_entrevista == 'competencia') {
                    echo "Competência";
                } else {
                    echo "Especialista";
                }
            }
            echo "</td>    
                                ";

            if ($linha -> es_status == 2 || $linha -> es_status == 4 || $linha -> es_status == 8 || $linha -> es_status == 10 || $linha -> es_status == 12 || $linha -> es_status == 13 || $linha -> es_status == 20) {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status;
                if ($linha -> es_status == 10) {
                    if ($linha->bl_tipo_entrevista == 'competencia') {
                        echo " - Competência";
                    }
                    if ($linha->bl_tipo_entrevista == 'especialista') {
                        echo " - Especialista";
                    }
                }

                echo '</span></td>';
            } else {
                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">".$linha -> vc_status.'</span></td>';
            }
            echo "
                                                                                            <td class=\"text-center\">".($linha -> en_aderencia == '2' ? "Realizado" : ($linha -> en_aderencia == '1' ? "Solicitado" : "Não solicitado"))."</td>
                                                                                            <td class=\"text-center\">";
            //if($linha -> es_status != 1){
            echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-search">Detalhes</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
            //echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\"");
                        //}
                        if (($linha -> es_status == 7 || $linha -> es_status == 20) && $dt_fim < $atual) { //aprovado 2ª etapa

                                if ($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador') {
                                    echo "<br />";
                                    echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Currículo</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");
                                }
                        }
            if ($linha -> es_status == 10) { //entrevista por competência
                                if ($linha -> bl_tipo_entrevista == 'competencia' && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0))) { //avaliador
                                        if (strtotime($linha -> dt_entrevista) <= $atual) {
                                            echo "<br />";
                                            echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                        }
                                } elseif ($linha -> bl_tipo_entrevista == 'especialista' && ((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && $linha -> es_avaliador2 == '')) { //avaliador
                                    if (strtotime($linha -> dt_entrevista) <= $atual) {
                                        echo "<br />";
                                        echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                                    }
                                }
            }
            if ($linha -> es_status == 11) { //entrevista por especialista

                if ($linha -> bl_tipo_entrevista == 'especialista' && ((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($linha -> es_avaliador2) == 0)) { //avaliador
                    if (strtotime($linha -> dt_entrevista) <= $atual) {
                        echo "<br />";
                        echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                    }
                }
            } elseif ($linha -> es_status == 12) {
                if ($linha -> bl_tipo_entrevista == 'competencia' && ((($this -> session -> perfil == 'sugesp' && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2)) || $this -> session -> perfil == 'avaliador') && (strlen($linha -> es_avaliador_competencia1) == 0))) { //avaliador
                    if (strtotime($linha -> dt_entrevista) <= $atual) {
                        echo "<br />";
                        echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Não Comparecimento\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar não comparecimento da entrevista</i></a>";
                    }
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
    if ($paginacao > 0) {
        echo "
                                                                    <div class=\"row\">
                                                                            <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                    <div class=\"dataTables_info\" id=\"vagas_table_info\" role=\"status\" aria-live=\"polite\">Mostrando de ".((($paginacao-1)*30)+1)." até ";
        if (($paginacao*30) > $total) {
            echo $total;
        } else {
            echo($paginacao*30);
        }
        echo " de {$total} itens</div>
                                                                            </div>
                                                                            <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                    <div class=\"dataTables_paginate paging_simple_numbers\" id=\"vagas_table_paginate\">
                                                                                            <ul class=\"pagination\">";
        $extra='';

        if ($paginacao > 1) {
            echo "
                                                                                                    <li class=\"paginate_button page-item previous\" id=\"vagas_table_previous\">
                                                                                                            <a onclick=\"ahref_lista(".($paginacao-1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                                    </li>";
        } else {
            echo "
                                                                                                    <li class=\"paginate_button page-item previous disabled\" id=\"vagas_table_previous\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                                    </li>";
        }
        echo "
                                                                                                    <li class=\"paginate_button page-item ";
        if ($paginacao == 1) {
            echo 'active';
        }
        echo "\">
                                                                                                            <a onclick=\"ahref_lista(1);\" aria-controls=\"vagas_table\" data-dt-idx=\"1\" tabindex=\"0\" class=\"page-link\">1</a>
                                                                                                    </li>";
        if ($paginacao > 3) {
            echo "
                                                                                                    <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                                    </li>";
        }
        if ($paginacao <= 2) {
            $inicio = 2;
            $termino = 5;
        } else {
            $inicio = $paginacao-1;
            $termino = $paginacao+4;
        }
        for ($i = $inicio; $i <= $total_paginas && $i <= $termino; $i++) {
            echo "
                                                                                                    <li class=\"paginate_button page-item ";
            if ($paginacao == $i) {
                echo 'active';
            }
            echo "\">
                                                                                                            <a onclick=\"ahref_lista(".$i.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$i\" tabindex=\"0\" class=\"page-link\">$i</a>
                                                                                                    </li>";
        }
        if ($paginacao < ($total_paginas - 5)) {
            echo "
                                                                                                    <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                            <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                                    </li>";
        }
        if ($paginacao < ($total_paginas - 4)) {
            echo "
                                                                                                    <li class=\"paginate_button page-item \">
                                                                                                            <a onclick=\"ahref_lista(".$total_paginas.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$total_paginas\" tabindex=\"0\" class=\"page-link\">$total_paginas</a>
                                                                                                    </li>";
        }
        if ($paginacao < $total_paginas) {
            echo "
                                                                                                    <li class=\"paginate_button page-item next\" id=\"vagas_table_next\">
                                                                                                            <a onclick=\"ahref_lista(".($paginacao+1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                                    </li>";
        } else {
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
                                //echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\"");
                        //}
                        if(($linha -> es_status == 7 || $linha -> es_status == 20) && $dt_fim < $atual){ //aprovado 2ª etapa

                                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
                                        echo "<br />";
                                        echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Currículo</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");

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
if ($menu2 == 'DetalheAvaliacao') { //detalhamento da candidatura
    //var_dump($candidato);
    //var_dump($vaga);
    //var_dump($candidatura);
    //var_dump($anexo3);
    //var_dump($respostas);
    if ($this -> session -> perfil == 'candidato') {
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
    } elseif ($this -> session -> perfil == 'avaliador') {
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
                                                                                <a class=\"nav-link\" data-toggle=\"tab\" href=\"#competenciaTab\" aria-expanded=\"true\">Entrevistas por competências</a>
                                                                        </li>

                                                                        <li class=\"nav-item\">
                                                                                <a class=\"nav-link\" data-toggle=\"tab\" href=\"#especialistaTab\" aria-expanded=\"true\">Entrevista com especialista</a>
                                                                        </li>
                                                                </ul>
                                                        </div>
                                                        </div>     
                                                <!-- Fim das tabs superior de navegação de conteúdo -->";
    } else {
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
                                                                                <a class=\"nav-link\" data-toggle=\"tab\" href=\"#motivacaoTab\" aria-expanded=\"true\">Teste de Motivação</a>                                                                            
                                                                        </li>

                                                                        <li class=\"nav-item\">
                                                                                <a class=\"nav-link\" data-toggle=\"tab\" href=\"#hbdiTab\" aria-expanded=\"true\">HBDI</a>                                                                            
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
    //if($this -> session -> perfil != 'avaliador'){
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
    echo form_label('CPF:', 'CPF', $attributes);
    $cpf = "";
    if (strlen($candidato -> ch_cpf)>0) {
        $partes2 = explode('.', $candidato -> ch_cpf);
        $cpf = $partes2[0].".***.***-**";
    }



    echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
    echo $cpf;
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
    if (strlen($candidato -> vc_telefoneOpcional) > 0) {
        echo ' - '.$candidato -> vc_telefoneOpcional;
    }
    echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
    if ($this -> session -> perfil == 'candidato') {
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
    if (!($this -> session -> perfil == 'candidato')) {
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
        if ($candidatura[0] -> es_status == '10') {
            if (isset($entrevistas)) {
                echo " - Competência";
            }
            if (isset($entrevistas_especialista)) {
                echo " - Especialista";
            }
        }
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

    if ($this -> session -> perfil != 'candidato' && $this -> session -> perfil != 'avaliador') {
        echo "
																																									<div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Nota Avaliação Curricular:', 'nota', $attributes);
        echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
        if (isset($notas['3'])) {
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
        if (isset($notas['4'])) {
            echo $notas['4'];
        }
        echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
        if (isset($notas['5'])) {
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
        if (isset($notas['6'])) {
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
        $total = (isset($notas['3']) ? intval($notas['3']."") : 0)+(isset($notas['4']) ? intval($notas['4']."") : 0)+(isset($notas['5']) ? intval($notas['5']."") : 0)+(isset($notas['6']) ? intval($notas['6']."") : 0);
        $nota_final = 0;
        if (!isset($notas['6']) || $notas['6'] == '0') {
            if ($candidatura[0] -> en_aderencia) {
                $nota_final = (round($total/3));
            } else {
                $nota_final = (round($total/2));
            }
        } else {
            if ($candidatura[0] -> en_aderencia) {
                $nota_final = (round($total/4));
            } else {
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
    $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false, '', $anexos_questao);
    echo form_fieldset_close();

    //**************************************
    echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator-border-dashed kt-separator-space-lg\"></div>";
    echo form_fieldset('Currículo');



    if (isset($formacoes)) {
        $i=0;


        foreach ($formacoes as $formacao) {
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
            if ($formacao->en_tipo == 'bacharelado') {
                $res = 'Graduação - Bacharelado';
            } elseif ($formacao->en_tipo == 'tecnologo') {
                $res = 'Graduação - Tecnológo';
            } elseif ($formacao->en_tipo == 'especializacao') {
                $res = 'Pós-graduação - Especialização';
            } elseif ($formacao->en_tipo == 'mba') {
                $res = 'MBA';
            } elseif ($formacao->en_tipo == 'mestrado') {
                $res = 'Mestrado';
            } elseif ($formacao->en_tipo == 'doutorado') {
                $res = 'Doutorado';
            } elseif ($formacao->en_tipo == 'posdoc') {
                $res = 'Pós-doutorado';
            } elseif ($formacao->en_tipo == 'seminario') {
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

            if ($formacao->en_tipo == 'seminario') {
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
            if ($anexos[$formacao->pr_formacao]) {
                foreach ($anexos[$formacao->pr_formacao] as $anexo) {
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
    if (isset($experiencias)) {
        $i = 0;
        foreach ($experiencias as $experiencia) {
            ++$i;
            echo "

																																							<fieldset>
																																									<legend>Experiência profissional {$i}</legend>";
            echo "
                                                                                                                                                                                                                                                                                                                                        <div class=\"form-group row\">
                                                                                                                                                                                                                                                                                                                                                        <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Cargo', "cargo{$i}", $attributes);
            echo " 
                                                                                                                                                                                                                                                                                                                                                                        <br />";

            $attributes = array('name' => "cargo{$i}",
                                                                                                                'id' => "cargo{$i}",
                                                                                                                'maxlength' => '100',
                                                                                                                'class' => 'form-control',
                                                                                                                'disabled' => 'disabled');
            echo form_input($attributes, $experiencia->vc_cargo);
            echo "
                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                        </div>
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
            if ($experiencia->bl_emprego_atual=='1') {
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
            } else {
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
            if ($anexos_experiencia[$experiencia->pr_experienca]) {
                foreach ($anexos_experiencia[$experiencia->pr_experienca] as $anexo) {
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
    $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false, '', $anexos_questao);
    echo form_fieldset_close();


    echo "</div> <!-- Fim 1ª Tab -->";
    //}
    if ($this -> session -> perfil != 'candidato') {
        /*if($this -> session -> perfil == 'avaliador'){
                echo "<div class=\"tab-pane active\"  id=\"avaliacaoTab\" role=\"tabpanel\" aria-expanded=\"false\">";
        }
        else{*/
        echo "<div class=\"tab-pane\" id=\"avaliacaoTab\" role=\"tabpanel\" aria-expanded=\"false\">";
        //}

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

        if ($entrevistas) {
            echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
            //print_r($entrevistas[0]);
            if ($candidatura[0]->es_avaliador_competencia1 == $entrevistas[0]->es_avaliador1) {
                echo form_fieldset('Entrevista por competência pelo(a) '.$entrevistas[0]->nome1);
            } elseif ($candidatura[0]->es_avaliador_competencia1 == $entrevistas[0]->es_avaliador2) {
                echo form_fieldset('Entrevista por competência pelo(a) '.$entrevistas[0]->nome2);
            }

            $CI =& get_instance();
            $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false);
            echo form_fieldset_close();
        }
        echo "</div> <!-- Fim 3ª Tab -->";
        if ($this -> session -> perfil != 'avaliador') {
            echo "<div class=\"tab-pane\" id=\"hbdiTab\" role=\"tabpanel\" aria-expanded=\"false\">";

            echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
            echo form_fieldset('HBDI');
            echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("Quais sentidos ou situações fazem você se sentir mais motivado no trabalho?", 'MotivacaoTrabalho');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";
            $MotivacaoTrabalho1 = '';
            if (isset($hbdi -> bl_motivacao_trabalho1) && strlen($hbdi -> bl_motivacao_trabalho1) > 0) {
                $MotivacaoTrabalho1 = $hbdi -> bl_motivacao_trabalho1;
            }

            $attributes = array('id'=>'MotivacaoTrabalho1','name' => 'MotivacaoTrabalho1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho1, ($MotivacaoTrabalho1=='1' && strlen($MotivacaoTrabalho1)>0));
            echo "
                                                                                                <span>1.1 Trabalhar sozinho</span><br />";
            $MotivacaoTrabalho2 = '';
            if (isset($hbdi -> bl_motivacao_trabalho2) && strlen($hbdi -> bl_motivacao_trabalho2) > 0) {
                $MotivacaoTrabalho2 = $hbdi -> bl_motivacao_trabalho2;
            }

            $attributes = array('id'=>'MotivacaoTrabalho2','name' => 'MotivacaoTrabalho2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho2, ($MotivacaoTrabalho2=='1' && strlen($MotivacaoTrabalho2)>0));
            echo "
                                                                                                <span>1.2 Expressar minhas ideias</span><br />";
            $MotivacaoTrabalho3 = '';
            if (isset($hbdi -> bl_motivacao_trabalho3) && strlen($hbdi -> bl_motivacao_trabalho3) > 0) {
                $MotivacaoTrabalho3 = $hbdi -> bl_motivacao_trabalho3;
            }

            $attributes = array('id'=>'MotivacaoTrabalho3','name' => 'MotivacaoTrabalho3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho3, ($MotivacaoTrabalho3=='1' && strlen($MotivacaoTrabalho3)>0));
            echo "
                                                                                                <span>1.3 Estar no controle da situação</span><br />";
            $MotivacaoTrabalho4 = '';
            if (isset($hbdi -> bl_motivacao_trabalho4) && strlen($hbdi -> bl_motivacao_trabalho4) > 0) {
                $MotivacaoTrabalho4 = $hbdi -> bl_motivacao_trabalho4;
            }

            $attributes = array('id'=>'MotivacaoTrabalho4','name' => 'MotivacaoTrabalho4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho4, ($MotivacaoTrabalho4=='1' && strlen($MotivacaoTrabalho4)>0));
            echo "
                                                                                                <span>1.4 Provocar mudanças</span><br />";
            $MotivacaoTrabalho5 = '';
            if (isset($hbdi -> bl_motivacao_trabalho5) && strlen($hbdi -> bl_motivacao_trabalho5) > 0) {
                $MotivacaoTrabalho5 = $hbdi -> bl_motivacao_trabalho5;
            }

            $attributes = array('id'=>'MotivacaoTrabalho5','name' => 'MotivacaoTrabalho5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho5, ($MotivacaoTrabalho5=='1' && strlen($MotivacaoTrabalho5)>0));
            echo "
                                                                                                <span>1.5 Ouvir e falar</span><br />";
            $MotivacaoTrabalho6 = '';
            if (isset($hbdi -> bl_motivacao_trabalho6) && strlen($hbdi -> bl_motivacao_trabalho6) > 0) {
                $MotivacaoTrabalho6 = $hbdi -> bl_motivacao_trabalho6;
            }

            $attributes = array('id'=>'MotivacaoTrabalho6','name' => 'MotivacaoTrabalho6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho6, ($MotivacaoTrabalho6=='1' && strlen($MotivacaoTrabalho6)>0));
            echo "
                                                                                                <span>1.6 Criar ou usar recursos visuais</span><br />";
            $MotivacaoTrabalho7 = '';
            if (isset($hbdi -> bl_motivacao_trabalho7) && strlen($hbdi -> bl_motivacao_trabalho7) > 0) {
                $MotivacaoTrabalho7 = $hbdi -> bl_motivacao_trabalho7;
            }

            $attributes = array('id'=>'MotivacaoTrabalho7','name' => 'MotivacaoTrabalho7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho7, ($MotivacaoTrabalho7=='1' && strlen($MotivacaoTrabalho7)>0));
            echo "
                                                                                                <span>1.7 Prestar atenção aos detalhes</span><br />";
            $MotivacaoTrabalho8 = '';
            if (isset($hbdi -> bl_motivacao_trabalho8) && strlen($hbdi -> bl_motivacao_trabalho8) > 0) {
                $MotivacaoTrabalho8 = $hbdi -> bl_motivacao_trabalho8;
            }

            $attributes = array('id'=>'MotivacaoTrabalho8','name' => 'MotivacaoTrabalho8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho8, ($MotivacaoTrabalho8=='1' && strlen($MotivacaoTrabalho8)>0));
            echo "
                                                                                                <span>1.8 Aspectos técnicos</span><br />";
            $MotivacaoTrabalho9 = '';
            if (isset($hbdi -> bl_motivacao_trabalho9) && strlen($hbdi -> bl_motivacao_trabalho9) > 0) {
                $MotivacaoTrabalho9 = $hbdi -> bl_motivacao_trabalho9;
            }

            $attributes = array('id'=>'MotivacaoTrabalho9','name' => 'MotivacaoTrabalho9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, set_value('MotivacaoTrabalho9'), ($MotivacaoTrabalho9=='1' && strlen($MotivacaoTrabalho9)>0));
            echo "
                                                                                                <span>1.9 Trabalhar com pessoas</span><br />";
            $MotivacaoTrabalho10 = '';
            if (isset($hbdi -> bl_motivacao_trabalho10) && strlen($hbdi -> bl_motivacao_trabalho10) > 0) {
                $MotivacaoTrabalho10 = $hbdi -> bl_motivacao_trabalho10;
            }

            $attributes = array('id'=>'MotivacaoTrabalho10','name' => 'MotivacaoTrabalho10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho10, ($MotivacaoTrabalho10=='1' && strlen($MotivacaoTrabalho10)>0));
            echo "
                                                                                                <span>1.10 Usar números e estatísticas</span><br />";
            $MotivacaoTrabalho11 = '';
            if (isset($hbdi -> bl_motivacao_trabalho11) && strlen($hbdi -> bl_motivacao_trabalho11) > 0) {
                $MotivacaoTrabalho11 = $hbdi -> bl_motivacao_trabalho11;
            }

            $attributes = array('id'=>'MotivacaoTrabalho11','name' => 'MotivacaoTrabalho11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho11, ($MotivacaoTrabalho11=='1' && strlen($MotivacaoTrabalho11)>0));
            echo "
                                                                                                <span>1.11 Oportunidades para fazer experiências</span><br />";
            $MotivacaoTrabalho12 = '';
            if (isset($hbdi -> bl_motivacao_trabalho12) && strlen($hbdi -> bl_motivacao_trabalho12) > 0) {
                $MotivacaoTrabalho12 = $hbdi -> bl_motivacao_trabalho12;
            }

            $attributes = array('id'=>'MotivacaoTrabalho12','name' => 'MotivacaoTrabalho12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho12, ($MotivacaoTrabalho12=='1' && strlen($MotivacaoTrabalho12)>0));
            echo "
                                                                                                <span>1.12 Planejar</span><br />";
            $MotivacaoTrabalho13 = '';
            if (isset($hbdi -> bl_motivacao_trabalho13) && strlen($hbdi -> bl_motivacao_trabalho13) > 0) {
                $MotivacaoTrabalho13 = $hbdi -> bl_motivacao_trabalho13;
            }

            $attributes = array('id'=>'MotivacaoTrabalho13','name' => 'MotivacaoTrabalho13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho13, ($MotivacaoTrabalho13=='1' && strlen($MotivacaoTrabalho13)>0));
            echo "
                                                                                                <span>1.13 Trabalhar com comunicação</span><br />";
            $MotivacaoTrabalho14 = '';
            if (isset($hbdi -> bl_motivacao_trabalho14) && strlen($hbdi -> bl_motivacao_trabalho14) > 0) {
                $MotivacaoTrabalho14 = $hbdi -> bl_motivacao_trabalho14;
            }

            $attributes = array('id'=>'MotivacaoTrabalho14','name' => 'MotivacaoTrabalho14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho14, ($MotivacaoTrabalho14=='1' && strlen($MotivacaoTrabalho14)>0));
            echo "
                                                                                                <span>1.14 Fazer algo funcionar</span><br />";
            $MotivacaoTrabalho15 = '';
            if (isset($hbdi -> bl_motivacao_trabalho15) && strlen($hbdi -> bl_motivacao_trabalho15) > 0) {
                $MotivacaoTrabalho15 = $hbdi -> bl_motivacao_trabalho15;
            }

            $attributes = array('id'=>'MotivacaoTrabalho15','name' => 'MotivacaoTrabalho15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho15, ($MotivacaoTrabalho15=='1' && strlen($MotivacaoTrabalho15)>0));
            echo "
                                                                                                <span>1.15 Arriscar-se</span><br />";
            $MotivacaoTrabalho16 = '';
            if (isset($hbdi -> bl_motivacao_trabalho16) && strlen($hbdi -> bl_motivacao_trabalho16) > 0) {
                $MotivacaoTrabalho16 = $hbdi -> bl_motivacao_trabalho16;
            }

            $attributes = array('id'=>'MotivacaoTrabalho16','name' => 'MotivacaoTrabalho16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho16, ($MotivacaoTrabalho16=='1' && strlen($MotivacaoTrabalho16)>0));
            echo "
                                                                                                <span>1.16 Analisar dados</span><br />";
            $MotivacaoTrabalho17 = '';
            if (isset($hbdi -> bl_motivacao_trabalho17) && strlen($hbdi -> bl_motivacao_trabalho17) > 0) {
                $MotivacaoTrabalho17 = $hbdi -> bl_motivacao_trabalho17;
            }

            $attributes = array('id'=>'MotivacaoTrabalho17','name' => 'MotivacaoTrabalho17', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho17, ($MotivacaoTrabalho17=='1' && strlen($MotivacaoTrabalho17)>0));
            echo "
                                                                                                <span>1.17 Lidar com o futuro</span><br />";
            $MotivacaoTrabalho18 = '';
            if (isset($hbdi -> bl_motivacao_trabalho18) && strlen($hbdi -> bl_motivacao_trabalho18) > 0) {
                $MotivacaoTrabalho18 = $hbdi -> bl_motivacao_trabalho18;
            }

            $attributes = array('id'=>'MotivacaoTrabalho18','name' => 'MotivacaoTrabalho18', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho18, ($MotivacaoTrabalho18=='1' && strlen($MotivacaoTrabalho18)>0));
            echo "
                                                                                                <span>1.18 Produzir e organizar</span><br />";
            $MotivacaoTrabalho19 = '';
            if (isset($hbdi -> bl_motivacao_trabalho19) && strlen($hbdi -> bl_motivacao_trabalho19) > 0) {
                $MotivacaoTrabalho19 = $hbdi -> bl_motivacao_trabalho19;
            }

            $attributes = array('id'=>'MotivacaoTrabalho19','name' => 'MotivacaoTrabalho19', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho19, ($MotivacaoTrabalho19=='1' && strlen($MotivacaoTrabalho19)>0));
            echo "
                                                                                                <span>1.19 Fazer parte de uma equipe</span><br />";
            $MotivacaoTrabalho20 = '';
            if (isset($hbdi -> bl_motivacao_trabalho20) && strlen($hbdi -> bl_motivacao_trabalho20) > 0) {
                $MotivacaoTrabalho20 = $hbdi -> bl_motivacao_trabalho20;
            }

            $attributes = array('id'=>'MotivacaoTrabalho20','name' => 'MotivacaoTrabalho20', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $MotivacaoTrabalho20, ($MotivacaoTrabalho20=='1' && strlen($MotivacaoTrabalho20)>0));
            echo "
                                                                                                <span>1.20 Fazer as coisas sempre no prazo previsto</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("2. Quando aprendo, gosto de... ", 'Gosto');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Gosto1 = '';
            if (isset($hbdi -> bl_gosto1) && strlen($hbdi -> bl_gosto1) > 0) {
                $Gosto1 = $hbdi -> bl_gosto1;
            }

            $attributes = array('id'=>'Gosto1','name' => 'Gosto1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto1, ($Gosto1=='1' && strlen($Gosto1)>0));
            echo "
                                                                                                <span>2.1 Avaliar e testar teorias</span><br />";
            $Gosto2 = '';
            if (isset($hbdi -> bl_gosto2) && strlen($hbdi -> bl_gosto2) > 0) {
                $Gosto2 = $hbdi -> bl_gosto2;
            }

            $attributes = array('id'=>'Gosto2','name' => 'Gosto2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto2, ($Gosto2=='1' && strlen($Gosto2)>0));
            echo "
                                                                                                <span>2.2 Obter e quantificar fatos</span><br />";
            $Gosto3 = '';
            if (isset($hbdi -> bl_gosto3) && strlen($hbdi -> bl_gosto3) > 0) {
                $Gosto3 = $hbdi -> bl_gosto3;
            }

            $attributes = array('id'=>'Gosto3','name' => 'Gosto3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto3, ($Gosto3=='1' && strlen($Gosto3)>0));
            echo "
                                                                                                <span>2.3 Ouvir e compartilhar ideias</span><br />";
            $Gosto4 = '';
            if (isset($hbdi -> bl_gosto4) && strlen($hbdi -> bl_gosto4) > 0) {
                $Gosto4 = $hbdi -> bl_gosto4;
            }

            $attributes = array('id'=>'Gosto4','name' => 'Gosto4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto4, ($Gosto4=='1' && strlen($Gosto4)>0));
            echo "
                                                                                                <span>2.4 Usar minha imaginação</span><br />";
            $Gosto5 = '';
            if (isset($hbdi -> bl_gosto5) && strlen($hbdi -> bl_gosto5) > 0) {
                $Gosto5 = $hbdi -> bl_gosto5;
            }

            $attributes = array('id'=>'Gosto5','name' => 'Gosto5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto5, ($Gosto5=='1' && strlen($Gosto5)>0));
            echo "
                                                                                                <span>2.5 Aplicar análise e lógica</span><br />";
            $Gosto6 = '';
            if (isset($hbdi -> bl_gosto6) && strlen($hbdi -> bl_gosto6) > 0) {
                $Gosto6 = $hbdi -> bl_gosto6;
            }

            $attributes = array('id'=>'Gosto6','name' => 'Gosto6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto6, ($Gosto6=='1' && strlen($Gosto6)>0));
            echo "
                                                                                                <span>2.6 Ambiente bem informal</span><br />";
            $Gosto7 = '';
            if (isset($hbdi -> bl_gosto7) && strlen($hbdi -> bl_gosto7) > 0) {
                $Gosto7 = $hbdi -> bl_gosto7;
            }

            $attributes = array('id'=>'Gosto7','name' => 'Gosto7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto7, ($Gosto7=='1' && strlen($Gosto7)>0));
            echo "
                                                                                                <span>2.7 Verificar meu entendimento</span><br />";
            $Gosto8 = '';
            if (isset($hbdi -> bl_gosto8) && strlen($hbdi -> bl_gosto8) > 0) {
                $Gosto8 = $hbdi -> bl_gosto8;
            }

            $attributes = array('id'=>'Gosto8','name' => 'Gosto8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto8, ($Gosto8=='1' && strlen($Gosto8)>0));
            echo "
                                                                                                <span>2.8 Fazer experiências práticas</span><br />";
            $Gosto9 = '';
            if (isset($hbdi -> bl_gosto9) && strlen($hbdi -> bl_gosto9) > 0) {
                $Gosto9 = $hbdi -> bl_gosto9;
            }

            $attributes = array('id'=>'Gosto9','name' => 'Gosto9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto9, ($Gosto9=='1' && strlen($Gosto9)>0));
            echo "
                                                                                                <span>2.9 Pensar sobre as ideias</span><br />";
            $Gosto10 = '';
            if (isset($hbdi -> bl_gosto10) && strlen($hbdi -> bl_gosto10) > 0) {
                $Gosto10 = $hbdi -> bl_gosto10;
            }

            $attributes = array('id'=>'Gosto10','name' => 'Gosto10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto10, ($Gosto10=='1' && strlen($Gosto10)>0));
            echo "
                                                                                                <span>2.10 Confiar nas intuições</span><br />";
            $Gosto11 = '';
            if (isset($hbdi -> bl_gosto11) && strlen($hbdi -> bl_gosto11) > 0) {
                $Gosto11 = $hbdi -> bl_gosto11;
            }

            $attributes = array('id'=>'Gosto11','name' => 'Gosto11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto11, ($Gosto11=='1' && strlen($Gosto11)>0));
            echo "
                                                                                                <span>2.11 Receber informações passo a passo</span><br />";
            $Gosto12 = '';
            if (isset($hbdi -> bl_gosto12) && strlen($hbdi -> bl_gosto12) > 0) {
                $Gosto12 = $hbdi -> bl_gosto12;
            }

            $attributes = array('id'=>'Gosto12','name' => 'Gosto12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto12, ($Gosto12=='1' && strlen($Gosto12)>0));
            echo "
                                                                                                <span>2.12 Tomar iniciativas</span><br />";
            $Gosto13 = '';
            if (isset($hbdi -> bl_gosto13) && strlen($hbdi -> bl_gosto13) > 0) {
                $Gosto13 = $hbdi -> bl_gosto13;
            }

            $attributes = array('id'=>'Gosto13','name' => 'Gosto13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto13, ($Gosto13=='1' && strlen($Gosto13)>0));
            echo "
                                                                                                <span>2.13 Elaborar teorias</span><br />";
            $Gosto14 = '';
            if (isset($hbdi -> bl_gosto14) && strlen($hbdi -> bl_gosto14) > 0) {
                $Gosto14 = $hbdi -> bl_gosto14;
            }

            $attributes = array('id'=>'Gosto14','name' => 'Gosto14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto14, ($Gosto14=='1' && strlen($Gosto14)>0));
            echo "
                                                                                                <span>2.14 Envolvimento emocional</span><br />";
            $Gosto15 = '';
            if (isset($hbdi -> bl_gosto15) && strlen($hbdi -> bl_gosto15) > 0) {
                $Gosto15 = $hbdi -> bl_gosto15;
            }

            $attributes = array('id'=>'Gosto15','name' => 'Gosto15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto15, ($Gosto15=='1' && strlen($Gosto15)>0));
            echo "
                                                                                                <span>2.15 Trabalhar em grupo</span><br />";
            $Gosto16 = '';
            if (isset($hbdi -> bl_gosto16) && strlen($hbdi -> bl_gosto16) > 0) {
                $Gosto16 = $hbdi -> bl_gosto16;
            }
            if (strlen(set_value('Gosto16')) > 0) {
                $Gosto16 = set_value('Gosto16');
            }
            $attributes = array('id'=>'Gosto16','name' => 'Gosto16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto16, ($Gosto16=='1' && strlen($Gosto16)>0));
            echo "
                                                                                                <span>2.16 Orientações claras</span><br />";
            $Gosto17 = '';
            if (isset($hbdi -> bl_gosto17) && strlen($hbdi -> bl_gosto17) > 0) {
                $Gosto17 = $hbdi -> bl_gosto17;
            }
            if (strlen(set_value('Gosto17')) > 0) {
                $Gosto17 = set_value('Gosto17');
            }
            $attributes = array('id'=>'Gosto17','name' => 'Gosto17', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto17, ($Gosto17=='1' && strlen($Gosto17)>0));
            echo "
                                                                                                <span>2.17 Fazer descobertas</span><br />";
            $Gosto18 = '';
            if (isset($hbdi -> bl_gosto18) && strlen($hbdi -> bl_gosto18) > 0) {
                $Gosto18 = $hbdi -> bl_gosto18;
            }
            if (strlen(set_value('Gosto18')) > 0) {
                $Gosto18 = set_value('Gosto18');
            }
            $attributes = array('id'=>'Gosto18','name' => 'Gosto18', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto18, ($Gosto18=='1' && strlen($Gosto18)>0));
            echo "
                                                                                                <span>2.18 Criticar</span><br />";
            $Gosto19 = '';
            if (isset($hbdi -> bl_gosto19) && strlen($hbdi -> bl_gosto19) > 0) {
                $Gosto19 = $hbdi -> bl_gosto19;
            }
            if (strlen(set_value('Gosto19')) > 0) {
                $Gosto19 = set_value('Gosto19');
            }
            $attributes = array('id'=>'Gosto19','name' => 'Gosto19', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto19, ($Gosto19=='1' && strlen($Gosto19)>0));
            echo "
                                                                                                <span>2.19 Perceber logo o quadro geral (o objetivo final)</span><br />";
            $Gosto20 = '';
            if (isset($hbdi -> bl_gosto20) && strlen($hbdi -> bl_gosto20) > 0) {
                $Gosto20 = $hbdi -> bl_gosto20;
            }
            if (strlen(set_value('Gosto20')) > 0) {
                $Gosto20 = set_value('Gosto20');
            }
            $attributes = array('id'=>'Gosto20','name' => 'Gosto20', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Gosto20, ($Gosto20=='1' && strlen($Gosto20)>0));
            echo "
                                                                                                <span>2.20 Adquirir habilidades pela prática</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("3. Prefiro aprender por meio de… ", 'Prefiro');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Prefiro1 = '';
            if (isset($hbdi -> bl_prefiro1) && strlen($hbdi -> bl_prefiro1) > 0) {
                $Prefiro1 = $hbdi -> bl_prefiro1;
            }

            $attributes = array('id'=>'Prefiro1','name' => 'Prefiro1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro1, ($Prefiro1=='1' && strlen($Prefiro1)>0));
            echo "
                                                                                                <span>3.1 Materiais visuais</span><br />";
            $Prefiro2 = '';
            if (isset($hbdi -> bl_prefiro2) && strlen($hbdi -> bl_prefiro2) > 0) {
                $Prefiro2 = $hbdi -> bl_prefiro2;
            }

            $attributes = array('id'=>'Prefiro2','name' => 'Prefiro2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro2, ($Prefiro2=='1' && strlen($Prefiro2)>0));
            echo "
                                                                                                <span>3.2 Demonstrações</span><br />";
            $Prefiro3 = '';
            if (isset($hbdi -> bl_prefiro3) && strlen($hbdi -> bl_prefiro3) > 0) {
                $Prefiro3 = $hbdi -> bl_prefiro3;
            }

            $attributes = array('id'=>'Prefiro3','name' => 'Prefiro3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro3, ($Prefiro3=='1' && strlen($Prefiro3)>0));
            echo "
                                                                                                <span>3.3 Debates estruturados pelo instrutor</span><br />";
            $Prefiro4 = '';
            if (isset($hbdi -> bl_prefiro4) && strlen($hbdi -> bl_prefiro4) > 0) {
                $Prefiro4 = $hbdi -> bl_prefiro4;
            }

            $attributes = array('id'=>'Prefiro4','name' => 'Prefiro4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro4, ($Prefiro4=='1' && strlen($Prefiro4)>0));
            echo "
                                                                                                <span>3.4 Palestras formais</span><br />";
            $Prefiro5 = '';
            if (isset($hbdi -> bl_prefiro5) && strlen($hbdi -> bl_prefiro5) > 0) {
                $Prefiro5 = $hbdi -> bl_prefiro5;
            }

            $attributes = array('id'=>'Prefiro5','name' => 'Prefiro5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro5, ($Prefiro5=='1' && strlen($Prefiro5)>0));
            echo "
                                                                                                <span>3.5 Experiências</span><br />";
            $Prefiro6 = '';
            if (isset($hbdi -> bl_prefiro6) && strlen($hbdi -> bl_prefiro6) > 0) {
                $Prefiro6 = $hbdi -> bl_prefiro6;
            }

            $attributes = array('id'=>'Prefiro6','name' => 'Prefiro6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro6, ($Prefiro6=='1' && strlen($Prefiro6)>0));
            echo "
                                                                                                <span>3.6 Utilizando histórias e música</span><br />";
            $Prefiro7 = '';
            if (isset($hbdi -> bl_prefiro7) && strlen($hbdi -> bl_prefiro7) > 0) {
                $Prefiro7 = $hbdi -> bl_prefiro7;
            }

            $attributes = array('id'=>'Prefiro7','name' => 'Prefiro7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro7, ($Prefiro7=='1' && strlen($Prefiro7)>0));
            echo "
                                                                                                <span>3.7 Exercícios que usam a intuição</span><br />";
            $Prefiro8 = '';
            if (isset($hbdi -> bl_prefiro8) && strlen($hbdi -> bl_prefiro8) > 0) {
                $Prefiro8 = $hbdi -> bl_prefiro8;
            }

            $attributes = array('id'=>'Prefiro8','name' => 'Prefiro8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro8, ($Prefiro8=='1' && strlen($Prefiro8)>0));
            echo "
                                                                                                <span>3.8 Debate em grupo</span><br />";
            $Prefiro9 = '';
            if (isset($hbdi -> bl_prefiro9) && strlen($hbdi -> bl_prefiro9) > 0) {
                $Prefiro9 = $hbdi -> bl_prefiro9;
            }

            $attributes = array('id'=>'Prefiro9','name' => 'Prefiro9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro9, ($Prefiro9=='1' && strlen($Prefiro9)>0));
            echo "
                                                                                                <span>3.9 Exercícios de análise</span><br />";
            $Prefiro10 = '';
            if (isset($hbdi -> bl_prefiro10) && strlen($hbdi -> bl_prefiro10) > 0) {
                $Prefiro10 = $hbdi -> bl_prefiro10;
            }

            $attributes = array('id'=>'Prefiro10','name' => 'Prefiro10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro10, ($Prefiro10=='1' && strlen($Prefiro10)>0));
            echo "
                                                                                                <span>3.10 Atividades sequenciais bem planejadas</span><br />";
            $Prefiro11 = '';
            if (isset($hbdi -> bl_prefiro11) && strlen($hbdi -> bl_prefiro11) > 0) {
                $Prefiro11 = $hbdi -> bl_prefiro11;
            }

            $attributes = array('id'=>'Prefiro11','name' => 'Prefiro11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro11, ($Prefiro11=='1' && strlen($Prefiro11)>0));
            echo "
                                                                                                <span>3.11 Analisando números; dados e fatos</span><br />";
            $Prefiro12 = '';
            if (isset($hbdi -> bl_prefiro12) && strlen($hbdi -> bl_prefiro12) > 0) {
                $Prefiro12 = $hbdi -> bl_prefiro12;
            }

            $attributes = array('id'=>'Prefiro12','name' => 'Prefiro12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro12, ($Prefiro12=='1' && strlen($Prefiro12)>0));
            echo "
                                                                                                <span>3.12 Exemplos com metáforas</span><br />";
            $Prefiro13 = '';
            if (isset($hbdi -> bl_prefiro13) && strlen($hbdi -> bl_prefiro13) > 0) {
                $Prefiro13 = $hbdi -> bl_prefiro13;
            }

            $attributes = array('id'=>'Prefiro13','name' => 'Prefiro13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, set_value('Prefiro13'), (set_value('Prefiro13')=='1' && strlen(set_value('Prefiro13'))>0));
            echo "
                                                                                                <span>3.13 Atividades passo a passo de reforço do conteúdo</span><br />";
            $Prefiro14 = '';
            if (isset($hbdi -> bl_prefiro14) && strlen($hbdi -> bl_prefiro14) > 0) {
                $Prefiro14 = $hbdi -> bl_prefiro14;
            }

            $attributes = array('id'=>'Prefiro14','name' => 'Prefiro14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro14, ($Prefiro14=='1' && strlen($Prefiro14)>0));
            echo "
                                                                                                <span>3.14 Leitura de livros-textos</span><br />";
            $Prefiro15 = '';
            if (isset($hbdi -> bl_prefiro15) && strlen($hbdi -> bl_prefiro15) > 0) {
                $Prefiro15 = $hbdi -> bl_prefiro15;
            }

            $attributes = array('id'=>'Prefiro15','name' => 'Prefiro15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro15, ($Prefiro15=='1' && strlen($Prefiro15)>0));
            echo "
                                                                                                <span>3.15 Discussões de casos voltados para as pessoas</span><br />";
            $Prefiro16 = '';
            if (isset($hbdi -> bl_prefiro16) && strlen($hbdi -> bl_prefiro16) > 0) {
                $Prefiro16 = $hbdi -> bl_prefiro16;
            }

            $attributes = array('id'=>'Prefiro16','name' => 'Prefiro16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro16, ($Prefiro16=='1' && strlen($Prefiro16)>0));
            echo "
                                                                                                <span>3.16 Discussões de casos voltados para os números e fatos</span><br />";
            $Prefiro17 = '';
            if (isset($hbdi -> bl_prefiro17) && strlen($hbdi -> bl_prefiro17) > 0) {
                $Prefiro17 = $hbdi -> bl_prefiro17;
            }

            $attributes = array('id'=>'Prefiro17','name' => 'Prefiro17', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro17, ($Prefiro17=='1' && strlen($Prefiro17)>0));
            echo "
                                                                                                <span>3.17 Métodos tradicionais comprovados</span><br />";
            $Prefiro18 = '';
            if (isset($hbdi -> bl_prefiro18) && strlen($hbdi -> bl_prefiro18) > 0) {
                $Prefiro18 = $hbdi -> bl_prefiro18;
            }

            $attributes = array('id'=>'Prefiro18','name' => 'Prefiro18', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro18, ($Prefiro18=='1' && strlen($Prefiro18)>0));
            echo "
                                                                                                <span>3.18 Agenda bem flexível</span><br />";
            $Prefiro19 = '';
            if (isset($hbdi -> bl_prefiro19) && strlen($hbdi -> bl_prefiro19) > 0) {
                $Prefiro19 = $hbdi -> bl_prefiro19;
            }

            $attributes = array('id'=>'Prefiro19','name' => 'Prefiro19', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro19, ($Prefiro19=='1' && strlen($Prefiro19)>0));
            echo "
                                                                                                <span>3.19 Agenda estruturada com antecedência</span><br />";
            $Prefiro20 = '';
            if (isset($hbdi -> bl_prefiro20) && strlen($hbdi -> bl_prefiro20) > 0) {
                $Prefiro20 = $hbdi -> bl_prefiro20;
            }

            $attributes = array('id'=>'Prefiro20','name' => 'Prefiro20', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Prefiro20, ($Prefiro20=='1' && strlen($Prefiro20)>0));
            echo "
                                                                                                <span>3.20 Trabalhos bem estruturados</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("4. Qual o tipo de pergunta que você mais gosta de fazer?", 'Pergunta');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";
            $Pergunta = '';
            if (isset($hbdi -> in_pergunta) && strlen($hbdi -> in_pergunta) > 0) {
                $Pergunta = $hbdi -> in_pergunta;
            }


            $attributes = array('id'=>'Pergunta1','name' => 'Pergunta', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='1' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.1 O que?</span><br />";
            $attributes = array('id'=>'Pergunta2','name' => 'Pergunta', 'value' => '2','disabled'=>"disabled");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='2' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.2 Como?</span><br />";
            $attributes = array('id'=>'Pergunta3','name' => 'Pergunta', 'value' => '3','disabled'=>"disabled");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='3' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.3 Por que?</span><br />";
            $attributes = array('id'=>'Pergunta4','name' => 'Pergunta', 'value' => '4','disabled'=>"disabled");
            echo form_checkbox($attributes, $Pergunta, ($Pergunta=='4' && strlen($Pergunta)>0));
            echo "
                                                                                                <span>4.4 Quem?</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("5. O que você mais gosta de fazer?", 'Fazer');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Fazer1 = '';
            if (isset($hbdi -> bl_fazer1) && strlen($hbdi -> bl_fazer1) > 0) {
                $Fazer1 = $hbdi -> bl_fazer1;
            }

            $attributes = array('id'=>'Fazer1','name' => 'Fazer1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer1, ($Fazer1=='1' && strlen($Fazer1)>0));
            echo "
                                                                                                <span>5.1 Descobrir</span><br />";
            $Fazer2 = '';
            if (isset($hbdi -> bl_fazer2) && strlen($hbdi -> bl_fazer2) > 0) {
                $Fazer2 = $hbdi -> bl_fazer2;
            }

            $attributes = array('id'=>'Fazer2','name' => 'Fazer2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer2, ($Fazer2=='1' && strlen($Fazer2)>0));
            echo "
                                                                                                <span>5.2 Quantificar</span><br />";
            $Fazer3 = '';
            if (isset($hbdi -> bl_fazer3) && strlen($hbdi -> bl_fazer3) > 0) {
                $Fazer3 = $hbdi -> bl_fazer3;
            }

            $attributes = array('id'=>'Fazer3','name' => 'Fazer3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer3, ($Fazer3=='1' && strlen($Fazer3)>0));
            echo "
                                                                                                <span>5.3 Envolver</span><br />";
            $Fazer4 = '';
            if (isset($hbdi -> bl_fazer4) && strlen($hbdi -> bl_fazer4) > 0) {
                $Fazer4 = $hbdi -> bl_fazer4;
            }

            $attributes = array('id'=>'Fazer4','name' => 'Fazer4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer4, ($Fazer4=='1' && strlen($Fazer4)>0));
            echo "
                                                                                                <span>5.4 Organizar</span><br />";
            $Fazer5 = '';
            if (isset($hbdi -> bl_fazer5) && strlen($hbdi -> bl_fazer5) > 0) {
                $Fazer5 = $hbdi -> bl_fazer5;
            }

            $attributes = array('id'=>'Fazer5','name' => 'Fazer5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer5, ($Fazer5=='1' && strlen($Fazer5)>0));
            echo "
                                                                                                <span>5.5 Conceituar</span><br />";
            $Fazer6 = '';
            if (isset($hbdi -> bl_fazer6) && strlen($hbdi -> bl_fazer6) > 0) {
                $Fazer6 = $hbdi -> bl_fazer6;
            }

            $attributes = array('id'=>'Fazer6','name' => 'Fazer6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer6, ($Fazer6=='1' && strlen($Fazer6)>0));
            echo "
                                                                                                <span>5.6 Analisar</span><br />";
            $Fazer7 = '';
            if (isset($hbdi -> bl_fazer7) && strlen($hbdi -> bl_fazer7) > 0) {
                $Fazer7 = $hbdi -> bl_fazer7;
            }

            $attributes = array('id'=>'Fazer7','name' => 'Fazer7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer7, ($Fazer7=='1' && strlen($Fazer7)>0));
            echo "
                                                                                                <span>5.7 Sentir</span><br />";
            $Fazer8 = '';
            if (isset($hbdi -> bl_fazer8) && strlen($hbdi -> bl_fazer8) > 0) {
                $Fazer8 = $hbdi -> bl_fazer8;
            }

            $attributes = array('id'=>'Fazer8','name' => 'Fazer8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer8, ($Fazer8=='1' && strlen($Fazer8)>0));
            echo "
                                                                                                <span>5.8 Praticar</span><br />";
            $Fazer9 = '';
            if (isset($hbdi -> bl_fazer9) && strlen($hbdi -> bl_fazer9) > 0) {
                $Fazer9 = $hbdi -> bl_fazer9;
            }

            $attributes = array('id'=>'Fazer9','name' => 'Fazer9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer9, ($Fazer9=='1' && strlen($Fazer9)>0));
            echo "
                                                                                                <span>5.9 Teorizar</span><br />";
            $Fazer10 = '';
            if (isset($hbdi -> bl_fazer10) && strlen($hbdi -> bl_fazer10) > 0) {
                $Fazer10 = $hbdi -> bl_fazer10;
            }

            $attributes = array('id'=>'Fazer10','name' => 'Fazer10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer10, ($Fazer10=='1' && strlen($Fazer10)>0));
            echo "
                                                                                                <span>5.10 Sintetizar</span><br />";
            $Fazer11 = '';
            if (isset($hbdi -> bl_fazer11) && strlen($hbdi -> bl_fazer11) > 0) {
                $Fazer11 = $hbdi -> bl_fazer11;
            }

            $attributes = array('id'=>'Fazer11','name' => 'Fazer11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer11, ($Fazer11=='1' && strlen($Fazer11)>0));
            echo "
                                                                                                <span>5.11 Avaliar</span><br />";
            $Fazer12 = '';
            if (isset($hbdi -> bl_fazer12) && strlen($hbdi -> bl_fazer12) > 0) {
                $Fazer12 = $hbdi -> bl_fazer12;
            }

            $attributes = array('id'=>'Fazer12','name' => 'Fazer12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer12, ($Fazer12=='1' && strlen($Fazer12)>0));
            echo "
                                                                                                <span>5.12 Interiorizar</span><br />";
            $Fazer13 = '';
            if (isset($hbdi -> bl_fazer13) && strlen($hbdi -> bl_fazer13) > 0) {
                $Fazer13 = $hbdi -> bl_fazer13;
            }

            $attributes = array('id'=>'Fazer13','name' => 'Fazer13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer13, ($Fazer13=='1' && strlen($Fazer13)>0));
            echo "
                                                                                                <span>5.13 Processar</span><br />";
            $Fazer14 = '';
            if (isset($hbdi -> bl_fazer14) && strlen($hbdi -> bl_fazer14) > 0) {
                $Fazer14 = $hbdi -> bl_fazer14;
            }

            $attributes = array('id'=>'Fazer14','name' => 'Fazer14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer14, ($Fazer14=='1' && strlen($Fazer14)>0));
            echo "
                                                                                                <span>5.14 Ordenar</span><br />";
            $Fazer15 = '';
            if (isset($hbdi -> bl_fazer15) && strlen($hbdi -> bl_fazer15) > 0) {
                $Fazer15 = $hbdi -> bl_fazer15;
            }

            $attributes = array('id'=>'Fazer15','name' => 'Fazer15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer15, ($Fazer15=='1' && strlen($Fazer15)>0));
            echo "
                                                                                                <span>5.15 Explorar</span><br />";
            $Fazer16 = '';
            if (isset($hbdi -> bl_fazer16) && strlen($hbdi -> bl_fazer16) > 0) {
                $Fazer16 = $hbdi -> bl_fazer16;
            }

            $attributes = array('id'=>'Fazer16','name' => 'Fazer16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Fazer16, ($Fazer16=='1' && strlen($Fazer16)>0));
            echo "
                                                                                                <span>5.16 Compartilhar</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("6. Ao comprar um carro você…", 'Comprar');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Comprar1 = '';
            if (isset($hbdi -> bl_comprar1) && strlen($hbdi -> bl_comprar1) > 0) {
                $Comprar1 = $hbdi -> bl_comprar1;
            }

            $attributes = array('id'=>'Comprar1','name' => 'Comprar1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar1, ($Comprar1=='1' && strlen($Comprar1)>0));
            echo "
                                                                                                <span>6.1 Compra com base na recomendação de amigos</span><br />";
            $Comprar2 = '';
            if (isset($hbdi -> bl_comprar2) && strlen($hbdi -> bl_comprar2) > 0) {
                $Comprar2 = $hbdi -> bl_comprar2;
            }

            $attributes = array('id'=>'Comprar2','name' => 'Comprar2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar2, ($Comprar2=='1' && strlen($Comprar2)>0));
            echo "
                                                                                                <span>6.2 Se preocupa com o consumo de combustível</span><br />";
            $Comprar3 = '';
            if (isset($hbdi -> bl_comprar3) && strlen($hbdi -> bl_comprar3) > 0) {
                $Comprar3 = $hbdi -> bl_comprar3;
            }

            $attributes = array('id'=>'Comprar3','name' => 'Comprar3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar3, ($Comprar3=='1' && strlen($Comprar3)>0));
            echo "
                                                                                                <span>6.3 Se preocupa com as forma; a cor e a tecnologia</span><br />";
            $Comprar4 = '';
            if (isset($hbdi -> bl_comprar4) && strlen($hbdi -> bl_comprar4) > 0) {
                $Comprar4 = $hbdi -> bl_comprar4;
            }

            $attributes = array('id'=>'Comprar4','name' => 'Comprar4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar4, ($Comprar4=='1' && strlen($Comprar4)>0));
            echo "
                                                                                                <span>6.4 Verifica equipamento de segurança e durabilidade</span><br />";
            $Comprar5 = '';
            if (isset($hbdi -> bl_comprar5) && strlen($hbdi -> bl_comprar5) > 0) {
                $Comprar5 = $hbdi -> bl_comprar5;
            }

            $attributes = array('id'=>'Comprar5','name' => 'Comprar5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar5, ($Comprar5=='1' && strlen($Comprar5)>0));
            echo "
                                                                                                <span>6.5 Dá importância à \"sensação\" de conforto do veículo</span><br />";
            $Comprar6 = '';
            if (isset($hbdi -> bl_comprar6) && strlen($hbdi -> bl_comprar6) > 0) {
                $Comprar6 = $hbdi -> bl_comprar6;
            }

            $attributes = array('id'=>'Comprar6','name' => 'Comprar6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar6, ($Comprar6=='1' && strlen($Comprar6)>0));
            echo "
                                                                                                <span>6.6 Faz comparações com outros veículos</span><br />";
            $Comprar7 = '';
            if (isset($hbdi -> bl_comprar7) && strlen($hbdi -> bl_comprar7) > 0) {
                $Comprar7 = $hbdi -> bl_comprar7;
            }

            $attributes = array('id'=>'Comprar7','name' => 'Comprar7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar7, ($Comprar7=='1' && strlen($Comprar7)>0));
            echo "
                                                                                                <span>6.7 Verificar tamanho do porta-malas</span><br />";
            $Comprar8 = '';
            if (isset($hbdi -> bl_comprar8) && strlen($hbdi -> bl_comprar8) > 0) {
                $Comprar8 = $hbdi -> bl_comprar8;
            }

            $attributes = array('id'=>'Comprar8','name' => 'Comprar8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar8, ($Comprar8=='1' && strlen($Comprar8)>0));
            echo "
                                                                                                <span>6.8 Verifica se encaixa no seu sonho de vida</span><br />";
            $Comprar9 = '';
            if (isset($hbdi -> bl_comprar9) && strlen($hbdi -> bl_comprar9) > 0) {
                $Comprar9 = $hbdi -> bl_comprar9;
            }

            $attributes = array('id'=>'Comprar9','name' => 'Comprar9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar9, ($Comprar9=='1' && strlen($Comprar9)>0));
            echo "
                                                                                                <span>6.9 Pesquisa e planeja antecipadamente como vai utilizá-lo</span><br />";
            $Comprar10 = '';
            if (isset($hbdi -> bl_comprar10) && strlen($hbdi -> bl_comprar10) > 0) {
                $Comprar10 = $hbdi -> bl_comprar10;
            }

            $attributes = array('id'=>'Comprar10','name' => 'Comprar10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar10, ($Comprar10=='1' && strlen($Comprar10)>0));
            echo "
                                                                                                <span>6.10 Se preocupa com o custo e o valor de troca</span><br />";
            $Comprar11 = '';
            if (isset($hbdi -> bl_comprar11) && strlen($hbdi -> bl_comprar11) > 0) {
                $Comprar11 = $hbdi -> bl_comprar11;
            }

            $attributes = array('id'=>'Comprar11','name' => 'Comprar11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar11, ($Comprar11=='1' && strlen($Comprar11)>0));
            echo "
                                                                                                <span>6.11 Quer \"amar\" o carro</span><br />";
            $Comprar12 = '';
            if (isset($hbdi -> bl_comprar12) && strlen($hbdi -> bl_comprar12) > 0) {
                $Comprar12 = $hbdi -> bl_comprar12;
            }

            $attributes = array('id'=>'Comprar12','name' => 'Comprar12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar12, ($Comprar12=='1' && strlen($Comprar12)>0));
            echo "
                                                                                                <span>6.12 Prefere carros lançados recentemente</span><br />";
            $Comprar13 = '';
            if (isset($hbdi -> bl_comprar13) && strlen($hbdi -> bl_comprar13) > 0) {
                $Comprar13 = $hbdi -> bl_comprar13;
            }

            $attributes = array('id'=>'Comprar13','name' => 'Comprar13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar13, ($Comprar13=='1' && strlen($Comprar13)>0));
            echo "
                                                                                                <span>6.13 Se preocupa com os requisitos técnicos</span><br />";
            $Comprar14 = '';
            if (isset($hbdi -> bl_comprar14) && strlen($hbdi -> bl_comprar14) > 0) {
                $Comprar14 = $hbdi -> bl_comprar14;
            }

            $attributes = array('id'=>'Comprar14','name' => 'Comprar14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar14, ($Comprar14=='1' && strlen($Comprar14)>0));
            echo "
                                                                                                <span>6.14 Verifica a facilidade de manutenção</span><br />";
            $Comprar15 = '';
            if (isset($hbdi -> bl_comprar15) && strlen($hbdi -> bl_comprar15) > 0) {
                $Comprar15 = $hbdi -> bl_comprar15;
            }

            $attributes = array('id'=>'Comprar15','name' => 'Comprar15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar15, ($Comprar15=='1' && strlen($Comprar15)>0));
            echo "
                                                                                                <span>6.15 Gosta de experimentar um novo modelo ou fabricante</span><br />";
            $Comprar16 = '';
            if (isset($hbdi -> bl_comprar16) && strlen($hbdi -> bl_comprar16) > 0) {
                $Comprar16 = $hbdi -> bl_comprar16;
            }

            $attributes = array('id'=>'Comprar16','name' => 'Comprar16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar16, ($Comprar16=='1' && strlen($Comprar16)>0));
            echo "
                                                                                                <span>6.16 Se preocupa com o nome do fabricante</span><br />";
            $Comprar17 = '';
            if (isset($hbdi -> bl_comprar17) && strlen($hbdi -> bl_comprar17) > 0) {
                $Comprar17 = $hbdi -> bl_comprar17;
            }

            $attributes = array('id'=>'Comprar17','name' => 'Comprar17', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar17, ($Comprar17=='1' && strlen($Comprar17)>0));
            echo "
                                                                                                <span>6.17 Dá importância à opinião das pessoas</span><br />";
            $Comprar18 = '';
            if (isset($hbdi -> bl_comprar18) && strlen($hbdi -> bl_comprar18) > 0) {
                $Comprar18 = $hbdi -> bl_comprar18;
            }

            $attributes = array('id'=>'Comprar18','name' => 'Comprar18', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar18, ($Comprar18=='1' && strlen($Comprar18)>0));
            echo "
                                                                                                <span>6.18 Quer ver dados e estatísticas sobre o desempenho</span><br />";
            $Comprar19 = '';
            if (isset($hbdi -> bl_comprar19) && strlen($hbdi -> bl_comprar19) > 0) {
                $Comprar19 = $hbdi -> bl_comprar19;
            }

            $attributes = array('id'=>'Comprar19','name' => 'Comprar19', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar19, ($Comprar19=='1' && strlen($Comprar19)>0));
            echo "
                                                                                                <span>6.19 Se preocupa com a qualidade do atendimento do revendedor</span><br />";
            $Comprar20 = '';
            if (isset($hbdi -> bl_comprar20) && strlen($hbdi -> bl_comprar20) > 0) {
                $Comprar20 = $hbdi -> bl_comprar20;
            }

            $attributes = array('id'=>'Comprar20','name' => 'Comprar20', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comprar20, ($Comprar20=='1' && strlen($Comprar20)>0));
            echo "
                                                                                                <span>6.20 Analisa como o carro vai ser útil no seu dia-a-dia</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("7. Como você define seu comportamento?", 'Comportamento');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Comportamento = '';
            if (isset($hbdi -> in_comportamento) && strlen($hbdi -> in_comportamento) > 0) {
                $Comportamento = $hbdi -> in_comportamento;
            }

            $attributes = array('id'=>'Comportamento1','name' => 'Comportamento', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='1' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.1 Gosto de organizar</span><br />";
            $attributes = array('id'=>'Comportamento2','name' => 'Comportamento', 'value' => '2','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='2' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.2 Gosto de compartilhar</span><br />";
            $attributes = array('id'=>'Comportamento3','name' => 'Comportamento', 'value' => '3','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='3' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.3 Gosto de analisar</span><br />";
            $attributes = array('id'=>'Comportamento4','name' => 'Comportamento', 'value' => '4','disabled'=>"disabled");
            echo form_checkbox($attributes, $Comportamento, ($Comportamento=='4' && strlen($Comportamento)>0));
            echo "
                                                                                                <span>7.4 Gosto de descobrir</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("8. Palavras que definem meu estilo...", 'Estilo');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Estilo1 = '';
            if (isset($hbdi -> bl_estilo1) && strlen($hbdi -> bl_estilo1) > 0) {
                $Estilo1 = $hbdi -> bl_estilo1;
            }

            $attributes = array('id'=>'Estilo1','name' => 'Estilo1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo1, ($Estilo1=='1' && strlen($Estilo1)>0));
            echo "
                                                                                                <span>8.1 Organizado</span><br />";
            $Estilo2 = '';
            if (isset($hbdi -> bl_estilo2) && strlen($hbdi -> bl_estilo2) > 0) {
                $Estilo2 = $hbdi -> bl_estilo2;
            }

            $attributes = array('id'=>'Estilo2','name' => 'Estilo2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo2, ($Estilo2=='1' && strlen($Estilo2)>0));
            echo "
                                                                                                <span>8.2 Analítico</span><br />";
            $Estilo3 = '';
            if (isset($hbdi -> bl_estilo3) && strlen($hbdi -> bl_estilo3) > 0) {
                $Estilo3 = $hbdi -> bl_estilo3;
            }

            $attributes = array('id'=>'Estilo3','name' => 'Estilo3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo3, ($Estilo3=='1' && strlen($Estilo3)>0));
            echo "
                                                                                                <span>8.3 Emocional</span><br />";
            $Estilo4 = '';
            if (isset($hbdi -> bl_estilo4) && strlen($hbdi -> bl_estilo4) > 0) {
                $Estilo4 = $hbdi -> bl_estilo4;
            }

            $attributes = array('id'=>'Estilo4','name' => 'Estilo4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo4, ($Estilo4=='1' && strlen($Estilo4)>0));
            echo "
                                                                                                <span>8.4 Experimental</span><br />";
            $Estilo5 = '';
            if (isset($hbdi -> bl_estilo5) && strlen($hbdi -> bl_estilo5) > 0) {
                $Estilo5 = $hbdi -> bl_estilo5;
            }

            $attributes = array('id'=>'Estilo5','name' => 'Estilo5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo5, ($Estilo5=='1' && strlen($Estilo5)>0));
            echo "
                                                                                                <span>8.5 Lógico</span><br />";
            $Estilo6 = '';
            if (isset($hbdi -> bl_estilo6) && strlen($hbdi -> bl_estilo6) > 0) {
                $Estilo6 = $hbdi -> bl_estilo6;
            }

            $attributes = array('id'=>'Estilo6','name' => 'Estilo6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo6, ($Estilo6=='1' && strlen($Estilo6)>0));
            echo "
                                                                                                <span>8.6 Conceitual</span><br />";
            $Estilo7 = '';
            if (isset($hbdi -> bl_estilo7) && strlen($hbdi -> bl_estilo7) > 0) {
                $Estilo7 = $hbdi -> bl_estilo7;
            }

            $attributes = array('id'=>'Estilo7','name' => 'Estilo7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo7, ($Estilo7=='1' && strlen($Estilo7)>0));
            echo "
                                                                                                <span>8.7 Perceptivo</span><br />";
            $Estilo8 = '';
            if (isset($hbdi -> bl_estilo8) && strlen($hbdi -> bl_estilo8) > 0) {
                $Estilo8 = $hbdi -> bl_estilo8;
            }

            $attributes = array('id'=>'Estilo8','name' => 'Estilo8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo8, ($Estilo8=='1' && strlen($Estilo8)>0));
            echo "
                                                                                                <span>8.8 Sequencial</span><br />";
            $Estilo9 = '';
            if (isset($hbdi -> bl_estilo9) && strlen($hbdi -> bl_estilo9) > 0) {
                $Estilo9 = $hbdi -> bl_estilo9;
            }

            $attributes = array('id'=>'Estilo9','name' => 'Estilo9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo9, ($Estilo9=='1' && strlen($Estilo9)>0));
            echo "
                                                                                                <span>8.9 Teórico</span><br />";
            $Estilo10 = '';
            if (isset($hbdi -> bl_estilo10) && strlen($hbdi -> bl_estilo10) > 0) {
                $Estilo10 = $hbdi -> bl_estilo10;
            }

            $attributes = array('id'=>'Estilo10','name' => 'Estilo10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo10, ($Estilo10=='1' && strlen($Estilo10)>0));
            echo "
                                                                                                <span>8.10 Explorador</span><br />";
            $Estilo11 = '';
            if (isset($hbdi -> bl_estilo11) && strlen($hbdi -> bl_estilo11) > 0) {
                $Estilo11 = $hbdi -> bl_estilo11;
            }

            $attributes = array('id'=>'Estilo11','name' => 'Estilo11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo11, ($Estilo11=='1' && strlen($Estilo11)>0));
            echo "
                                                                                                <span>8.11 Avaliador</span><br />";
            $Estilo12 = '';
            if (isset($hbdi -> bl_estilo12) && strlen($hbdi -> bl_estilo12) > 0) {
                $Estilo12 = $hbdi -> bl_estilo12;
            }

            $attributes = array('id'=>'Estilo12','name' => 'Estilo12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo12, ($Estilo12=='1' && strlen($Estilo12)>0));
            echo "
                                                                                                <span>8.12 Cinestésico</span><br />";
            $Estilo13 = '';
            if (isset($hbdi -> bl_estilo13) && strlen($hbdi -> bl_estilo13) > 0) {
                $Estilo13 = $hbdi -> bl_estilo13;
            }

            $attributes = array('id'=>'Estilo13','name' => 'Estilo13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo13, ($Estilo13=='1' && strlen($Estilo13)>0));
            echo "
                                                                                                <span>8.13 Sentimental</span><br />";
            $Estilo14 = '';
            if (isset($hbdi -> bl_estilo14) && strlen($hbdi -> bl_estilo14) > 0) {
                $Estilo14 = $hbdi -> bl_estilo14;
            }

            $attributes = array('id'=>'Estilo14','name' => 'Estilo14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo14, ($Estilo14=='1' && strlen($Estilo14)>0));
            echo "
                                                                                                <span>8.14 Preparado</span><br />";
            $Estilo15 = '';
            if (isset($hbdi -> bl_estilo15) && strlen($hbdi -> bl_estilo15) > 0) {
                $Estilo15 = $hbdi -> bl_estilo15;
            }

            $attributes = array('id'=>'Estilo15','name' => 'Estilo15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo15, ($Estilo15='1' && strlen($Estilo15)>0));
            echo "
                                                                                                <span>8.15 Quantitativo</span><br />";
            $Estilo16 = '';
            if (isset($hbdi -> bl_estilo16) && strlen($hbdi -> bl_estilo16) > 0) {
                $Estilo16 = $hbdi -> bl_estilo16;
            }

            $attributes = array('id'=>'Estilo16','name' => 'Estilo16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Estilo16, ($Estilo16=='1' && strlen($Estilo16)>0));
            echo "
                                                                                                <span>8.16 Sintético</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("9. Quais as frases que você mais ouve dos outros em relação a seus “pontos fracos”?", 'PontoFraco');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $PontoFraco1 = '';
            if (isset($hbdi -> bl_ponto_fraco1) && strlen($hbdi -> bl_ponto_fraco1) > 0) {
                $PontoFraco1 = $hbdi -> bl_ponto_fraco1;
            }

            $attributes = array('id'=>'PontoFraco1','name' => 'PontoFraco1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco1, ($PontoFraco1=='1' && strlen($PontoFraco1)>0));
            echo "
                                                                                                <span>9.1 Viciado em números</span><br />";
            $PontoFraco2 = '';
            if (isset($hbdi -> bl_ponto_fraco2) && strlen($hbdi -> bl_ponto_fraco2) > 0) {
                $PontoFraco2 = $hbdi -> bl_ponto_fraco2;
            }

            $attributes = array('id'=>'PontoFraco2','name' => 'PontoFraco2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco2, ($PontoFraco2=='1' && strlen($PontoFraco2)>0));
            echo "
                                                                                                <span>9.2 Coração mole</span><br />";
            $PontoFraco3 = '';
            if (isset($hbdi -> bl_ponto_fraco3) && strlen($hbdi -> bl_ponto_fraco3) > 0) {
                $PontoFraco3 = $hbdi -> bl_ponto_fraco3;
            }

            $attributes = array('id'=>'PontoFraco3','name' => 'PontoFraco3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco3, ($PontoFraco3=='1' && strlen($PontoFraco3)>0));
            echo "
                                                                                                <span>9.3 Exigente; esforçado</span><br />";
            $PontoFraco4 = '';
            if (isset($hbdi -> bl_ponto_fraco4) && strlen($hbdi -> bl_ponto_fraco4) > 0) {
                $PontoFraco4 = $hbdi -> bl_ponto_fraco4;
            }

            $attributes = array('id'=>'PontoFraco4','name' => 'PontoFraco4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco4, ($PontoFraco4=='1' && strlen($PontoFraco4)>0));
            echo "
                                                                                                <span>9.4 Vive no mundo da lua</span><br />";
            $PontoFraco5 = '';
            if (isset($hbdi -> bl_ponto_fraco5) && strlen($hbdi -> bl_ponto_fraco5) > 0) {
                $PontoFraco5 = $hbdi -> bl_ponto_fraco5;
            }

            $attributes = array('id'=>'PontoFraco5','name' => 'PontoFraco5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco5, ($PontoFraco5=='1' && strlen($PontoFraco5)>0));
            echo "
                                                                                                <span>9.5 Tem sede de poder</span><br />";
            $PontoFraco6 = '';
            if (isset($hbdi -> bl_ponto_fraco6) && strlen($hbdi -> bl_ponto_fraco6) > 0) {
                $PontoFraco6 = $hbdi -> bl_ponto_fraco6;
            }

            $attributes = array('id'=>'PontoFraco6','name' => 'PontoFraco6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco6, ($PontoFraco6=='1' && strlen($PontoFraco6)>0));
            echo "
                                                                                                <span>9.6 Fala demais</span><br />";
            $PontoFraco7 = '';
            if (isset($hbdi -> bl_ponto_fraco7) && strlen($hbdi -> bl_ponto_fraco7) > 0) {
                $PontoFraco7 = $hbdi -> bl_ponto_fraco7;
            }

            $attributes = array('id'=>'PontoFraco7','name' => 'PontoFraco7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco7, ($PontoFraco7=='1' && strlen($PontoFraco7)>0));
            echo "
                                                                                                <span>9.7 Não decide sozinho</span><br />";
            $PontoFraco8 = '';
            if (isset($hbdi -> bl_ponto_fraco8) && strlen($hbdi -> bl_ponto_fraco8) > 0) {
                $PontoFraco8 = $hbdi -> bl_ponto_fraco8;
            }

            $attributes = array('id'=>'PontoFraco8','name' => 'PontoFraco8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco8, ($PontoFraco8=='1' && strlen($PontoFraco8)>0));
            echo "
                                                                                                <span>9.8 Não sabe se concentrar</span><br />";
            $PontoFraco9 = '';
            if (isset($hbdi -> bl_ponto_fraco9) && strlen($hbdi -> bl_ponto_fraco9) > 0) {
                $PontoFraco9 = $hbdi -> bl_ponto_fraco9;
            }

            $attributes = array('id'=>'PontoFraco9','name' => 'PontoFraco9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco9, ($PontoFraco9=='1' && strlen($PontoFraco9)>0));
            echo "
                                                                                                <span>9.9 Frio; insensível</span><br />";
            $PontoFraco10 = '';
            if (isset($hbdi -> bl_ponto_fraco10) && strlen($hbdi -> bl_ponto_fraco10) > 0) {
                $PontoFraco10 = $hbdi -> bl_ponto_fraco10;
            }

            $attributes = array('id'=>'PontoFraco10','name' => 'PontoFraco10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco10, ($PontoFraco10=='1' && strlen($PontoFraco10)>0));
            echo "
                                                                                                <span>9.10 Fácil de convencer</span><br />";
            $PontoFraco11 = '';
            if (isset($hbdi -> bl_ponto_fraco11) && strlen($hbdi -> bl_ponto_fraco11) > 0) {
                $PontoFraco11 = $hbdi -> bl_ponto_fraco11;
            }

            $attributes = array('id'=>'PontoFraco11','name' => 'PontoFraco11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco11, ($PontoFraco11=='1' && strlen($PontoFraco11)>0));
            echo "
                                                                                                <span>9.11 Sem imaginação</span><br />";
            $PontoFraco12 = '';
            if (isset($hbdi -> bl_ponto_fraco12) && strlen($hbdi -> bl_ponto_fraco12) > 0) {
                $PontoFraco12 = $hbdi -> bl_ponto_fraco12;
            }

            $attributes = array('id'=>'PontoFraco12','name' => 'PontoFraco12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco12, ($PontoFraco12=='1' && strlen($PontoFraco12)>0));
            echo "
                                                                                                <span>9.12 Maluco</span><br />";
            $PontoFraco13 = '';
            if (isset($hbdi -> bl_ponto_fraco13) && strlen($hbdi -> bl_ponto_fraco13) > 0) {
                $PontoFraco13 = $hbdi -> bl_ponto_fraco13;
            }

            $attributes = array('id'=>'PontoFraco13','name' => 'PontoFraco13', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco13, ($PontoFraco13=='1' && strlen($PontoFraco13)>0));
            echo "
                                                                                                <span>9.13 Calculista</span><br />";
            $PontoFraco14 = '';
            if (isset($hbdi -> bl_ponto_fraco14) && strlen($hbdi -> bl_ponto_fraco14) > 0) {
                $PontoFraco14 = $hbdi -> bl_ponto_fraco14;
            }

            $attributes = array('id'=>'PontoFraco14','name' => 'PontoFraco14', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco14, ($PontoFraco14=='1' && strlen($PontoFraco14)>0));
            echo "
                                                                                                <span>9.14 Ingênuo</span><br />";
            $PontoFraco15 = '';
            if (isset($hbdi -> bl_ponto_fraco15) && strlen($hbdi -> bl_ponto_fraco15) > 0) {
                $PontoFraco15 = $hbdi -> bl_ponto_fraco15;
            }

            $attributes = array('id'=>'PontoFraco15','name' => 'PontoFraco15', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco15, ($PontoFraco15=='1' && strlen($PontoFraco15)>0));
            echo "
                                                                                                <span>9.15 Bitolado</span><br />";
            $PontoFraco16 = '';
            if (isset($hbdi -> bl_ponto_fraco16) && strlen($hbdi -> bl_ponto_fraco16) > 0) {
                $PontoFraco16 = $hbdi -> bl_ponto_fraco16;
            }

            $attributes = array('id'=>'PontoFraco16','name' => 'PontoFraco16', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco16, ($PontoFraco16=='1' && strlen($PontoFraco16)>0));
            echo "
                                                                                                <span>9.16 Inconsequente</span><br />";
            $PontoFraco17 = '';
            if (isset($hbdi -> bl_ponto_fraco17) && strlen($hbdi -> bl_ponto_fraco17) > 0) {
                $PontoFraco17 = $hbdi -> bl_ponto_fraco17;
            }

            $attributes = array('id'=>'PontoFraco17','name' => 'PontoFraco17', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco17, ($PontoFraco17=='1' && strlen($PontoFraco17)>0));
            echo "
                                                                                                <span>9.17 Não se mistura</span><br />";
            $PontoFraco18 = '';
            if (isset($hbdi -> bl_ponto_fraco18) && strlen($hbdi -> bl_ponto_fraco18) > 0) {
                $PontoFraco18 = $hbdi -> bl_ponto_fraco18;
            }

            $attributes = array('id'=>'PontoFraco18','name' => 'PontoFraco18', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco18, ($PontoFraco18=='1' && strlen($PontoFraco18)>0));
            echo "
                                                                                                <span>9.18 Ultrassensível</span><br />";
            $PontoFraco19 = '';
            if (isset($hbdi -> bl_ponto_fraco19) && strlen($hbdi -> bl_ponto_fraco19) > 0) {
                $PontoFraco19 = $hbdi -> bl_ponto_fraco19;
            }

            $attributes = array('id'=>'PontoFraco19','name' => 'PontoFraco19', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco19, ($PontoFraco19=='1' && strlen($PontoFraco19)>0));
            echo "
                                                                                                <span>9.19 Quadrado</span><br />";
            $PontoFraco20 = '';
            if (isset($hbdi -> bl_ponto_fraco20) && strlen($hbdi -> bl_ponto_fraco20) > 0) {
                $PontoFraco20 = $hbdi -> bl_ponto_fraco20;
            }

            $attributes = array('id'=>'PontoFraco20','name' => 'PontoFraco20', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $PontoFraco20, ($PontoFraco20=='1' && strlen($PontoFraco20)>0));
            echo "
                                                                                                <span>9.20 Sem disciplina</span><br />";
            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("10. Quando tenho que resolver um problema, eu geralmente…", 'Resolver');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Resolver = '';
            if (isset($hbdi -> in_resolver) && strlen($hbdi -> in_resolver) > 0) {
                $Resolver = $hbdi -> in_resolver;
            }

            $attributes = array('id'=>'Resolver1','name' => 'Resolver', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='1' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.1 Visualizo os fatos; tratando-os de forma intuitiva e holística</span><br />";
            $attributes = array('id'=>'Resolver2','name' => 'Resolver', 'value' => '2','disabled'=>"disabled");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='2' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.2 Organizo os fatos; tratando os detalhes de forma realista e cronológica</span><br />";
            $attributes = array('id'=>'Resolver3','name' => 'Resolver', 'value' => '3','disabled'=>"disabled");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='3' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.3 Sinto os fatos; tratando-os de forma expressiva e interpessoal</span><br />";
            $attributes = array('id'=>'Resolver4','name' => 'Resolver', 'value' => '4','disabled'=>"disabled");
            echo form_checkbox($attributes, $Resolver, ($Resolver=='4' && strlen($Resolver)>0));
            echo "
                                                                                                <span>10.4 Analiso os fatos; tratando-os de forma lógica e racional</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("11. Quando tenho que resolver um problema, eu procuro…", 'Procuro');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Procuro = '';
            if (isset($hbdi -> in_procuro) && strlen($hbdi -> in_procuro) > 0) {
                $Procuro = $hbdi -> in_procuro;
            }

            $attributes = array('id'=>'Procuro1','name' => 'Procuro', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='1' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.1 Uma visão interpessoal; emocional; humana</span><br />";
            $attributes = array('id'=>'Procuro2','name' => 'Procuro', 'value' => '2','disabled'=>"disabled");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='2' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.2 Uma visão organizada; detalhada; cronológica</span><br />";
            $attributes = array('id'=>'Procuro3','name' => 'Procuro', 'value' => '3','disabled'=>"disabled");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='3' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.3 Uma visão analítica; lógica; racional; de resultados</span><br />";
            $attributes = array('id'=>'Procuro4','name' => 'Procuro', 'value' => '4','disabled'=>"disabled");
            echo form_checkbox($attributes, $Procuro, ($Procuro=='4' && strlen($Procuro)>0));
            echo "
                                                                                                <span>11.4 Uma visão intuitiva; conceitual; visual; de contexto geral</span><br />";

            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-md-4 col-lg-2\">";
            $attributes = array('class' => 'esquerdo control-label');

            echo form_label("12. Quais as frases que mais se aproximam do que você diz?", 'Frase');
            echo "
                                                                                            </div>
                                                                                            <div class=\"col-md-8 col-lg-10\">";

            $Frase1 = '';
            if (isset($hbdi -> bl_frase1) && strlen($hbdi -> bl_frase1) > 0) {
                $Frase1 = $hbdi -> bl_frase1;
            }

            $attributes = array('id'=>'Frase1','name' => 'Frase1', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase1, ($Frase1=='1' && strlen($Frase1)>0));
            echo "
                                                                                                <span>12.1 Sempre fazemos desta forma</span><br />";
            $Frase2 = '';
            if (isset($hbdi -> bl_frase2) && strlen($hbdi -> bl_frase2) > 0) {
                $Frase2 = $hbdi -> bl_frase2;
            }

            $attributes = array('id'=>'Frase2','name' => 'Frase2', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase2, ($Frase2=='1' && strlen($Frase2)>0));
            echo "
                                                                                                <span>12.2 Vamos ao ponto-chave do problema</span><br />";
            $Frase3 = '';
            if (isset($hbdi -> bl_frase3) && strlen($hbdi -> bl_frase3) > 0) {
                $Frase3 = $hbdi -> bl_frase3;
            }

            $attributes = array('id'=>'Frase3','name' => 'Frase3', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase3, ($Frase3=='1' && strlen($Frase3)>0));
            echo "
                                                                                                <span>12.3 Vejamos os valores humanos</span><br />";
            $Frase4 = '';
            if (isset($hbdi -> bl_frase4) && strlen($hbdi -> bl_frase4) > 0) {
                $Frase4 = $hbdi -> bl_frase4;
            }

            $attributes = array('id'=>'Frase4','name' => 'Frase4', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase4, ($Frase4=='1' && strlen($Frase4)>0));
            echo "
                                                                                                <span>12.4 Vamos analisar</span><br />";
            $Frase5 = '';
            if (isset($hbdi -> bl_frase5) && strlen($hbdi -> bl_frase5) > 0) {
                $Frase5 = $hbdi -> bl_frase5;
            }

            $attributes = array('id'=>'Frase5','name' => 'Frase5', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase5, ($Frase5=='1' && strlen($Frase5)>0));
            echo "
                                                                                                <span>12.5 Vamos ver o quadro geral</span><br />";
            $Frase6 = '';
            if (isset($hbdi -> bl_frase6) && strlen($hbdi -> bl_frase6) > 0) {
                $Frase6 = $hbdi -> bl_frase6;
            }

            $attributes = array('id'=>'Frase6','name' => 'Frase6', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, set_value('Frase6'), (set_value('Frase6')=='1' && strlen(set_value('Frase6'))>0));
            echo "
                                                                                                <span>12.6 Vamos ver o desenvolvimento de equipe</span><br />";
            $Frase7 = '';
            if (isset($hbdi -> bl_frase7) && strlen($hbdi -> bl_frase7) > 0) {
                $Frase7 = $hbdi -> bl_frase7;
            }

            $attributes = array('id'=>'Frase7','name' => 'Frase7', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase7, ($Frase7=='1' && strlen($Frase7)>0));
            echo "
                                                                                                <span>12.7 Vamos conhecer o resultado</span><br />";
            $Frase8 = '';
            if (isset($hbdi -> bl_frase8) && strlen($hbdi -> bl_frase8) > 0) {
                $Frase8 = $hbdi -> bl_frase8;
            }

            $attributes = array('id'=>'Frase8','name' => 'Frase8', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase8, ($Frase8=='1' && strlen($Frase8)>0));
            echo "
                                                                                                <span>12.8 Este é o grande sucesso conceitual</span><br />";
            $Frase9 = '';
            if (isset($hbdi -> bl_frase9) && strlen($hbdi -> bl_frase9) > 0) {
                $Frase9 = $hbdi -> bl_frase9;
            }

            $attributes = array('id'=>'Frase9','name' => 'Frase9', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase9, ($Frase9=='1' && strlen($Frase9)>0));
            echo "
                                                                                                <span>12.9 Vamos manter a lei e a ordem</span><br />";
            $Frase10 = '';
            if (isset($hbdi -> bl_frase10) && strlen($hbdi -> bl_frase10) > 0) {
                $Frase10 = $hbdi -> bl_frase10;
            }

            $attributes = array('id'=>'Frase10','name' => 'Frase10', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase10, ($Frase10=='1' && strlen($Frase10)>0));
            echo "
                                                                                                <span>12.10 Vamos inovar e criar sinergia</span><br />";
            $Frase11 = '';
            if (isset($hbdi -> bl_frase11) && strlen($hbdi -> bl_frase11) > 0) {
                $Frase11 = $hbdi -> bl_frase11;
            }

            $attributes = array('id'=>'Frase11','name' => 'Frase11', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase11, ($Frase11=='1' && strlen($Frase11)>0));
            echo "
                                                                                                <span>12.11 Vamos participar e envolver</span><br />";
            $Frase12 = '';
            if (isset($hbdi -> bl_frase12) && strlen($hbdi -> bl_frase12) > 0) {
                $Frase12 = $hbdi -> bl_frase12;
            }

            $attributes = array('id'=>'Frase12','name' => 'Frase12', 'value' => '1','disabled'=>"disabled");
            echo form_checkbox($attributes, $Frase12, ($Frase12=='1' && strlen($Frase12)>0));
            echo "
                                                                                                <span>12.12 É mais seguro desta forma</span><br />";


            echo "
                        
                                                                                            </div>
                                                                                    </div>
                                                                                    ";

            echo "
                         
                                                                                
                                                                           ";

            echo form_fieldset_close();
            echo "</div> <!-- Fim HBDI Tab -->";
            echo "<div class=\"tab-pane\" id=\"aderenciaTab\" role=\"tabpanel\" aria-expanded=\"false\">";

            echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
            echo form_fieldset('Teste de aderência');
            $CI =& get_instance();
            $CI -> mostra_questoes($questoes5, $respostas, $opcoes, '', false);
            echo form_fieldset_close();


            echo "</div> <!-- Fim 5ª Tab -->";

            echo "<div class=\"tab-pane\" id=\"motivacaoTab\" role=\"tabpanel\" aria-expanded=\"false\">";

            echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
            echo form_fieldset('Teste de motivação');
            $CI =& get_instance();
            $CI -> mostra_questoes($questoes7, $respostas, $opcoes, '', false);
            echo form_fieldset_close();


            echo "</div> <!-- Fim 7ª Tab -->";
        }
        echo "<div class=\"tab-pane\" id=\"especialistaTab\" role=\"tabpanel\" aria-expanded=\"false\">";

        echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Entrevista com especialista');
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes6, $respostas, $opcoes, '', false);
        echo form_fieldset_close();


        echo "</div> <!-- Fim 6ª Tab -->";
    }
    if ($this -> session -> perfil == 'candidato') {
        echo "                                                                                          <div class=\"row\">
                                                                                                                                                    <div class=\"col-sm-12\">
                                                                                                                                                        <div class=\"kt-form__actions\">                                                                                
                                                                                                                                                            <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\">< Voltar</button>                                                                                                                                                            
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div> ";
    } else {
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
                                            </div></div>";
}

if ($menu2 == 'RevisaoRequisitos') { //detalhamento da candidatura
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
    if (strlen($candidato -> vc_telefoneOpcional) > 0) {
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

    if (isset($formacoes)) {
        $i=0;


        foreach ($formacoes as $formacao) {
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
            if ($formacao->en_tipo == 'bacharelado') {
                $res = 'Graduação - Bacharelado';
            } elseif ($formacao->en_tipo == 'tecnologo') {
                $res = 'Graduação - Tecnológo';
            } elseif ($formacao->en_tipo == 'especializacao') {
                $res = 'Pós-graduação - Especialização';
            } elseif ($formacao->en_tipo == 'mba') {
                $res = 'MBA';
            } elseif ($formacao->en_tipo == 'mestrado') {
                $res = 'Mestrado';
            } elseif ($formacao->en_tipo == 'doutorado') {
                $res = 'Doutorado';
            } elseif ($formacao->en_tipo == 'posdoc') {
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
            if ($anexos[$formacao->pr_formacao]) {
                foreach ($anexos[$formacao->pr_formacao] as $anexo) {
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
    if (isset($experiencias)) {
        $i = 0;
        foreach ($experiencias as $experiencia) {
            ++$i;
            echo "
                                                                                        
                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
            echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";
            $attributes = array('class' => 'esquerdo control-label');
            echo form_label('Cargo', "cargo{$i}", $attributes);
            echo " 
                                                                                                        <br />";

            $attributes = array('name' => "cargo{$i}",
                                            'id' => "cargo{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
            echo form_input($attributes, $experiencia->vc_cargo);
            echo "
                                                                                                </div>
                                                                                        </div>
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
    if ($candidatura[0] -> bl_aderencia) {
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
    if (isset($questoes6)) {
        echo form_input(array('name' => 'codigo_candidatura', 'type'=>'hidden', 'id' =>'codigo_candidatura','value'=>$codigo_candidatura));
        $attributes = array('class' => 'btn btn-primary');
        echo form_submit('salvar', 'Salvar', $attributes);
    }
    echo "                                                                                
                                                                                    <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."';\">< Voltar</button>
                                                                            </div>
                                                                    </form>
                                                            </div>
                                                    </div>
                                            </div></div>";
}

if ($menu2 == 'AgendamentoEntrevista') { //agendamento da entrevista ou calendário
        if ($this -> session -> perfil == 'candidato' || $this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'sugesp') { //avaliador
                //var_dump($candidaturas);
                echo "
                                                            <div class=\"row\">
                                                                    <div class=\"col-md-12\">
                                                                            <div id='calendar'>";
            $contador = 0;
            if (isset($candidaturas)) {
                foreach ($candidaturas as $linha) {
                    if (strlen($linha -> dt_entrevista)>0) {
                        ++$contador;
                    }
                }
            }
            if ($contador == 0) {
                echo "Sem entrevistas agendadas para o seu usuário.";
            }
            echo"</div>
                                                                    </div>
                                                                    
                                                            </div>
                                                    </div>
                                            </div>";
            if ($contador > 0) {
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

                foreach ($candidaturas as $linha) {
                    if (strlen($linha -> dt_entrevista)>0) {
                        $partes = explode(" ", $linha -> dt_entrevista);
                        //if($this -> session -> perfil == 'candidato'){
                        $pagina['js'] .= " 
                                    {
                                            title: 'Entrevista',
                                            start: '".$linha -> dt_entrevista."',
                                            description: 'Entrevista".($linha->bl_tipo_entrevista=='especialista' ? " com Especialista" : " por Competência")."<br/>Vaga: ".$linha -> vc_vaga."<br />Horário: ".$partes[1]."<br />Link: ".$linha -> vc_link."',
                                            color: '".($linha->bl_tipo_entrevista=='especialista' ? ($linha->es_status=='12' ? "green" : ($linha->es_status==15 ? "red" : "#ab8c00")) : ($linha->es_status=='11' ? "green" : ($linha->es_status==15 ? "red" : "#ab8c00")))."'    
                                    }, ";
                        //}
                                        /*else{
                                                $pagina['js'] .= "
                                    {
                                            title: 'Entrevista com o candidato ".$linha -> vc_nome."',
                                            start: '".$linha -> dt_entrevista."',
                                            description: 'Entrevista".($linha->bl_tipo_entrevista=='especialista'?" com Especialista":" por Competência")."<br/>Vaga: ".$linha -> vc_vaga."<br />Horário: ".$partes[1]."<br />Link: ".$linha -> vc_link."',
                                            color: '".($linha->bl_tipo_entrevista=='especialista'?($linha->es_status=='12'?"green":($linha->es_status==15?"red":"#ab8c00")):($linha->es_status=='11'?"green":($linha->es_status==15?"red":"#ab8c00")))."'

                                    }, ";
                                        }*/
                    }
                    if (strlen($linha -> dt_aderencia) > 0 && ($linha -> en_aderencia == '1' || $linha -> en_aderencia == '2')) {
                        $partes = explode(" ", $linha -> dt_aderencia);
                        $pagina['js'] .= " 
                                        {
                                        title: 'Teste de Aderência',
                                        start: '".$linha -> dt_aderencia."',
                                        description: 'Teste de Aderência<br />Vaga: ".$linha -> vc_vaga."<br />Fim do prazo de preenchimento: ".$partes[1]."',
                                        color: '".($linha->en_aderencia=='2' ? "green" : "red")."'    
                                        }, ";
                    }
                    if (strlen($linha -> dt_aderencia) > 0 && ($linha -> en_hbdi == '1' || $linha -> en_hbdi == '2')) {
                        $partes = explode(" ", $linha -> dt_aderencia);
                        $pagina['js'] .= " 
                                        {
                                        title: 'HBDI',
                                        start: '".$linha -> dt_aderencia."',
                                        description: 'HBDI<br />Vaga: ".$linha -> vc_vaga."<br />Fim do prazo de preenchimento: ".$partes[1]."',
                                        color: '".($linha->en_hbdi=='2' ? "green" : "red")."'   
                                        }, ";
                    }
                    if (strlen($linha -> dt_aderencia) > 0 && ($linha -> en_motivacao == '1' || $linha -> en_motivacao == '2')) {
                        $partes = explode(" ", $linha -> dt_aderencia);
                        $pagina['js'] .= " 
                                        {
                                        title: 'Teste de Motivação',
                                        start: '".$linha -> dt_aderencia."',
                                        description: 'Teste de motivação<br />Vaga: ".$linha -> vc_vaga."<br />Fim do prazo de preenchimento: ".$partes[1]."',
                                        color: '".($linha->en_motivacao=='2' ? "green" : "red")."'    
                                        }, ";
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
if ($menu2 == 'AvaliacaoEntrevista') { //avaliação da entrevista - 4ª etapa

    if (strlen($erro)>0) {
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
    } elseif (strlen($sucesso) > 0) {
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
    if (strlen($sucesso) == 0) {
        $attributes = array('class' => 'kt-form',
                                    'id' => 'form_avaliacoes');
        if (isset($vaga) && $vaga > 0) {
            echo form_open($url, $attributes, array('codigo' => $codigo, 'vaga' => $vaga));
        } else {
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
        if (strlen($candidato -> vc_telefoneOpcional) > 0) {
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
        if (isset($vaga) && $vaga > 0) {
            echo "
                                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vaga)."'\">Cancelar</button>";
        } else {
            echo "
                                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>";
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

if ($menu2 == 'AvaliacaoEntrevistaEspecialista') { //avaliação da entrevista especialista - 6ª etapa

    if (strlen($erro)>0) {
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
    } elseif (strlen($sucesso) > 0) {
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
    if (strlen($sucesso) == 0) {
        $attributes = array('class' => 'kt-form',
                                    'id' => 'form_avaliacoes');
        if (isset($vaga) && $vaga > 0) {
            echo form_open($url, $attributes, array('codigo' => $codigo,'vaga' => $vaga));
        } else {
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
        if (strlen($candidato -> vc_telefoneOpcional) > 0) {
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
        if (isset($vaga) && $vaga > 0) {
            echo "
                                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vaga)."'\">Cancelar</button>";
        } else {
            echo "
                                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>";
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
                                    </div></div>";

$this->load->view('templates/internaRodape', $pagina);
