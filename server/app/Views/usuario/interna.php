<?php
$session = session();
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
                                                <h4><i class="fa fa-home" style="color:black"></i> &nbsp; Pagina Inicial</h4>
                                            </div>
                                    </div>
                                                            <div class="col-lg-12">
                                                                <!-- Default card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        Bem vindo ao Sistema do TransformaGov.<br/><br/>
                                                                        Verifique se o seu nome completo está correto: <span class="alert-danger"><?php echo $session->nome ?></span>.<br/>
                                                                        Data e hora atual do sistema: <span class="alert-danger"><?= date(
                                                                            "d/m/Y - H:i:s"
                                                                        ) ?></span>.<br/><br/>
                                                                        Caso haja algum problema com as verificações acima, saia do sistema e informe os responsáveis pelo sistema por meio do fale conosco (link na página de login).<br/><br/>
                                                                        Se os dados acima estiverem corretos, utilize o menu ao lado para iniciar suas atividades.

                                                                        <h5 style="text-align:left">AVISOS</h4>
                                                                        1) A utilização do sistema é monitorada constantemente, sendo que para entrar você deve concordar em ceder dados de uso e informações pessoais que podem ficar registradas para aplicações legais.<br/>
                                                                        2) O uso não autorizado do sistema é proibido.
                                                                    </div>
                                                                </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
</div>
</div>
</div>
</div>
</div>
