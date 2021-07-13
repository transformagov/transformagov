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

$this->load->view('templates/internaCabecalho', $pagina);

echo "
                        <div class=\"col-12\">
                            <div class=\"tsm-inner-content\">
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
                                                                            <a href=\"".base_url('GruposVagas/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Novo grupo de vagas </a>
                                                                            <br />
                                                                            <a href=\"".base_url('GruposVagas/historico_duplicate_total')."\" class=\"btn btn-warning btn-square\"> <i class=\"fa fa-lg mr-0 fa-sort-amount-down\"></i> Histórico de duplicações </a>
                                                                            <a href=\"".base_url('GruposVagas/historico_duplicate_quantitativo')."\" class=\"btn btn-danger btn-square\"> <i class=\"fa fa-lg mr-0 fa-sort-amount-down\"></i> Quantitativo de duplicações </a>
                                                                    </div>";
}
if($menu2 != 'index' && strlen($sucesso) == 0 && ($menu2 == 'create' || $menu2 == 'edit' || $menu2 == 'questoes')){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_gruposvagas').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('GruposVagas/index')."'\">Cancelar</button>
                                                                    </div>";
}
echo "
                                                            </div>";
if($menu2 == 'index'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" ".($inativo == 1? "checked=\"checked\" ":"")." /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"gruposvagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Instituição</th>
                                                                                            <th>Vagas</th>
                                                                                            <th>Questões</th>
                                                                                            <th>Status</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($grupos);
        if(isset($grupos)){
                foreach ($grupos as $linha){
                        echo "
                                                                                    <tr>
                                                                                            <td class=\"align-middle\">".$linha -> vc_grupovaga."</td>
                                                                                            <td class=\"align-middle text-center\">".$linha -> vc_sigla."</td>
                                                                                            <td class=\"align-middle text-center\">".$linha -> cont_vagas."</td>
                                                                                            <td class=\"align-middle text-center\">".$linha -> cont_questoes."</td>";
                        if($linha -> bl_removido == '0'){
                                echo "
                                                                                            <td class=\"align-middle text-center\"><span class=\"badge badge-success badge-lg\">Ativo</span></td>";
                        }
                        else{
                                echo "
                                                                                            <td class=\"align-middle text-center\"><span class=\"badge badge-danger badge-lg\">Desativado</span></td>";
                        }
                        echo "
                                                                                            <td class=\"align-middle text-center\" style=\"white-space:nowrap\">";
                        if($linha -> bl_removido == '0'){
                                echo anchor('Questoes/index/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-check-square">Definir questões</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Definir questões\"");
                                echo anchor('GruposVagas/edit/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-edit">Editar</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar grupo\"");
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar grupo de vagas\" onclick=\"confirm_delete(".$linha -> pr_grupovaga.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Desativar</i></a>";
                                echo anchor('GruposVagas/duplicate/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-check-square">Duplicar questões</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Duplicar questões\"");
                                if($linha -> etapa7 == '0'){
                                        echo anchor('GruposVagas/create_motivacao/'.$linha -> pr_grupovaga, '<i class="fa fa-lg mr-0 fa-check-square">Criar questões do formulário de motivação</i>', " class=\"btn btn-sm btn-square btn-danger\" title=\"Criar questões do formulário de motivação\"");
                                }
                                
                        }
                        else{
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar grupo de vagas\" onclick=\"confirm_reactivate(".$linha -> pr_grupovaga.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Reativar</i></a>";
                        }
                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function check_inativo(){
                                                            if(document.getElementById('inativo').checked == true){
                                                                    $(location).attr('href', '".base_url('GruposVagas/index/')."1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '".base_url('GruposVagas/index/')."')        
                                                            }
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'O grupo de vagas em questão será marcada como desativado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('GruposVagas/delete/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'O grupo de vagas em questão voltará a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('GruposVagas/reactivate/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#gruposvagas_table').DataTable({
                                                            order: [
                                                                [0, 'asc']
                                                            ],
                                                            columnDefs: [
                                                                    {
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
                $attributes = array('id' => 'form_gruposvagas');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }
                echo "
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Nome <abbr title="Obrigatório">*</abbr>', 'nome', $attributes);
                echo "
                                                                            <div class=\"col-lg-6\">";
                if(!isset($vc_grupovaga) || (strlen($vc_grupovaga) == 0 && strlen(set_value('nome')) > 0)){
                        $vc_grupovaga = set_value('nome');
                }
                $attributes = array('name' => 'nome',
                                    'maxlength'=>'250',
                                    'class' => 'form-control');
                if(strstr($erro, "'Nome'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_grupovaga);
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Instituição <abbr title="Obrigatório">*</abbr>', 'instituicao', $attributes);
                echo "
                                                                            <div class=\"col-lg-6\">";
                if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('instituicao')) > 0)){
                        $es_instituicao = set_value('instituicao');
                }
                $vazio = array(""=>"");
                $valores = $vazio + $instituicoes;
                /*foreach($instituicoes as $opcao){
                        $valores[] = $opcao;
                }*/
                if(strstr($erro, "'instituicao'")){
                        echo form_dropdown('instituicao', $valores, $es_instituicao, "class=\"form-control is-invalid\" id=\"instituicao\"");
                }
                else{
                        echo form_dropdown('instituicao', $valores, $es_instituicao, "class=\"form-control\" id=\"instituicao\"");
                }
                echo "
                                                                            </div>
                                                                    </div>
                                                                    <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_grupo', 'Salvar', $attributes);
                echo "
                                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('GruposVagas/index')."'\">Cancelar</button>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </form>";
                $pagina['js']="
        <script type=\"text/javascript\">
            $('#inicio').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
            $('#fim').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
        </script>";
        }
}
else if($menu2 == 'duplicate'){
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
                $attributes = array('id' => 'form_gruposvagas');
                
                echo form_open($url, $attributes, array('codigo' => $codigo));
                
                echo "
                                                                <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-1 col-form-label text-left');
                echo form_label('Grupo de vaga de destino <abbr title="Obrigatório">*</abbr>', 'grupo', $attributes);
                echo "
                                                                        <div class=\"col-lg-8\">";
                $grupo = '';
                if(strlen(set_value('grupo')) > 0){
                        $grupo = set_value('grupo');
                }
                $array_grupos = array(''=>'');
                foreach($grupos as $grupo){
                        if($codigo != $grupo -> pr_grupovaga){
                                $array_grupos[$grupo -> pr_grupovaga] = $grupo -> vc_grupovaga;
                        }                     
                }
                if(strstr($erro, "'Grupo'")){
                        echo form_dropdown('grupo', $array_grupos, $grupo, "class=\"form-control is-invalid\" id=\"grupo\"");
                }
                else{
                        echo form_dropdown('grupo', $array_grupos, $grupo, "class=\"form-control\" id=\"grupo\"");
                }
                echo "
                                                                        </div>
                                                                        <div class=\"col-lg-3 text-right\">
                ";
                $attributes = array('class' => 'btn btn-primary','id'=>'salvar_grupo');
                echo form_submit('salvar_grupo', 'Duplicar selecionadas', $attributes);

                echo "
                                                                        </div>
                                                                </div>
                                                                                                           
                                                                <div class=\"form-group row\">
                                                                        <div class=\"col-lg-12\">
                                                                                <a href=\"#\" onclick=\"check_all();\"> Marcar todas</a> &nbsp; <a href=\"#\" onclick=\"uncheck_all();\"> Desmarcar todas</a>
                                                                        </div>
                                                                </div>

                                                                <div class=\"dt-responsive table-responsive\">
                                                                            
                                                                        <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
                                                                                <thead>
                                                                                        <tr>
                                                                                                <th>Selecionar</th>
                                                                                                <th>Questão duplicada</th>
                                                                                                <th>Etapa</th>
                                                                                                <th>Enunciado</th>
                                                                                                <th>Tipo</th>
                                                                                                <th>Peso</th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                            ";
                
                foreach($questoes as $questao){
                        // &nbsp; <a href=\"".base_url('GruposVagas/historico_duplicate/'.$codigo)."\">Histórico de duplicações</a>
                        if($questao -> cont_respostas > 0 || $cont_vagas == 0){
                                echo "
                                                                                        <tr>
                                                                                                <td>";
                                $attributes = array('id'=>'questao'.$questao -> pr_questao,'name' => 'questao'.$questao -> pr_questao, 'value' => '1');
                                
                                        //$attributes['disabled'] = 'disabled';
                                
                                echo form_checkbox($attributes, set_value('questao'.$questao -> pr_questao), (set_value('questao'.$questao -> pr_questao)=='1' && strlen(set_value('questao'.$questao -> pr_questao))>0));
                                echo "</td>
                                                                                                <td>
                                                                                                        ".($questao -> bl_duplicado == '1'?"Sim":"Não")."
                                                                                                </td>
                                                                                                <td>
                                                                                                        ".$questao -> es_etapa."ª Etapa
                                                                                                </td>
                                                                                                <td>
                                                                                                        {$questao -> tx_questao}
                                                                                                </td>
                                                                                                <td>";
                                if($questao -> in_tipo == 1){
                                        echo 'Customizadas';
                                }
                                else if($questao -> in_tipo == 2){
                                        echo 'Aberta';
                                }
                                else if($questao -> in_tipo == 3){
                                        echo 'Sim/Não (sim positivo)';
                                }
                                else if($questao -> in_tipo == 4){
                                        echo 'Sim/Não (não positivo)';
                                }
                                else if($questao -> in_tipo == 5){
                                        echo 'Nenhum/Básico/Intermediário/Avançado';
                                }
                                else if($questao -> in_tipo == 6){
                                        echo 'Intervalo';
                                }
                                else if($questao -> in_tipo == 7){
                                        echo 'Upload de arquivo';
                                }                                                                                
                                echo "</td>
                                                                                                <td>
                                                                                                        {$questao -> in_peso}
                                                                                                </td>
                                                                                        </tr>";
                        }
                }
                

                echo "
                                                                                </tbody>
                                                                        </table>
                                                                            
                                                                </div>
                                                                
                                                            </form>";
                                                            //paginação retirada pois impede a escolha de todas as questões "check_all"
                $pagina['js'] = "
                                                            <script type=\"text/javascript\">

                                                                        function check_all(){
                                                                                $(':checkbox').prop('checked', true);
                                                                        }
                                                                        function uncheck_all(){
                                                                                $(':checkbox').prop('checked', false);
                                                                        }
                                                                        jQuery(':submit').click(function (event) {
                                                                                var form = document.getElementById('form_gruposvagas');
                                                                                var se_repetido = 0;
                                                                                if(form.elements['grupo'].value==''){
                                                                                        event.preventDefault();
                                                                                        alert('O grupo de destino deve ser escolhido.');
                                                                                        return;
                                                                                }
                                                                                var se_escolhido = 0;

                                                                                ";
                foreach($questoes_duplicadas as $questao_duplicada){
                        $pagina['js'] .= "
                                                                                if(form.elements['questao{$questao_duplicada -> es_questao_origem}'] && form.elements['questao{$questao_duplicada -> es_questao_origem}'].checked == true && form.elements['grupo'] && form.elements['grupo'].value == '".$questao_duplicada -> es_grupovaga_destino."'){
                                                                                        se_repetido = 1;
                                                                                                                                                         
                                                                                }
                                                                                
                        ";
                }
                foreach($questoes as $questao){
                        if($questao -> cont_respostas > 0 || $cont_vagas == 0){
                                $pagina['js'] .= "
                                                                                if(form.elements['questao{$questao -> pr_questao}'] && form.elements['questao{$questao -> pr_questao}'].checked == true){
                                                                                        se_escolhido = 1;
                                                                                                                                                         
                                                                                }
                                                                                
                                ";
                        }
                }                                                                
                $pagina['js'] .= "
                                                                                if(se_escolhido==0){
                                                                                        event.preventDefault();
                                                                                        alert('Ao menos uma questão deve ser escolhida.');
                                                                                        return;
                                                                                }

                                                                                var titulo = 'Confirmação de duplicação';
                                                                                var grupo = form.elements['grupo'];
                                                                                var texto = 'Deseja confirmar a duplicação das questões selecionadas para o grupo: <u>'+grupo.options[grupo.selectedIndex].text+'</u>?';
                                                                                if(se_repetido == 1){
                                                                                        titulo = 'Aviso de duplicação';
                                                                                        texto = 'Existe questão(s) já duplicada para o grupo <u>'+grupo.options[grupo.selectedIndex].text+'</u>, deseja prosseguir?';
                                                                                }
                                                                                if (this.id == 'salvar_grupo') {
                                                                                        event.preventDefault();
                                                                                        $(document).ready(function(){
                                                                                                event.preventDefault();
                                                                                                swal.fire({
                                                                                                        title: titulo,                                                                                                        
                                                                                                        html: texto,                                                                                                        
                                                                                                        type: 'warning',
                                                                                                        showCancelButton: true,
                                                                                                        cancelButtonText: 'Não',
                                                                                                        confirmButtonText: 'Sim, desejo salvar'
                                                                                                })
                                                                                                .then(function(result) {
                                                                                                        if (result.value) {
                                                                                                                //desfaz as configurações do botão
                                                                                                                $('#salvar_grupo').unbind(\"click\");
                                                                                                                //clica, concluindo o processo
                                                                                                                $('#salvar_grupo').click();
                                                                                                        }
                                                                                                        
                                                                                                });
                                                                                                
                                                                                                
                                                                                        });
                                                                                                                                                                                                                                                                }
                                                                        });
                                                                        

                                                            </script>
                                                            
                                                            <script type=\"text/javascript\">
                                                                jQuery('#questoes_table input:checkbox').change(function() {

                                                                        if(this.checked)  // check if checkbox checked then change color of row
                                                         
                                                                                jQuery(this).closest('td').css('background-color', '#6f6 !important');
                                                                        else
                                                                                jQuery(this).closest('td').css('background-color', '');
                                                         
                                                                 });
                                                                    $('#questoes_table').DataTable({
                                                                            order: [
                                                                                [2, 'asc']
                                                                            ],
                                                                            columnDefs: [
                                                                                    {
                                                                                        'orderable': false,
                                                                                        'targets': [-1]
                                                                                    },
                                                                                    {
                                                                                        'searchable': false,
                                                                                        'targets': [-1]
                                                                                    }
                                                                            ],
                                                                            'rowCallback': function(row, data, index){
                                                                                if(data[1] == 'Sim'){
                                                                                    $(row).find('td:eq(1)').css('background-color', '#f66');
                                                                                }
                                                                                
                                                                              },
                                                                            lengthMenu: [
                                                                                [-1],
										[\"Todos\"]
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
                                                                    $(document).ready(function(){
 
                                                                        $('#grupo').change(function(){
                                                                                var grupo = $(this).val();
                                                                                
                                                                                $.ajax({
                                                                                        url:'".base_url('GruposVagas/getEtapa')."',
                                                                                        method: 'post',
                                                                                        data : {grupo:grupo},
                                                                                        dataType: 'json',
                                                                                        success: function(response){
                                                                                                var len = response.length;
                                                                                                
                                                                                                
                                                                                                        // Read values
                                                                                                ";
                foreach($questoes as $questao){
                        
                        $pagina['js'] .= "
                                                                                                        
                                                                                                        if(response[".$questao -> es_etapa."] == 1){
                                                                                                                
                                                                                                                $('#questao".$questao -> pr_questao."').prop('checked', false);
                                                                                                                $('#questao".$questao -> pr_questao."').prop('disabled', 'disabled');
                                                                                                        }
                                                                                                        else{
                                                                                                                $('#questao".$questao -> pr_questao."').prop('disabled','');
                                                                                                        }
                        ";
                }                                                                                
                $pagina['js'] .= "
                                                                                        
                                                                                                
                                                                                
                                                                                        }
                                                                                });
                                                                        });
                                                                    });
                                                            </script>";
        }
}
else if($menu2 == 'historico_duplicate'){
        echo "
                                                        <div class=\"dt-responsive table-responsive\">
                                                                                                                        
                                                                <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
                                                                        <thead>
                                                                                <tr>
                                                                                        
                                                                                        
                                                                                        <th>Etapa</th>
                                                                                        <th>Enunciado</th>
                                                                                        <th>Tipo</th>
                                                                                        <th>Peso</th>
                                                                                        <th>Grupo de destino</th>
                                                                                        <th>Data de duplicação</th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
            ";

        foreach($questoes_duplicadas as $questao_duplicada){
                echo "
                                                                                <tr> 

                                                                                        <td>
                                                                                                ".$questao_duplicada -> es_etapa."ª Etapa
                                                                                        </td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> tx_questao}
                                                                                        </td>
                                                                                        <td>";
                if($questao_duplicada -> in_tipo == 1){
                        echo 'Customizadas';
                }
                else if($questao_duplicada -> in_tipo == 2){
                        echo 'Aberta';
                }
                else if($questao_duplicada -> in_tipo == 3){
                        echo 'Sim/Não (sim positivo)';
                }
                else if($questao_duplicada -> in_tipo == 4){
                        echo 'Sim/Não (não positivo)';
                }
                else if($questao_duplicada -> in_tipo == 5){
                        echo 'Nenhum/Básico/Intermediário/Avançado';
                }
                else if($questao_duplicada -> in_tipo == 6){
                        echo 'Intervalo';
                }
                else if($questao_duplicada -> in_tipo == 7){
                        echo 'Upload de arquivo';
                }                                                                                
                echo "</td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> in_peso}
                                                                                        </td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> grupo_destino}
                                                                                        </td>
                                                                                        <td>
                                                                                                ".show_date($questao_duplicada -> dt_cadastro,true)."
                                                                                        </td>
                                                                                </tr>";
        }


        echo "
                                                                        </tbody>
                                                                </table>
                                                                
                                                        </div>
                                                        <div class=\"j-footer\">
                                                                <hr>
                                                                <div class=\"row\">
                                                                        <div class=\"col-lg-12 text-center\">
                                                                                        
                                                                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('GruposVagas/duplicate/'.$grupo)."'\">Voltar</button>
                                                                        </div>
                                                                </div>
                                                        </div>
        ";
        $pagina['js'] = "
                                                            
                                                        <script type=\"text/javascript\">
                                                                $('#questoes_table').DataTable({
                                                                        order: [
                                                                        [0, 'asc']
                                                                        ],
                                                                        columnDefs: [
                                                                                {
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
else if($menu2 == 'historico_duplicate_total'){
        echo "
                                                        <div class=\"dt-responsive table-responsive\">
                                                                                                                        
                                                                <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
                                                                        <thead>
                                                                                <tr>                                                                                        
                                                                                        <th>Data/Hora</th>
                                                                                        <th>Usuário</th>
                                                                                        <th>Enunciado</th>
                                                                                        <th>Etapa</th>
                                                                                        
                                                                                        <th>Tipo</th>
                                                                                        <th>Grupo de origem</th>
                                                                                        <th>Grupo de destino</th>
                                                                                        
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
            ";

        foreach($questoes_duplicadas as $questao_duplicada){
                echo "
                                                                                <tr>
                                                                                        <td>
                                                                                                ".show_date($questao_duplicada -> dt_cadastro,true)."
                                                                                        </td>
                                                                                        <td>
                                                                                                ".$questao_duplicada -> usuario."
                                                                                        </td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> tx_questao}
                                                                                        </td>
                                                                                        <td>
                                                                                                ".$questao_duplicada -> es_etapa."ª Etapa
                                                                                        </td>
                                                                                        
                                                                                        <td>";
                if($questao_duplicada -> in_tipo == 1){
                        echo 'Customizadas';
                }
                else if($questao_duplicada -> in_tipo == 2){
                        echo 'Aberta';
                }
                else if($questao_duplicada -> in_tipo == 3){
                        echo 'Sim/Não (sim positivo)';
                }
                else if($questao_duplicada -> in_tipo == 4){
                        echo 'Sim/Não (não positivo)';
                }
                else if($questao_duplicada -> in_tipo == 5){
                        echo 'Nenhum/Básico/Intermediário/Avançado';
                }
                else if($questao_duplicada -> in_tipo == 6){
                        echo 'Intervalo';
                }
                else if($questao_duplicada -> in_tipo == 7){
                        echo 'Upload de arquivo';
                }                                                                                
                echo "</td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> grupo_origem}
                                                                                        </td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> grupo_destino}
                                                                                        </td>
                                                                                        
                                                                                </tr>";
        }


        echo "
                                                                        </tbody>
                                                                </table>
                                                                
                                                        </div>
                                                        <div class=\"j-footer\">
                                                                <hr>
                                                                <div class=\"row\">
                                                                        <div class=\"col-lg-12 text-center\">
                                                                                        
                                                                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('GruposVagas/index')."'\">Voltar</button>
                                                                        </div>
                                                                </div>
                                                        </div>
        ";
        $pagina['js'] = "
                                                            
                                                        <script type=\"text/javascript\">
                                                                $('#questoes_table').DataTable({
                                                                        order: [
                                                                        [0, 'desc']
                                                                        ],
                                                                        columnDefs: [
                                                                                {
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
else if($menu2 == 'historico_duplicate_quantitativo'){
        echo "
                                                        <div class=\"dt-responsive table-responsive\">
                                                                                                                        
                                                                <table class=\"table table-striped table-bordered table-hover\" id=\"questoes_table\">
                                                                        <thead>
                                                                                <tr>                                                                                        
                                                                                        
                                                                                        <th>Enunciado</th>
                                                                                        <th>Etapa</th>
                                                                                        
                                                                                        <th>Tipo</th>
                                                                                        <th>Grupo de origem</th>
                                                                                        <th>Total</th>
                                                                                        
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
            ";

        foreach($questoes_duplicadas as $questao_duplicada){
                echo "
                                                                                <tr>
                                                                                        
                                                                                        <td>
                                                                                                {$questao_duplicada -> tx_questao}
                                                                                        </td>
                                                                                        <td>
                                                                                                ".$questao_duplicada -> es_etapa."ª Etapa
                                                                                        </td>
                                                                                        
                                                                                        <td>";
                if($questao_duplicada -> in_tipo == 1){
                        echo 'Customizadas';
                }
                else if($questao_duplicada -> in_tipo == 2){
                        echo 'Aberta';
                }
                else if($questao_duplicada -> in_tipo == 3){
                        echo 'Sim/Não (sim positivo)';
                }
                else if($questao_duplicada -> in_tipo == 4){
                        echo 'Sim/Não (não positivo)';
                }
                else if($questao_duplicada -> in_tipo == 5){
                        echo 'Nenhum/Básico/Intermediário/Avançado';
                }
                else if($questao_duplicada -> in_tipo == 6){
                        echo 'Intervalo';
                }
                else if($questao_duplicada -> in_tipo == 7){
                        echo 'Upload de arquivo';
                }                                                                                
                echo "</td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> vc_grupovaga}
                                                                                        </td>
                                                                                        <td>
                                                                                                {$questao_duplicada -> quantitativo}
                                                                                        </td>
                                                                                        
                                                                                </tr>";
        }


        echo "
                                                                        </tbody>
                                                                </table>
                                                                
                                                        </div>
                                                        <div class=\"j-footer\">
                                                                <hr>
                                                                <div class=\"row\">
                                                                        <div class=\"col-lg-12 text-center\">
                                                                                        
                                                                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('GruposVagas/index')."'\">Voltar</button>
                                                                        </div>
                                                                </div>
                                                        </div>
        ";
        $pagina['js'] = "
                                                            
                                                        <script type=\"text/javascript\">
                                                                $('#questoes_table').DataTable({
                                                                        order: [
                                                                        [4, 'desc']
                                                                        ],
                                                                        columnDefs: [
                                                                                {
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
else if($menu2 == 'create_motivacao'){
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
else if($menu2 == 'questoes'){
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-exclamation-triangle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                                    </div>
                                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                            <div class=\"alert alert-success\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-check-circle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            $sucesso
                                                                                    </div>
                                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_gruposvagas');
                echo form_open($url, $attributes, array('codigo' => $codigo, 'num' => 0));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Vaga');
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                echo form_label('Nome', 'nome', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                $attributes = array('name' => 'nome',
                                    'class' => 'form-control',
                                    'disabled' => 'disabled');
                echo form_input($attributes, $vc_vaga);
                echo "
                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                //var_dump($questoes_atuais);
                $x=0;
                foreach ($questoes_atuais as $linha){
                        $x++;
                        echo form_fieldset('Questão atual '.$x);
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Descrição', 'nome_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'nome_'.$linha -> pr_questao,
                                            'class' => 'form-control',
                                            'rows' => '2');
                        echo form_textarea($attributes, strip_tags($linha -> tx_questao));
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Etapa', 'etapa_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-4\">";
                        $etapas=array(0 => '')+$etapas;
                        if(strstr($erro, "'Etapa'")){
                                echo form_dropdown('etapa_'.$linha -> pr_questao, $etapas, $linha -> es_etapa, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('etapa_'.$linha -> pr_questao, $etapas, $linha -> es_etapa, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Tipo de resposta', 'tipo_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-4\">";
                        $attributes = array(
                                    '' => '',
                                    1 => 'Customizadas',
                                    2 => 'Aberta',
                                    3 => 'Sim/Não (Sim positivo)',
                                    4 => 'Sim/Não (Não positivo)',
                                    5 => 'Nenhum/Básico/Intermediário/Avançado'
                                    );
                        if(strstr($erro, "'Tipo de resposta'")){
                                echo form_dropdown('tipo_'.$linha -> pr_questao, $attributes, $linha -> in_tipo, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('tipo_'.$linha -> pr_questao, $attributes, $linha -> in_tipo, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Resposta aceita', 'resposta_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'resposta_'.$linha -> pr_questao,
                                            'class' => 'form-control',
                                            'maxlength' => '500');
                        echo form_input($attributes, strip_tags($linha -> vc_respostaAceita));
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Eliminatória?', 'eliminatoria_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='1' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'eliminatoria_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_eliminatoria, ($linha -> bl_eliminatoria=='0' && strlen($linha -> bl_eliminatoria)>0));
                        echo " Não
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                        echo form_label('Obrigatória?', 'obrigatorio_'.$linha -> pr_questao, $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'1');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='1' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Sim<br/>";
                        $attributes = array('name' => 'obrigatorio_'.$linha -> pr_questao,
                                            'value'=>'0');
                        echo form_radio($attributes, $linha -> bl_obrigatorio, ($linha -> bl_obrigatorio=='0' && strlen($linha -> bl_obrigatorio)>0));
                        echo " Não
                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                }

                echo "
                                                                                    <div id=\"div_questoes\"></div>
                                                                            </div>
                                                                            <div class=\"kt-portlet__foot\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">
                                                                                                            <button type=\"button\" id=\"adicionar_questao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-0 fa-plus\"></i> Adicionar questão</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class=\"kt-portlet__foot\">
                                                                                    <div class=\"kt-form__actions\">
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_usuario', 'Salvar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                $pagina['js']="
        <script type=\"text/javascript\">
                $( '#adicionar_questao' ).click(function() {
                        var valor_num = $('input[name=num]').val();
                        valor_num++;
                        var newElement = '<fieldset><legend>Nova questão ' + valor_num + '</legend>";
                //$pagina['js'].=form_fieldset('Requisitos mínimos');
                $pagina['js'].="<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-2 col-form-label text-right');
                $pagina['js'].= form_label('Questão pré-cadastrada', 'grupo', $attributes);
                $pagina['js'].= "<div class=\"col-lg-9\">";
                $pagina['js'].="<select name=\"outras_questoes_' + valor_num + '\" class=\"form-control\"><option value=\"\"> -- ESCOLHA AQUI OU DEFINA OS PARÂMETROS ABAIXO -- </option><optgroup label=\"Etapa 1\">";
                foreach ($outras_questoes1 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="<optgroup label=\"Etapa 2\">";
                foreach ($outras_questoes2 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="<optgroup label=\"Etapa 3\">";
                foreach ($outras_questoes3 as $linha){
                        $pagina['js'].= "<option value=\"".$linha -> pr_questao."\">".preg_replace( "/\r|\n/", "", strip_tags($linha -> tx_questao))."</option>";
                }
                $pagina['js'].="</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"nome2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Descrição</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><textarea name=\"nome2_' + valor_num + '\" cols=\"40\" rows=\"2\" class=\"form-control\" ></textarea></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"etapa2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Etapa</label>";
                $pagina['js'].= "<div class=\"col-lg-4\"><select name=\"etapa2_' + valor_num + '\" class=\"form-control\" >";
                //var_dump($etapas);
                for($x=0;$x<count($etapas);$x++){
                        $pagina['js'].= "<option value=\"{$x}\">".$etapas[$x]."</option>";
                }
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"tipo2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Tipo de resposta</label>";
                $pagina['js'].= "<div class=\"col-lg-4\"><select name=\"tipo2_' + valor_num + '\" class=\"form-control\" >";
                $pagina['js'].= "<option value=\"\"></option>";
                $pagina['js'].= "<option value=\"2\">Aberta</option>";
                $pagina['js'].= "<option value=\"3\">Sim/Não (Sim positivo)</option>";
                $pagina['js'].= "<option value=\"4\">Sim/Não (Não positivo)</option>";
                $pagina['js'].= "<option value=\"5\">Nenhum/Básico/Intermediário/Avançado</option>";
                $pagina['js'].= "</select></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"resposta2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Resposta aceita</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"text\" name=\"resposta2_' + valor_num + '\" class=\"form-control\" /></div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"eliminatoria2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Eliminatória?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"eliminatoria2_' + valor_num + '\" value=\"0\" /> Não</div></div>";
                $pagina['js'].= "<div class=\"form-group row\">";
                $pagina['js'].= "<label for=\"obrigatorio2_' + valor_num + '\" class=\"col-lg-2 col-form-label text-right\">Obrigatória?</label>";
                $pagina['js'].= "<div class=\"col-lg-9\"><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"1\" /> Sim<br/><input type=\"radio\" name=\"obrigatorio2_' + valor_num + '\" value=\"0\" /> Não</div></div>";
                
                echo form_fieldset_close();
                $pagina['js'].= "<div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                $pagina['js'].="';
                        $( '#div_questoes' ).append( $(newElement) );
                        $('input[name=num]').val(valor_num);
                });
        </script>";
        }
}*/
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
echo "
                                                            </div>
                                                    </div>";

$this->load->view('templates/internaRodape', $pagina);

?>