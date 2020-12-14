<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos extends CI_Controller {
        function __construct() {
                parent::__construct();
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Candidaturas_model');
                
        }

	public function index()	{ //atualização dos dados pessoais dos candidatos já cadastrados
                $this -> load -> model('Anexos_model');
                $config['upload_path'] = './anexos/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2048;
                $this -> load -> library('upload', $config);
                
                if(!$this -> session -> logado){
                        redirect('Publico');
                }

                if($this -> session -> perfil == 'candidato'){ //candidato
                        $this -> load -> library('MY_Form_Validation');
                        
                        $pagina['menu1']='Candidatos';
                        $pagina['menu2']='index';
                        $pagina['url']='Candidatos/index';
                        $pagina['nome_pagina']='Seus dados';
                        $pagina['icone']='fa fa-user';

                        $dados_candidato = $this -> Candidatos_model -> get_candidatos($this -> session -> candidato);
                        $dados = (array) $dados_candidato;
                        
                        $dados += $pagina;
                        
                        /*$dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato);
                        $i=0;
                        if(count($dados_formacao)>0){
                                foreach($dados_formacao as $formacao){
                                        ++$i;
                                        $dados['en_tipo'][$i]=$formacao->en_tipo;
                                        $dados['vc_curso'][$i]=$formacao->vc_curso;
                                        $dados['vc_instituicao'][$i]=$formacao->vc_instituicao;
                                        
					$dados['dt_conclusao'][$i]=$formacao->dt_conclusao;
					$dados['in_cargahoraria'][$i]=$formacao->in_cargahoraria;
                                        $dados['pr_formacao'][$i]=$formacao->pr_formacao;
					$dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                }
                        }
                        $dados['num_formacao']=$i;
                        $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato);
                        
                        $i=0;
                        if(count($dados_experiencia)>0){
                                foreach($dados_experiencia as $experiencia){
                                        ++$i;
                                        $dados['vc_empresa'][$i]=$experiencia->vc_empresa;
                                        $dados['dt_inicio'][$i]=$experiencia->dt_inicio;
										
                                        $dados['dt_fim'][$i]=$experiencia->dt_fim;
										
                                        $dados['tx_atividades'][$i]=$experiencia->tx_atividades;
                                        $dados['pr_experienca'][$i]=$experiencia->pr_experienca;
										$dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                }
                        }
                        $dados['num_experiencia']=$i;*/
                        
                        $dados['adicionais'] = array('inputmasks' => true);

                        $this -> form_validation -> set_rules('IdentidadeGenero', "'Gênero'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Gênero\' é obrigatório.'));
                        //$this -> form_validation -> set_rules('IdentidadeGeneroOptativa', "'Gênero optativo'", 'callback_valida_genero_optativo'); //se o de cima estiver == 4
                        $this -> form_validation -> set_rules('Raca', "'Raça'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Raça\' é obrigatório.'));
                        $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                        $this -> form_validation -> set_rules('Telefone', "'Telefone'", 'required|min_length[14]');
                        $this -> form_validation -> set_rules('DataNascimento', "'Data de nascimento'", 'required|valida_data', array('required' => 'O campo \'Data de nascimento\' é obrigatório.', 'valida_data' => 'A data de nascimento inserida é inválida.'));
                        //$this -> form_validation -> set_rules('Pais2', "'País estrangeiro'", 'callback_valida_cidade_estrangeira');
                        //$this -> form_validation -> set_rules('CidadeEstrangeira', "'Cidade estrangeira'", 'callback_valida_cidade_estrangeira');
                        $this -> form_validation -> set_rules('CEP', "'CEP'", 'required|min_length[9]');
                        $this -> form_validation -> set_rules('Logradouro', "'Logradouro'", 'required');
                        $this -> form_validation -> set_rules('Numero', "'Numero'", 'required');
                        $this -> form_validation -> set_rules('Bairro', "'Bairro'", 'required');
                        $this -> form_validation -> set_rules('Estado', "'Estado'", 'required');
                        $this -> form_validation -> set_rules('Municipio', "'Município'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Munícipio\' é obrigatório.'));
                        
                        $erro='';
                        $algum = false;
						
                        /*for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                        $algum = true; 
                                        if(strlen($this -> input -> post("tipo{$i}")) == 0){
                                                $erro .= "Você deve escolher o tipo da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        if(strlen($this -> input -> post("curso{$i}")) == 0){
                                                $erro .= "Você deve inserir o nome do curso da 'Formação acadêmica {$i}'.<br/>";
                                        }
										else if($this -> input -> post("curso{$i}") == 'seminario' && strlen($this -> input -> post("cargahoraria{$i}")) == 0){
												$erro .= "Você deve inserir a carga horária da 'Formação acadêmica {$i}'.<br/>";
										}
                                        if(strlen($this -> input -> post("instituicao{$i}")) == 0){
                                                $erro .= "Você deve inserir a instituição de ensino da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        if(strlen($this -> input -> post("conclusao{$i}")) == 0){
                                                $erro .= "Você deve escolher a data da conclusão da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        
                                        if((!isset($_FILES["diploma{$i}"]['name']) || strlen($_FILES["diploma{$i}"]['name']) == 0) && !(strlen($this -> input -> post("codigo_formacao{$i}"))>0)){
                                                $erro .= "Você deve anexar o diploma / certificado da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        
                                }
                        }
                        if(!$algum){
                                $erro.='Você deve preencher ao menos uma formação acadêmica.<br/>';
                        }
                        $algum = false;
                        for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("fim{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                        $algum = true; 
                                        if(strlen($this -> input -> post("empresa{$i}")) == 0){
                                                $erro .= "Você deve inserir a instituição / empresa da 'Experiência profissional {$i}'.<br/>";
                                        }
                                        if(strlen($this -> input -> post("inicio{$i}")) == 0){
                                                $erro .= "Você deve inserir o data de início da 'Experiência profissional {$i}'.<br/>";
                                        }
                                        else if(strlen($this -> input -> post("fim{$i}")) > 0 && strtotime($this -> input -> post("fim{$i}"))<strtotime($this -> input -> post("inicio{$i}"))){
                                                $erro .= "A data de término deve ser igual ou maior à data de início da 'Experiência profissional {$i}'.<br/>";
                                        }
										
										
                                        if(strlen($this -> input -> post("atividades{$i}")) == 0){
                                                $erro .= "Você deve inserir a descrição de atividades da 'Experiência profissional {$i}'.<br/>";
                                        }
										if((!isset($_FILES["comprovante{$i}"]['name']) || strlen($_FILES["comprovante{$i}"]['name']) == 0) && !(strlen($this -> input -> post("codigo_experiencia{$i}"))>0)){
                                                $erro .= "Você deve anexar o comprovante da 'Experiência profissional {$i}'.<br/>";
                                        }
                                }
                        }
                        if(!$algum){
                                $erro.='Você deve preencher ao menos uma experiência profissional.<br/>';
                        }*/
                        
                        /*if(strlen($erro)==0){

                                for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                        if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                                        if ( ! $this -> upload -> do_upload("diploma{$i}")){
                                                                //echo 'Erro no envio do arquivo do currículo: '.$this -> upload -> display_errors().'.<br>';
                                                                $erro.=$this -> upload -> display_errors()." O envio do diploma / certificado da 'Formação acadêmica {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 2 MBytes.<br>";
                                                        }
                                                        else{
                                                                $dados_upload["envio_curriculo{$i}"] = $this -> upload -> data();

                                                        }
                                                }
                                                
                                        }
                                }
								
				for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                        if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
												if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                        if ( ! $this -> upload -> do_upload("comprovante{$i}")){
                                                                //echo 'Erro no envio do arquivo do currículo: '.$this -> upload -> display_errors().'.<br>';
                                                                $erro.=$this -> upload -> display_errors()." O envio do comprovante da 'Experiência profissional {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 2 MBytes.<br>";
                                                        }
                                                        else{
                                                                $dados_upload["envio_experiencia{$i}"] = $this -> upload -> data();

                                                        }
                                                }
                                                
                                        }
                                }
                                
                        }*/
                        
                        
                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] =  validation_errors();
                        }
                        else if(strlen($erro)>0){
                                $dados['sucesso'] = '';
                                $dados['erro'] =  $erro;
                        }
                        else{
                                $this -> load -> model('Usuarios_model'); //para o log
                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['codigo'] = $this -> session -> candidato;
                                if(!isset($dados_form['IdentidadeGeneroOptativa'])){
                                        $dados_form['IdentidadeGeneroOptativa'] = NULL;
                                }
                                if($this -> Candidatos_model -> update_candidato($dados_form)){ //atualizado
                                        $dados_candidato = $this -> Candidatos_model -> get_candidatos($this -> session -> candidato);
                                        $dados = (array) $dados_candidato;
                                        
                                        /*for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                                if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                                        if(strlen($this -> input -> post("codigo_formacao{$i}"))>0){
                                                                $this -> Candidaturas_model -> update_formacao("vc_curso", $this -> input -> post("curso{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                $this -> Candidaturas_model -> update_formacao("en_tipo", $this -> input -> post("tipo{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                $this -> Candidaturas_model -> update_formacao("vc_instituicao", $this -> input -> post("instituicao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                $this -> Candidaturas_model -> update_formacao("dt_conclusao", $this -> input -> post("conclusao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                
                                                                
								if(strlen($this -> input -> post("cargahoraria{$i}")) > 0){
										$this -> Candidaturas_model -> update_formacao("in_cargahoraria", $this -> input -> post("cargahoraria{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
								}
								else{
										$this -> Candidaturas_model -> update_formacao("in_cargahoraria", null ,$this -> input -> post("codigo_formacao{$i}"));
								}
								if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                                        $dados_upload["envio_curriculo{$i}"]['formacao'] = $this -> input -> post("codigo_formacao{$i}");

                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_curriculo{$i}"], '1');
                                                                        if($id > 0){
                                                                                rename($config['upload_path'].$dados_upload["envio_curriculo{$i}"]['file_name'], $config['upload_path'].$id);
                                                                        }
                                                                }
                                                        }
                                                        else{
                                                                $formacao = $this -> Candidaturas_model -> create_formacao($dados_form, $i);
                                                                $dados_upload["envio_curriculo{$i}"]['formacao'] = $formacao;

                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_curriculo{$i}"], '1');
                                                                if($id > 0){
                                                                        rename($config['upload_path'].$dados_upload["envio_curriculo{$i}"]['file_name'], $config['upload_path'].$id);
                                                                }
                                                        }
                                                }
                                        }
                                        for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                                if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                        if(strlen($this -> input -> post("codigo_experiencia{$i}"))>0){
                                                                $this -> Candidaturas_model -> update_experiencia("vc_empresa", $this -> input -> post("empresa{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                $this -> Candidaturas_model -> update_experiencia("dt_inicio", $this -> input -> post("inicio{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                
								if(strlen($this -> input -> post("fim{$i}"))>0){
                                                                        $this -> Candidaturas_model -> update_experiencia("dt_fim", $this -> input -> post("fim{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));																		
                                                                }
								else{
										$this -> Candidaturas_model -> update_experiencia("dt_fim", null ,$this -> input -> post("codigo_experiencia{$i}"));																		
								}
                                                                
                                                                $this -> Candidaturas_model -> update_experiencia("tx_atividades", $this -> input -> post("atividades{$i}"),$this -> input -> post("codigo_experiencia{$i}"));
																
																if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                                        $dados_upload["envio_experiencia{$i}"]['experiencia'] = $this -> input -> post("codigo_experiencia{$i}");

                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_experiencia{$i}"], '1');
                                                                        if($id > 0){
                                                                                rename($config['upload_path'].$dados_upload["envio_experiencia{$i}"]['file_name'], $config['upload_path'].$id);
                                                                        }
                                                                }
                                                        }
                                                        else{
                                                                $experiencia = $this -> Candidaturas_model -> create_experiencia($dados_form, $i);
																
																$dados_upload["envio_experiencia{$i}"]['experiencia'] = $experiencia;

                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_experiencia{$i}"], '1');
                                                                if($id > 0){
                                                                        rename($config['upload_path'].$dados_upload["envio_experiencia{$i}"]['file_name'], $config['upload_path'].$id);
                                                                }
                                                        }
                                                }
                                        }
                                        
                                        
                                        $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato);
                                        $i=0;
                                        foreach($dados_formacao as $formacao){
                                                ++$i;
                                                $dados['en_tipo'][$i]=$formacao->en_tipo;
                                                $dados['vc_curso'][$i]=$formacao->vc_curso;
                                                $dados['vc_instituicao'][$i]=$formacao->vc_instituicao;
                                                $dados['dt_conclusao'][$i]=$formacao->ye_conclusao;
												
												$dados['in_cargahoraria'][$i]=$formacao->in_cargahoraria;
                                                $dados['pr_formacao'][$i]=$formacao->pr_formacao;

                                        }
                                        $dados['num_formacao']=$i;
                                        $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato);

                                        $i=0;
                                        foreach($dados_experiencia as $experiencia){
                                                ++$i;
                                                $dados['vc_empresa'][$i]=$experiencia->vc_empresa;
                                                $dados['dt_inicio'][$i]=$experiencia->dt_inicio;
												
                                                $dados['dt_fim'][$i]=$experiencia->dt_fim;
												
                                                $dados['tx_atividades'][$i]=$experiencia->tx_atividades;
                                                $dados['pr_experienca'][$i]=$experiencia->pr_experienca;
                                        }
                                        $dados['num_experiencia']=$i;*/
                                        
										//if($this -> input -> post("num_experiencia")<=$dados['num_experiencia']){
					$dados['sucesso'] = 'Dados atualizados com sucesso.';
										/*}
										else{
												$dados['sucesso'] = '';
										}*/
                                        $dados['erro'] = '';

                                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/index', 'Candidato '.$this -> session -> candidato.' atualizou seus dados com sucesso.', 'tb_candidatos', $this -> session -> candidato);
                                }
                                else{
                                        $erro = $this -> db -> error();
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  'Erro ao salvar seus dados. Os responsáveis já foram avisados.';

                                        $this -> Usuarios_model -> log('erro', 'Candidatos/index', 'Erro na atualização dos seus dados pelo candidato '.$this -> session -> candidato.': '.$erro['message'], 'tb_candidatos', $this -> session -> candidato);
                                }
                        }

                        $dados['Estados'] = $this -> Candidatos_model -> get_Estados();
                        $dados['Municipios'] = 'Selecione o Estado ao lado.';
                        $dados += $pagina;
						
			$this->load->view('dados', $dados);
						
                }
	}

        public function curriculo_base(){
                $this -> load -> model('Anexos_model');
                $config['upload_path'] = './anexos/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2048;
                $this -> load -> library('upload', $config);
                
                if(!$this -> session -> logado){
                        redirect('Publico');
                }

                if($this -> session -> perfil == 'candidato'){ //candidato
                        $this -> load -> library('MY_Form_Validation');
                        
                        $pagina['menu1']='Candidatos';
                        $pagina['menu2']='index';
                        $pagina['url']='Candidatos/curriculo_base';
                        $pagina['nome_pagina']='Currículo Base';
                        $pagina['icone']='fa fa-user';

                        /*$dados_candidato = $this -> Candidatos_model -> get_candidatos($this -> session -> candidato);
                        $dados = (array) $dados_candidato;*/
                        $dados = array();
                        $dados += $pagina;
                        
                        $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato);
                        $i=0;
                        if(count($dados_formacao)>0){
                                foreach($dados_formacao as $formacao){
                                        ++$i;
                                        $dados['en_tipo'][$i]=$formacao->en_tipo;
                                        $dados['vc_curso'][$i]=$formacao->vc_curso;
                                        $dados['vc_instituicao'][$i]=$formacao->vc_instituicao;
                                        
                                        $dados['dt_conclusao'][$i]=$formacao->dt_conclusao;
                                        $dados['in_cargahoraria'][$i]=$formacao->in_cargahoraria;
                                        $dados['pr_formacao'][$i]=$formacao->pr_formacao;
                                        $dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                }
                        }
                        $dados['num_formacao']=$i;
                        $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato);
                        
                        $i=0;
                        if(count($dados_experiencia)>0){
                                foreach($dados_experiencia as $experiencia){
                                        ++$i;
                                        $dados['vc_empresa'][$i]=$experiencia->vc_empresa;
                                        $dados['dt_inicio'][$i]=$experiencia->dt_inicio;
                                        $dados['bl_emprego_atual'][$i]=$experiencia->bl_emprego_atual;                                        
                                        $dados['dt_fim'][$i]=$experiencia->dt_fim;
                                                                                
                                        $dados['tx_atividades'][$i]=$experiencia->tx_atividades;
                                        $dados['pr_experienca'][$i]=$experiencia->pr_experienca;
                                        $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                }
                        }
                        $dados['num_experiencia']=$i;
                        
                        $dados['adicionais'] = array('inputmasks' => true);

                        /*$this -> form_validation -> set_rules('IdentidadeGenero', "'Gênero'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Gênero\' é obrigatório.'));
                        $this -> form_validation -> set_rules('IdentidadeGeneroOptativa', "'Gênero optativo'", 'callback_valida_genero_optativo'); //se o de cima estiver == 4
                        $this -> form_validation -> set_rules('Raca', "'Raça'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Raça\' é obrigatório.'));
                        $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                        $this -> form_validation -> set_rules('Telefone', "'Telefone'", 'required|min_length[14]');
                        $this -> form_validation -> set_rules('DataNascimento', "'Data de nascimento'", 'required|valida_data', array('required' => 'O campo \'Data de nascimento\' é obrigatório.', 'valida_data' => 'A data de nascimento inserida é inválida.'));
                        $this -> form_validation -> set_rules('Pais2', "'País estrangeiro'", 'callback_valida_cidade_estrangeira');
                        $this -> form_validation -> set_rules('CidadeEstrangeira', "'Cidade estrangeira'", 'callback_valida_cidade_estrangeira');
                        $this -> form_validation -> set_rules('CEP', "'CEP'", 'required|min_length[9]');
                        $this -> form_validation -> set_rules('Logradouro', "'Logradouro'", 'required');
                        $this -> form_validation -> set_rules('Numero', "'Numero'", 'required');
                        $this -> form_validation -> set_rules('Bairro', "'Bairro'", 'required');
                        $this -> form_validation -> set_rules('Estado', "'Estado'", 'required');
                        $this -> form_validation -> set_rules('Municipio', "'Município'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Munícipio\' é obrigatório.'));*/
                        
                        $erro='';
                        $algum = false;
                                                
                        for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                        $algum = true; 
                                        if(strlen($this -> input -> post("tipo{$i}")) == 0){
                                                $erro .= "Você deve escolher o tipo da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        if(strlen($this -> input -> post("curso{$i}")) == 0){
                                                $erro .= "Você deve inserir o nome do curso da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                                                                else if($this -> input -> post("curso{$i}") == 'seminario' && strlen($this -> input -> post("cargahoraria{$i}")) == 0){
                                                                                                $erro .= "Você deve inserir a carga horária da 'Formação acadêmica {$i}'.<br/>";
                                                                                }
                                        if(strlen($this -> input -> post("instituicao{$i}")) == 0){
                                                $erro .= "Você deve inserir a instituição de ensino da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        if(strlen($this -> input -> post("conclusao{$i}")) == 0){
                                                $erro .= "Você deve escolher a data da conclusão da 'Formação acadêmica {$i}'.<br/>".$this -> input -> post("conclusao{$i}");
                                        }
                                        
                                        if((!isset($_FILES["diploma{$i}"]['name']) || strlen($_FILES["diploma{$i}"]['name']) == 0) && !(strlen($this -> input -> post("codigo_formacao{$i}"))>0)){
                                                $erro .= "Você deve anexar o diploma / certificado da 'Formação acadêmica {$i}'.<br/>";
                                        }
                                        
                                }
                        }
                        if(!$algum && strlen($this -> input -> post('cadastrar')) > 0){
                                $erro.='Você deve preencher ao menos uma formação acadêmica.<br/>';
                        }
                        $algum = false;
                        for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("fim{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                        $algum = true; 
                                        if(strlen($this -> input -> post("empresa{$i}")) == 0){
                                                $erro .= "Você deve inserir a instituição / empresa da 'Experiência profissional {$i}'.<br/>";
                                        }
                                        if(strlen($this -> input -> post("inicio{$i}")) == 0){
                                                $erro .= "Você deve inserir o data de início da 'Experiência profissional {$i}'.<br/>";
                                        }
                                        else if(strlen($this -> input -> post("fim{$i}")) > 0 && strtotime($this -> input -> post("fim{$i}"))<strtotime($this -> input -> post("inicio{$i}"))){
                                                $erro .= "A data de término deve ser igual ou maior à data de início da 'Experiência profissional {$i}'.<br/>";
                                        }
                                                                                
                                                                                
                                        if(strlen($this -> input -> post("atividades{$i}")) == 0){
                                                $erro .= "Você deve inserir a descrição de atividades da 'Experiência profissional {$i}'.<br/>";
                                        }
                                        /*if((!isset($_FILES["comprovante{$i}"]['name']) || strlen($_FILES["comprovante{$i}"]['name']) == 0) && !(strlen($this -> input -> post("codigo_experiencia{$i}"))>0)){
                                                $erro .= "Você deve anexar o comprovante da 'Experiência profissional {$i}'.<br/>";
                                        }*/
                                }
                        }
                        if(!$algum && strlen($this -> input -> post('cadastrar')) > 0){
                                $erro.='Você deve preencher ao menos uma experiência profissional.<br/>';
                        }
                        
                        if(strlen($erro)==0){

                                for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                        if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                                        //$this -> upload -> do_upload("diploma{$i}")
                                                        if ( !($_FILES["diploma{$i}"]['type'] == 'application/pdf' && $_FILES["diploma{$i}"]["size"] <= 2 * 1024 * 1024) ){
                                                                //echo 'Erro no envio do arquivo do currículo: '.$this -> upload -> display_errors().'.<br>';
                                                                //$this -> upload -> display_errors().
                                                                $erro.=" O envio do diploma / certificado da 'Formação acadêmica {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 2 MBytes.<br>";
                                                        }
                                                        else{
                                                                //$dados_upload["envio_curriculo{$i}"] = $this -> upload -> data();
                                                                $dados_upload["envio_curriculo{$i}"]['file_type'] = $_FILES["diploma{$i}"]['type'];
                                                                $dados_upload["envio_curriculo{$i}"]['file_size'] = $_FILES["diploma{$i}"]["size"];
                                                                $dados_upload["envio_curriculo{$i}"]['orig_name'] = $_FILES["diploma{$i}"]["name"];
                                                        }
                                                }
                                                
                                        }
                                }
                                                                
                                for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                        if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                        //$this -> upload -> do_upload("comprovante{$i}")
                                                        if ( !($_FILES["comprovante{$i}"]['type'] == 'application/pdf' && $_FILES["comprovante{$i}"]["size"] <= 2 * 1024 * 1024) ){
                                                                //echo 'Erro no envio do arquivo do currículo: '.$this -> upload -> display_errors().'.<br>';
                                                                $erro.=$this -> upload -> display_errors()." O envio do comprovante da 'Experiência profissional {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 2 MBytes.<br>";
                                                        }
                                                        else{
                                                                //$dados_upload["envio_experiencia{$i}"] = $this -> upload -> data();
                                                                $dados_upload["envio_experiencia{$i}"]['file_type'] = $_FILES["comprovante{$i}"]['type'];
                                                                $dados_upload["envio_experiencia{$i}"]['file_size'] = $_FILES["comprovante{$i}"]["size"];
                                                                $dados_upload["envio_experiencia{$i}"]['orig_name'] = $_FILES["comprovante{$i}"]["name"];

                                                        }
                                                }
                                                
                                        }
                                }
                                
                        }
                        
                        
                        /*if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] =  validation_errors();
                        }
                        else*/
                        $dados['sucesso'] = '';
                        $dados['erro'] = '';        
                        if(strlen($this -> input -> post('cadastrar')) > 0){        
                                if(strlen($erro)>0){
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  $erro;
                                }
                                else{
                                        $this -> load -> model('Usuarios_model'); //para o log
                                        $dados_form = $this -> input -> post(null,true);
                                        $dados_form['codigo'] = $this -> session -> candidato;
                                        /*if(!isset($dados_form['IdentidadeGeneroOptativa'])){
                                                $dados_form['IdentidadeGeneroOptativa'] = NULL;
                                        }*/
                                        //if($this -> Candidatos_model -> update_candidato($dados_form)){ //atualizado
                                                /*$dados_candidato = $this -> Candidatos_model -> get_candidatos($this -> session -> candidato);
                                                $dados = (array) $dados_candidato;*/
                                                
                                                for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                                        if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                                                if(strlen($this -> input -> post("codigo_formacao{$i}"))>0){
                                                                        $this -> Candidaturas_model -> update_formacao("vc_curso", $this -> input -> post("curso{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("en_tipo", $this -> input -> post("tipo{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("vc_instituicao", $this -> input -> post("instituicao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("dt_conclusao", $this -> input -> post("conclusao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        
                                                                        
                                                                        if(strlen($this -> input -> post("cargahoraria{$i}")) > 0){
                                                                                        $this -> Candidaturas_model -> update_formacao("in_cargahoraria", $this -> input -> post("cargahoraria{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        }
                                                                        else{
                                                                                        $this -> Candidaturas_model -> update_formacao("in_cargahoraria", null ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        }
                                                                        if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                                                $dados_upload["envio_curriculo{$i}"]['formacao'] = $this -> input -> post("codigo_formacao{$i}");
                                                                                if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_curriculo{$i}"], '1');
                                                                                        if($id > 0){
                                                                                                if(copy($_FILES["diploma{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                        //$dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$this -> input -> post("codigo_formacao{$i}"));
                                                                                                }
                                                                                                else{
                                                                                                        $this -> Anexos_model -> delete_anexo($id); 
                                                                                                }
                                                                                                //rename($config['upload_path'].$dados_upload["envio_curriculo{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                                else{
                                                                        $formacao = $this -> Candidaturas_model -> create_formacao($dados_form, $i);
                                                                        $dados_upload["envio_curriculo{$i}"]['formacao'] = $formacao;
                                                                        if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_curriculo{$i}"], '1');
                                                                                if($id > 0){
                                                                                        if(copy($_FILES["diploma{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                //$dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$this -> input -> post("codigo_formacao{$i}"));
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id); 
                                                                                        }
                                                                                        //rename($config['upload_path'].$dados_upload["envio_curriculo{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                                for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                                        if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                                if(strlen($this -> input -> post("codigo_experiencia{$i}"))>0){
                                                                        $this -> Candidaturas_model -> update_experiencia("vc_empresa", $this -> input -> post("empresa{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        $this -> Candidaturas_model -> update_experiencia("dt_inicio", $this -> input -> post("inicio{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        $this -> Candidaturas_model -> update_experiencia("bl_emprego_atual", $this -> input -> post("emprego_atual{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        if(strlen($this -> input -> post("fim{$i}"))>0){
                                                                                $this -> Candidaturas_model -> update_experiencia("dt_fim", $this -> input -> post("fim{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));                                                                                                                                               
                                                                        }
                                                                        else{
                                                                                        $this -> Candidaturas_model -> update_experiencia("dt_fim", null ,$this -> input -> post("codigo_experiencia{$i}"));                                                                                                                                            
                                                                        }
                                                                        
                                                                        $this -> Candidaturas_model -> update_experiencia("tx_atividades", $this -> input -> post("atividades{$i}"),$this -> input -> post("codigo_experiencia{$i}"));
                                                                                                                                        
                                                                                                                                        if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                                                $dados_upload["envio_experiencia{$i}"]['experiencia'] = $this -> input -> post("codigo_experiencia{$i}");
                                                                                if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_experiencia{$i}"], '1');
                                                                                        if($id > 0){
                                                                                                //rename($config['upload_path'].$dados_upload["envio_experiencia{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                                if(copy($_FILES["comprovante{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                        //$dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$this -> input -> post("codigo_experiencia{$i}"));
                                                                                                }
                                                                                                else{
                                                                                                        $this -> Anexos_model -> delete_anexo($id);
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                                else{
                                                                        $experiencia = $this -> Candidaturas_model -> create_experiencia($dados_form, $i);
                                                                                                                                        
                                                                        $dados_upload["envio_experiencia{$i}"]['experiencia'] = $experiencia;
                                                                        if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_experiencia{$i}"], '1');
                                                                                if($id > 0){
                                                                                        if(copy($_FILES["comprovante{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                //$dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$this -> input -> post("codigo_experiencia{$i}"));
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                        //rename($config['upload_path'].$dados_upload["envio_experiencia{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                                
                                                
                                                $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato);
                                                $i=0;
                                                foreach($dados_formacao as $formacao){
                                                        ++$i;
                                                        $dados['en_tipo'][$i]=$formacao->en_tipo;
                                                        $dados['vc_curso'][$i]=$formacao->vc_curso;
                                                        $dados['vc_instituicao'][$i]=$formacao->vc_instituicao;
                                                        $dados['dt_conclusao'][$i]=$formacao->ye_conclusao;
                                                                                                        
                                                        $dados['in_cargahoraria'][$i]=$formacao->in_cargahoraria;
                                                        $dados['pr_formacao'][$i]=$formacao->pr_formacao;
                                                        $dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);

                                                }
                                                $dados['num_formacao']=$i;
                                                $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato);

                                                $i=0;
                                                foreach($dados_experiencia as $experiencia){
                                                        ++$i;
                                                        $dados['vc_empresa'][$i]=$experiencia->vc_empresa;
                                                        $dados['dt_inicio'][$i]=$experiencia->dt_inicio;
                                                        $dados['bl_emprego_atual'][$i]=$experiencia->bl_emprego_atual;                                                
                                                        $dados['dt_fim'][$i]=$experiencia->dt_fim;
                                                                                                        
                                                        $dados['tx_atividades'][$i]=$experiencia->tx_atividades;
                                                        $dados['pr_experienca'][$i]=$experiencia->pr_experienca;
                                                        $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                                }
                                                $dados['num_experiencia']=$i;
                                                
                                                if($this -> input -> post("num_experiencia")<=$dados['num_experiencia']){
                                                        $dados['sucesso'] = 'Dados atualizados com sucesso.';
                                                }
                                                else{
                                                                $dados['sucesso'] = '';
                                                }
                                                $dados['erro'] = '';

                                                $this -> Usuarios_model -> log('sucesso', 'Candidatos/index', 'Candidato '.$this -> session -> candidato.' atualizou seus dados com sucesso.', 'tb_candidatos', $this -> session -> candidato);
                                        /*}
                                        else{
                                                $erro = $this -> db -> error();
                                                $dados['sucesso'] = '';
                                                $dados['erro'] =  'Erro ao salvar seus dados. Os responsáveis já foram avisados.';

                                                $this -> Usuarios_model -> log('erro', 'Candidatos/index', 'Erro na atualização dos seus dados pelo candidato '.$this -> session -> candidato.': '.$erro['message'], 'tb_candidatos', $this -> session -> candidato);
                                        }*/
                                }
                        }
                        /*$dados['Estados'] = $this -> Candidatos_model -> get_Estados();
                        $dados['Municipios'] = 'Selecione o Estado ao lado.';*/
                        $dados += $pagina;
                                                
                        $this->load->view('base', $dados);
                                                
                }
        }

        public function cadastro(){ //página de cadastro do candidato na área pública
                $pagina['menu1']='Candidatos';
                $pagina['menu2']='cadastro';
                $pagina['url']='Candidatos/cadastro';
                $pagina['nome_pagina']='Para começar, faça seu cadastro';
                        $pagina['icone']='fa fa-user';
                        
                session_destroy();
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('email');
                $this -> load -> library('MY_Form_Validation');
                //carrega as funções de validação do /helpers/funcoes_helper.php
                $this -> load -> helper('string');

                $this -> form_validation -> set_rules('NomeCompleto', "'Nome completo'", 'required|min_length[8]');
                $this -> form_validation -> set_rules('CPF', "'CPF'", 'required|verificaCPF|is_unique[tb_usuarios.vc_login]', array('required' => 'O campo \'CPF\' é obrigatório.', 'verificaCPF' => 'O CPF inserido é inválido.', 'is_unique' => 'O CPF inserido já está cadastrado. Recupere sua senha na página inicial.'));
                $this -> form_validation -> set_rules('RG', "'RG'", 'required|is_unique[tb_candidatos.vc_rg]', array('required' => 'O campo \'RG\' é obrigatório.', 'is_unique' => 'O RG inserido já está cadastrado. Recupere sua senha na página inicial.'));
                $this -> form_validation -> set_rules('OrgaoEmissor', "'Órgao Emissor'", 'required');
                $this -> form_validation -> set_rules('IdentidadeGenero', "'Gênero'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Gênero\' é obrigatório.'));
                //$this -> form_validation -> set_rules('IdentidadeGeneroOptativa', "'Gênero optativo'", 'callback_valida_genero_optativo'); //se o de cima estiver == 4
                $this -> form_validation -> set_rules('Raca', "'Raça'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Raça\' é obrigatório.'));
                $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                $this -> form_validation -> set_rules('Telefone', "'Telefone'", 'required|min_length[14]');
                $this -> form_validation -> set_rules('DataNascimento', "'Data de nascimento'", 'required|valida_data', array('required' => 'O campo \'Data de nascimento\' é obrigatório.', 'valida_data' => 'A data de nascimento inserida é inválida.'));
                //$this -> form_validation -> set_rules('Pais2', "'País estrangeiro'", 'callback_valida_cidade_estrangeira');
                //$this -> form_validation -> set_rules('CidadeEstrangeira', "'Cidade estrangeira'", 'callback_valida_cidade_estrangeira');
                $this -> form_validation -> set_rules('CEP', "'CEP'", 'required|min_length[9]');
                $this -> form_validation -> set_rules('Logradouro', "'Logradouro'", 'required');
                $this -> form_validation -> set_rules('Numero', "'Número'", 'required');
                $this -> form_validation -> set_rules('Bairro', "'Bairro'", 'required');
                $this -> form_validation -> set_rules('Estado', "'Estado'", 'required');
                $this -> form_validation -> set_rules('Municipio', "'Município'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Munícipio\' é obrigatório.'));
                $this -> form_validation -> set_rules('TransformaMinas', "'Opção de cadastro'", 'required');
                //if($this->input->post('TransformaMinas') == '1'){
                        $this -> form_validation -> set_rules('Requisitos', "'Pré-requisitos'", 'required');
                        $this -> form_validation -> set_rules('Sentenciado', "'Você está, ou esteve, nos últimos cinco anos, sofrendo efeitos de sentença penal condenatória?'", 'required');
                        $this -> form_validation -> set_rules('ProcessoDisciplinar', "'Você foi condenado em algum processo disciplinar administrativo em órgão integrante da administração pública direta ou indireta, nos cinco anos anteriores à data de publicação desta vaga?'", 'required');
                        $this -> form_validation -> set_rules('AjustamentoFuncionalPorDoenca', "'Você está em ajustamento funcional por motivo de doença que impeça o exercício do cargo para o qual está se candidatando?'", 'required');
                //}
                $this -> form_validation -> set_rules('AceiteTermo', "'Termo de responsabilidade'", 'required');
                $this -> form_validation -> set_rules('AceitePrivacidade', "'Política de privacidade'", 'required');
                
                
                $dados['candidato'] = null;
                
                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  validation_errors();
                        
                        if(strlen($this -> input -> post('CPF'))>0){                                
                                $dados['candidato'] = $this -> Candidatos_model -> get_Candidatos(null,$this -> input -> post('CPF'),true);
                        }
                        
                }
                else{
                        $dados_form = $this -> input -> post(null,true);
						
						$dados_form['Brumadinho'] = NULL;
						
						if($dados_form['TransformaMinas'] == '0'){
								$dados_form['Brumadinho'] = '1';
						}
						
                        if(!isset($dados_form['IdentidadeGeneroOptativa'])){
                                $dados_form['IdentidadeGeneroOptativa'] = NULL;
                        }
						
						if($this->input->post('TransformaMinas') == '0'){
								$dados_form['Requisitos'] = NULL;
								$dados_form['Sentenciado'] = NULL;
								$dados_form['ProcessoDisciplinar'] = NULL;
								$dados_form['AjustamentoFuncionalPorDoenca'] = NULL;
						}
						
						
                        $pr_candidato = $this -> Candidatos_model -> create_candidato($dados_form);
                        if($pr_candidato > 0){
                                if($dados_form['Requisitos'] == '0' || $dados_form['Sentenciado'] == '1' || $dados_form['ProcessoDisciplinar'] == '1' || $dados_form['AjustamentoFuncionalPorDoenca'] == '1'){ //requisitos mínimos
                                        
                                        //****************************
                                        $config['protocol'] = 'smpt';
										$config['smtp_host'] = 'smtpprdo.prodemge.gov.br';
										$config['smtp_port'] = 25;
										$config['smtp_user'] = 'pontodigital';
										$config['smtp_pass'] = 'fXso2ogUbw9PE8Aj';
										$config['charset'] = 'UTF-8';

										$config['wordwrap'] = TRUE;

										$config['mailtype'] = 'html';

										$this->email->initialize($config);
                                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                        $this -> email -> to($dados_form['Email']);
                                        $this -> email -> subject('['.$this -> config -> item('nome').'] Confirmação de cadastro');
                                        //$msg="Olá {$dados_form['NomeCompleto']},\n\nSeu cadastro foi realizado porém, infelizmente, você não cumpre com os requisitos mínimos para concorrer a alguma vaga. Em caso de dúvidas favor entrar em contato pelo fale conosco.";
                                        $msg="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
<meta content=\"width=device-width\" name=\"viewport\"/>
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#304025;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #304025; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Transforma Minas</strong></span></p>
<p style=\"font-size: 20px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #304025;\"><strong>Programa de Gestão de Pessoas por Mérito e Competência</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Cadastro indeferido</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$dados_form['NomeCompleto']}</strong>, sua candidatura foi indeferida por não cumprir com os requisitos para ingresso no serviço público!</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Em caso de dúvidas, <a href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">entre em contato</a> com a equipe do Transforma Minas.</span></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\"/>
<div style=\"font-size:1px;line-height:10px\"> </div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>";
                                        
                                        
                                        $this -> email -> message($msg);
                                        if(!$this -> email -> send()){
                                                $this -> Usuarios_model -> log('erro', 'Candidatos/cadastro', "Erro de envio de confirmação de reprovação dos requisitos mínimos para o e-mail {$dados_form['Email']} do candidato {$pr_candidato}.", 'tb_candidatos', $pr_candidato);
                                        }
                                        //****************************
                                               
                                        $dados['sucesso'] = "Seu cadastro foi realizado porém, infelizmente, você não cumpre com os requisitos mínimos para concorrer a alguma vaga. Em caso de dúvidas favor entrar em contato pelo fale conosco.<br/><br/><a href=\"".base_url()."\">Voltar</a>";
                                        $dados['erro'] =  NULL;
                                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/cadastro', "Candidato {$pr_candidato} criado mas sem pré-requisitos mínimos.", 'tb_candidatos', $pr_candidato);
                                }
                                else{
                                        /*
                                        $this -> db -> select ('pr_usuario, es_candidato');
                                        $this -> db -> from ('tb_usuarios');
                                        $this -> db -> where('vc_login', $dados_form['CPF']);
                                        $query = $this -> db -> get();
                                        if($query -> num_rows() > 0){ //já existe cadastro de usuário para o CPF, tenta associar com o cadastro anterior de usuário
                                                $row = $query->row();
                                                if(strlen($row -> es_candidato) > 0){
                                                        $dados['sucesso'] = '';
                                                        $dados['erro'] =  'Já existe um cadastro de usuário com este CPF associado a um cadastro de candidato.';
                                                }
                                                else{
                                                        $this -> Usuarios_model -> update_usuario('es_candidato', $pr_candidato, $row -> pr_usuario);
                                                        $dados['sucesso'] = "Você já possuía cadastro como usuário e este cadastro foi associado ao seu perfil de candidato. Você pode utilizar sua senha anterior para ter acesso.<br/><br/><a href=\"".base_url()."\">Voltar</a>";
                                                        $dados['erro'] =  NULL;
                                                }
                                        }
                                        else{*/
                                                $senha = random_string ('alnum', 8);
                                                $dados_form['senha'] = $senha;
                                                $dados_form['candidato'] = $pr_candidato;
                                                $dados_form['perfil'] = 'candidato';
                                                //print_r($dados_form);
                                                $pr_usuario = $this -> Usuarios_model -> create_usuario($dados_form);
                                                if($pr_usuario > 0){
                                                        $config['protocol'] = 'smpt';
														$config['smtp_host'] = 'smtpprdo.prodemge.gov.br';
														$config['smtp_port'] = 25;
														$config['smtp_user'] = 'pontodigital';
														$config['smtp_pass'] = 'fXso2ogUbw9PE8Aj';
														$config['charset'] = 'UTF-8';

														$config['wordwrap'] = TRUE;

														$config['mailtype'] = 'html';

														$this->email->initialize($config);
                                                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                        $this -> email -> to($dados_form['Email']);
                                                        $this -> email -> subject('['.$this -> config -> item('nome').'] Confirmação de cadastro');
                                                        //$msg="Olá {$dados_form['NomeCompleto']},\n\nSeu cadastro foi realizado no sistema do ".$this -> config -> item('nome').". Seus dados para acesso são:\n\nUsuário: {$dados_form['CPF']}\nSenha inicial: $senha\n\nAcesse o sistema por meio do link: ".base_url();
                                                        $msg="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
<meta content=\"width=device-width\" name=\"viewport\"/>
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
		
		.botao:hover{
			background-color: #718066 !important;
		}
		
		.aqui:hover{
			color: #DF2935 !important;
		}
		
		
	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
	<!--<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]-->
	<!--<img align=\"center\" alt=\"Image\" border=\"0\" class=\"center autowidth\" src=\"images/logovermelho.jpg\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 123px; display: block;\" title=\"Image\" width=\"123\"/>-->
	<!--[if mso]></td></tr></table><![endif]-->
	<!--</div>-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #555555; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Transforma Minas</strong></span></p>
<p style=\"font-size: 20px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #304025;\"><strong>Programa de Gestão de Pessoas por Mérito e Competência</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"line-height: 1.6; font-size: 12px; color: #555555; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 24px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Login e primeiro acesso:</strong></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$dados_form['NomeCompleto']}</strong>, o seu cadastro foi realizado com sucesso!</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\"> </span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão <em>\"Acessar o sistema\"</em> e insira as informações abaixo:</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\"><em>Login:</em><strong> {$dados_form['CPF']}</strong></span><br/><span style=\"color: #000000;\"><span style=\"font-size: 18px; mso-ansi-font-size: 18px;\">Senha:<strong> {$senha}</strong></span></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Em seu primeiro acesso, altere a sua senha após o login.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"https://www.selecaotransformaminas.mg.gov.br/\" style=\"height:39pt; width:204pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"transparent\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"https://www.selecaotransformaminas.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #304025; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; border-top: 1px solid transparent; border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.6; color: #555555; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 18px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\"/>
<div style=\"font-size:1px;line-height:10px\"> </div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>";
                                                        $this -> email -> message($msg);
                                                        if(!$this -> email -> send()){
                                                                $this -> Usuarios_model -> log('erro', 'Candidatos/cadastro', "Erro de envio de e-mail com senha de cadastro para o e-mail {$dados_form['Email']} do candidato {$pr_candidato}.", 'tb_candidatos', $pr_candidato);
                                                        }
							$dados['sucesso'] = "<div class=\"alert-text\">
<strong><strong>Cadastro realizado com sucesso.</strong> Você vai receber sua senha inicial de acesso por e-mail. Caso não receba, tente recuperar sua senha pela página inicial ou entre em contato pelo fale conosco.<br><br><h5><b>Atenção</b></h5><br>
<strong>Para se candidatar a uma das vagas disponibilizadas no sistema</strong>, faça seu primeiro login e então escolha a vaga de interesse no menu candidaturas. Após a escolha, preencha todas as fases da candidatura e clique no botão concluir para confirmá-la.
<br>
<br><a href=\"".base_url()."\">Voltar</a></strong>
</div>";
                                                        //$dados['sucesso'] = "<strong>Cadastro realizado com sucesso.</strong> Você vai receber sua senha inicial de acesso por e-mail. Caso não receba, tente recuperar sua senha pela página inicial ou entre em contato pelo fale conosco.<br/><br/><a href=\"".base_url()."\">Voltar</a>";
                                                        $dados['erro'] =  NULL;
                                                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/cadastro', "Candidato {$pr_candidato} criado e associado ao usuário {$pr_usuario} criado com sucesso.", 'tb_candidatos', $pr_candidato);
                                                }
                                                else{
                                                        $erro = $this -> db -> error();
                                                        $dados['sucesso'] = '';
                                                        $dados['erro'] =  'Erro no cadastro de usuário. Os responsáveis já foram avisados.';
                                                        $this -> Usuarios_model -> log('erro', 'Candidatos/cadastro', "Erro de usuário para o candidato {$pr_candidato}. Erro: ".$erro['message'], 'tb_candidatos', $pr_candidato);
                                                }
                                        //}
                                }
                        }
                        else{
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro no cadastro de candidato.'.$this -> db -> error()['message'];
                        }
                }
                $dados['Estados'] = $this -> Candidatos_model -> get_Estados();
                $dados['Municipios'] = 'Selecione o Estado ao lado.';
                $dados += $pagina;

                $this -> load -> view('cadastro', $dados);
	}

	public function ListaCandidatos($inativo = 0, $paginacao = 1){
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
                else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');                
                }
                $this -> load -> helper('date');

                $pagina['menu1']='Candidatos';
                $pagina['menu2']='ListaCandidatos';
                $pagina['url']='Candidatos/ListaCandidatos';
                $pagina['nome_pagina']='Lista de candidatos';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados_form = $this -> input -> post(null,true);
                if(!isset($dados_form['cpf'])){
                                $dados_form['cpf'] = '';
                }
                if(!isset($dados_form['nome'])){
                                $dados_form['nome'] = '';
                }
                if(!isset($dados_form['email'])){
                                $dados_form['email'] = '';
                }
                $dados_form['nome'] = addslashes($dados_form['nome']);
                $dados_form['email'] = addslashes($dados_form['email']);
                //$pagina += $dados_form;
                //var_dump($dados_form);
                /*if(strlen($dados_form['cpf']) > 0 || strlen($dados_form['nome']) > 0 || strlen($dados_form['email']) > 0){
                         $paginacao = 0;
                }*/
                                
                $dados['adicionais'] = array('datatables' => true, 'accordion' => true, 'inputmasks' => true);
                if($inativo == 0){ //sem desativados
                        $candidatos = $this -> Candidatos_model -> get_candidatos('', $dados_form['cpf'], false, $dados_form['nome'], $dados_form['email'], $paginacao);
                        //var_dump($candidatos);
                        if(is_array($candidatos)){ //a resposta do Model está diferenciando quando vem só um resultado de quando vem vários
                                if($paginacao > 0){
                                        if(strlen($dados_form['cpf']) > 0 || strlen($dados_form['nome']) > 0 || strlen($dados_form['email']) > 0){
                                                $candidatos2 = $candidatos = $this -> Candidatos_model -> get_candidatos('', $dados_form['cpf'], false, $dados_form['nome'], $dados_form['email']);
                                                //$dados['total'] = db_result("select count(*) from tb_candidatos where bl_removido='0'");
                                                $dados['total'] = count($candidatos2);
                                                
                                        }
                                        else{
                                                $dados['total'] = db_result("select count(*) from tb_candidatos where bl_removido='0'");
                                        }
                                        
                                }
                                else{
                                        $dados['total'] = count($candidatos);
                                }
                                $dados['candidatos'] = $candidatos;
                        }
                        else{ //gambiarra para corrigir a diferença de resposta do Model
                                if(isset($candidatos -> pr_candidato)){                                                                 
                                        $dados['total'] = 1;
                                        $dados['candidatos'][0] = $candidatos;
                                        $dados['candidatos'][0] -> cont = db_result("select count(*) from tb_candidaturas where es_candidato={$candidatos -> pr_candidato}");
                                }
                                else{
                                        $dados['total'] = 0;
                                }
                        }
                }
                else{                        
                        $candidatos = $this -> Candidatos_model -> get_candidatos('', $dados_form['cpf'], true, $dados_form['nome'], $dados_form['email'], $paginacao);
                        //var_dump($candidatos);
                        if(is_array($candidatos)){ //a resposta do Model está diferenciando quando vem só um resultado de quando vem vários
                                if($paginacao > 0){
                                                if(strlen($dados_form['cpf']) > 0 || strlen($dados_form['nome']) > 0 || strlen($dados_form['email']) > 0){
                                                        //$dados['total'] = db_result("select count(*) from tb_candidatos");
                                                        $candidatos2 = $this -> Candidatos_model -> get_candidatos('', $dados_form['cpf'], true, $dados_form['nome'], $dados_form['email']);
                                                        $dados['total'] = count($candidatos2);
                                                }
                                                else{
                                                        

                                                        $dados['total'] = db_result("select count(*) from tb_candidatos");
                                                }
                                                
                                }
                                else{
                                                $dados['total'] = count($candidatos);
                                }
                                $dados['candidatos'] = $candidatos;
                        }
                        else{ //gambiarra para corrigir a diferença de resposta do Model
                                if(isset($candidatos -> pr_candidato)){                                                                 
                                                $dados['total'] = 1;
                                                $dados['candidatos'][0] = $candidatos;
                                                $dados['candidatos'][0] -> cont = db_result("select count(*) from tb_candidaturas where es_candidato={$candidatos -> pr_candidato}");
                                }
                                else{
                                                $dados['total'] = 0;
                                }
                        }
                }              

                                //echo "inativo: $inativo, paginacao: $paginacao<br>";

                $dados['inativo'] = $inativo;
                $dados['paginacao'] = $paginacao;
                                $dados['total_paginas'] = ceil($dados['total']/30);
                $this -> load -> view('candidatos', $dados);
        }

	public function view(){
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Candidaturas_model');

                $pagina['menu1']='Candidatos';
                $pagina['menu2']='view';
                $pagina['url']='Candidatos/view';
                $pagina['nome_pagina']='Dados de candidato';
                $pagina['icone']='fa fa-user';

                $candidato = $this -> uri -> segment(3);
                $dados_candidato = $this -> Candidatos_model -> get_candidatos($candidato);
                $dados = (array) $dados_candidato;
                $dados += $pagina;

                $dados['municipio'] = $this -> Candidatos_model -> get_Municipios($dados_candidato -> es_municipio);
                $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', $dados_candidato -> pr_candidato);

                $dados['sucesso'] = '';
                $dados['erro'] = '';

                $this -> load -> view('candidatos', $dados);
        }
	public function novaSenha(){
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('email');
                $this -> load -> library('encryption');
                $this -> load -> helper('string');

                $pagina['menu1']='Candidatos';
                $pagina['menu2']='novaSenha';
                $pagina['url']='Candidatos/novaSenha';
                $pagina['nome_pagina']='Nova senha';
                $pagina['icone']='fa fa-user';

                $dados=$pagina;
                $candidato = $this -> uri -> segment(3);
                $dados_candidato = $this -> Candidatos_model -> get_candidatos($candidato);
                $usuario = $dados_candidato -> pr_usuario;
                $dados['usuario'] = $this -> Usuarios_model -> get_usuarios($usuario);
                if($dados['usuario'] -> pr_usuario > 0){
                        $senha = random_string ('alnum', 8);
						//$senha = "transforma";
                        $password = $this -> encryption -> encrypt($senha);
                        $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $usuario);
						$this -> Usuarios_model -> update_usuario('in_erros', '0', $usuario);
						$this -> Usuarios_model -> update_usuario('bl_trocasenha', '1', $usuario);
						$config['protocol'] = 'smpt';
						$config['smtp_host'] = 'smtpprdo.prodemge.gov.br';
						$config['smtp_port'] = 25;
						$config['smtp_user'] = 'pontodigital';
						$config['smtp_pass'] = 'fXso2ogUbw9PE8Aj';
						$config['charset'] = 'UTF-8';

						$config['wordwrap'] = TRUE;

						$config['mailtype'] = 'html';

						$this->email->initialize($config);
						
                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                        $this -> email -> to($dados['usuario'] -> vc_email);
                        $this -> email -> subject('['.$this -> config -> item('nome').'] Nova senha');
                        //$msg='Olá '.$dados['usuario'] -> vc_nome.',<br/><br/>Foi solicitada uma nova senha do sistema do programa '.$this -> config -> item('nome').'. Seus dados para acesso são:<br/><br/>Usuário: '.$dados['usuario'] -> vc_login."<br/>Senha inicial: $senha<br/><br/>Se não foi você que solicitou essa recuperação de senha, não se preocupe pois sua senha antiga ainda funciona.<br/><br/>Acesse o sistema por meio do link: ".base_url();
                        $msg="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
<meta content=\"width=device-width\" name=\"viewport\"/>
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
		
			.botao:hover{
			background-color: #718066 !important;
		}
		
		.aqui:hover{
			color: #DF2935 !important;
		}
	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#304025;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #304025; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Transforma Minas</strong></span></p>
<p style=\"font-size: 20px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #304025;\"><strong>Programa de Gestão de Pessoas por Mérito e Competência</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Alteração de senha</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$dados['usuario'] -> vc_nome}</strong>, foi solicitada uma nova senha para acesso ao sistema do Transforma Minas!</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Seus dados para acesso são:</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><strong><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Usuário: {$dados['usuario'] -> vc_login}</span></span></strong></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><strong><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Senha: {$senha}</span></span></strong></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Dúvidas sobre as etapas do processo de seleção do Transforma Minas?<br/>Clique <a class=\"aqui\" href=\"https://www.mg.gov.br/conteudo/transforma-minas/etapas-do-processo\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Etapas Transforma Minas\">aqui</a>.</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão abaixo:</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"https://www.selecaotransformaminas.mg.gov.br/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#304025\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"https://www.selecaotransformaminas.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #304025; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #304025; border-right: 1px solid #304025; border-bottom: 1px solid #304025; border-left: 1px solid #304025; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.8; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"https://www.mg.gov.br/transforma-minas/fale-conosco\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\"/>
<div style=\"font-size:1px;line-height:10px\"> </div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>";
						$this -> email -> message($msg);
                        if(!$this -> email -> send()){
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro no envio do e-mail com a nova senha. Os responsáveis já foram avisados.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                                $this -> Usuarios_model -> log('erro', 'Candidatos/novaSenha', 'Erro de envio de e-mail com senha de cadastro para o e-mail '.$dados['usuario'] -> vc_email.' do usuário '.$dados['usuario'] -> pr_usuario, 'tb_usuarios', $usuario);
                        }
                        else{
								if($this -> session -> perfil == 'administrador'){
										$dados['sucesso'] = 'Nova senha enviada com sucesso.A nova senha é:<br/><br/><b>'.$senha.'</b><br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
								}
								else{
										$dados['sucesso'] = 'Nova senha enviada com sucesso.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
								}
                                //$dados['sucesso'] = 'Nova senha enviada com sucesso. A nova senha é '.$senha.'<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] =  NULL;
                                $this -> Usuarios_model -> log('sucesso', 'Candidatos/novaSenha', "Nova senha para Usuário {$usuario} enviada com sucesso.", 'tb_usuarios', $usuario);
                        }
                }
                else{
                        $erro = $this -> db -> error();
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                        $this -> Usuarios_model -> log('erro', 'Candidatos/novaSenha', "Erro na recuperação dos dados do usuário {$usuario}. Erro: ".$erro['message']);
                }

                $this -> load -> view('candidatos', $dados);
        }
	public function delete(){
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('email');
                $this -> load -> helper('string');

                $pagina['menu1']='Candidatos';
                $pagina['menu2']='delete';
                $pagina['url']='Candidatos/delete';
                $pagina['nome_pagina']='Desativar candidato';
                $pagina['icone']='fa fa-user';

                $dados=$pagina;
                $candidato = $this -> uri -> segment(3);
                $dados_candidato = $this -> Candidatos_model -> get_candidatos($candidato);
                $usuario = $dados_candidato -> pr_usuario;
                $dados_usuario = $this -> Usuarios_model -> get_usuarios ($usuario);
                $dados += (array) $dados_usuario;
                //var_dump($usuario);
                //var_dump($dados_usuario);

                if($usuario == $this -> session -> uid){
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Você não pode desativar seu próprio acesso por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                        $this -> Usuarios_model -> log('seguranca', 'Candidatos/delete', "Usuário {$usuario} tentou se desativar.", 'tb_usuarios', $usuario);
                }
                else{
                        $dados_candidato2['codigo'] = $dados_candidato -> pr_candidato;
                        $dados_candidato2['bl_removido'] = '1';

                        $this -> Candidatos_model -> update_candidato($dados_candidato2);
                        $this -> Usuarios_model -> update_usuario('bl_removido', '1', $usuario);
                        $this -> Usuarios_model -> update_usuario('vc_senha', null, $usuario);
                        $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', null, $usuario);
                        $dados['sucesso'] = 'O usuário \''.$dados_usuario -> vc_nome.'\' foi desativado com sucesso.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                        $dados['erro'] = '';
                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/delete', "Usuário {$usuario} desativado pelo usuário ".$this -> session -> uid, 'tb_usuarios', $usuario);
                }
                $this -> load -> view('candidatos', $dados);
        }
	public function reactivate(){
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('email');
                $this -> load -> helper('string');
                $this -> load -> library('encryption');

                $pagina['menu1']='Candidatos';
                $pagina['menu2']='reactivate';
                $pagina['url']='Candidatos/reactivate';
                $pagina['nome_pagina']='Reativar conta';
                $pagina['icone']='fa fa-user';

                $dados=$pagina;
                $candidato = $this -> uri -> segment(3);
                $dados_candidato = $this -> Candidatos_model -> get_candidatos($candidato);
                $usuario = $dados_candidato -> pr_usuario;
                $dados['usuario'] = $this -> Usuarios_model -> get_usuarios($usuario);
                if($dados['usuario'] -> pr_usuario > 0){
                        $dados_candidato2['codigo'] = $dados_candidato -> pr_candidato;
                        $dados_candidato2['bl_removido'] = '0';
                        $this -> Candidatos_model -> update_candidato($dados_candidato2);

                        $senha = random_string ('alnum', 8);
                        $password = $this -> encryption -> encrypt($senha);
                        $this -> Usuarios_model -> update_usuario('bl_removido', '0', $usuario);
                        $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $usuario);
                        $this -> Usuarios_model -> update_usuario('dt_alteracao', date('Y-m-d H:i:s'), $usuario);
						
						$config['protocol'] = 'smpt';
						$config['smtp_host'] = 'smtpprdo.prodemge.gov.br';
						$config['smtp_port'] = 25;
						$config['smtp_user'] = 'pontodigital';
						$config['smtp_pass'] = 'fXso2ogUbw9PE8Aj';
						$config['charset'] = 'UTF-8';

						$config['wordwrap'] = TRUE;

						$config['mailtype'] = 'html';

						$this->email->initialize($config);
						
                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                        $this -> email -> to($dados['usuario'] -> vc_email);
                        $this -> email -> subject('['.$this -> config -> item('nome').'] Nova senha');
                        $msg='Olá '.$dados['usuario'] -> vc_nome.',<br/><br/>Foi solicitada uma nova senha do sistema do programa '.$this -> config -> item('nome').'. Seus dados para acesso são:<br/><br/>Usuário: '.$dados['usuario'] -> vc_login."<br/>Senha inicial: $senha<br/><br/>Se não foi você que solicitou essa recuperação de senha, não se preocupe pois sua senha antiga ainda funciona.<br/><br/>Acesse o sistema por meio do link: ".base_url();
                        $this -> email -> message($msg);
                        if(!$this -> email -> send()){
                                $this -> Usuarios_model -> log('erro', 'Candidatos/reactivate', 'Erro de envio de e-mail com senha de cadastro para o e-mail '.$dados['usuario'] -> vc_email.' do usuário '.$dados['usuario'] -> pr_usuario, 'tb_usuarios', $usuario);
                        }
                        else{
                                $this -> Usuarios_model -> log('sucesso', 'Candidatos/reactivate', "Nova senha para Usuário {$usuario} enviada com sucesso.", 'tb_usuarios', $usuario);
                        }
                        $dados['sucesso'] = 'Usuário reativado com sucesso.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                        $dados['erro'] =  NULL;
                }
                else{
                        $erro = $this -> db -> error();
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.<br/><br/><a href="'.base_url('Candidatos/ListaCandidatos').'" class="btn btn-light">Voltar</a>';
                        $this -> Usuarios_model -> log('erro', 'Candidatos/reactivate', "Erro na recuperação dos dados do usuário {$usuario}. Erro: ".$erro['message']);
                }

                $this -> load -> view('candidatos', $dados);
        }
        public function fetch_Municipios(){ //função de preenchimento da combo da view de cadastro
                $this -> load -> model('Candidatos_model');
                if($this -> input -> post ('estado')){
                        $output = $this -> Candidatos_model -> get_Municipios ('', $this -> input -> post ('estado'));
                        echo '<option value=""></option>';
                        foreach($output as $row)
                        {
                                echo '<option value="'.$row['pr_municipio'].'">'.$row['vc_municipio'].'</option>';
                        }
                }
        }
        public function valida_genero_optativo(){ //callback de validação customizada do formulário de cadsatro
                $genero = $this -> input -> post('IdentidadeGenero');
                $optativo = $this -> input -> post('IdentidadeGeneroOptativa');
                if ($genero == 4 && strlen($optativo)==0){
                        $this -> form_validation -> set_message('valida_genero_optativo', "O campo 'Gênero optativo' deve ser preenchido se a opção de gênero for 'Desejo Informar'.");
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        public function valida_cidade_estrangeira(){ //callback de validação customizada do formulário de cadsatro
                $Nacionalidade = $this -> input -> post('Nacionalidade');
                $Pais2 = $this -> input -> post('Pais2');
                $CidadeEstrangeira = $this -> input -> post('CidadeEstrangeira');
                if ($Nacionalidade != 'Brasil' && (strlen($Pais2)==0 || strlen($CidadeEstrangeira)==0)){
                        $this -> form_validation -> set_message('valida_cidade_estrangeira', "Os campos de 'País estrangeiro' e 'Cidade estrangeira' devem ser preenchidos se a opção de país for diferente de 'Brasil'.");
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        
        public function delete_formacao($id){
            $this -> load -> model('Anexos_model');
            $this -> Anexos_model -> delete_anexo('','',$id,'');
            $this -> Candidaturas_model -> delete_formacao($id);
        }
        
        public function delete_experiencia($id){
            $this -> load -> model('Anexos_model');
            $this -> Anexos_model -> delete_anexo('','','','', $id);
            $this -> Candidaturas_model -> delete_experiencia($id);
        }
        
        
        public function recuperar($cpf){
                $candidato = $this -> Candidatos_model -> get_Candidatos(null,$cpf,true);
                
                if($candidato->in_exigenciasComuns == '0' || $candidato->bl_sentenciado == '1' || $candidato->bl_processoDisciplinar == '1' || $candidato->bl_ajustamentoFuncionalPorDoenca == '1'){
                        $this -> Candidatos_model -> delete_candidato($cpf);
                        echo "<script type=\"text/javascript\">alert('Usuário recuperado para inserção');window.location='/Candidatos/cadastro';</script>";
                        
                }
                else{
                        echo "<script type=\"text/javascript\">alert('Esse CPF já está inserido. Clique em Recuperar a Senha');window.location='/Candidatos/cadastro';</script>";
                }
                //redirect('Candidatos/cadastro/');
        }
}
