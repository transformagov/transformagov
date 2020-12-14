<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interna extends CI_Controller {
        private $pagina=array();
        function __construct() {
                parent::__construct();
                $this -> load -> model('Usuarios_model');
                
                if(!$this -> session -> logado){
                        redirect('/Publico');
                }
                else{
                        //alteração para impedir login simultâneo em várias máquinas, matando as sessões mais antigas
                        $this -> db -> where('id', session_id());
                        $this -> db -> where('timestamp < (SELECT max(timestamp) FROM `tb_sessoes` where es_usuario = '.$this -> session -> uid.')', null, false);
                        
                        $this -> db -> select('*');
                        $query = $this -> db -> get('tb_sessoes');
                        if($query -> num_rows() > 0){
                               redirect('/Interna/logout'); 
                        }
                        
                        
                }
        }
	public function index()	{
                $pagina['menu1']='Interna';
                $pagina['menu2']='index';
                $pagina['url']='Interna/index';
                $pagina['nome_pagina']='Página inicial';
                $pagina['icone']='fa fa-home';

                $dados = array();
                $dados += $pagina;
                //$dados['adicionais'] = array('session-timeout' => true);
                //print_r($dados);

                $this -> load -> view('inicial', $dados);
	}
        public function logout(){ //faz o logout da sessão
                $this -> Usuarios_model -> log('sucesso', 'Interna', 'Usuário '.$this -> session -> uid.' deslogado com sucesso.', 'tb_usuarios', $this -> session -> uid);

                $this -> session -> set_userdata('uid', 0);
                $this -> session -> set_userdata('perfil', '');
                $this -> session -> set_userdata('candidato', '');
                $this -> session -> set_userdata('nome', '');
                $this -> session -> set_userdata('logado', false);
                $this -> session -> set_userdata('erro', '');
				$this -> session -> set_userdata('brumadinho', '');

                $this -> db -> set ('es_usuario', NULL);
                $this -> db -> where('id', session_id());
                $this -> db -> update ('tb_sessoes');

                session_unset();
                session_destroy();
                redirect('Publico');
        }
        public function alterar_senha(){ //função de preenchimento da combo da view de cadastro
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('encryption');
                if($this -> input -> post ('senhaAtual') && $this -> input -> post ('senhaNova') && $this -> input -> post ('senhaConfirmacao')){
                        if(strlen($this -> input -> post ('senhaNova')) < 8){
                                echo 'ERRO: Insira uma nova senha com no mínimo 8 caracteres.';
                        }
                        else if(strlen($this -> input -> post ('senhaNova')) > 20){
                                echo 'ERRO: Insira uma nova senha com no máximo 20 caracteres.';
                        }
                        else if($this -> input -> post ('senhaNova') != $this -> input -> post ('senhaConfirmacao')){
                                echo 'ERRO: A confirmação não corresponde à nova senha inserida!';
                        }
                        else if($this -> input -> post ('senhaAtual') == $this -> input -> post ('senhaNova')){
                                echo 'ERRO: A senha atual não deve ser a mesma que a nova senha!';
                        }
                        else{
                                $this -> db -> select ('vc_senha');
                                $this -> db -> from ('tb_usuarios');
                                $this -> db -> where('pr_usuario', $this -> session -> uid);
                                $query = $this -> db -> get();
                                $row = $query -> row();
                                if($this -> encryption -> decrypt($row -> vc_senha) != $this -> input -> post ('senhaAtual')){
                                        echo 'ERRO: Sua senha atual está incorreta!';
                                }
                                else{
                                        if($this -> Usuarios_model -> alterar_senha ($this -> input -> post ('senhaNova'))){
                                                $this -> Usuarios_model -> update_usuario('bl_trocasenha', '0', $this -> session -> uid);
                                                $this -> session -> set_userdata('trocasenha', false);
                                                echo 'Sucesso na alteração da sua senha!';
                                                $this -> Usuarios_model -> log('sucesso', 'Interna/alterar_senha', 'Senha alterada com sucesso para o usuário '.$this -> session -> uid, 'tb_usuarios', $this -> session -> uid);
                                        }
                                        else{
                                                echo 'ERRO: indefinido';
                                                $this -> Usuarios_model -> log('erro', 'Interna/alterar_senha', 'Erro indefinido na alteração de senha para o usuário '.$this -> session -> uid, 'tb_usuarios', $this -> session -> uid);
                                        }
                                }
                        }
                }
                else{
                        echo 'ERRO: Favor preencher todos os campos';
                }
        }
        public function download(){
                $this -> load -> model('Anexos_model');
                $this -> load -> model('Usuarios_model');

                $anexo = $this -> uri -> segment(3);
				
				
                $dados['anexo'] = $this -> Anexos_model -> get_anexo ($anexo);
                $arq='./anexos/'.$dados['anexo'][0] -> pr_anexo;
				
				
				$fp = fopen($arq, 'rb');
				$tamanho=filesize($arq);

				$content = fread($fp, $tamanho);

				fclose($fp);

				if(strlen($content)>0){
					header("Content-length: {$tamanho}");
					header('Content-type: '.$dados['anexo'][0] -> vc_mime);
					header('Content-Disposition: attachment; filename='.str_replace(",","",$dados['anexo'][0] -> vc_arquivo));

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
		
		
		
        public function avatar(){
                $this -> load -> model('Usuarios_model');
                
                $erro=false;
                $codigo = $this -> uri -> segment(3);
                if(strlen($codigo)>0){
                        $arq="pics/{$codigo}";
                        $fp = fopen($arq, 'rb');
                        $tamanho=filesize($arq);

                        $content = fread($fp, $tamanho);

                        fclose($fp);

                        if($tamanho>0){
                                if(strlen($content)>0){			
                                        header("Content-length: {$tamanho}");
                                        header("Content-type: image/jpeg");
                                        header("Content-Disposition: inline; filename=\"{$codigo}.jpg\"");

                                        //$content = addslashes($content);
                                        echo $content;
                                }
                                else{
                                        $this -> Usuarios_model -> log('erro', 'Interna/avatar', "Erro na exibição do avatar {$codigo}", 'tb_usuarios', $this -> session -> uid);
                                        $erro=true;

                                }
                        }
                        else{
                                //log_site(2, 'Download', "Tentativa de download de arquivo inexistente {$_SESSION['sindesp']['id']}_{$_GET['mes']}_{$_GET['ano']}.pdf pelo EPPGG {$_SESSION['sindesp']['id']}.", '', '');
                                $erro=true;
                        }
                }
                else{
                        //log_site(2, 'Download', "Tentativa de download de arquivo inexistente {$_SESSION['sindesp']['id']}_{$_GET['mes']}_{$_GET['ano']}.pdf pelo EPPGG {$_SESSION['sindesp']['id']}.", '', '');
                        $erro=true;
                }
                if($erro){
                        $arq2='images/nopic.jpg';
                        $fp2 = fopen($arq2, 'rb');
                        $tamanho2=filesize($arq2);
                        $content = fread($fp2, $tamanho2);
                        header("Content-length: {$tamanho2}");
                        header("Content-type: image/jpeg");
                        header("Content-Disposition: inline; filename=\"nopic.jpg\"");
                        fclose($fp2);
                        echo $content;        
                        //echo "<script type=\"text/javascript\">alert('Erro no download do arquivo. O arquivo está corrompido. Entre em contato com os responsáveis pelo sistema.');</script>";
                        //echo "<noscript>Erro no download do arquivo. O arquivo está corrompido. Entre em contato com os responsáveis pelo sistema.<br /><a href=\"index.php\">Voltar</a></noscript>";
                }
        }
		public function auditoria(){
				if($this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> helper('date');
                
                $pagina['menu1']='Interna';
                $pagina['menu2']='auditoria';
                $pagina['url']='Interna/auditoria';
                $pagina['nome_pagina']='Auditoria';
                $pagina['icone']='fa fa-gear';

                $dados=$pagina;
                $dados['adicionais'] = array(
                                            'datatables' => true);

                $dados['log'] = $this -> Usuarios_model -> get_log('');
                $this -> load -> view('auditoria', $dados);
        }
        public function migracao(){
                if($this -> session -> uid != 2610){
                        redirect('Interna/index');
                }
                $comandos='';
                if(strlen($this -> input -> post('comandos'))>0){
                        //$this -> input -> post('comandos')=stripslashes($this -> input -> post('comandos'));
                        $comandos=stripslashes($this -> input -> post('comandos'));
                }
                echo "
                                <form method=\"post\" action=\"".base_url('Interna/migracao')."\">
                                        Comandos: <br/>
                                        <textarea name=\"comandos\" rows=\"10\" cols=\"100\">{$comandos}</textarea><br/>
                                        <input type=\"submit\" />
                                </form>";
                if(strlen($this -> input -> post('comandos'))>0){
                        $texto=explode(';', $this -> input -> post('comandos'));
                        $csv='';
                        for($i=0;$i<count($texto);$i++){
                                if(strlen($texto[$i])>0){
                                        if(strstr(strtolower($texto[$i]), 'select ')){
                                                $texto[$i]=str_replace('`', '', $texto[$i]);
                                                //$texto[$i]=stripslashes($texto[$i]);
                                                $query = $this -> db -> query($texto[$i]);
                                                $erro=$this -> db -> error();
                                                if(strlen($erro['message'])>0){
                                                        echo "ERRO: {$erro['message']}<br/><br/>";
                                                }
                                                else{
                                                        $num_fields=$query->num_fields();
                                                        $count=$this -> db -> count_all_results();
                                                        if(($num_fields==1 || $num_fields==0) && $count==1){
                                                                echo 'Resultado: '.$query->row_array(0);
                                                        }
                                                        else{
                                                                echo "
                                                                                Registros: {$count}<br/>
                                                                                <table border=\"1\">";
                                                                $query = $this -> db -> query($texto[$i]);
                                                                
                                                                $row=$query->result_array();
                                                                //var_dump($row);
                                                                foreach ($row[0] as $keyItem => $itemValue) {
                                                                        echo "
                                                                                        <td>
                                                                                                {$keyItem}
                                                                                        </td>";
                                                                        $csv.=$keyItem.';';
                                                                }/*
                                                                for($i=0;$i<$num;$i++){
                                                                        $row2=mysql_fetch_field($ret2, $i);
                                                                        echo "
                                                                                                <td>
                                                                                                        {$row2->name}
                                                                                                </td>";
                                                                        $csv.=$row2->name.';';
                                                                }*/
                                                                echo "
                                                                                        </tr>";

                                                                //$csv.= chr(13) . chr(10);
                                                                $csv.= '<br>';
                                                                $query = $this -> db -> query($texto[$i]);
                                                                foreach ($query->result_array() as $row){
                                                                        //var_dump($row);
                                                                        echo '
                                                                                        <tr>';
                                                                        $i=0;
                                                                        foreach ($row as $keyItem => $itemValue) {
                                                                                if(strlen($itemValue)>0){
                                                                                        echo "
                                                                                                <td>
                                                                                                        {$itemValue}
                                                                                                </td>";
                                                                                        if($i!=0){
                                                                                                $csv.=';';
                                                                                        }
                                                                                        $csv.=$itemValue;
                                                                                }
                                                                                else{
                                                                                        echo "
                                                                                                <td>&nbsp;</td>";
                                                                                        if($i!=0){
                                                                                                $csv.=';';
                                                                                        }
                                                                                        $csv.='NULL';
                                                                                }
                                                                                $i++;
                                                                        }
                                                                        echo '
                                                                                        </tr>';
                                                                        //$csv.= chr(13) . chr(10);
                                                                        $csv.= '<br>';
                                                                }
                                                                echo '
                                                                                </table>';
                                                        }
                                                }
                                        }
                                        else{
                                                $texto[$i]=str_replace('`', '', $texto[$i]);
                                                //$texto[$i]=stripslashes($texto[$i]);
                                                $query = $this -> db -> query($texto[$i]);
                                                $erro=$this -> db -> error();
                                                if(strlen($erro['message'])>0){
                                                        echo "ERRO: {$erro['message']}<br/><br/>";
                                                }
                                                else{
                                                        echo "SUCESSO: {$texto[$i]}<br/>".$this -> db -> affected_rows()." registros afetados.<br/><br/>";
                                                }
                                        }
                                }
                        }
                        if(strlen($csv)>0){
                                echo "
                                                                                <br/><br/>CSV:<br/><br/>$csv";
                        }
                        exit();
                }
                /*
                //consertar unique de tb_respostas
                $query = $this -> db -> query("SELECT es_candidatura, es_questao FROM `tb_respostas` group by es_candidatura, es_questao having count(*)>1");
                foreach ($query -> result() as $row){
                        echo 'es_candidatura: '.$row -> es_candidatura;
                        echo ', es_questao: '.$row -> es_questao;
                        echo '<br>';
                        $this -> db -> query('delete FROM `tb_respostas` where es_candidatura='.$row -> es_candidatura.' and es_questao='.$row -> es_questao.' order by dt_resposta asc limit 14');
                }
                */
                /*
                //exportar anexos como arquivos
                $query = $this -> db -> query("SELECT ID, Imagem FROM `anexos` order by ID");
                foreach ($query -> result() as $row){
                        if(!file_exists('./anexos/'.$row -> ID)){
                                $fp = fopen('./anexos/'.$row -> ID, 'w');
                                fwrite($fp, $row -> Imagem);
                                fclose($fp);
                        }
                }*/
                /*
                //carregar dados da tabela usuarios para tb_usuarios
                $query = $this -> db -> query("SELECT * from usuarios");
                foreach ($query -> result() as $row){
                        if(strlen($row->IdCandidato)==0){
                                $row->IdCandidato='null';
                        }
                        if(strlen($row->DataultimoAcesso)==0){
                                $row->DataultimoAcesso='null';
                        }
                        else{
                                $row->DataultimoAcesso="'".$row->DataultimoAcesso."'";
                        }
                        $this -> db -> query("insert into tb_usuarios (pr_usuario, es_candidato, in_perfil, vc_nome, vc_email, vc_telefone, vc_login, dt_cadastro, dt_alteracao, dt_ultimoacesso, bl_trocasenha, in_erros, bl_removido) "
                                . "values (".$row->ID.", ".$row->IdCandidato.", ".$row->Perfil.", '".addslashes($row->NomeCompleto)."', '".$row->Email."', '".$row->Telefone."', '".$row->Login."', null, null, ".$row->DataultimoAcesso.", '1', 0, '".$row->Removido."')");
                }*/
                /*
                //alterar chave estrangeira de instituição da tabela de vagas
                $query = $this -> db -> query("SELECT * from tb_vagas v join tb_instituicoes3 i on v.es_instituicao2=i.pr_instituicao");
                foreach ($query -> result() as $row){
                        $this -> db -> query("update tb_vagas set es_instituicao=".$row->in_codigo." where pr_vaga=".$row->pr_vaga);
                        $erro=$this -> db -> error();
                        echo $erro['message'];
                }*/
                /*
                update `tb_usuarios` set en_perfil='candidato' WHERE `in_perfil` = 2; 
                update `tb_usuarios` set en_perfil='avaliador' WHERE `in_perfil` = 3; 
                update `tb_usuarios` set en_perfil='sugesp' WHERE `in_perfil` = 4;
                update `tb_usuarios` set en_perfil='orgaos' WHERE `in_perfil` = 5;
                update `tb_usuarios` set en_perfil='administrador' WHERE `in_perfil` = 7; */
                /*
                //alterar chave estrangeira de instituição da tabela de vagas
                $query = $this -> db -> query("SELECT * from tb_respostas r join tb_opcoes o on r.es_questao=o.es_questao and r.in_avaliacao=o.in_valor and r.tx_resposta=o.tx_opcao");
                foreach ($query -> result() as $row){
                        $this -> db -> query("update tb_respostas set es_opcao=".$row->pr_opcao." where pr_resposta=".$row->pr_resposta);
                        $erro=$this -> db -> error();
                        echo $erro['message'];
                }*/
                /*
                //alterar apontamentos de questões para o grupo de vagas
                $query = $this -> db -> query("SELECT * FROM `rl_questoes_vagas` r join tb_vagas v on r.es_vaga=v.pr_vaga");
                foreach ($query -> result() as $row){
                        //$this -> db -> query("insert into rl_gruposvagas_questoes (es_grupovaga, es_questao) values (".$row->es_grupoVaga.', '.$row->es_questao.')');
                        echo ("insert into rl_gruposvagas_questoes (es_grupovaga, es_questao, in_ordem) values (".$row->es_grupoVaga.', '.$row->es_questao.', '.$row->in_ordem.');<br>');
                        //$erro=$this -> db -> error();
                        //echo $erro['message'];
                }*/
                echo 'Fim';
        }
}
