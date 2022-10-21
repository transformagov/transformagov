<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Anexos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function salvar_anexo($dados, $tipo)
    {
        $data=array(
                        'in_tipo' => $tipo,
                        'vc_mime' => $dados['file_type'],
                        'vc_arquivo' => $dados['orig_name'],
                        'in_tamanho' => $dados['file_size'],
                        'es_usuarioCadastro' => $this -> session -> uid,
                        'dt_cadastro' => date('Y-m-d H:i:s')
                );
        if (isset($dados['candidatura']) && strlen($dados['candidatura']) > 0 && isset($dados['questao']) && strlen($dados['questao']) > 0) {
            $data['es_candidatura'] = $dados['candidatura'];
            $data['es_questao'] = $dados['questao'];

        //$this -> delete_anexo('',$dados['candidatura'],'',$tipo,'',$dados['questao']);
        } elseif (isset($dados['formacao']) && strlen($dados['formacao']) > 0) {
            $data['es_formacao'] = $dados['formacao'];
        //$this -> delete_anexo('','',$dados['formacao'],$tipo);
        } elseif (isset($dados['experiencia']) && strlen($dados['experiencia']) > 0) {
            $data['es_experiencia'] = $dados['experiencia'];
            //$this -> delete_anexo('','','',$tipo,$dados['experiencia']);
        }

        $this -> db -> replace('tb_anexos', $data);
        return $this -> db -> insert_id();
    }
    public function get_anexo($id='', $formacao='', $candidatura='', $tipo='', $experiencia='', $questao='')
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_anexo', $id);
        }
        if (strlen($formacao) > 0 && $formacao > 0) {
            $this -> db -> where('es_formacao', $formacao);
        }
        if (strlen($candidatura) > 0 && $candidatura > 0) {
            $this -> db -> where('es_candidatura', $candidatura);
        }
        if (strlen($questao) > 0 && $questao > 0) {
            $this -> db -> where('es_questao', $questao);
        }
        if (strlen($tipo) > 0 && $tipo > 0) {
            $this -> db -> where('in_tipo', $tipo);
        }
        if (strlen($experiencia) > 0 && $experiencia > 0) {
            $this -> db -> where('es_experiencia', $experiencia);
        }
        $this -> db -> where('bl_removido', '0');
        $this -> db -> select('*');
        $this -> db -> from('tb_anexos');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }

    public function delete_anexo($id, $candidatura='', $formacao='', $tipo='', $experiencia = '', $questao='')
    {
        //echo "delete: $primaria<br>";
        if (strlen($candidatura)==0&&strlen($formacao)==0 && strlen($experiencia)==0) {
            return false;
        }


        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_anexo', $id);
        }
        if (strlen($candidatura)>0 && $candidatura > 0) {
            $this -> db -> where('es_candidatura', $candidatura);
        }
        if (strlen($questao)>0 && $questao > 0) {
            $this -> db -> where('es_questao', $questao);
        }
        if (strlen($formacao)>0 && $formacao > 0) {
            $this -> db -> where('es_formacao', $formacao);
        }
        if (strlen($experiencia)>0 && $experiencia > 0) {
            $this -> db -> where('es_experiencia', $experiencia);
        }
        if (strlen($tipo) > 0 && $tipo > 0) {
            $this -> db -> where('in_tipo', $tipo);
        }
        $this -> db -> delete('tb_anexos');
        echo $this -> db -> last_query();
        return $this -> db -> affected_rows();
    }
}
