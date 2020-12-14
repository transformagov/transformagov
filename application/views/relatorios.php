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

$this -> load -> view('internaCabecalho', $pagina);
$this -> load -> view('internaMenu', $pagina);

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
																	<li><a href="'.base_url('Relatorios/AvaliacaoCurricular').'"><h5>Avaliação Curricular</h5></a></li>
																	';
        
        echo "
                                                            </ul>
                                                    </div>";
}														
if($menu2 == 'DocumentosObrigatorios'){
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
                                                                                            <th>CPF</th>
																							<th>Documento de identificação</th>
																							<th>Idade</th>
                                                                                            <th>E-mail</th>
																							<th>Status</th>
																							";
				if(isset($questoes)){																					
						foreach ($questoes as $questao){
								echo "
																							<th>{$questao -> tx_questao}</th>
								";
						}
				}		
				echo "
                                                                                            
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
				if(isset($candidaturas)){
						foreach ($candidaturas as $linha){
								/*$dt_candidatura = mysql_to_unix($linha -> dt_candidatura);
								$dt_fim = mysql_to_unix($linha -> dt_fim);*/
								if(isset($candidato[$linha -> pr_candidatura])){
										echo "
                                                                                    <tr>
                                                                                            <td>".@$candidato[$linha -> pr_candidatura] -> vc_nome."</td>
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
                                                                                            <th>E-mail</th>
																							<th>CPF</th>
																							<th>Idade</th>
																							<th>Status</th>
																							";
				if(isset($questoes)){																					
						foreach ($questoes as $questao){

								echo "
																							<th>{$questao -> tx_questao}</th>
								";
						}
				}																			
				echo "
																							
																							<th>Nota bruta da Avaliação Curricular</th>
                                                                                            <th>Nota  percentual da Avaliação Curricular</th>
                                                                                            
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
				if(isset($candidaturas)){
						foreach ($candidaturas as $linha){

								echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome."</td>
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
														foreach($opcoes[$questao -> pr_questao] as $opcao){

																if(@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
																		//echo $opcao->in_valor;
																		$nota += intval($opcao->in_valor);
																}
																if($max < intval($opcao->in_valor)){
																		$max = intval($opcao->in_valor);
																}
																
																
														}
														echo "
																											<td>".$nota."</td>
														";
														$total+=$nota;
														$maximo += $max;

														
												}
												else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
														echo "
																											<td>".@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso)."</td>
														";
														$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
														$maximo += intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '5'){
														$nota = 0;
														$nota += round((@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
														
														echo "
																											<td>".$nota."</td>
														";
														$total+=$nota;
														$maximo += intval($questao -> in_peso);
												}
												else if($questao -> in_tipo == '6'){
														echo "
																											<td>".@$respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta."</td>
														";
														$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
														$maximo += intval($questao -> in_peso);
												}
												else{
														echo "
																											<td>-</td>
														";
												}
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

echo "
                                            </div>";
$this -> load -> view('internaRodape', $pagina);
?>