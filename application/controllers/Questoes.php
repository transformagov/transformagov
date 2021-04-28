<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questoes extends CI_Controller {
        function __construct() {
                parent::__construct();
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Questoes_model');
                $this -> load -> model('GruposVagas_model');
        }

	public function index()	{
                $this -> load -> helper('date');
                $this -> load -> model('Vagas_model');
                
                $pagina['menu1']='Questoes';
                $pagina['menu2']='index';
                $pagina['url']='Questoes/index';
                $pagina['nome_pagina']='Questões';
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                
                $dados['adicionais'] = array('datatables' => true);
                $grupo = $this -> uri -> segment(3);
                $dados['grupo']=$grupo;

                
                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', true, '', '',0,$grupo);
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos ($grupo);

                $dados['etapas'] = $this -> Questoes_model -> get_etapas();

                $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $grupo, '', '', false);

                $this -> load -> view('questoes', $dados);
	}
        
	public function create(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');

                $pagina['menu1']='Questoes';
                $pagina['menu2']='create';
                $pagina['url']='Questoes/create';
                $pagina['nome_pagina']='Nova questão';
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                $dados['adicionais'] = array('rangeslider' => true, 'wnumb' => true);//,'wysiwyg'=>true
                $grupo = $this -> uri -> segment(3);
                
                
                $dados_form = $this -> input -> post(null,true);
                if(strlen($grupo)==0||$grupo==0){
                        $grupo=$dados_form["grupo"];
                }
                $dados['grupo']=$grupo;
                //$dados += $this -> input -> post(null,true);

                $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
                $this -> form_validation -> set_rules('tipo', "'Tipo'", 'required|maior_que_zero|callback_valida_respostas', array('maior_que_zero' => 'O campo \'Tipo\' é obrigatório.', 'valida_respostas' => 'É necessário definir as respostas quando o tipo escolhido é \'Customizadas\'.'));
                $this -> form_validation -> set_rules('etapa', "'Etapa'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Etapa\' é obrigatório.'));
                $this -> form_validation -> set_rules('obrigatorio', "'Obrigatória?'", 'required|callback_valida_obrigatorio');
                $this -> form_validation -> set_rules('eliminatoria', "'Eliminatória?'", 'required|callback_valida_eliminatoria');

                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] = validation_errors();
                }
                else{
                        //var_dump($this -> input -> post(null,true));
                        if(!($dados_form['peso']>0)){
                                $dados_form['peso'] = 0;
                        }
                        $questao = $this -> Questoes_model -> create_questao($dados_form);
                        if($questao > 0){
                                if($this -> input -> post('tipo') == '1'){ //customizadas
                                        for ($i = 1; $i <= $this -> input -> post('num'); $i++){
                                                $dados_opcoes['questao'] = $questao;
                                                $dados_opcoes['texto'] = $this -> input -> post("texto{$i}");
                                                $dados_opcoes['valor'] = $this -> input -> post("valor{$i}");
                                                $this -> Questoes_model -> create_opcoes($dados_opcoes);
                                        }

                                }
                                $dados['sucesso'] = 'Questão cadastrada com sucesso.<br/><br/><a href="'.base_url('Questoes/index/'.$grupo).'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] =  NULL;
                                $this -> Usuarios_model -> log('sucesso', 'Questoes/create', "Questão {$questao} criada com sucesso.", 'tb_questoes', $questao);
                        }
                        else{
                                $erro = $this -> db -> error();
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro no cadastro da questão. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'Questoes/create', 'Erro de criação da questão. Erro: '.$erro['message']);
                        }
                }

                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos ($grupo);
                $dados['etapas'] = $this -> Questoes_model -> get_etapas($grupo);
                $dados['competencias'] = $this -> Questoes_model -> get_competencias();
                $this -> load -> view('questoes', $dados);
        }
	public function edit(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');

                $pagina['menu1']='Questoes';
                $pagina['menu2']='edit';
                $pagina['url']='Questoes/edit';
                $pagina['nome_pagina']='Editar questão';
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                $dados['adicionais'] = array('nouislidder' => true, 'wnumb' => true);//,'wysiwyg'=>true
                $dados_form = $this -> input -> post(null,true);
                $questao = $this -> uri -> segment(3);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $questao = $dados_form['codigo'];
                }
                $grupo = $this -> uri -> segment(4);
                if(isset($dados_form['grupo']) && $dados_form['grupo'] > 0){
                        $grupo = $dados_form['grupo'];
                }
                $dados['grupo']=$grupo;
                $dados_questao = $this -> Questoes_model -> get_questoes ($questao);
                //var_dump($dados_questao);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', $questao);
                
                if($dados_questao[0] -> cont_respostas > 0){
                        $dados['menu2']='';
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Não é possível editar questões que possuem respostas associadas. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Questoes/edit', "Tentativa de editar questão {$questao} com respostas pelo usuário ".$this -> session -> uid, 'tb_questoes', $questao);
                }
                else{
                        //var_dump($dados_vaga);
                        $dados['codigo'] = $questao;
                        $dados += (array) $dados_questao[0];
                        //$dados += $this -> input -> post(null,true);
                        //var_dump($this -> input -> post(null,true));

                        $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
                        $this -> form_validation -> set_rules('tipo', "'Tipo'", 'required|maior_que_zero|callback_valida_respostas', array('maior_que_zero' => 'O campo \'Tipo\' é obrigatório.', 'valida_respostas' => 'É necessário definir as respostas quando o tipo escolhido é \'Customizadas\'.'));
                        $this -> form_validation -> set_rules('etapa', "'Etapa'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Etapa\' é obrigatório.'));
                        $this -> form_validation -> set_rules('obrigatorio', "'Obrigatória?'", 'required|callback_valida_obrigatorio');
                        $this -> form_validation -> set_rules('eliminatoria', "'Eliminatória?'", 'required|callback_valida_eliminatoria');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                //var_dump($this -> input -> post(null,true));
                                if(!($dados_form['peso']>0)){
                                        $dados_form['peso'] = 0;
                                }
                                $this -> Questoes_model -> update_questao('es_etapa', $dados_form['etapa'], $questao);
                                if($dados_form['competencia']>0){
                                        $this -> Questoes_model -> update_questao('es_competencia', $dados_form['competencia'], $questao);
                                }
                                $this -> Questoes_model -> update_questao('tx_questao', $dados_form['descricao'], $questao);
                                $this -> Questoes_model -> update_questao('vc_respostaAceita', $dados_form['respostaaceita'], $questao);
                                $this -> Questoes_model -> update_questao('in_peso', $dados_form['peso'], $questao);
                                $this -> Questoes_model -> update_questao('in_tipo', $dados_form['tipo'], $questao);
                                $this -> Questoes_model -> update_questao('bl_eliminatoria', $dados_form['eliminatoria'], $questao);
                                $this -> Questoes_model -> update_questao('bl_obrigatorio', $dados_form['obrigatorio'], $questao);
                                
                                if($this -> input -> post('tipo') == '1'){ //customizadas
                                        for ($i = 1; $i <= $this -> input -> post('num'); $i++){
                                                $dados_opcoes['questao'] = $questao;
                                                $dados_opcoes['texto'] = $this -> input -> post("texto{$i}");
                                                $dados_opcoes['valor'] = $this -> input -> post("valor{$i}");
                                                $this -> Questoes_model -> create_opcoes($dados_opcoes);
                                        }
                                        foreach($dados['opcoes'] as $linha){
                                                //var_dump($linha);
                                                if(strlen($this -> input -> post('texto_'.$linha -> pr_opcao)) > 0){
                                                        $this -> Questoes_model -> update_opcao('tx_opcao', $this -> input -> post('texto_'.$linha -> pr_opcao), $linha -> pr_opcao);
                                                        $this -> Questoes_model -> update_opcao('in_valor', $this -> input -> post('valor_'.$linha -> pr_opcao), $linha -> pr_opcao);
                                                }
                                                else{
                                                        $this -> Questoes_model -> delete_opcao($linha -> pr_opcao);
                                                }
                                        }
                                }

                                $this -> Usuarios_model -> log('sucesso', 'Questoes/edit', "Questão {$questao} editada com sucesso pelo usuário ".$this -> session -> uid, 'tb_questoes', $questao);

                                $dados['sucesso'] = 'Questão editada com sucesso.<br/><br/><a href="'.base_url('Questoes/index/'.$grupo).'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] = '';
                        }
                }
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos ($grupo);
                $dados['etapas'] = $this -> Questoes_model -> get_etapas($grupo,$questao);
                $dados['competencias'] = $this -> Questoes_model -> get_competencias();
                $this -> load -> view('questoes', $dados);
        }
		public function view(){
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');
				
                $pagina['menu1']='Questoes';
                $pagina['menu2']='view';
                $pagina['url']='Questoes/view';
                $pagina['nome_pagina']='Editar questão';
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                $dados['adicionais'] = array('nouislidder' => true, 'wnumb' => true);
				
				$dados['erro'] = "";
				$dados['sucesso'] = "";
				
               
                $questao = $this -> uri -> segment(3);
				$dados['codigo'] = $questao;
                /*if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $questao = $dados_form['codigo'];
                }*/
                $grupo = $this -> uri -> segment(4);
                /*if(isset($dados_form['grupo']) && $dados_form['grupo'] > 0){
                        $grupo = $dados_form['grupo'];
                }*/
                $dados['grupo']=$grupo;
                $dados_questao = $this -> Questoes_model -> get_questoes ($questao);
				
				$dados += (array) $dados_questao[0];
                //var_dump($dados_questao);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', $questao);
                
                
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos ($grupo);
                $dados['etapas'] = $this -> Questoes_model -> get_etapas();
                $dados['competencias'] = $this -> Questoes_model -> get_competencias();
                $this -> load -> view('questoes', $dados);
        }
		
	public function delete(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='Questoes';
                $pagina['menu2']='delete';
                $pagina['url']='Questoes/delete';
                $pagina['nome_pagina']='Desativar questão';
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                $questao = $this -> uri -> segment(3);
                $grupo = $this -> uri -> segment(4);
                $dados['grupo']=$grupo;

                $this -> Questoes_model -> update_questao('bl_removido', '1', $questao);
                $dados['sucesso'] = "A questão foi desativada com sucesso.<br/><br/><a href=\"".base_url('Questoes/index/'.$grupo).'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'Vagas/delete', "Questão {$questao} desativada pelo usuário ".$this -> session -> uid, 'tb_questoes', $questao);
                echo "<script type=\"text/javascript\">alert('A questão foi desativada com sucesso.');window.location='".base_url('Questoes/index/'.$grupo)."';</script>";
                //$this -> load -> view('questoes', $dados);
        }
	public function reactivate(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='Questoes';
                $pagina['menu2']='reactivate';
                $pagina['url']='Questoes/reactivate';
                $pagina['nome_pagina']='Reativar questão';
                $pagina['icone']='fa fa-check-square-o';

                $dados=$pagina;
                $questao = $this -> uri -> segment(3);
                $grupo = $this -> uri -> segment(4);
                $dados['grupo']=$grupo;

                $this -> Questoes_model -> update_questao('bl_removido', '0', $questao);
                $dados['sucesso'] = "A questão foi reativada com sucesso.<br/><br/><a href=\"".base_url('Questoes/index/'.$grupo).'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'Vagas/reactivate', "Questão {$questao} reaativada pelo usuário ".$this -> session -> uid, 'tb_questoes', $questao);

                echo "<script type=\"text/javascript\">alert('A questão foi reativada com sucesso.');window.location='".base_url('Questoes/index/'.$grupo)."';</script>";
                //$this -> load -> view('questoes', $dados);
        }
        public function valida_respostas(){ //callback de validação customizada do formulário de cadastro
                $dados_form = $this -> input -> post(null,true);
                $questao = $this -> uri -> segment(3);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $questao = $dados_form['codigo'];
                }
                $num = $dados_form['num'];
                $tipo = $dados_form['tipo'];
                $algum = false;
                for ($i = 1; $i <= $num; $i++){
                        if(strlen($dados_form["texto{$i}"]) > 0){
                                $algum = true;
                        }
                }
                if($questao > 0){
                        $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', $questao);
                        if($dados['opcoes'] && count($dados['opcoes'])>0){
                                foreach($dados['opcoes'] as $linha){
                                        if(strlen($dados_form['texto_'.$linha -> pr_opcao]) > 0){
                                                $algum = true;
                                        }
                                }
                        }
                }
                if ($tipo == '1' && !$algum){
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        public function valida_obrigatorio(){ //callback de validação customizada do formulário de cadastro
                $obrigatorio = $this -> input -> post('obrigatorio');
                $etapa = $this -> input -> post('etapa');
                $eliminatoria = $this -> input -> post('eliminatoria');
                if ($etapa == '1' && $obrigatorio == '0'){
                        $this->form_validation->set_message('valida_obrigatorio', "O campo 'Obrigatória?' deve ser 'Sim' na 'Etapa 1 - Req. obrigatórios'.");
                        return FALSE;
                }

                /*else if ($etapa == '2' && $obrigatorio == '1'){
                        $this->form_validation->set_message('valida_obrigatorio', "O campo 'Obrigatória?' deve ser 'Não' na 'Etapa 2 - Req. desejáveis'.");
                        return FALSE;
                }*/
                else if ($etapa == '2' && $eliminatoria == '1'){
                        $this->form_validation->set_message('valida_obrigatorio', "O campo 'Eliminatória?' deve ser 'Não' na 'Etapa 2 - Req. desejáveis'.");
                        return FALSE;
                }
				
                else
                {
                        return TRUE;
                }
        }
                        
        public function valida_eliminatoria(){ //callback de validação customizada do formulário de cadastro
                $eliminatoria = $this -> input -> post('eliminatoria');
                $etapa = $this -> input -> post('etapa');
                $tipo = $this -> input -> post('tipo');
                if ($etapa == '1' && $eliminatoria == '0'){
                        $this->form_validation->set_message('valida_eliminatoria', "O campo 'Eliminatória?' deve ser 'Sim' na 'Etapa 1 - Req. obrigatórios'.");
                        return FALSE;
                }
                else if($etapa != '1' && $eliminatoria == '1'){
                        $this->form_validation->set_message('valida_eliminatoria', "O campo 'Eliminatória?' somente pode ser usado na etapa 'Etapa 1 - Req. obrigatórios'.");
                        return FALSE;
                }
                else if($etapa == 1 && $tipo != '3' && $tipo != '4' && $tipo != '7'){
                        $this->form_validation->set_message('valida_eliminatoria', "A questão não pode ser 'Etapa 1 - Req. obrigatórios' se não for 'Sim/Não' ou 'Upload'.");
                        return FALSE;
                }
                else if ($etapa == '2' && $eliminatoria == '1'){
                        $this->form_validation->set_message('valida_eliminatoria', "O campo 'Eliminatória?' deve ser 'Não' na 'Etapa 2 - Req. desejáveis'.");
                        return FALSE;
                }
                else if ($tipo == '2' && $eliminatoria == '1'){
                        $this->form_validation->set_message('valida_eliminatoria', "O campo 'Eliminatória?' deve ser 'Não' se o tipo da questão for 'Aberta'.");
                        return FALSE;
                }
	        else if($tipo == '6' && $eliminatoria == '1'){
                        $this->form_validation->set_message('valida_eliminatoria', "O campo 'Eliminatória?' deve ser 'Não' se o tipo da questão for 'Intervalo'.");
                        return FALSE;
                }
                else if($tipo == '6' && $etapa == '1'){
                        $this->form_validation->set_message('valida_eliminatoria', "A questão não pode ser 'Etapa 1 - Req. obrigatórios' se for 'Intervalo'.");
                        return FALSE;
                }
                else if($tipo == '7' && $etapa != '1' && $etapa != '2'){
                        $this->form_validation->set_message('valida_eliminatoria', "A questão deve ser 'Etapa 1 - Req. obrigatórios' se for 'Upload' or 'Etapa 2 - Req. desejáveis'.");
                        return FALSE;
				}
                else
                {
                        return TRUE;
                }
        }
}
