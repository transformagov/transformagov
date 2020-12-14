<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this -> load -> view('internaCabecalho', $pagina);
$this -> load -> view('internaMenu', $pagina);

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
                                                                    </div>";
if($menu2 == 'index'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                        <a href=\"".base_url('Usuarios/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Novo usuário </a>
                                                                    </div>";
}
else if($menu2 == 'create' || $menu2 == 'edit'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_usuarios').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
                                                                    </div>";
}
echo "
                                                            </div>";
if($menu2 == 'index'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" ".($inativo == 1? "checked=\"checked\" ":"")." /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table id=\"usuarios_table\" class=\"table table-striped table-bordered table-hover\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
											    <th>CPF</th>
                                                                                            <th>Perfil</th>
                                                                                            <th>Cadastro</th>
                                                                                            <th>Último acesso</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($usuarios);
        if(isset($usuarios)){
                foreach ($usuarios as $linha){
                        $dt_cadastro = human_to_unix($linha -> dt_cadastro.' 00:00:00');
                        $dt_ultimoacesso = human_to_unix($linha -> dt_ultimoacesso.' 00:00:00');
                        echo "
                                                                                    <tr>
                                                                                            <td class=\"align-middle\">".$linha -> vc_nome."</td>
                                                                                            <td class=\"align-middle\">".$linha -> vc_login."</td>
                                                                                            <td class=\"align-middle text-center\">";
                        if($linha -> en_perfil == 'candidato'){
                                echo 'Candidato';
                        }
                        else if($linha -> en_perfil == 'avaliador'){
                                echo 'Avaliador';
                        }
                        else if($linha -> en_perfil == 'sugesp'){
                                echo 'Gestor SEPLAG';
                        }
                        else if($linha -> en_perfil == 'orgaos'){
                                echo 'Gestor Outros Órgãos';
                        }
                        else if($linha -> en_perfil == 'administrador'){
                                echo 'Administrador';
                        }
                        echo "
                                                                                            <td class=\"align-middle text-center\" data-search=\"".show_date($linha -> dt_cadastro)."\" data-order=\"$dt_cadastro\">".show_date($linha -> dt_cadastro)."</td>
                                                                                            <td class=\"align-middle text-center\" data-search=\"".show_date($linha -> dt_ultimoacesso)."\" data-order=\"$dt_ultimoacesso\">".show_date($linha -> dt_ultimoacesso)."</td>
                                                                                            <td class=\"align-middle text-center\">";
                        if($linha -> bl_removido == '0'){
                                if($linha -> pr_usuario != $this -> session -> uid){
                                        echo anchor('Usuarios/edit/'.$linha -> pr_usuario, '<i class="fa fa-lg mr-0 fa-edit">Editar</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar\"");
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-warning\" title=\"Nova senha\" onclick=\"confirm_senha(".$linha -> pr_usuario.");\"><i class=\"fa fa-lg fa-envelope mr-0\">Nova senha</i></a>";
                                        //echo anchor('#', '<i class="la la-envelope"></i>', " class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Nova senha\" onclick=\"confirma_senha(".$linha -> pr_usuario.");\"");
                                        //echo anchor('Usuarios/delete/'.$linha -> pr_usuario, '<i class="la la-times-circle"></i>', " class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Excluir\"");
                                        echo "<button type=\"button\" class=\"btn btn-sm btn-square btn-danger alert-confirm\" title=\"Desativar usuário\" onclick=\"confirm_delete(".$linha -> pr_usuario.");\"><i class=\"fa fa-lg fa-times-circle mr-0\">Desativar</i></a>";
                                }
                                
                        }
                        else{
                                if($linha -> pr_usuario != $this -> session -> uid){
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-success btn-square\" title=\"Reativar usuário\" onclick=\"confirm_reactivate(".$linha -> pr_usuario.");\"><i class=\"fa fa-lg fa-plus-circle mr-0\">Reativar</i></a>";
                                }
                        }
                        echo "</td>
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                        </div>
                                                    </div>";
        $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function check_inativo(){
                                                            if(document.getElementById('inativo').checked == true){
                                                                    $(location).attr('href', '".base_url('Usuarios/index/')."1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '".base_url('Usuarios/index/')."')        
                                                            }
                                                    }
                                                    function confirm_senha(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o envio de nova senha?',
                                                                        text: 'Será enviada uma nova senha para o e-mail do usuario.',
                                                                        type: 'info',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, envie'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Usuarios/novaSenha/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'O usuário perderá o acesso e seu CPF ficará como inativo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Usuarios/delete/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'O usuário voltará a ter acesso e receberá um e-mail com nova senha.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Usuarios/reactivate/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#usuarios_table').DataTable({
                                                        'pageLength': 15,
                                                        'lengthMenu': [
                                                            [ 15, 25, 50, -1 ],
                                                            [ '15', '25', '50', 'Todos' ]
                                                        ],
                                                        'order': [
                                                            [0, 'asc']
                                                        ],
                                                        columnDefs: [
                                                            {  // set default column settings
                                                                'orderable': false,
                                                                'targets': [-1]
                                                            },
                                                            {
                                                                'searchable': false,
                                                                'targets': [-1]
                                                            }
                                                        ],
                                                        language: {
                                                            \"decimal\":        \"\",
                                                            \"emptyTable\":     \"Nenhum item encontrado\",
                                                            \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                            \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                            \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                            \"infoPostFix\":    \"\",
                                                            \"thousands\":      \",\",
                                                            \"lengthMenu\":     \"Mostrar _MENU_\",
                                                            \"loadingRecords\": \"Carregando...\",
                                                            \"processing\":     \"Carregando...\",
                                                            \"search\":         \"Pesquisar:\",
                                                            \"zeroRecords\":    \"Nenhum item encontrado\",
                                                            \"paginate\": {
                                                                \"first\":      \"Primeira\",
                                                                \"last\":       \"Última\",
                                                                \"next\":       \"Próxima\",
                                                                \"previous\":   \"Anterior\"
                                                            },
                                                            \"aria\": {
                                                                \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                            }
                                                        }
                                                    });
                                            </script>";
}
else if($menu2 == 'create' || $menu2 == 'edit'){
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
        if(strlen($sucesso) == 0){
                $attributes = array('id' => 'form_usuarios');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }
                echo "
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Nome completo <abbr title="Obrigatório">*</abbr>', 'NomeCompleto', $attributes);
                echo "
                                                                            <div class=\"col-lg-6\">";
                if(!isset($vc_nome) || (strlen($vc_nome) == 0 && strlen(set_value('NomeCompleto')) > 0)){
                        $vc_nome = set_value('NomeCompleto');
                }
                $attributes = array('name' => 'NomeCompleto',
                                    'maxlength'=>'250',
                                    'class' => 'form-control');
                if(strstr($erro, "'Nome completo'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_nome);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('E-mail <abbr title="Obrigatório">*</abbr>', 'Email', $attributes);
                echo "
                                                                            <div class=\"col-lg-6\">";
                if(!isset($vc_email) || (strlen($vc_email) == 0 && strlen(set_value('Email')) > 0)){
                        $vc_email = set_value('Email');
                }
                $attributes = array('name' => 'Email',
                                    'maxlength'=>'250',
                                    'class' => 'form-control');
                if(strstr($erro, "'E-mail'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_email);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('CPF <abbr title="Obrigatório">*</abbr>', 'CPF', $attributes);
                echo "
                                                                            <div class=\"col-lg-3\">";
                if(!isset($vc_login) || (strlen($vc_login) == 0 && strlen(set_value('CPF')) > 0)){
                        $vc_login = set_value('CPF');
                }
                $attributes = array('name' => 'CPF',
                                    'id' => 'CPF',
                                    'maxlength'=>'14',
                                    'class' => 'form-control',
                                    'data-mask' => '999.999.999-99');                
                if($menu2 != 'create'){
                        $attributes['readonly'] = 'readonly';
                }
                if(strstr($erro, "'CPF'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_login);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Perfil <abbr title="Obrigatório">*</abbr>', 'perfil', $attributes);
                echo "
                                                                            <div class=\"col-lg-3\">";
                if(!isset($en_perfil) || (strlen($en_perfil) == 0 && strlen(set_value('perfil')) > 0)){
                        $en_perfil = set_value('perfil');
                }
                $attributes = array(
                                    '' => '',
                                    'avaliador' => 'Avaliador',
                                    'sugesp' => 'Gestor SEPLAG',
                                    'orgaos' => 'Gestor Outros Órgãos',
                                    'administrador' => 'Administrador'
                                    );
                if(strstr($erro, "'Perfil'")){
                        echo form_dropdown('perfil', $attributes, $en_perfil, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('perfil', $attributes, $en_perfil, "class=\"form-control\"");
                }
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_usuario', 'Salvar', $attributes);
                echo "
                                                                                    <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
                                                                            </div>
                                                                    </div>
                                                            </form>
                                                    </div>";
                $pagina['js']="
        <script type=\"text/javascript\">
            $(document).ready(function(){
                    $('#CPF').inputmask('999.999.999-99');
            });
        </script>";
        }
}
else{
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
}
/*
echo "
                                                    </div>";*/
$this -> load -> view('internaRodape', $pagina);
?>