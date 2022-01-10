<?php

defined('BASEPATH') or exit('No direct script access allowed');

class GruposVagas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_grupos($id='', $vigentes=true, $nao_finalizado=false)
    {
        if (strlen($id) > 0) {
            $this -> db -> where('g.pr_grupovaga', $id);
        }
        if ($vigentes) {
            $this -> db -> where('g.bl_removido', '0');
        }
        if ($nao_finalizado) {
            $this -> db -> where('g.pr_grupovaga not in (select r.es_grupovaga from rl_gruposvagas_questoes r join tb_questoes q on q.pr_questao=r.es_questao where q.pr_questao in (select es_questao from tb_respostas) and q.es_etapa in (6))', null);
        }
        $grupos = array();
        $this -> db -> select('g.*, i.vc_sigla');
        $this -> db -> from('tb_gruposvagas g');
        $this -> db -> join('tb_instituicoes2 i', 'g.es_instituicao=i.pr_instituicao', 'left');
        $this -> db -> order_by('g.vc_grupovaga', 'ASC');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            $resultado = $query -> result();
            foreach ($resultado as $linha) {
                $this -> db -> from('tb_vagas');
                $this -> db -> where('es_grupoVaga', $linha -> pr_grupovaga);
                $this -> db -> where('bl_removido', '0');
                $linha -> cont_vagas = $this -> db -> count_all_results();

                $this -> db -> from('rl_gruposvagas_questoes');
                $this -> db -> where('es_grupovaga', $linha -> pr_grupovaga);
                $linha -> cont_questoes = $this -> db -> count_all_results();
                $retorno[] = $linha;
            }
            return $retorno;
        }
        return $grupos;
    }
    public function update_grupo($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> set('es_usuarioAlteracao', $this -> session -> uid);
        $this -> db -> set('dt_alteracao', date('Y-m-d H:i:s'));
        $this -> db -> where('pr_grupovaga', $primaria);
        $this -> db -> update('tb_gruposvagas');
        return $this -> db -> affected_rows();
    }
    public function create_grupo($dados)
    {
        if (isset($dados['instituicao'])&&$dados['instituicao']>0) {
            $data=array(
                                'vc_grupovaga' => $dados['nome'],
                                'es_instituicao' => $dados['instituicao'],
                                'es_usuarioCadastro' => $this -> session -> uid,
                                'dt_cadastro' => date('Y-m-d H:i:s')
                        );
        } else {
            $data=array(
                                'vc_grupovaga' => $dados['nome'],
                                'es_usuarioCadastro' => $this -> session -> uid,
                                'dt_cadastro' => date('Y-m-d H:i:s')
                        );
        }
        $this -> db -> insert('tb_gruposvagas', $data);
        //print_r($this ->db ->error());
        return $this -> db -> insert_id();
    }
}
