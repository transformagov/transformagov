<?php

defined("BASEPATH") or exit("No direct script access allowed");
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
    if (!isset($vc_respostaAceita) || (strlen($vc_respostaAceita) == 0 && strlen(set_value('respostaaceita')) > 0)) {
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
    if (isset($opcoes)) {
        $c=1;
        foreach ($opcoes as $linha) {
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
