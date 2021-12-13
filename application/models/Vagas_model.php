<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vagas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_vagas($id='', $vigentes=true, $tipo='array', $not_candidato='', $periodo=0, $grupovaga = '', $nao_removidos=false, $status_candidatura='', $avaliador='')
    {
        if (strlen($id) > 0) {
            $this -> db -> where('v.pr_vaga', $id);
        } elseif (strlen($grupovaga) > 0) {
            $this -> db -> where('v.es_grupoVaga', $grupovaga);
        } else {
            if ($vigentes) {
                $this -> db -> where('v.dt_fim >=', date('Y-m-d H:i:s'));
                $this -> db -> where('v.bl_removido', '0');
            } elseif ($nao_removidos) {
                $this -> db -> where('v.bl_removido', '0');
            }
            if (strlen($not_candidato) > 0) {
                $this -> db -> where("v.pr_vaga not in (select es_vaga from tb_candidaturas where es_candidato={$not_candidato})");
            }
            if ($periodo==1) {
                $this -> db -> where("v.dt_inicio<=now() and v.dt_fim>=now() and v.bl_liberado='1'");
            } elseif ($periodo==2) {
                $this -> db -> where("v.dt_fim<now() and v.bl_liberado='1'");
            }
        }
        if (is_array($status_candidatura)) {
            $string_status="";
            foreach ($status_candidatura as $status) {
                $string_status.=$status.",";
            }
            $string_status=substr($string_status, 0, -1);
            $this -> db -> where("v.pr_vaga in (select es_vaga from tb_candidaturas where es_status in ({$string_status}))");
        } elseif (strlen($status_candidatura) > 0) {
            $this -> db -> where("v.pr_vaga in (select es_vaga from tb_candidaturas where es_status in ({$status_candidatura}))");
        }
        if ($this -> session -> brumadinho == '1') {
            $this -> db -> where('v.bl_brumadinho', '1');
        }
        if (strlen($avaliador) > 0) {
            $this -> db -> where("v.pr_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario={$avaliador})");
        }
        $this -> db -> select('v.pr_vaga, v.vc_vaga, v.dt_inicio, v.dt_fim, v.tx_descricao, v.es_instituicao, v.es_grupoVaga, v.bl_removido, g.vc_grupovaga, i.vc_sigla, v.bl_liberado, v.bl_brumadinho, v.bl_finalizado');
        $this -> db -> from('tb_vagas v');
        $this -> db -> join('tb_gruposvagas g', 'v.es_grupoVaga=g.pr_grupovaga');
        $this -> db -> join('tb_instituicoes2 i', 'v.es_instituicao=i.pr_instituicao');
        $this -> db -> order_by('v.vc_vaga', 'ASC');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            if (strlen($id) > 0) {
                return $query -> result();
            } else {
                if ($tipo=='array') {
                    $results = $query -> result_array();
                    $vagas = array_column($results, 'vc_vaga', 'pr_vaga');
                    return $vagas;
                } else {
                    $resultado = $query -> result();
                    foreach ($resultado as $linha) {
                        $this -> db -> from('rl_questoes_vagas');
                        $this -> db -> where('es_vaga', $linha -> pr_vaga);
                        $linha -> cont = $this -> db -> count_all_results();
                        $retorno[] = $linha;
                    }
                    return $retorno;
                }
            }
        } else {
            return null;
        }
    }
    public function update_vaga($campo, $valor, $primaria)
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
        $this -> db -> where('pr_vaga', $primaria);
        $this -> db -> update('tb_vagas');
        return $this -> db -> affected_rows();
    }
    public function create_vaga($dados)
    {
        $data=array(
                        'vc_vaga' => $dados['nome'],
                        'tx_descricao' => $dados['descricao'],
                        'dt_inicio' => show_sql_date($dados['inicio'], true),
                        'dt_fim' => show_sql_date($dados['fim'], true),
                        'es_instituicao' => $dados['instituicao'],
                        'es_grupoVaga' => $dados['grupo'],
                        'in_statusVaga' => '1',
                        'bl_brumadinho' => $dados['brumadinho'],
                        'es_usuarioCadastro' => $this -> session -> uid,
                        'dt_cadastro' => date('Y-m-d H:i:s')
                );
        $this -> db -> insert('tb_vagas', $data);
        //print_r($this->db->error());
        return $this -> db -> insert_id();
    }

    public function get_vagas_avaliadores($vaga='', $usuario='')
    {
        if (strlen($vaga) > 0) {
            $this -> db -> where('es_vaga', $vaga);
        }
        if (strlen($usuario) > 0) {
            $this -> db -> where('es_usuario', $usuario);
        }
        $this -> db -> select('*');

        $query = $this -> db -> get('rl_vagas_avaliadores');
        if ($query -> num_rows() >= 1) {
            return $query -> result();
        } else {
            return null;
        }
    }

    public function create_vaga_avaliador($dados, $vaga, $usuario)
    {
        $data=array(
                        'es_vaga' => $vaga,
                        'es_usuario' => $dados["usuario{$usuario}"],
                );

        $this -> db -> insert('rl_vagas_avaliadores', $data);

        return $this -> db -> affected_rows();
    }

    public function delete_vaga_avaliador($id)
    {
        if (strlen($id)==0) {
            return false;
        }
        $this -> db -> where('es_vaga', $id);
        $this -> db -> delete('rl_vagas_avaliadores');
        return $this -> db -> affected_rows();
    }
}
