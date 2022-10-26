<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Candidaturas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_candidaturas($id='', $candidato='', $vaga='', $instituicao='', $status='', $avaliador='', $calendario='', $nome = '', $paginacao=0)
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('c.pr_candidatura', $id);
        }
        if (strlen($candidato) > 0 && $candidato > 0) {
            $this -> db -> where('c.es_candidato', $candidato);
        }
        if (strlen($vaga) > 0 && $vaga > 0) {
            $this -> db -> where('c.es_vaga', $vaga);
        }
        if (strlen($nome) > 0) {
            $this -> db -> where("upper(remove_accents(d.vc_nome)) like '%".strtoupper(retira_acentos($nome))."%'");
        }

        if (strlen($instituicao) > 0 && $instituicao > 0) {
            $this -> db -> where('v.es_instituicao', $instituicao);
        }

        if (stristr($status, ",")) {
            $status= explode(",", $status);
        }

        if (is_array($status)) {
            $this -> db -> where_in('c.es_status', $status);
        } elseif (strlen($status) > 0 && $status > 0) {
            //$this -> db -> where('c.es_status', $status);
            $this -> db -> where('c.es_status', $status);
        } elseif (stristr($status, '<>')) {
            //feito para excluir o valor
            $status=trim(str_replace("<>", "", $status));

            $this -> db -> where('c.es_status <>', $status);
        }
        $this -> db -> where('c.bl_removido', '0');
        if ((strlen($avaliador) > 0 && $avaliador > 0)) {
            $this -> db -> where("(e.es_avaliador1 = {$avaliador} or e.es_avaliador2 = {$avaliador} or e.es_avaliador3 = {$avaliador} or es_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario={$avaliador}))");
        }

        /*if($this -> session -> brumadinho == '1'){
                $this -> db -> where('v.bl_brumadinho', '1');
        }*/

        /*        $this -> db -> select('c.pr_candidatura, c.es_candidato, c.es_vaga, c.dt_candidatura, c.es_status, s.vc_status, v.vc_vaga, v.dt_fim, d.vc_nome, e.*, i.vc_sigla, i.vc_instituicao, c.en_aderencia, c.es_avaliador_competencia1, c.es_avaliador_competencia2');
        }
        else */if ((strlen($avaliador) > 0 && $avaliador > 0) || (strlen($calendario) > 0 && $calendario > 0)) {
            $this -> db -> select('c.dt_realizada,c.en_motivacao,c.en_hbdi,u.vc_nome as avaliador_competencia,c.pr_candidatura, c.es_candidato, c.es_vaga, c.dt_candidatura, c.es_status, s.vc_status, v.vc_vaga, v.dt_fim, d.vc_nome, e.*, i.vc_sigla, i.vc_instituicao, c.en_aderencia, c.dt_aderencia, c.es_avaliador_competencia1, c.es_avaliador_especialista, c.dt_cadastro');
        } else {
            $this -> db -> select('c.dt_realizada,c.en_motivacao,c.en_hbdi,u.vc_nome as avaliador_competencia,c.pr_candidatura, c.es_candidato, c.es_vaga, c.dt_candidatura, c.es_status, s.vc_status, v.vc_vaga, v.dt_fim, d.vc_nome, i.vc_sigla, i.vc_instituicao, c.en_aderencia, c.dt_aderencia, c.es_avaliador_competencia1, c.es_avaliador_especialista, c.tx_expectativa_momento, c.tx_observacoes_momento, c.tx_pontos_fortes, c.tx_pontos_melhorias, c.tx_feedback, c.tx_comentarios, c.dt_cadastro');
        }

        $this -> db -> where('c.bl_removido', '0');
        $this -> db -> from('tb_candidaturas c');
        $this -> db -> join('tb_vagas v', 'c.es_vaga=v.pr_vaga');
        $this -> db -> join('tb_status_candidaturas s', 's.pr_status=c.es_status');
        $this -> db -> join('tb_candidatos d', 'c.es_candidato=d.pr_candidato');
        $this -> db -> join('tb_instituicoes2 i', 'v.es_instituicao=i.pr_instituicao');
        $this -> db -> join('tb_usuarios u', 'c.es_avaliador_curriculo=u.pr_usuario', 'left');
        if ((strlen($avaliador) > 0 && $avaliador > 0) || (strlen($calendario) > 0 && $calendario > 0)) {
            $this -> db -> join('tb_entrevistas e', 'c.pr_candidatura=e.es_candidatura', 'left');
        }
        $this->db->order_by('c.pr_candidatura', 'DESC');

        if ($paginacao > 0) {
            $this -> db -> limit(30, (($paginacao-1)*30));
        }
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }
    public function update_candidatura($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_candidatura', $primaria);
        $this -> db -> update('tb_candidaturas');
        return $this -> db -> affected_rows();
    }
    public function create_candidatura($dados)
    {
        $data=array(
                        'es_candidato' => $this -> session -> candidato,
                        'es_vaga' => $dados['Vaga'],
                        'es_status' => 1,
                        'dt_cadastro' => date('Y-m-d H:i:s'),
                        'dt_candidatura' => date('Y-m-d H:i:s')
                );
        $this -> db -> insert('tb_candidaturas', $data);
        return $this -> db -> insert_id();
    }

    public function atualiza_hbdi($dados)
    {
        if (!isset($dados['MotivacaoTrabalho1'])||strlen($dados['MotivacaoTrabalho1']) == 0) {
            $dados['MotivacaoTrabalho1'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho2'])||strlen($dados['MotivacaoTrabalho2']) == 0) {
            $dados['MotivacaoTrabalho2'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho3'])||strlen($dados['MotivacaoTrabalho3']) == 0) {
            $dados['MotivacaoTrabalho3'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho4'])||strlen($dados['MotivacaoTrabalho4']) == 0) {
            $dados['MotivacaoTrabalho4'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho5'])||strlen($dados['MotivacaoTrabalho5']) == 0) {
            $dados['MotivacaoTrabalho5'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho6'])||strlen($dados['MotivacaoTrabalho6']) == 0) {
            $dados['MotivacaoTrabalho6'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho7'])||strlen($dados['MotivacaoTrabalho7']) == 0) {
            $dados['MotivacaoTrabalho7'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho8'])||strlen($dados['MotivacaoTrabalho8']) == 0) {
            $dados['MotivacaoTrabalho8'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho9'])||strlen($dados['MotivacaoTrabalho9']) == 0) {
            $dados['MotivacaoTrabalho9'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho10'])||strlen($dados['MotivacaoTrabalho10']) == 0) {
            $dados['MotivacaoTrabalho10'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho11'])||strlen($dados['MotivacaoTrabalho11']) == 0) {
            $dados['MotivacaoTrabalho11'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho12'])||strlen($dados['MotivacaoTrabalho12']) == 0) {
            $dados['MotivacaoTrabalho12'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho13'])||strlen($dados['MotivacaoTrabalho13']) == 0) {
            $dados['MotivacaoTrabalho13'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho14'])||strlen($dados['MotivacaoTrabalho14']) == 0) {
            $dados['MotivacaoTrabalho14'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho15'])||strlen($dados['MotivacaoTrabalho15']) == 0) {
            $dados['MotivacaoTrabalho15'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho16'])||strlen($dados['MotivacaoTrabalho16']) == 0) {
            $dados['MotivacaoTrabalho16'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho17'])||strlen($dados['MotivacaoTrabalho17']) == 0) {
            $dados['MotivacaoTrabalho17'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho18'])||strlen($dados['MotivacaoTrabalho18']) == 0) {
            $dados['MotivacaoTrabalho18'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho19'])||strlen($dados['MotivacaoTrabalho19']) == 0) {
            $dados['MotivacaoTrabalho19'] = null;
        }
        if (!isset($dados['MotivacaoTrabalho20'])||strlen($dados['MotivacaoTrabalho20']) == 0) {
            $dados['MotivacaoTrabalho20'] = null;
        }
        if (!isset($dados['Gosto1'])||strlen($dados['Gosto1']) == 0) {
            $dados['Gosto1'] = null;
        }
        if (!isset($dados['Gosto2'])||strlen($dados['Gosto2']) == 0) {
            $dados['Gosto2'] = null;
        }
        if (!isset($dados['Gosto3'])||strlen($dados['Gosto3']) == 0) {
            $dados['Gosto3'] = null;
        }
        if (!isset($dados['Gosto4'])||strlen($dados['Gosto4']) == 0) {
            $dados['Gosto4'] = null;
        }
        if (!isset($dados['Gosto5'])||strlen($dados['Gosto5']) == 0) {
            $dados['Gosto5'] = null;
        }
        if (!isset($dados['Gosto6'])||strlen($dados['Gosto6']) == 0) {
            $dados['Gosto6'] = null;
        }
        if (!isset($dados['Gosto7'])||strlen($dados['Gosto7']) == 0) {
            $dados['Gosto7'] = null;
        }
        if (!isset($dados['Gosto8'])||strlen($dados['Gosto8']) == 0) {
            $dados['Gosto8'] = null;
        }
        if (!isset($dados['Gosto9'])||strlen($dados['Gosto9']) == 0) {
            $dados['Gosto9'] = null;
        }
        if (!isset($dados['Gosto10'])||strlen($dados['Gosto10']) == 0) {
            $dados['Gosto10'] = null;
        }
        if (!isset($dados['Gosto11'])||strlen($dados['Gosto11']) == 0) {
            $dados['Gosto11'] = null;
        }
        if (!isset($dados['Gosto12'])||strlen($dados['Gosto12']) == 0) {
            $dados['Gosto12'] = null;
        }
        if (!isset($dados['Gosto13'])||strlen($dados['Gosto13']) == 0) {
            $dados['Gosto13'] = null;
        }
        if (!isset($dados['Gosto14'])||strlen($dados['Gosto14']) == 0) {
            $dados['Gosto14'] = null;
        }
        if (!isset($dados['Gosto15'])||strlen($dados['Gosto15']) == 0) {
            $dados['Gosto15'] = null;
        }
        if (!isset($dados['Gosto16'])||strlen($dados['Gosto16']) == 0) {
            $dados['Gosto16'] = null;
        }
        if (!isset($dados['Gosto17'])||strlen($dados['Gosto17']) == 0) {
            $dados['Gosto17'] = null;
        }
        if (!isset($dados['Gosto18'])||strlen($dados['Gosto18']) == 0) {
            $dados['Gosto18'] = null;
        }
        if (!isset($dados['Gosto19'])||strlen($dados['Gosto19']) == 0) {
            $dados['Gosto19'] = null;
        }
        if (!isset($dados['Gosto20'])||strlen($dados['Gosto20']) == 0) {
            $dados['Gosto20'] = null;
        }
        if (!isset($dados['Prefiro1'])||strlen($dados['Prefiro1']) == 0) {
            $dados['Prefiro1'] = null;
        }
        if (!isset($dados['Prefiro2'])||strlen($dados['Prefiro2']) == 0) {
            $dados['Prefiro2'] = null;
        }
        if (!isset($dados['Prefiro3'])||strlen($dados['Prefiro3']) == 0) {
            $dados['Prefiro3'] = null;
        }
        if (!isset($dados['Prefiro4'])||strlen($dados['Prefiro4']) == 0) {
            $dados['Prefiro4'] = null;
        }
        if (!isset($dados['Prefiro5'])||strlen($dados['Prefiro5']) == 0) {
            $dados['Prefiro5'] = null;
        }
        if (!isset($dados['Prefiro6'])||strlen($dados['Prefiro6']) == 0) {
            $dados['Prefiro6'] = null;
        }
        if (!isset($dados['Prefiro7'])||strlen($dados['Prefiro7']) == 0) {
            $dados['Prefiro7'] = null;
        }
        if (!isset($dados['Prefiro8'])||strlen($dados['Prefiro8']) == 0) {
            $dados['Prefiro8'] = null;
        }
        if (!isset($dados['Prefiro9'])||strlen($dados['Prefiro9']) == 0) {
            $dados['Prefiro9'] = null;
        }
        if (!isset($dados['Prefiro10'])||strlen($dados['Prefiro10']) == 0) {
            $dados['Prefiro10'] = null;
        }
        if (!isset($dados['Prefiro11'])||strlen($dados['Prefiro11']) == 0) {
            $dados['Prefiro11'] = null;
        }
        if (!isset($dados['Prefiro12'])||strlen($dados['Prefiro12']) == 0) {
            $dados['Prefiro12'] = null;
        }
        if (!isset($dados['Prefiro13'])||strlen($dados['Prefiro13']) == 0) {
            $dados['Prefiro13'] = null;
        }
        if (!isset($dados['Prefiro14'])||strlen($dados['Prefiro14']) == 0) {
            $dados['Prefiro14'] = null;
        }
        if (!isset($dados['Prefiro15'])||strlen($dados['Prefiro15']) == 0) {
            $dados['Prefiro15'] = null;
        }
        if (!isset($dados['Prefiro16'])||strlen($dados['Prefiro16']) == 0) {
            $dados['Prefiro16'] = null;
        }
        if (!isset($dados['Prefiro17'])||strlen($dados['Prefiro17']) == 0) {
            $dados['Prefiro17'] = null;
        }
        if (!isset($dados['Prefiro18'])||strlen($dados['Prefiro18']) == 0) {
            $dados['Prefiro18'] = null;
        }
        if (!isset($dados['Prefiro19'])||strlen($dados['Prefiro19']) == 0) {
            $dados['Prefiro19'] = null;
        }
        if (!isset($dados['Prefiro20'])||strlen($dados['Prefiro20']) == 0) {
            $dados['Prefiro20'] = null;
        }
        if (!isset($dados['Pergunta'])||strlen($dados['Pergunta']) == 0) {
            $dados['Pergunta'] = null;
        }
        if (!isset($dados['Fazer1'])||strlen($dados['Fazer1']) == 0) {
            $dados['Fazer1'] = null;
        }
        if (!isset($dados['Fazer2'])||strlen($dados['Fazer2']) == 0) {
            $dados['Fazer2'] = null;
        }
        if (!isset($dados['Fazer3'])||strlen($dados['Fazer3']) == 0) {
            $dados['Fazer3'] = null;
        }
        if (!isset($dados['Fazer4'])||strlen($dados['Fazer4']) == 0) {
            $dados['Fazer4'] = null;
        }
        if (!isset($dados['Fazer5'])||strlen($dados['Fazer5']) == 0) {
            $dados['Fazer5'] = null;
        }
        if (!isset($dados['Fazer6'])||strlen($dados['Fazer6']) == 0) {
            $dados['Fazer6'] = null;
        }
        if (!isset($dados['Fazer7'])||strlen($dados['Fazer7']) == 0) {
            $dados['Fazer7'] = null;
        }
        if (!isset($dados['Fazer8'])||strlen($dados['Fazer8']) == 0) {
            $dados['Fazer8'] = null;
        }
        if (!isset($dados['Fazer9'])||strlen($dados['Fazer9']) == 0) {
            $dados['Fazer9'] = null;
        }
        if (!isset($dados['Fazer10'])||strlen($dados['Fazer10']) == 0) {
            $dados['Fazer10'] = null;
        }
        if (!isset($dados['Fazer11'])||strlen($dados['Fazer11']) == 0) {
            $dados['Fazer11'] = null;
        }
        if (!isset($dados['Fazer12'])||strlen($dados['Fazer12']) == 0) {
            $dados['Fazer12'] = null;
        }
        if (!isset($dados['Fazer13'])||strlen($dados['Fazer13']) == 0) {
            $dados['Fazer13'] = null;
        }
        if (!isset($dados['Fazer14'])||strlen($dados['Fazer14']) == 0) {
            $dados['Fazer14'] = null;
        }
        if (!isset($dados['Fazer15'])||strlen($dados['Fazer15']) == 0) {
            $dados['Fazer15'] = null;
        }
        if (!isset($dados['Fazer16'])||strlen($dados['Fazer16']) == 0) {
            $dados['Fazer16'] = null;
        }
        if (!isset($dados['Comprar1'])||strlen($dados['Comprar1']) == 0) {
            $dados['Comprar1'] = null;
        }
        if (!isset($dados['Comprar2'])||strlen($dados['Comprar2']) == 0) {
            $dados['Comprar2'] = null;
        }
        if (!isset($dados['Comprar3'])||strlen($dados['Comprar3']) == 0) {
            $dados['Comprar3'] = null;
        }
        if (!isset($dados['Comprar4'])||strlen($dados['Comprar4']) == 0) {
            $dados['Comprar4'] = null;
        }
        if (!isset($dados['Comprar5'])||strlen($dados['Comprar5']) == 0) {
            $dados['Comprar5'] = null;
        }
        if (!isset($dados['Comprar6'])||strlen($dados['Comprar6']) == 0) {
            $dados['Comprar6'] = null;
        }
        if (!isset($dados['Comprar7'])||strlen($dados['Comprar7']) == 0) {
            $dados['Comprar7'] = null;
        }
        if (!isset($dados['Comprar8'])||strlen($dados['Comprar8']) == 0) {
            $dados['Comprar8'] = null;
        }
        if (!isset($dados['Comprar9'])||strlen($dados['Comprar9']) == 0) {
            $dados['Comprar9'] = null;
        }
        if (!isset($dados['Comprar10'])||strlen($dados['Comprar10']) == 0) {
            $dados['Comprar10'] = null;
        }
        if (!isset($dados['Comprar11'])||strlen($dados['Comprar11']) == 0) {
            $dados['Comprar11'] = null;
        }
        if (!isset($dados['Comprar12'])||strlen($dados['Comprar12']) == 0) {
            $dados['Comprar12'] = null;
        }
        if (!isset($dados['Comprar13'])||strlen($dados['Comprar13']) == 0) {
            $dados['Comprar13'] = null;
        }
        if (!isset($dados['Comprar14'])||strlen($dados['Comprar14']) == 0) {
            $dados['Comprar14'] = null;
        }
        if (!isset($dados['Comprar15'])||strlen($dados['Comprar15']) == 0) {
            $dados['Comprar15'] = null;
        }
        if (!isset($dados['Comprar16'])||strlen($dados['Comprar16']) == 0) {
            $dados['Comprar16'] = null;
        }
        if (!isset($dados['Comprar17'])||strlen($dados['Comprar17']) == 0) {
            $dados['Comprar17'] = null;
        }
        if (!isset($dados['Comprar18'])||strlen($dados['Comprar18']) == 0) {
            $dados['Comprar18'] = null;
        }
        if (!isset($dados['Comprar19'])||strlen($dados['Comprar19']) == 0) {
            $dados['Comprar19'] = null;
        }
        if (!isset($dados['Comprar20'])||strlen($dados['Comprar20']) == 0) {
            $dados['Comprar20'] = null;
        }
        if (!isset($dados['Comportamento'])||strlen($dados['Comportamento']) == 0) {
            $dados['Comportamento'] = null;
        }
        if (!isset($dados['Estilo1'])||strlen($dados['Estilo1']) == 0) {
            $dados['Estilo1'] = null;
        }
        if (!isset($dados['Estilo2'])||strlen($dados['Estilo2']) == 0) {
            $dados['Estilo2'] = null;
        }
        if (!isset($dados['Estilo3'])||strlen($dados['Estilo3']) == 0) {
            $dados['Estilo3'] = null;
        }
        if (!isset($dados['Estilo4'])||strlen($dados['Estilo4']) == 0) {
            $dados['Estilo4'] = null;
        }
        if (!isset($dados['Estilo5'])||strlen($dados['Estilo5']) == 0) {
            $dados['Estilo5'] = null;
        }
        if (!isset($dados['Estilo6'])||strlen($dados['Estilo6']) == 0) {
            $dados['Estilo6'] = null;
        }
        if (!isset($dados['Estilo7'])||strlen($dados['Estilo7']) == 0) {
            $dados['Estilo7'] = null;
        }
        if (!isset($dados['Estilo8'])||strlen($dados['Estilo8']) == 0) {
            $dados['Estilo8'] = null;
        }
        if (!isset($dados['Estilo9'])||strlen($dados['Estilo9']) == 0) {
            $dados['Estilo9'] = null;
        }
        if (!isset($dados['Estilo10'])||strlen($dados['Estilo10']) == 0) {
            $dados['Estilo10'] = null;
        }
        if (!isset($dados['Estilo11'])||strlen($dados['Estilo11']) == 0) {
            $dados['Estilo11'] = null;
        }
        if (!isset($dados['Estilo12'])||strlen($dados['Estilo12']) == 0) {
            $dados['Estilo12'] = null;
        }
        if (!isset($dados['Estilo13'])||strlen($dados['Estilo13']) == 0) {
            $dados['Estilo13'] = null;
        }
        if (!isset($dados['Estilo14'])||strlen($dados['Estilo14']) == 0) {
            $dados['Estilo14'] = null;
        }
        if (!isset($dados['Estilo15'])||strlen($dados['Estilo15']) == 0) {
            $dados['Estilo15'] = null;
        }
        if (!isset($dados['Estilo16'])||strlen($dados['Estilo16']) == 0) {
            $dados['Estilo16'] = null;
        }
        if (!isset($dados['PontoFraco1'])||strlen($dados['PontoFraco1']) == 0) {
            $dados['PontoFraco1'] = null;
        }
        if (!isset($dados['PontoFraco2'])||strlen($dados['PontoFraco2']) == 0) {
            $dados['PontoFraco2'] = null;
        }
        if (!isset($dados['PontoFraco3'])||strlen($dados['PontoFraco3']) == 0) {
            $dados['PontoFraco3'] = null;
        }
        if (!isset($dados['PontoFraco4'])||strlen($dados['PontoFraco4']) == 0) {
            $dados['PontoFraco4'] = null;
        }
        if (!isset($dados['PontoFraco5'])||strlen($dados['PontoFraco5']) == 0) {
            $dados['PontoFraco5'] = null;
        }
        if (!isset($dados['PontoFraco6'])||strlen($dados['PontoFraco6']) == 0) {
            $dados['PontoFraco6'] = null;
        }
        if (!isset($dados['PontoFraco7'])||strlen($dados['PontoFraco7']) == 0) {
            $dados['PontoFraco7'] = null;
        }
        if (!isset($dados['PontoFraco8'])||strlen($dados['PontoFraco8']) == 0) {
            $dados['PontoFraco8'] = null;
        }
        if (!isset($dados['PontoFraco9'])||strlen($dados['PontoFraco9']) == 0) {
            $dados['PontoFraco9'] = null;
        }
        if (!isset($dados['PontoFraco10'])||strlen($dados['PontoFraco10']) == 0) {
            $dados['PontoFraco10'] = null;
        }
        if (!isset($dados['PontoFraco11'])||strlen($dados['PontoFraco11']) == 0) {
            $dados['PontoFraco11'] = null;
        }
        if (!isset($dados['PontoFraco12'])||strlen($dados['PontoFraco12']) == 0) {
            $dados['PontoFraco12'] = null;
        }
        if (!isset($dados['PontoFraco13'])||strlen($dados['PontoFraco13']) == 0) {
            $dados['PontoFraco13'] = null;
        }
        if (!isset($dados['PontoFraco14'])||strlen($dados['PontoFraco14']) == 0) {
            $dados['PontoFraco14'] = null;
        }
        if (!isset($dados['PontoFraco15'])||strlen($dados['PontoFraco15']) == 0) {
            $dados['PontoFraco15'] = null;
        }
        if (!isset($dados['PontoFraco16'])||strlen($dados['PontoFraco16']) == 0) {
            $dados['PontoFraco16'] = null;
        }
        if (!isset($dados['PontoFraco17'])||strlen($dados['PontoFraco17']) == 0) {
            $dados['PontoFraco17'] = null;
        }
        if (!isset($dados['PontoFraco18'])||strlen($dados['PontoFraco18']) == 0) {
            $dados['PontoFraco18'] = null;
        }
        if (!isset($dados['PontoFraco19'])||strlen($dados['PontoFraco19']) == 0) {
            $dados['PontoFraco19'] = null;
        }
        if (!isset($dados['PontoFraco20'])||strlen($dados['PontoFraco20']) == 0) {
            $dados['PontoFraco20'] = null;
        }
        if (!isset($dados['Resolver'])||strlen($dados['Resolver']) == 0) {
            $dados['Resolver'] = null;
        }
        if (!isset($dados['Procuro'])||strlen($dados['Procuro']) == 0) {
            $dados['Procuro'] = null;
        }
        if (!isset($dados['Frase1'])||strlen($dados['Frase1']) == 0) {
            $dados['Frase1'] = null;
        }
        if (!isset($dados['Frase2'])||strlen($dados['Frase2']) == 0) {
            $dados['Frase2'] = null;
        }
        if (!isset($dados['Frase3'])||strlen($dados['Frase3']) == 0) {
            $dados['Frase3'] = null;
        }
        if (!isset($dados['Frase4'])||strlen($dados['Frase4']) == 0) {
            $dados['Frase4'] = null;
        }
        if (!isset($dados['Frase5'])||strlen($dados['Frase5']) == 0) {
            $dados['Frase5'] = null;
        }
        //echo $dados['Frase6']."Frase6";
        if (!isset($dados['Frase6'])||strlen($dados['Frase6']) == 0) {
            $dados['Frase6'] = null;
        }
        //echo $dados['Frase6']."Frase6";
        if (!isset($dados['Frase7'])||strlen($dados['Frase7']) == 0) {
            $dados['Frase7'] = null;
        }
        if (!isset($dados['Frase8'])||strlen($dados['Frase8']) == 0) {
            $dados['Frase8'] = null;
        }
        if (!isset($dados['Frase9'])||strlen($dados['Frase9']) == 0) {
            $dados['Frase9'] = null;
        }
        if (!isset($dados['Frase10'])||strlen($dados['Frase10']) == 0) {
            $dados['Frase10'] = null;
        }
        if (!isset($dados['Frase11'])||strlen($dados['Frase11']) == 0) {
            $dados['Frase11'] = null;
        }
        if (!isset($dados['Frase12'])||strlen($dados['Frase12']) == 0) {
            $dados['Frase12'] = null;
        }
        $data=array(
                        'es_candidatura' => $dados['candidatura'],
                        'dt_hbdi' => date('Y-m-d H:i:s'),
                        'bl_motivacao_trabalho1' => $dados['MotivacaoTrabalho1'],
                        'bl_motivacao_trabalho2' => $dados['MotivacaoTrabalho2'],
                        'bl_motivacao_trabalho3' => $dados['MotivacaoTrabalho3'],
                        'bl_motivacao_trabalho4' => $dados['MotivacaoTrabalho4'],
                        'bl_motivacao_trabalho5' => $dados['MotivacaoTrabalho5'],
                        'bl_motivacao_trabalho6' => $dados['MotivacaoTrabalho6'],
                        'bl_motivacao_trabalho7' => $dados['MotivacaoTrabalho7'],
                        'bl_motivacao_trabalho8' => $dados['MotivacaoTrabalho8'],
                        'bl_motivacao_trabalho9' => $dados['MotivacaoTrabalho9'],
                        'bl_motivacao_trabalho10' => $dados['MotivacaoTrabalho10'],
                        'bl_motivacao_trabalho11' => $dados['MotivacaoTrabalho11'],
                        'bl_motivacao_trabalho12' => $dados['MotivacaoTrabalho12'],
                        'bl_motivacao_trabalho13' => $dados['MotivacaoTrabalho13'],
                        'bl_motivacao_trabalho14' => $dados['MotivacaoTrabalho14'],
                        'bl_motivacao_trabalho15' => $dados['MotivacaoTrabalho15'],
                        'bl_motivacao_trabalho16' => $dados['MotivacaoTrabalho16'],
                        'bl_motivacao_trabalho17' => $dados['MotivacaoTrabalho17'],
                        'bl_motivacao_trabalho18' => $dados['MotivacaoTrabalho18'],
                        'bl_motivacao_trabalho19' => $dados['MotivacaoTrabalho19'],
                        'bl_motivacao_trabalho20' => $dados['MotivacaoTrabalho20'],
                        'bl_gosto1' => $dados['Gosto1'],
                        'bl_gosto2' => $dados['Gosto2'],
                        'bl_gosto3' => $dados['Gosto3'],
                        'bl_gosto4' => $dados['Gosto4'],
                        'bl_gosto5' => $dados['Gosto5'],
                        'bl_gosto6' => $dados['Gosto6'],
                        'bl_gosto7' => $dados['Gosto7'],
                        'bl_gosto8' => $dados['Gosto8'],
                        'bl_gosto9' => $dados['Gosto9'],
                        'bl_gosto10' => $dados['Gosto10'],
                        'bl_gosto11' => $dados['Gosto11'],
                        'bl_gosto12' => $dados['Gosto12'],
                        'bl_gosto13' => $dados['Gosto13'],
                        'bl_gosto14' => $dados['Gosto14'],
                        'bl_gosto15' => $dados['Gosto15'],
                        'bl_gosto16' => $dados['Gosto16'],
                        'bl_gosto17' => $dados['Gosto17'],
                        'bl_gosto18' => $dados['Gosto18'],
                        'bl_gosto19' => $dados['Gosto19'],
                        'bl_gosto20' => $dados['Gosto20'],
                        'bl_prefiro1' => $dados['Prefiro1'],
                        'bl_prefiro2' => $dados['Prefiro2'],
                        'bl_prefiro3' => $dados['Prefiro3'],
                        'bl_prefiro4' => $dados['Prefiro4'],
                        'bl_prefiro5' => $dados['Prefiro5'],
                        'bl_prefiro6' => $dados['Prefiro6'],
                        'bl_prefiro7' => $dados['Prefiro7'],
                        'bl_prefiro8' => $dados['Prefiro8'],
                        'bl_prefiro9' => $dados['Prefiro9'],
                        'bl_prefiro10' => $dados['Prefiro10'],
                        'bl_prefiro11' => $dados['Prefiro11'],
                        'bl_prefiro12' => $dados['Prefiro12'],
                        'bl_prefiro13' => $dados['Prefiro13'],
                        'bl_prefiro14' => $dados['Prefiro14'],
                        'bl_prefiro15' => $dados['Prefiro15'],
                        'bl_prefiro16' => $dados['Prefiro16'],
                        'bl_prefiro17' => $dados['Prefiro17'],
                        'bl_prefiro18' => $dados['Prefiro18'],
                        'bl_prefiro19' => $dados['Prefiro19'],
                        'bl_prefiro20' => $dados['Prefiro20'],
                        'in_pergunta' => $dados['Pergunta'],
                        'bl_fazer1' => $dados['Fazer1'],
                        'bl_fazer2' => $dados['Fazer2'],
                        'bl_fazer3' => $dados['Fazer3'],
                        'bl_fazer4' => $dados['Fazer4'],
                        'bl_fazer5' => $dados['Fazer5'],
                        'bl_fazer6' => $dados['Fazer6'],
                        'bl_fazer7' => $dados['Fazer7'],
                        'bl_fazer8' => $dados['Fazer8'],
                        'bl_fazer9' => $dados['Fazer9'],
                        'bl_fazer10' => $dados['Fazer10'],
                        'bl_fazer11' => $dados['Fazer11'],
                        'bl_fazer12' => $dados['Fazer12'],
                        'bl_fazer13' => $dados['Fazer13'],
                        'bl_fazer14' => $dados['Fazer14'],
                        'bl_fazer15' => $dados['Fazer15'],
                        'bl_fazer16' => $dados['Fazer16'],
                        'bl_comprar1' => $dados['Comprar1'],
                        'bl_comprar2' => $dados['Comprar2'],
                        'bl_comprar3' => $dados['Comprar3'],
                        'bl_comprar4' => $dados['Comprar4'],
                        'bl_comprar5' => $dados['Comprar5'],
                        'bl_comprar6' => $dados['Comprar6'],
                        'bl_comprar7' => $dados['Comprar7'],
                        'bl_comprar8' => $dados['Comprar8'],
                        'bl_comprar9' => $dados['Comprar9'],
                        'bl_comprar10' => $dados['Comprar10'],
                        'bl_comprar11' => $dados['Comprar11'],
                        'bl_comprar12' => $dados['Comprar12'],
                        'bl_comprar13' => $dados['Comprar13'],
                        'bl_comprar14' => $dados['Comprar14'],
                        'bl_comprar15' => $dados['Comprar15'],
                        'bl_comprar16' => $dados['Comprar16'],
                        'bl_comprar17' => $dados['Comprar17'],
                        'bl_comprar18' => $dados['Comprar18'],
                        'bl_comprar19' => $dados['Comprar19'],
                        'bl_comprar20' => $dados['Comprar20'],
                        'in_comportamento' => $dados['Comportamento'],
                        'bl_estilo1' => $dados['Estilo1'],
                        'bl_estilo2' => $dados['Estilo2'],
                        'bl_estilo3' => $dados['Estilo3'],
                        'bl_estilo4' => $dados['Estilo4'],
                        'bl_estilo5' => $dados['Estilo5'],
                        'bl_estilo6' => $dados['Estilo6'],
                        'bl_estilo7' => $dados['Estilo7'],
                        'bl_estilo8' => $dados['Estilo8'],
                        'bl_estilo9' => $dados['Estilo9'],
                        'bl_estilo10' => $dados['Estilo10'],
                        'bl_estilo11' => $dados['Estilo11'],
                        'bl_estilo12' => $dados['Estilo12'],
                        'bl_estilo13' => $dados['Estilo13'],
                        'bl_estilo14' => $dados['Estilo14'],
                        'bl_estilo15' => $dados['Estilo15'],
                        'bl_estilo16' => $dados['Estilo16'],
                        'bl_ponto_fraco1' => $dados['PontoFraco1'],
                        'bl_ponto_fraco2' => $dados['PontoFraco2'],
                        'bl_ponto_fraco3' => $dados['PontoFraco3'],
                        'bl_ponto_fraco4' => $dados['PontoFraco4'],
                        'bl_ponto_fraco5' => $dados['PontoFraco5'],
                        'bl_ponto_fraco6' => $dados['PontoFraco6'],
                        'bl_ponto_fraco7' => $dados['PontoFraco7'],
                        'bl_ponto_fraco8' => $dados['PontoFraco8'],
                        'bl_ponto_fraco9' => $dados['PontoFraco9'],
                        'bl_ponto_fraco10' => $dados['PontoFraco10'],
                        'bl_ponto_fraco11' => $dados['PontoFraco11'],
                        'bl_ponto_fraco12' => $dados['PontoFraco12'],
                        'bl_ponto_fraco13' => $dados['PontoFraco13'],
                        'bl_ponto_fraco14' => $dados['PontoFraco14'],
                        'bl_ponto_fraco15' => $dados['PontoFraco15'],
                        'bl_ponto_fraco16' => $dados['PontoFraco16'],
                        'bl_ponto_fraco17' => $dados['PontoFraco17'],
                        'bl_ponto_fraco18' => $dados['PontoFraco18'],
                        'bl_ponto_fraco19' => $dados['PontoFraco19'],
                        'bl_ponto_fraco20' => $dados['PontoFraco20'],
                        'in_resolver' => $dados['Resolver'],
                        'in_procuro' => $dados['Procuro'],
                        'bl_frase1' => $dados['Frase1'],
                        'bl_frase2' => $dados['Frase2'],
                        'bl_frase3' => $dados['Frase3'],
                        'bl_frase4' => $dados['Frase4'],
                        'bl_frase5' => $dados['Frase5'],
                        'bl_frase6' => $dados['Frase6'],
                        'bl_frase7' => $dados['Frase7'],
                        'bl_frase8' => $dados['Frase8'],
                        'bl_frase9' => $dados['Frase9'],
                        'bl_frase10' => $dados['Frase10'],
                        'bl_frase11' => $dados['Frase11'],
                        'bl_frase12' => $dados['Frase12'],
                );
        $this -> db -> replace('tb_hbdi', $data);
        //echo $this -> db -> last_query();
        return $this -> db -> insert_id();
    }

    public function get_hbdi($candidatura)
    {
        $this -> db -> where('es_candidatura', $candidatura);

        $this -> db -> select('*');
        $this -> db -> from('tb_hbdi');

        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> row();
        } else {
            return null;
        }
    }
    public function salvar_resposta($dados, $questao)
    {
        //var_dump($dados);
        if (isset($dados['avaliador']) && strlen($dados['avaliador']) > 0) {
            $data=array(
                                'es_candidatura' => $dados['candidatura'],
                                'es_questao' => $questao,
                                'es_avaliador' => $dados['avaliador'],
                                'tx_resposta' => $dados["Questao{$questao}"],
                                'dt_resposta' => date('Y-m-d H:i:s')
                        );
        } else {
            $data=array(
                                'es_candidatura' => $dados['candidatura'],
                                'es_questao' => $questao,
                                'tx_resposta' => $dados["Questao{$questao}"],
                                'dt_resposta' => date('Y-m-d H:i:s')
                        );
        }
        $this -> db -> insert('tb_respostas', $data);
        return $this -> db -> insert_id();
    }
    public function update_resposta($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_resposta', $primaria);
        $this -> db -> update('tb_respostas');
        return $this -> db -> affected_rows();
    }

    public function delete_resposta($id)
    {
        //echo "delete: $primaria<br>";
        if (strlen($id)==0&&strlen($id)==0) {
            return false;
        }

        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_resposta', $id);
        }

        $this -> db -> delete('tb_respostas');

        return $this -> db -> affected_rows();
    }

    public function get_status($avaliador=0)
    {
        $this -> db -> select('*');
        $this -> db -> from('tb_status_candidaturas');
        if ($avaliador != 0) {
            $this -> db -> where('pr_status <>', 5);
        }
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }
    public function get_entrevistas($id='', $candidatura='', $tipo_entrevista='')
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('e.pr_entrevista', $id);
        }
        if (strlen($candidatura) > 0) {
            $this -> db -> where('e.es_candidatura', $candidatura);
        }
        if (strlen($tipo_entrevista) > 0) {
            $this -> db -> where('e.bl_tipo_entrevista', $tipo_entrevista);
        }
        $this -> db -> select('e.*, c.vc_nome as nome_candidato,c.vc_email as email_candidato, u1.vc_email as email1, u1.vc_nome as nome1, u2.vc_email as email2, u2.vc_nome as nome2');
        $this -> db -> from('tb_entrevistas e');
        $this -> db -> join('tb_usuarios u1', 'e.es_avaliador1=u1.pr_usuario');
        $this -> db -> join('tb_usuarios u2', 'e.es_avaliador2=u2.pr_usuario', 'left');
        //$this -> db -> join('tb_usuarios u3', 'e.es_avaliador3=u3.pr_usuario','left');
        $this -> db -> join('tb_candidaturas ca', 'e.es_candidatura=ca.pr_candidatura');
        $this -> db -> join('tb_candidatos c', 'ca.es_candidato=c.pr_candidato');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }
    public function atualiza_entrevista($dados)
    {
        //var_dump($dados);
        if (isset($dados['avaliador2']) && strlen($dados['avaliador2']) >0) {
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
        } else {
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
        $this -> db -> replace('tb_entrevistas', $data);
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
    public function create_formacao($dados, $id)
    {
        if (!($dados["cargahoraria{$id}"])>0) {
            $dados["cargahoraria{$id}"] = null;
        }
        /*
        'se_conclusao' => $dados["semestre_conclusao{$id}"],
        'me_conclusao' => $dados["mes_conclusao{$id}"],
        */
        if (isset($dados["candidatura{$id}"]) && strlen($dados["candidatura{$id}"])>0) {
            if (isset($dados["codigo_formacao_pai{$id}"]) && strlen($dados["codigo_formacao_pai{$id}"])>0) {
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
            } else {
                //duplica a formação na candidatura para gerar automaticamente os dados nos dados pessoais
                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'vc_curso' => $dados["curso{$id}"],
                                        'en_tipo' => $dados["tipo{$id}"],
                                        'vc_instituicao' => $dados["instituicao{$id}"],
                                        'dt_conclusao' => $dados["conclusao{$id}"],

                                        'in_cargahoraria' => $dados["cargahoraria{$id}"],
                                );
                $this -> db -> insert('tb_formacao', $data);
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
        } else {
            $data=array(
                                'es_candidato' => $this -> session -> candidato,
                                'vc_curso' => $dados["curso{$id}"],
                                'en_tipo' => $dados["tipo{$id}"],
                                'vc_instituicao' => $dados["instituicao{$id}"],
                                'dt_conclusao' => $dados["conclusao{$id}"],

                                'in_cargahoraria' => $dados["cargahoraria{$id}"],
                        );
        }
        $this -> db -> insert('tb_formacao', $data);
        //echo $this -> db -> last_query();
        return $this -> db -> insert_id();
    }

    public function update_formacao($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_formacao', $primaria);
        $this -> db -> update('tb_formacao');
        return $this -> db -> affected_rows();
    }



    public function delete_formacao($id)
    {
        //echo "delete: $primaria<br>";
        if (strlen($id)==0&&strlen($id)==0) {
            return false;
        }


        if (strlen($id) > 0 && $id > 0) {
            //$this ->delete_formacao_candidatura($id);
            $this -> db -> where('pr_formacao', $id);
        }

        $this -> db -> delete('tb_formacao');

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

    public function get_formacao($id='', $candidato='', $candidatura='')
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_formacao', $id);
        }
        if (strlen($candidato) > 0) {
            $this -> db -> where('es_candidato', $candidato);
        }
        if (strlen($candidatura) > 0) {
            $this -> db -> where('es_candidatura', $candidatura);
        //$this -> db -> where("pr_formacao IN (select es_formacao from rl_formacoes_candidaturas where es_candidatura={$candidatura})", NULL, FALSE);
        } else {
            $this -> db -> where('es_candidatura', null);
        }
        $this -> db -> select('*');
        $this -> db -> from('tb_formacao');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }

    public function create_experiencia($dados, $id)
    {
        if (!($dados["emprego_atual{$id}"]>0)) {
            $dados["emprego_atual{$id}"]=null;
        }
        if (isset($dados["candidatura{$id}"]) && strlen($dados["candidatura{$id}"])>0) {
            if (isset($dados["codigo_experiencia_pai{$id}"]) && strlen($dados["codigo_experiencia_pai{$id}"])>0) {
                //echo "teste";
                if (strlen($dados["fim{$id}"])>0) {
                    $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $dados["codigo_experiencia_pai{$id}"],
                                                'vc_cargo' => $dados["cargo{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
                        'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                                'dt_fim' => $dados["fim{$id}"],

                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                } else {
                    $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $dados["codigo_experiencia_pai{$id}"],
                                                'vc_cargo' => $dados["cargo{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
                        'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                }
            } else {
                if (strlen($dados["fim{$id}"])>0) {
                    $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'vc_cargo' => $dados["cargo{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
                        'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                                'dt_fim' => $dados["fim{$id}"],

                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                    $this -> db -> insert('tb_experiencias', $data);

                    $experiencia = $this -> db -> insert_id();
                    //echo "teste";
                    $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $experiencia,
                                                'vc_cargo' => $dados["cargo{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
                        'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                                'dt_fim' => $dados["fim{$id}"],

                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                } else {
                    $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'vc_cargo' => $dados["cargo{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
                        'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                    $this -> db -> insert('tb_experiencias', $data);

                    $experiencia = $this -> db -> insert_id();
                    $data=array(
                                                'es_candidato' => $this -> session -> candidato,
                                                'es_candidatura' => $dados["candidatura{$id}"],
                                                'es_experiencia_pai' => $experiencia,
                                                'vc_cargo' => $dados["cargo{$id}"],
                                                'vc_empresa' => $dados["empresa{$id}"],
                                                'dt_inicio' => $dados["inicio{$id}"],
                        'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                                'tx_atividades' => $dados["atividades{$id}"],
                                        );
                }
            }
        } else {
            if (strlen($dados["fim{$id}"])>0) {
                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'vc_cargo' => $dados["cargo{$id}"],
                                        'vc_empresa' => $dados["empresa{$id}"],
                                        'dt_inicio' => $dados["inicio{$id}"],
                    'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                        'dt_fim' => $dados["fim{$id}"],

                                        'tx_atividades' => $dados["atividades{$id}"],
                                );
            } else {
                $data=array(
                                        'es_candidato' => $this -> session -> candidato,
                                        'vc_cargo' => $dados["cargo{$id}"],
                                        'vc_empresa' => $dados["empresa{$id}"],
                                        'dt_inicio' => $dados["inicio{$id}"],
                    'bl_emprego_atual' => $dados["emprego_atual{$id}"],
                                        'tx_atividades' => $dados["atividades{$id}"],
                                );
            }
        }
        $this -> db -> insert('tb_experiencias', $data);

        return $this -> db -> insert_id();
    }

    public function update_experiencia($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_experienca', $primaria);
        $this -> db -> update('tb_experiencias');
        return $this -> db -> affected_rows();
    }

    public function delete_experiencia($id)
    {
        //echo "delete: $primaria<br>";
        if (strlen($id)==0&&strlen($id)==0) {
            return false;
        }


        if (strlen($id) > 0 && $id > 0) {
            //$this ->delete_experiencia_candidatura($id);
            $this -> db -> where('pr_experienca', $id);
        }


        $this -> db -> delete('tb_experiencias');

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


    public function get_experiencia($id='', $candidato='', $candidatura='')
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_experienca', $id);
        }
        if (strlen($candidato) > 0) {
            $this -> db -> where('es_candidato', $candidato);
        }
        if (strlen($candidatura) > 0) {
            $this -> db -> where('es_candidatura', $candidatura);
        //$this -> db -> where("pr_experienca IN (select es_experiencia from rl_experiencias_candidaturas where es_candidatura={$candidatura})", NULL, FALSE);
        } else {
            $this -> db -> where('es_candidatura', null);
        }
        $this -> db -> select('*');
        $this -> db -> from('tb_experiencias');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }

    public function get_nota($id='', $candidatura='', $etapa='', $competencia='', $etapa4='', $avaliador='')
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_nota', $id);
        }
        if (strlen($candidatura) > 0) {
            $this -> db -> where('es_candidatura', $candidatura);
        }
        if (strlen($etapa) > 0) {
            $this -> db -> where('es_etapa', $etapa);
        }
        if (strlen($avaliador) > 0) {
            $this -> db -> where('es_avaliador', $avaliador);
        } elseif ($etapa4 == '') {
            $this -> db -> where('es_avaliador', null);
        } else {
            $this -> db -> where('es_avaliador !=', null);
        }
        if ($competencia == '') {
            $this -> db -> where('es_competencia', null);
        } elseif ($competencia == 'todos') {
            $this -> db -> where('es_competencia !=', null);
        } else {
            $this -> db -> where('es_competencia', $competencia);
        }

        $this -> db -> select('*');
        $this -> db -> from('tb_notas');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }

    public function get_nota_total($id='', $vaga='', $etapa='')
    {
        if (strlen($id) > 0 && $id > 0) {
            $this -> db -> where('pr_nota', $id);
        }
        if (strlen($vaga) > 0) {
            $this -> db -> where('es_vaga', $vaga);
        }
        if (strlen($etapa) > 0) {
            $this -> db -> where('es_etapa', $etapa);
        }


        $this -> db -> select('*');
        $this -> db -> from('tb_notas_totais');
        $query = $this -> db -> get();
        if ($query -> num_rows() > 0) {
            return $query -> result();
        } else {
            return null;
        }
    }

    public function create_nota($dados)
    {
        if (isset($dados['competencia']) && strlen($dados['competencia']) > 0) {
            if (isset($dados['avaliador']) && strlen($dados['avaliador']) > 0) {
                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_competencia' => $dados["competencia"],
                                        'es_avaliador' => $dados["avaliador"],
                                        'es_etapa' => $dados["etapa"]
                                );
            } else {
                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_competencia' => $dados["competencia"],
                                        'es_etapa' => $dados["etapa"]
                                );
            }
        } else {
            if (isset($dados['avaliador']) && strlen($dados['avaliador']) > 0) {
                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_avaliador' => $dados["avaliador"],
                                        'es_etapa' => $dados["etapa"]
                                );
            } else {
                $data=array(
                                        'es_candidatura' => $dados['candidatura'],
                                        'in_nota' => $dados['nota'],
                                        'es_etapa' => $dados["etapa"]
                                );
            }
        }
        $this -> db -> insert('tb_notas', $data);
        return $this -> db -> insert_id();
    }

    public function create_nota_total($dados)
    {
        $data=array(
                        'es_vaga' => $dados['vaga'],
                        'in_nota_total' => $dados['nota_total'],
                        'es_etapa' => $dados["etapa"]
                );

        $this -> db -> insert('tb_notas_totais', $data);
        return $this -> db -> insert_id();
    }

    public function update_nota($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_nota', $primaria);
        $this -> db -> update('tb_notas');
        return $this -> db -> affected_rows();
    }

    public function update_nota_total($campo, $valor, $primaria)
    {
        if (strlen($primaria)==0) {
            return false;
        }
        if (strlen($campo)==0) {
            return false;
        }
        $this -> db -> set($campo, $valor);
        $this -> db -> where('pr_nota_total', $primaria);
        $this -> db -> update('tb_notas_totais');
        return $this -> db -> affected_rows();
    }

    public function delete_nota($id, $candidatura, $etapa)
    {
        //echo "delete: $primaria<br>";
        if ((strlen($id)==0&&strlen($id)==0) && ((strlen($candidatura)==0&&strlen($candidatura)==0) || (strlen($etapa)==0&&strlen($etapa)==0))) {
            echo "teste";
            return false;
        }


        if (strlen($id) > 0 && $id > 0) {
            //$this ->delete_experiencia_candidatura($id);
            $this -> db -> where('pr_nota', $id);
        } elseif ((strlen($candidatura) > 0 && $candidatura > 0) && (strlen($etapa) > 0 && $etapa > 0)) {
            $this -> db -> where('es_candidatura', $candidatura);
            $this -> db -> where('es_etapa', $etapa);
        }


        $this -> db -> delete('tb_notas');
        //echo $this -> db -> last_query();
        return $this -> db -> affected_rows();
    }
}
