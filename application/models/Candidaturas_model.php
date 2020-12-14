<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidaturas_model extends CI_Model {
        function __construct() {
                parent::__construct();
        }
        public function get_candidaturas($id='', $candidato='', $vaga='', $instituicao='', $status='', $avaliador='',$calendario='', $nome = '', $paginacao=0){
                if(strlen($id) > 0 && $id > 0){
                        $this -> db -> where('c.pr_candidatura', $id);
                }
                if(strlen($candidato) > 0 && $candidato > 0){
                        $this -> db -> where('c.es_candidato', $candidato);
                }
                if(strlen($vaga) > 0 && $vaga > 0){
						
                        $this -> db -> where('c.es_vaga', $vaga);
                }
                if(strlen($nome) > 0){
                        $this -> db -> where("upper(remove_accents(d.vc_nome)) like '%".strtoupper(retira_acentos($nome))."%'");
                }
				
                if(strlen($instituicao) > 0 && $instituicao > 0){
                        $this -> db -> where('v.es_instituicao', $instituicao);
                }
                
                if(stristr($status,",")){
                        $status= explode(",", $status);
                }
                
                if(is_array($status)){
                        $this -> db -> where_in('c.es_status', $status);
                }
                else if(strlen($status) > 0 && $status > 0){
                        //$this -> db -> where('c.es_status', $status);
                        $this -> db -> where('c.es_status', $status);
                }
                else if(stristr($status,'<>')){
                        //feito para excluir o valor
                        $status=trim(str_replace("<>","",$status));
                        
                        $this -> db -> where('c.es_status <>', $status);
                }
                $this -> db -> where('c.bl_removido', '0');
                if((strlen($avaliador) > 0 && $avaliador > 0)){                        
                        $this -> db -> where("(e.es_avaliador1 = {$avaliador} or e.es_avaliador2 = {$avaliador} or e.es_avaliador3 = {$avaliador} or es_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario={$avaliador}))");
                }
                
				/*if($this -> session -> brumadinho == '1'){
						$this -> db -> where('v.bl_brumadinho', '1');
				}*/
				
                /*        $this -> db -> select('c.pr_candidatura, c.es_candidato, c.es_vaga, c.dt_candidatura, c.es_status, s.vc_status, v.vc_vaga, v.dt_fim, d.vc_nome, e.*, i.vc_sigla, i.vc_instituicao, c.en_aderencia, c.es_avaliador_competencia1, c.es_avaliador_competencia2');
                }
                else */if((strlen($avaliador) > 0 && $avaliador > 0) || (strlen($calendario) > 0 && $calendario > 0)){
                        $this -> db -> select('u.vc_nome as avaliador_competencia,c.pr_candidatura, c.es_candidato, c.es_vaga, c.dt_candidatura, c.es_status, s.vc_status, v.vc_vaga, v.dt_fim, d.vc_nome, e.*, i.vc_sigla, i.vc_instituicao, c.en_aderencia, c.dt_aderencia, c.es_avaliador_competencia1, c.es_avaliador_especialista');
                }
                else{
                        $this -> db -> select('u.vc_nome as avaliador_competencia,c.pr_candidatura, c.es_candidato, c.es_vaga, c.dt_candidatura, c.es_status, s.vc_status, v.vc_vaga, v.dt_fim, d.vc_nome, i.vc_sigla, i.vc_instituicao, c.en_aderencia, c.dt_aderencia, c.es_avaliador_competencia1, c.es_avaliador_especialista, c.tx_expectativa_momento, c.tx_observacoes_momento, c.tx_pontos_fortes, c.tx_pontos_melhorias, c.tx_feedback, c.tx_comentarios, c.dt_cadastro');
                }
                
                $this -> db -> where('c.bl_removido', '0');
                $this -> db -> from('tb_candidaturas c');
                $this -> db -> join('tb_vagas v', 'c.es_vaga=v.pr_vaga');
                $this -> db -> join('tb_status_candidaturas s', 's.pr_status=c.es_status');
                $this -> db -> join('tb_candidatos d', 'c.es_candidato=d.pr_candidato');
                $this -> db -> join('tb_instituicoes2 i', 'v.es_instituicao=i.pr_instituicao');
				$this -> db -> join('tb_usuarios u', 'c.es_avaliador_curriculo=u.pr_usuario', 'left');
                if((strlen($avaliador) > 0 && $avaliador > 0) || (strlen($calendario) > 0 && $calendario > 0)){
                        $this -> db -> join('tb_entrevistas e', 'c.pr_candidatura=e.es_candidatura', 'left');
                }
                $this->db->order_by('c.pr_candidatura', 'DESC');

                if($paginacao > 0){
                        $this -> db -> limit(30, (($paginacao-1)*30));
                }
                $query = $this -> db -> get();
                
                if($query -> num_rows() > 0){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        public function update_candidatura($campo, $valor, $primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> where('pr_candidatura', $primaria);
                $this -> db -> update ('tb_candidaturas');
                return $this -> db -> affected_rows();
        }
        public function create_candidatura($dados){
                $data=array(
                        'es_candidato' => $this -> session -> candidato,
                        'es_vaga' => $dados['Vaga'],
                        'es_status' => 1,
                        'dt_cadastro' => date('Y-m-d H:i:s'),
                        'dt_candidatura' => date('Y-m-d H:i:s')
                );
                $this -> db -> insert ('tb_candidaturas', $data);
                return $this -> db -> insert_id();
        }
        public function salvar_resposta($dados, $questao){
                //var_dump($dados);
                if(isset($dados['avaliador']) && strlen($dados['avaliador']) > 0){
                        $data=array(
                                'es_candidatura' => $dados['candidatura'],
                                'es_questao' => $questao,
                                'es_avaliador' => $dados['avaliador'],
                                'tx_resposta' => $dados["Questao{$questao}"],
                                'dt_resposta' => date('Y-m-d H:i:s')
                        );
                }
                else{
                        $data=array(
                                'es_candidatura' => $dados['candidatura'],
                                'es_questao' => $questao,
                                'tx_resposta' => $dados["Questao{$questao}"],
                                'dt_resposta' => date('Y-m-d H:i:s')
                        );
                }
                $this -> db -> insert ('tb_respostas', $data);
                return $this -> db -> insert_id();
        }
        public function update_resposta($campo,$valor,$primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> where('pr_resposta', $primaria);
                $this -> db -> update ('tb_respostas');
                return $this -> db -> affected_rows();
        }
        
        public function delete_resposta($id){
                //echo "delete: $primaria<br>";
                if(strlen($id)==0&&strlen($id)==0){
                        return FALSE;
                }
                
                if(strlen($id) > 0 && $id > 0){
                        $this -> db -> where('pr_resposta', $id);
                }

                $this -> db -> delete ('tb_respostas');
                
                return $this -> db -> affected_rows();
        }
        
        public function get_status($avaliador=0){
                $this -> db -> select('*');
                $this -> db -> from('tb_status_candidaturas');
                if($avaliador != 0){
                        $this -> db -> where('pr_status <>', 5);
                }
                $query = $this -> db -> get();
                if($query -> num_rows() > 0){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        public function get_entrevistas($id='', $candidatura='', $tipo_entrevista=''){
                if(strlen($id) > 0 && $id > 0){
                        $this -> db -> where('e.pr_entrevista', $id);
                }
                if(strlen($candidatura) > 0){
                        $this -> db -> where('e.es_candidatura', $candidatura);
                }
                if(strlen($tipo_entrevista) > 0){
                        $this -> db -> where('e.bl_tipo_entrevista', $tipo_entrevista);
                }
                $this -> db -> select('e.*, c.vc_nome as nome_candidato,c.vc_email as email_candidato, u1.vc_email as email1, u1.vc_nome as nome1, u2.vc_email as email2, u2.vc_nome as nome2');
                $this -> db -> from('tb_entrevistas e');
                $this -> db -> join('tb_usuarios u1', 'e.es_avaliador1=u1.pr_usuario');
                $this -> db -> join('tb_usuarios u2', 'e.es_avaliador2=u2.pr_usuario','left');
				//$this -> db -> join('tb_usuarios u3', 'e.es_avaliador3=u3.pr_usuario','left');
                $this -> db -> join('tb_candidaturas ca', 'e.es_candidatura=ca.pr_candidatura');
                $this -> db -> join('tb_candidatos c', 'ca.es_candidato=c.pr_candidato');
                $query = $this -> db -> get();
                if($query -> num_rows() > 0){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        public function atualiza_entrevista($dados){
                //var_dump($dados);
                if(isset($dados['avaliador2']) && strlen($dados['avaliador2']) >0 ){
                        $data=array(
                                'es_candidatura' => $dados['codigo'],
                                'es_avaliador1' => $dados['avaliador1'],
                                'es_avaliador2' => $dados['avaliador2'],
								
                                'dt_entrevista' => show_sql_date($dados['data'], true),
                                'es_alterador' => $this -> session -> uid,
                                'bl_tipo_entrevista' => $dados['tipo_entrevista'],
				'vc_link' => $dados['link'],
                                'tx_observacoes' => $dados['observacoes'],
                                'dt_alteracao' => date('Y-m-d H:i:s')
                        );
                }
                else{
                        $data=array(
                                'es_candidatura' => $dados['codigo'],
                                'es_avaliador1' => $dados['avaliador1'],
                                
                                'dt_entrevista' => show_sql_date($dados['data'], true),
                                'es_alterador' => $this -> session -> uid,
                                'bl_tipo_entrevista' => $dados['tipo_entrevista'],
				'vc_link' => $dados['link'],
                                'tx_observacoes' => $dados['observacoes'],
                                'dt_alteracao' => date('Y-m-d H:i:s')
                        );
                }
                $this -> db -> replace ('tb_entrevistas', $data);
                return $this -> db -> insert_id();
                
                /*
                $data=array(
                        'es_candidato' => $this -> session -> candidato,
                        'es_vaga' => $dados['Vaga'],
                        'es_status' => 1,
                        'dt_candidatura' => date('Y-m-d H:i:s')
                );
                $this -> db -> insert ('tb_candidaturas', $data);
                return $this -> db -> insert_id();*/
        }
        public function create_formacao($dados, $id){
				if(!($dados["cargahoraria{$id}"])>0){
						$dados["cargahoraria{$id}"] = null;
				}
				/*
				'se_conclusao' => $dados["semestre_conclusao{$id}"],
				'me_conclusao' => $dados["mes_conclusao{$id}"],
				*/
                if(isset($dados["candidatura{$id}"]) && strlen($dados["candidatura{$id}"])>0){
                        if(isset($dados["codigo_formacao_pai{$id}"]) && strlen($dados["codigo_formacao_pai{$id}"])>0){
                                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'es_candidatura' => $dados["candidatura{$id}"],
                                        'es_formacao_pai' => $dados["codigo_formacao_pai{$id}"],
                                        'vc_curso' => $dados["curso{$id}"],
                                        'en_tipo' => $dados["tipo{$id}"],
                                        'vc_instituicao' => $dados["instituicao{$id}"],
                                        'dt_conclusao' => $dados["conclusao{$id}"],
                                        
										'in_cargahoraria' => $dados["cargahoraria{$id}"],
                                );
                        }
                        else{
                                //duplica a formação na candidatura para gerar automaticamente os dados nos dados pessoais
                                $data=array(
                                        'es_candidato' => $this -> session -> candidato,                                        
                                        'vc_curso' => $dados["curso{$id}"],
                                        'en_tipo' => $dados["tipo{$id}"],
                                        'vc_instituicao' => $dados["instituicao{$id}"],
                                        'dt_conclusao' => $dados["conclusao{$id}"],
                                        
										'in_cargahoraria' => $dados["cargahoraria{$id}"],
                                );
                                $this -> db -> insert ('tb_formacao', $data);
                                $formacao = $this -> db -> insert_id();
                                 
                                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'es_candidatura' => $dados["candidatura{$id}"],
                                        'es_formacao_pai' => $formacao,
                                        'vc_curso' => $dados["curso{$id}"],
                                        'en_tipo' => $dados["tipo{$id}"],
                                        'vc_instituicao' => $dados["instituicao{$id}"],
                                        'dt_conclusao' => $dados["conclusao{$id}"],
                                        
										'in_cargahoraria' => $dados["cargahoraria{$id}"],
                                );        
                        }
                }
                else{
                        $data=array(
                                'es_candidato' => $this -> session -> candidato,
                                'vc_curso' => $dados["curso{$id}"],
                                'en_tipo' => $dados["tipo{$id}"],
                                'vc_instituicao' => $dados["instituicao{$id}"],
                                'dt_conclusao' => $dados["conclusao{$id}"],
                                
								'in_cargahoraria' => $dados["cargahoraria{$id}"],
                        );
                }
                $this -> db -> insert ('tb_formacao', $data);
                //echo $this -> db -> last_query();
                return $this -> db -> insert_id();
        }
        
        public function update_formacao($campo,$valor,$primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> where('pr_formacao', $primaria);
                $this -> db -> update ('tb_formacao');
                return $this -> db -> affected_rows();
        }
        
        
        
        public function delete_formacao($id){
                //echo "delete: $primaria<br>";
                if(strlen($id)==0&&strlen($id)==0){
                        return FALSE;
                }
                
                
                if(strlen($id) > 0 && $id > 0){
                        //$this ->delete_formacao_candidatura($id);
                        $this -> db -> where('pr_formacao', $id);
                }
                
                $this -> db -> delete ('tb_formacao');
                
                return $this -> db -> affected_rows();
        }
        
        /*public function create_formacao_candidatura($formacao,$candidatura){
                $data=array(
                        'es_candidatura' => $candidatura,
                        'es_formacao' => $formacao,                        
                );
                $this -> db -> insert ('rl_formacoes_candidaturas', $data);
                return $this -> db -> affected_rows();
        }*/
        
        /*public function delete_formacao_candidatura($formacao,$candidatura=''){
                if(strlen($formacao)==0&&strlen($formacao)==0){
                        return FALSE;
                }
                if(strlen($formacao) > 0 && $formacao > 0){
                        $this -> db -> where('es_formacao', $formacao);
                }
                if(strlen($candidatura) > 0 && $candidatura > 0){
                        $this -> db -> where('es_candidatura', $candidatura);
                }
                $this -> db -> delete ('rl_formacoes_candidaturas');                
                return $this -> db -> affected_rows();
        }*/
        
        public function get_formacao($id='',$candidato='',$candidatura=''){
                if(strlen($id) > 0 && $id > 0){
                        $this -> db -> where('pr_formacao', $id);
                }
                if(strlen($candidato) > 0){
                        $this -> db -> where('es_candidato', $candidato);
                }
                if(strlen($candidatura) > 0){
                        $this -> db -> where('es_candidatura', $candidatura);
                        //$this -> db -> where("pr_formacao IN (select es_formacao from rl_formacoes_candidaturas where es_candidatura={$candidatura})", NULL, FALSE);
                }
                else{
                        $this -> db -> where('es_candidatura', null);
                }
                $this -> db -> select('*');
                $this -> db -> from('tb_formacao');
                $query = $this -> db -> get();
                if($query -> num_rows() > 0){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        
        public function create_experiencia($dados, $id){
                if(!($dados["emprego_atual{$id}"]>0)){
                        $dados["emprego_atual{$id}"]=null;
                }
                if(isset($dados["candidatura{$id}"]) && strlen($dados["candidatura{$id}"])>0){
                        if(isset($dados["codigo_experiencia_pai{$id}"]) && strlen($dados["codigo_experiencia_pai{$id}"])>0){
                                //echo "teste";
                                if(strlen($dados["fim{$id}"])>0){
                                        $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $dados["codigo_experiencia_pai{$id}"],        
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
						'bl_emprego_atual' => $dados["emprego_atual{$id}"],						
                                                'dt_fim' => $dados["fim{$id}"],
												
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                                }
                                else{
                                        $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $dados["codigo_experiencia_pai{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
						'bl_emprego_atual' => $dados["emprego_atual{$id}"],						
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                                }
                        }
                        else{
                                if(strlen($dados["fim{$id}"])>0){
                                        $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
						'bl_emprego_atual' => $dados["emprego_atual{$id}"],						
                                                'dt_fim' => $dados["fim{$id}"],
												
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                                        $this -> db -> insert ('tb_experiencias', $data);
               
                                        $experiencia = $this -> db -> insert_id();
                                        //echo "teste";
                                        $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $experiencia,        
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
						'bl_emprego_atual' => $dados["emprego_atual{$id}"],						
                                                'dt_fim' => $dados["fim{$id}"],
												
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                                }
                                else{
                                        $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
						'bl_emprego_atual' => $dados["emprego_atual{$id}"],						
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                                        $this -> db -> insert ('tb_experiencias', $data);
                                        
                                        $experiencia = $this -> db -> insert_id();
                                        $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $experiencia,
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
						'bl_emprego_atual' => $dados["emprego_atual{$id}"],						
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                                }
                        }
                }
                else{
                        if(strlen($dados["fim{$id}"])>0){
                                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'vc_empresa' => $dados["empresa{$id}"],
                                        'dt_inicio' => $dados["inicio{$id}"],
					'bl_emprego_atual' => $dados["emprego_atual{$id}"],					
                                        'dt_fim' => $dados["fim{$id}"],
										
                                        'tx_atividades' => $dados["atividades{$id}"],
                                );
                        }
                        else{
                                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'vc_empresa' => $dados["empresa{$id}"],
                                        'dt_inicio' => $dados["inicio{$id}"],
					'bl_emprego_atual' => $dados["emprego_atual{$id}"],					
                                        'tx_atividades' => $dados["atividades{$id}"],
                                );
                        }
                }
                $this -> db -> insert ('tb_experiencias', $data);
                
                return $this -> db -> insert_id();
        }
        
        public function update_experiencia($campo,$valor,$primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> where('pr_experienca', $primaria);
                $this -> db -> update ('tb_experiencias');
                return $this -> db -> affected_rows();
        }
        
        public function delete_experiencia($id){
                //echo "delete: $primaria<br>";
                if(strlen($id)==0&&strlen($id)==0){
                        return FALSE;
                }
                
                
                if(strlen($id) > 0 && $id > 0){
                        //$this ->delete_experiencia_candidatura($id);
                        $this -> db -> where('pr_experienca', $id);
                }
                
               
                $this -> db -> delete ('tb_experiencias');
                
                return $this -> db -> affected_rows();
        }
        
        /*public function create_experiencia_candidatura($experiencia,$candidatura){
                
                $data=array(
                        'es_candidatura' => $candidatura,
                        'es_experiencia' => $experiencia,                        
                );
                
                $this -> db -> insert ('rl_experiencias_candidaturas', $data);
                return $this -> db -> affected_rows();
        }*/
        
        /*public function delete_experiencia_candidatura($experiencia,$candidatura=''){
                //echo "delete: $primaria<br>";
                if(strlen($experiencia)==0&&strlen($experiencia)==0){
                        return FALSE;
                }
                
                if(strlen($experiencia) > 0 && $experiencia > 0){
                        $this -> db -> where('es_experiencia', $experiencia);
                }
                if(strlen($candidatura) > 0 && $candidatura > 0){
                        $this -> db -> where('es_candidatura', $candidatura);
                }
               
                $this -> db -> delete ('rl_experiencias_candidaturas');
                
                return $this -> db -> affected_rows();
        }*/
        
        
        public function get_experiencia($id='',$candidato='',$candidatura=''){
                if(strlen($id) > 0 && $id > 0){
                        $this -> db -> where('pr_experienca', $id);
                }
                if(strlen($candidato) > 0){
                        $this -> db -> where('es_candidato', $candidato);
                }
                if(strlen($candidatura) > 0){
                        $this -> db -> where('es_candidatura', $candidatura);
                        //$this -> db -> where("pr_experienca IN (select es_experiencia from rl_experiencias_candidaturas where es_candidatura={$candidatura})", NULL, FALSE);
                }
                else{
                        $this -> db -> where('es_candidatura', null);
                }
                $this -> db -> select('*');
                $this -> db -> from('tb_experiencias');
                $query = $this -> db -> get();
                if($query -> num_rows() > 0){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }

        public function get_nota($id='',$candidatura='',$etapa='',$competencia='',$etapa4='',$avaliador=''){
                if(strlen($id) > 0 && $id > 0){
                        $this -> db -> where('pr_nota', $id);
                }
                if(strlen($candidatura) > 0){
                        $this -> db -> where('es_candidatura', $candidatura);
                }
                if(strlen($etapa) > 0){
                        $this -> db -> where('es_etapa', $etapa);
                }
				if(strlen($avaliador) > 0){
						$this -> db -> where('es_avaliador', $avaliador);
				}
				else if($etapa4 == ''){
                        $this -> db -> where('es_avaliador', null);
                }
                else{
                        $this -> db -> where('es_avaliador !=', null);
                }
                if($competencia == ''){
                        $this -> db -> where('es_competencia', null);
                }
				else if($competencia == 'todos'){
						$this -> db -> where('es_competencia !=', null);
				}
                else{
                        $this -> db -> where('es_competencia', $competencia);
                }
                
                $this -> db -> select('*');
                $this -> db -> from('tb_notas');
                $query = $this -> db -> get();
                if($query -> num_rows() > 0){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        
        public function create_nota($dados){
                if(isset($dados['competencia']) && strlen($dados['competencia']) > 0){
                        if(isset($dados['avaliador']) && strlen($dados['avaliador']) > 0){
                                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_competencia' => $dados["competencia"],
                                        'es_avaliador' => $dados["avaliador"],
                                        'es_etapa' => $dados["etapa"]
                                );
                        }
                        else{
                                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_competencia' => $dados["competencia"],
                                        'es_etapa' => $dados["etapa"]
                                );
                        }
                }
                else{
                        if(isset($dados['avaliador']) && strlen($dados['avaliador']) > 0){
                                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_avaliador' => $dados["avaliador"],
                                        'es_etapa' => $dados["etapa"]
                                );
                        }
                        else{
                                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_etapa' => $dados["etapa"]
                                );
                        }
                }
                $this -> db -> insert ('tb_notas', $data);
                return $this -> db -> insert_id();                                
        }
        
        public function update_nota($campo,$valor,$primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> where('pr_nota', $primaria);
                $this -> db -> update ('tb_notas');
                return $this -> db -> affected_rows();
        }
}
