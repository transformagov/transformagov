<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($adicionais);

echo "
                                        </div>
                                        <!-- Page body end -->
                                    </div>
                                </div>";
/*
echo "
                                <div id=\"styleSelector\">
                                </div>";
*/
echo "
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"page-footer\">
                <div class=\"page-footer-inner\">
                         Desenvolvido pela SUGESP - SEPLAG/MG. Layout: &copy; Adminty.
                </div>
                <div class=\"scroll-to-top\">
                        <i class=\"icon-arrow-up\"></i>
                </div>
        </div>
        <div class=\"modal fade\" id=\"trocarsenha\" tabindex=\"-1\" role=\"dialog\">
                <div class=\"modal-dialog\" role=\"document\">
                        <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                        <h4 class=\"modal-title\">Alterar senha</h4>
                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Fechar\">
                                                <span aria-hidden=\"true\">&times;</span>
                                        </button>
                                </div>
                                <form method=\"post\" action=\"javascript:;\" id=\"form_alterarsenha\" class=\"form-horizontal\">
                                        <div class=\"modal-body\">";
if($this -> session -> trocasenha){
        echo "
                                                <div class=\"alert alert-warning\">
                                                        <div class=\"alert-text\">
                                                                Você deve alterar a senha recebida por e-mail.
                                                        </div>
                                                </div>";
}
echo "
                                                <p style=\"margin-left: 10px; font-size: medium;\">
                                                        <span class=\"bolder\">Padrão da senha:</span><br/>
                                                        Tamanho mínimo: 8 caracteres<br/>
                                                        Tamanho máximo: 20 caracteres.
                                                </p>
                                                <h5>Senha atual</h5>
                                                <p>
                                                        <input class=\"form-control form-control-inline input-medium\" type=\"password\" name=\"senhaAtual\" id=\"senhaAtual\" />
                                                </p>
                                                <h5>Nova senha</h5>
                                                <p>
                                                        <input class=\"form-control form-control-inline input-medium\" type=\"password\" name=\"senhaNova\" id=\"senhaNova\" />
                                                </p>
                                                <h5>Confirmação</h5>
                                                <p>
                                                        <input class=\"form-control form-control-inline input-medium\" type=\"password\" name=\"senhaConfirmacao\" id=\"senhaConfirmacao\" />
                                                </p>
                                        </div>
                                        <div class=\"modal-footer\">
                                                <button type=\"button\" data-dismiss=\"modal\" class=\"btn default\">Cancelar</button>
                                                <button type=\"button\" name=\"alterar\" id=\"alterarSenha\" class=\"btn btn-primary\">Alterar</button>
                                        </div>
                                </div>
                        </form>
                </div>
        </div>";
/*
echo "
        <script type=\"text/javascript\" src=\"".base_url('bower_components/jquery/js/jquery.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components/jquery-ui/jquery-ui.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components/popper.js/js/popper.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components/bootstrap/js/bootstrap.min.js')."\"></script>";
*/
echo "
        <script src=\"https://code.jquery.com/jquery-3.4.1.min.js\"></script>
        <script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\" integrity=\"sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1\" crossorigin=\"anonymous\"></script>
        <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\" integrity=\"sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\" crossorigin=\"anonymous\"></script>
        <script src=\"https://momentjs.com/downloads/moment-with-locales.js\"></script>
        <!-- jquery slimscroll js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components/jquery-slimscroll/js/jquery.slimscroll.js')."\"></script>
        <!-- modernizr js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components/modernizr/js/modernizr.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\modernizr\js\css-scrollbars.js')."\"></script>
        <!-- sweet alert js -->
        <script src=\"".base_url('bower_components/sweetalert2/dist/sweetalert2.min.js')."\" type=\"text/javascript\"></script>";

if(isset($adicionais['datatables'])){
        echo "
        <!-- data-table js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net\js\jquery.dataTables.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets\pages\data-table\js\jszip.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets\pages\data-table\js\pdfmake.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets\pages\data-table\js\vfs_fonts.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net-buttons\js\buttons.print.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net-buttons\js\buttons.html5.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')."\"></script>";
}
if(isset($adicionais['prism'])){
        echo "
        <!-- Syntax highlighter prism js -->
        <script type=\"text/javascript\" src=\"".base_url('assets/pages/prism/custom-prism.js')."\"></script>";
}
if(isset($adicionais['inputmasks'])){
        echo "
        <!-- Masking js -->
        <script src=\"".base_url('assets\pages\form-masking\inputmask.js')."\"></script>
        <script src=\"".base_url('assets\pages\form-masking\jquery.inputmask.js')."\"></script>
        <script src=\"".base_url('assets\pages\form-masking\autoNumeric.js')."\"></script>
        <script src=\"".base_url('assets\pages\form-masking\form-mask.js')."\"></script>";
}
if(isset($adicionais['rangeslider'])){
        echo "
        <script type=\"text/javascript\" src=\"".base_url('bower_components\seiyria-bootstrap-slider\js\bootstrap-slider.js')."\"></script>";
}
/*
if(isset($adicionais['pickers'])){
        echo "
        <!-- Bootstrap date-time-picker js -->
        <script type=\"text/javascript\" src=\"".base_url('assets\pages\advance-elements\moment-with-locales.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\bootstrap-datepicker\js\bootstrap-datepicker.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets\pages\advance-elements\bootstrap-datetimepicker.min.js')."\"></script>
        <!-- Date-range picker js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\bootstrap-daterangepicker\js\daterangepicker.js')."\"></script>
        <!-- Date-dropper js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\datedropper\js\datedropper.min.js')."\"></script>";
}*/
/*if(isset($adicionais['moment']) || isset($adicionais['pickers']) || isset($adicionais['calendar'])){
        echo "
		<script src=\"".base_url('assets_6.0.3/vendors/general/moment/min/moment-with-locales.js')."\" type=\"text/javascript\"></script>
		<script src=\"".base_url('assets_6.0.3/vendors/general/moment/locale/pt-br.js')."\" type=\"text/javascript\"></script>";
}*/
/*
if(isset($adicionais['moment']) || isset($adicionais['pickers']) || isset($adicionais['calendar'])){
        echo "
        <script src=\"".base_url('bower_components/moment/min/moment-with-locales.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/moment/locale/pt-br.js')."\" type=\"text/javascript\"></script>";
}*/
if(isset($adicionais['calendar'])){
        echo "
        <!-- calendar js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\fullcalendar\js\fullcalendar.min.js')."\"></script>";
}
if(isset($adicionais['pickers'])){
        echo "
        <script src=\"".base_url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('assets/js/bootstrap-datepicker.init.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-timepicker/js/bootstrap-timepicker.min.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('assets/js/bootstrap-timepicker.init.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-daterangepicker/daterangepicker.js')."\" type=\"text/javascript\"></script>";
}

if(isset($adicionais['wizard'])){
        echo "
        <!--Forms - Wizard js-->
        <script src=\"".base_url('bower_components/jquery.cookie/js/jquery.cookie.js')."\"></script>
        <script src=\"".base_url('bower_components/jquery.steps/js/jquery.steps.js')."\"></script>
        <script src=\"".base_url('bower_components/jquery-validation/js/jquery.validate.js')."\"></script>";
}
if(isset($adicionais['select2'])){
        echo "
        <!-- Select 2 js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\select2\js\select2.full.min.js')."\"></script>";
}
if(isset($adicionais['accordion'])){
        echo "
        <!-- accordion -->
        <script type=\"text/javascript\" src=\"".base_url('assets/pages/accordion/accordion.js')."\"></script>";
}
if(isset($adicionais['wysiwyg'])){
        echo "
        <!-- wysiwyg -->
        <script type=\"text/javascript\" src=\"".base_url('assets/pages/wysiwyg-editor/js/tinymce.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets/pages/wysiwyg-editor/wysiwyg-editor.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets/js/script.js')."\"></script>
        ";
}
echo "
        <!-- Custom js -->
        <script type=\"text/javascript\" src=\"".base_url('assets/js/pcoded.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets/js/vartical-layout.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets/js/script.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets/js/jquery.mCustomScrollbar.concat.min.js')."\"></script>
        
        <script type=\"text/javascript\" src=\"".base_url('assets/pages/sessionTimeout/sessionTimeout-custom.js')."\"></script>
        <script type=\"text/javascript\">
            $(document).ready(function(){
                    var request;
                    $('#alterarSenha').click(function(){
                            event.preventDefault();
                            if (request) {
                                request.abort();
                            }
                            var form = $(this);
                            var inputs = form.find(\"input, select, button, textarea\");
                            var serializedData =  $('#form_alterarsenha').serialize();
                            inputs.prop(\"disabled\", true);
                            request = $.ajax({
                                    url:\"".base_url()."Interna/alterar_senha\",
                                    method:\"POST\",
                                    data:serializedData
                            });
                            request.done(function (response, textStatus, jqXHR){
                                    if(response.search('ERRO:')>=0){
                                            swal.fire('', response, 'error');
                                    }
                                    else{
                                            $('#trocarsenha').modal('hide');
                                            $('#senhaAtual').val('');
                                            $('#senhaNova').val('');
                                            $('#senhaConfirmacao').val('');
                                            swal.fire('', response, 'success');
                                    }
                            });
                    });
            });
            $(document).ready(function() {
                $.sessionTimeout({
                    warnAfter: 1800000, //30 minutos
                    redirAfter: 1860000, //+60 segundos
                    message: 'Sua sessão está se expirando.',
                    keepAliveUrl: '".base_url('Interna/index')."',
                    logoutUrl: '".base_url('Interna/logout')."'
                });
            });
        </script>";
if($this -> session -> trocasenha){
        echo "
        <script type=\"text/javascript\">
                $(document).ready(function(){
                        $('#trocarsenha').modal('show');
                });
        </script>";
}
if(isset($js)){
        echo "
                {$js}";
}
echo "
    </body>
</html>";
?>
