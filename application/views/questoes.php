<?php

defined("BASEPATH") or exit("No direct script access allowed");

$pagina["menu1"] = $menu1;
$pagina["menu2"] = $menu2;
$pagina["url"] = $url;
$pagina["nome_pagina"] = $nome_pagina;
$pagina["icone"] = $icone;
if (isset($adicionais)) {
	$pagina["adicionais"] = $adicionais;
}

$this->load->view("templates/internaCabecalho", $pagina);
?>

<div class="col-12">
    <div class="tsm-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row sub-title" style="letter-spacing:0px">
                                        <div class="col-lg-8">
                                            <h4>
                                                <i class="<?php $icone; ?>" style="color:black"></i> &nbsp; <?php $nome_pagina; ?>
                                                <?php if (
                                                	$menu2 == "index" ||
                                                	$menu2 == "create"
                                                ): ?>
                                                    Grupo de vagas: <?php $grupos[0]->vc_grupovaga; ?>
                                                <?php endif; ?>
                                            </h4>
                                        </div>

                                        <?php if (
                                        	$menu2 == "index" &&
                                        	$this->Questoes_model->grupo_de_questoes_nao_vigente(
                                        		$etapas,
                                        		$questoes
                                        	)
                                        ): ?>
                                            <div class="col-lg-4 text-right"> <a href='<?php echo base_url(
                                            "Questoes/create/" . $grupo
                                            ) ?>' class="btn btn-primary btn-square"> <i class="fa fa-plus-circle"></i> Nova questão neste grupo </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (
                                            $menu2 != "index" &&
                                            strlen($sucesso) == 0 &&
                                            ($menu2 == "create" || $menu2 == "edit" || $menu2 == "questoes")
                                        ): ?>
                                            <div class="col-lg-4 text-right">
                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('form_questoes').submit();"> Salvar </button>
                                                <button type="button" class="btn btn-outline-dark" onclick="window.location='<?php echo base_url("Questoes/index/" . $grupo) ?>'" >Cancelar</button>
                                            </div>
                                        <?php endif; ?>
                                    </div>

<?php
if ($menu2 == "index") {
	$this->load->view("questoes/tabela_de_questoes");
} elseif ($menu2 == "create" || $menu2 == "edit") {
	$this->load->view("questoes/criar_editar_questao");
} elseif ($menu2 == "view") {
	$this->load->view("questoes/visualiza_questao");
} else {
	echo "
                                                                    <div class=\"kt-portlet__body\">";
	if (strlen($erro) > 0) {
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
	} elseif (strlen($sucesso) > 0) {
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

$this->load->view("templates/internaRodape", $pagina);

