<section class="login-block pt-4 mb-5">

    <div class="container" style="width:100% !important">
        <div class="row">
            <div class="col-sm-12">
                <?php
                $attributes = array('class' => 'md-float-material form-material');
                echo form_open($url, $attributes);
                ?>

                <div class="text-center">
                    <?php echo img(['src' => 'images/logo.png', 'alt' => 'TransformaGov']) ?>
                </div>
                <div class="card" style="width:100% !important">
                    <div class="card-block p-3">
                        <div class="row m-b-20">
                            <div class="col-12">
                                <h3 class="text-center">Para começar, faça seu cadastro</h3>
                            </div>
                        </div>

                        <?php if (strlen($erro) > 0): ?>
                            <div class="alert alert-danger background-danger">
                                <div class="alert-text">
                                    <strong>ERRO</strong>: <?= esc($erro) ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (strlen($sucesso) > 0): ?>
                            <div class="alert background-success">
                                <div class="alert-text">
                                    <strong><?= esc($sucesso) ?></strong>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="form-group form-primary">
                            <?php if (strlen($sucesso) == 0): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Nome completo <abbr title="Obrigatório" class="text-danger">*</abbr>', 'nome', $attributes);

                                            $attributes = array(
                                                'name' => 'nome',
                                                'id' => 'nome',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Nome completo'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('nome'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label');
                                            echo form_label('Nome social', 'nomesocial', $attributes);

                                            $attributes = array(
                                                'name' => 'nome_social',
                                                'id' => 'NomeCompleto',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            echo form_input($attributes, set_value('nome_social'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('CPF <abbr title="Obrigatório" class="text-danger">*</abbr>', 'CPF', $attributes);

                                            $attributes = array(
                                                'name' => 'cpf',
                                                'id' => 'cpf',
                                                'maxlength' => '14',
                                                'type' => 'tel',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'CPF'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('cpf'));
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
                                                'name' => 'rg',
                                                'id' => 'RG',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'RG'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('rg'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Órgão Emissor <abbr title="Obrigatório" class="text-danger">*</abbr>', 'OrgaoEmissor', $attributes);

                                            $attributes = array(
                                                'name' => 'orgao_emissor',
                                                'id' => 'OrgaoEmissor',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Órgao Emissor'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('orgao_emissor'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Gênero <abbr title="Obrigatório" class="text-danger">*</abbr>', 'IdentidadeGenero', $attributes);

                                            if (strstr($erro, "'Gênero'")) {
                                                echo form_dropdown('genero', $candidato->opcoesDeGenero(), set_value('genero'), "class=\"form-control is-invalid\" id=\"IdentidadeGenero\"");
                                            } else {
                                                echo form_dropdown('genero', $candidato->opcoesDeGenero(), set_value('genero'), "class=\"form-control\" id=\"IdentidadeGenero\"");
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

                                            if (strstr($erro, "'Raça'")) {
                                                echo form_dropdown('raca', $candidato->opcoesDeRaca(), set_value('raca'), "class=\"form-control is-invalid\" id=\"Raca\"");
                                            } else {
                                                echo form_dropdown('raca', $candidato->opcoesDeRaca(), set_value('raca'), "class=\"form-control\" id=\"Raca\"");
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
                                                'name' => 'email',
                                                'id' => 'Email',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'E-mail'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('email'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Telefone <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Telefone', $attributes);

                                            $attributes = array(
                                                'name' => 'telefone',
                                                'id' => 'Telefone',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Telefone'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('telefone'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Telefone opcional', 'TelefoneOpcional', $attributes);

                                            $attributes = array(
                                                'name' => 'telefone_opcional',
                                                'id' => 'TelefoneOpcional',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            echo form_input($attributes, set_value('telefone_opcional'));
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
                                                'name' => 'data_nascimento',
                                                'id' => 'DataNascimento',
                                                'maxlength' => '15',
                                                'class' => 'form-control text-box single-line',
                                                'type' => "date"
                                            );
                                            if (strstr($erro, 'Data de nascimento')) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('data_nascimento'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('LinkedIn', 'LinkedIn', $attributes);

                                            $attributes = array(
                                                'name' => 'linkedin',
                                                'id' => 'LinkedIn',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line',
                                                'placeholder' => 'https://www.linkedin.com/in/'
                                            );
                                            echo form_input($attributes, set_value('linkedin'));
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
                                                'name' => 'cep',
                                                'id' => 'CEP',
                                                'maxlength' => '9',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'CEP'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('cep'), " onblur=\"pesquisacep(this.value);\"");
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
                                                'name' => 'logradouro',
                                                'id' => 'Logradouro',
                                                'maxlength' => '250',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Logradouro'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('logradouro'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Número <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Numero', $attributes);

                                            $attributes = array(
                                                'name' => 'numero',
                                                'id' => 'Numero',
                                                'maxlength' => '10',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Número'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('numero'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Complemento', 'Complemento', $attributes);

                                            $attributes = array(
                                                'name' => 'complemento',
                                                'id' => 'Complemento',
                                                'maxlength' => '10',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            echo form_input($attributes, set_value('complemento'));
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
                                                'name' => 'bairro',
                                                'id' => 'Bairro',
                                                'maxlength' => '150',
                                                'class' => 'form-control text-box single-line'
                                            );
                                            if (strstr($erro, "'Bairro'")) {
                                                $attributes['class'] = 'form-control text-box single-line is-invalid';
                                            }
                                            echo form_input($attributes, set_value('bairro'));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Estado <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Estado', $attributes);
                                            if (strstr($erro, "'Estado'")) {
                                                echo form_dropdown('estado', $Estados, set_value('estado'), "class=\"form-control is-invalid\" id=\"Estado\"");
                                            } else {
                                                echo form_dropdown('estado', $Estados,
                                                    set_value('estado'), "class=\"form-control\" id=\"Estado\"");
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php
                                            $attributes = array('class' => 'control-label font-weight-bold');
                                            echo form_label('Município <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Municipio', $attributes);
                                            if (strstr($erro, "'município'")) {
                                                echo form_dropdown('municipio', [], set_value('municipio'), "class=\"form-control is-invalid\" id=\"Municipio\"");
                                            } else {
                                                echo form_dropdown('municipio', [], set_value('municipio'), "class=\"form-control\" id=\"Municipio\"");
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
                                                                    'name' => 'exigencias_comuns',
                                                                    'value' => '1'
                                                                );
                                                                echo form_radio($attributes, set_value('exigencias_comuns'), (set_value('exigencias_comuns') == '1' && strlen(set_value('exigencias_comuns')) > 0));
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
                                                                    'name' => 'exigencias_comuns',
                                                                    'value' => '0'
                                                                );
                                                                echo form_radio($attributes, set_value('exigencias_comuns'), (set_value('exigencias_comuns') == '0' && strlen(set_value('exigencias_comuns')) > 0));
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
                                                                    'name' => 'sentenciado',
                                                                    'value' => '1'
                                                                );
                                                                echo form_radio($attributes, set_value('sentenciado'), (set_value('sentenciado') == '1' && strlen(set_value('sentenciado')) > 0));
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
                                                                    'name' => 'sentenciado',
                                                                    'value' => '0'
                                                                );
                                                                echo form_radio($attributes, set_value('sentenciado'), (set_value('sentenciado') == '0' && strlen(set_value('sentenciado')) > 0));
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
                                                $attributes = array('name' => 'processo_disciplinar', 'value' => '1'); echo form_radio($attributes, set_value('processo_disciplinar'), (set_value('processo_disciplinar') == '1' && strlen(set_value('processo_disciplinar')) > 0));
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
                                                                $attributes = array('name' => 'processo_disciplinar', 'value' => '0');
                                                                echo form_radio($attributes, set_value('processo_disciplinar'), (set_value('processo_disciplinar') == '0' && strlen(set_value('processo_disciplinar')) > 0));
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
                                                                $attributes = array('name' => 'ajustamento_funcional_por_doenca', 'value' => '1');
                                                                echo form_radio($attributes, set_value('ajustamento_funcional_por_doenca'), (set_value('ajustamento_funcional_por_doenca') == '1' && strlen(set_value('ajustamento_funcional_por_doenca')) > 0));
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
                                                                $attributes = array('name' => 'ajustamento_funcional_por_doenca', 'value' => '0');
                                                                echo form_radio($attributes, set_value('ajustamento_funcional_por_doenca'), (set_value('ajustamento_funcional_por_doenca') == '0' && strlen(set_value('ajustamento_funcional_por_doenca')) > 0));
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
                                        $attributes = array('name' => 'aceito_termo', 'value' => '1');
                                        echo form_checkbox($attributes, set_value('aceito_termo'), (set_value('aceito_termo') == '1' && strlen(set_value('aceito_termo')) > 0));
                                        ?>

                                        <span class="font-weight-bold">Li e estou de acordo com o <a href="<?= base_url('Publico/download_termo/responsabilidade') ?>" target="_blank"><u>termo de responsabilidade</u>.</a></span>
                                        <abbr title="Obrigatório" class="text-danger">*</abbr><br />
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="col-12">
                                        <?php
                                        $attributes = array('name' => 'aceite_privacidade', 'value' => '1');
                                        echo form_checkbox($attributes, set_value('aceite_privacidade'), (set_value('aceite_privacidade') == '1' && strlen(set_value('aceite_privacidade')) > 0));
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
                                    <a href="/" style="font-size: 1.3rem;color: #6c7293;display: inline-block;">Já possui cadastro na plataforma?</a>
                                </div>
                            </form>
                        <?php endif ?>
                        </div>
                    </div>
                </div>


                <div class="text-center" style="margin-top: 10px">
                        <br/>SUGESP - Fundação Lemann - Pencillabs
                </div>
            </div>
        </div>
    </div>
</section>


<script>
$(document).ready(function() {
    $('#Estado').change(function(){
            var estado = $('#Estado').val();
            if(estado != ''){
                    $.ajax({
                            url: `/candidato/recupera_municipios/${estado}`,
                            method:"GET",
                            success:function(data){
                                    $('#Municipio').html(data);
                            }
                    })
            }
    });

    var cpfElement = document.getElementById("cpf");
    Inputmask('999.999.999-99').mask(cpfElement);
});
</script>
