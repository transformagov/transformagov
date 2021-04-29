<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this->load->view('templates/internaCabecalho', $pagina);

echo "
                        <div class=\"pcoded-content\">
                            <div class=\"pcoded-inner-content\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper\">
                                        <div class=\"page-body\">
                                            <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                    <div class=\"card\">
                                                        <div class=\"card-block\">";
if($menu2 == 'index'){
        echo "
                                                            <ul class=\"basic-list\">";
        
                echo '
																	<li><a href="'.base_url('Relatorios/DocumentosObrigatorios').'"><h5>Documentos obrigatórios</h5></a></li>
																	<li><a href="'.base_url('Relatorios/RequisitosDesejaveis').'"><h5>Requisitos desejáveis</h5></a></li>
																	<li><a href="'.base_url('Relatorios/AvaliacaoCurricular').'"><h5>Avaliação Curricular</h5></a></li>
																	<li><a href="'.base_url('Relatorios/AvaliacaoCompetencia').'"><h5>Avaliação por Competência</h5></a></li>
																	<li><a href="'.base_url('Relatorios/TesteAderencia').'"><h5>Teste de Aderência</h5></a></li>
																	<li><a href="'.base_url('Relatorios/TesteMotivacao').'"><h5>Teste de Motivação</h5></a></li>
																	<li><a href="'.base_url('Relatorios/HBDI').'"><h5>HBDI</h5></a></li>
																	<li><a href="'.base_url('Relatorios/AvaliacaoEspecialista').'"><h5>Avaliação com Especialista</h5></a></li>
																	';
        
        echo "
                                                            </ul>
                                                    </div>";
}														
else if($menu2 == 'DocumentosObrigatorios'){
		if(!isset($_POST['vaga'])){
				echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                            <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>";
				$attributes = array('class' => 'kt-form',
                                    'id' => 'form_relatorios');
                
                echo form_open($url, $attributes);
				echo " 
															<div class=\"kt-portlet__body\">
																	<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Vaga', 'vaga', $attributes);
                echo "
																			<div class=\"col-lg-6\">";
                
                
                
                
                echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
                
                echo "
																			</div>
																	</div>
																	<div class=\"j-footer\">
																			<hr>
																			<div class=\"row\">
																					<div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('carregar', 'Carregar relatório', $attributes);
                echo "
																							<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																					</div>
																			</div>
																	</div>
															</form>
													</div>";
                											
		}
		else{
				echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                            <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
                                                                            <thead>
                                                                                    <tr>
																							<th>Nome do candidato</th>
																							<th>Gênero</th>
                                                                                            <th>CPF</th>
																							<th>Documento de identificação</th>
																							<th>Idade</th>
                                                                                            <th>E-mail</th>
																							<th>Status</th>
																							";
				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								echo "
																							<th>".strip_tags($questao -> tx_questao)."</th>
								";
						}
				}		
				echo "
                                                                                            
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
				if(isset($candidaturas)){
						$sexo = array(
						0 => '',
						1 => 'Não informado',
						2 => 'Masculino',
						3 => 'Feminino',
						4 => 'Prefiro não declarar'
						);
						foreach ($candidaturas as $linha){
								/*$dt_candidatura = mysql_to_unix($linha -> dt_candidatura);
								$dt_fim = mysql_to_unix($linha -> dt_fim);*/
								if(isset($candidato[$linha -> pr_candidatura])){
										echo "
                                                                                    <tr>
																							<td>".@$candidato[$linha -> pr_candidatura] -> vc_nome."</td>
																							<td>".@$sexo[$candidato[$linha -> pr_candidatura] -> in_genero]."</td>
                                                                                            <td>".@$candidato[$linha -> pr_candidatura] -> ch_cpf."</td>
                                                                                            <td>".@$candidato[$linha -> pr_candidatura] -> vc_rg."</td>
																							
																							<td>";
										$dataNascimento = @$candidato[$linha -> pr_candidatura] -> dt_nascimento;
										$date = new DateTime($dataNascimento );
										$interval = $date->diff( new DateTime( date('Y-m-d') ) );
										echo $interval->format( '%Y anos' );													
										echo "</td>
																							<td>".@$candidato[$linha -> pr_candidatura] -> vc_email."</td>
																							<td>".$linha -> vc_status."</td>
																							";
										foreach ($questoes as $questao){
												if($questao -> in_tipo == '7'){
														echo "
																							<td>";
														if(isset($anexos[$linha -> pr_candidatura][$questao -> pr_questao])){
																/*$vc_anexo = $anexos[$linha -> pr_candidatura][$questao -> pr_questao][0]->vc_arquivo;
																$pr_arquivo = $anexos[$linha -> pr_candidatura][$questao -> pr_questao][0]->pr_anexo;
																echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";*/
																echo "Inserido";
														}
														else{
																echo "Não inserido";
														}
														echo "
																							</td>";
												}
												else if($questao -> in_tipo == 3){
														$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
														echo "
																							<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
												";
												}
												else if($questao -> in_tipo == 4){
														$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
														echo "
																							<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
														";
												}
										}																	
										echo "
                                                                                    </tr>";
								}
						}
				}
				echo "
                                                                            </tbody>
                                                                    </table>
																	<div class=\"j-footer\">
																			<hr>
																			<div class=\"row\">
																					<div class=\"col-lg-12 text-center\">
																							<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/DocumentosObrigatorios')."'\">Retornar para a escolha da vaga</button>
																							<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_DocumentosObrigatorios/'.$vaga[0] -> pr_vaga)."'\">Gerar planilha</button>
																					</div>
																			</div>
																	</div>
                                                            </div>
                                                    </div>";

				$pagina['js'] = "
											
													<script type=\"text/javascript\">
															$('#relatorios_table').DataTable({
																	columnDefs: [
																			{  // set default column settings
																				'orderable': false,
																				'targets': [-1]
																			},
																			{
																				'searchable': false,
																				'targets': [-1]
																			}
																	],
																	aLengthMenu: [
																		[10, 25, 50, 100, -1],
																		[10, 25, 50, 100, \"Todos\"]
																	],
																	order: [
																		[0, 'asc']
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
		}
        
}
else if($menu2 == 'RequisitosDesejaveis'){
	if(!isset($_POST['vaga'])){
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>";
			$attributes = array('class' => 'kt-form',
								'id' => 'form_relatorios');
			
			echo form_open($url, $attributes);
			echo " 
														<div class=\"kt-portlet__body\">
																<div class=\"form-group row\">";
			$attributes = array('class' => 'col-lg-3 col-form-label text-right');
			echo form_label('Vaga', 'vaga', $attributes);
			echo "
																		<div class=\"col-lg-6\">";
			
			
			
			
			echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
			
			echo "
																		</div>
																</div>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">";
			$attributes = array('class' => 'btn btn-primary');
			echo form_submit('carregar', 'Carregar relatório', $attributes);
			echo "
																						<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																				</div>
																		</div>
																</div>
														</form>
												</div>";
														
	}
	else{
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>
														<div class=\"dt-responsive table-responsive\">
																<table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
																		<thead>
																				<tr>
																						<th>Nome do candidato</th>
																						<th>Gênero</th>
																						<th>CPF</th>
																						<th>Documento de identificação</th>
																						<th>Idade</th>
																						<th>E-mail</th>
																						<th>Status</th>
																						";
																						
			if(isset($questoes)){																					
					foreach ($questoes as $questao){
							echo "
																						<th>".strip_tags($questao -> tx_questao)."</th>
							";
					}
			}		
			echo "
																						
																				</tr>
																		</thead>
																		<tbody>";
			if(isset($candidaturas)){
					$sexo = array(
					0 => '',
					1 => 'Não informado',
					2 => 'Masculino',
					3 => 'Feminino',
					4 => 'Prefiro não declarar'
					);
					foreach ($candidaturas as $linha){
							/*$dt_candidatura = mysql_to_unix($linha -> dt_candidatura);
							$dt_fim = mysql_to_unix($linha -> dt_fim);*/
							if(isset($candidato[$linha -> pr_candidatura])){
									echo "
																				<tr>
																						<td>".@$candidato[$linha -> pr_candidatura] -> vc_nome."</td>
																						<td>".@$sexo[$candidato[$linha -> pr_candidatura] -> in_genero]."</td>
																						<td>".@$candidato[$linha -> pr_candidatura] -> ch_cpf."</td>
																						<td>".@$candidato[$linha -> pr_candidatura] -> vc_rg."</td>
																						
																						<td>";
									$dataNascimento = @$candidato[$linha -> pr_candidatura] -> dt_nascimento;
									$date = new DateTime($dataNascimento );
									$interval = $date->diff( new DateTime( date('Y-m-d') ) );
									echo $interval->format( '%Y anos' );													
									echo "</td>
																						<td>".@$candidato[$linha -> pr_candidatura] -> vc_email."</td>
																						<td>".$linha -> vc_status."</td>
																						";
									foreach ($questoes as $questao){
											if($questao -> in_tipo == '7'){
													echo "
																						<td>";
													if(isset($anexos[$linha -> pr_candidatura][$questao -> pr_questao])){
															/*$vc_anexo = $anexos[$linha -> pr_candidatura][$questao -> pr_questao][0]->vc_arquivo;
															$pr_arquivo = $anexos[$linha -> pr_candidatura][$questao -> pr_questao][0]->pr_anexo;
															echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";*/
															echo "Inserido";
													}
													else{
															echo "Não inserido";
													}
													echo "
																						</td>";
											}
											else if($questao -> in_tipo == 3){
													$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
													echo "
																						<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
											";
											}
											else if($questao -> in_tipo == 4){
													$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
													echo "
																						<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
													";
											}
											else if($questao -> in_tipo == 1){
													$resposta = '';
													foreach($opcoes[$questao -> pr_questao] as $opcao){
															if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){												
																	$resposta = $opcao -> tx_opcao;
															}
													}
													echo "
																					<td>".$resposta."</td>
													";
											}
											else{
													echo "
																					<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
													";	
											}
									}																	
									echo "
																				</tr>";
							}
					}
			}
			echo "
																		</tbody>
																</table>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/RequisitosDesejaveis')."'\">Retornar para a escolha da vaga</button>
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_RequisitosDesejaveis/'.$vaga[0] -> pr_vaga)."'\">Gerar planilha</button>
																				</div>
																		</div>
																</div>
														</div>
												</div>";

			$pagina['js'] = "
										
												<script type=\"text/javascript\">
														$('#relatorios_table').DataTable({
																columnDefs: [
																		{  // set default column settings
																			'orderable': false,
																			'targets': [-1]
																		},
																		{
																			'searchable': false,
																			'targets': [-1]
																		}
																],
																aLengthMenu: [
																	[10, 25, 50, 100, -1],
																	[10, 25, 50, 100, \"Todos\"]
																],
																order: [
																	[0, 'asc']
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
	}
	
}
else if($menu2 == 'AvaliacaoCurricular'){
		if(!isset($_POST['vaga'])){
				echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                            <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>";
				$attributes = array('class' => 'kt-form',
                                    'id' => 'form_relatorios');
                
                echo form_open($url, $attributes);
				echo " 
															<div class=\"kt-portlet__body\">
																	<div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label text-right');
                echo form_label('Vaga', 'vaga', $attributes);
                echo "
																			<div class=\"col-lg-6\">";
                
                
                
                
                echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
                
                echo "
																			</div>
																	</div>
																	<div class=\"j-footer\">
																			<hr>
																			<div class=\"row\">
																					<div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('carregar', 'Carregar relatório', $attributes);
                echo "
																							<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																					</div>
																			</div>
																	</div>
															</form>
													</div>";
                											
		}
		else{
				echo "
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                            <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
                                                                            <thead>
                                                                                    <tr>
																							<th>Nome</th>
																							<th>Gênero</th>
                                                                                            <th>E-mail</th>
																							<th>CPF</th>
																							<th>Idade</th>
																							<th>Status</th>
																							";
				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								if($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6'){
										echo "
																							<th>".strip_tags($questao -> tx_questao)."</th>
																							<th>Nota Questão</th>
										";
								}
						}
				}																			
				echo "
																							
																							<th>Nota bruta da Avaliação Curricular</th>
                                                                                            <th>Nota  percentual da Avaliação Curricular</th>
                                                                                            
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
				if(isset($candidaturas)){
						$sexo = array(
						0 => '',
						1 => 'Não informado',
						2 => 'Masculino',
						3 => 'Feminino',
						4 => 'Prefiro não declarar'
						);
						foreach ($candidaturas as $linha){

								echo "
                                                                                    <tr>
																							<td>".$linha -> vc_nome."</td>
																							<td>".$sexo[$linha -> 	in_genero]."</td>
                                                                                            <td class=\"text-center\">".$linha -> vc_email."</td>
																							<td class=\"text-center\">".$linha -> ch_cpf."</td>
																							<td class=\"text-center\">";
								$dataNascimento = $linha -> dt_nascimento;
								$date = new DateTime($dataNascimento );
								$interval = $date->diff( new DateTime( date('Y-m-d') ) );
								echo $interval->format( '%Y anos' );
								echo "</td>
																							<td class=\"text-center\">".$linha -> vc_status."</td>
																							";
								$total = 0;
								$maximo = 0;
								if(isset($questoes)){
										
										foreach ($questoes as $questao){
												if($questao -> in_tipo == '1'){
														$nota = 0;
														$max = 0;
														$resposta = '';
														foreach($opcoes[$questao -> pr_questao] as $opcao){

																if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																		//echo $opcao->in_valor;
																		$nota += intval($opcao->in_valor);
																		$resposta = $opcao->tx_opcao;
																}
																if($max < intval($opcao->in_valor)){
																		$max = intval($opcao->in_valor);
																}
																
																
														}
														echo "
																											<td>".$resposta."</td>
																											<td>".$nota."</td>
														";
														$total+=$nota;
														$maximo += $max;

														
												}
												else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
														if($questao -> in_tipo == '3'){
																$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
														}
														else{
																$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
														}
														echo "
																											<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
																											<td>".@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso)."</td>
														";
														$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
														$maximo += intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '5'){
														$nota = 0;
														$nota += round((@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
														$valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
														echo "
																											<td>".$valores[$linha -> pr_candidatura][$questao -> pr_questao]."</td>
																											<td>".$nota."</td>
														";
														$total+=$nota;
														$maximo += intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '6'){
														
														echo "
																											<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
																											<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
														";
														$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
														$maximo += intval($questao -> in_peso);
												}
												/*else{
														echo "
																											<td>-</td>
														";
												}*/
										}
										if($maximo == 0){
												$maximo = 1;
										}
								}															
								echo "
                                                                                            <td class=\"text-center\">
                                                                                                    {$total}
                                                                                            </td>
																							<td class=\"text-center\">
                                                                                                    ".(round(($total/$maximo)*100))."
                                                                                            </td>
																					</tr>";
								$percentual = (round(($total/$maximo)*100));													
								if($percentual > 0){
										$CI =& get_instance();
										$notas = $CI -> Candidaturas_model -> get_nota ('', $linha -> pr_candidatura, '3');                                            
										

										if(isset($notas[0] -> pr_nota) && $notas[0] -> in_nota != $percentual){
												$CI -> Candidaturas_model -> update_nota('in_nota',$percentual,$notas[0] -> pr_nota);
										}
										else{
												$dados_nota=array('candidatura'=>$linha -> pr_candidatura,'nota'=>$percentual,'etapa'=>3);
												$CI -> Candidaturas_model -> create_nota($dados_nota);
										}	
								}													
						}
				}
				echo "
                                                                            </tbody>
                                                                    </table>
																	<div class=\"j-footer\">
																			<hr>
																			<div class=\"row\">
																					<div class=\"col-lg-12 text-center\">
																							<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/AvaliacaoCurricular')."'\">Retornar para a escolha da vaga</button>
																							<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_AvaliacaoCurricular/'.$vagas[0] -> pr_vaga)."'\">Gerar planilha</button>
																					</div>
																			</div>
																	</div>
                                                            </div>
                                                    </div>";

				$pagina['js'] = "
											
													<script type=\"text/javascript\">
															$('#relatorios_table').DataTable({
																	columnDefs: [
																			{  // set default column settings
																				'orderable': false,
																				'targets': [-1]
																			},
																			{
																				'searchable': false,
																				'targets': [-1]
																			}
																	],
																	aLengthMenu: [
																		[10, 25, 50, 100, -1],
																		[10, 25, 50, 100, \"Todos\"]
																	],
																	order: [
																		[0, 'asc']
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
		}
		
}
else if($menu2 == 'AvaliacaoCompetencia'){
	if(!isset($_POST['vaga'])){
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>";
			$attributes = array('class' => 'kt-form',
								'id' => 'form_relatorios');
			
			echo form_open($url, $attributes);
			echo " 
														<div class=\"kt-portlet__body\">
																<div class=\"form-group row\">";
			$attributes = array('class' => 'col-lg-3 col-form-label text-right');
			echo form_label('Vaga', 'vaga', $attributes);
			echo "
																		<div class=\"col-lg-6\">";
			
			
			
			
			echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
			
			echo "
																		</div>
																</div>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">";
			$attributes = array('class' => 'btn btn-primary');
			echo form_submit('carregar', 'Carregar relatório', $attributes);
			echo "
																						<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																				</div>
																		</div>
																</div>
														</form>
												</div>";
														
	}
	else{
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>
														<div class=\"dt-responsive table-responsive\">
																<table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
																		<thead>
																				<tr>
																						<th>Nome</th>
																						<th>Gênero</th>
																						<th>E-mail</th>
																						<th>CPF</th>
																						<th>Idade</th>
																						<th>Status</th>
																						<th>Avaliador</th>
																						";
			if(isset($questoes)){																					
					foreach ($questoes as $questao){
							if($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6'){
									echo "
																						<th>".strip_tags($questao -> tx_questao)."</th>
																						<th>Nota Questão</th>
									";
							}
					}
			}																			
			echo "
																						
																						<th>Nota bruta da Avaliação por Competência</th>
																						<th>Nota  percentual da Avaliação por Competência</th>
																						
																				</tr>
																		</thead>
																		<tbody>";
			if(isset($candidaturas)){
					$sexo = array(
					0 => '',
					1 => 'Não informado',
					2 => 'Masculino',
					3 => 'Feminino',
					4 => 'Prefiro não declarar'
					);
					foreach ($candidaturas as $linha){

							echo "
																				<tr>
																						<td>".$linha -> vc_nome."</td>
																						<td>".$sexo[$linha -> 	in_genero]."</td>
																						<td class=\"text-center\">".$linha -> vc_email."</td>
																						<td class=\"text-center\">".$linha -> ch_cpf."</td>
																						<td class=\"text-center\">";
							$dataNascimento = $linha -> dt_nascimento;
							$date = new DateTime($dataNascimento );
							$interval = $date->diff( new DateTime( date('Y-m-d') ) );
							echo $interval->format( '%Y anos' );
							echo "</td>
																						<td class=\"text-center\">".$linha -> vc_status."</td>
																						<td class=\"text-center\">".$linha -> avaliador_competencia."</td>
																						";
							$total = 0;
							$maximo = 0;
							if(isset($questoes)){
									
									foreach ($questoes as $questao){
											if($questao -> in_tipo == '1'){
													$nota = 0;
													$max = 0;
													$resposta = '';
													foreach($opcoes[$questao -> pr_questao] as $opcao){

															if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																	//echo $opcao->in_valor;
																	$nota += intval($opcao->in_valor);
																	$resposta = $opcao->tx_opcao;
															}
															if($max < intval($opcao->in_valor)){
																	$max = intval($opcao->in_valor);
															}
															
															
													}
													echo "
																						<td>".$resposta."</td>
																						<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += $max;

													
											}
											else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
													if($questao -> in_tipo == '3'){
															$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
													}
													else{
															$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
													}
													echo "
																						<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
																						<td>".@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso)."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '5'){
													$nota = 0;
													$nota += round((@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
													$valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
													echo "
																						<td>".$valores[$linha -> pr_candidatura][$questao -> pr_questao]."</td>
																						<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '6'){
													
													echo "
																						<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
																						<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
													$maximo += intval($questao -> in_peso);
											}
											/*else{
													echo "
																										<td>-</td>
													";
											}*/
									}
							}
							if($maximo == 0){
								 	$maximo = 1;
							}															
							echo "
																						<td class=\"text-center\">
																								{$total}
																						</td>
																						<td class=\"text-center\">
																								".(round(($total/$maximo)*100))."
																						</td>
																				</tr>";
							$percentual = (round(($total/$maximo)*100));													
							if($percentual > 0){
									$CI =& get_instance();
									$notas = $CI -> Candidaturas_model -> get_nota ('', $linha -> pr_candidatura, '4');                                            
									

									if(isset($notas[0] -> pr_nota) && $notas[0] -> in_nota != $percentual){
											$CI -> Candidaturas_model -> update_nota('in_nota',$percentual,$notas[0] -> pr_nota);
									}
									else{
											$dados_nota=array('candidatura'=>$linha -> pr_candidatura,'nota'=>$percentual,'etapa'=>4);
											$CI -> Candidaturas_model -> create_nota($dados_nota);
									}	
							}													
					}
			}
			echo "
																		</tbody>
																</table>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/AvaliacaoCompetencia')."'\">Retornar para a escolha da vaga</button>
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_AvaliacaoCompetencia/'.$vagas[0] -> pr_vaga)."'\">Gerar planilha</button>
																				</div>
																		</div>
																</div>
														</div>
												</div>";

			$pagina['js'] = "
										
												<script type=\"text/javascript\">
														$('#relatorios_table').DataTable({
																columnDefs: [
																		{  // set default column settings
																			'orderable': false,
																			'targets': [-1]
																		},
																		{
																			'searchable': false,
																			'targets': [-1]
																		}
																],
																aLengthMenu: [
																	[10, 25, 50, 100, -1],
																	[10, 25, 50, 100, \"Todos\"]
																],
																order: [
																	[0, 'asc']
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
	}
	
}
else if($menu2 == 'TesteAderencia'){
	if(!isset($_POST['vaga'])){
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>";
			$attributes = array('class' => 'kt-form',
								'id' => 'form_relatorios');
			
			echo form_open($url, $attributes);
			echo " 
														<div class=\"kt-portlet__body\">
																<div class=\"form-group row\">";
			$attributes = array('class' => 'col-lg-3 col-form-label text-right');
			echo form_label('Vaga', 'vaga', $attributes);
			echo "
																		<div class=\"col-lg-6\">";
			
			
			
			
			echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
			
			echo "
																		</div>
																</div>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">";
			$attributes = array('class' => 'btn btn-primary');
			echo form_submit('carregar', 'Carregar relatório', $attributes);
			echo "
																						<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																				</div>
																		</div>
																</div>
														</form>
												</div>";
														
	}
	else{
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>
														<div class=\"dt-responsive table-responsive\">
																<table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
																		<thead>
																				<tr>
																						<th>Nome</th>
																						<th>Gênero</th>
																						<th>E-mail</th>
																						<th>CPF</th>
																						<th>Idade</th>
																						<th>Status</th>
																						
																						";
			if(isset($questoes)){																					
					foreach ($questoes as $questao){
							if($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6'){
									echo "
																						<th>".strip_tags($questao -> tx_questao)."</th>
																						<th>Nota Questão</th>
									";
							}
					}
			}																			
			echo "
																						
																						<th>Nota bruta do Teste de Aderência</th>
																						<th>Nota percentual do Teste de Aderência</th>
																						
																				</tr>
																		</thead>
																		<tbody>";
			if(isset($candidaturas)){
					$sexo = array(
					0 => '',
					1 => 'Não informado',
					2 => 'Masculino',
					3 => 'Feminino',
					4 => 'Prefiro não declarar'
					);
					foreach ($candidaturas as $linha){

							echo "
																				<tr>
																						<td>".$linha -> vc_nome."</td>
																						<td>".$sexo[$linha -> 	in_genero]."</td>
																						<td class=\"text-center\">".$linha -> vc_email."</td>
																						<td class=\"text-center\">".$linha -> ch_cpf."</td>
																						<td class=\"text-center\">";
							$dataNascimento = $linha -> dt_nascimento;
							$date = new DateTime($dataNascimento );
							$interval = $date->diff( new DateTime( date('Y-m-d') ) );
							echo $interval->format( '%Y anos' );
							echo "</td>
																						<td class=\"text-center\">".$linha -> vc_status."</td>
																						
																						";
							$total = 0;
							$maximo = 0;
							if(isset($questoes)){
									
									foreach ($questoes as $questao){
											if($questao -> in_tipo == '1'){
													$nota = 0;
													$max = 0;
													$resposta = '';
													foreach($opcoes[$questao -> pr_questao] as $opcao){

															if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																	//echo $opcao->in_valor;
																	$nota += intval($opcao->in_valor);
																	$resposta = $opcao->tx_opcao;
															}
															if($max < intval($opcao->in_valor)){
																	$max = intval($opcao->in_valor);
															}
															
															
													}
													echo "
																					<td>".$resposta."</td>
																					<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += $max;

													
											}
											else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
													if($questao -> in_tipo == '3'){
															$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
													}
													else{
															$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
													}
													echo "
																					<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
																					<td>".@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso)."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '5'){
													$nota = 0;
													$nota += round((@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
													$valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
													echo "
																					<td>".$valores[$linha -> pr_candidatura][$questao -> pr_questao]."</td>
																					<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '6'){
													
													echo "
																					<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
																					<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
													$maximo += intval($questao -> in_peso);
											}
											/*else{
													echo "
																										<td>-</td>
													";
											}*/
									}
							}
							
							if($maximo == 0){
									$maximo = 1;
							}									
							echo "
																						<td class=\"text-center\">
																								{$total}
																						</td>
																						<td class=\"text-center\">
																								".(round(($total/$maximo)*100))."
																						</td>
																				</tr>";
							$percentual = (round(($total/$maximo)*100));													
							if($percentual > 0){
									$CI =& get_instance();
									$notas = $CI -> Candidaturas_model -> get_nota ('', $linha -> pr_candidatura, '5');                                            
									

									if(isset($notas[0] -> pr_nota) && $notas[0] -> in_nota != $percentual){
											$CI -> Candidaturas_model -> update_nota('in_nota',$percentual,$notas[0] -> pr_nota);
									}
									else{
											$dados_nota=array('candidatura'=>$linha -> pr_candidatura,'nota'=>$percentual,'etapa'=>5);
											$CI -> Candidaturas_model -> create_nota($dados_nota);
									}	
							}
					}
			}
			echo "
																		</tbody>
																</table>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/TesteAderencia')."'\">Retornar para a escolha da vaga</button>
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_TesteAderencia/'.$vagas[0] -> pr_vaga)."'\">Gerar planilha</button>
																				</div>
																		</div>
																</div>
														</div>
												</div>";

			$pagina['js'] = "
										
												<script type=\"text/javascript\">
														$('#relatorios_table').DataTable({
																columnDefs: [
																		{  // set default column settings
																			'orderable': false,
																			'targets': [-1]
																		},
																		{
																			'searchable': false,
																			'targets': [-1]
																		}
																],
																aLengthMenu: [
																	[10, 25, 50, 100, -1],
																	[10, 25, 50, 100, \"Todos\"]
																],
																order: [
																	[0, 'asc']
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
	}
	
}
else if($menu2 == 'TesteMotivacao'){
	if(!isset($_POST['vaga'])){
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>";
			$attributes = array('class' => 'kt-form',
								'id' => 'form_relatorios');
			
			echo form_open($url, $attributes);
			echo " 
														<div class=\"kt-portlet__body\">
																<div class=\"form-group row\">";
			$attributes = array('class' => 'col-lg-3 col-form-label text-right');
			echo form_label('Vaga', 'vaga', $attributes);
			echo "
																		<div class=\"col-lg-6\">";
			
			
			
			
			echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
			
			echo "
																		</div>
																</div>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">";
			$attributes = array('class' => 'btn btn-primary');
			echo form_submit('carregar', 'Carregar relatório', $attributes);
			echo "
																						<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																				</div>
																		</div>
																</div>
														</form>
												</div>";
														
	}
	else{
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>
														<div class=\"dt-responsive table-responsive\">
																<table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
																		<thead>
																				<tr>
																						<th>Nome</th>
																						<th>Gênero</th>
																						<th>E-mail</th>
																						<th>CPF</th>
																						<th>Idade</th>
																						<th>Status</th>
																						
																						";
			if(isset($questoes)){																					
					foreach ($questoes as $questao){
							if($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6'){
									echo "
																						<th>".strip_tags($questao -> tx_questao)."</th>
																						<th>Nota Questão</th>
									";
							}
					}
			}																			
			echo "
																						
																						<th>Nota bruta do Teste de Motivação</th>
																						<th>Nota percentual do Teste de Motivação</th>
																						
																				</tr>
																		</thead>
																		<tbody>";
			if(isset($candidaturas)){
					$sexo = array(
					0 => '',
					1 => 'Não informado',
					2 => 'Masculino',
					3 => 'Feminino',
					4 => 'Prefiro não declarar'
					);
					foreach ($candidaturas as $linha){

							echo "
																				<tr>
																						<td>".$linha -> vc_nome."</td>
																						<td>".$sexo[$linha -> 	in_genero]."</td>
																						<td class=\"text-center\">".$linha -> vc_email."</td>
																						<td class=\"text-center\">".$linha -> ch_cpf."</td>
																						<td class=\"text-center\">";
							$dataNascimento = $linha -> dt_nascimento;
							$date = new DateTime($dataNascimento );
							$interval = $date->diff( new DateTime( date('Y-m-d') ) );
							echo $interval->format( '%Y anos' );
							echo "</td>
																						<td class=\"text-center\">".$linha -> vc_status."</td>
																						
																						";
							$total = 0;
							$maximo = 0;
							if(isset($questoes)){
									
									foreach ($questoes as $questao){
											if($questao -> in_tipo == '1'){
													$nota = 0;
													$max = 0;
													$resposta = '';
													foreach($opcoes[$questao -> pr_questao] as $opcao){

															if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																	//echo $opcao->in_valor;
																	$nota += intval($opcao->in_valor);
																	$resposta = $opcao->tx_opcao;
															}
															if($max < intval($opcao->in_valor)){
																	$max = intval($opcao->in_valor);
															}
															
															
													}
													echo "
																					<td>".$resposta."</td>
																					<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += $max;

													
											}
											else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
													if($questao -> in_tipo == '3'){
															$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
													}
													else{
															$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
													}
													echo "
																					<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
																					<td>".@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso)."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '5'){
													$nota = 0;
													$nota += round((@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
													$valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
													echo "
																					<td>".$valores[$linha -> pr_candidatura][$questao -> pr_questao]."</td>
																					<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '6'){
													
													echo "
																					<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
																					<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
													$maximo += intval($questao -> in_peso);
											}
											/*else{
													echo "
																										<td>-</td>
													";
											}*/
									}
							}
							
							if($maximo == 0){
									$maximo = 1;
							}									
							echo "
																						<td class=\"text-center\">
																								{$total}
																						</td>
																						<td class=\"text-center\">
																								".(round(($total/$maximo)*100))."
																						</td>
																				</tr>";
							$percentual = (round(($total/$maximo)*100));													
							if($percentual > 0){
									$CI =& get_instance();
									$notas = $CI -> Candidaturas_model -> get_nota ('', $linha -> pr_candidatura, '5');                                            
									

									if(isset($notas[0] -> pr_nota) && $notas[0] -> in_nota != $percentual){
											$CI -> Candidaturas_model -> update_nota('in_nota',$percentual,$notas[0] -> pr_nota);
									}
									else{
											$dados_nota=array('candidatura'=>$linha -> pr_candidatura,'nota'=>$percentual,'etapa'=>5);
											$CI -> Candidaturas_model -> create_nota($dados_nota);
									}	
							}
					}
			}
			echo "
																		</tbody>
																</table>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/TesteMotivacao')."'\">Retornar para a escolha da vaga</button>
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_TesteMotivacao/'.$vagas[0] -> pr_vaga)."'\">Gerar planilha</button>
																				</div>
																		</div>
																</div>
														</div>
												</div>";

			$pagina['js'] = "
										
												<script type=\"text/javascript\">
														$('#relatorios_table').DataTable({
																columnDefs: [
																		{  // set default column settings
																			'orderable': false,
																			'targets': [-1]
																		},
																		{
																			'searchable': false,
																			'targets': [-1]
																		}
																],
																aLengthMenu: [
																	[10, 25, 50, 100, -1],
																	[10, 25, 50, 100, \"Todos\"]
																],
																order: [
																	[0, 'asc']
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
	}
	
}
else if($menu2 == 'HBDI'){
	if(!isset($_POST['vaga'])){
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>";
			$attributes = array('class' => 'kt-form',
								'id' => 'form_relatorios');
			
			echo form_open($url, $attributes);
			echo " 
														<div class=\"kt-portlet__body\">
																<div class=\"form-group row\">";
			$attributes = array('class' => 'col-lg-3 col-form-label text-right');
			echo form_label('Vaga', 'vaga', $attributes);
			echo "
																		<div class=\"col-lg-6\">";
			
			
			
			
			echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
			
			echo "
																		</div>
																</div>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">";
			$attributes = array('class' => 'btn btn-primary');
			echo form_submit('carregar', 'Carregar relatório', $attributes);
			echo "
																						<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																				</div>
																		</div>
																</div>
														</form>
												</div>";
														
	}
	else{
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>
														<div class=\"dt-responsive table-responsive\">
																<table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
																		<thead>
																				<tr>
																						<th>Nome</th>
																						<th>Gênero</th>
																						<th>E-mail</th>
																						<th>CPF</th>
																						<th>Idade</th>
																						<th>Status</th>
																						<th>1. Quais sentidos ou situações fazem você se sentir mais motivado no trabalho?</th>
																						<th>2. Quando aprendo, gosto de...</th>
																						<th>3. Prefiro aprender por meio de…</th>
																						<th>4. Qual o tipo de pergunta que você mais gosta de fazer?</th>
																						<th>5. O que você mais gosta de fazer?</th>
																						<th>6. Ao comprar um carro você…</th>
																						<th>7. Como você define seu comportamento?</th>
																						<th>8. Palavras que definem meu estilo...</th>
																						<th>9. Quais as frases que você mais ouve dos outros em relação a seus \"pontos fracos\"?</th>
																						<th>10. Quando tenho que resolver um problema, eu geralmente…</th>
																						<th>11. Quando tenho que resolver um problema, eu procuro…</th>
																						<th>12. Quais as frases que mais se aproximam do que você diz?</th>
																						<th>Superior Direito</th>
																						<th>Superior Esquerdo</th>
																						<th>Inferior Direito</th>
																						<th>Inferior Esquerdo</th>
																				</tr>
																		</thead>
																		<tbody>";
			if(isset($candidaturas)){
					
					$sexo = array(
					0 => '',
					1 => 'Não informado',
					2 => 'Masculino',
					3 => 'Feminino',
					4 => 'Prefiro não declarar'
					);
					foreach ($candidaturas as $linha){

							echo "
																				<tr>
																						<td>".$linha -> vc_nome."</td>
																						<td>".$sexo[$linha -> 	in_genero]."</td>
																						<td class=\"text-center\">".$linha -> vc_email."</td>
																						<td class=\"text-center\">".$linha -> ch_cpf."</td>
																						<td class=\"text-center\">";
							$dataNascimento = $linha -> dt_nascimento;
							$date = new DateTime($dataNascimento );
							$interval = $date->diff( new DateTime( date('Y-m-d') ) );
							echo $interval->format( '%Y anos' );
							echo "</td>
																						<td class=\"text-center\">".$linha -> vc_status."</td>
																						<td class=\"text-center\">";
							//Calcula pelo lado do cérebro, com somatório simples, dependendo da resposta
							$sd = 0;
							$se = 0;
							$ie = 0;
							$id = 0;															
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho1 == '1'){
											echo "1.1 Trabalhar sozinho<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho2 == '1'){
											echo "1.2 Expressar minhas ideias<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho3 == '1'){
											echo "1.3 Estar no controle da situação<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho4 == '1'){
											echo "1.4 Provocar mudanças<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho5 == '1'){
											echo "1.5 Ouvir e falar<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho6 == '1'){
											echo "1.6 Criar ou usar recursos visuais<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho7 == '1'){
											echo "1.7 Prestar atenção aos detalhes<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho8 == '1'){
											echo "1.8 Aspectos técnicos<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho9 == '1'){
											echo "1.9 Trabalhar com pessoas<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho10 == '1'){
											echo "1.10 Usar números e estatísticas<br />";
											++$se;

									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho11 == '1'){
											echo "1.11 Oportunidades para fazer experiências<br />";
											++$sd;

									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho12 == '1'){
											echo "1.12 Planejar<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho13 == '1'){
											echo "1.13 Trabalhar com comunicação<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho14 == '1'){
											echo "1.14 Fazer algo funcionar<br />";
											++$se;

									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho15 == '1'){
											echo "1.15 Arriscar-se<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho16 == '1'){
											echo "1.16 Analisar dados<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho17 == '1'){
											echo "1.17 Lidar com o futuro<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho18 == '1'){
											echo "1.18 Produzir e organizar<br />";
											++$ie;

									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho19 == '1'){
											echo "1.19 Fazer parte de uma equipe<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_motivacao_trabalho20 == '1'){
											echo "1.20 Fazer as coisas sempre no prazo previsto<br />";
											++$ie;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_gosto1 == '1'){
											echo "2.1 Avaliar e testar teorias<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto2 == '1'){
											echo "2.2 Obter e quantificar fatos<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto3 == '1'){
											echo "2.3 Ouvir e compartilhar ideias<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto4 == '1'){
											echo "2.4 Usar minha imaginação<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto5 == '1'){
											echo "2.5 Aplicar análise e lógica<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto6 == '1'){
											echo "2.6 Ambiente bem informal<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto7 == '1'){
											echo "2.7 Verificar meu entendimento<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto8 == '1'){
											echo "2.8 Fazer experiências práticas<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto9 == '1'){
											echo "2.9 Pensar sobre as ideias<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto10 == '1'){
											echo "2.10 Confiar nas intuições<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto11 == '1'){
											echo "2.11 Receber informações passo a passo<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto12 == '1'){
											echo "2.12 Tomar iniciativas<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto13 == '1'){
											echo "2.13 Elaborar teorias<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto14 == '1'){
											echo "2.14 Envolvimento emocional<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto15 == '1'){
											echo "2.15 Trabalhar em grupo<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto16 == '1'){
											echo "2.16 Orientações claras<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto17 == '1'){
											echo "2.17 Fazer descobertas<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto18 == '1'){
											echo "2.18 Criticar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto19 == '1'){
											echo "2.19 Perceber logo o quadro geral (o objetivo final)<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_gosto20 == '1'){
											echo "2.20 Adquirir habilidades pela prática<br />";
											++$ie;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro1 == '1'){
											echo "3.1 Materiais visuais<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro2 == '1'){
											echo "3.2 Demonstrações<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro3 == '1'){
											echo "3.3 Debates estruturados pelo instrutor<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro4 == '1'){
											echo "3.4 Palestras formais<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro5 == '1'){
											echo "3.5 Experiências<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro6 == '1'){
											echo "3.6 Utilizando histórias e música<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro7 == '1'){
											echo "3.7 Exercícios que usam a intuição<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro8 == '1'){
											echo "3.8 Debate em grupo<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro9 == '1'){
											echo "3.9 Exercícios de análise<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro10 == '1'){
											echo "3.10 Atividades sequenciais bem planejadas<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro11 == '1'){
											echo "3.11 Analisando números; dados e fatos<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro12 == '1'){
											echo "3.12 Exemplos com metáforas<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro13 == '1'){
											echo "3.13 Atividades passo a passo de reforço do conteúdo<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro14 == '1'){
											echo "3.14 Leitura de livros-textos<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro15 == '1'){
											echo "3.15 Discussões de casos voltados para as pessoas<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro16 == '1'){
											echo "3.16 Discussões de casos voltados para os números e fatos<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro17 == '1'){
											echo "3.17 Métodos tradicionais comprovados<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro18 == '1'){
											echo "3.18 Agenda bem flexível<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro19 == '1'){
											echo "3.19 Agenda estruturada com antecedência<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_prefiro20 == '1'){
											echo "3.20 Trabalhos bem estruturados<br />";
											++$id;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> in_pergunta == '1'){
											echo "4.1 O que?<br />";
											++$se;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_pergunta == '2'){
											echo "4.2 Como?<br />";
											++$ie;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_pergunta == '3'){
											echo "4.3 Por que?<br />";
											++$sd;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_pergunta == '4'){
											echo "4.4 Quem?<br />";
											++$id;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_fazer1 == '1'){
											echo "5.1 Descobrir<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer2 == '1'){
											echo "5.2 Quantificar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer3 == '1'){
											echo "5.3 Envolver<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer4 == '1'){
											echo "5.4 Organizar<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer5 == '1'){
											echo "5.5 Conceituar<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer6 == '1'){
											echo "5.6 Analisar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer7 == '1'){
											echo "5.7 Sentir<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer8 == '1'){
											echo "5.8 Praticar<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer9 == '1'){
											echo "5.9 Teorizar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer10 == '1'){
											echo "5.10 Sintetizar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer11 == '1'){
											echo "5.11 Avaliar<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer12 == '1'){
											echo "5.12 Interiorizar<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer13 == '1'){
											echo "5.13 Processar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer14 == '1'){
											echo "5.14 Ordenar<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer15 == '1'){
											echo "5.15 Explorar<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_fazer16 == '1'){
											echo "5.16 Compartilhar<br />";
											++$id;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_comprar1 == '1'){
											echo "6.1 Compra com base na recomendação de amigos<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar2 == '1'){
											echo "6.2 Se preocupa com o consumo de combustível<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar3 == '1'){
											echo "6.3 Se preocupa com as forma; a cor e a tecnologia<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar4 == '1'){
											echo "6.4 Verifica equipamento de segurança e durabilidade<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar5 == '1'){
											echo "6.5 Dá importância à \"sensação\" de conforto do veículo<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar6 == '1'){
											echo "6.6 Faz comparações com outros veículos<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar7 == '1'){
											echo "6.7 Verificar tamanho do porta-malas<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar8 == '1'){
											echo "6.8 Verifica se encaixa no seu sonho de vida<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar9 == '1'){
											echo "6.9 Pesquisa e planeja antecipadamente como vai utilizá-lo<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar10 == '1'){
											echo "6.10 Se preocupa com o custo e o valor de troca<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar11 == '1'){
											echo "6.11 Quer \"amar\" o carro<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar12 == '1'){
											echo "6.12 Prefere carros lançados recentemente<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar13 == '1'){
											echo "6.13 Se preocupa com os requisitos técnicos<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar14 == '1'){
											echo "6.14 Verifica a facilidade de manutenção<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar15 == '1'){
											echo "6.15 Gosta de experimentar um novo modelo ou fabricante<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar16 == '1'){
											echo "6.16 Se preocupa com o nome do fabricante<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar17 == '1'){
											echo "6.17 Dá importância à opinião das pessoas<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar18 == '1'){
											echo "6.18 Quer ver dados e estatísticas sobre o desempenho<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar19 == '1'){
											echo "6.19 Se preocupa com a qualidade do atendimento do revendedor<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_comprar20 == '1'){
											echo "6.20 Analisa como o carro vai ser útil no seu dia-a-dia<br />";
											++$ie;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> in_comportamento == '1'){
											echo "7.1 Gosto de organizar<br />";
											++$ie;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_comportamento == '2'){
											echo "7.2 Gosto de compartilhar<br />";
											++$id;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_comportamento == '3'){
											echo "7.3 Gosto de analisar<br />";
											++$se;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_comportamento == '4'){
											echo "7.4 Gosto de descobrir<br />";
											++$sd;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_estilo1 == '1'){
											echo "8.1 Organizado<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo2 == '1'){
											echo "8.2 Analítico<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo3 == '1'){
											echo "8.3 Emocional<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo4 == '1'){
											echo "8.4 Experimental<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo5 == '1'){
											echo "8.5 Lógico<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo6 == '1'){
											echo "8.6 Conceitual<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo7 == '1'){
											echo "8.7 Perceptivo<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo8 == '1'){
											echo "8.8 Sequencial<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo9 == '1'){
											echo "8.9 Teórico<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo10 == '1'){
											echo "8.10 Explorador<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo11 == '1'){
											echo "8.11 Avaliador<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo12 == '1'){
											echo "8.12 Cinestésico<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo13 == '1'){
											echo "8.13 Sentimental<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo14 == '1'){
											echo "8.14 Preparado<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo15 == '1'){
											echo "8.15 Quantitativo<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_estilo16 == '1'){
											echo "8.16 Sintético<br />";
											++$sd;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco1 == '1'){
											echo "9.1 Viciado em números<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco2 == '1'){
											echo "9.2 Coração mole<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco3 == '1'){
											echo "9.3 Exigente; esforçado<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco4 == '1'){
											echo "9.4 Vive no mundo da lua<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco5 == '1'){
											echo "9.5 Tem sede de poder<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco6 == '1'){
											echo "9.6 Fala demais<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco7 == '1'){
											echo "9.7 Não decide sozinho<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco8 == '1'){
											echo "9.8 Não sabe se concentrar<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco9 == '1'){
											echo "9.9 Frio; insensível<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco10 == '1'){
											echo "9.10 Fácil de convencer<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco11 == '1'){
											echo "9.11 Sem imaginação<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco12 == '1'){
											echo "9.12 Maluco<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco13 == '1'){
											echo "9.13 Calculista<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco14 == '1'){
											echo "9.14 Ingênuo<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco15 == '1'){
											echo "9.15 Bitolado<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco16 == '1'){
											echo "9.16 Inconsequente<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco17 == '1'){
											echo "9.17 Não se mistura<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco18 == '1'){
											echo "9.18 Ultrassensível<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco19 == '1'){
											echo "9.19 Quadrado<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_ponto_fraco20 == '1'){
											echo "9.20 Sem disciplina<br />";
											++$sd;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> in_resolver == '1'){
											echo "10.1 Visualizo os fatos; tratando-os de forma intuitiva e holística<br />";
											++$sd;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_resolver == '2'){
											echo "10.2 Organizo os fatos; tratando os detalhes de forma realista e cronológica<br />";
											++$ie;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_resolver == '3'){
											echo "10.3 Sinto os fatos; tratando-os de forma expressiva e interpessoal<br />";
											++$id;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_resolver == '4'){
											echo "10.4 Analiso os fatos; tratando-os de forma lógica e racional<br />";
											++$se;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> in_procuro == '1'){
											echo "11.1 Uma visão interpessoal; emocional; humana<br />";
											++$id;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_procuro == '2'){
											echo "11.2 Uma visão organizada; detalhada; cronológica<br />";
											++$ie;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_procuro == '3'){
											echo "11.3 Uma visão analítica; lógica; racional; de resultados<br />";
											++$se;
									}
									else if($hbdi[$linha->pr_candidatura] -> in_procuro == '4'){
											echo "11.4 Uma visão intuitiva; conceitual; visual; de contexto geral<br />";
											++$sd;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">";
							if(isset($hbdi[$linha->pr_candidatura])){															
									if($hbdi[$linha->pr_candidatura] -> bl_frase1 == '1'){
											echo "12.1 Sempre fazemos desta forma<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase2 == '1'){
											echo "12.2 Vamos ao ponto-chave do problema<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase3 == '1'){
											echo "12.3 Vejamos os valores humanos<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase4 == '1'){
											echo "12.4 Vamos analisar<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase5 == '1'){
											echo "12.5 Vamos ver o quadro geral<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase6 == '1'){
											echo "12.6 Vamos ver o desenvolvimento de equipe<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase7 == '1'){
											echo "12.7 Vamos conhecer o resultado<br />";
											++$se;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase8 == '1'){
											echo "12.8 Este é o grande sucesso conceitual<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase9 == '1'){
											echo "12.9 Vamos manter a lei e a ordem<br />";
											++$ie;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase10 == '1'){
											echo "12.10 Vamos inovar e criar sinergia<br />";
											++$sd;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase11 == '1'){
											echo "12.11 Vamos participar e envolver<br />";
											++$id;
									}
									if($hbdi[$linha->pr_candidatura] -> bl_frase12 == '1'){
											echo "12.12 É mais seguro desta forma<br />";
											++$ie;
									}
							}														
							echo "</td>
																						<td class=\"text-center\">{$sd}</td>
																						<td class=\"text-center\">{$se}</td>
																						<td class=\"text-center\">{$id}</td>
																						<td class=\"text-center\">{$ie}</td>
																				</tr>";
					}
			}
			echo "
																		</tbody>
																</table>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/HBDI')."'\">Retornar para a escolha da vaga</button>
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_HBDI/'.$vagas[0] -> pr_vaga)."'\">Gerar planilha</button>
																				</div>
																		</div>
																</div>
														</div>
												</div>";

			$pagina['js'] = "
										
												<script type=\"text/javascript\">
														$('#relatorios_table').DataTable({
																columnDefs: [
																		{  // set default column settings
																			'orderable': false,
																			'targets': [-1]
																		},
																		{
																			'searchable': false,
																			'targets': [-1]
																		}
																],
																aLengthMenu: [
																	[10, 25, 50, 100, -1],
																	[10, 25, 50, 100, \"Todos\"]
																],
																order: [
																	[0, 'asc']
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
	}
	
}
else if($menu2 == 'AvaliacaoEspecialista'){
	if(!isset($_POST['vaga'])){
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>";
			$attributes = array('class' => 'kt-form',
								'id' => 'form_relatorios');
			
			echo form_open($url, $attributes);
			echo " 
														<div class=\"kt-portlet__body\">
																<div class=\"form-group row\">";
			$attributes = array('class' => 'col-lg-3 col-form-label text-right');
			echo form_label('Vaga', 'vaga', $attributes);
			echo "
																		<div class=\"col-lg-6\">";
			
			
			
			
			echo form_dropdown('vaga', $vagas, '', "class=\"form-control\"");
			
			echo "
																		</div>
																</div>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">";
			$attributes = array('class' => 'btn btn-primary');
			echo form_submit('carregar', 'Carregar relatório', $attributes);
			echo "
																						<button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Relatorios/index')."'\">Cancelar</button>
																				</div>
																		</div>
																</div>
														</form>
												</div>";
														
	}
	else{
			echo "
														<div class=\"row sub-title\" style=\"letter-spacing:0px\">
																<div class=\"col-lg-8\">
																		<h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
																</div>
														</div>
														<div class=\"dt-responsive table-responsive\">
																<table id=\"relatorios_table\" class=\"table table-striped table-bordered table-hover nowrap\">
																		<thead>
																				<tr>
																						<th>Nome</th>
																						<th>Gênero</th>
																						<th>E-mail</th>
																						<th>CPF</th>
																						<th>Idade</th>
																						<th>Status</th>
																						<th>Avaliador</th>
																						";
			if(isset($questoes)){																					
					foreach ($questoes as $questao){
							if($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6'){
									echo "
																						<th>".strip_tags($questao -> tx_questao)."</th>
																						<th>Nota Questão</th>
									";
							}
					}
			}																			
			echo "
																						
																						<th>Nota bruta da Avaliação Especialista</th>
																						<th>Nota  percentual da Avaliação Especialista</th>
																						
																				</tr>
																		</thead>
																		<tbody>";
			if(isset($candidaturas)){
					$sexo = array(
					0 => '',
					1 => 'Não informado',
					2 => 'Masculino',
					3 => 'Feminino',
					4 => 'Prefiro não declarar'
					);
					foreach ($candidaturas as $linha){

							echo "
																				<tr>
																						<td>".$linha -> vc_nome."</td>
																						<td>".$sexo[$linha -> 	in_genero]."</td>
																						<td class=\"text-center\">".$linha -> vc_email."</td>
																						<td class=\"text-center\">".$linha -> ch_cpf."</td>
																						<td class=\"text-center\">";
							$dataNascimento = $linha -> dt_nascimento;
							$date = new DateTime($dataNascimento );
							$interval = $date->diff( new DateTime( date('Y-m-d') ) );
							echo $interval->format( '%Y anos' );
							echo "</td>
																						<td class=\"text-center\">".$linha -> vc_status."</td>
																						<td class=\"text-center\">".$linha -> avaliador_especialista."</td>
																						";
							$total = 0;
							$maximo = 0;
							if(isset($questoes)){
									
									foreach ($questoes as $questao){
											if($questao -> in_tipo == '1'){
													$nota = 0;
													$max = 0;
													$resposta = '';
													foreach($opcoes[$questao -> pr_questao] as $opcao){

															if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																	//echo $opcao->in_valor;
																	$nota += intval($opcao->in_valor);
																	$resposta = $opcao->tx_opcao;
															}
															if($max < intval($opcao->in_valor)){
																	$max = intval($opcao->in_valor);
															}
															
															
													}
													echo "
																						<td>".$resposta."</td>
																						<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += $max;

													
											}
											else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
													if($questao -> in_tipo == '3'){
															$array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
													}
													else{
															$array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
													}
													echo "
																						<td>".@$array_resposta[$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]."</td>
																						<td>".@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso)."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '5'){
													$nota = 0;
													$nota += round((@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
													$valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
													echo "
																						<td>".$valores[$linha -> pr_candidatura][$questao -> pr_questao]."</td>
																						<td>".$nota."</td>
													";
													$total+=$nota;
													$maximo += intval($questao -> in_peso);
											}
											else if($questao -> in_tipo == '6'){
													
													echo "
																						<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
																						<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
													";
													$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
													$maximo += intval($questao -> in_peso);
											}
											/*else{
													echo "
																										<td>-</td>
													";
											}*/
									}
							}
							if($maximo == 0){
									$maximo = 1;
							}															
							echo "
																						<td class=\"text-center\">
																								{$total}
																						</td>
																						<td class=\"text-center\">
																								".(round(($total/$maximo)*100))."
																						</td>
																				</tr>";
							$percentual = (round(($total/$maximo)*100));													
							if($percentual > 0){
									$CI =& get_instance();
									$notas = $CI -> Candidaturas_model -> get_nota ('', $linha -> pr_candidatura, '6');                                            
									

									if(isset($notas[0] -> pr_nota) && $notas[0] -> in_nota != $percentual){
											$CI -> Candidaturas_model -> update_nota('in_nota',$percentual,$notas[0] -> pr_nota);
									}
									else{
											$dados_nota=array('candidatura'=>$linha -> pr_candidatura,'nota'=>$percentual,'etapa'=>6);
											$CI -> Candidaturas_model -> create_nota($dados_nota);
									}	
							}
					}
			}
			echo "
																		</tbody>
																</table>
																<div class=\"j-footer\">
																		<hr>
																		<div class=\"row\">
																				<div class=\"col-lg-12 text-center\">
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/AvaliacaoEspecialista')."'\">Retornar para a escolha da vaga</button>
																						<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Relatorios/csv_AvaliacaoEspecialista/'.$vagas[0] -> pr_vaga)."'\">Gerar planilha</button>
																				</div>
																		</div>
																</div>
														</div>
												</div>";

			$pagina['js'] = "
										
												<script type=\"text/javascript\">
														$('#relatorios_table').DataTable({
																columnDefs: [
																		{  // set default column settings
																			'orderable': false,
																			'targets': [-1]
																		},
																		{
																			'searchable': false,
																			'targets': [-1]
																		}
																],
																aLengthMenu: [
																	[10, 25, 50, 100, -1],
																	[10, 25, 50, 100, \"Todos\"]
																],
																order: [
																	[0, 'asc']
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
	}
	
}

echo "
                                            </div>";

$this->load->view('templates/internaRodape', $pagina);

?>