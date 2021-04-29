<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']='Candidatos';
$pagina['menu2']='index';
$pagina['url']='Candidatos/curriculo_base';
$pagina['nome_pagina']='Currículo base';
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this->load->view('templates/internaCabecalho', $pagina);

echo "
                        <div class=\"pcoded-content\">
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
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"$('#Salvar').click();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url()."'\">Cancelar</button>
                                                                    </div>
                                                            </div>";

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
//if(strlen($sucesso) == 0){
        if(strlen(set_value('num_formacao')) > 0){
        
                $num_formacao = set_value('num_formacao');
        }
        if(!($num_formacao>0)){
                $num_formacao = 1;
        }
		$navegar = 0;
        if(strlen(set_value('num_experiencia')) > 0){
                if(set_value('num_experiencia') > $num_experiencia){
						$navegar = 1;
				}
                $num_experiencia = set_value('num_experiencia');
        }
        if(!($num_experiencia>0)){
                $num_experiencia = 1;
        }
        $attributes = array('class' => 'login-form',
                            'id' => 'form_dados');
        echo form_open_multipart($url, $attributes, array('num_formacao' => $num_formacao, 'num_experiencia' => $num_experiencia));
        //echo form_open($url, $attributes);
        /*echo "
                                <div class=\"row\">
                                        <div class=\"col-md-9\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Nome completo <abbr title="Obrigatório">*</abbr>', 'nome', $attributes);

        $attributes = array('name' => 'NomeCompleto',
                            'id' => 'NomeCompleto',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $vc_nome);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('CPF <abbr title="Obrigatório">*</abbr>', 'CPF', $attributes);

        $attributes = array('name' => 'CPF',
                            'id' => 'CPF',
                            'maxlength'=>'14',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $ch_cpf);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('RG <abbr title="Obrigatório">*</abbr>', 'RG', $attributes);

        $attributes = array('name' => 'RG',
                            'id' => 'RG',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $vc_rg);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Órgão Emissor <abbr title="Obrigatório">*</abbr>', 'OrgaoEmissor', $attributes);

        $attributes = array('name' => 'OrgaoEmissor',
                            'id' => 'OrgaoEmissor',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $vc_orgaoEmissor);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Gênero <abbr title="Obrigatório">*</abbr>', 'IdentidadeGenero', $attributes);

        $attributes = array(
                            0 => '',
                            1 => 'Não informado',
                            2 => 'Masculino',
                            3 => 'Feminino',
                            4 => 'Desejo informar'
                            );
        if(strstr($erro, "'Gênero'")){
                echo form_dropdown('IdentidadeGenero', $attributes, $in_genero, "class=\"form-control is-invalid\" id=\"IdentidadeGenero\"");
        }
        else{
                echo form_dropdown('IdentidadeGenero', $attributes, $in_genero, "class=\"form-control\" id=\"IdentidadeGenero\"");
        }
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Informe gênero optativo <abbr title="Obrigatório">*</abbr>', 'IdentidadeGeneroOptativa', $attributes);

        $attributes = array('name' => 'IdentidadeGeneroOptativa',
                            'id' => 'IdentidadeGeneroOptativa',
                            'maxlength'=>'50',
                            'class' => 'form-control text-box single-line',
                            'disabled'=>'disabled');
        if(strstr($erro, "'Gênero optativo'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_generoOptativo);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Raça <abbr title="Obrigatório">*</abbr>', 'Raca', $attributes);

        $attributes = array(
                            0 => '',
                            1 => 'Não informado',
                            2 => 'Amarela',
                            3 => 'Branca',
                            4 => 'Indígena',
                            5 => 'Parda',
                            6 => 'Preta'
                            );
        if(strstr($erro, "'Raça'")){
                echo form_dropdown('Raca', $attributes, $in_raca, "class=\"form-control is-invalid\" id=\"Raca\"");
        }
        else{
                echo form_dropdown('Raca', $attributes, $in_raca, "class=\"form-control\" id=\"Raca\"");
        }
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('E-mail <abbr title="Obrigatório">*</abbr>', 'Email', $attributes);

        $attributes = array('name' => 'Email',
                            'id' => 'Email',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'E-mail'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_email);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Telefone <abbr title="Obrigatório">*</abbr>', 'Telefone', $attributes);

        $attributes = array('name' => 'Telefone',
                            'id' => 'Telefone',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Telefone'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_telefone);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Telefone opcional', 'TelefoneOpcional', $attributes);

        $attributes = array('name' => 'TelefoneOpcional',
                            'id' => 'TelefoneOpcional',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_telefoneOpcional);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Data de nascimento <abbr title="Obrigatório">*</abbr>', 'DataNascimento', $attributes);

        $attributes = array('name' => 'DataNascimento',
                            'id' => 'DataNascimento',
                            'maxlength'=>'15',
							
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, 'data de nascimento')){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, show_date($dt_nascimento));
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-9\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('LinkedIn', 'LinkedIn', $attributes);

        $attributes = array('name' => 'LinkedIn',
                            'id' => 'LinkedIn',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line',
                            'placeholder' => 'https://www.linkedin.com/in/');
        echo form_input($attributes, $vc_linkedin);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-4\">
                                                <br/>
                                                <label>
                                                        País: &nbsp;
                                                </label>
                                                <div class=\"btn-group control-label\">
                                                        <label class=\"\">";
        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'Pais',
                            'value'=>'Brasil');
        echo form_radio($attributes, set_value('Nacionalidade'), ($vc_pais=='Brasil' || strlen($vc_pais)==0));
        echo " Brasil
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=\"\">";
        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'OutroPais',
                            'value'=>'Outro');
        echo form_radio($attributes, set_value('Nacionalidade'), ($vc_pais!='Brasil' && strlen($vc_pais)>0));
        echo " Exterior
                                                        </label>
                                                </div>
                                        </div>
                                        <div id=\"div_cidadeestrangeira\" class=\"col-md-8\" style=\"display:none\">
                                                <div class=\"col-md-4\">
                                                        <div class=\"form-group\" id=\"div_pais\">";
        $attributes = array('class' => 'control-label');
        echo form_label('País estrangeiro <abbr title="Obrigatório">*</abbr>', 'Pais2', $attributes);

        $attributes = array('name' => 'Pais2',
                            'id' => 'Pais2',
                            'maxlength'=>'150',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'País estrangeiro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_pais);
        echo "
                                                        </div>
                                                </div>
                                                <div class=\"col-md-4\">
                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Cidade estrangeira <abbr title="Obrigatório">*</abbr>', 'CidadeEstrangeira', $attributes);

        $attributes = array('name' => 'CidadeEstrangeira',
                            'id' => 'CidadeEstrangeira',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Cidade estrangeira'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_cidadeEstrangeira);
        echo "
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-2\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('CEP <abbr title="Obrigatório">*</abbr>', 'CEP', $attributes);

        $attributes = array('name' => 'CEP',
                            'id' => 'CEP',
                            'maxlength'=>'9',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'CEP'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_cep, " onblur=\"pesquisacep(this.value);\"");
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-6\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Logradouro <abbr title="Obrigatório">*</abbr>', 'Logradouro', $attributes);

        $attributes = array('name' => 'Logradouro',
                            'id' => 'Logradouro',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Logradouro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_logradouro);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Número <abbr title="Obrigatório">*</abbr>', 'Numero', $attributes);

        $attributes = array('name' => 'Numero',
                            'id' => 'Numero',
                            'maxlength'=>'10',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Número'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_numero);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-4\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Complemento', 'Complemento', $attributes);

        $attributes = array('name' => 'Complemento',
                            'id' => 'Complemento',
                            'maxlength'=>'10',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_complemento);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-6\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Bairro', 'Bairro', $attributes);

        $attributes = array('name' => 'Bairro',
                            'id' => 'Bairro',
                            'maxlength'=>'150',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Bairro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_bairro);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                                <div class=\"form-group\">";
        $Estados=array(0 => '')+$Estados;
        $attributes = array('class' => 'control-label');
        echo form_label('Estado <abbr title="Obrigatório">*</abbr>', 'Estado', $attributes);
        
        if(strstr($erro, "'Estado'")){
                echo form_dropdown('Estado', $Estados, set_value('Estado'), "class=\"form-control is-invalid\" id=\"Estado\"");
        }
        else{
                echo form_dropdown('Estado', $Estados, set_value('Estado'), "class=\"form-control\" id=\"Estado\"");
        }
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-4\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Município <abbr title="Obrigatório">*</abbr>', 'Municipio', $attributes);
        
        if(strstr($erro, "'Município'")){
                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control is-invalid\" id=\"Municipio\"");
        }
        else{
                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control\" id=\"Municipio\"");
        }
        echo "
                                                </div>
                                        </div>
                                </div>";*/
        echo "
								<div class=\"alert alert-warning\">
										ATENÇÃO<br />
										As informações de Formação Acadêmica e Experiência Profissional registradas aqui servirão como currículo base na inscrição de qualquer vaga. O sistema incluirá uma cópia dos dados inseridos aqui no formulário de “Currículo” da vaga escolhida, para que o candidato não precise preencher todas essas informações e incluir todos os comprovantes toda vez que se inscrever a uma vaga.<br />
										Os dados copiados para a vaga poderão ser alterados pelo candidato durante a inscrição, mas essas alterações NÃO serão refletidas no currículo base, ou seja, no formulário de Dados Pessoais.<br />
										Após a escolha da vaga, qualquer alteração no currículo base (neste formulário de Dados Pessoais) NÃO será refletida no Currículo que aparece na vaga.

								</div>
                                <div class=\"kt-wizard-v4__form\" id=\"div_formacao\">";
        for($i = 1; $i <= $num_formacao; $i++){
                echo "
                                        <div id=\"row_formacao{$i}\">
                                                <fieldset>
                                                        <legend>Formação acadêmica {$i}</legend>
                                                                <div class=\"form-group row\">
                                                                    <div class=\"col-lg-12\">";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Tipo <abbr title="Obrigatório">*</abbr>', "tipo{$i}", $attributes);
                
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
                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\" required=\"required\" oninvalid=\"this.scrollIntoView({block:'center'});\" onchange=\"mostra_carga_horaria({$i})\"");
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
                                                                    <div class=\"col-md-4 col-lg-12\">
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
                echo form_label('Diploma / certificado <abbr title="Obrigatório">*</abbr>', "diploma{$i}", $attributes);
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
				else if(isset($anexos_formacao2[$i])){
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
                                </div>
                                <div class=\"j-footer\">
                                        <div class=\"kt-form__actions\">
                                                <div class=\"col-lg-12 text-center\">
                                                        <button type=\"button\" id=\"adicionar_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar formação</button>
                                                        <button type=\"button\" id=\"remover_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-minus\"></i> Remover formação</button>
                                                </div>
                                        </div>
                                </div>
                                <div class=\"kt-wizard-v4__form\" id=\"div_experiencia\">";
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
                echo "
                                                        <div class=\"form-group row\">
                                                                <div class=\"col-lg-12\">
                                                                ";                                                            
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Cargo <abbr title="Obrigatório">*</abbr>', "cargo{$i}", $attributes);
                echo " 
                                                                    <br />";
                if(!isset($vc_cargo[$i]) || (strlen($vc_cargo[$i]) == 0 && strlen(set_value("cargo{$i}")) > 0) || (strlen(set_value("cargo{$i}")) > 0 && $vc_cargo[$i] != set_value("cargo{$i}"))){
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
                                                                <div class=\"col-lg-12\">
                                                                ";                                                            
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
                                                                <div class=\"col-md-4 col-lg-12\">
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
                if(!isset($pr_experienca[$i]) || (strlen($pr_experienca[$i]) == 0 && strlen(set_value("codigo_experiencia{$i}")) > 0) || (strlen(set_value("codigo_experiencia{$i}")) > 0 && $pr_experienca[$i] != set_value("codigo_experienci{$i}"))){
                        $pr_experienca[$i] = set_value("codigo_experiencia{$i}");
                }
                echo form_input(array('name' => 'codigo_experiencia'.$i, 'type'=>'hidden', 'id' =>'codigo_experiencia'.$i,'value'=>$pr_experienca[$i]));
                //echo form_hidden('codigo_experiencia'.$i, $pr_experienca[$i]);
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
                echo form_upload($attributes, '', 'class="form-control"');
                echo "
																</div>
														</div>
                                                </fieldset>
                                        </div>
                                                                        ";
        }
        echo " 
                                </div>
                                <div class=\"j-footer\" id=\"botoes_experiencia\">
                                        <div class=\"kt-form__actions\">
                                                <div class=\"col-lg-12 text-center\">
                                                        <button type=\"button\" id=\"adicionar_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar exp. profissional</button>
                                                        <button type=\"button\" id=\"remover_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-minus\"></i> Remover exp. profissional</button>
                                                </div>
                                        </div>
                                </div>";
        echo "
                                <div class=\"j-footer\">
                                        <div class=\"kt-form__actions text-center\">";
        $attributes = array('class' => 'btn btn-primary');
        $attributes['id'] = "Salvar";
        echo form_submit('cadastrar', 'Salvar', $attributes);
        echo "
                                                                                                    <a href=\"".base_url()."\" class=\"btn btn-default\"> Cancelar </a>
                                                                                            </div>
                                                                                    </div>
                                                                            </form>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>";
        $pagina['js']="
                        <script type=\"text/javascript\" >
							
                            
        ";
        $pagina['js'] .= "
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

                            $( '#adicionar_formacao' ).click(function() {
                                    var valor_num = $('input[name=num_formacao]').val();
                                    valor_num++;
                                    var newElement = '<div id=\"row_formacao' + valor_num + '\"><div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div><fieldset><legend>Formação acadêmica ' + valor_num + '</legend><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

                                    $attributes = array('class' => 'col-lg-12 col-form-label');
                                    $pagina['js'] .= form_label('Tipo <abbr title="Obrigatório">*</abbr>', "tipo' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<br /><select name=\"tipo' + valor_num + '\" class=\"form-control\" id=\"tipo' + valor_num + '\" required=\"required\" onchange=\"mostra_carga_horaria('+valor_num+')\"><option value=\"\" selected=\"selected\"></option><option value=\"bacharelado\">Graduação - Bacharelado</option><option value=\"tecnologo\">Graduação - Tecnológo</option><option value=\"especializacao\">Pós-graduação - Especialização</option><option value=\"mba\">MBA</option><option value=\"mestrado\">Mestrado</option><option value=\"doutorado\">Doutorado</option><option value=\"posdoc\">Pós-doutorado</option><option value=\"seminario\">Curso/Seminário</option></select></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";                             
                                    $attributes = array('class' => 'col-lg-12 col-form-label');
                                    $pagina['js'] .= form_label('Nome do curso <abbr title="Obrigatório">*</abbr>', "curso' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<br />";
                                    $pagina['js'] .= "<input type=\"text\" name=\"curso' + valor_num + '\" value=\"\" id=\"curso' + valor_num + '\" required=\"required\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
                                    $attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Instituição de ensino <abbr title="Obrigatório">*</abbr>', "instituicao' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<br />";
                                    $pagina['js'] .= "<input type=\"text\" name=\"instituicao' + valor_num + '\" value=\"\" id=\"instituicao' + valor_num + '\" required=\"required\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
                                    
									$attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Data de conclusão <abbr title="Obrigatório">*</abbr>', "conclusao' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<br />";
                                    $pagina['js'] .= "<input type=\"date\" name=\"conclusao' + valor_num + '\" value=\"\" id=\"conclusao' + valor_num + '\" required=\"required\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\" id=\"div_carga_horaria' + valor_num + '\"><div class=\"col-lg-12\">";
                                    
                                    
									$attributes = array('class' => 'col-lg-12 col-form-label');
                                    $pagina['js'] .= form_label('Carga Horária total (considerando 1 dia = 8h) <abbr title="Obrigatório no caso de ser Curso/Seminário">*</abbr>', "conclusao' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<br />";
                                    $pagina['js'] .= "<input type=\"number\" name=\"cargahoraria' + valor_num + '\" value=\"\" id=\"cargahoraria' + valor_num + '\" maxlength=\"4\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
									
                                    $attributes = array('class' => 'col-lg-12 col-form-label');
                                    $pagina['js'] .= form_label('Diploma / comprovante <abbr title="Obrigatório">*</abbr>', "diploma' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<br /><input type=\"file\" name=\"diploma' + valor_num + '\"  class=\"form-control\" required=\"required\" onchange=\"checkFile(this)\" /></div>";
                                    $pagina['js'] .= "</div></fieldset>";
                                    $pagina['js'] .= "</div>';
                                    $( '#div_formacao' ).append( $(newElement) );
                                    $('input[name=num_formacao]').val(valor_num);
                                    $('#div_carga_horaria'+valor_num).hide(); 

                            });
                            $( '#remover_formacao' ).click(function() {
                                    var valor_num = $('input[name=num_formacao]').val();
                                    if($('#codigo_formacao'+valor_num).val()>0){
                                        $.get( \"/Candidatos/delete_formacao/\"+$('#codigo_formacao'+valor_num).val() );
                                    }
                                    $( '#row_formacao' + valor_num ).remove();
                                    
                                    valor_num--;
                                    
                                    $('input[name=num_formacao]').val(valor_num);
                            });        
                                    
                            $( '#adicionar_experiencia' ).click(function() {
                                    var valor_num = $('input[name=num_experiencia]').val();
                                    valor_num++;
                                    
                                    $('input[name=num_experiencia]').val(valor_num);
									document.getElementById('form_dados').submit();
                            });
                            $( '#remover_experiencia' ).click(function() {
                                    var valor_num = $('input[name=num_experiencia]').val();
                                    if($('#codigo_experiencia'+valor_num).val()>0){
                                        
                                        $.get( \"/Candidatos/delete_experiencia/\"+$('#codigo_experiencia'+valor_num).val() );
                                    }
                                    $( '#row_experiencia' + valor_num ).remove();
                                    valor_num--;                                    
                                    $('input[name=num_experiencia]').val(valor_num);
                            });";
        $pagina['js'].=" 
                        </script>
                        <script type=\"text/javascript\">
                            $(document).ready(function(){
									";
		if($navegar == 1){
				
				$pagina['js'].="
									$('html, body').animate({
										scrollTop: $('#botoes_experiencia').offset().top
									}, 'fast');";
			
		}
        for($i = 1; $i <= $num_formacao; $i++){
                $pagina['js'].="
                                    $('#div_carga_horaria{$i}').hide(); 
                                    mostra_carga_horaria({$i});
                                     
                ";
        }
        for($i = 1; $i <= $num_experiencia; $i++){
                $pagina['js'].="
                                    
                                    esconde_data_termino({$i}); 
                ";
        }				
		$pagina['js'].="
                                    
                            });
                        </script>
                       ";
//}
echo "";

$this->load->view('templates/internaRodape', $pagina);
?>