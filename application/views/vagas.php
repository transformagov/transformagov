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

<div class=col-12>
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
                                                <i class=<?php $icone; ?> style="color:black"></i> 
                                                &nbsp; <?php echo $nome_pagina; ?>  <?php echo $menu_vc_vaga; ?> 
                                            </h4>
                                        </div> 
                                <?php if ($perfil_pode_adicionar_vaga): ?>
                                    <div class="col-lg-4 text-right">
                                        <a href=<?php echo base_url(
                                        "Vagas/create"
                                        ); ?> class="btn btn-primary btn-square"><i class="fa fa-plus-circle"></i> Nova vaga </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($criar_ou_editar_vaga): ?>
                                    <div class="col-lg-4 text-right">
                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('form_vagas').submit();"> Salvar </button>
                                            <button type="button" class="btn btn-outline-dark" onclick="window.location='<?php echo base_url(
                                            	"Vagas/index"
                                            ); ?>'" ?>>Cancelar</button>
                                    </div>;
                                <?php endif; ?>
                                <div class="col-lg-4 text-right">
                                <?php if (
                                	$menu2 == "resultado" &&
                                	$vagas[0]->bl_finalizado != "1" &&
                                	$this->session->perfil != "avaliador"
                                ): ?>
                                    <?php if ($aprovado): ?>
                                        <button type="button" class="btn btn-danger" onclick="confirm_reprovacao2("<?php $vagas[0]
                                        	->pr_vaga; ?>");"> Finalizar vaga </button>
                                    <?php endif; ?>
                                <button type="button" class="btn btn-primary btn-square" onclick="window.location='<?php echo base_url(
                                	"Vagas/recalcular_nota/" . $vagas[0]->pr_vaga
                                ); ?>'" >Recalcular nota bruta</button>
                                <button type="button" class="btn btn-primary btn-square" onclick="window.location='<?php echo base_url(
                                	"Vagas/resultado3/" . $vagas[0]->pr_vaga
                                ); ?>'" >Reprovadas na Habilitação</button>
                                <button type="button" class="btn btn-primary btn-square" onclick="window.location='<?php base_url(
                                	"Vagas/resultado2/" . $vagas[0]->pr_vaga
                                ); ?>'" >Detalhamento por competência</button>
                                <?php endif; ?>

                                    </div>

<?php
if ($menu2 == "resultado2" || $menu2 == "resultado3") {
	echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary btn-square\" onclick=\"window.location='" .
		base_url("Vagas/resultado/" . $vagas[0]->pr_vaga) .
		"'\">Voltar</button>
                                                                    </div>";
}
echo "
                                                            </div>";
if ($menu2 == "index") {
	$this->load->view("vagas/tabela_de_vagas");
} elseif ($menu2 == "create" || $menu2 == "edit") {
	$this->load->view("vagas/edita_vagas");
} elseif ($menu2 == "resultado") {
	$this->load->view("vagas/resultado_vaga");
} elseif ($menu2 == "resultado2") {
	$this->load->view("vagas/resultado2_vaga");
} elseif ($menu2 == "resultado3") {
	$this->load->view("vagas/resultado3_vaga");
} elseif ($menu2 == "AgendamentoEntrevista") {
	$this->load->view("vagas/agendamento_entrevista");
} else {
	if (strlen($erro) > 0) {
		echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
		//$erro='';
	} elseif (strlen($sucesso) > 0) {
		echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
	}
}
echo "
                                                            </div>
                                                    </div>";

$this->load->view("templates/internaRodape", $pagina);


?>
