<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Relatorios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Vagas_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> helper('date');
        if (!$this -> session -> logado) {
            redirect('Publico');
        } elseif ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
    }

    public function index()
    {
        $pagina['menu1']='Relatorios';
        $pagina['menu2']='index';
        $pagina['url']='Relatorios/index';
        $pagina['nome_pagina']='Relatorios';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $this -> load -> view('relatorios', $dados);
    }

    public function DocumentosObrigatorios()
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> model('Anexos_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='DocumentosObrigatorios';
        $pagina['url']='Relatorios/DocumentosObrigatorios';
        if (!isset($_POST["vaga"])) {
            $pagina['nome_pagina']='Relatorios';
        } else {
            $vaga = $_POST['vaga'];
            $vagas = $this ->Vagas_model -> get_vagas($vaga);
            $pagina['nome_pagina']='Relatorios - '.$vagas[0] -> vc_vaga;
        }
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;

        $dados['adicionais'] = array(
                                            'datatables' => true);
        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true);
        } else {
            $vaga = $_POST['vaga'];
            $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
            $dados['vaga'] = $this ->Vagas_model -> get_vagas($vaga);
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vaga'][0] -> es_grupoVaga, 1);
            if (isset($dados['candidaturas']) && isset($dados['questoes'])) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '1');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['candidaturas'] as $candidatura) {
                    $dados['candidato'][$candidatura -> pr_candidatura] = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    foreach ($dados['questoes'] as $questao) {
                        if ($questao -> in_tipo == '7') {
                            $dados['anexos'][$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('', '', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
                        }
                    }
                }
            }
        }



        $this -> load -> view('relatorios', $dados);
    }

    public function csv_DocumentosObrigatorios($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> model('Anexos_model');
        $this -> load -> library('csvmodel');

        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
        $vagas = $this ->Vagas_model -> get_vagas($vaga);
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 1);


        $campos=array('nome','genero','cpf','documento','idade','email','status');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                $campos[] = 'campo'.$questao->pr_questao;
                /*echo "
                                                                            <th>{$questao -> tx_questao}</th>
                ";*/
            }
        }

        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode("Gênero"),'cpf'=>'CPF','documento'=>utf8_decode('Documento de identificação'),'idade'=>"Idade",'email'=>'E-mail','status'=>'Status');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
            }
        }
        $this->csvmodel->escreveCache($cabecalho);



        if (isset($candidaturas) && isset($questoes)) {
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '1');
            $respostas2 = array();
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }
            $sexo = array(
                            0 => '',
                            1 => 'Não informado',
                            2 => 'Masculino',
                            3 => 'Feminino',
                            4 => 'Prefiro não declarar'
                            );
            foreach ($candidaturas as $candidatura) {
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato-> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));

                    $conteudo = array('nome'=>utf8_decode($candidato -> vc_nome),'genero'=>utf8_decode($sexo[$candidato -> in_genero]),'cpf'=>$candidato -> ch_cpf,'documento'=>$candidato -> vc_rg,'idade'=>$interval->format('%Y anos'),'email' => $candidato -> vc_email,'status'=>utf8_decode($candidatura -> vc_status));

                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '7') {
                            $anexos[$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('', '', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
                            if (isset($anexos[$candidatura -> pr_candidatura][$questao -> pr_questao])) {
                                $conteudo['campo'.$questao->pr_questao] = "Inserido";
                            } else {
                                $conteudo['campo'.$questao->pr_questao] = utf8_decode("Não inserido");
                            }
                        } elseif ($questao -> in_tipo == '3') {
                            $array_resposta = array(""=>"","0"=>utf8_decode("Não"),"1"=>"Sim");

                            $conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
                        } elseif ($questao -> in_tipo == '4') {
                            $array_resposta = array(""=>"","0"=>"Sim","1"=>utf8_decode("Não"));

                            $conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
                        }
                    }

                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_DocumentosObrigatorios', "CSV de documentos obrigatórios da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('documentos_obrigatorios.csv');
    }

    public function RequisitosDesejaveis()
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> model('Anexos_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='RequisitosDesejaveis';
        $pagina['url']='Relatorios/RequisitosDesejaveis';
        if (!isset($_POST["vaga"])) {
            $pagina['nome_pagina']='Relatorios';
        } else {
            $vaga = $_POST['vaga'];
            $vagas = $this ->Vagas_model -> get_vagas($vaga);
            $pagina['nome_pagina']='Relatorios - '.$vagas[0] -> vc_vaga;
        }
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;

        $dados['adicionais'] = array(
                                            'datatables' => true);
        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true);
        } else {
            $vaga = $_POST['vaga'];
            $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '');
            $dados['vaga'] = $this ->Vagas_model -> get_vagas($vaga);
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vaga'][0] -> es_grupoVaga, 2);
            if (isset($dados['candidaturas']) && isset($dados['questoes'])) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '2');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['candidaturas'] as $candidatura) {
                    $dados['candidato'][$candidatura -> pr_candidatura] = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    foreach ($dados['questoes'] as $questao) {
                        if ($questao -> in_tipo == '7') {
                            $dados['anexos'][$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('', '', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
                        }
                        $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                    }
                }
            }
        }



        $this -> load -> view('relatorios', $dados);
    }

    public function csv_RequisitosDesejaveis($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> model('Anexos_model');
        $this -> load -> library('csvmodel');

        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
        $vagas = $this ->Vagas_model -> get_vagas($vaga);
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 2);


        $campos=array('nome','genero','cpf','documento','idade','email','status');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                $campos[] = 'campo'.$questao->pr_questao;
            }
        }

        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode("Gênero"),'cpf'=>'CPF','documento'=>utf8_decode('Documento de identificação'),'idade'=>"Idade",'email'=>'E-mail','status'=>'Status');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
            }
        }
        $this->csvmodel->escreveCache($cabecalho);



        if (isset($candidaturas) && isset($questoes)) {
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '2');
            $respostas2 = array();
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }
            $sexo = array(
                            0 => '',
                            1 => 'Não informado',
                            2 => 'Masculino',
                            3 => 'Feminino',
                            4 => 'Prefiro não declarar'
                            );
            foreach ($candidaturas as $candidatura) {
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato-> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));

                    $conteudo = array('nome'=>utf8_decode($candidato -> vc_nome),'genero'=>utf8_decode($sexo[$candidato -> in_genero]),'cpf'=>$candidato -> ch_cpf,'documento'=>$candidato -> vc_rg,'idade'=>$interval->format('%Y anos'),'email' => $candidato -> vc_email,'status'=>utf8_decode($candidatura -> vc_status));

                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '7') {
                            $anexos[$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('', '', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
                            if (isset($anexos[$candidatura -> pr_candidatura][$questao -> pr_questao])) {
                                $conteudo['campo'.$questao->pr_questao] = "Inserido";
                            } else {
                                $conteudo['campo'.$questao->pr_questao] = utf8_decode("Não inserido");
                            }
                        } elseif ($questao -> in_tipo == '3') {
                            $array_resposta = array(""=>"","0"=>utf8_decode("Não"),"1"=>"Sim");

                            $conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
                        } elseif ($questao -> in_tipo == '4') {
                            $array_resposta = array(""=>"","0"=>"Sim","1"=>utf8_decode("Não"));

                            $conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
                        } elseif ($questao -> in_tipo == '1') {
                            $opcoes = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                            $resposta = '';
                            if (isset($opcoes)) {
                                foreach ($opcoes as $opcao) {
                                    if (@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao) {
                                        $resposta = utf8_decode($opcao -> tx_opcao);
                                    }
                                }
                            }
                            $conteudo['campo'.$questao->pr_questao] = $resposta;
                        } else {
                            $conteudo['campo'.$questao->pr_questao] = utf8_decode(@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                        }
                    }

                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_RequisitosDesejaveis', "CSV de Requisitos Desejáveis da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('requisitos_desejaveis.csv');
    }

    public function AvaliacaoCurricular()
    {
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='AvaliacaoCurricular';
        $pagina['url']='Relatorios/AvaliacaoCurricular';
        $pagina['nome_pagina']='Resultados da Avaliação Curricular';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true);
        } else {
            $vaga = $_POST["vaga"];
            //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

            //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 3);

            //var_dump($candidaturas);
            $dados['candidaturas'] = array();
            if ($candidaturas) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '3');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['questoes'] as $questao) {
                    $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                }


                foreach ($candidaturas as $candidatura) {
                    //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                    $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    if (isset($candidatos)) {
                        //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                        $candidatura -> vc_email = $candidatos -> vc_email;
                        $candidatura -> in_genero = $candidatos -> in_genero;
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


    public function csv_AvaliacaoCurricular($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> library('csvmodel');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 3);

        $campos=array('nome','genero','email','cpf','idade','documento','status');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $campos[] = 'campo'.$questao->pr_questao;
                    $campos[] = 'valor'.$questao->pr_questao;
                }
            }
        }
        $campos[]='total';
        $campos[]='percentual';
        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode('Gênero'),'email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
                    $cabecalho['valor'.$questao->pr_questao] = utf8_decode("Nota Questão");
                }
            }
        }
        $cabecalho['total'] = utf8_decode("Nota bruta da Avaliação Curricular");
        $cabecalho['percentual'] = utf8_decode("Nota  percentual da Avaliação Curricular");
        $this->csvmodel->escreveCache($cabecalho);

        if ($candidaturas) {
            $sexo = array(
                        0 => '',
                        1 => 'Não informado',
                        2 => 'Masculino',
                        3 => 'Feminino',
                        4 => 'Prefiro não declarar'
                        );
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '3');
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }

            foreach ($questoes as $questao) {
                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
            }

            foreach ($candidaturas as $candidatura) {
                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato -> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));


                    $conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'genero'=>utf8_decode($sexo[$candidato  -> in_genero]),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format('%Y anos'),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status));
                    $total = 0;
                    $maximo = 0;
                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '1') {
                            $nota = 0;
                            $max = 0;
                            $resposta = '';
                            foreach ($opcoes[$questao -> pr_questao] as $opcao) {
                                if (@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao) {
                                    //echo $opcao->in_valor;
                                    $nota += intval($opcao->in_valor);
                                    $resposta = utf8_decode($opcao->tx_opcao);
                                }
                                if ($max < intval($opcao->in_valor)) {
                                    $max = intval($opcao->in_valor);
                                }
                            }
                            $conteudo['campo'.$questao->pr_questao] = $resposta;
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += $max;
                        } elseif ($questao -> in_tipo == '3' || $questao -> in_tipo == '4') {
                            if ($questao -> in_tipo == '3') {
                                $array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
                            } else {
                                $array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
                            }
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '5') {
                            $nota = 0;
                            $nota += round((@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
                            $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($valores[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '6') {
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $maximo += intval($questao -> in_peso);
                        }
                    }

                    if ($maximo == 0) {
                        $maximo =1;
                    }

                    $conteudo['total'] = $total;
                    $conteudo['percentual'] = (round(($total/$maximo)*100));
                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_AvaliacaoCurricular', "CSV de avaliação curricular da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('avaliacao_curricular.csv');
    }

    public function AvaliacaoCompetencia()
    {
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='AvaliacaoCompetencia';
        $pagina['url']='Relatorios/AvaliacaoCompetencia';
        $pagina['nome_pagina']='Resultados da Avaliação por Competência';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true, '10,11,14,16,18,19');
        } else {
            $vaga = $_POST["vaga"];
            //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

            //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 4);

            //var_dump($candidaturas);
            $dados['candidaturas'] = array();
            if (isset($candidaturas) && isset($dados['questoes'])) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '4');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['questoes'] as $questao) {
                    $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                }


                foreach ($candidaturas as $candidatura) {
                    //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                    $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    if (isset($candidatos)) {
                        //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                        $candidatura -> vc_email = $candidatos -> vc_email;
                        $candidatura -> in_genero = $candidatos -> in_genero;
                        $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                        $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;


                        $dados['candidaturas'][] = $candidatura;
                    }
                }
            }
        }


        $this -> load -> view('relatorios', $dados);
    }

    public function csv_AvaliacaoCompetencia($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> library('csvmodel');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 4);

        $campos=array('nome','genero','email','cpf','idade','documento','status','avaliador');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $campos[] = 'campo'.$questao->pr_questao;
                    $campos[] = 'valor'.$questao->pr_questao;
                }
            }
        }
        $campos[]='total';
        $campos[]='percentual';
        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode('Gênero'),'email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status','avaliador'=>'Avaliador');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
                    $cabecalho['valor'.$questao->pr_questao] = utf8_decode("Nota Questão");
                }
            }
        }
        $cabecalho['total'] = utf8_decode("Nota bruta da Avaliação por Competência");
        $cabecalho['percentual'] = utf8_decode("Nota  percentual da Avaliação por Competência");
        $this->csvmodel->escreveCache($cabecalho);

        if (isset($candidaturas) && isset($questoes)) {
            $sexo = array(
                        0 => '',
                        1 => 'Não informado',
                        2 => 'Masculino',
                        3 => 'Feminino',
                        4 => 'Prefiro não declarar'
                        );
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '4');
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }

            foreach ($questoes as $questao) {
                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
            }

            foreach ($candidaturas as $candidatura) {
                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato -> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));


                    $conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'genero'=>utf8_decode($sexo[$candidato  -> in_genero]),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format('%Y anos'),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status),'avaliador'=>utf8_decode($candidatura -> avaliador_competencia));
                    $total = 0;
                    $maximo = 0;
                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '1') {
                            $nota = 0;
                            $max = 0;
                            $resposta = '';
                            foreach ($opcoes[$questao -> pr_questao] as $opcao) {
                                if (@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao) {
                                    //echo $opcao->in_valor;
                                    $nota += intval($opcao->in_valor);
                                    $resposta = utf8_decode($opcao->tx_opcao);
                                }
                                if ($max < intval($opcao->in_valor)) {
                                    $max = intval($opcao->in_valor);
                                }
                            }
                            $conteudo['campo'.$questao->pr_questao] = $resposta;
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += $max;
                        } elseif ($questao -> in_tipo == '3' || $questao -> in_tipo == '4') {
                            if ($questao -> in_tipo == '3') {
                                $array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
                            } else {
                                $array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
                            }
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '5') {
                            $nota = 0;
                            $nota += round((@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
                            $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($valores[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $total+=$nota;
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '6') {
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $maximo += intval($questao -> in_peso);
                        }
                    }

                    if ($maximo == 0) {
                        $maximo =1;
                    }

                    $conteudo['total'] = $total;
                    $conteudo['percentual'] = (round(($total/$maximo)*100));
                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_AvaliacaoCompetencia', "CSV de avaliação por competência da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('avaliacao_competencia.csv');
    }

    public function TesteAderencia()
    {
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='TesteAderencia';
        $pagina['url']='Relatorios/TesteAderencia';
        $pagina['nome_pagina']='Resultados do Teste de Aderência';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true, '10,11,14,16,18,19');
        } else {
            $vaga = $_POST["vaga"];
            //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

            //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 5);

            //var_dump($candidaturas);
            $dados['candidaturas'] = array();
            if (isset($candidaturas) && isset($dados['questoes'])) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '5');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['questoes'] as $questao) {
                    $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                }


                foreach ($candidaturas as $candidatura) {
                    //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                    $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    if (isset($candidatos)) {
                        //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                        $candidatura -> vc_email = $candidatos -> vc_email;
                        $candidatura -> in_genero = $candidatos -> in_genero;
                        $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                        $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;


                        $dados['candidaturas'][] = $candidatura;
                    }
                }
            }
        }


        $this -> load -> view('relatorios', $dados);
    }

    public function csv_TesteAderencia($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> library('csvmodel');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 5);

        $campos=array('nome','genero','email','cpf','idade','documento','status');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $campos[] = 'campo'.$questao->pr_questao;
                    $campos[] = 'valor'.$questao->pr_questao;
                }
            }
        }
        $campos[]='total';
        $campos[]='percentual';
        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode('Gênero'),'email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
                    $cabecalho['valor'.$questao->pr_questao] = utf8_decode("Nota Questão");
                }
            }
        }
        $cabecalho['total'] = utf8_decode("Nota bruta do Teste de Aderência");
        $cabecalho['percentual'] = utf8_decode("Nota percentual do Teste de Aderência");
        $this->csvmodel->escreveCache($cabecalho);

        if (isset($candidaturas) && isset($questoes)) {
            $sexo = array(
                        0 => '',
                        1 => 'Não informado',
                        2 => 'Masculino',
                        3 => 'Feminino',
                        4 => 'Prefiro não declarar'
                        );
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '5');
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }

            foreach ($questoes as $questao) {
                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
            }

            foreach ($candidaturas as $candidatura) {
                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato -> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));


                    $conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'genero'=>utf8_decode($sexo[$candidato  -> in_genero]),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format('%Y anos'),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status));
                    $total = 0;
                    $maximo = 0;
                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '1') {
                            $nota = 0;
                            $max = 0;
                            $resposta = '';
                            foreach ($opcoes[$questao -> pr_questao] as $opcao) {
                                if (@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao) {
                                    //echo $opcao->in_valor;
                                    $nota += intval($opcao->in_valor);
                                    $resposta = utf8_decode($opcao->tx_opcao);
                                }
                                if ($max < intval($opcao->in_valor)) {
                                    $max = intval($opcao->in_valor);
                                }
                            }
                            $conteudo['campo'.$questao->pr_questao] = $resposta;
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += $max;
                        } elseif ($questao -> in_tipo == '3' || $questao -> in_tipo == '4') {
                            if ($questao -> in_tipo == '3') {
                                $array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
                            } else {
                                $array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
                            }
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '5') {
                            $nota = 0;
                            $nota += round((@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
                            $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($valores[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '6') {
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $maximo += intval($questao -> in_peso);
                        }
                    }

                    if ($maximo == 0) {
                        $maximo =1;
                    }

                    $conteudo['total'] = $total;
                    $conteudo['percentual'] = (round(($total/$maximo)*100));
                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_TesteAderencia', "CSV de teste de aderência da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('teste_aderencia.csv');
    }

    public function TesteMotivacao()
    {
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='TesteMotivacao';
        $pagina['url']='Relatorios/TesteMotivacao';
        $pagina['nome_pagina']='Resultados do Teste de Motivação';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true, '10,11,14,16,18,19');
        } else {
            $vaga = $_POST["vaga"];
            //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

            //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 7);

            //var_dump($candidaturas);
            $dados['candidaturas'] = array();
            if (isset($candidaturas) && isset($dados['questoes'])) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '7');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['questoes'] as $questao) {
                    $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                }


                foreach ($candidaturas as $candidatura) {
                    //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                    $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    if (isset($candidatos)) {
                        //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                        $candidatura -> vc_email = $candidatos -> vc_email;
                        $candidatura -> in_genero = $candidatos -> in_genero;
                        $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                        $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;


                        $dados['candidaturas'][] = $candidatura;
                    }
                }
            }
        }


        $this -> load -> view('relatorios', $dados);
    }

    public function csv_TesteMotivacao($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> library('csvmodel');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 7);

        $campos=array('nome','genero','email','cpf','idade','documento','status');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $campos[] = 'campo'.$questao->pr_questao;
                    $campos[] = 'valor'.$questao->pr_questao;
                }
            }
        }
        $campos[]='total';
        $campos[]='percentual';
        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode('Gênero'),'email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
                    $cabecalho['valor'.$questao->pr_questao] = utf8_decode("Nota Questão");
                }
            }
        }
        $cabecalho['total'] = utf8_decode("Nota bruta do Teste de Motivação");
        $cabecalho['percentual'] = utf8_decode("Nota percentual do Teste de Motivação");
        $this->csvmodel->escreveCache($cabecalho);

        if (isset($candidaturas) && isset($questoes)) {
            $sexo = array(
                        0 => '',
                        1 => 'Não informado',
                        2 => 'Masculino',
                        3 => 'Feminino',
                        4 => 'Prefiro não declarar'
                        );
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '7');
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }

            foreach ($questoes as $questao) {
                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
            }

            foreach ($candidaturas as $candidatura) {
                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato -> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));


                    $conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'genero'=>utf8_decode($sexo[$candidato  -> in_genero]),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format('%Y anos'),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status));
                    $total = 0;
                    $maximo = 0;
                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '1') {
                            $nota = 0;
                            $max = 0;
                            $resposta = '';
                            foreach ($opcoes[$questao -> pr_questao] as $opcao) {
                                if (@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao) {
                                    //echo $opcao->in_valor;
                                    $nota += intval($opcao->in_valor);
                                    $resposta = utf8_decode($opcao->tx_opcao);
                                }
                                if ($max < intval($opcao->in_valor)) {
                                    $max = intval($opcao->in_valor);
                                }
                            }
                            $conteudo['campo'.$questao->pr_questao] = $resposta;
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += $max;
                        } elseif ($questao -> in_tipo == '3' || $questao -> in_tipo == '4') {
                            if ($questao -> in_tipo == '3') {
                                $array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
                            } else {
                                $array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
                            }
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '5') {
                            $nota = 0;
                            $nota += round((@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
                            $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($valores[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '6') {
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $maximo += intval($questao -> in_peso);
                        }
                    }

                    if ($maximo == 0) {
                        $maximo =1;
                    }

                    $conteudo['total'] = $total;
                    $conteudo['percentual'] = (round(($total/$maximo)*100));
                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_TesteMotivacao', "CSV de teste de motivação da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('teste_motivacao.csv');
    }

    public function HBDI()
    {
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='HBDI';
        $pagina['url']='Relatorios/HBDI';
        $pagina['nome_pagina']='Resultados do Teste HBDI';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', '10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        } else {
            $vaga = $_POST["vaga"];
            //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

            //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');

            $dados['candidaturas'] = array();
            if (isset($candidaturas)) {
                foreach ($candidaturas as $candidatura) {
                    //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                    $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    if (isset($candidatos)) {
                        $dados['hbdi'][$candidatura -> pr_candidatura] = $this -> Candidaturas_model -> get_hbdi($candidatura -> pr_candidatura);
                        $candidatura -> vc_email = $candidatos -> vc_email;
                        $candidatura -> in_genero = $candidatos -> in_genero;
                        $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                        $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;


                        $dados['candidaturas'][] = $candidatura;
                    }
                }
            }
        }


        $this -> load -> view('relatorios', $dados);
    }

    public function csv_HBDI($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> library('csvmodel');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 5);

        $campos=array('nome','genero','email','cpf','idade','documento','status','motivacao_trabalho','gosto','prefiro','pergunta','fazer','comprar','comportamento','estilo','ponto_fraco','resolver','procuro','frase','sd','se','id','ie');


        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode('Gênero'),'email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status','motivacao_trabalho'=>utf8_decode("1. Quais sentidos ou situações fazem você se sentir mais motivado no trabalho?"),'gosto'=>utf8_decode("2. Quando aprendo, gosto de..."),'prefiro'=>utf8_decode("3. Prefiro aprender por meio de…"),'pergunta'=>utf8_decode("4. Qual o tipo de pergunta que você mais gosta de fazer?"),'fazer'=>utf8_decode("5. O que você mais gosta de fazer?"),'comprar'=>utf8_decode("6. Ao comprar um carro você…"),'comportamento'=>utf8_decode("7. Como você define seu comportamento?"),'estilo'=>utf8_decode("8. Palavras que definem meu estilo..."),'ponto_fraco'=>utf8_decode("9. Quais as frases que você mais ouve dos outros em relação a seus \"pontos fracos\"?"),'resolver'=>utf8_decode("10. Quando tenho que resolver um problema, eu geralmente…"),'procuro'=>utf8_decode("11. Quando tenho que resolver um problema, eu procuro…"),'frase'=>utf8_decode("12. Quais as frases que mais se aproximam do que você diz?"),'sd'=>"Superior Direito",'se'=>"Superior Esquerdo",'id'=>"Inferior Direito",'ie'=>"Inferior Esquerdo");

        $this->csvmodel->escreveCache($cabecalho);

        if (isset($candidaturas)) {
            $sexo = array(
                        0 => '',
                        1 => 'Não informado',
                        2 => 'Masculino',
                        3 => 'Feminino',
                        4 => 'Prefiro não declarar'
                        );


            foreach ($candidaturas as $candidatura) {
                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                if (isset($candidato)) {
                    $dataNascimento = $candidato -> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));
                    $hbdi = $this -> Candidaturas_model -> get_hbdi($candidatura -> pr_candidatura);

                    $conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'genero'=>utf8_decode($sexo[$candidato  -> in_genero]),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format('%Y anos'),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status));

                    $bl_motivacao_trabalho = "";
                    $bl_gosto = "";
                    $bl_prefiro = "";
                    $in_pergunta = "";
                    $bl_fazer = "";
                    $bl_comprar = "";
                    $in_comportamento = "";
                    $bl_estilo = "";
                    $bl_ponto_fraco = "";
                    $in_resolver = "";
                    $in_resolver = "";
                    $in_procuro = "";
                    $bl_frase = "";

                    //Calcula pelo lado do cérebro, com somatório simples, dependendo da resposta
                    $sd = 0;
                    $se = 0;
                    $ie = 0;
                    $id = 0;

                    if (isset($hbdi)) {
                        if ($hbdi -> bl_motivacao_trabalho1 == '1') {
                            $bl_motivacao_trabalho .=  "1.1 Trabalhar sozinho-";
                            ++$se;
                        }
                        if ($hbdi -> bl_motivacao_trabalho2 == '1') {
                            $bl_motivacao_trabalho .=  "1.2 Expressar minhas ideias-";
                            ++$id;
                        }
                        if ($hbdi -> bl_motivacao_trabalho3 == '1') {
                            $bl_motivacao_trabalho .=  "1.3 Estar no controle da situação-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_motivacao_trabalho4 == '1') {
                            $bl_motivacao_trabalho .=  "1.4 Provocar mudanças-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_motivacao_trabalho5 == '1') {
                            $bl_motivacao_trabalho .=  "1.5 Ouvir e falar-";
                            ++$id;
                        }
                        if ($hbdi -> bl_motivacao_trabalho6 == '1') {
                            $bl_motivacao_trabalho .=  "1.6 Criar ou usar recursos visuais-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_motivacao_trabalho7 == '1') {
                            $bl_motivacao_trabalho .=  "1.7 Prestar atenção aos detalhes-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_motivacao_trabalho8 == '1') {
                            $bl_motivacao_trabalho .=  "1.8 Aspectos técnicos-";
                            ++$se;
                        }
                        if ($hbdi -> bl_motivacao_trabalho9 == '1') {
                            $bl_motivacao_trabalho .=  "1.9 Trabalhar com pessoas-";
                            ++$id;
                        }
                        if ($hbdi -> bl_motivacao_trabalho10 == '1') {
                            $bl_motivacao_trabalho .=  "1.10 Usar números e estatísticas-";
                            ++$se;
                        }
                        if ($hbdi -> bl_motivacao_trabalho11 == '1') {
                            $bl_motivacao_trabalho .=  "1.11 Oportunidades para fazer experiências-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_motivacao_trabalho12 == '1') {
                            $bl_motivacao_trabalho .=  "1.12 Planejar-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_motivacao_trabalho13 == '1') {
                            $bl_motivacao_trabalho .=  "1.13 Trabalhar com comunicação-";
                            ++$id;
                        }
                        if ($hbdi -> bl_motivacao_trabalho14 == '1') {
                            $bl_motivacao_trabalho .=  "1.14 Fazer algo funcionar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_motivacao_trabalho15 == '1') {
                            $bl_motivacao_trabalho .=  "1.15 Arriscar-se-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_motivacao_trabalho16 == '1') {
                            $bl_motivacao_trabalho .=  "1.16 Analisar dados-";
                            ++$se;
                        }
                        if ($hbdi -> bl_motivacao_trabalho17 == '1') {
                            $bl_motivacao_trabalho .=  "1.17 Lidar com o futuro-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_motivacao_trabalho18 == '1') {
                            $bl_motivacao_trabalho .=  "1.18 Produzir e organizar-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_motivacao_trabalho19 == '1') {
                            $bl_motivacao_trabalho .=  "1.19 Fazer parte de uma equipe-";
                            ++$id;
                        }
                        if ($hbdi -> bl_motivacao_trabalho20 == '1') {
                            $bl_motivacao_trabalho .=  "1.20 Fazer as coisas sempre no prazo previsto-";
                            ++$ie;
                        }
                        $bl_motivacao_trabalho = substr($bl_motivacao_trabalho, 0, -1);

                        if ($hbdi -> bl_gosto1 == '1') {
                            $bl_gosto .= "2.1 Avaliar e testar teorias-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_gosto2 == '1') {
                            $bl_gosto .= "2.2 Obter e quantificar fatos-";
                            ++$se;
                        }
                        if ($hbdi -> bl_gosto3 == '1') {
                            $bl_gosto .= "2.3 Ouvir e compartilhar ideias-";
                            ++$id;
                        }
                        if ($hbdi -> bl_gosto4 == '1') {
                            $bl_gosto .= "2.4 Usar minha imaginação-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_gosto5 == '1') {
                            $bl_gosto .= "2.5 Aplicar análise e lógica-";
                            ++$se;
                        }
                        if ($hbdi -> bl_gosto6 == '1') {
                            $bl_gosto .= "2.6 Ambiente bem informal-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_gosto7 == '1') {
                            $bl_gosto .= "2.7 Verificar meu entendimento-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_gosto8 == '1') {
                            $bl_gosto .= "2.8 Fazer experiências práticas-";
                            ++$id;
                        }
                        if ($hbdi -> bl_gosto9 == '1') {
                            $bl_gosto .= "2.9 Pensar sobre as ideias-";
                            ++$se;
                        }
                        if ($hbdi -> bl_gosto10 == '1') {
                            $bl_gosto .= "2.10 Confiar nas intuições-";
                            ++$id;
                        }
                        if ($hbdi -> bl_gosto11 == '1') {
                            $bl_gosto .= "2.11 Receber informações passo a passo-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_gosto12 == '1') {
                            $bl_gosto .= "2.12 Tomar iniciativas-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_gosto13 == '1') {
                            $bl_gosto .= "2.13 Elaborar teorias-";
                            ++$se;
                        }
                        if ($hbdi -> bl_gosto14 == '1') {
                            $bl_gosto .= "2.14 Envolvimento emocional-";
                            ++$id;
                        }
                        if ($hbdi -> bl_gosto15 == '1') {
                            $bl_gosto .= "2.15 Trabalhar em grupo-";
                            ++$id;
                        }
                        if ($hbdi -> bl_gosto16 == '1') {
                            $bl_gosto .= "2.16 Orientações claras-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_gosto17 == '1') {
                            $bl_gosto .= "2.17 Fazer descobertas-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_gosto18 == '1') {
                            $bl_gosto .= "2.18 Criticar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_gosto19 == '1') {
                            $bl_gosto .= "2.19 Perceber logo o quadro geral (o objetivo final)-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_gosto20 == '1') {
                            $bl_gosto .= "2.20 Adquirir habilidades pela prática-";
                            ++$ie;
                        }
                        $bl_gosto = substr($bl_gosto, 0, -1);

                        if ($hbdi -> bl_prefiro1 == '1') {
                            $bl_prefiro .= "3.1 Materiais visuais-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_prefiro2 == '1') {
                            $bl_prefiro .= "3.2 Demonstrações-";
                            ++$id;
                        }
                        if ($hbdi -> bl_prefiro3 == '1') {
                            $bl_prefiro .= "3.3 Debates estruturados pelo instrutor-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_prefiro4 == '1') {
                            $bl_prefiro .= "3.4 Palestras formais-";
                            ++$se;
                        }
                        if ($hbdi -> bl_prefiro5 == '1') {
                            $bl_prefiro .= "3.5 Experiências-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_prefiro6 == '1') {
                            $bl_prefiro .= "3.6 Utilizando histórias e música-";
                            ++$id;
                        }
                        if ($hbdi -> bl_prefiro7 == '1') {
                            $bl_prefiro .= "3.7 Exercícios que usam a intuição-";
                            ++$id;
                        }
                        if ($hbdi -> bl_prefiro8 == '1') {
                            $bl_prefiro .= "3.8 Debate em grupo-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_prefiro9 == '1') {
                            $bl_prefiro .= "3.9 Exercícios de análise-";
                            ++$se;
                        }
                        if ($hbdi -> bl_prefiro10 == '1') {
                            $bl_prefiro .= "3.10 Atividades sequenciais bem planejadas-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_prefiro11 == '1') {
                            $bl_prefiro .= "3.11 Analisando números; dados e fatos-";
                            ++$se;
                        }
                        if ($hbdi -> bl_prefiro12 == '1') {
                            $bl_prefiro .= "3.12 Exemplos com metáforas-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_prefiro13 == '1') {
                            $bl_prefiro .= "3.13 Atividades passo a passo de reforço do conteúdo-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_prefiro14 == '1') {
                            $bl_prefiro .= "3.14 Leitura de livros-textos-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_prefiro15 == '1') {
                            $bl_prefiro .= "3.15 Discussões de casos voltados para as pessoas-";
                            ++$id;
                        }
                        if ($hbdi -> bl_prefiro16 == '1') {
                            $bl_prefiro .= "3.16 Discussões de casos voltados para os números e fatos-";
                            ++$se;
                        }
                        if ($hbdi -> bl_prefiro17 == '1') {
                            $bl_prefiro .= "3.17 Métodos tradicionais comprovados-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_prefiro18 == '1') {
                            $bl_prefiro .= "3.18 Agenda bem flexível-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_prefiro19 == '1') {
                            $bl_prefiro .= "3.19 Agenda estruturada com antecedência-";
                            ++$se;
                        }
                        if ($hbdi -> bl_prefiro20 == '1') {
                            $bl_prefiro .= "3.20 Trabalhos bem estruturados-";
                            ++$id;
                        }
                        $bl_prefiro = substr($bl_prefiro, 0, -1);

                        if ($hbdi -> in_pergunta == '1') {
                            $in_pergunta .= "4.1 O que?-";
                            ++$se;
                        } elseif ($hbdi -> in_pergunta == '2') {
                            $in_pergunta .= "4.2 Como?-";
                            ++$ie;
                        } elseif ($hbdi -> in_pergunta == '3') {
                            $in_pergunta .= "4.3 Por que?-";
                            ++$sd;
                        } elseif ($hbdi -> in_pergunta == '4') {
                            $in_pergunta .= "4.4 Quem?-";
                            ++$id;
                        }
                        $in_pergunta = substr($in_pergunta, 0, -1);

                        if ($hbdi -> bl_fazer1 == '1') {
                            $bl_fazer .= "5.1 Descobrir-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_fazer2 == '1') {
                            $bl_fazer .= "5.2 Quantificar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_fazer3 == '1') {
                            $bl_fazer .= "5.3 Envolver-";
                            ++$id;
                        }
                        if ($hbdi -> bl_fazer4 == '1') {
                            $bl_fazer .= "5.4 Organizar-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_fazer5 == '1') {
                            $bl_fazer .= "5.5 Conceituar-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_fazer6 == '1') {
                            $bl_fazer .= "5.6 Analisar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_fazer7 == '1') {
                            $bl_fazer .= "5.7 Sentir-";
                            ++$id;
                        }
                        if ($hbdi -> bl_fazer8 == '1') {
                            $bl_fazer .= "5.8 Praticar-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_fazer9 == '1') {
                            $bl_fazer .= "5.9 Teorizar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_fazer10 == '1') {
                            $bl_fazer .= "5.10 Sintetizar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_fazer11 == '1') {
                            $bl_fazer .= "5.11 Avaliar-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_fazer12 == '1') {
                            $bl_fazer .= "5.12 Interiorizar-";
                            ++$id;
                        }
                        if ($hbdi -> bl_fazer13 == '1') {
                            $bl_fazer .= "5.13 Processar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_fazer14 == '1') {
                            $bl_fazer .= "5.14 Ordenar-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_fazer15 == '1') {
                            $bl_fazer .= "5.15 Explorar-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_fazer16 == '1') {
                            $bl_fazer .= "5.16 Compartilhar-";
                            ++$id;
                        }
                        $bl_fazer = substr($bl_fazer, 0, -1);

                        if ($hbdi -> bl_comprar1 == '1') {
                            $bl_comprar .= "6.1 Compra com base na recomendação de amigos-";
                            ++$id;
                        }
                        if ($hbdi -> bl_comprar2 == '1') {
                            $bl_comprar .= "6.2 Se preocupa com o consumo de combustível-";
                            ++$se;
                        }
                        if ($hbdi -> bl_comprar3 == '1') {
                            $bl_comprar .= "6.3 Se preocupa com as forma; a cor e a tecnologia-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_comprar4 == '1') {
                            $bl_comprar .= "6.4 Verifica equipamento de segurança e durabilidade-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_comprar5 == '1') {
                            $bl_comprar .= "6.5 Dá importância à \"sensação\" de conforto do veículo-";
                            ++$id;
                        }
                        if ($hbdi -> bl_comprar6 == '1') {
                            $bl_comprar .= "6.6 Faz comparações com outros veículos-";
                            ++$se;
                        }
                        if ($hbdi -> bl_comprar7 == '1') {
                            $bl_comprar .= "6.7 Verificar tamanho do porta-malas-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_comprar8 == '1') {
                            $bl_comprar .= "6.8 Verifica se encaixa no seu sonho de vida-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_comprar9 == '1') {
                            $bl_comprar .= "6.9 Pesquisa e planeja antecipadamente como vai utilizá-lo-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_comprar10 == '1') {
                            $bl_comprar .= "6.10 Se preocupa com o custo e o valor de troca-";
                            ++$se;
                        }
                        if ($hbdi -> bl_comprar11 == '1') {
                            $bl_comprar .= "6.11 Quer \"amar\" o carro-";
                            ++$id;
                        }
                        if ($hbdi -> bl_comprar12 == '1') {
                            $bl_comprar .= "6.12 Prefere carros lançados recentemente-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_comprar13 == '1') {
                            $bl_comprar .= "6.13 Se preocupa com os requisitos técnicos-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_comprar14 == '1') {
                            $bl_comprar .= "6.14 Verifica a facilidade de manutenção-";
                            ++$se;
                        }
                        if ($hbdi -> bl_comprar15 == '1') {
                            $bl_comprar .= "6.15 Gosta de experimentar um novo modelo ou fabricante-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_comprar16 == '1') {
                            $bl_comprar .= "6.16 Se preocupa com o nome do fabricante-";
                            ++$id;
                        }
                        if ($hbdi -> bl_comprar17 == '1') {
                            $bl_comprar .= "6.17 Dá importância à opinião das pessoas-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_comprar18 == '1') {
                            $bl_comprar .= "6.18 Quer ver dados e estatísticas sobre o desempenho-";
                            ++$se;
                        }
                        if ($hbdi -> bl_comprar19 == '1') {
                            $bl_comprar .= "6.19 Se preocupa com a qualidade do atendimento do revendedor-";
                            ++$id;
                        }
                        if ($hbdi -> bl_comprar20 == '1') {
                            $bl_comprar .= "6.20 Analisa como o carro vai ser útil no seu dia-a-dia-";
                            ++$ie;
                        }
                        $bl_comprar = substr($bl_comprar, 0, -1);

                        if ($hbdi -> in_comportamento == '1') {
                            $in_comportamento .= "7.1 Gosto de organizar-";
                            ++$ie;
                        } elseif ($hbdi -> in_comportamento == '2') {
                            $in_comportamento .= "7.2 Gosto de compartilhar-";
                            ++$id;
                        } elseif ($hbdi -> in_comportamento == '3') {
                            $in_comportamento .= "7.3 Gosto de analisar-";
                            ++$se;
                        } elseif ($hbdi -> in_comportamento == '4') {
                            $in_comportamento .= "7.4 Gosto de descobrir-";
                            ++$sd;
                        }
                        $in_comportamento = substr($in_comportamento, 0, -1);

                        if ($hbdi -> bl_estilo1 == '1') {
                            $bl_estilo .= "8.1 Organizado-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_estilo2 == '1') {
                            $bl_estilo .= "8.2 Analítico-";
                            ++$se;
                        }
                        if ($hbdi -> bl_estilo3 == '1') {
                            $bl_estilo .= "8.3 Emocional-";
                            ++$id;
                        }
                        if ($hbdi -> bl_estilo4 == '1') {
                            $bl_estilo .= "8.4 Experimental-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_estilo5 == '1') {
                            $bl_estilo .= "8.5 Lógico-";
                            ++$se;
                        }
                        if ($hbdi -> bl_estilo6 == '1') {
                            $bl_estilo .= "8.6 Conceitual-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_estilo7 == '1') {
                            $bl_estilo .= "8.7 Perceptivo-";
                            ++$id;
                        }
                        if ($hbdi -> bl_estilo8 == '1') {
                            $bl_estilo .= "8.8 Sequencial-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_estilo9 == '1') {
                            $bl_estilo .= "8.9 Teórico-";
                            ++$se;
                        }
                        if ($hbdi -> bl_estilo10 == '1') {
                            $bl_estilo .= "8.10 Explorador-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_estilo11 == '1') {
                            $bl_estilo .= "8.11 Avaliador-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_estilo12 == '1') {
                            $bl_estilo .= "8.12 Cinestésico-";
                            ++$id;
                        }
                        if ($hbdi -> bl_estilo13 == '1') {
                            $bl_estilo .= "8.13 Sentimental-";
                            ++$id;
                        }
                        if ($hbdi -> bl_estilo14 == '1') {
                            $bl_estilo .= "8.14 Preparado-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_estilo15 == '1') {
                            $bl_estilo .= "8.15 Quantitativo-";
                            ++$se;
                        }
                        if ($hbdi -> bl_estilo16 == '1') {
                            $bl_estilo .= "8.16 Sintético-";
                            ++$sd;
                        }
                        $bl_estilo = substr($bl_estilo, 0, -1);

                        if ($hbdi -> bl_ponto_fraco1 == '1') {
                            $bl_ponto_fraco .= "9.1 Viciado em números-";
                            ++$se;
                        }
                        if ($hbdi -> bl_ponto_fraco2 == '1') {
                            $bl_ponto_fraco .= "9.2 Coração mole-";
                            ++$id;
                        }
                        if ($hbdi -> bl_ponto_fraco3 == '1') {
                            $bl_ponto_fraco .= "9.3 Exigente; esforçado-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_ponto_fraco4 == '1') {
                            $bl_ponto_fraco .= "9.4 Vive no mundo da lua-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_ponto_fraco5 == '1') {
                            $bl_ponto_fraco .= "9.5 Tem sede de poder-";
                            ++$se;
                        }
                        if ($hbdi -> bl_ponto_fraco6 == '1') {
                            $bl_ponto_fraco .= "9.6 Fala demais-";
                            ++$id;
                        }
                        if ($hbdi -> bl_ponto_fraco7 == '1') {
                            $bl_ponto_fraco .= "9.7 Não decide sozinho-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_ponto_fraco8 == '1') {
                            $bl_ponto_fraco .= "9.8 Não sabe se concentrar-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_ponto_fraco9 == '1') {
                            $bl_ponto_fraco .= "9.9 Frio; insensível-";
                            ++$se;
                        }
                        if ($hbdi -> bl_ponto_fraco10 == '1') {
                            $bl_ponto_fraco .= "9.10 Fácil de convencer-";
                            ++$id;
                        }
                        if ($hbdi -> bl_ponto_fraco11 == '1') {
                            $bl_ponto_fraco .= "9.11 Sem imaginação-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_ponto_fraco12 == '1') {
                            $bl_ponto_fraco .= "9.12 Maluco-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_ponto_fraco13 == '1') {
                            $bl_ponto_fraco .= "9.13 Calculista-";
                            ++$se;
                        }
                        if ($hbdi -> bl_ponto_fraco14 == '1') {
                            $bl_ponto_fraco .= "9.14 Ingênuo-";
                            ++$id;
                        }
                        if ($hbdi -> bl_ponto_fraco15 == '1') {
                            $bl_ponto_fraco .= "9.15 Bitolado-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_ponto_fraco16 == '1') {
                            $bl_ponto_fraco .= "9.16 Inconsequente-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_ponto_fraco17 == '1') {
                            $bl_ponto_fraco .= "9.17 Não se mistura-";
                            ++$se;
                        }
                        if ($hbdi -> bl_ponto_fraco18 == '1') {
                            $bl_ponto_fraco .= "9.18 Ultrassensível-";
                            ++$id;
                        }
                        if ($hbdi -> bl_ponto_fraco19 == '1') {
                            $bl_ponto_fraco .= "9.19 Quadrado-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_ponto_fraco20 == '1') {
                            $bl_ponto_fraco .= "9.20 Sem disciplina-";
                            ++$sd;
                        }
                        $bl_ponto_fraco = substr($bl_ponto_fraco, 0, -1);

                        if ($hbdi -> in_resolver == '1') {
                            $in_resolver .= "10.1 Visualizo os fatos; tratando-os de forma intuitiva e holística-";
                            ++$sd;
                        } elseif ($hbdi -> in_resolver == '2') {
                            $in_resolver .= "10.2 Organizo os fatos; tratando os detalhes de forma realista e cronológica-";
                            ++$ie;
                        } elseif ($hbdi -> in_resolver == '3') {
                            $in_resolver .= "10.3 Sinto os fatos; tratando-os de forma expressiva e interpessoal-";
                            ++$id;
                        } elseif ($hbdi -> in_resolver == '4') {
                            $in_resolver .= "10.4 Analiso os fatos; tratando-os de forma lógica e racional-";
                            ++$se;
                        }
                        $in_resolver = substr($in_resolver, 0, -1);

                        if ($hbdi -> in_procuro == '1') {
                            $in_procuro .= "11.1 Uma visão interpessoal; emocional; humana-";
                            ++$id;
                        } elseif ($hbdi -> in_procuro == '2') {
                            $in_procuro .= "11.2 Uma visão organizada; detalhada; cronológica-";
                            ++$ie;
                        } elseif ($hbdi -> in_procuro == '3') {
                            $in_procuro .= "11.3 Uma visão analítica; lógica; racional; de resultados-";
                            ++$se;
                        } elseif ($hbdi -> in_procuro == '4') {
                            $in_procuro .= "11.4 Uma visão intuitiva; conceitual; visual; de contexto geral-";
                            ++$sd;
                        }
                        $in_procuro = substr($in_procuro, 0, -1);

                        if ($hbdi -> bl_frase1 == '1') {
                            $bl_frase .= "12.1 Sempre fazemos desta forma-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_frase2 == '1') {
                            $bl_frase .= "12.2 Vamos ao ponto-chave do problema-";
                            ++$se;
                        }
                        if ($hbdi -> bl_frase3 == '1') {
                            $bl_frase .= "12.3 Vejamos os valores humanos-";
                            ++$id;
                        }
                        if ($hbdi -> bl_frase4 == '1') {
                            $bl_frase .= "12.4 Vamos analisar-";
                            ++$se;
                        }
                        if ($hbdi -> bl_frase5 == '1') {
                            $bl_frase .= "12.5 Vamos ver o quadro geral-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_frase6 == '1') {
                            $bl_frase .= "12.6 Vamos ver o desenvolvimento de equipe-";
                            ++$id;
                        }
                        if ($hbdi -> bl_frase7 == '1') {
                            $bl_frase .= "12.7 Vamos conhecer o resultado-";
                            ++$se;
                        }
                        if ($hbdi -> bl_frase8 == '1') {
                            $bl_frase .= "12.8 Este é o grande sucesso conceitual-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_frase9 == '1') {
                            $bl_frase .= "12.9 Vamos manter a lei e a ordem-";
                            ++$ie;
                        }
                        if ($hbdi -> bl_frase10 == '1') {
                            $bl_frase .= "12.10 Vamos inovar e criar sinergia-";
                            ++$sd;
                        }
                        if ($hbdi -> bl_frase11 == '1') {
                            $bl_frase .= "12.11 Vamos participar e envolver-";
                            ++$id;
                        }
                        if ($hbdi -> bl_frase12 == '1') {
                            $bl_frase .= "12.12 É mais seguro desta forma-";
                            ++$ie;
                        }
                        $bl_frase = substr($bl_frase, 0, -1);
                    }


                    $conteudo['motivacao_trabalho'] = utf8_decode($bl_motivacao_trabalho);
                    $conteudo['gosto'] = utf8_decode($bl_gosto);
                    $conteudo['prefiro'] = utf8_decode($bl_prefiro);
                    $conteudo['pergunta'] = utf8_decode($in_pergunta);
                    $conteudo['fazer'] = utf8_decode($bl_fazer);
                    $conteudo['comprar'] = utf8_decode($bl_comprar);
                    $conteudo['comportamento'] = utf8_decode($in_comportamento);
                    $conteudo['estilo'] = utf8_decode($bl_estilo);
                    $conteudo['ponto_fraco'] = utf8_decode($bl_ponto_fraco);
                    $conteudo['resolver'] = utf8_decode($in_resolver);
                    $conteudo['procuro'] = utf8_decode($in_procuro);
                    $conteudo['frase'] = utf8_decode($bl_frase);

                    $conteudo['sd']=$sd;
                    $conteudo['se']=$se;
                    $conteudo['id']=$id;
                    $conteudo['ie']=$ie;

                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_HBDI', "CSV de HBDI da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('hbdi.csv');
    }

    public function AvaliacaoEspecialista()
    {
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Relatorios';
        $pagina['menu2']='AvaliacaoEspecialista';
        $pagina['url']='Relatorios/AvaliacaoEspecialista';
        $pagina['nome_pagina']='Resultados da Avaliação com Especialista';
        $pagina['icone']='fa fa-edit';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        if (!isset($_POST["vaga"])) {
            $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'array', '', 0, '', true, '10,11,14,16,18,19');
        } else {
            $vaga = $_POST["vaga"];
            //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

            //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 6);

            //var_dump($candidaturas);
            $dados['candidaturas'] = array();
            if (isset($candidaturas) && isset($dados['questoes'])) {
                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '6');
                foreach ($respostas as $resposta) {
                    $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                }

                foreach ($dados['questoes'] as $questao) {
                    $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                }


                foreach ($candidaturas as $candidatura) {
                    //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                    $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                    if (strlen($candidatura -> es_avaliador_especialista)) {
                        $usuarios = $this -> Usuarios_model -> get_usuarios($candidatura -> es_avaliador_especialista);
                    }


                    $candidatura -> avaliador_especialista = "";

                    if (isset($usuarios)) {
                        $candidatura -> avaliador_especialista = $usuarios -> vc_nome;
                    }

                    if (isset($candidatos)) {
                        //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                        $candidatura -> vc_email = $candidatos -> vc_email;
                        $candidatura -> in_genero = $candidatos -> in_genero;
                        $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                        $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;


                        $dados['candidaturas'][] = $candidatura;
                    }
                }
            }
        }


        $this -> load -> view('relatorios', $dados);
    }

    public function csv_AvaliacaoEspecialista($vaga)
    {
        $this -> load -> model('Questoes_model');
        $this -> load -> library('csvmodel');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21');
        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 6);

        $campos=array('nome','genero','email','cpf','idade','documento','status','avaliador');

        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $campos[] = 'campo'.$questao->pr_questao;
                    $campos[] = 'valor'.$questao->pr_questao;
                }
            }
        }
        $campos[]='total';
        $campos[]='percentual';
        $this->csvmodel->setCampos($campos);

        $cabecalho = array('nome'=>'Nome do candidato','genero'=>utf8_decode('Gênero'),'email'=>'E-mail','cpf'=>'CPF','idade'=>"Idade",'documento'=>utf8_decode('Documento de identificação'),'status'=>'Status','avaliador'=>'Avaliador');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                if ($questao -> in_tipo == '1' || $questao -> in_tipo == '3' || $questao -> in_tipo == '4' || $questao -> in_tipo == '5' || $questao -> in_tipo == '6') {
                    $cabecalho['campo'.$questao->pr_questao] = utf8_decode(strip_tags($questao -> tx_questao));
                    $cabecalho['valor'.$questao->pr_questao] = utf8_decode("Nota Questão");
                }
            }
        }
        $cabecalho['total'] = utf8_decode("Nota bruta da Avaliação com Especialista");
        $cabecalho['percentual'] = utf8_decode("Nota  percentual da Avaliação com Especialista");
        $this->csvmodel->escreveCache($cabecalho);

        if (isset($candidaturas) && isset($questoes)) {
            $sexo = array(
                        0 => '',
                        1 => 'Não informado',
                        2 => 'Masculino',
                        3 => 'Feminino',
                        4 => 'Prefiro não declarar'
                        );
            $respostas = $this -> Questoes_model -> get_respostas('', '', '', '', '6');
            foreach ($respostas as $resposta) {
                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
            }

            foreach ($questoes as $questao) {
                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
            }

            foreach ($candidaturas as $candidatura) {
                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);

                $candidatura -> avaliador_especialista = "";

                if (isset($usuarios)) {
                    $candidatura -> avaliador_especialista = $usuarios -> vc_nome;
                }

                if (isset($candidato)) {
                    $dataNascimento = $candidato -> dt_nascimento;
                    $date = new DateTime($dataNascimento);
                    $interval = $date->diff(new DateTime(date('Y-m-d')));


                    $conteudo = array('nome'=>utf8_decode($candidato  -> vc_nome),'genero'=>utf8_decode($sexo[$candidato  -> in_genero]),'email'=>utf8_decode($candidato -> vc_email),'cpf'=>$candidato  -> ch_cpf,'idade'=>$interval->format('%Y anos'),'documento'=>$candidato -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status),'avaliador'=>utf8_decode($candidatura -> avaliador_especialista));
                    $total = 0;
                    $maximo = 0;
                    foreach ($questoes as $questao) {
                        if ($questao -> in_tipo == '1') {
                            $nota = 0;
                            $max = 0;
                            $resposta = '';
                            foreach ($opcoes[$questao -> pr_questao] as $opcao) {
                                if (@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao) {
                                    //echo $opcao->in_valor;
                                    $nota += intval($opcao->in_valor);
                                    $resposta = utf8_decode($opcao->tx_opcao);
                                }
                                if ($max < intval($opcao->in_valor)) {
                                    $max = intval($opcao->in_valor);
                                }
                            }
                            $conteudo['campo'.$questao->pr_questao] = $resposta;
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += $max;
                        } elseif ($questao -> in_tipo == '3' || $questao -> in_tipo == '4') {
                            if ($questao -> in_tipo == '3') {
                                $array_resposta = array(""=>"","0"=>"Não","1"=>"Sim");
                            } else {
                                $array_resposta = array(""=>"","0"=>"Sim","1"=>"Não");
                            }
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '5') {
                            $nota = 0;
                            $nota += round((@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3) * intval($questao -> in_peso));
                            $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                            $conteudo['campo'.$questao->pr_questao] = @utf8_decode($valores[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta]);
                            $conteudo['valor'.$questao->pr_questao] = $nota;
                            $total+=$nota;
                            $maximo += intval($questao -> in_peso);
                        } elseif ($questao -> in_tipo == '6') {
                            $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $conteudo['valor'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                            $maximo += intval($questao -> in_peso);
                        }
                    }
                    if ($maximo == 0) {
                        $maximo =1;
                    }
                    $conteudo['total'] = $total;
                    $conteudo['percentual'] = (round(($total/$maximo)*100));
                    $this->csvmodel->escreveCache($conteudo);
                }
            }
        }
        $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_AvaliacaoEspecialista', "CSV de avaliação com especialista da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
        $this->csvmodel->printCache('avaliacao_especialista.csv');
    }
}
