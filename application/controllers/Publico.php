<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//páginas públicas
class Publico extends CI_Controller {
        function __construct() {
                parent::__construct();
                if($this -> session -> logado){
                        redirect('Interna');
                }
                $this -> load -> helper('form');
                $this -> load -> library('form_validation');
                $this -> load -> model('Usuarios_model');
        }
        public function test(){
                $this->load->helper('emails');
                // echo loadTestHtml();
                echo loadReagendamentoDeEntrevistaHtml(
                        $this->config->item('nome'),
                        $this->config->item('subTituloPlataforma'),
                        1,
                        'Fulanor',
                        '22/22/22',
                        '10:10:10',
                        'competencia',
                        'Porteiro',
                        'www.google.com'
                );
              }
	public function index(){ //login
                $pagina['menu1']='Publico';
                $pagina['menu2']='index';
                $pagina['url']='Publico/index';
                $pagina['nome_pagina']='Entre no sistema';
                
                /*$this -> load -> library('encryption');
                $password = $this -> encryption -> encrypt('teste123');
                $this -> Usuarios_model -> update_usuario('vc_senha', $password, 2610);*/
                
                $this -> form_validation -> set_rules('cpf', "'CPF'", 'trim|required|verificaCPF', array('required' => 'O campo \'CPF\' é obrigatório.', 'verificaCPF' => 'O CPF inserido é inválido.'));
                $this -> form_validation -> set_rules('senha', "'Senha'", 'trim|required|min_length[8]');
                
                if ($this->form_validation->run() == FALSE){ //validações de preenchimento
                        $dados['erro']= validation_errors();
                }
                else{
                        $dados['erro']= NULL;
                        $dados_form = $this -> input -> post(null,true);
                        $row = $this -> Usuarios_model -> login($dados_form['cpf'], $dados_form['senha']); //fazer login
                        if(is_object($row) && $row -> pr_usuario > 0 && strlen($this -> session -> erro)==0){ //sem erro
                                $this -> session -> set_userdata('uid', $row -> pr_usuario);
                                $this -> session -> set_userdata('perfil', $row -> en_perfil);
                                $this -> session -> set_userdata('candidato', $row -> es_candidato);
                                
                                if(strlen($row -> es_candidato) > 0){
                                        $this -> load -> model('Candidatos_model');
                                        $candidatos = $this -> Candidatos_model -> get_candidatos($row -> es_candidato);
                                        $this -> session -> set_userdata('brumadinho', $candidatos -> bl_brumadinho);
                                }
                                else{
                                        $this -> session -> set_userdata('brumadinho', '');
                                }
								
                                $this -> session -> set_userdata('nome', $row -> vc_nome);
                                $this -> session -> set_userdata('trocasenha', $row -> bl_trocasenha);
                                $this -> session -> set_userdata('logado', true);
                                $this -> session -> set_userdata('erro', '');                                

                                $this -> Usuarios_model -> log('sucesso', 'Publico', 'Usuário '.$row -> pr_usuario.' logado com sucesso.', 'tb_usuarios', $row -> pr_usuario);
                                /*
                                if($row -> pr_usuario == 2610){
                                        $this -> session -> set_userdata('uid', 3444);
                                        $this -> session -> set_userdata('perfil', 'candidato');
                                        $this -> session -> set_userdata('candidato', 3535);
                                        $this -> session -> set_userdata('nome', 'Fernando Pereira Rodrigues');
                                        $this -> session -> set_userdata('brumadinho', '1');
                                }*/

                                $this -> Usuarios_model -> update_usuario('dt_ultimoacesso', date('Y-m-d H:i:s'), $row -> pr_usuario);
                                $this -> db -> set ('es_usuario', $row -> pr_usuario);
                                $this -> db -> where('id', session_id());
                                $this -> db -> update ('tb_sessoes');

                                redirect('Interna');
                        }
                        else{ //exibe erro na página inicial
                                $dados['erro']= $this -> session -> erro;
                                $this -> Usuarios_model -> log('advertencia', 'Publico', 'Login sem sucesso para CPF '.$dados_form['cpf']);
                                $this -> session -> set_userdata('erro', '');
                        }
                }
                $dados['sucesso']='';
                $dados += $pagina;
                
                $this -> load -> view('home', $dados);
	}
	public function recuperar(){ //recuperar senha
                $pagina['menu1']='Publico';
                $pagina['menu2']='recuperar';
                $pagina['url']='Publico/recuperar';
                $pagina['nome_pagina']='Recuperar senha';
                
                $this -> load -> model('Candidatos_model');
                $this -> load -> library('email');
                $this -> load -> library('encryption');
                $this -> load -> helper('string');

                $this -> form_validation -> set_rules('cpf', 'CPF', 'required|verificaCPF', array('required' => 'Você deve inserir seu CPF.', 'verificaCPF' => 'O CPF inserido é inválido.'));

                if ($this->form_validation->run() == FALSE){
                        $dados['sucesso']='';
                        $dados['erro']= validation_errors();
                }
                else{
                        $dados_form = $this -> input -> post(null,true);
                        $row = $this -> Usuarios_model -> get_usuarios('', $dados_form['cpf']);
                        $row2 = $this -> Candidatos_model -> get_candidatos('', $dados_form['cpf']);

                        if(is_array($row) && sizeof($row) > 0) {
                                $row = $row[0];
                        }
                        if(is_array($row2) && sizeof($row2) > 0) {
                                $row2 = $row2[0];
                        }

                        if(strlen($row -> vc_email) > 0){
                                $senha = random_string ('alnum', 8);
                                $password = $this -> encryption -> encrypt($senha);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $row -> pr_usuario);

                                // TODO PENCIL: Remover antes do merge
                                $this->load->helper('emails');
                                $config = getEmailEnvConfigs();

                                $this->email->initialize($config);
                                
                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                $this -> email -> to($row -> vc_email);
                                $this -> email -> subject('['.$this -> config -> item('nome').'] Recuperação de senha');
                                //$msg='Olá '.$row -> vc_nome.',\n\nFoi solicitada a recuperação de senha do sistema do programa '.$this -> config -> item('nome').'. Seus dados para acesso são:\n\nUsuário: '.$row -> vc_login."\nSenha inicial: $senha\n\nSe não foi você que solicitou essa recuperação de senha, não se preocupe pois sua senha antiga ainda funciona.\n\nAcesse o sistema por meio do link: ".base_url();

                                $msg=loadAlteracaoDeSenhaHtml(
                                        $this -> config -> item('tituloPlataforma'),
                                        $this -> config -> item('subTituloPlataforma'),
                                        $row -> vc_nome,
                                        $row -> vc_login,
                                        $senha
                                );

                                $this -> email -> message($msg);
                                if(!$this -> email -> send()){
                                        //log
                                        $dados['sucesso']='';
                                        $dados['erro']= 'Erro no envio da mensagem. Os responsáveis já foram avisados.';
                                        $this -> Usuarios_model -> log('erro', 'Publico/recuperar', 'Erro no envio de e-mail de recuperação de senha para '.$row -> vc_email);
                                }
                                else{
                                        $dados['sucesso']='Senha recuperada com sucesso. Favor verificar seu e-mail.';
                                        $dados['erro']= '';
                                        $this -> Usuarios_model -> log('sucesso', 'Publico/recuperar', 'Sucesso no envio de e-mail de recuperação de senha para '.$row -> vc_email);
                                }
                        }
                        else if(strlen($row2 -> pr_candidato) > 0){
                                $dados['sucesso']='';
                                $dados['erro']= 'Seu cadastro de candidato foi encontrado mas você não cumpriu com os requisitos mínimos. Em caso de dúvidas, favor entrar em contato pelo fale conosco.';
                        }
                        else{
                                $dados['sucesso']='';
                                $dados['erro']= 'Não foi encontrado cadastro com esse CPF!';
                        }

                }
                $dados += $pagina;
                
                $this -> load -> view('home', $dados);
	}
	public function contato(){ //fale conosco
                $pagina['menu1']='Publico';
                $pagina['menu2']='contato';
                $pagina['url']='Publico/contato';
                $pagina['nome_pagina']='Fale conosco';
                
                $this -> load -> library('email');

                $this -> form_validation -> set_rules('nome', "'Nome completo'", 'required|min_length[10]|max_length[100]');
                $this -> form_validation -> set_rules('email', "'E-mail'", 'required|valid_email');
                $this -> form_validation -> set_rules('assunto', "'Assunto'", 'required|max_length[100]');
                $this -> form_validation -> set_rules('msg', "'Mensagem'", 'required|min_length[10]|max_length[4000]');

                if ($this->form_validation->run() == FALSE){
                        $dados['sucesso']='';
                        $dados['erro']= validation_errors();
                }
                else{
                        $this->load->helper('emails');
                        $config = getEmailEnvConfigs();

                        $this->email->initialize($config);

                        $dados_form = $this -> input -> post(null,true);
                        $this -> email -> from($dados_form['email'], $dados_form['nome']);
                        $this -> email -> to($this -> config -> item('email'));
                        $this -> email -> subject('['.$this -> config -> item('nome').'] Fale conosco: '.$dados_form['assunto']);
                        $this -> email -> message($dados_form['msg']);

                        if($this -> email -> send()){
                                $dados['sucesso']='Mensagem enviada com sucesso.';
                                $dados['erro']= '';
                        }
                        else{
                                $dados['sucesso']='';
                                $dados['erro']= 'Erro no envio da mensagem.';
                        }
                }
                $dados += $pagina;
                
                $this -> load -> view('home', $dados);
	}
		
		function download_termo($termo){
				$termos = array('responsabilidade'=>'responsabilidade.pdf','privacidade'=>'privacidade.pdf');
				if(isset($termos[$termo])){
						$arq='./termos/'.$termos[$termo];
						$fp = fopen($arq, 'rb');
						$tamanho=filesize($arq);

						$content = fread($fp, $tamanho);

						fclose($fp);

						if(strlen($content)>0){
							header("Content-length: {$tamanho}");
							header('Content-type: '.$dados['anexo'][0] -> vc_mime);
							header('Content-Disposition: attachment; filename='.$dados['anexo'][0] -> vc_arquivo);

							//$content = addslashes($content);
							echo $content;
						}
						else{
							log_site(1, 'Download', 'Erro no download do arquivo '.$dados['anexo'][0] -> pr_anexo, '', '');
										$this -> Usuarios_model -> log('erro', 'Interna/download', 'Erro no download do arquivo '.$dados['anexo'][0] -> pr_anexo, 'tb_anexos', $dados['anexo'][0] -> pr_anexo);
							echo "<script type=\"text/javascript\">alert('Erro no download do arquivo. O arquivo está corrompido.');</script>";
							//echo "<script type=\"text/javascript\">window.location=\"/home_js\";</script>";
							echo "<noscript>Erro no download do arquivo. O arquivo está corrompido.<br /><a href=\"/home\">Voltar</a></noscript>";
						}
				}
		}
}
