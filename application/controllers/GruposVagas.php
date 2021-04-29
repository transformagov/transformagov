<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GruposVagas extends CI_Controller {
        function __construct() {
                parent::__construct();
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('GruposVagas_model');
                //$this->load->library('jaxon');
                //$this -> load -> model('Instituicoes_model');    
        }

	public function index($inativo = 0)	{ 
                $this -> load -> helper('date');
                $this -> load -> model('Vagas_model');
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='index';
                $pagina['url']='GruposVagas/index';
                $pagina['nome_pagina']='Grupos de vagas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $dados['adicionais'] = array(
                                            'datatables' => true);
                //$vaga = $this -> uri -> segment(3);
                if($inativo == 0){
                        $grupos = $this -> GruposVagas_model -> get_grupos('');
                }
                else{
                        $grupos = $this -> GruposVagas_model -> get_grupos('', false);
                }
                foreach($grupos as $grupo){
                        $questoes = $this -> Questoes_model -> get_questoes('', $grupo -> pr_grupovaga, '7');
                        if(isset($questoes)){
                                $grupo -> etapa7 = 1;
                        }
                        else{
                                $grupo -> etapa7 = 0;
                        }
                        $dados['grupos'][] = $grupo;
                }

                
                $dados['inativo'] = $inativo;
                $this -> load -> view('gruposvagas', $dados);
	}
	public function create(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='create';
                $pagina['url']='GruposVagas/create';
                $pagina['nome_pagina']='Novo grupo de vagas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                //$dados += $this -> input -> post(null,true);

                $this -> form_validation -> set_rules('nome', "'Nome'", 'required|is_unique[tb_gruposvagas.vc_grupovaga]', array('is_unique' => 'Já existe um grupo de vagas com esse nome no campo \'Nome\'.'));
                $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
                
                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] = validation_errors();
                }
                else{
                        //var_dump($this -> input -> post(null,true));
                        $dados_form = $this -> input -> post(null,true);
                        $grupo = $this -> GruposVagas_model -> create_grupo($dados_form);
                        if($grupo > 0){
                                $dados['sucesso'] = 'Grupo de vagas cadastrado com sucesso.<br/><br/><a href="'.base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] =  NULL;
                                $this -> Usuarios_model -> log('sucesso', 'GruposVagas/create', "Grupo de vagas {$grupo} criado com sucesso.", 'tb_gruposvagas', $grupo);
                        }
                        else{
                                $erro = $this -> db -> error();
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro no cadastro do grupo de vagas. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'GruposVagas/create', 'Erro de criação do grupo de vagas. Erro: '.$erro['message']);
                        }
                }
                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos();
                $this -> load -> view('gruposvagas', $dados);
        }
	public function edit(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                
                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='edit';
                $pagina['url']='GruposVagas/edit';
                $pagina['nome_pagina']='Editar grupo de vagas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $dados['adicionais'] = array('pickers' => true);
                $dados_form = $this -> input -> post(null,true);
                $grupo = $this -> uri -> segment(3);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $grupo = $dados_form['codigo'];
                }
                $dados_grupo = $this -> GruposVagas_model -> get_grupos ($grupo);
                //var_dump($dados_vaga);
                $dados['codigo'] = $grupo;
                $dados += (array) $dados_grupo[0];
                //$dados += $this -> input -> post(null,true);
                //var_dump($this -> input -> post(null,true));

                $this -> form_validation -> set_rules('nome', "'Nome'", 'required');
                $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
                
                
                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] = validation_errors();
                }
                else{
                        $this -> GruposVagas_model -> update_grupo('vc_grupovaga', $dados_form['nome'], $grupo);
                        //if(isset($dados_form['instituicao']) && $dados_form['instituicao']>0){
                                $this -> GruposVagas_model -> update_grupo('es_instituicao', $dados_form['instituicao'], $grupo);
                        //}
                        $this -> Usuarios_model -> log('sucesso', 'GruposVagas/edit', "Grupo de vagas {$grupo} editado com sucesso pelo usuário ".$this -> session -> uid, 'tb_gruposvagas', $grupo);

                        $dados['sucesso'] = 'Grupo de vagas editado com sucesso.<br/><br/><a href="'.base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                        $dados['erro'] = '';
                }
                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos();
                $this -> load -> view('gruposvagas', $dados);
        }

        public function duplicate(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Vagas_model');
                
                $grupo = $this -> uri -> segment(3);


                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $grupo = $dados_form['codigo'];
                }
                
                $dados_grupo = $this -> GruposVagas_model -> get_grupos ($grupo);

                

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='duplicate';
                $pagina['url']='GruposVagas/duplicate';
                $pagina['nome_pagina']='Duplicar questão - '. $dados_grupo[0] -> vc_grupovaga;
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                

                $dados['adicionais'] = array(
                        'pickers' => true,
                        'datatables' => true);
                
                
                
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos('',true,true);

                
                
                $dados['codigo'] = $grupo;
               
                
                $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $grupo);

                /*$questoes = $dados['questoes'] = $this -> Questoes_model -> get_questoes();
                foreach($questoes as $questao){

                }*/

                $dados['questoes_duplicadas'] = $this -> Questoes_model -> get_grupos_questoes_duplicadas('',$grupo);

                $dados['sucesso'] = '';
                $dados['erro'] = '';

                $vagas = $this -> Vagas_model -> get_vagas('', false, 'array', '',0,$grupovaga = $grupo);

                if(isset($vagas) && count($vagas) > 0){
                        $dados['cont_vagas'] = count($vagas);
                        
                }
                else{
                        $dados['cont_vagas'] = 0;
                }

                //$this -> form_validation -> set_rules('questao', "'Questao'", 'required');
                $this -> form_validation -> set_rules('grupo', "'Grupo'", 'required');                
                
                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] = validation_errors();
                }
                else{
                        
                        foreach($dados['questoes'] as $questao){
                                if(isset($dados_form['questao'.$questao -> pr_questao]) && $dados_form['questao'.$questao -> pr_questao] == '1'){
                                        
                                        $questao_form = $this -> Questoes_model -> get_questoes($questao -> pr_questao);
                                        $this -> Questoes_model -> update_questao('bl_duplicado','1',$questao -> pr_questao);


                                        $dados_insercao['grupo'] = $dados_form['grupo'];
                                        $dados_insercao['etapa'] = $questao_form[0] -> es_etapa;
                                        $dados_insercao['descricao'] = $questao_form[0] -> tx_questao;
                                        $dados_insercao['competencia'] = $questao_form[0] -> es_competencia;
                                        $dados_insercao['respostaaceita'] = $questao_form[0] -> vc_respostaAceita;
                                        $dados_insercao['peso'] = $questao_form[0] -> in_peso;
                                        $dados_insercao['peso'] = $questao_form[0] -> in_peso;
                                        $dados_insercao['tipo'] = $questao_form[0] -> in_tipo;
                                        $dados_insercao['eliminatoria'] = $questao_form[0] -> bl_eliminatoria;                        
                                        $dados_insercao['obrigatorio'] = $questao_form[0] -> bl_obrigatorio;

                                        $questao_nova = $this -> Questoes_model -> create_questao($dados_insercao);

                                        $dados_duplicados['questao_origem'] = $questao -> pr_questao;
                                        $dados_duplicados['grupo_origem'] = $grupo;
                                        $dados_duplicados['questao_destino'] = $questao_nova;
                                        $dados_duplicados['grupo_destino'] = $dados_form['grupo'];

                                        $this -> Questoes_model -> create_grupos_questoes_duplicadas($dados_duplicados);


                                        $opcoes = $this -> Questoes_model -> get_opcoes('',$questao -> pr_questao);

                                        if(isset($opcoes)){
                                                foreach($opcoes as $opcao){
                                                        $dados_opcao['questao'] = $questao_nova;
                                                        $dados_opcao['texto'] = $opcao -> tx_opcao;
                                                        $dados_opcao['valor'] = $opcao -> in_valor;

                                                        $this -> Questoes_model -> create_opcoes( $dados_opcao);
                                                }
                                        }
                                        $this -> Usuarios_model -> log('sucesso', 'GruposVagas/duplicate', "Questão ".$questao -> pr_questao." duplicada com sucesso para o grupo ".$dados_form['grupo']." pelo usuário ".$this -> session -> uid, 'tb_questoes', $questao_nova);
                                }
                                
                                
                        }
                       

                        $dados['sucesso'] = 'Questão duplicada com sucesso.<br/><br/><a href="'.base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                        /*$dados['JaxonCss'] = $this->jaxon->css();
                        $dados['JaxonJs'] = $this->jaxon->js();
                        $dados['JaxonScript'] = $this->jaxon->script();*/
                        $dados['erro'] = '';
                }
                
                $this -> load -> view('gruposvagas', $dados);
        }

        public function getEtapa(){
                $retorno = array(1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0);
                $this -> load -> model('Questoes_model');
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['grupo'])){
                        $questoes = $this -> Questoes_model -> get_questoes('', $dados_form['grupo']);

                        foreach($questoes as $questao){
                                if($questao -> cont_respostas > 0){

                                        $retorno[$questao -> es_etapa] = 1;
                                }
                        }
                }
                //$retorno = $this -> GruposVagas_model -> get_grupos ();
                echo json_encode($retorno);
                //return json_encode($retorno);
        }

        public function historico_duplicate($grupo){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');

                $dados_grupo = $this -> GruposVagas_model -> get_grupos ($grupo);

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='historico_duplicate';
                $pagina['url']='GruposVagas/historico_duplicate';
                $pagina['nome_pagina']='Histórico de questão - '. $dados_grupo[0] -> vc_grupovaga;
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                

                $dados['adicionais'] = array(
                        'pickers' => true,
                        'datatables' => true);

                $dados['grupo'] = $grupo;

                $dados['sucesso'] = '';
                $dados['erro'] = '';
                
                $dados['questoes_duplicadas'] = $this -> Questoes_model -> get_grupos_questoes_duplicadas('',$grupo);

                $this -> load -> view('gruposvagas', $dados);
        }

        public function historico_duplicate_total(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');

                

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='historico_duplicate_total';
                $pagina['url']='GruposVagas/historico_duplicate_total';
                $pagina['nome_pagina']='Histórico de questões duplicadas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                

                $dados['adicionais'] = array(
                        'pickers' => true,
                        'datatables' => true);

                
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                
                $dados['questoes_duplicadas'] = $this -> Questoes_model -> get_grupos_questoes_duplicadas();

                $this -> load -> view('gruposvagas', $dados);
        }

        public function historico_duplicate_quantitativo(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');

                

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='historico_duplicate_quantitativo';
                $pagina['url']='GruposVagas/historico_duplicate_quantitativo';
                $pagina['nome_pagina']='Quantitativo de questões duplicadas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                

                $dados['adicionais'] = array(
                        'pickers' => true,
                        'datatables' => true);

                
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                
                $dados['questoes_duplicadas'] = $this -> Questoes_model -> cont_grupos_questoes_duplicadas();

                $this -> load -> view('gruposvagas', $dados);
        }


        public function create_motivacao($grupo){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');
                
                $grupo = $this -> uri -> segment(3);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $grupo = $dados_form['codigo'];
                }

                $dados_grupo = $this -> GruposVagas_model -> get_grupos ($grupo);

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='create_motivacao';
                $pagina['url']='GruposVagas/create_motivacao';
                $pagina['nome_pagina']='Criar questões de motivação - '. $dados_grupo[0] -> vc_grupovaga;
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $dados['adicionais'] = array('pickers' => true);
                $dados_form = $this -> input -> post(null,true);
                
                
                
               
                
                

                $dados['sucesso'] = '';
                $dados['erro'] = '';

                $this -> form_validation -> set_rules('questao', "'Questao'", 'required');
                $this -> form_validation -> set_rules('grupo', "'Grupo'", 'required');                
                
                
                //$questoes = $this -> Questoes_model -> get_questoes('',35,7);
                $questoes = array("a) Gerar impacto para a sociedade é mais importante do que minhas conquistas individuais",
                "b) Os acontecimentos do dia a dia sempre me lembram como somos dependentes uns dos outros",
                "c) A boa prestação do serviço público é algo muito importante para mim",
                "d) Eu correria o risco de perdas ou danos pessoais para ajudar alguém",
                "e) Eu estou disposto a fazer sacrifícios pessoais em prol do bem-estar coletivo");

                $opcoes = array(array("valor"=>"1","texto"=>"Discordo totalmente"),array("valor"=>"2","texto"=>"Discordo parcialmente"),array("valor"=>"3","texto"=>"Não concordo, nem discordo"),array("valor"=>"4","texto"=>"Concordo parcialmente"),array("valor"=>"5","texto"=>"Concordo totalmente"));


                foreach($questoes as $questao){
                        $dados_insercao['grupo'] = $grupo;
                        $dados_insercao['etapa'] = '7';
                        $dados_insercao['descricao'] = $questao;
                        $dados_insercao['competencia'] = null;
                        $dados_insercao['respostaaceita'] = '';
                        
                        $dados_insercao['peso'] = '';
                        $dados_insercao['tipo'] = "1";
                        $dados_insercao['eliminatoria'] = '0';                        
                        $dados_insercao['obrigatorio'] = '1';

                        $questao_nova = $this -> Questoes_model -> create_questao($dados_insercao);
                        //$opcoes = $this -> Questoes_model -> get_opcoes('',$questao -> pr_questao);

                        if(isset($opcoes)){
                                foreach($opcoes as $opcao){
                                        $dados_opcao['questao'] = $questao_nova;
                                        $dados_opcao['texto'] = $opcao['texto'];
                                        $dados_opcao['valor'] = $opcao['valor'];

                                        $this -> Questoes_model -> create_opcoes( $dados_opcao);
                                }
                        }
                        
                        
                }
                $this -> Usuarios_model -> log('sucesso', 'GruposVagas/create_motivacao', "Questões de Teste de motivação criadas com sucesso para o grupo ".$grupo." pelo usuário ".$this -> session -> uid, 'tb_questoes', $questao_nova);

                $dados['sucesso'] = 'Questões de Teste de motivação criadas.<br/><br/><a href="'.base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> load -> view('gruposvagas', $dados);
        }


	public function delete(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='delete';
                $pagina['url']='GruposVagas/delete';
                $pagina['nome_pagina']='Desativar grupo de vagas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $grupo = $this -> uri -> segment(3);

                $this -> GruposVagas_model -> update_grupo('bl_removido', '1', $grupo);
                $dados['sucesso'] = "Grupo de vagas desativado com sucesso.<br/><br/><a href=\"".base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'GruposVagas/delete', "Grupo de vagas {$grupo} desativado pelo usuário ".$this -> session -> uid, 'tb_gruposvagas', $grupo);
                echo "<script type=\"text/javascript\">alert('Grupo de vagas desativado com sucesso.');window.location='".base_url('GruposVagas/index')."';</script>";
                //$this -> load -> view('gruposvagas', $dados);
        }
	public function reactivate(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='reactivate';
                $pagina['url']='GruposVagas/reactivate';
                $pagina['nome_pagina']='Reativar grupo de vagas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $grupo = $this -> uri -> segment(3);

                $this -> GruposVagas_model -> update_grupo('bl_removido', '0', $grupo);
                $dados['sucesso'] = "Grupo de vagas reativado com sucesso.<br/><br/><a href=\"".base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'GruposVagas/reactivate', "Grupo de vagas {$grupo} reativado pelo usuário ".$this -> session -> uid, 'tb_gruposvagas', $grupo);
                
                echo "<script type=\"text/javascript\">alert('Grupo de vagas reativado com sucesso.');window.location='".base_url('GruposVagas/index')."';</script>";
                //$this -> load -> view('gruposvagas', $dados);
        }
}
