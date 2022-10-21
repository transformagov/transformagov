<?php

defined('BASEPATH') or exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if (isset($adicionais)) {
    $pagina['adicionais']=$adicionais;
}

$pdf = new pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Dossiê '.$this -> config -> item('nome').' de \''.$candidato -> vc_nome.'\' para a vaga \''.$candidatura[0] -> vc_vaga.'\'');
//$pdf->setPageOrientation('P', false, 40);
//$pdf->SetAutoPageBreak(true, 100);
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Transforma Minas - SUGESP/SEPLAG MG');
$pdf->SetDisplayMode('real', 'default');

$pdf->AddPage();

$pdf->Image('./images/capa.jpg', 0, 0, 230, 300, 'JPG', '', false);
$pdf->Image('./images/logomg.jpg', 0, 260, 230, 35, 'JPG', '', false);

$pdf->setY(230);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 8, $candidatura[0] -> vc_vaga, 0, 1, 'R', 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 8, $candidatura[0] -> vc_instituicao, 0, 1, 'R', 0);

///////////////////////////////////////////////////

$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

$pdf->SetMargins(15, 10, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, 'ÍNDICE', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '1.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Informações Básicas e Currículo', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '2.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Resultado da Análise Curricular', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '3.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Resultado da Entrevista por Competências', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '4.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Momentos da Carreira', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '5.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Informações Complementares', 0, 0, 'L', 0);
$pdf->Ln(6);


///////////////////////////////////////////////////

$pdf->AddPage();

$pdf->SetMargins(15, 10, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, '1.  Informações básicas', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'Nome do(a) Candidato(a):', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'CPF:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> ch_cpf, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'Município de Residência:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> vc_municipio.' / '.$candidato -> ch_sigla, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'E-mail:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> vc_email, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'Telefone:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$telefones=$candidato -> vc_telefone;
if (strlen($candidato -> vc_telefoneOpcional)>0) {
    $telefones.=' - '.$candidato -> vc_telefoneOpcional;
}
$pdf->Cell(0, 6, $telefones, 0, 0, 'L', 0);
$pdf->Ln(6);

///////////////////////////////////////////////////

$pdf->AddPage();
$pdf->SetMargins(15, 30, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, '2.  Resultado da Análise Curricular', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Pré Requisitos', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
foreach ($questoes1 as $linha) {
    $res = "";
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
    $pdf->SetFont('helvetica', '', 10);

    foreach ($respostas as $linha2) {
        if ($linha2 -> es_questao == $linha -> pr_questao) {
            $res = $linha2 -> tx_resposta;
        }
    }

    if ($linha -> in_tipo == 1) {
        foreach ($opcoes as $row2) {
            if ($row2 -> pr_opcao == $res) {
                $res = $row2 -> tx_opcao;
            }
        }
    } elseif ($linha -> in_tipo == 3) {
        $valores=array(""=>"",0=>"Não",1=>"Sim");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == 4) {
        $valores=array(""=>"",0=>"Não",1=>"Sim");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == 5) {
        $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == '7') {
        if (isset($anexos_questao[$linha -> pr_questao])) {
            $res = "Inserido";
        } else {
            $res = 'Não Inserido';
        }
    }


    /*else if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){

    }
    else if($linha -> vc_respostaAceita == NULL || $linha -> in_tipo == 2){


    }*/

    if (strlen($res) == 0) {
        $res = "Resposta não Inserida";
    }
    $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
    $pdf->Ln(10);
}

$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Requisitos desejáveis', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
foreach ($questoes2 as $linha) {
    $res = "";
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
    $pdf->SetFont('helvetica', '', 10);

    foreach ($respostas as $linha2) {
        if ($linha2 -> es_questao == $linha -> pr_questao) {
            $res = $linha2 -> tx_resposta;
        }
    }
    if ($linha -> in_tipo == 1) {
        foreach ($opcoes as $row2) {
            if ($row2 -> pr_opcao == $res) {
                $res = $row2 -> tx_opcao;
            }
        }
    } elseif ($linha -> in_tipo == 3) {
        $valores=array(""=>"",0=>"Não",1=>"Sim");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == 4) {
        $valores=array(""=>"",0=>"Não",1=>"Sim");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == 5) {
        $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == '7') {
        if (isset($anexos_questao[$linha -> pr_questao])) {
            $res = "Inserido";
        } else {
            $res = 'Não Inserido';
        }
    }


    if (strlen($res) == 0) {
        $res = "Resposta não Inserida";
    }

    $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
    $pdf->Ln(10);
}
//**************************************
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Currículo', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
if (isset($formacoes)) {
    $i=0;
    foreach ($formacoes as $formacao) {
        ++$i;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Formação acadêmica {$i}", 0, 'L', 0);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Tipo", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        if ($formacao->en_tipo == 'bacharelado') {
            $res = 'Graduação - Bacharelado';
        } elseif ($formacao->en_tipo == 'tecnologo') {
            $res = 'Graduação - Tecnológo';
        } elseif ($formacao->en_tipo == 'especializacao') {
            $res = 'Pós-graduação - Especialização';
        } elseif ($formacao->en_tipo == 'mba') {
            $res = 'MBA';
        } elseif ($formacao->en_tipo == 'mestrado') {
            $res = 'Mestrado';
        } elseif ($formacao->en_tipo == 'doutorado') {
            $res = 'Doutorado';
        } elseif ($formacao->en_tipo == 'posdoc') {
            $res = 'Pós-doutorado';
        }

        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Nome do curso", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = $formacao->vc_curso;
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Instituição de ensino", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = $formacao->vc_instituicao;
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Data de conclusão", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = show_date($formacao->dt_conclusao);
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Diploma / certificado", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = "Não Inserido";
        if (isset($anexos) && is_array($anexos[$formacao->pr_formacao])) {
            foreach ($anexos[$formacao->pr_formacao] as $anexo) {
                $res = "Inserido";
            }
        }
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);
    }
}
//**************************************
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Experiência', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
if (isset($experiencias)) {
    $i=0;
    foreach ($experiencias as $experiencia) {
        ++$i;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Experiência profissional {$i}", 0, 'L', 0);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Instituição / empresa", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);

        $res = $experiencia->vc_empresa;
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Data de início", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = show_date($experiencia->dt_inicio);
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);

        if ($experiencia->bl_emprego_atual=='1') {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->MultiCell(0, 6, "Emprego atual?", 0, 'L', 0);
            $pdf->SetFont('helvetica', '', 10);
            $res = "Sim";
            $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
            $pdf->Ln(10);
        } else {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->MultiCell(0, 6, "Data de término", 0, 'L', 0);
            $pdf->SetFont('helvetica', '', 10);
            if (strlen($experiencia->dt_fim) > 0) {
                $res = show_date($experiencia->dt_fim);
            } else {
                $res = "Resposta não inserida";
            }
            $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
            $pdf->Ln(10);
        }


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Principais atividades desenvolvidas", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = $experiencia->tx_atividades;
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, "Comprovante", 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = "Não Inserido";
        if (isset($anexos_experiencia) && is_array($anexos_experiencia[$experiencia->pr_experienca])) {
            foreach ($anexos_experiencia[$experiencia->pr_experienca] as $anexo) {
                $res = "Inserido";
            }
        }
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);

        $pdf->Ln(10);
    }
}
//**************************************
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Avaliação do(a) candidato(a)', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
foreach ($questoes3 as $linha) {
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
    $pdf->SetFont('helvetica', '', 10);
    $res = "";
    foreach ($respostas as $linha2) {
        if ($linha2 -> es_questao == $linha -> pr_questao) {
            $res = $linha2 -> tx_resposta;
        }
    }

    if ($linha -> in_tipo == 1) {
        foreach ($opcoes as $row2) {
            if ($row2 -> pr_opcao == $res) {
                $res = $row2 -> tx_opcao;
            }
        }
    } elseif ($linha -> in_tipo == 3) {
        $valores=array(""=>"",0=>"Não",1=>"Sim");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == 4) {
        $valores=array(""=>"",0=>"Não",1=>"Sim");
        $res = @$valores[$res];
    } elseif ($linha -> in_tipo == 5) {
        $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
        $res = @$valores[$res];
    }

    if (strlen($res) == 0) {
        $res = "Resposta não Inserida";
    }

    $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
    $pdf->Ln(10);
}
//**************************************
if ($entrevista) {
    $pdf->AddPage();
    $pdf->SetMargins(15, 30, 15);

    $pdf->setY(15);
    $pdf->setX(100);
    $pdf->SetTextColor(28, 150, 140);
    $pdf->SetFont('helvetica', '', 11);
    $pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

    $pdf->setY(40);
    $pdf->setX(20);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 6, '3.  Resultado da Entrevista por Competências', 0, 0, 'L', 0);
    $pdf->Ln(10);

    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(28, 150, 140);
    $pdf->SetFont('helvetica', 'B', 10);
    if ($candidatura[0]->es_avaliador_competencia1 == $entrevista[0]->es_avaliador1) {
        $pdf->Cell(0, 8, 'Entrevista por competência pelo(a) '.$entrevista[0]->nome1, 0, 0, 'L', 1);
    } elseif ($candidatura[0]->es_avaliador_competencia1 == $entrevista[0]->es_avaliador2) {
        $pdf->Cell(0, 8, 'Entrevista por competência pelo(a) '.$entrevista[0]->nome2, 0, 0, 'L', 1);
    }

    $pdf->Ln(6);
    $pdf->Ln(6);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(240, 240, 240);
    foreach ($questoes4 as $linha) {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = "";
        foreach ($respostas as $linha2) {
            if ($linha2 -> es_questao == $linha -> pr_questao) {
                $res = $linha2 -> tx_resposta;
            }
        }

        if ($linha -> in_tipo == 1) {
            foreach ($opcoes as $row2) {
                if ($row2 -> pr_opcao == $res) {
                    $res = $row2 -> tx_opcao;
                }
            }
        } elseif ($linha -> in_tipo == 3) {
            $valores=array(""=>"",0=>"Não",1=>"Sim");
            $res = @$valores[$res];
        } elseif ($linha -> in_tipo == 4) {
            $valores=array(""=>"",0=>"Não",1=>"Sim");
            $res = @$valores[$res];
        } elseif ($linha -> in_tipo == 5) {
            $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
            $res = @$valores[$res];
        }

        if (strlen($res) == 0) {
            $res = "Resposta não Inserida";
        }

        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);
    }
}

$pdf->AddPage();
$pdf->SetMargins(15, 30, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, '4.  Momentos de Carreira', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 6, "Quais são as expectativas em relação a atuação nesta posição? Quais os resultados quer entregar? Que tipos de desafios acredita que enfrentará? E como pretende transpô-los?", 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 6, $candidatura[0] -> tx_expectativa_momento, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 6, "Observações:", 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 6, $candidatura[0] -> tx_observacoes_momento, 0, 'L', 0);
$pdf->Ln(6);

$pdf->AddPage();
$pdf->SetMargins(15, 30, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, '5.  Informações Complementares', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 6, "Pontos Fortes", 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 6, $candidatura[0] -> tx_pontos_fortes, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 6, "Pontos de Melhoria", 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 6, $candidatura[0] -> tx_pontos_melhorias, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 6, "Feedback ao(à) candidato(a)", 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 6, $candidatura[0] -> tx_feedback, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 6, "Comentários dos entrevistadores", 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 6, $candidatura[0] -> tx_comentarios, 0, 'L', 0);
$pdf->Ln(6);

$pdf->Output('dossie'.$candidatura[0] -> pr_candidatura.'.pdf', 'i');
