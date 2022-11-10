<?php
defined('BASEPATH') or exit('No direct script access allowed');

$pagina['menu1'] = $menu1;
$pagina['menu2'] = $menu2;
$pagina['url'] = $url;
$pagina['nome_pagina'] = $nome_pagina;
if (isset($adicionais)) {
    $pagina['adicionais'] = $adicionais;
}

$this->load->view('templates/publicoCabecalho');

?>

<section class="login-block pt-4 mb-5">
    <!-- Container-fluid starts -->
    <div class="container" style="width:100% !important">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <?php
                $attributes = array('class' => 'md-float-material form-material');
                echo form_open($url, $attributes);
                ?>

                <div class="text-center">
                    <img src="<?= base_url('images/logo-tagline.png') ?>" alt="<?= $this->config->item('nome') ?>" />
                </div>
                <div class="card" style="width:100% !important">
                    <div class="card-block p-3">
                        <div class="row m-b-20">
                            <div class="col-12">
                                <h3 class="text-center"><?= $nome_pagina ?></h3>
                            </div>
                        </div>

                        <?php if (strlen($erro) > 0) : ?>
                            <?php if (isset($candidato)) : ?>
                                <?php if ($candidato->in_exigenciasComuns == '0' || $candidato->bl_sentenciado == '1' || $candidato->bl_processoDisciplinar == '1' || $candidato->bl_ajustamentoFuncionalPorDoenca == '1') : ?>
                                    <div class="text-center center-block">
                                        <button type="reset" class="btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase" onclick="window.location='<?= base_url('Candidatos/recuperar/' . set_value('CPF')) ?>';">
                                            Recuperar candidato reprovado
                                        </button>
                                    </div>
                                <?php endif ?>
                            <?php endif // isset($candidato)
                            ?>

                            <div class="alert alert-danger background-danger">
                                <div class="alert-text">
                                    <strong>ERRO</strong>: <?= $erro ?>
                                </div>
                            </div>

                        <?php endif // strlen($erro)>0
                        ?>

                        <?php if (strlen($sucesso) > 0) : ?>

                            <div class="alert background-success">
                                <div class="alert-text">
                                    <strong><?= $sucesso ?></strong>
                                </div>
                            </div>
                        <?php endif // strlen($sucesso)>0
                        ?>

                        <div class="form-group form-primary">
                            <?php if (strlen($sucesso) == 0) : ?>
                                <?php
                                $attributes = array('class' => 'kt-form');
                                echo form_open($url, $attributes);
                                ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Nome completo <abbr title="Obrigatório" class="text-danger">*</abbr>', 'nome', $attributes);

                                            $attributes = array(
                                                'name' => 'NomeCompleto',
                                                'id' => 'NomeCompleto',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Nome completo'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('NomeCompleto'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label');
                                            echo form_label('Nome social', 'nomesocial', $attributes);

                                            $attributes = array(
                                                'name' => 'NomeSocial',
                                                'id' => 'NomeCompleto',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            echo form_input($attributes, set_value('NomeSocial'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('CPF <abbr title="Obrigatório" class="text-danger">*</abbr>', 'CPF', $attributes);

                                            $attributes = array(
                                                'name' => 'CPF',
                                                'id' => 'CPF',
                                                'maxlength' => '14',
                                                'type' => 'tel',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'CPF'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('CPF'));
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('RG <abbr title="Obrigatório" class="text-danger">*</abbr>', 'RG', $attributes);

                                            $attributes = array(
                                                'name' => 'RG',
                                                'id' => 'RG',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'RG'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('RG'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Órgão Emissor <abbr title="Obrigatório" class="text-danger">*</abbr>', 'OrgaoEmissor', $attributes);

                                            $attributes = array(
                                                'name' => 'OrgaoEmissor',
                                                'id' => 'OrgaoEmissor',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Órgao Emissor'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('OrgaoEmissor'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Gênero <abbr title="Obrigatório" class="text-danger">*</abbr>', 'IdentidadeGenero', $attributes);

                                            $attributes = array(
                                                0 => '',
                                                1 => 'Não informado',
                                                2 => 'Masculino',
                                                3 => 'Feminino',
                                                4 => 'Prefiro não declarar'
                                            );
                                            if (strstr($erro, "'Gênero'")) {
                                                echo form_dropdown('IdentidadeGenero', $attributes, set_value('IdentidadeGenero'), "class=\"form-control is-invalid\" id=\"IdentidadeGenero\"");
                                            } else {
                                                echo form_dropdown('IdentidadeGenero', $attributes, set_value('IdentidadeGenero'), "class=\"form-control\" id=\"IdentidadeGenero\"");
                                            }
                                            ?>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Raça <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Raca', $attributes);

                                            $attributes = array(
                                                0 => '',
                                                1 => 'Não informado',
                                                2 => 'Amarela',
                                                3 => 'Branca',
                                                4 => 'Indígena',
                                                5 => 'Parda',
                                                6 => 'Preta',
                                                7 => 'Prefiro não declarar',
                                            );
                                            if (strstr($erro, "'Raça'")) {
                                                echo form_dropdown('Raca', $attributes, set_value('Raca'), "class=\"form-control is-invalid\" id=\"Raca\"");
                                            } else {
                                                echo form_dropdown('Raca', $attributes, set_value('Raca'), "class=\"form-control\" id=\"Raca\"");
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('E-mail <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Email', $attributes);

                                            $attributes = array(
                                                'name' => 'Email',
                                                'id' => 'Email',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'E-mail'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('Email'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Telefone <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Telefone', $attributes);

                                            $attributes = array(
                                                'name' => 'Telefone',
                                                'id' => 'Telefone',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Telefone'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('Telefone'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Telefone opcional', 'TelefoneOpcional', $attributes);

                                            $attributes = array(
                                                'name' => 'TelefoneOpcional',
                                                'id' => 'TelefoneOpcional',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            echo form_input($attributes, set_value('TelefoneOpcional'));
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Data de nascimento <abbr title="Obrigatório" class="text-danger">*</abbr>', 'DataNascimento', $attributes);

                                            $attributes = array(
                                                'name' => 'DataNascimento',
                                                'id' => 'DataNascimento',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, 'Data de nascimento')) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('DataNascimento'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('LinkedIn', 'LinkedIn', $attributes);

                                            $attributes = array(
                                                'name' => 'LinkedIn',
                                                'id' => 'LinkedIn',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line',
                                                'placeholder' => 'https://www.linkedin.com/in/'
                                            );
                                            echo form_input($attributes, set_value('LinkedIn'));
                                            ?>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('CEP <abbr title="Obrigatório" class="text-danger">*</abbr>', 'CEP', $attributes);

                                            $attributes = array(
                                                'name' => 'CEP',
                                                'id' => 'CEP',
                                                'maxlength' => '9',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'CEP'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('CEP'), " onblur=\"pesquisacep(this.value);\"");
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Logradouro <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Logradouro', $attributes);

                                            $attributes = array(
                                                'name' => 'Logradouro',
                                                'id' => 'Logradouro',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Logradouro'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('Logradouro'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Número <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Numero', $attributes);

                                            $attributes = array(
                                                'name' => 'Numero',
                                                'id' => 'Numero',
                                                'maxlength' => '10',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Número'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('Numero'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Complemento', 'Complemento', $attributes);

                                            $attributes = array(
                                                'name' => 'Complemento',
                                                'id' => 'Complemento',
                                                'maxlength' => '10',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            echo form_input($attributes, set_value('Complemento'));
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Bairro', 'Bairro', $attributes);

                                            $attributes = array(
                                                'name' => 'Bairro',
                                                'id' => 'Bairro',
                                                'maxlength' => '150',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Bairro'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('Bairro'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php
                                            $Estados = array(0 => '') + $Estados;
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Estado <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Estado', $attributes);
                                            if (strstr($erro, "'Estado'")) {
                                                echo form_dropdown('Estado', $Estados, set_value('Estado'), "class=\"form-control is-invalid\" id=\"Estado\"");
                                            } else {
                                                echo form_dropdown('Estado', $Estados, set_value('Estado'), "class=\"form-control\" id=\"Estado\"");
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Município <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Municipio', $attributes);
                                            if (strstr($erro, "'Município'")) {
                                                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control is-invalid\" id=\"Municipio\"");
                                            } else {
                                                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control\" id=\"Municipio\"");
                                            }
                                            echo form_input(array('name' => 'TransformaMinas', 'type' => 'hidden', 'id' => 'TransformaMinas', 'value' => '1'));
                                            ?>

                                        </div>
                                    </div>
                                </div>





                                <div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <?php
                                                $attributes = array('class' => 'control-label font-weight-bold');
                                                echo form_label('Você atende a todos os pré-requisitos abaixo? <abbr title="Obrigatório" class="text-danger">*</abbr><br />', 'Requisitos', $attributes);
                                                ?>

                                                <ul>
                                                    <li> - Possuir ensino superior completo.</li>
                                                    <li> - Possuir nacionalidade brasileira ou ser naturalizado brasileiro.</li>
                                                    <li> - Estar em dia com os direitos políticos.</li>
                                                    <li> - Estar em dia com as obrigações eleitorais.</li>
                                                    <li> - Estar em dia com as obrigações do Serviço Militar, para o candidato do sexo masculino.</li>
                                                    <li> - Estar em situação regular junto à Receita Federal do Brasil.</li>
                                                    <li> - Não participar da gerência ou administração de alguma empresa comercial ou industrial.</li>
                                                    <li> - Não exercer comércio ou participar de sociedade comercial (exceto como acionista, quotista ou comandatário).</li>
                                                </ul><br />
                                                <div class="col-xl-6 col-lg-8">
                                                    <div class="input-group" style="margin-bottom:0px;">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array(
                                                                    'name' => 'Requisitos',
                                                                    'value' => '1'
                                                                );
                                                                echo form_radio($attributes, set_value('Requisitos'), (set_value('Requisitos') == '1' && strlen(set_value('Requisitos')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control <?= strstr($erro, "'Pré-requisitos'") ? 'is-invalid' : '' ?>" value="Sim, atendo a todos os pré-requisitos" readonly="readonly" style="background-color:white!important" />


                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array(
                                                                    'name' => 'Requisitos',
                                                                    'value' => '0'
                                                                );
                                                                echo form_radio($attributes, set_value('Requisitos'), (set_value('Requisitos') == '0' && strlen(set_value('Requisitos')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control <?= strstr($erro, "'Pré-requisitos'") ? 'is-invalid' : '' ?>" value="Não atendo a um ou mais dos pré-requisitos" readonly="readonly" style="background-color:white!important" />
                                                    </div>
                                                </div </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <?php
                                                $attributes = array('class' => 'control-label font-weight-bold font-weight-bold');
                                                echo form_label('Você está, ou esteve, nos últimos cinco anos, sofrendo efeitos de sentença penal condenatória? <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Sentenciado', $attributes);
                                                ?>

                                                <div class="col-xl-2 col-lg-4">
                                                    <div class="input-group" style="margin-bottom:0px;">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array(
                                                                    'name' => 'Sentenciado',
                                                                    'value' => '1'
                                                                );
                                                                echo form_radio($attributes, set_value('Sentenciado'), (set_value('Sentenciado') == '1' && strlen(set_value('Sentenciado')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control <?= strstr($erro, "'Você está, ou esteve, nos últimos cinco anos, sofrendo efeitos de sentença penal condenatória?'") ? 'is-invalid' : '' ?>" value="Sim" readonly="readonly" style="background-color:white!important" />

                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array(
                                                                    'name' => 'Sentenciado',
                                                                    'value' => '0'
                                                                );
                                                                echo form_radio($attributes, set_value('Sentenciado'), (set_value('Sentenciado') == '0' && strlen(set_value('Sentenciado')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control <?= strstr($erro, "'Você está, ou esteve, nos últimos cinco anos, sofrendo efeitos de sentença penal condenatória?'") ? 'is-invalid' : '' ?>" value="Não" readonly="readonly" style="background-color:white!important" />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <?php
                                                $attributes = array('class' => 'control-label font-weight-bold');
                                                echo form_label('Você foi condenado em algum processo disciplinar administrativo em órgão integrante da administração pública direta ou indireta, nos cinco anos anteriores à data de publicação desta vaga? <abbr title="Obrigatório" class="text-danger">*</abbr>', 'ProcessoDisciplinar', $attributes);
                                                ?>

                                                <div class="col-xl-2 col-lg-4">
                                                    <div class="input-group" style="margin-bottom:0px;">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array('name' => 'ProcessoDisciplinar', 'value' => '1');
                                                                echo form_radio($attributes, set_value('ProcessoDisciplinar'), (set_value('ProcessoDisciplinar') == '1' && strlen(set_value('ProcessoDisciplinar')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>
                                                    <?php if (strstr($erro, "'Você foi condenado em algum processo disciplinar administrativo em órgão integrante da administração pública direta ou indireta, nos cinco anos anteriores à data de publicação desta vaga?'")) : ?>
                                                        <input type="text" class="form-control is-invalid" value="Sim" readonly="readonly" style="background-color:white!important" />
                                                    <?php else : ?>
                                                        <input type="text" class="form-control" value="Sim" readonly="readonly" style="background-color:white!important" />
                                                    <?php endif ?>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array('name' => 'ProcessoDisciplinar', 'value' => '0');
                                                                echo form_radio($attributes, set_value('ProcessoDisciplinar'), (set_value('ProcessoDisciplinar') == '0' && strlen(set_value('ProcessoDisciplinar')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>

                                                        <?php if (strstr($erro, "'Você foi condenado em algum processo disciplinar administrativo em órgão integrante da administração pública direta ou indireta, nos cinco anos anteriores à data de publicação desta vaga?'")) : ?>
                                                            <input type="text" class="form-control is-invalid" value="Não" readonly="readonly" style="background-color:white!important" />
                                                        <?php else : ?>
                                                            <input type="text" class="form-control" value="Não" readonly="readonly" style="background-color:white!important" />
                                                        <?php endif ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <?php
                                                $attributes = array('class' => 'control-label font-weight-bold');
                                                echo form_label('Você está em ajustamento funcional por motivo de doença que impeça o exercício do cargo para o qual está se candidatando? <abbr title="Obrigatório" class="text-danger">*</abbr>', 'AjustamentoFuncionalPorDoenca', $attributes);
                                                ?>



                                                <div class="col-xl-2 col-lg-4">
                                                    <div class="input-group" style="margin-bottom:0px;">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array('name' => 'AjustamentoFuncionalPorDoenca', 'value' => '1');
                                                                echo form_radio($attributes, set_value('AjustamentoFuncionalPorDoenca'), (set_value('AjustamentoFuncionalPorDoenca') == '1' && strlen(set_value('AjustamentoFuncionalPorDoenca')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>

                                                        <?php if (strstr($erro, "'Você está em ajustamento funcional por motivo de doença que impeça o exercício do cargo para o qual está se candidatando?'")) : ?>
                                                            <input type="text" class="form-control is-invalid" value="Sim" readonly="readonly" style="background-color:white!important" />
                                                        <?php else : ?>
                                                            <input type="text" class="form-control" value="Sim" readonly="readonly" style="background-color:white!important" />
                                                        <?php endif ?>

                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <?php
                                                                $attributes = array('name' => 'AjustamentoFuncionalPorDoenca', 'value' => '0');
                                                                echo form_radio($attributes, set_value('AjustamentoFuncionalPorDoenca'), (set_value('AjustamentoFuncionalPorDoenca') == '0' && strlen(set_value('AjustamentoFuncionalPorDoenca')) > 0));
                                                                ?>

                                                            </div>
                                                        </div>

                                                        <?php if (strstr($erro, "'Você está em ajustamento funcional por motivo de doença que impeça o exercício do cargo para o qual está se candidatando?'")) : ?>
                                                            <input type="text" class="form-control is-invalid" value="Não" readonly="readonly" style="background-color:white!important" />
                                                        <?php else : ?>
                                                            <input type="text" class="form-control" value="Não" readonly="readonly" style="background-color:white!important" />
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px; margin-bottom: 10px;">
                                    <div class="col-12">
                                        <?php
                                        $attributes = array('name' => 'AceiteTermo', 'value' => '1');
                                        echo form_checkbox($attributes, set_value('AceiteTermo'), (set_value('AceiteTermo') == '1' && strlen(set_value('AceiteTermo')) > 0));
                                        ?>

                                        <span class="font-weight-bold">Li e estou de acordo com o <a href="<?= base_url('Publico/download_termo/responsabilidade') ?>" target="_blank"><u>termo de responsabilidade</u>.</a></span>
                                        <abbr title="Obrigatório" class="text-danger">*</abbr><br />
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-12">
                                        <?php
                                        $attributes = array('name' => 'AceitePrivacidade', 'value' => '1');
                                        echo form_checkbox($attributes, set_value('AceitePrivacidade'), (set_value('AceitePrivacidade') == '1' && strlen(set_value('AceitePrivacidade')) > 0));
                                        ?>
                                        <span class="font-weight-bold">Li e estou de acordo com a <a href="<?= base_url('Publico/download_termo/privacidade') ?>" target="_blank"><u>política de privacidade</u>.</a></span>
                                        <abbr title="Obrigatório" class="text-danger">*</abbr><br />
                                    </div>
                                </div>

                                <div class="text-center center-block">
                                    <?php
                                    $attributes = array(
                                        'class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
                                        'style' => 'width:60%'
                                    );
                                    echo form_submit('cadastrar', 'Cadastre-se', $attributes);
                                    ?>

                                </div>
                                <hr />
                                <div class="text-center center-block">
                                    <a href="<?= base_url('Publico/index') ?>" style="font-size: 1.3rem;color: #6c7293;display: inline-block;">Já possui cadastro na plataforma?</a>
                                </div>
                                </form>
                        </div>
                    </div>
                </div>


                <?php
                                echo "<script type=\"text/javascript\" >";

                                if (set_value('TransformaMinas') == '1') {
                                    echo "document.getElementById('div_transformaminas').style.display='block';";
                                }

                                echo "
                    function limpa_formulário_cep() {
                            //Limpa valores do formulário de cep.
                            document.getElementById('Logradouro').value=(\"\");
                            document.getElementById('Bairro').value=(\"\");
                            document.getElementById('Municipio').value=(\"\");
                            document.getElementById('Estado').value=(\"\");
                    }

                    function meu_callback(conteudo) {
                            if (!(\"erro\" in conteudo)) {
                                    //Atualiza os campos com os valores.
                                    document.getElementById('Logradouro').value=(conteudo.logradouro);
                                    document.getElementById('Bairro').value=(conteudo.bairro);
                                    //document.getElementById('Estado').value=(conteudo.uf);

                                    var opts = document.getElementById('Estado').options;
                                    for (var opt, j = 0; opt = opts[j]; j++) {
                                            if (opt.text == conteudo.uf) {
                                                    document.getElementById('Estado').selectedIndex = j;
                                                    break;
                                            }
                                    }
                                    $(document).ready(function(){
                                            var estado = $('#Estado').val();
                                            if(estado != ''){
                                                    $.ajax({
                                                            url:\"" . base_url() . "Candidatos/fetch_Municipios\",
                                                            method:\"POST\",
                                                            data:{estado:estado},
                                                            success:function(data){
                                                                    $('#Municipio').html(data);
                                                                    $('#Municipio option').each(function () {
                                                                            if ($(this).html() == conteudo.localidade.toUpperCase()) {
                                                                                $(this).attr('selected', 'selected');
                                                                                return;
                                                                            }
                                                                    });
                                                            }
                                                    })
                                            }
                                    });
                                    //document.getElementById('Municipio').value=(conteudo.localidade);
                                    document.getElementById('Numero').focus();
                            }
                            else {
                                    //CEP não Encontrado.
                                    limpa_formulário_cep();
                                    alert(\"CEP não encontrado.\");
                            }
                    }

                    function pesquisacep(valor) {

                        //Nova variável \"cep\" somente com dígitos.
                        var cep = valor.replace(/\D/g, '');

                        //Verifica se campo cep possui valor informado.
                        if (cep != '') {

                            //Expressão regular para validar o CEP.
                            var validacep = /^[0-9]{8}$/;

                            //Valida o formato do CEP.
                            if(validacep.test(cep)) {
                                //Preenche os campos com \"...\" enquanto consulta webservice.
                                document.getElementById('Logradouro').value=\"...\";
                                document.getElementById('Bairro').value=\"...\";

                                //Cria um elemento javascript.
                                var script = document.createElement('script');

                                //Sincroniza com o callback.
                                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                                //Insere script no documento e carrega o conteúdo.
                                document.body.appendChild(script);

                            }
                            else {
                                //cep é inválido.
                                limpa_formulário_cep();
                                alert('Formato de CEP inválido.');
                            }
                        }
                        else {
                            //cep sem valor, limpa formulário.
                            limpa_formulário_cep();
                        }
                    };
                </script>";

                                $pagina['js'] = "
                <script type=\"text/javascript\">
                    $(document).ready(function(){
                            $('#CPF').inputmask('999.999.999-99');
                            $('#DataNascimento').inputmask('99/99/9999');
                            $('#CEP').inputmask('99999-999');
                            $('#Telefone').inputmask('(99)99999-9999');
                            $('#TelefoneOpcional').inputmask('(99)99999-9999');

                            ";
                                if (set_value('Nacionalidade') != 'Brasil' && strlen(set_value('Nacionalidade'))) {
                                    $pagina['js'] .= "
                                $('#div_cidadeestrangeira').show();";
                                }
                                $pagina['js'] .= "
                            $('#IdentidadeGenero').change(function(){
                                    if($(this).val()==4){
                                        $('#IdentidadeGeneroOptativa').prop('disabled', false);
                                    }
                                    else{
                                        $('#IdentidadeGeneroOptativa').prop('disabled', true);
                                        $('#IdentidadeGeneroOptativa').val('');
                                    }
                            });
                            if($('#IdentidadeGenero').val()==4){
                                $('#IdentidadeGeneroOptativa').prop('disabled', false);
                            }
                            else{
                                $('#IdentidadeGeneroOptativa').prop('disabled', true);
                                $('#IdentidadeGeneroOptativa').val('');
                            }
                            $('#Estado').change(function(){
                                    var estado = $('#Estado').val();
                                    if(estado != ''){
                                            $.ajax({
                                                    url:\"" . base_url() . "Candidatos/fetch_Municipios\",
                                                    method:\"POST\",
                                                    data:{estado:estado},
                                                    success:function(data){
                                                            $('#Municipio').html(data);
                                                    }
                                            })
                                    }
                            });
                            $('#Estado').trigger('change');
                            $('#CEP').trigger('onblur');
                    });
                </script>";
                ?>
            <?php endif // strlen($sucesso) == 0
            ?>

            <?php $this->load->view('templates/publicoRodape', $pagina) ?>