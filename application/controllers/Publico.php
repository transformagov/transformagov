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
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$row -> vc_nome}</strong>, foi solicitada uma nova senha para acesso ao sistema do Transforma Minas!</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Seus dados para acesso são:</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><strong><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Usuário: {$row -> vc_login}</span></span></strong></p>
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
