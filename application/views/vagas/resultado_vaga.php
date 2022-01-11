<?php

defined("BASEPATH") or exit("No direct script access allowed");

	echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            <th>Teste de Aderência</th>
                                                                                            <th>Teste de Motivação</th>
                                                                                            <th>Teste de HBDI</th>
                                                                                            ";
	if ($this->session->perfil != "avaliador") {
		echo "
                                                                                            <th>Nota total</th>
                                                                                            
                                                                                            <th>Nota - Anál. Curricular</th>
                                                                                            <th>Nota bruta - Anál. Curricular</th>
                                                                                            <th>Nota - Teste aderência</th>
                                                                                            <th>Nota bruta - Teste aderência</th>
                                                                                            <th>Nota - Teste motivação</th>
                                                                                            <th>Nota bruta - Teste motivação</th>
                                                                                            <th>Nota - Entr. Competência</th>
                                                                                            <th>Nota bruta - Entr. Competência</th>
                                                                                            <th>Nota - Entre. Especialista</th>
                                                                                            <th>Nota bruta - Entre. Especialista</th>
                                                                                            ";
	}
	echo "
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
	//var_dump($vagas);
	if (isset($candidaturas)) {
		$atual = time();
		foreach ($candidaturas as $linha) {
			$dt_fim = strtotime($linha->dt_fim);
			echo "
                                                                                    <tr>
                                                                                            <td>" .
				$linha->vc_nome .
				"</td>";
			if ($linha->es_status == 7 || $linha->es_status == 8) {
				echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-warning badge-lg\">" .
					$linha->vc_status .
					"</span></td>";
			} elseif (
				$linha->es_status == 9 ||
				$linha->es_status == 13 ||
				$linha->es_status == 15 ||
				$linha->es_status == 18 ||
				$linha->es_status == 20
			) {
				echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">" .
					$linha->vc_status .
					"</span></td>";
			} elseif (
				$linha->es_status == 10 ||
				$linha->es_status == 11 ||
				$linha->es_status == 12 ||
				$linha->es_status == 14 ||
				$linha->es_status == 16 ||
				$linha->es_status == 19
			) {
				echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">" .
					$linha->vc_status;
				if ($linha->es_status == 10) {
					if (isset($entrevistas[$linha->pr_candidatura]["competencia"])) {
						echo " - Competência";
					}
					if (isset($entrevistas[$linha->pr_candidatura]["especialista"])) {
						echo " - Especialista";
					}
				}
				echo "</span></td>";
			}
			echo "
                                                                                            <td class=\"text-center\">" .
				($linha->en_aderencia == "2"
					? "Realizado"
					: ($linha->en_aderencia == "1"
						? (strlen($linha->dt_aderencia) > 0 &&
						strtotime($linha->dt_aderencia) >= $atual
							? "Solicitado"
							: "Expirado")
						: "Não solicitado")) .
				"</td>
                                                                                            <td class=\"text-center\">" .
				($linha->en_motivacao == "2"
					? "Realizado"
					: ($linha->en_motivacao == "1"
						? (strlen($linha->dt_aderencia) > 0 &&
						strtotime($linha->dt_aderencia) >= $atual
							? "Solicitado"
							: "Expirado")
						: "Não solicitado")) .
				"</td>
                                                                                            <td class=\"text-center\">" .
				($linha->en_hbdi == "2"
					? "Realizado"
					: ($linha->en_hbdi == "1"
						? (strlen($linha->dt_aderencia) > 0 &&
						strtotime($linha->dt_aderencia) >= $atual
							? "Solicitado"
							: "Expirado")
						: "Não solicitado")) .
				"</td>
                                                                                            ";
			/*
            echo "
                                                                                <td class=\"text-center\">".$linha -> cont."</td>";
            */

			if (!isset($linha->in_nota2) || !(strlen($linha->in_nota2) > 0)) {
				$linha->in_nota2 = 0;
			}
			if (!isset($linha->in_nota3) || !(strlen($linha->in_nota3) > 0)) {
				$linha->in_nota3 = 0;
			}

			if (!isset($linha->in_nota4) || !(strlen($linha->in_nota4) > 0)) {
				$linha->in_nota4 = 0;
			}
			if (!isset($linha->in_nota5) || !(strlen($linha->in_nota5) > 0)) {
				$linha->in_nota5 = 0;
			}
			if (!isset($linha->in_nota6) || !(strlen($linha->in_nota6) > 0)) {
				$linha->in_nota6 = 0;
			}
			if (!isset($linha->in_nota7) || !(strlen($linha->in_nota7) > 0)) {
				$linha->in_nota7 = 0;
			}

			if ($linha->en_aderencia == "1") {
				$linha->in_nota5 = 0;
			}
			if ($linha->en_motivacao == "1") {
				$linha->in_nota6 = 0;
			}

			if ($linha->es_status == 20 || $linha->es_status == 21) {
				$linha->in_nota3 = 0;
			}

			$total = 0;

			$bruta3 = round(($total3 * $linha->in_nota3) / 100);
			$bruta4 = round(($total4 * $linha->in_nota4) / 100);
			$bruta5 = round(($total5 * $linha->in_nota5) / 100);
			$bruta6 = round(($total6 * $linha->in_nota6) / 100);
			$bruta7 = round(($total7 * $linha->in_nota7) / 100);

			/*if($linha -> in_nota2 != 0){
                            $total += intval($linha -> in_nota2);
            }*/
			if ($linha->in_nota3 != 0) {
				$total += intval($linha->in_nota3);
			}
			if ($linha->in_nota4 != 0) {
				$total += intval($linha->in_nota4);
			}
			if ($linha->in_nota5 != 0) {
				$total += intval($linha->in_nota5);
			}
			if ($linha->in_nota6 != 0) {
				$total += intval($linha->in_nota6);
			}
			if ($linha->in_nota7 != 0) {
				$total += intval($linha->in_nota7);
			}
			if ($this->session->perfil != "avaliador") {
				if ($linha->in_nota6 == 0) {
					if ($linha->en_aderencia) {
						if ($linha->en_motivacao) {
							echo "
                                                                                            <td class=\"text-center\">" .
								round($total / 4) .
								"</td>";
						} else {
							echo "
                                                                                            <td class=\"text-center\">" .
								round($total / 3) .
								"</td>";
						}
					} else {
						echo "
                                                                                            <td class=\"text-center\">" .
							round($total / 2) .
							"</td>";
					}
				} else {
					if ($linha->en_aderencia) {
						if ($linha->en_motivacao) {
							echo "
                                                                                            <td class=\"text-center\">" .
								round($total / 5) .
								"</td>";
						} else {
							echo "
                                                                                            <td class=\"text-center\">" .
								round($total / 4) .
								"</td>";
						}
					} else {
						echo "
                                                                                            <td class=\"text-center\">" .
							round($total / 3) .
							"</td>";
					}
				}
				//<td class=\"text-center\">".$linha -> in_nota2."</td>
				echo "
																							
                                                                                            
                                                                                            <td class=\"text-center\">" .
					$linha->in_nota3 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$bruta3 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$linha->in_nota5 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$bruta5 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$linha->in_nota7 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$bruta7 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$linha->in_nota4 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$bruta4 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$linha->in_nota6 .
					"</td>
                                                                                            <td class=\"text-center\">" .
					$bruta6 .
					"</td>
                                                                                            ";
			}
			echo "
                                                                                            <td class=\"text-center\">";

			echo anchor(
				"Candidaturas/DetalheAvaliacao/" . $linha->pr_candidatura . "/" . $linha->es_vaga,
				'<i class="fa fa-lg mr-0 fa-search">Detalhes</i>',
				" class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\""
			);
			/*
            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\"></i></a>";
            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar currículo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
            */

			if ($vagas[0]->bl_finalizado != "1") {
				if ($linha->es_status == 8 || $linha->es_status == 10) {
					//candidatura realizada ou selecionado para entrevista por competência
					if ($this->session->perfil != "avaliador") {
						echo anchor(
							"Vagas/AgendamentoEntrevista/" . $linha->pr_candidatura,
							'<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento competência</i>',
							" class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por competência\""
						);
						echo anchor(
							"Vagas/AgendamentoEntrevista/" .
								$linha->pr_candidatura .
								"/especialista",
							'<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento especialista</i>',
							" class=\"btn btn-sm btn-square btn-primary\" title=\"Agendar entrevista com especialista\""
						);
						/*if(strlen($linha -> en_aderencia) == 0 && $linha -> es_status == 10){
                                        echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Solicitar teste de aderência</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de aderência\"");
                        }*/
					}
					if ($linha->es_status == 10) {
						//echo $entrevistas[$linha -> pr_candidatura]['competencia']->es_avaliador2;
						if (
							isset($entrevistas[$linha->pr_candidatura]["competencia"]) &&
							(($this->session->perfil == "sugesp" &&
								($this->session->uid ==
									$entrevistas[$linha->pr_candidatura]["competencia"]
										->es_avaliador1 ||
									$this->session->uid ==
										$entrevistas[$linha->pr_candidatura]["competencia"]
											->es_avaliador2)) ||
								$this->session->perfil == "avaliador") &&
							(strlen($linha->es_avaliador_competencia1) == 0 ||
								strlen($linha->es_avaliador_competencia2) == 0)
						) {
							//avaliador
							if (
								strtotime(
									$entrevistas[$linha->pr_candidatura]["competencia"]
										->dt_entrevista
								) <= $atual
							) {
								echo "<br />";
								echo anchor(
									"Candidaturas/AvaliacaoEntrevista/" .
										$linha->pr_candidatura .
										"/" .
										$linha->es_vaga,
									'<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>',
									" class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\""
								);
								echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(" .
									$linha->pr_candidatura .
									");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
							}
						} elseif (
							isset($entrevistas[$linha->pr_candidatura]["especialista"]) &&
							(($this->session->perfil == "sugesp" &&
								$this->session->uid ==
									$entrevistas[$linha->pr_candidatura]["especialista"]
										->es_avaliador1) ||
								$this->session->perfil == "avaliador") &&
							$entrevistas[$linha->pr_candidatura]["especialista"]->es_avaliador2 ==
								""
						) {
							//avaliador
							if (
								strtotime(
									$entrevistas[$linha->pr_candidatura]["especialista"]
										->dt_entrevista
								) <= $atual
							) {
								echo "<br />";
								echo anchor(
									"Candidaturas/AvaliacaoEntrevistaEspecialista/" .
										$linha->pr_candidatura .
										"/" .
										$linha->es_vaga,
									'<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>',
									" class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\""
								);
								echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(" .
									$linha->pr_candidatura .
									");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
							}
						}
					}
				} elseif ($linha->es_status == 11) {
					//candidatura com entrevista com especialista já realizada
					if ($this->session->perfil != "avaliador") {
						echo anchor(
							"Vagas/AgendamentoEntrevista/" .
								$linha->pr_candidatura .
								"/especialista",
							'<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento especialista</i>',
							" class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista com especialista\""
						);
					}
					/*if(strlen($linha -> en_aderencia) == 0){
                                                echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt">Solicitar teste de aderência</i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de aderência\"");
                                        }*/
					/*if($linha -> en_aderencia == '1'){
                            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo não preenchimento do teste de aderência\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Eliminar por Teste de Aderência</i></a>";
                    }
                    else{
                            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decisão final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Mudar aguardando decisão final</i></a>";
                    }*/
					if (
						isset($entrevistas[$linha->pr_candidatura]["especialista"]) &&
						(($this->session->perfil == "sugesp" &&
							$this->session->uid ==
								$entrevistas[$linha->pr_candidatura]["especialista"]
									->es_avaliador1) ||
							$this->session->perfil == "avaliador") &&
						strlen(
							$entrevistas[$linha->pr_candidatura]["especialista"]->es_avaliador2
						) == 0
					) {
						//avaliador
						if (
							strtotime(
								$entrevistas[$linha->pr_candidatura]["especialista"]->dt_entrevista
							) <= $atual
						) {
							echo "<br />";
							echo anchor(
								"Candidaturas/AvaliacaoEntrevistaEspecialista/" .
									$linha->pr_candidatura .
									"/" .
									$linha->es_vaga,
								'<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>',
								" class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\""
							);
							echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(" .
								$linha->pr_candidatura .
								");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
						}
					}
				} elseif ($linha->es_status == 12) {
					if (strlen($linha->es_avaliador_competencia1) == 0) {
						echo anchor(
							"Vagas/AgendamentoEntrevista/" . $linha->pr_candidatura,
							'<i class="fa fa-lg mr-0 fa-calendar-check">Agendamento Competência</i>',
							" class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por competência\""
						);
					}
					/*if($linha -> en_aderencia == '1'){
                            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo não preenchimento do teste de aderência\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Eliminar por Teste de Aderência</i></a>";
                    }
                    else{
                            echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decisão final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Mudar aguardando decisão final</i></a>";
                    }*/
					if (
						isset($entrevistas[$linha->pr_candidatura]["competencia"]) &&
						((($this->session->perfil == "sugesp" &&
							($this->session->uid ==
								$entrevistas[$linha->pr_candidatura]["competencia"]
									->es_avaliador1 ||
								$this->session->uid ==
									$entrevistas[$linha->pr_candidatura]["competencia"]
										->es_avaliador2)) ||
							$this->session->perfil == "avaliador") &&
							strlen($linha->es_avaliador_competencia1) == 0)
					) {
						//avaliador
						if (strtotime($linha->dt_entrevista) <= strtotime(date("Y-m-d"))) {
							echo "<br />";
							echo anchor(
								"Candidaturas/AvaliacaoEntrevista/" .
									$linha->pr_candidatura .
									"/" .
									$linha->es_vaga,
								'<i class="fa fa-lg mr-0 fa-video-camera">Entrevista</i>',
								" class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\""
							);
							echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(" .
								$linha->pr_candidatura .
								");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Não Comparecimento</i></a>";
						}
					}
				} elseif ($linha->es_status == 14 && $this->session->perfil != "avaliador") {
					echo anchor(
						"Candidaturas/editDossie/" . $linha->pr_candidatura,
						'<i class="fa fa-lg mr-0 fa-file-alt">Dossiê</i>',
						" class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\""
					);
				} elseif ($linha->es_status == 16 && $this->session->perfil != "avaliador") {
					echo anchor(
						"Candidaturas/Dossie/" . $linha->pr_candidatura,
						'<i class="fa fa-lg mr-0 fa-file-alt">Dossiê</i>',
						" class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\""
					);
					echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar candidato\" onclick=\"confirm_aprovacao_final(" .
						$linha->pr_candidatura .
						");\"><i class=\"fa fa-lg mr-0 fa-plus-circle\">Aprovar candidato</i></a>";
				} elseif (
					($linha->es_status == 18 || $linha->es_status == 19) &&
					$this->session->perfil != "avaliador"
				) {
					echo anchor(
						"Candidaturas/Dossie/" . $linha->pr_candidatura,
						'<i class="fa fa-lg mr-0 fa-file-alt">Dossiê</i>',
						" class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\""
					);
				} elseif (($linha->es_status == 20 || $linha->es_status == 7) && $dt_fim < $atual) {
					if (
						$this->session->perfil == "sugesp" ||
						$this->session->perfil == "orgaos" ||
						$this->session->perfil == "administrador" ||
						$this->session->perfil == "avaliador"
					) {
						echo anchor(
							"Candidaturas/AvaliacaoCurriculo/" .
								$linha->pr_candidatura .
								"/" .
								$linha->es_vaga,
							'<i class="fa fa-lg mr-0 fa-file-alt">Currículo</i>',
							" class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\""
						);

						if ($linha->es_status == 20) {
							echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprovação por habilitação\" onclick=\"confirm_reprovacao_habilitacao(" .
								$linha->pr_candidatura .
								");\"><i class=\"fa fa-lg mr-0 fa-times-circle\">Confirmar reprovação por habilitação</i></a>";
						}
					}
				}
				/*if($linha -> es_status != 19 && $linha -> es_status != 20){
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura por revisão de requisitos\" onclick=\"confirm_reprovacao_requisitos(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-0 fa-times-circle\"></i></a>";
                }*/
			} elseif (
				($linha->es_status == 16 || $linha->es_status == 18 || $linha->es_status == 19) &&
				$this->session->perfil != "avaliador"
			) {
				echo anchor(
					"Candidaturas/Dossie/" . $linha->pr_candidatura,
					'<i class="fa fa-lg mr-0 fa-file-alt">Dossiê</i>',
					" class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\" target=\"blank\""
				);
			}
			//echo anchor('Candidaturas/RevisaoRequisitos/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Revisão de requisitos\"");

			echo "
                                                                                            </td>
                                                                                    </tr>";
		}
	}
	echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

	$pagina["js"] = "
                                            <script type=\"text/javascript\">";
	/*
                                                function confirm_aprovacao(id){
                                                        $(document).ready(function(){
                                                                swal.fire({
                                                                    title: 'Você confirma a aprovação para a entrevista?',
                                                                    text: 'O candidato será aprovado para a entrevista.',
                                                                    type: 'warning',
                                                                    showCancelButton: true,
                                                                    cancelButtonText: 'Não, cancele',
                                                                    confirmButtonText: 'Sim, aprove'
                                                                })
                                                                .then(function(result) {
                                                                    if (result.value) {
                                                                        $(location).attr('href', '".base_url('Vagas/aprovar_entrevista/')."' + id)
                                                                    }
                                                                });
                                                        });
                                                }
                                                function confirm_reprovacao(id){
                                                        $(document).ready(function(){
                                                                swal.fire({
                                                                    title: 'Você confirma a reprovação da análise curricular?',
                                                                    text: 'O candidato será reprovado.',
                                                                    type: 'warning',
                                                                    showCancelButton: true,
                                                                    cancelButtonText: 'Não, cancele',
                                                                    confirmButtonText: 'Sim, reprove'
                                                                })
                                                                .then(function(result) {
                                                                    if (result.value) {
                                                                        $(location).attr('href', '".base_url('Vagas/reprovar_curriculo/')."' + id)
                                                                    }
                                                                });
                                                        });
                                                }*/
	$pagina["js"] .=
		"
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o não comparecimento à entrevista?',
                                                                        text: 'O candidato será eliminado por não comparecimento à entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não',
                                                                        confirmButtonText: 'Sim, elimine'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Candidaturas/eliminar_entrevista/") .
		"' + id + '/' + {$vagas[0]->pr_vaga})
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_reprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação dos candidatos não agendados para entrevista?',
                                                                        text: 'Todo o restante de candidatos será reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reprovar_restantes/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    
                                                    function confirm_reprovacao2(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação dos candidatos dos candidatos que estão aguardando decisão final, finalizando essa vaga?',
                                                                        text: 'Essa vaga será finalizada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove os candidatos e finalize a vaga'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reprovar_restantes2/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_reprovacao_requisitos(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação desse candidato por revisão de requisitos',
                                                                        text: 'Esse candidato será eliminado por revisão por requisitos.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reprovar_revisao_requisitos/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reprovacao_entrevista(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação desse candidato por não preenchimento do teste de aderência',
                                                                        text: 'Esse candidato será eliminado pelo não preenchimento do teste de aderência.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reprovar_entrevista/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
													
													function confirm_reprovacao_habilitacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma que esse candidato perdeu o recurso e será reprovado definitivamente',
                                                                        text: 'Esse candidato será eliminado no teste de habilitação em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, confirma'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/reprovar_habilitacao/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
													
                                                    function confirm_aprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação para aguardando decisão final',
                                                                        text: 'Esse candidato terá o status alterado para aguardando decisão final, se não tiver entrevista com especialista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/aguardar_decisao_final/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_aprovacao_final(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação final desse candidato',
                                                                        text: 'Esse candidato será aprovado no processo seletivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '" .
		base_url("Vagas/aprovar_final/") .
		"' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            bDeferRender: true,
                                                            order: [
                                                                [5, 'desc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";
