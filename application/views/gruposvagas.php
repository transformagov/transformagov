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
                                            <h4><i class=<?php $icone; ?> style="color:black"></i> &nbsp; <?php $nome_pagina; ?> </h4>
                                            </div>

                                            <?php if ($menu2 == "index"): ?>
                                                <div class="col-lg-4 text-right">
                                                <a href='<?php echo base_url(
                                                	"GruposVagas/create"
                                                ); ?>' class="btn btn-primary btn-square"> <i class="fa fa-plus-circle"></i> Novo grupo de vagas </a>
                                                        <br />
                                                        <a href='<?php echo base_url(
                                                        	"GruposVagas/historico_duplicate_total"
                                                        ); ?>' class="btn btn-warning btn-square"> <i class="fa fa-lg mr-0 fa-sort-amount-down"></i> Histórico de duplicações </a>
                                                        <a href='<?php echo base_url(
                                                        	"GruposVagas/historico_duplicate_quantitativo"
                                                        ); ?>' class="btn btn-danger btn-square"> <i class="fa fa-lg mr-0 fa-sort-amount-down"></i> Quantitativo de duplicações </a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (
                                            $menu2 != "index" &&
                                            strlen($sucesso) == 0 &&
                                            ($menu2 == "create" || $menu2 == "edit" || $menu2 == "questoes")
                                            ): ?>
                                                <div class="col-lg-4 text-right">
                                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('form_gruposvagas').submit();"> Salvar </button>
                                                    <button type="button" class="btn btn-outline-dark" onclick="window.location='<?php echo base_url("GruposVagas/index"); ?>'">Cancelar</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>

<?php

if ($menu2 == "index") {
    $this->load->view("gruposvagas/tabela_gruposvagas");
} elseif ($menu2 == "create" || $menu2 == "edit") {
    $this->load->view("gruposvagas/edita_gruposvagas");
} elseif ($menu2 == "duplicate") {
    $this->load->view("gruposvagas/duplica_gruposvagas");
} elseif ($menu2 == "historico_duplicate") {
    $this->load->view("gruposvagas/historico_duplica_gruposvagas");
} elseif ($menu2 == "historico_duplicate_total") {
    $this->load->view("gruposvagas/historico_duplica_total_gruposvagas");
} elseif ($menu2 == "historico_duplicate_quantitativo") {
    $this->load->view("gruposvagas/historico_duplica_quantitativo");
} elseif ($menu2 == "create_motivacao") {
    $this->load->view("gruposvagas/historico_cria_motivacao");
} else {
	if (strlen($erro) > 0) {
		echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>"; //$erro='';
	} elseif (strlen($sucesso) > 0) {
		echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
	}
}
?>
        </div>
</div>

<?php $this->load->view("templates/internaRodape", $pagina); ?>

