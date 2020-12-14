<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos_model extends CI_Model {
        function __construct() {
                parent::__construct();
        }
        public function get_Estados() {
                $Estados = array();
                $this -> db -> select ('pr_uf, ch_sigla');
                $this -> db -> from ('tb_uf');
                $this -> db -> order_by ('ch_sigla', 'ASC');
                $query = $this -> db -> get();
                if ($query -> num_rows() > 0) {
                        $results = $query -> result_array();
                        $Estados = array_column($results, 'ch_sigla', 'pr_uf');
                }
                //$Estados[]=array(0=>'');
                return $Estados;
        }
        public function get_Municipios($id='', $estado='') {
                if(strlen($id) > 0){
                        $this -> db -> select ('m.pr_municipio, m.vc_municipio, u.ch_sigla');
                        $this -> db -> from ('tb_municipios m');
                        $this -> db -> join('tb_uf u', 'u.pr_uf=m.es_uf');
                        $this -> db -> order_by ('m.vc_municipio', 'ASC');
                        $this -> db -> where('m.pr_municipio', $id);
                        $query = $this -> db -> get();
                        if ($query -> num_rows() > 0) {
                                $results = $query -> result_array();
                        }
                }
                if(strlen($estado)>0){
                        $this -> db -> select ('pr_municipio, vc_municipio');
                        $this -> db -> from ('tb_municipios');
                        $this -> db -> order_by ('vc_municipio', 'ASC');
                        $this -> db -> where('es_uf', $estado);
                        $query = $this -> db -> get();
                        if ($query -> num_rows() > 0) {
                                $results = $query -> result_array();
                        }
                }
                return $results;
        }
        public function get_candidatos($id='', $cpf='', $removido=false, $nome='', $email='', $paginacao=0){
                if(strlen($id) > 0){
                        $this -> db -> where('c.pr_candidato', $id);
                }
                if(strlen($cpf) > 0){
                        $this -> db -> where('c.ch_cpf', $cpf);
                }
                if(strlen($nome) > 0){
                        $this -> db -> where("upper(remove_accents(c.vc_nome)) like '%".strtoupper(retira_acentos($nome))."%'");
                }
                if(strlen($email) > 0){
                        $this -> db -> where("c.vc_email like '%{$email}%'");
                }
                if($id == '' && $cpf == ''){
                        $this -> db -> select('c.pr_candidato,c.vc_nome,c.ch_cpf,c.vc_email,c.dt_cadastro,c.bl_removido, u.pr_usuario, u.bl_removido as removido');         
                }
                else{
                        $this -> db -> select('c.*, u.pr_usuario, u.bl_removido as removido, m.vc_municipio, uf.ch_sigla');
                }
                //$this -> db -> select('c.*, u.pr_usuario, u.bl_removido as removido, m.vc_municipio, uf.ch_sigla');
                if($id != '' || $cpf != ''){
                        $this -> db -> join('tb_usuarios u', 'u.es_candidato=c.pr_candidato', 'left');
                        $this -> db -> join('tb_municipios m', 'm.pr_municipio=c.es_municipio', 'left');
                        $this -> db -> join('tb_uf uf', 'uf.pr_uf=m.es_uf', 'left');
                }
                else{
                        $this -> db -> join('tb_usuarios u', 'u.es_candidato=c.pr_candidato', 'left');
                }
                if($removido==false){
                        $this -> db -> where('u.bl_removido', '0');
                }
                $this -> db -> where('u.es_candidato is not null');
                $this -> db -> order_by('c.vc_nome', 'ASC');
                                if($paginacao > 0){
                                                $this -> db -> limit(30, (($paginacao-1)*30));
                                }
                $query = $this -> db -> get('tb_candidatos c');
                if($query -> num_rows() == 1){
                        return $query -> row();
                }
                else if($query -> num_rows() > 1){
                        $resultado = $query -> result();
                        if($id != '' || $cpf != ''){
                                $retorno = $resultado;
                        }
                        else{
                                foreach ($resultado as $linha){
                                        $this -> db -> from('tb_candidaturas');
                                        $this -> db -> where('es_candidato', $linha -> pr_candidato);
                                        $linha -> cont = $this -> db -> count_all_results();
                                        $retorno[] = $linha;
                                }  
                        }
                        
                        //
                        return $retorno;
                }
                else{
                        return NULL;
                }
        }
        public function update_candidato($dados){
                $this -> db -> select ('pr_candidato');
                $this -> db -> from ('tb_candidatos');
                $this -> db -> where('pr_candidato', $dados['codigo']);
                $query = $this -> db -> get();
                if (strlen($dados['codigo']) > 0 && $query -> num_rows() > 0) { //atualizar
                        if(isset($dados['IdentidadeGenero'])){
                                $this -> db -> set ('in_genero', $dados['IdentidadeGenero']);
                        }
                        if(isset($dados['IdentidadeGeneroOptativa'])){
                                $this -> db -> set ('vc_generoOptativo', $dados['IdentidadeGeneroOptativa']);
                        }
                        if(isset($dados['Raca'])){
                                $this -> db -> set ('in_raca', $dados['Raca']);
                        }
                        if(isset($dados['Email'])){
                                $this -> db -> set ('vc_email', $dados['Email']);
                        }
                        if(isset($dados['Telefone'])){
                                $this -> db -> set ('vc_telefone', $dados['Telefone']);
                        }
                        if(isset($dados['TelefoneOpcional'])){
                                $this -> db -> set ('vc_telefoneOpcional', $dados['TelefoneOpcional']);
                        }
                        if(isset($dados['LinkedIn'])){
                                $this -> db -> set ('vc_linkedin', $dados['LinkedIn']);
                        }
                        if(isset($dados['DataNascimento'])){
                                $this -> db -> set ('dt_nascimento', show_sql_date($dados['DataNascimento']));
                        }
                        if(isset($dados['Pais2'])){
                                $this -> db -> set ('vc_pais', $dados['Pais2']);
                        }
                        if(isset($dados['CidadeEstrangeira'])){
                                $this -> db -> set ('vc_cidadeEstrangeira', $dados['CidadeEstrangeira']);
                        }
                        if(isset($dados['CEP'])){
                                $this -> db -> set ('vc_cep', $dados['CEP']);
                        }
                        if(isset($dados['Logradouro'])){
                                $this -> db -> set ('vc_logradouro', $dados['Logradouro']);
                        }
                        if(isset($dados['Numero'])){
                                $this -> db -> set ('vc_numero', $dados['Numero']);
                        }
                        if(isset($dados['Bairro'])){
                                $this -> db -> set ('vc_bairro', $dados['Bairro']);
                        }
                        if(isset($dados['Complemento'])){
                                $this -> db -> set ('vc_complemento', $dados['Complemento']);
                        }
                        if(isset($dados['Municipio'])){
                                $this -> db -> set ('es_municipio', $dados['Municipio']);
                        }
                        if(isset($dados['bl_removido'])){
                                $this -> db -> set ('bl_removido', $dados['bl_removido']);
                        }
                        if(isset($dados['NomeSocial'])){
                                $this -> db -> set ('vc_nomesocial', $dados['NomeSocial']);
                        }
                        //$this -> db -> set ('es_usuarioAlteracao', );
                        $this -> db -> set ('dt_alteracao', date('Y-m-d H:i:s'));
                        $this -> db -> where('pr_candidato', $dados['codigo']);
                        $this -> db -> update ('tb_candidatos');
                        return $this -> db -> affected_rows();
                }
        }
        public function create_candidato($dados){
                $data=array(
                        'vc_nome' => $dados['NomeCompleto'],
                        'vc_nomesocial' => $dados['NomeSocial'],
                        'ch_cpf' => $dados['CPF'],
                        'vc_rg' => $dados['RG'],
                        'vc_orgaoEmissor' => $dados['OrgaoEmissor'],
                        'in_genero' => $dados['IdentidadeGenero'],
                        'vc_generoOptativo' => null,
                        'in_raca' => $dados['Raca'],
                        'vc_email' => $dados['Email'],
                        'vc_telefone' => $dados['Telefone'],
                        'vc_telefoneOpcional' => $dados['TelefoneOpcional'],
                        'vc_linkedin' => $dados['LinkedIn'],
                        'dt_nascimento' => show_sql_date($dados['DataNascimento']),
                        'vc_pais' => 'Brasil',
                        'vc_cidadeEstrangeira' => null,
                        'vc_cep' => $dados['CEP'],
                        'vc_logradouro' => $dados['Logradouro'],
                        'vc_numero' => $dados['Numero'],
                        'vc_bairro' => $dados['Bairro'],
                        'vc_complemento' => $dados['Complemento'],
                        'es_municipio' => $dados['Municipio'],
                        'in_exigenciasComuns' => $dados['Requisitos'],
                        'bl_sentenciado' => $dados['Sentenciado'],
                        'bl_processoDisciplinar' => $dados['ProcessoDisciplinar'],
                        'bl_ajustamentoFuncionalPorDoenca' => $dados['AjustamentoFuncionalPorDoenca'],
                        'bl_aceiteTermo' => $dados['AceiteTermo'],
                        'bl_aceitePrivacidade' => $dados['AceitePrivacidade'],
						'bl_brumadinho' => $dados['Brumadinho'],
                        'dt_cadastro' => date('Y-m-d H:i:s'),
                        'dt_alteracao' => date('Y-m-d H:i:s')
                );
                $this -> db -> insert ('tb_candidatos', $data);
                return $this -> db -> insert_id();

        }
        
        public function delete_candidato($cpf){
                //echo "delete: $primaria<br>";
                if(strlen($cpf)==0){
                        return FALSE;
                }
                $this -> db -> where('ch_cpf', $cpf);
                $this -> db -> delete ('tb_candidatos');
                return $this -> db -> affected_rows();
        }
}
