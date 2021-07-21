<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
        function __construct() {
                parent::__construct();
                $this -> load -> model('Usuarios_model');
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
        }
	public function index($inativo = 0)	{
                $this -> load -> helper('date');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='index';
                $pagina['url']='Usuarios/index';
                $pagina['nome_pagina']='Usuários';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['adicionais'] = array('datatables' => true,'sweetalert' => true);
                
                
                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/index', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                if($inativo == 0){
                		$dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('','','','',true);
                }
                else{
                		$dados['usuarios'] = $this -> Usuarios_model -> get_usuarios();
                }
                $dados['inativo'] = $inativo;
                $this -> load -> view('usuarios', $dados);
        }
        
	public function create(){
                $this -> load -> library('email');
				
				
                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='create';
                $pagina['url']='Usuarios/create';
                $pagina['nome_pagina']='Novo usuário';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                //$dados += $this -> input -> post(null,true);

                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/create', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('NomeCompleto', "'Nome completo'", 'required|min_length[8]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome completo\'.'));
                        $this -> form_validation -> set_rules('CPF', "'CPF'", 'required|verificaCPF|is_unique[tb_usuarios.vc_login]', array('required' => 'O campo \'CPF\' é obrigatório.', 'verificaCPF' => 'O CPF inserido é inválido.', 'is_unique' => 'O CPF inserido já está cadastrado.'));
                        $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                        $this -> form_validation -> set_rules('perfil', "'Perfil'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                //var_dump($this -> input -> post(null,true));
                                $senha = random_string ('alnum', 8);
                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['senha'] = $senha;
                                $dados_form['candidato'] = null;
                                $dados_form['Telefone'] = null;
                                $usuario = $this -> Usuarios_model -> create_usuario($dados_form);
                                if($usuario > 0){
										// $config['smtp_host'] = 'smtpprdo.prodemge.gov.br';
										// $config['smtp_port'] = 25;
										// $config['smtp_user'] = 'pontodigital';
										// $config['smtp_pass'] = 'fXso2ogUbw9PE8Aj';

                                                                                $this->load->helper('emails');
                                                                                $config = getEmailEnvConfigs();

										$this->email->initialize($config);
									
                                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                        $this -> email -> to($dados_form['Email']);
                                        $this -> email -> subject('['.$this -> config -> item('nome').'] Confirmação de cadastro');
                                        //$msg="Olá {$dados_form['NomeCompleto']},\n\nSeu cadastro foi realizado no sistema do ".$this -> config -> item('nome').". Seus dados para acesso são:\n\nUsuário: {$dados_form['CPF']}\nSenha inicial: $senha\n\nAcesse o sistema por meio do link: ".base_url();
                                        $this->load->helper('emails');
                                        $msg = loadCadastroHtml($this -> config -> item('nome'), $this -> config -> item('subTituloPlataforma'), $dados_form['NomeCompleto'], $senha, $dados_form['CPF']);

                                        $this -> email -> message($msg);
                                        if(!$this -> email -> send()){
                                                $this -> Usuarios_model -> log('erro', 'Usuarios/create', "Erro de envio de e-mail com senha de cadastro para o e-mail {$dados_form['Email']} do usuário {$usuario}.", 'tb_usuarios', $usuario);
                                        }

                                        $dados['sucesso'] = 'Cadastro realizado com sucesso. Você vai receber sua senha inicial de acesso por e-mail. Caso não receba, tente recuperar sua senha pela página inicial ou entre em contato pelo fale conosco.<br/><br/><a href="'.base_url('Usuarios/index').'" class="btn btn-light">Voltar</a>';
                                        $dados['erro'] =  NULL;
                                        $this -> Usuarios_model -> log('sucesso', 'Usuarios/create', "Usuário {$usuario} criado com sucesso.", 'tb_usuarios', $usuario);
                                }
                                else{
                                        $erro = $this -> db -> error();
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  'Erro no cadastro de usuário. Os responsáveis já foram avisados.<br/><br/><a href="'.base_url('Usuarios/index').'" class="btn btn-light">Voltar</a>';
                                        $this -> Usuarios_model -> log('erro', 'Usuarios/create', 'Erro de criação de usuário. Erro: '.$erro['message']);
                                }
                        }
                }
                $this -> load -> view('usuarios', $dados);
        }
        
	public function edit(){
                $this -> load -> library('email');
                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='edit';
                $pagina['url']='Usuarios/edit';
                $pagina['nome_pagina']='Editar usuário';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                $usuario = $this -> uri -> segment(3);
                $dados_usuario = $this -> Usuarios_model -> get_usuarios ($usuario);
                $dados['codigo'] = $usuario;
                $dados += (array) $dados_usuario;
                //var_dump($usuario);
                //var_dump($dados_usuario);
                $dados_form = $this -> input -> post(null,true);
                //var_dump($dados_form);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $usuario = $dados_form['codigo'];
                }

                if($usuario == $this -> session -> uid){
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Você não pode atualizar seus próprios dados por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/edit', "Usuário {$usuario} tentou atualizar seus próprios dados.", 'tb_usuarios', $usuario);
                }
                else if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/edit', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('NomeCompleto', "'Nome completo'", 'required|min_length[8]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome completo\'.'));
                        $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                        $this -> form_validation -> set_rules('perfil', "'Perfil'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                //var_dump($this -> input -> post(null,true));

                                $this -> Usuarios_model -> update_usuario('vc_nome',$dados_form['NomeCompleto'], $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_email', $dados_form['Email'], $usuario);
                                $this -> Usuarios_model -> update_usuario('en_perfil', $dados_form['perfil'], $usuario);
                                $this -> Usuarios_model -> update_usuario('dt_alteracao', date('Y-m-d H:i:s'), $usuario);

                                $this -> Usuarios_model -> log('sucesso', 'Usuarios/edit', "Usuário {$usuario} editado com sucesso pelo usuário ".$this -> session -> uid, 'tb_usuarios', $usuario);

                                $dados['sucesso'] = 'Usuário editado com sucesso.<br/><br/><a href="'.base_url('Usuarios/index').'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] = '';
                        }
                }
                $this -> load -> view('usuarios', $dados);
        }
        
	public function novaSenha(){
                $this -> load -> library('email');
                $this -> load -> helper('string');
                $this -> load -> library('encryption');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='novaSenha';
                $pagina['url']='Usuarios/novaSenha';
                $pagina['nome_pagina']='Nova senha';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                
                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/novaSenha', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                        echo "<script type=\"text/javascript\">alert('Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                }
                else{
                        $usuario = $this -> uri -> segment(3);
                        $dados['usuario'] = $this -> Usuarios_model -> get_usuarios($usuario);

                        if(is_array($dados['usuario']) && count($dados['usuario']) > 0) {
                                $dados['usuario'] = $dados['usuario'][0];
                        }

                        if($dados['usuario'] -> pr_usuario > 0){
                                $senha = random_string ('alnum', 8);
                                //$senha = "transforma";
                                $password = $this -> encryption -> encrypt($senha);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $usuario);
                                $this -> Usuarios_model -> update_usuario('in_erros', '0', $usuario);
                                // $config['smtp_host'] = 'smtpprdo.prodemge.gov.br';
                                // $config['smtp_port'] = 25;
                                // $config['smtp_user'] = 'pontodigital';
                                // $config['smtp_pass'] = 'fXso2ogUbw9PE8Aj';

                                $this->load->helper('emails');
                                $config = getEmailEnvConfigs();

                                $this->email->initialize($config);
                                
                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                $this -> email -> to($dados['usuario'] -> vc_email);
                                $this -> email -> subject('['.$this -> config -> item('nome').'] Nova senha');
                                
                                //$msg='Olá '.$dados['usuario'] -> vc_nome.',\n\nFoi solicitada uma nova senha do sistema do programa '.$this -> config -> item('nome').'. Seus dados para acesso são:\n\nUsuário: '.$dados['usuario'] -> vc_login."\nSenha inicial: $senha\n\nSe não foi você que solicitou essa recuperação de senha, não se preocupe pois sua senha antiga ainda funciona.\n\nAcesse o sistema por meio do link: ".base_url();
                                $msg= loadAlteracaoDeSenhaHtml(
                                        $this -> config -> item('nome'),
                                        $this -> config -> item('subTituloPlataforma'),
                                        $dados['usuario'] -> vc_nome,
                                        $dados['usuario'] -> vc_login,
                                        $senha
                                );

                                $this -> email -> message($msg);
                                if(!$this -> email -> send()){
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  'Erro no envio do e-mail com a nova senha. Os responsáveis já foram avisados.';
                                        $this -> Usuarios_model -> log('erro', 'Usuarios/novaSenha', 'Erro de envio de e-mail com senha de cadastro para o e-mail '.$dados['usuario'] -> vc_email.' do usuário '.$dados['usuario'] -> pr_usuario.' feita pelo usuário '.$this -> session -> uid, 'tb_usuarios', $usuario);
                                        echo "<script type=\"text/javascript\">alert('Erro no envio do e-mail com a nova senha. Os responsáveis já foram avisados.');window.location='".base_url('Usuarios/index')."';</script>";
                                }
                                else{
                                        $dados['sucesso'] = 'Nova senha enviada com sucesso. A nova senha é '.$senha.'.<br/><br/><a href="'.base_url('Usuarios/index').'" class="btn btn-light">Voltar</a>';
                                        $dados['erro'] =  NULL;
                                        $this -> Usuarios_model -> log('sucesso', 'Usuarios/novaSenha', "Nova senha para Usuário {$usuario} enviada com sucesso pelo usuário ".$this -> session -> uid.".", 'tb_usuarios', $usuario);
                                        echo "<script type=\"text/javascript\">alert('Nova senha enviada com sucesso. A nova senha é ".$senha.".');window.location='".base_url('Usuarios/index')."';</script>";
                                }
                        }
                        else{
                                $erro = $this -> db -> error();
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'Usuarios/novaSenha', "Erro na recuperação dos dados do usuário {$usuario}. Erro: ".$erro['message']);
                                echo "<script type=\"text/javascript\">alert('Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                }

                //$this -> load -> view('usuarios', $dados);
        }
	public function delete(){
                $this -> load -> library('email');
                $this -> load -> helper('string');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='delete';
                $pagina['url']='Usuarios/delete';
                $pagina['nome_pagina']='Desativar usuário';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                
                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/index', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                        echo "<script type=\"text/javascript\">alert('Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                }
                else{
                        $usuario = $this -> uri -> segment(3);
                        $dados_usuario = $this -> Usuarios_model -> get_usuarios ($usuario);
                        if(is_array($dados_usuario) && sizeof($dados_usuario) > 0) {
                                $dados_usuario = $dados_usuario[0];
                        }

                        $dados += (array) $dados_usuario;
                        //var_dump($usuario);
                        //var_dump($dados_usuario);

                        if($usuario == $this -> session -> uid){
                                $dados['sucesso'] = '';
                                $dados['erro'] = 'Você não pode desativar seu próprio acesso por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.';
                                $this -> Usuarios_model -> log('seguranca', 'Usuarios/delete', "Usuário {$usuario} tentou se desativar.", 'tb_usuarios', $usuario);
                                echo "<script type=\"text/javascript\">alert('Você não pode desativar seu próprio acesso por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                        else{
                                $this -> Usuarios_model -> update_usuario('bl_removido', '1', $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_senha', null, $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', null, $usuario);
                                $dados['sucesso'] = 'O usuário \''.$dados_usuario -> vc_nome.'\' foi desativado com sucesso.<br/><br/><a href="'.base_url('Usuarios/index').'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] = '';
                                $this -> Usuarios_model -> log('sucesso', 'Usuarios/delete', "Usuário {$usuario} desativado pelo usuário ".$this -> session -> uid, 'tb_usuarios', $usuario);
                                echo "<script type=\"text/javascript\">alert('O usuário \'".$dados_usuario -> vc_nome."\' foi desativado com sucesso.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                }

                //$this -> load -> view('usuarios', $dados);
        }
	public function reactivate(){
                $this -> load -> library('email');
                $this -> load -> helper('string');
                $this -> load -> library('encryption');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='reactivate';
                $pagina['url']='Usuarios/reactivate';
                $pagina['nome_pagina']='Reativar conta';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                
                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/index', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                        echo "<script type=\"text/javascript\">alert('Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                }
                else{
                        $usuario = $this -> uri -> segment(3);
                        $dados['usuario'] = $this -> Usuarios_model -> get_usuarios($usuario);
                        if($dados['usuario'] -> pr_usuario > 0){
                                $senha = random_string ('alnum', 8);
                                $password = $this -> encryption -> encrypt($senha);
                                $this -> Usuarios_model -> update_usuario('bl_removido', '0', $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $usuario);
                                $this -> Usuarios_model -> update_usuario('dt_alteracao', date('Y-m-d H:i:s'), $usuario);

                                $this->load->helper('emails');
                                $config = getEmailEnvConfigs();

                                $this->email->initialize($config);
                                
                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                $this -> email -> to($dados['usuario'] -> vc_email);
                                $this -> email -> subject('['.$this -> config -> item('nome').'] Nova senha');
                                $msg='Olá '.$dados['usuario'] -> vc_nome.',<br><br>Foi solicitada uma nova senha do sistema do programa '.$this -> config -> item('nome').'. Seus dados para acesso são:<br><br>Usuário: '.$dados['usuario'] -> vc_login."<br>Senha inicial: $senha<br><br>Se não foi você que solicitou essa recuperação de senha, não se preocupe pois sua senha antiga ainda funciona.<br><br>Acesse o sistema por meio do link: ".base_url();
                                $this -> email -> message($msg);
                                if(!$this -> email -> send()){
                                        $this -> Usuarios_model -> log('erro', 'Usuarios/reactivate', 'Erro de envio de e-mail com senha de cadastro para o e-mail '.$dados['usuario'] -> vc_email.' do usuário '.$dados['usuario'] -> pr_usuario, 'tb_usuarios', $usuario);
                                }
                                else{
                                        $this -> Usuarios_model -> log('sucesso', 'Usuarios/reactivate', "Nova senha para Usuário {$usuario} enviada com sucesso.", 'tb_usuarios', $usuario);
                                }
                                $dados['sucesso'] = 'Usuário reativado com sucesso.<br/><br/><a href="'.base_url('Usuarios/index').'" class="btn btn-light">Voltar</a>';
                                $dados['erro'] =  NULL;
                                echo "<script type=\"text/javascript\">alert('Usuário reativado com sucesso.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                        else{
                                $erro = $this -> db -> error();
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'Usuarios/reactivate', "Erro na recuperação dos dados do usuário {$usuario}. Erro: ".$erro['message']);
                                echo "<script type=\"text/javascript\">alert('Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                }

                //$this -> load -> view('usuarios', $dados);
        }
}