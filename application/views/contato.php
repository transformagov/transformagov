<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this -> load -> view('templates/publicoCabecalho');
echo "
                <div class=\"content\">
                        <!-- BEGIN LOGIN FORM -->
                        <form class=\"login-form\" action=\"contato\" method=\"post\">
                        <h3 class=\"form-title\">Entre em contato</h3>";
if(strlen($erro)>0){
        echo "
                                <div class=\"alert alert-danger\">
                                        <strong>ERRO</strong>: $erro<br />
                                </div>";
        $erro="";
}
if($sucesso=='1'){
        echo "
                                <div class=\"alert alert-success\">
                                        <strong>Mensagem enviada com sucesso.<br />
                                </div>";
}
else{
        $attributes = array('class' => 'login-form');
        echo form_open($pagina, $attributes);
        echo "
                                <div class=\"form-group\">
                                        ";
        $attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        echo form_label('Nome completo', 'nome', $attributes);

        $attributes = array('name' => 'nome', 
                            'id' => 'nome', 
                            'maxlength'=>'100', 
                            'class' => 'form-control form-control-solid placeholder-no-fix', 
                            'placeholder'=>'Nome completo');
        echo form_input($attributes, set_value('nome'));
        
        echo "
                                </div>
                                <div class=\"form-group\">
                                        ";
        $attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        echo form_label('E-mail', 'email', $attributes);

        $attributes = array('name' => 'email', 
                            'id' => 'email', 
                            'maxlength'=>'100', 
                            'class' => 'form-control form-control-solid placeholder-no-fix', 
                            'placeholder'=>'E-mail');
        echo form_input($attributes, set_value('email'));
        
        echo "
                                </div>
                                <div class=\"form-group\">
                                        ";
        $attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        echo form_label('Assunto', 'assunto', $attributes);

        $attributes = array('name' => 'assunto', 
                            'id' => 'assunto', 
                            'maxlength'=>'100', 
                            'class' => 'form-control form-control-solid placeholder-no-fix', 
                            'placeholder'=>'Assunto');
        echo form_input($attributes, set_value('assunto'));
        
        echo "
                                </div>
                                <div class=\"form-group\">
                                        ";
        $attributes = array('class' => 'control-label visible-ie8 visible-ie9');
        echo form_label('Mensagem', 'msg', $attributes);

        $attributes = array('name' => 'msg', 
                            'id' => 'msg', 
                            'rows'=>'3', 
                            'class' => 'form-control form-control-solid placeholder-no-fix', 
                            'placeholder' => 'Mensagem',
                            'style' => 'height:100px');
        echo form_textarea($attributes, set_value('msg'));
        echo "
                                </div>
                                <div class=\"form-actions\">
                                        ";
        $attributes = array('class' => 'btn btn-success uppercase');
        echo form_submit('enviado', 'Enviar', $attributes);
        echo "
                                        <a href=\"".base_url()."\" id=\"forget-password\" class=\"forget-password\">Login</a>
                                </div>
                        ";
        echo form_close();
        echo "
                </div>
                <div class=\"copyright\">
                         SUGESP - SEPLAG © Layout Metronic
                </div>";
}
$this -> load -> view('templates/publicoRodape');
?>