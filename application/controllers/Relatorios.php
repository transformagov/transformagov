<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {
		
		function __construct() {
                parent::__construct();
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Vagas_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> helper('date');
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
				else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
        }
		
		public function index(){
				$pagina['menu1']='Relatorios';
                $pagina['menu2']='index';
                $pagina['url']='Relatorios/index';
                $pagina['nome_pagina']='Relatorios';
                $pagina['icone']='fa fa-pencil-square-o';
				
                $dados=$pagina;
				$this -> load -> view('relatorios', $dados);
		}
		
		public function DocumentosObrigatorios(){
				$this -> load -> model('Questoes_model');
				$this -> load -> model('Anexos_model');
				
				$pagina['menu1']='Relatorios';
                $pagina['menu2']='DocumentosObrigatorios';
                $pagina['url']='Relatorios/DocumentosObrigatorios';
				if(!isset($_POST["vaga"])){
						$pagina['nome_pagina']='Relatorios';
				}
				else{
						$vaga = $_POST['vaga'];
						$vagas = $this ->Vagas_model -> get_vagas ($vaga);
						$pagina['nome_pagina']='Relatorios - '.$vagas[0] -> vc_vaga;
				}
                $pagina['icone']='fa fa-pencil-square-o';

                $dados=$pagina;
				
				$dados['adicionais'] = array(
                                            'datatables' => true);
				if(!isset($_POST["vaga"])){
						$dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true);
						
				}
				else{
						$vaga = $_POST['vaga'];
						$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
						$dados['vaga'] = $this ->Vagas_model -> get_vagas ($vaga);
						$dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vaga'][0] -> es_grupoVaga, 1);
						if(isset($dados['candidaturas']) && isset($dados['questoes'])){
								$respostas = $this -> Questoes_model -> get_respostas('', '', '', '','1');
								foreach($respostas as $resposta){
										
										$dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
								}
								
								foreach($dados['candidaturas'] as $candidatura){
										$dados['candidato'][$candidatura -> pr_candidatura] = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
										foreach($dados['questoes'] as $questao){
												if($questao -> in_tipo == '7'){
														$dados['anexos'][$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('','', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
												}
												
										}
										
								}
								
								
						}
				}
				
				
				
				$this -> load -> view('relatorios', $dados);
				
		}

		public function csv_DocumentosObrigatorios($vaga){
				$this -> load -> model('Questoes_model');
				$this -> load -> model('Anexos_model');
				$this -> load -> library('csvmodel');

				$candidaturas = $this -> Candidaturas_model -> get_candidaturas ('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
				$vagas = $this ->Vagas_model -> get_vagas ($vaga);
				$questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 1);


				$campos=array('nome','cpf','documento','idade','email','status');

				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								$campos[] = 'campo'.$questao->pr_questao;
								/*echo "
																							<th>{$questao -> tx_questao}</th>
								";*/
						}
				}

				$this->csvmodel->setCampos($campos);

				$cabecalho = array('nome'=>'Nome do candidato','cpf'=>'CPF','documento'=>utf8_decode('Documento de identificação'),'idade'=>"Idade",'email'=>'E-mail','status'=>'Status');
				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								$cabecalho['campo'.$questao->pr_questao] = utf8_decode($questao -> tx_questao);
						}
				}
				$this->csvmodel->escreveCache($cabecalho);



				if(isset($candidaturas) && isset($questoes)){
						$respostas = $this -> Questoes_model -> get_respostas('', '', '', '','1');
						$respostas2 = array();
						foreach($respostas as $resposta){
								
								$respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
						}
						
						foreach($candidaturas as $candidatura){
								$candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
								if(isset($candidato)){
										$dataNascimento = $candidato-> dt_nascimento;
										$date = new DateTime($dataNascimento );
										$interval = $date->diff( new DateTime( date('Y-m-d') ) );
										
										$conteudo = array('nome'=>utf8_decode($candidato -> vc_nome),'cpf'=>$candidato -> ch_cpf,'documento'=>$candidato -> vc_rg,'idade'=>$interval->format( '%Y anos' ),'email' => $candidato -> vc_email,'status'=>utf8_decode($candidatura -> vc_status));

										foreach($questoes as $questao){
												


												if($questao -> in_tipo == '7'){
														$anexos[$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('','', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
														if(isset($anexos[$candidatura -> pr_candidatura][$questao -> pr_questao])){
																$conteudo['campo'.$questao->pr_questao] = "Inserido";
														}
														else{
																$conteudo['campo'.$questao->pr_questao] = utf8_decode("Não inserido");
														}
												}
												else if($questao -> in_tipo == '3'){
														$array_resposta = array(""=>"","0"=>utf8_decode("Não"),"1"=>"Sim");

														$conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
												}
												else if($questao -> in_tipo == '4'){
														$array_resposta = array(""=>"","0"=>"Sim","1"=>utf8_decode("Não"));

														$conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
												}

												
										}

										$this->csvmodel->escreveCache($conteudo);

								}
								
								
						}
						
						
				}

				$this->csvmodel->printCache('documentos_obrigatorios.csv');

		}
		
		public function AvaliacaoCurricular(){
                
                $this -> load -> model('Questoes_model');
                
                $pagina['menu1']='Relatorios';
                $pagina['menu2']='AvaliacaoCurricular';
                $pagina['url']='Relatorios/AvaliacaoCurricular';
                $pagina['nome_pagina']='Resultados da Avaliação Curricular';
                $pagina['icone']='fa fa-pencil-square-o';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                $dados['adicionais'] = array('datatables' => true);

                if(!isset($_POST["vaga"])){
						$dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true);
						
				}
				else{
						$vaga = $_POST["vaga"];
						//$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
						$dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

						//$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
						$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
						$dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 3);
						
						//var_dump($candidaturas);
						$dados['candidaturas'] = array();
						if($candidaturas){
								$respostas = $this -> Questoes_model -> get_respostas('', '', '', '','3');
								foreach($respostas as $resposta){
										
										$dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
								}
								
								foreach($dados['questoes'] as $questao){
										$dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
								}
								
								
								foreach($candidaturas as $candidatura){
										//$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
										$candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
										if(isset($candidatos)){
												//$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
												$candidatura -> vc_email = $candidatos -> vc_email;
												$candidatura -> ch_cpf = $candidatos -> ch_cpf;
												$candidatura -> dt_nascimento = $candidatos -> dt_nascimento;
												/*if(isset($notas)){
												
														foreach($notas as $nota){
																$candidatura -> in_nota3 = $nota -> in_nota;
																
																
														}
												}
												else{
														$candidatura -> in_nota3 = "0";
												}*/
												
												$dados['candidaturas'][] = $candidatura;
										}
										
										
										
								}
						}
				}	
                //$dados['competencias'] = $this -> Questoes_model -> get_competencias();
                
                //var_dump($dados['candidaturas']);

                $this -> load -> view('relatorios', $dados);
        }


        public function csv_AvaliacaoCurricular($vaga){
        		$this -> load -> model('Questoes_model');
        		$this -> load -> library('csvmodel');

        		$vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

						
				$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
				$questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 3);

				$campos=array('nome','email','cpf','idade','documento','status');

				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								$campos[] = 'campo'.$questao->pr_questao;
								
						}
				}
				$campos[]='total';
				$campos[]='percentual';
				$this->csvmodel->setCampos($campos);

				$cabecalho = array('nome'=>'Nome do candidato','email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status');
				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								$cabecalho['campo'.$questao->pr_questao] = utf8_decode($questao -> tx_questao);

						}
				}
				$cabecalho['total'] = utf8_decode("Nota bruta da Avaliação Curricular");
				$cabecalho['percentual'] = utf8_decode("Nota  percentual da Avaliação Curricular");
				$this->csvmodel->escreveCache($cabecalho);

				if($candidaturas){
						$respostas = $this -> Questoes_model -> get_respostas('', '', '', '','3');
						foreach($respostas as $resposta){
								
								$respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
						}
						
						foreach($questoes as $questao){
								$opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
						}

						foreach($candidaturas as $candidatura){
								//$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
								$candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
								if(isset($candidato)){

										$dataNascimento = $candidato -> dt_nascimento;
										$date = new DateTime($dataNascimento );
										$interval = $date->diff( new DateTime( date('Y-m-d') ) );
										

										$conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format( '%Y anos' ),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status));
										$total = 0;
										$maximo = 0;
										foreach($questoes as $questao){
												if($questao -> in_tipo == '1'){
														$nota = 0;
														$max = 0;
														foreach($opcoes[$questao -> pr_questao] as $opcao){

																if(@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																		//echo $opcao->in_valor;
																		$nota += intval($opcao->in_valor);
																}
																if($max < intval($opcao->in_valor)){
																		$max = intval($opcao->in_valor);
																}
																
																
														}
														$conteudo['campo'.$questao->pr_questao] = $nota;
														$total+=$nota;
														$maximo += $max;

														
												}
												else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
														
														$total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
														$conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
														$maximo += intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '5'){
														$nota = 0;
														$nota += round((@intval($respostas[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
														
														$conteudo['campo'.$questao->pr_questao] = $nota;
														$total+=$nota;
														$maximo += intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '6'){
														
														$total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
														$conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
														$maximo += intval($questao -> in_peso);
												}
												else{
														$conteudo['campo'.$questao->pr_questao] = "Campo sem nota";
												}
												/*if($questao -> in_tipo == '1'){
														$nota = 0;
														foreach($opcoes[$questao -> pr_questao] as $opcao){

																if(@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																		//echo $opcao->in_valor;
																		$nota += intval($opcao->in_valor);
																}
																
														}
														$conteudo['campo'.$questao->pr_questao] = $nota;
														$total+=$nota;
												}
												else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
														$conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
														$total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '5'){
														$nota = 0;
														if(@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)>=1 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
																$nota += intval($row->in_peso);
														}
														else if(@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)>=2 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
																$nota += intval($row->in_peso);
														}
														else if(@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)>=3 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
																$nota += intval($row->in_peso);
														}
														$conteudo['campo'.$questao->pr_questao] = $nota;
														$total+=$nota;
												}
												else if($questao -> in_tipo == '6'){
														$conteudo['campo'.$questao->pr_questao] = @$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta;
														$total+=@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta;
														//$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
												}
												else{
														$conteudo['campo'.$questao->pr_questao] = "Campo sem nota";
												}*/
												
												//$conteudo['campo'.$questao->pr_questao] = "-";
												
										}
										$conteudo['total'] = $total;
										$conteudo['percentual'] = (round(($total/$maximo)*100));
										$this->csvmodel->escreveCache($conteudo);
								}
						}

				}

				$this->csvmodel->printCache('avaliacao_curricular.csv');
        }
}
?>