<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_usuarios($id='', $cpf='', $perfil='', $vaga = '', $ativo = false)
    {
        if (strlen($id) > 0) {
            $this -> db -> where('pr_usuario', $id);
        } elseif (strlen($cpf) > 0) {
            $this -> db -> where('vc_login', $cpf);
        } else {
            $this -> db -> where('es_candidato', null);
        }
        if (strlen($vaga) >0) {
            $this -> db -> where("((pr_usuario in (select es_usuario from rl_vagas_avaliadores where es_vaga={$vaga}) and en_perfil = 2) or en_perfil = 3)");
        } elseif (is_array($perfil)) {
            $this -> db -> where_in('en_perfil', $perfil);
        } elseif (strlen($perfil) > 0) {
            $this -> db -> where('en_perfil', $perfil);
        }
        if ($ativo == true) {
            $this -> db -> where('bl_removido !=', '1');
        }
        $this -> db -> select('*');
        $this -> db -> order_by('vc_nome', 'ASC');
        $query = $this -> db -> get('tb_usuarios');
        if ($query -> num_rows() == 1 && ($id != '' || $cpf != '')) {
            return $query -> row();
        } elseif ($query -> num_rows() > 1) {
            return $query -> result();
        } else {
            return array();
        }
    }
    public function create_usuario($dados)
    {
        $this -> load -> library('encryption');

        $password = $this -> encryption -> encrypt($dados['senha']);
        $data=array(
                        'vc_nome' => $dados['NomeCompleto'],
                        'vc_login' => $dados['CPF'],
                        'vc_email' => $dados['Email'],
                        'vc_senha' => $password,
                        'en_perfil' => $dados['perfil'],
                        'es_candidato' => $dados['candidato'],
                        'vc_telefone' => $dados['Telefone'],
                        'vc_senha_temporaria' => null,
                        'dt_cadastro' => date('Y-m-d H:i:s'),
                        'bl_trocasenha' => '1'
                );
        $this -> db -> insert('tb_usuarios', $data);
        return $this -> db -> insert_id();
    }
    public function update_usuario($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_usuario', $primaria);
        $this -> db -> update('tb_usuarios');
        return $this -> db -> affected_rows();
    }
    public function login($login, $senha)
    {
        $this -> load -> library('encryption');

        $this -> db -> select('*');
        $this -> db -> from('tb_usuarios');
        $where = array('vc_login' => $login);
        $this -> db -> where($where);
        $query = $this -> db -> get();
        if ($query -> num_rows() == 1) {
            $row = $query -> row();
            if ($row -> in_erros > 3) {
                $this -> session -> set_userdata('erro', 'Essa conta está bloqueada por muitas tentativas de acesso sem sucesso!');
                return null;
            } elseif ($row -> bl_removido == '1') {
                $this -> session -> set_userdata('erro', 'Essa conta está desativada!');
                return null;
            } elseif ($this -> encryption -> decrypt($row -> vc_senha) == $senha) {
                $this -> update_usuario('in_erros', 0, $row -> pr_usuario);
                $this -> session -> set_userdata('erro', '');
                return $row;
            } elseif ($this -> encryption -> decrypt($row -> vc_senha_temporaria) == $senha) {
                $this -> update_usuario('in_erros', 0, $row -> pr_usuario);
                $this -> update_usuario('vc_senha', $row -> vc_senha_temporaria, $row -> pr_usuario);
                $this -> update_usuario('vc_senha_temporaria', null, $row -> pr_usuario);
                $this -> session -> set_userdata('erro', '');
                return $row;
            } else {
                $this -> update_usuario('in_erros', ($row -> in_erros + 1), $row -> pr_usuario);
                $this -> session -> set_userdata('erro', 'CPF ou senha incorretos!');
                return null;
            }
        } else {
            $this -> session -> set_userdata('erro', 'CPF ou senha incorretos!');
            return null;
        }
    }
    public function alterar_senha($senha)
    {
        $this -> load -> library('encryption');

        $password = $this -> encryption -> encrypt($senha);
        $this -> db -> set('vc_senha', $password);
        $this -> db -> where('pr_usuario', $this -> session -> uid);
        $this -> db -> update('tb_usuarios');
        return $this -> db -> affected_rows();
    }
    public function get_log($id='')
    {
        if (strlen($id) > 0) {
            $this -> db -> where('pr_log', $id);
        }
        $this -> db -> order_by('pr_log', 'DESC');
        $this -> db -> limit(1000);
        $query = $this -> db -> get('tb_log');
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }
    public function log($tipo, $local, $texto, $tabela='', $chave='', $email=true)
    {
        $this -> load -> library('email');
        /*
         * Tipos:
         * erro: erro de sistema
         * seguranca: violações de segurança
         * sucesso: mensagens de sucesso
         * advertencia: advertências leves
         */
        //echo "tipo: $tipo, local: $local, texto: $texto, tabela: $tabela, chave: $chave<br/>";

        if (strlen($chave)==0) {
            $chave=null;
        }
        $texto.='<br/>';
        $local=addslashes($local);
        $texto=addslashes($texto);

        $data=array(
                        'en_tipo' => $tipo,
                        'vc_local' => $local,
                        'es_usuario' => $this -> session -> uid,
                        'vc_tabela' => $tabela,
                        'in_chave' => $chave,
                        'tx_texto' => $texto,
                        'vc_ip' => $_SERVER['REMOTE_ADDR'],
                        'vc_sessao' => session_id(),
                        'dt_log' => date('Y-m-d H:i:s')
                );
        $this -> db -> insert('tb_log', $data);



        if ($email && ($tipo==1 || $tipo==2)) {
            $this -> email -> from('naoresponda@planejamento.mg.gov.br', $this -> config -> item('nome'));
            $this -> email -> to($config['administrador']);
            if ($tipo==1) {
                $this -> email -> subject('['.$this -> config -> item('nome').'] Erro');
                $this -> email -> message($texto);
            } elseif ($tipo==2) {
                $this -> email -> subject('['.$this -> config -> item('nome').'] Violação');
                $this -> email -> message($texto);
            }
            $this -> email -> send();
        }

        //log redundante em arquivo texto
        if (!file_exists('./application/logs')) {
            mkdir('./application/logs', 0766);
        }
        chmod('./application/logs', 0766);

        $arquivo=fopen('./application/logs/'.date('Y_m').'.log', 'a');
        chmod('./application/logs/'.date('Y_m').'.log', 0766);
        $escrito = date('d/m/Y H:i:s').'> Tipo '.$tipo.' ('.$local.'): '.$texto."\n";
        fwrite($arquivo, $escrito);

        chmod('./application/logs/'.date('Y_m').'.log', 0644);
        chmod('./application/logs', 0644);
        fclose($arquivo);
    }
}
