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
                //$this -> load -> model('Instituicoes_model');    
        }

	public function index($inativo = 0)	{ 
                $this -> load -> helper('date');
                $this -> load -> model('Vagas_model');

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='index';
                $pagina['url']='GruposVagas/index';
                $pagina['nome_pagina']='Grupos de vagas';
                $pagina['icone']='fa fa-thumb-tack';

                $dados=$pagina;
                $dados['adicionais'] = array(
                                            'datatables' => true);
                //$vaga = $this -> uri -> segment(3);
                if($inativo == 0){
                        $dados['grupos'] = $this -> GruposVagas_model -> get_grupos('');
                }
                else{
                        $dados['grupos'] = $this -> GruposVagas_model -> get_grupos('', false);
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
                $pagina['icone']='fa fa-thumb-tack';

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
                $pagina['icone']='fa fa-thumb-tack';

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
	public function delete(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='delete';
                $pagina['url']='GruposVagas/delete';
                $pagina['nome_pagina']='Desativar grupo de vagas';
                $pagina['icone']='fa fa-thumb-tack';

                $dados=$pagina;
                $grupo = $this -> uri -> segment(3);

                $this -> GruposVagas_model -> update_grupo('bl_removido', '1', $grupo);
                $dados['sucesso'] = "Grupo de vagas desativado com sucesso.<br/><br/><a href=\"".base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'GruposVagas/delete', "Grupo de vagas {$grupo} desativado pelo usuário ".$this -> session -> uid, 'tb_gruposvagas', $grupo);
                
                $this -> load -> view('gruposvagas', $dados);
        }
	public function reactivate(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='GruposVagas';
                $pagina['menu2']='reactivate';
                $pagina['url']='GruposVagas/reactivate';
                $pagina['nome_pagina']='Reativar grupo de vagas';
                $pagina['icone']='fa fa-thumb-tack';

                $dados=$pagina;
                $grupo = $this -> uri -> segment(3);

                $this -> GruposVagas_model -> update_grupo('bl_removido', '0', $grupo);
                $dados['sucesso'] = "Grupo de vagas reativado com sucesso.<br/><br/><a href=\"".base_url('GruposVagas/index').'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'GruposVagas/reactivate', "Grupo de vagas {$grupo} reativado pelo usuário ".$this -> session -> uid, 'tb_gruposvagas', $grupo);
                
                $this -> load -> view('gruposvagas', $dados);
        }
}
