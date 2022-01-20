<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Questoes_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_questoes(
		$id = "",
		$grupo = "",
		$etapa = "",
		$not_grupo = "",
		$vigentes = true,
		$tipo = ""
	) {
		if (strlen($id) > 0) {
			$this->db->where("q.pr_questao", $id);
		}
		if (strlen($grupo) > 0) {
			$this->db->join("rl_gruposvagas_questoes r", "q.pr_questao=r.es_questao");
			$this->db->where("r.es_grupovaga", $grupo);
		} elseif (strlen($not_grupo) > 0) {
			$this->db->where(
				"q.pr_questao not in (select es_questao from rl_gruposvagas_questoes where es_grupovaga={$not_grupo})"
			);
		}
		if (strlen($etapa) > 0) {
			$this->db->where("q.es_etapa", $etapa);
		}
		if (strlen($tipo) > 0) {
			$this->db->where("q.in_tipo", $tipo);
		}
		if ($vigentes) {
			$this->db->where("q.bl_removido", "0");
		}
		$this->db->join("tb_etapas e", "q.es_etapa=e.pr_etapa");
		$this->db->select("q.*, e.vc_etapa");
		$this->db->from("tb_questoes q");
		if (strlen($grupo) > 0) {
			$this->db->order_by("r.in_ordem ASC, q.es_etapa ASC, q.pr_questao ASC");
		} else {
			$this->db->order_by("q.es_etapa ASC, q.pr_questao ASC");
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$resultado = $query->result();
			foreach ($resultado as $linha) {
				$this->db->from("tb_respostas");
				$this->db->where("es_questao", $linha->pr_questao);
				$linha->cont_respostas = $this->db->count_all_results();
				$retorno[] = $linha;
			}
			return $retorno;
		} else {
			return null;
		}
	}
	public function get_respostas(
		$id = "",
		$candidatura = "",
		$questao = "",
		$avaliador = "",
		$etapa = ""
	) {
		if (strlen($id) > 0) {
			$this->db->where("pr_resposta", $id);
		}
		if (strlen($candidatura) > 0) {
			$this->db->where("es_candidatura", $candidatura);
		}
		if (strlen($questao) > 0) {
			$this->db->where("es_questao", $questao);
		}
		if (strlen($avaliador) > 0) {
			$this->db->where("es_avaliador", $avaliador);
		}
		if (strlen($etapa) > 0) {
			$this->db->where(
				"es_questao IN (select pr_questao from tb_questoes where es_etapa={$etapa})",
				null,
				false
			);
		}
		$this->db->where("bl_removido", "0");
		$this->db->select("*");
		$this->db->from("tb_respostas");
		$query = $this->db->get();
		//echo $this -> db ->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function delete_resposta($primaria)
	{
		if (strlen($primaria) == 0) {
			return false;
		}
		$this->db->where("pr_resposta", $primaria);
		$this->db->delete("tb_respostas");
		return $this->db->affected_rows();
	}

	public function get_opcoes($id = "", $questao = "", $vaga = "")
	{
		if (strlen($id) > 0) {
			$this->db->where("o.pr_opcao", $id);
		}
		if (strlen($questao) > 0) {
			$this->db->where("o.es_questao", $questao);
		}
		if (strlen($vaga) > 0) {
			$this->db->join("tb_questoes q", "q.pr_questao=o.es_questao");
			$this->db->join("rl_gruposvagas_questoes r", "q.pr_questao=r.es_questao");
			$this->db->join("tb_vagas v", "v.es_grupoVaga=r.es_grupovaga");
			$this->db->where("v.pr_vaga", $vaga);
			$this->db->order_by("o.es_questao, o.in_valor");
		}
		$this->db->where("o.bl_removido", "0");
		$this->db->select("*");
		$this->db->from("tb_opcoes o");
		$this->db->order_by("o.in_valor");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	/*
    A variável questão é para excluir das questoões não respondidas, não funcionando isoladamente
    */
	public function get_etapas($grupo_vaga = "", $questao = "")
	{
		$etapas = [];
		$this->db->select("pr_etapa, vc_etapa");
		$this->db->from("tb_etapas");
		if (strlen($grupo_vaga) > 0) {
			if (strlen($questao) > 0) {
				$this->db->where(
					"pr_etapa not IN (select es_etapa from tb_questoes where pr_questao in (select es_questao from rl_gruposvagas_questoes where es_grupovaga=" .
						$grupo_vaga .
						" and es_questao <> " .
						$questao .
						") and  pr_questao in (select es_questao from tb_respostas where es_questao<>" .
						$questao .
						"))",
					null,
					false
				);
			} else {
				$this->db->where(
					"pr_etapa not IN (select es_etapa from tb_questoes where pr_questao in (select es_questao from rl_gruposvagas_questoes where es_grupovaga=" .
						$grupo_vaga .
						") and  pr_questao in (select es_questao from tb_respostas))",
					null,
					false
				);
			}
		}
		$this->db->order_by("in_ordem", "ASC");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$results = $query->result_array();
			$etapas = array_column($results, "vc_etapa", "pr_etapa");
		}
		//$Estados[]=array(0=>'');
		return $etapas;
	}

	public function get_competencias()
	{
		$competencias = [];
		$this->db->select("pr_competencia, vc_competencia");
		$this->db->from("tb_competencias");
		$this->db->order_by("vc_competencia", "ASC");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$results = $query->result_array();
			$competencias = array_column($results, "vc_competencia", "pr_competencia");
		}
		//$Estados[]=array(0=>'');
		return $competencias;
	}

	public function create_questao($dados)
	{
		if (
			isset($dados["competencia"]) &&
			strlen($dados["competencia"]) > 0 &&
			$dados["competencia"] != "0"
		) {
			if (isset($dados["peso"]) && strlen($dados["peso"]) > 0) {
				$data = [
					"es_etapa" => $dados["etapa"],
					"es_competencia" => $dados["competencia"],
					"tx_questao" => $dados["descricao"],
					"vc_respostaAceita" => $dados["respostaaceita"],
					"in_peso" => $dados["peso"],
					"in_tipo" => $dados["tipo"],
					"bl_eliminatoria" => $dados["eliminatoria"],
					"bl_obrigatorio" => $dados["obrigatorio"],
					"es_usuarioCadastro" => $this->session->uid,
					"dt_cadastro" => date("Y-m-d H:i:s"),
				];
			} else {
				$data = [
					"es_etapa" => $dados["etapa"],
					"es_competencia" => $dados["competencia"],
					"tx_questao" => $dados["descricao"],
					"vc_respostaAceita" => $dados["respostaaceita"],

					"in_tipo" => $dados["tipo"],
					"bl_eliminatoria" => $dados["eliminatoria"],
					"bl_obrigatorio" => $dados["obrigatorio"],
					"es_usuarioCadastro" => $this->session->uid,
					"dt_cadastro" => date("Y-m-d H:i:s"),
				];
			}
		} else {
			if (isset($dados["peso"]) && strlen($dados["peso"]) > 0) {
				$data = [
					"es_etapa" => $dados["etapa"],
					"tx_questao" => $dados["descricao"],
					"vc_respostaAceita" => $dados["respostaaceita"],
					"in_peso" => $dados["peso"],
					"in_tipo" => $dados["tipo"],
					"bl_eliminatoria" => $dados["eliminatoria"],
					"bl_obrigatorio" => $dados["obrigatorio"],
					"es_usuarioCadastro" => $this->session->uid,
					"dt_cadastro" => date("Y-m-d H:i:s"),
				];
			} else {
				$data = [
					"es_etapa" => $dados["etapa"],
					"tx_questao" => $dados["descricao"],
					"vc_respostaAceita" => $dados["respostaaceita"],

					"in_tipo" => $dados["tipo"],
					"bl_eliminatoria" => $dados["eliminatoria"],
					"bl_obrigatorio" => $dados["obrigatorio"],
					"es_usuarioCadastro" => $this->session->uid,
					"dt_cadastro" => date("Y-m-d H:i:s"),
				];
			}
		}
		$this->db->insert("tb_questoes", $data);
		$retorno = $this->db->insert_id();
		if ($retorno > 0) {
			if (!isset($data["ordem"])) {
				$data["ordem"] = "0";
			}
			$data = [
				"es_grupovaga" => $dados["grupo"],
				"es_questao" => $retorno,
				"in_ordem" => $data["ordem"],
			];
			$this->db->insert("rl_gruposvagas_questoes", $data);
		}
		//echo $this->db->last_query();
		return $retorno;
	}

	public function get_grupos_questoes_duplicadas(
		$questao_origem = "",
		$grupo_origem = "",
		$questao_destino = "",
		$grupo_destino = ""
	) {
		if (strlen($questao_origem) > 0) {
			$this->db->where("r.es_questao_origem", $questao_origem);
		}
		if (strlen($grupo_origem) > 0) {
			$this->db->where("r.es_grupovaga_origem", $grupo_origem);
		}
		if (strlen($questao_destino) > 0) {
			$this->db->where("r.es_questao_destino", $questao_destino);
		}
		if (strlen($grupo_destino) > 0) {
			$this->db->where("r.es_grupovaga_destino", $grupo_destino);
		}

		$this->db->where("q2.bl_removido", "0");

		$this->db->join("tb_gruposvagas g", "g.pr_grupovaga=r.es_grupovaga_destino");
		$this->db->join("tb_gruposvagas g2", "g2.pr_grupovaga=r.es_grupovaga_origem");
		$this->db->join("tb_questoes q2", "q2.pr_questao=r.es_questao_origem");
		$this->db->join("tb_usuarios u", "u.pr_usuario=r.es_usuario");
		$this->db->select(
			"r.*,q2.pr_questao,q2.tx_questao,q2.es_etapa,q2.in_tipo,q2.in_peso,g.vc_grupovaga as grupo_destino,g2.vc_grupovaga as grupo_origem,u.vc_nome as usuario"
		);
		$this->db->from("rl_gruposvagas_questoes_duplicadas r");

		$this->db->order_by("q2.es_etapa,q2.tx_questao,r.dt_cadastro");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function cont_grupos_questoes_duplicadas($questao_origem = "", $grupo_origem = "")
	{
		if (strlen($questao_origem) > 0) {
			$this->db->where("r.es_questao_origem", $questao_origem);
		}
		if (strlen($grupo_origem) > 0) {
			$this->db->where("r.es_grupovaga_origem", $grupo_origem);
		}
		$this->db->where("q2.bl_removido", "0");
		$this->db->join("tb_gruposvagas g2", "g2.pr_grupovaga=r.es_grupovaga_origem");
		$this->db->join("tb_questoes q2", "q2.pr_questao=r.es_questao_origem");

		$this->db->select(
			"q2.pr_questao,q2.tx_questao,q2.es_etapa,q2.in_tipo,g2.vc_grupovaga,count(1) as quantitativo"
		);
		$this->db->from("rl_gruposvagas_questoes_duplicadas r");

		$this->db->group_by("q2.pr_questao,q2.tx_questao,q2.es_etapa,q2.in_tipo,g2.vc_grupovaga");
		$this->db->order_by("count(1) desc");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function create_grupos_questoes_duplicadas($dados)
	{
		$data = [
			"es_grupovaga_origem" => $dados["grupo_origem"],
			"es_questao_origem" => $dados["questao_origem"],
			"es_grupovaga_destino" => $dados["grupo_destino"],
			"es_questao_destino" => $dados["questao_destino"],
			"es_usuario" => $this->session->uid,
			"dt_cadastro" => date("Y-m-d H:i:s"),
		];
		$this->db->insert("rl_gruposvagas_questoes_duplicadas", $data);
		$retorno = $this->db->insert_id();
		return $retorno;
	}

	public function update_questao($campo, $valor, $primaria)
	{
		if (strlen($primaria) == 0) {
			return false;
		}
		if (strlen($campo) == 0) {
			return false;
		}
		$this->db->set($campo, $valor);
		$this->db->set("es_usuarioAlteracao", $this->session->uid);
		$this->db->set("dt_alteracao", date("Y-m-d H:i:s"));
		$this->db->where("pr_questao", $primaria);
		$this->db->update("tb_questoes");
		return $this->db->affected_rows();
	}
	public function create_opcoes($dados)
	{
		if (strlen($dados["valor"]) == 0) {
			$dados["valor"] = 0;
		}
		$data = [
			"es_questao" => $dados["questao"],
			"tx_opcao" => $dados["texto"],
			"in_valor" => $dados["valor"],
		];
		$this->db->insert("tb_opcoes", $data);
		return $this->db->insert_id();
	}
	public function update_opcao($campo, $valor, $primaria)
	{
		if (strlen($primaria) == 0) {
			return false;
		}
		if (strlen($campo) == 0) {
			return false;
		}
		$this->db->set($campo, $valor);
		$this->db->where("pr_opcao", $primaria);
		$this->db->update("tb_opcoes");
		return $this->db->affected_rows();
	}
	public function delete_opcao($primaria)
	{
		//echo "delete: $primaria<br>";
		if (strlen($primaria) == 0) {
			return false;
		}
		$this->db->where("pr_opcao", $primaria);
		$this->db->delete("tb_opcoes");
		return $this->db->affected_rows();
	}

	public static function grupo_de_questoes_nao_vigente($etapas, $questoes)
	{
		$vigente = 1;
		$vigente_etapa = [];
		$chaves = array_keys($etapas);
		foreach ($chaves as $chave) {
			$vigente_etapa[$chave] = 0;
		}
		if (!is_array($questoes)) {
			$questoes = [];
		}
		foreach ($questoes as $linha) {
			if ($linha->cont_respostas > 0) {
				$vigente_etapa[$linha->es_etapa] = 1;
			}
		}
		foreach ($chaves as $chave) {
			if ($vigente_etapa[$chave] == 0) {
				$vigente = 0;
				break;
			}
		}
    return $vigente == 0;
	}
}
