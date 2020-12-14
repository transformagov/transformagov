<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instituicoes_model extends CI_Model {
        function __construct() {
                parent::__construct();
        }
        public function get_instituicoes($id='', $com_vagas=false){
                $inst = array();
                if(strlen($id) > 0){
                        $this -> db -> where('pr_instituicao', $id);
                }
                if($com_vagas){
                        $this -> db -> where('pr_instituicao in (select es_instituicao from tb_vagas)', null, false);
                }
                $this -> db -> where('bl_extinto', '0');
                $this -> db -> select('*');
                $this -> db -> from('tb_instituicoes2');
                $this -> db -> order_by ('vc_sigla', 'ASC');
                $query = $this -> db -> get();
                if ($query -> num_rows() > 0) {
                        $results = $query -> result_array();
                        $inst = array_column($results, 'vc_sigla', 'pr_instituicao');
                }
                return $inst;
        }
}
