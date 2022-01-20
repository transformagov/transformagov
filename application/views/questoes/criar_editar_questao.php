<?php

defined("BASEPATH") or exit("No direct script access allowed");

    if (strlen($erro)>0) {
        echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
    //$erro='';
    } elseif (strlen($sucesso) > 0) {
        echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
    }
    if (strlen($sucesso) == 0) {
        $attributes = array('id' => 'form_questoes');
        if ($menu2 == 'edit' && isset($codigo) && $codigo > 0) {
            echo form_open($url, $attributes, array('codigo' => $codigo, 'grupo' => $grupo, 'num' => set_value('num')));
        } else {
            echo form_open($url, $attributes, array('grupo' => $grupo, 'num' => set_value('num')));
        }
        echo "
                                                                    <div class=\"form-group row\">";
        $attributes = array('class' => 'col-lg-3 col-form-label text-right');
        echo form_label('Descrição <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);
        echo "
                                                                            <div class=\"col-lg-6\">";
        if (!isset($tx_questao) || (strlen($tx_questao) == 0 && strlen(set_value('descricao')) > 0)) {
            $tx_questao = set_value('descricao');
        }
        $attributes = array('name' => 'descricao',

                                    'rows'=>'3',
                                    'class' => 'form-control');
        if (strstr($erro, "'Descrição'")) {
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
        if (!isset($es_etapa) || (strlen($es_etapa) == 0 && strlen(set_value('etapa')) > 0)) {
            $es_etapa = set_value('etapa');
        }
        if (strstr($erro, "'Etapa'")) {
            echo form_dropdown('etapa', $etapas, $es_etapa, "class=\"form-control is-invalid\"");
        } else {
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
        if (!isset($es_competencia) || (strlen($es_competencia) == 0 && strlen(set_value('competencia')) > 0)) {
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
        if (!isset($bl_obrigatorio) || (strlen($bl_obrigatorio) == 0 && strlen(set_value('obrigatorio')) > 0)) {
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
        if (!isset($bl_eliminatoria) || (strlen($bl_eliminatoria) == 0 && strlen(set_value('eliminatoria')) > 0)) {
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
        if (!isset($in_peso) || (strlen($in_peso) == 0 && strlen(set_value('peso')) > 0)) {
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
        if (!isset($in_tipo) || (strlen($in_tipo) == 0 && strlen(set_value('tipo')) > 0)) {
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
        if (strstr($erro, "'Tipo'")) {
            echo form_dropdown('tipo', $attributes, $in_tipo, "class=\"form-control is-invalid\" id=\"tipo\"");
        } else {
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
        if (!isset($vc_respostaAceita) || (strlen($vc_respostaAceita) == 0 && strlen(set_value('respostaaceita')) > 0)) {
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
        if (isset($opcoes)) {
            $c=1;
            foreach ($opcoes as $linha) {
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
        for ($i = 1 ; $i <= set_value('num'); $i++) {
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
        if (strlen($in_peso)==0) {
            $in_peso=0;
        }
        $pagina['js'].="
                $('#tipo').trigger('change');
        </script>";
    }
