<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vagas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this -> session -> logado) {
            redirect('Publico');
        } elseif ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'avaliador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Vagas_model');
    }

    public function index($inativo = 0)
    {
        $this -> load -> helper('date');
        $this -> load -> model('Candidaturas_model');
        $this -> load -> helper('menu');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='index';
        $pagina['url']='Vagas/index';
        $pagina['nome_pagina']='Lista de vagas';
        $pagina['icone']='fa fa-thumbtack';
        $dados=$pagina;

        $dados['adicionais'] = array('datatables' => true);
        if ($inativo == '0') {
            if ($this -> session -> perfil == 'avaliador') {
                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object', '', 0, '', true, '', $this -> session -> uid);
            } else {
                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object', '', 0, '', true, '');
            }
        } else {
            if ($this -> session -> perfil == 'avaliador') {
                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object', '', 0, '', false, '', $this -> session -> uid);
            } else {
                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object');
            }
        }

        $dados['menu_vc_vaga'] = menuVcVaga($pagina['menu2'], $dados['vagas']);
        $dados['perfil_pode_adicionar_vaga'] = perfilPodeADicionarVaga('index', $this -> session -> perfil);
        $dados['criar_ou_editar_vaga'] = criarOuEditarVaga($pagina['menu2'], 1);
        $dados['perfil_pode_adicionar_vaga'] = perfilPodeADicionarVaga('index', $this -> session -> perfil);


        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '', '');
        if (isset($candidaturas)) {
            foreach ($candidaturas as $candidatura) {
                if ($candidatura -> es_status == '14') {
                    $dados['aguardando_decisao'][$candidatura -> es_vaga] = 1;
                }
                /*$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura);
                if(isset($notas[0] -> pr_nota)){
                        //if($candidatura -> es_status == 7 && $notas[0] -> es_etapa == 3){
                               //$dados['selecao_entrevista'][$candidatura -> es_vaga] = 1;
                        //}

                        $dados['visualizacao_nota'][$candidatura -> es_vaga] = 1;
                }*/
            }
        }
        $dados['inativo'] = $inativo;
        $dados['sucesso'] = '';
        $dados['erro'] = '';

        //$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '','','','7');
        $this -> load -> view('vagas', $dados);
    }
    public function create()
    {
        if ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Usuarios_model');
        $this -> load -> model('Instituicoes_model');
        $this -> load -> model('GruposVagas_model');
        $this -> load -> library('MY_Form_Validation');
        $this -> load -> helper('menu');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='create';
        $pagina['url']='Vagas/create';
        $pagina['nome_pagina']='Nova vaga';
        $pagina['icone']='fa fa-thumbtack';

        $dados=$pagina;
        $dados['adicionais'] = array('pickers' => true);
        //$dados += $this -> input -> post(null,true);

        $this -> form_validation -> set_rules('nome', "'Nome'", 'required|min_length[10]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome\'.'));
        $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
        $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
        $this -> form_validation -> set_rules('grupo', "'Grupo da vaga'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Grupo da vaga\' é obrigatório.'));
        $this -> form_validation -> set_rules('inicio', "'Início das inscrições'", 'required|valida_data|callback_data_maior', array('required' => 'O campo \'Início das inscrições\' é obrigatório.', 'valida_data' => 'A data \'Início das inscrições\' inserida é inválida.'));
        $this -> form_validation -> set_rules('fim', "'Término das inscrições'", 'required|valida_data', array('required' => 'O campo \'Término das inscrições\' é obrigatório.', 'valida_data' => 'A data \'Término das inscrições\' inserida é inválida.'));
        //$this -> form_validation -> set_rules('brumadinho', "'Tipo de vaga'", 'required');

        $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', '', 2);
        $usuarios = $dados['usuarios'];

        if ($this -> form_validation -> run() == false) {
            $dados['sucesso'] = '';
            $dados['erro'] = validation_errors();
        } else {
            //var_dump($this -> input -> post(null,true));
            $dados_form = $this -> input -> post(null, true);

            //if($dados_form['brumadinho'] == '0'){
            $dados_form['brumadinho'] = null;
            //}

            $vaga = $this -> Vagas_model -> create_vaga($dados_form);
            if ($vaga > 0) {
                $dados['sucesso'] = 'Vaga cadastrada com sucesso.<br/><br/><a href="'.base_url('Vagas/index').'" class="btn btn-light">Voltar</a>';
                $dados['erro'] =  null;

                if ($usuarios) {
                    foreach ($usuarios as $usuario) {
                        if (isset($dados_form['usuario'.$usuario->pr_usuario]) && $dados_form['usuario'.$usuario->pr_usuario] = $usuario->pr_usuario) {
                            $this -> Vagas_model -> create_vaga_avaliador($dados_form, $vaga, $usuario->pr_usuario);
                        }
                    }
                }

                $this -> Usuarios_model -> log('sucesso', 'Vagas/create', "Vaga {$vaga} criada com sucesso.", 'tb_vagas', $vaga);
            } else {
                $dados['sucesso'] = '';
                $dados['erro'] =  'Erro no cadastro da vaga. Os responsáveis já foram avisados.';
                $this -> Usuarios_model -> log('erro', 'Vagas/create', 'Erro de criação da vaga. Erro: '.$this -> db -> error('message'));
            }
        }

        $dados['menu_vc_vaga'] = menuVcVaga($pagina['menu2'], []);
        $dados['perfil_pode_adicionar_vaga'] = perfilPodeADicionarVaga($pagina['menu2'], $this -> session -> perfil);
        $dados['criar_ou_editar_vaga'] = criarOuEditarVaga($pagina['menu2'], $dados['sucesso']);
        $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', '', 2, '', true);
        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
        $dados['grupos'] = $this -> GruposVagas_model -> get_grupos();
        $this -> load -> view('vagas', $dados);
    }

    public function edit()
    {
        if ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Usuarios_model');
        $this -> load -> model('Instituicoes_model');
        $this -> load -> model('GruposVagas_model');

        $this -> load -> library('MY_Form_Validation');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='edit';
        $pagina['url']='Vagas/edit';
        $pagina['nome_pagina']='Editar vaga';
        $pagina['icone']='fa fa-thumbtack';

        $dados=$pagina;
        $dados['adicionais'] = array('pickers' => true);
        $dados_form = $this -> input -> post(null, true);
        $vaga = $this -> uri -> segment(3);
        if (isset($dados_form['codigo']) && $dados_form['codigo'] > 0) {
            $vaga = $dados_form['codigo'];
        }
        $dados_vaga = $this -> Vagas_model -> get_vagas($vaga);
        //var_dump($dados_vaga);
        $dados['codigo'] = $vaga;
        $dados += (array) $dados_vaga[0];

        if (!isset($dados['bl_brumadinho'])) {
            $dados['bl_brumadinho'] = '0';
        }
        if (!($dados['bl_brumadinho'] == 1)) {
            $dados['bl_brumadinho'] = '0';
        }

        //$dados += $this -> input -> post(null,true);
        //var_dump($this -> input -> post(null,true));

        $this -> form_validation -> set_rules('nome', "'Nome'", 'required|min_length[10]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome\'.'));
        $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
        $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
        $this -> form_validation -> set_rules('grupo', "'Grupo da vaga'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Grupo da vaga\' é obrigatório.'));
        $this -> form_validation -> set_rules('inicio', "'Início das inscrições'", 'required|valida_data|callback_data_maior', array('required' => 'O campo \'Início das inscrições\' é obrigatório.', 'valida_data' => 'A data \'Início das inscrições\' inserida é inválida.'));
        $this -> form_validation -> set_rules('fim', "'Término das inscrições'", 'required|valida_data|callback_data_fim', array('required' => 'O campo \'Término das inscrições\' é obrigatório.', 'valida_data' => 'A data \'Término das inscrições\' inserida é inválida.'));
        //$this -> form_validation -> set_rules('brumadinho', "'Tipo de vaga'", 'required');

        $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', '', 2, '', true);
        $usuarios = $dados['usuarios'];
        if ($this -> form_validation -> run() == false) {
            $dados['sucesso'] = '';
            $dados['erro'] = validation_errors();
        } else {
            //if($dados_form['brumadinho'] == '0'){
            $dados_form['brumadinho'] = null;
            //}

            $this -> Vagas_model -> update_vaga('vc_vaga', $dados_form['nome'], $vaga);
            $this -> Vagas_model -> update_vaga('tx_descricao', $dados_form['descricao'], $vaga);
            $this -> Vagas_model -> update_vaga('dt_inicio', show_sql_date($dados_form['inicio'], true), $vaga);
            $this -> Vagas_model -> update_vaga('dt_fim', show_sql_date($dados_form['fim'], true), $vaga);
            $this -> Vagas_model -> update_vaga('es_instituicao', $dados_form['instituicao'], $vaga);
            $this -> Vagas_model -> update_vaga('es_grupoVaga', $dados_form['grupo'], $vaga);
            $this -> Vagas_model -> update_vaga('bl_brumadinho', $dados_form['brumadinho'], $vaga);

            $this -> Vagas_model -> delete_vaga_avaliador($vaga);
            if ($usuarios) {
                foreach ($usuarios as $usuario) {
                    if (isset($dados_form['usuario'.$usuario->pr_usuario]) && $dados_form['usuario'.$usuario->pr_usuario] = $usuario->pr_usuario) {
                        $this -> Vagas_model -> create_vaga_avaliador($dados_form, $vaga, $usuario->pr_usuario);
                    }
                }
            }
            $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Vaga {$vaga} editada com sucesso pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);

            $dados['sucesso'] = 'Vaga editada com sucesso.<br/><br/><a href="'.base_url('Vagas/index').'" class="btn btn-light">Voltar</a>';
            $dados['erro'] = '';
        }

        $vagas_avaliadores = $this -> Vagas_model -> get_vagas_avaliadores($vaga);

        if ($vagas_avaliadores) {
            foreach ($vagas_avaliadores as $vaga_avaliador) {
                $dados['avaliador'][$vaga_avaliador->es_usuario] =  $vaga_avaliador->es_usuario;
            }
        }


        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
        $dados['grupos'] = $this -> GruposVagas_model -> get_grupos();
        $this -> load -> view('vagas', $dados);
    }

    public function resultado()
    {
        $this -> load -> model('Candidaturas_model');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='resultado';
        $pagina['url']='Vagas/resultado';
        $pagina['nome_pagina']='Resultados';
        $pagina['icone']='fa fa-sort-amount-down';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        $vaga = $this -> uri -> segment(3);
        if (isset($dados_form['codigo']) && $dados_form['codigo'] > 0) {
            $vaga = $dados_form['codigo'];
        }
        //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
        $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

        //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
        if ($this -> session -> perfil == 'avaliador') {
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20', $this -> session -> uid);
        } else {
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20');
        }

        //var_dump($candidaturas);
        $dados['candidaturas'] = array();


        $dados['entrevistas'] = array();

        $notas_totais = $this -> Candidaturas_model -> get_nota_total('', $vaga);
        if (!isset($notas_totais)) {
            $this ->calcula_nota($vaga, 2);
            $this ->calcula_nota($vaga, 3);
            $this ->calcula_nota($vaga, 4);
            $this ->calcula_nota($vaga, 5);
            $this ->calcula_nota($vaga, 6);
            $this ->calcula_nota($vaga, 7);
            $notas_totais = $this -> Candidaturas_model -> get_nota_total('', $vaga);
        }


        $dados['total2'] = 0;
        $dados['total3'] = 0;
        $dados['total4'] = 0;
        $dados['total5'] = 0;
        $dados['total6'] = 0;
        $dados['total7'] = 0;

        foreach ($notas_totais as $nota_total) {
            if ($nota_total -> es_etapa == '2') {
                $dados['total2'] = $nota_total->in_nota_total;
            }
            if ($nota_total -> es_etapa == '3') {
                $dados['total3'] = $nota_total->in_nota_total;
            }
            if ($nota_total -> es_etapa == '4') {
                $dados['total4'] = $nota_total->in_nota_total;
            }
            if ($nota_total -> es_etapa == '5') {
                $dados['total5'] = $nota_total->in_nota_total;
            }
            if ($nota_total -> es_etapa == '6') {
                $dados['total6'] = $nota_total->in_nota_total;
            }
            if ($nota_total -> es_etapa == '7') {
                $dados['total7'] = $nota_total->in_nota_total;
            }
        }



        if ($candidaturas) {
            $candidatura_anterior = -1;
            foreach ($candidaturas as $candidatura) {
                if ($candidatura_anterior == $candidatura -> pr_candidatura) {
                    continue;
                }

                $candidatura_anterior = $candidatura -> pr_candidatura;
                $entrevistas = $this -> Candidaturas_model -> get_entrevistas('', $candidatura -> pr_candidatura);
                if (isset($entrevistas)) {
                    foreach ($entrevistas as $entrevista) {
                        $dados['entrevistas'][$candidatura -> pr_candidatura][$entrevista -> bl_tipo_entrevista] = $entrevista;
                    }
                }
                $notas = $this -> Candidaturas_model -> get_nota('', $candidatura -> pr_candidatura, '');
                if (isset($notas)) {
                    //$dados['selecao_entrevista'][$candidatura->es_vaga]=1;
                    foreach ($notas as $nota) {
                        if ($nota -> es_etapa == '2') {
                            $candidatura -> in_nota2 = $nota -> in_nota;
                        }
                        if ($nota -> es_etapa == '3') {
                            $candidatura -> in_nota3 = $nota -> in_nota;
                        }
                        if ($nota -> es_etapa == '4') {
                            $candidatura -> in_nota4 = $nota -> in_nota;
                        }
                        if ($nota -> es_etapa == '5') {
                            $candidatura -> in_nota5 = $nota -> in_nota;
                        }
                        if ($nota -> es_etapa == '6') {
                            $candidatura -> in_nota6 = $nota -> in_nota;
                        }
                        if ($nota -> es_etapa == '7') {
                            $candidatura -> in_nota7 = $nota -> in_nota;
                        }
                    }
                }
                $dados['candidaturas'][] = $candidatura;
            }
        }
        //var_dump($dados['candidaturas']);

        $this -> load -> view('vagas', $dados);
    }

    public function resultado2()
    {
        if ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Questoes_model');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='resultado2';
        $pagina['url']='Vagas/resultado2';
        $pagina['nome_pagina']='Resultados por Competência';
        $pagina['icone']='fa fa-sort-amount-down';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        $vaga = $this -> uri -> segment(3);
        if (isset($dados_form['codigo']) && $dados_form['codigo'] > 0) {
            $vaga = $dados_form['codigo'];
        }
        //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
        $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

        //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20');
        //var_dump($candidaturas);
        $dados['candidaturas'] = $candidaturas;
        if ($candidaturas) {
            foreach ($candidaturas as $candidatura) {
                $notas = $this -> Candidaturas_model -> get_nota('', $candidatura -> pr_candidatura, '4', 'todos');
                if (isset($notas)) {
                    foreach ($notas as $nota) {
                        if (!isset($dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia])) {
                            /*echo "teste";
                            $dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia] = $dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia] + $nota -> in_nota;
                            ++$i[$candidatura->pr_candidatura];
                            if($i[$candidatura->pr_candidatura] == 3){
                                    $dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia] = $dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia]/3;
                            }
                                                }
                                                else{*/
                            //echo "teste1";
                            $dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia] = $nota -> in_nota;
                            $i[$candidatura->pr_candidatura]=1;
                        }
                    }
                }
            }
        }
        $dados['competencias'] = $this -> Questoes_model -> get_competencias();

        //var_dump($dados['candidaturas']);

        $this -> load -> view('vagas', $dados);
    }

    public function resultado3()
    {
        $this -> load -> model('Candidaturas_model');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='resultado3';
        $pagina['url']='Vagas/resultado3';
        $pagina['nome_pagina']='Resultados Reprovados Habilitação';
        $pagina['icone']='fa fa-sort-amount-down';

        $dados=$pagina;
        $dados['sucesso'] = '';
        $dados['erro'] = '';
        $dados['adicionais'] = array('datatables' => true);

        $vaga = $this -> uri -> segment(3);
        if (isset($dados_form['codigo']) && $dados_form['codigo'] > 0) {
            $vaga = $dados_form['codigo'];
        }
        //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
        $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

        //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '20,21');
        //var_dump($candidaturas);
        $dados['candidaturas'] = array();
        if ($candidaturas) {
            foreach ($candidaturas as $candidatura) {
                $notas = $this -> Candidaturas_model -> get_nota('', $candidatura -> pr_candidatura, '');
                if (isset($notas)) {
                    //$dados['selecao_entrevista'][$candidatura->es_vaga]=1;
                    foreach ($notas as $nota) {
                        if ($nota -> es_etapa == '3') {
                            $candidatura -> in_nota3 = $nota -> in_nota;
                        }
                        /*if($nota -> es_etapa == '4'){
                                $candidatura -> in_nota4 = $nota -> in_nota;
                        }
                        if($nota -> es_etapa == '5'){
                                $candidatura -> in_nota5 = $nota -> in_nota;
                        }
                        if($nota -> es_etapa == '6'){
                                $candidatura -> in_nota6 = $nota -> in_nota;
                        }*/
                    }
                }
                $dados['candidaturas'][] = $candidatura;
            }
        }
        //var_dump($dados['candidaturas']);

        $this -> load -> view('vagas', $dados);
    }



    public function delete()
    {
        if ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Usuarios_model');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='delete';
        $pagina['url']='Vagas/delete';
        $pagina['nome_pagina']='Desativar vaga';
        $pagina['icone']='fa fa-thumbtack';

        $dados=$pagina;
        $vaga = $this -> uri -> segment(3);

        $this -> Vagas_model -> update_vaga('bl_removido', '1', $vaga);
        $dados['sucesso'] = "A vaga foi desativada com sucesso.\n\n<a href=\"".base_url('Vagas/index').'" class="btn btn-light">Voltar</a>';
        $dados['erro'] = '';
        $this -> Usuarios_model -> log('sucesso', 'Vagas/delete', "Vaga {$vaga} desativada pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);
        echo "<script type=\"text/javascript\">alert('A vaga foi desativada com sucesso.');window.location='".base_url('Vagas/index')."';</script>";
        //$this -> load -> view('vagas', $dados);
    }
    public function reactivate()
    {
        if ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Usuarios_model');

        $pagina['menu1']='Vagas';
        $pagina['menu2']='reactivate';
        $pagina['url']='Vagas/reactivate';
        $pagina['nome_pagina']='Reativar vaga';
        $pagina['icone']='fa fa-thumbtack';

        $dados=$pagina;
        $vaga = $this -> uri -> segment(3);

        $this -> Vagas_model -> update_vaga('bl_removido', '0', $vaga);
        $dados['sucesso'] = "A vaga foi reaativada com sucesso.\n\n<a href=\"".base_url('Vagas/index').'" class="btn btn-light">Voltar</a>';
        $dados['erro'] = '';
        $this -> Usuarios_model -> log('sucesso', 'Vagas/reactivate', "Vaga {$vaga} reaativada pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);
        echo "<script type=\"text/javascript\">alert('A vaga foi reativada com sucesso.');window.location='".base_url('Vagas/index')."';</script>";
        //$this -> load -> view('vagas', $dados);
    }



    public function AgendamentoEntrevista($candidatura, $tipo_entrevista='competencia')
    { //agendamento - perfil gestores e avaliador
        if ($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador') {
            redirect('Interna/index');
        }
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> model('Questoes_model');
        $this -> load -> library('email');

        if ($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador') { //gestores
            $pagina['menu1']='Vagas';
            $pagina['menu2']='AgendamentoEntrevista';
            $pagina['url']='Vagas/AgendamentoEntrevista/'.$candidatura.'/'.$tipo_entrevista;
            $pagina['nome_pagina']='Agendamento de entrevista'.($tipo_entrevista == 'especialista' ? ' com especialista' : ' por competência');
            $pagina['icone']='fa fa-edit';

            $dados=$pagina;
            $dados['adicionais'] = array('pickers' => true,'calendar' => true,'moment'=>true,'select2'=>true);
            $dados_form = $this -> input -> post(null, true);
            //$candidatura = $this -> uri -> segment(3);
            if (isset($dados_form['codigo']) && $dados_form['codigo'] > 0) {
                $candidatura = $dados_form['codigo'];
            }
            $dados['codigo'] = $candidatura;
            $dados['tipo_entrevista'] = $tipo_entrevista;
            $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);



            $vaga = $this -> Vagas_model -> get_vagas($dados_candidatura[0]->es_vaga, false);

            $questoes2 = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 5);
            $questoes3 = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 7);

            $dados['questoes2'] = $questoes2;

            if ($tipo_entrevista=='competencia') {
                $questoes = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 4);
            } else {
                $questoes = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 6);
            }


            if (!isset($questoes)) {
                if ($tipo_entrevista=='competencia') {
                    echo "
                                        <script type=\"text/javascript\">
                                                alert('A entrevista por competência não pode ser aplicada para essa vaga.');
                                                window.location='/Vagas/resultado/".$dados_candidatura[0] -> es_vaga."';
                                        </script>";
                    exit();
                } else {
                    echo "
                                        <script type=\"text/javascript\">
                                                alert('A entrevista por especialista não pode ser aplicada para essa vaga.');
                                                window.location='/Vagas/resultado/".$dados_candidatura[0] -> es_vaga."';
                                        </script>";
                    exit();
                }
            }

            //var_dump($dados_candidatura);

            //$this -> form_validation -> set_rules('avaliador1', "'Avaliador 1'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Avaliador 1\' é obrigatório.'));
            //as regras podem ser colocadas como array, inseridas

            if ($tipo_entrevista == 'competencia') {
                $this -> form_validation -> set_rules('avaliador1', "'Avaliador 1'", 'required|differs[avaliador3]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 1\' é obrigatório.','differs'=>'O campo \'Avaliador 1\' deve ser diferente do \'Avaliador 3\'.'));
                $this -> form_validation -> set_rules('avaliador2', "'Avaliador 2'", 'required|differs[avaliador1]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 2\' é obrigatório.','differs'=>'O campo \'Avaliador 2\' deve ser diferente do \'Avaliador 1\'.'));
                if (isset($questoes2)) {
                    $this -> form_validation -> set_rules('data2', "'Data/Horário máximo'", 'required|valida_data', array('required' => 'O campo \'Data/Horário máximo\' é obrigatório.', 'valida_data' => 'A data do campo \'Data/Horário máximo\' inserida é inválida.'));
                }
                //$this -> form_validation -> set_rules('avaliador3', "'Avaliador 3'", 'required|differs[avaliador2]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 2\' é obrigatório.','differs'=>'O campo \'Avaliador 3\' deve ser diferente do \'Avaliador 2\'.'));
            } else {
                $this -> form_validation -> set_rules('avaliador1', "'Avaliador 1'", 'required|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 1\' é obrigatório.'));
            }
            $this -> form_validation -> set_rules('data', "'Horário da entrevista'", 'required|valida_data|callback_valida_unico3|callback_data_atual', array('required' => 'O campo \'Horário da entrevista\' é obrigatório.', 'valida_data' => 'A data do campo \'Horário da entrevista\' inserida é inválida.'));



            if ($this -> form_validation -> run() == false) {
                $dados['sucesso'] = '';
                $dados['erro'] = validation_errors();
            } else {
                /*if($dados_candidatura[0] -> es_status==11){
                        $tipo_entrevista = 'especialista';
                }
                else{
                        $tipo_entrevista = 'competencia';
                }*/
                $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
                //var_dump($dados_form);
                //var_dump($entrevista_anterior);
                if ($entrevista_anterior != null) {
                    $this->load->helper('emails');
                    $config = getEmailEnvConfigs();

                    $this->email->initialize($config);

                    if ($entrevista_anterior[0] -> es_avaliador1 != $dados_form['avaliador1']) {
                        $partes = explode(" ", $dados_form['data']);
                        $data = $partes[0];
                        $hora = $partes[1];
                        $this -> envio_email2($entrevista_anterior[0] -> nome1, $entrevista_anterior[0] -> email1, $entrevista_anterior[0]->nome_candidato, $dados_candidatura, $data, $hora, $dados_form['link'], 'reagendamento_cancelamento', $tipo_entrevista, $vaga);
                    }
                    if ($tipo_entrevista == 'competencia') {
                        if ($entrevista_anterior[0] -> es_avaliador2 != $dados_form['avaliador2']) {
                            $partes = explode(" ", $dados_form['data']);
                            $data = $partes[0];
                            $hora = $partes[1];
                            $this -> envio_email2($entrevista_anterior[0] -> nome2, $entrevista_anterior[0] -> email2, $entrevista_anterior[0]->nome_candidato, $dados_candidatura, $data, $hora, $dados_form['link'], 'reagendamento_cancelamento', $tipo_entrevista, $vaga);
                        }
                    }
                    //echo "'".substr($entrevista_anterior[0] -> dt_entrevista, 0, 16)."' - '".show_sql_date($dados_form['data'], true)."'<br>";
                    if (substr($entrevista_anterior[0] -> dt_entrevista, 0, 16) != show_sql_date($dados_form['data'], true)) {


                                                //$this -> email -> to($entrevista_anterior[0] -> email1.",".$entrevista_anterior[0] -> email2);
                        //if($dados_candidatura[0] -> es_status==10){
                        //$this -> email -> to();
                        //$this -> email -> to($entrevista_anterior[0] -> email3);
                        //}

                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                        $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

                        /*$config['charset'] = 'UTF-8';

                        $config['wordwrap'] = TRUE;

                        $config['mailtype'] = 'html';

                        $this->email->initialize($config);*/
                        $partes = explode(" ", $dados_form['data']);
                        $data = $partes[0];
                        $hora = $partes[1];
                        $this -> envio_email($dados_candidatura, $vaga, 'reagendamento_candidato', $tipo_entrevista, $data, $hora, $dados_form['link']);

                        $this -> envio_email2($entrevista_anterior[0] -> nome1, $entrevista_anterior[0] -> email1, $entrevista_anterior[0]->nome_candidato, $dados_candidatura, $data, $hora, $dados_form['link'], 'reagendamento', $tipo_entrevista, $vaga);
                        if ($tipo_entrevista == 'competencia') {
                            $this -> envio_email2($entrevista_anterior[0] -> nome2, $entrevista_anterior[0] -> email2, $entrevista_anterior[0]->nome_candidato, $dados_candidatura, $data, $hora, $dados_form['link'], 'reagendamento', $tipo_entrevista, $vaga);
                        }
                    }
                } else {
                    $dados_form['tipo_entrevista'] = $tipo_entrevista;

                    $this -> Candidaturas_model -> atualiza_entrevista($dados_form);

                    $entrevista_atual = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);

                    $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);


                    //$this -> email -> to($dados_candidato -> vc_email.",".$entrevista_atual[0] -> email1.",".$entrevista_atual[0] -> email2);

                    //echo $dados_candidato -> vc_email.",".$entrevista_atual[0] -> email1.",".$entrevista_atual[0] -> email2;



                    $partes = explode(" ", $dados_form['data']);
                    $data = $partes[0];
                    $hora = $partes[1];

                    //$msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>A entrevista foi marcada com sucesso.<br/>Data/horário novos: '.$dados_form['data'].'<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();

                    $this -> envio_email($dados_candidatura, $vaga, 'agendamento_entrevista', $tipo_entrevista, $data, $hora, $dados_form['link'], $dados_form['observacoes']);

                    $this -> envio_email2($entrevista_atual[0] -> nome1, $entrevista_atual[0] -> email1, $entrevista_atual[0]->nome_candidato, $dados_candidatura, $data, $hora, $dados_form['link'], 'agendamento_entrevista', $tipo_entrevista, $vaga);
                    if ($tipo_entrevista == 'competencia') {
                        $this -> envio_email2($entrevista_atual[0] -> nome2, $entrevista_atual[0] -> email2, $entrevista_atual[0]->nome_candidato, $dados_candidatura, $data, $hora, $dados_form['link'], 'agendamento_entrevista', $tipo_entrevista, $vaga);
                    }
                }
                if (isset($entrevista_anterior[0])) {
                    $dados_form['tipo_entrevista'] = $tipo_entrevista;

                    $this -> Candidaturas_model -> atualiza_entrevista($dados_form);
                }
                //echo "candidatura: $candidatura<br>";
                if ($dados_candidatura[0] -> es_status == 8) {
                    $this -> Candidaturas_model -> update_candidatura('es_status', 10, $candidatura);
                }


                //teste de aderencia
                if (isset($questoes2) && $dados_candidatura[0] -> en_aderencia != '2' && $tipo_entrevista == 'competencia' && strtotime(show_sql_date($dados_form['data2'], true)) != strtotime($dados_candidatura[0] -> dt_aderencia)) {
                    //echo $dados_candidatura[0] -> dt_aderencia.show_sql_date($dados_form['data2'],true);
                    $this -> Candidaturas_model -> update_candidatura('dt_aderencia', show_sql_date($dados_form['data2'], true), $candidatura);
                    $this -> Candidaturas_model -> update_candidatura('en_aderencia', '1', $candidatura);
                    if ($dados_candidatura[0] -> en_hbdi != '2' && $dados_candidatura[0] -> en_hbdi != '1') {
                        $this -> Candidaturas_model -> update_candidatura('en_hbdi', '1', $candidatura);
                    }
                    if (isset($questoes3) && $dados_candidatura[0] -> en_motivacao != '2' && $dados_candidatura[0] -> en_motivacao != '1') {
                        $this -> Candidaturas_model -> update_candidatura('en_motivacao', '1', $candidatura);
                    }

                    $this->load->helper('emails');
                    $config = getEmailEnvConfigs();

                    $partes = explode(" ", $dados_form['data2']);
                    $data = $partes[0];
                    $hora = $partes[1];

                    $this->email->initialize($config);

                    $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

                    $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                    $this -> email -> to($dados_candidato -> vc_email);

                    $this -> email -> subject('['.$this -> config -> item('nome').'] Teste de aderência');
                    //$msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>O teste de aderência deve ser preenchido.<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();

                    // $this -> config -> item('nome'),
                    // $this -> config -> item('subTituloPlataforma'),
                    // $dados_candidato -> in_genero
                    // $dados_candidato -> vc_nome
                    // $vaga[0] -> vc_vaga
                    // $data
                    // $hora

                    $msg= loadTestesAderenciaPerfilHBDIMotivaçãoServicoPublicoHtml(
                        $this -> config -> item('nome'),
                        $this -> config -> item('subTituloPlataforma'),
                        $dados_candidato -> in_genero,
                        $dados_candidato -> vc_nome,
                        $vaga[0] -> vc_vaga,
                        $data,
                        $hora
                    );
                    $this -> email -> message($msg);
                    if (!$this -> email -> send()) {
                        $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de Teste de Aderência e HBDI do '.$dados_candidato->vc_nome.' feito pelo usuário '.$this -> session -> uid);
                    } else {
                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'E-mail de entrevista do '.$dados_candidato->vc_nome.' enviado com sucesso pelo usuário '.$this -> session -> uid);
                    }
                    $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Inserção/Alteração de data limite do Teste de aderência e HBDI pelo usuário '.$this -> session -> uid);
                }
                $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura);

                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Entrevista para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' agendada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                $dados['sucesso'] = 'Entrevista agendada com sucesso.<br/><br/><a href="'.base_url('Vagas/resultado/'.$dados_candidatura[0]->es_vaga).'" class="btn btn-light">Voltar</a>';
                $dados['erro'] = '';
            }

            //var_dump($dados_form);
            $dados['candidato'] = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);
            $dados['candidatura'] = $dados_candidatura;
            //$dados['usuarios'] = $this -> Usuarios_model -> get_usuarios ('', '', 2,'',true);
            $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', '', array(2,3), $dados_candidatura[0] -> es_vaga, true);
            $dados['status'] = $this -> Candidaturas_model -> get_status();
            /*if($dados_candidatura[0] -> es_status==11){
                    $tipo_entrevista = 'especialista';
            }
            else{
                    $tipo_entrevista = 'competencia';
            }*/
            $dados['entrevista'] = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
        }
        /*
        else if($this -> session -> perfil == 'candidato' || $this -> session -> perfil == 'avaliador'){ //candidatos e avaliadores
                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='AgendamentoEntrevista';
                $pagina['url']='Candidaturas/AgendamentoEntrevista';
                $pagina['nome_pagina']='Seus agendamentos';
                $pagina['icone']='fa fa-calendar';

                $dados=$pagina;
                $dados['adicionais'] = array('calendar' => true,'moment'=>true);
                //$dados['adicionais'] = array('calendar' => true, 'moment' => true);
                $dados['status'] = $this -> Candidaturas_model -> get_status ();
                if($this -> session -> perfil == 'candidato'){
                        $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', $this -> session -> candidato, '', '', '', '');
                }
                else if($this -> session -> perfil == 'avaliador'){
                        $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', '', '', '', '', $this -> session -> uid);
                }
        }*/
        else {
            redirect('Interna/index');
        }
        //$this -> load -> view('avaliacoes', $dados);
        $this -> load -> view('vagas', $dados);
    }
    public function reprovar_restantes2()
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> library('email');

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        $vaga = $this -> uri -> segment(3);
        $dados_vaga = $this -> Vagas_model -> get_vagas($vaga);


        $pagina['menu1']='Vagas';
        $pagina['menu2']='';
        $pagina['url']='Vagas/resultado/';
        $pagina['nome_pagina']='Resultados';
        $pagina['icone']='fa fa-sort-amount-down';
        $dados=$pagina;



        /*$query = $this->db->query("SELECT * FROM tb_candidaturas where es_vaga=$vaga and es_status=16");
        if($query->num_rows() < 10){
                $dados['sucesso'] = '';
                $dados['erro'] = 'Deve existir ao menos 10 agendados para entrevista para usar essa funcionalidade.<br/><br/><a href="'.base_url('Vagas/resultado/'.$vaga).'" class="btn btn-light">Voltar</a>';
        }
        else{*/
        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '8,10,11,12,16');
        foreach ($candidaturas as $candidatura) {
            $this -> Candidaturas_model -> update_candidatura('es_status', 18, $candidatura -> pr_candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura -> pr_candidatura);

            $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);

            $this -> Usuarios_model -> log('sucesso', 'Vagas/reprovar_restantes2', "Candidatura {$candidatura -> pr_candidatura} reprovada no processo seletivo.", 'tb_candidaturas', $candidatura -> pr_candidatura);
            //*********************
            $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($candidato -> vc_email);
            $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação da candidatura');
            $msg='Olá '.$candidato -> vc_nome.',<br/><br/>Obrigado por participar do Transforma Minas, mas foi reprovado na vaga '.$dados_vaga[0] -> vc_vaga.'.<br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação dessa candidatura. Acesse o sistema por meio do link: '.base_url();
            $this -> email -> message($msg);
            //echo $msg;
                                /*if(!$this -> email -> send()){
                                        $this -> Usuarios_model -> log('erro', 'Vagas/reprovar_restantes2', 'Erro de envio de e-mail de reprovação da candidatura '.$candidatura -> pr_candidatura.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura -> pr_candidatura);
                                }*/
        }

        $this -> Vagas_model -> update_vaga('bl_finalizado', '1', $vaga);

        $dados['sucesso'] = 'As candidaturas sem agendamento de entrevistas foram marcadas como reprovadas.<br /><br /><a href="'.base_url('Vagas/resultado/'.$vaga).'" class="btn btn-light">Voltar</a>';
        $dados['erro'] = '';
        //}

        $this -> load -> view('vagas', $dados);
    }

    public function reprovar_restantes()
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> library('email');

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        $pagina['menu1']='Vagas';
        $pagina['menu2']='';
        $pagina['url']='Vagas/resultado';
        $pagina['nome_pagina']='Resultados';
        $pagina['icone']='fa fa-sort-amount-down';
        $dados=$pagina;

        $vaga = $this -> uri -> segment(3);
        $dados_vaga = $this -> Vagas_model -> get_vagas($vaga);

        /*$query = $this->db->query("SELECT * FROM tb_candidaturas where es_vaga=$vaga and es_status=9");
        if($query->num_rows() < 10){
                $dados['sucesso'] = '';
                $dados['erro'] = 'Deve existir ao menos 10 agendados para entrevista para usar essa funcionalidade.<br/><br/><a href="'.base_url('Vagas/resultado/'.$vaga).'" class="btn btn-light">Voltar</a>';
        }
        else{*/
        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', 8);

        $candidaturas2 = $candidaturas;

        foreach ($candidaturas2 as $candidatura) {
            $this -> Candidaturas_model -> update_candidatura('es_status', 9, $candidatura -> pr_candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura -> pr_candidatura);

            $candidato = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);

            $this -> Usuarios_model -> log('sucesso', 'Vagas/reprovar_restantes', "Candidatura {$candidatura -> pr_candidatura} reprovada na análise curricular.", 'tb_candidaturas', $candidatura -> pr_candidatura);
            //*********************
            $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($candidato -> vc_email);
            $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação da candidatura na análise curricular');
            $msg='Olá '.$candidato -> vc_nome.',<br/><br/>Obrigado por participar do Transforma Minas, mas foi reprovado na análise curricular na vaga '.$dados_vaga[0] -> vc_vaga.'.<br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação dessa candidatura. Acesse o sistema por meio do link: '.base_url();
            $this -> email -> message($msg);
            //echo $msg;
                                /*if(!$this -> email -> send()){
                                        $this -> Usuarios_model -> log('erro', 'Vagas/reprovar_restantes', 'Erro de envio de e-mail de reprovação na análise curricular da candidatura '.$candidatura -> pr_candidatura.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura -> pr_candidatura);
                                }*/
        }
        $dados['sucesso'] = 'As candidaturas sem agendamento de entrevistas foram marcadas como reprovadas.<br /><br /><a href="'.base_url('Vagas/resultado/'.$vaga).'" class="btn btn-light">Voltar</a>';
        $dados['erro'] = '';
        //}

        $this -> load -> view('vagas', $dados);
    }

    public function calcula_nota($vaga, $etapa)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Questoes_model');

        $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, $etapa, '', true, '1');
        if (isset($questoes)) {
            foreach ($questoes as $questao) {
                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
            }
        }

        if ($etapa == 2 || $etapa == 3 || $etapa == 4 || $etapa == 5 || $etapa == 6 || $etapa == 7) {
            $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, $etapa, '', true);

            $total_max = 0;
            if (isset($questoes)) {
                foreach ($questoes as $questao) {
                    if ($questao -> in_tipo == '1') {
                        $max = 0;
                        foreach ($opcoes[$questao -> pr_questao] as $opcao) {
                            if ($max < intval($opcao->in_valor)) {
                                $max = intval($opcao->in_valor);
                            }
                        }
                        $total_max += $max;
                    } elseif ($questao -> in_tipo == '3' || $questao -> in_tipo == '4') {
                        $total_max += intval($questao -> in_peso);
                    } elseif ($questao -> in_tipo == '5') {
                        $total_max += intval($questao->in_peso);
                    } elseif ($questao -> in_tipo == '6') {
                        $total_max += intval($questao -> in_peso);
                    }
                }
            }


            $notas = $this -> Candidaturas_model -> get_nota_total('', $vaga, $etapa);

            if (isset($notas[0] -> pr_nota_total)) {
                if ($notas[0] -> in_nota_total != $total_max) {
                    $this -> Candidaturas_model -> update_nota_total('in_nota_total', $total_max, $notas[0] -> pr_nota_total);
                }
            } else {
                $dados_nota=array('vaga'=>$vaga,'nota_total'=>$total_max,'etapa'=>$etapa);
                $this -> Candidaturas_model -> create_nota_total($dados_nota);
            }
        }
    }

    public function recalcular_nota($vaga)
    {
        $this->calcula_nota($vaga, 3);
        $this->calcula_nota($vaga, 4);
        $this->calcula_nota($vaga, 5);
        $this->calcula_nota($vaga, 6);
        $this->calcula_nota($vaga, 7);
        redirect('Vagas/resultado/'.$vaga);
    }

    public function reprovar_habilitacao($id)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> library('email');

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        $pagina['menu1']='Vagas';
        $pagina['menu2']='';
        $pagina['url']='Vagas/resultado';
        $pagina['nome_pagina']='Resultados';
        $pagina['icone']='fa fa-sort-amount-down';
        $dados=$pagina;

        //$vaga = $this -> uri -> segment(3);



        $candidatura = $this -> Candidaturas_model -> get_candidaturas($id);
        //foreach($candidaturas as $candidatura){
        $this -> Candidaturas_model -> update_candidatura('es_status', 21, $candidatura[0] -> pr_candidatura);
        $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura[0] -> pr_candidatura);
        $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);

        $candidato = $this -> Candidatos_model -> get_candidatos($candidatura[0] -> es_candidato);

        $this -> Usuarios_model -> log('sucesso', 'Vagas/reprovar_restantes', "Candidatura {$candidatura[0] -> pr_candidatura} reprovação na habilitação.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
        //*********************
        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
        $this -> email -> to($candidato -> vc_email);
        $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação da candidatura na análise curricular');
        $msg=loadCandidaturaReprovadaHtml(
            $this -> config -> item('nome'),
            $this -> config -> item('subTituloPlataforma'),
            $candidato -> in_genero,
            $candidato -> vc_nome,
            $vaga[0] -> vc_vaga
        );
        $this -> email -> message($msg);
        /*if(!$this -> email -> send()){
                $this -> Usuarios_model -> log('erro', 'Candidatos/AvaliacaoCurriculo', 'Erro de envio de e-mail de reprovação na habilitação da candidatura '.$candidatura[0] -> pr_candidatura.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
        }*/
        //}
        /*$dados['sucesso'] = 'As candidaturas do candidato '.$candidato -> vc_nome.' foi reprovada em definitivo.<br/><br/><a href="'.base_url('Vagas/resultado/'.$candidatura[0] -> es_vaga).'" class="btn btn-light">Voltar</a>';
        $dados['erro'] = '';*/


        //$this -> load -> view('vagas', $dados);
        redirect('Vagas/resultado/'.$candidatura[0] -> es_vaga);
    }

    public function teste_aderencia($candidatura)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> model('Questoes_model');




        //$candidatura = $this -> uri -> segment(3);
        //$this -> Candidaturas_model -> update_candidatura('es_status', 8,  $candidatura);


        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

        $vaga = $this -> Vagas_model -> get_vagas($dados_candidatura[0]->es_vaga, false);
        $questoes = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 5);

        if (!isset($questoes)) {
            echo "
                                <script type=\"text/javascript\">
                                        alert('O teste de aderência não pode ser aplicado para essa vaga.');
                                        window.location='/Vagas/resultado/".$dados_candidatura[0] -> es_vaga."';
                                </script>";
        } else {
            $this -> Candidaturas_model -> update_candidatura('en_aderencia', '1', $candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura);



            $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Teste de aderência para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' habilitada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

            $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

            $this->load->helper('emails');
            $config = getEmailEnvConfigs();

            $this->email->initialize($config);

            $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($dados_candidato -> vc_email);

            $this -> email -> subject('['.$this -> config -> item('nome').'] Teste de aderência');
            //$msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>O teste de aderência deve ser preenchido.<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
            $msg = loadTesteDeAderenciaHtml(
                $this->config->item('nome'),
                $this->config->item('subTituloPlataforma'),
                $dados_candidato -> in_genero,
                $dados_candidato -> vc_nome,
                $vaga[0] -> vc_vaga
            );
            $this -> email -> message($msg);
            if (!$this -> email -> send()) {
                $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
            }

            redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
        }
    }

    public function reprovar_revisao_requisitos($candidatura)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> library('email');

        //$candidatura = $this -> uri -> segment(3);
        $this -> Candidaturas_model -> update_candidatura('es_status', 13, $candidatura);
        //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
        $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura);

        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Teste de aderência para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' habilitada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);
        $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
        $this -> email -> to($dados_candidato -> vc_email);

        $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação na revisão de requisitos');


        //$msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>Sua candidatura foi eliminada na revisão dos requisitos.<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
        $msg=loadReprovacaoHtml(
            $this -> config -> item('nome'),
            $this -> config -> item('subTituloPlataforma'),
            $dados_candidato -> in_genero,
            $dados_candidato -> vc_nome
        );

        $this -> email -> message($msg);
        /*if(!$this -> email -> send()){
                $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
        }*/
        redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
    }

    public function reprovar_entrevista($candidatura)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> library('email');

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        //$candidatura = $this -> uri -> segment(3);
        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

        if ($dados_candidatura[0] -> en_aderencia =='1') {
            $this -> Candidaturas_model -> update_candidatura('es_status', 15, $candidatura);
            //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura);

            $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Teste de aderência para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' habilitada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);


            $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);
            $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($dados_candidato -> vc_email);

            $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação por não preenchimento do teste de aderência');
            $msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>Sua candidatura foi eliminada pelo não preenchimento do teste de aderência.<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
            $this -> email -> message($msg);
            /*if(!$this -> email -> send()){
                    $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
            }*/
        }
        redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
    }

    public function aguardar_decisao_final($candidatura)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        //$this -> load -> library('email');
        //$candidatura = $this -> uri -> segment(3);
        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);
        $entrevista = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, 'especialista');
        if ((strlen($dados_candidatura[0] -> en_aderencia) == 0 || $dados_candidatura[0] -> en_aderencia == '2') && (($dados_candidatura[0] -> es_status == 11 && !isset($entrevista)) || $dados_candidatura[0] -> es_status == 12)) {
            $this -> Candidaturas_model -> update_candidatura('es_status', 14, $candidatura);
            //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura);

            $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Alteração do status da candidatura '.$dados_candidatura[0] -> pr_candidatura.' para aguardando decisão final com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);


            $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

            $this -> load -> library('email');

            $this->load->helper('emails');
            $config = getEmailEnvConfigs();

            $this->email->initialize($config);

            $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($dados_candidato -> vc_email);

            $this -> email -> subject('['.$this -> config -> item('nome').'] Aprovação para aguardando decisão final');
            //$msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>Sua candidatura está esperando a decisão final.<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();

            $msg=loadAguardandoDecisaoFinalHtml(
                $this -> config -> item('nome'),
                $this -> config -> item('subTituloPlataforma'),
                $dados_candidato -> in_genero,
                $dados_candidato->vc_nome
            );

            $this -> email -> message($msg);
            if (!$this -> email -> send()) {
                $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
            }
        }
        redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
    }

    public function aprovar_final($candidatura)
    {
        $this -> load -> model('Candidaturas_model');
        $this -> load -> model('Candidatos_model');
        $this -> load -> model('Usuarios_model');
        $this -> load -> library('email');
        //$candidatura = $this -> uri -> segment(3);
        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);
        $entrevista = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, 'especialista');
        if ($dados_candidatura[0] -> es_status == 16) {
            $this -> Candidaturas_model -> update_candidatura('es_status', 19, $candidatura);
            //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'), $candidatura);

            $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Candidatura '.$dados_candidatura[0] -> pr_candidatura.' aprovada, com status inserido pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);


            $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

            $this->load->helper('emails');
            $config = getEmailEnvConfigs();

            $this->email->initialize($config);

            $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($dados_candidato -> vc_email);

            $this -> email -> subject('['.$this -> config -> item('nome').'] Candidatura aprovada');
            $msg='Olá '.$dados_candidato->vc_nome.',<br/><br/>Sua candidatura foi aprovada.<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
            $this -> email -> message($msg);
            /*if(!$this -> email -> send()){
                    $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
            }*/
        }
        redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
    }

    public function liberar_vaga($vaga)
    {
        $dados_vaga = $this -> Vagas_model -> get_vagas($vaga);

        $this -> load -> model('Questoes_model');
        $this -> load -> model('Usuarios_model');
        $questoes1 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 1);
        $questoes2 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 2);
        $questoes3 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 3);

        $questoes4 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 4);
        $questoes5 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 5);
        $questoes6 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 6);

        // && isset($questoes4) && isset($questoes2)
        if (isset($questoes1) && isset($questoes3)) {
            $this -> Vagas_model -> update_vaga('bl_liberado', '1', $vaga);
            $this -> Usuarios_model -> log('sucesso', 'Vagas/liberar_vaga', 'Vaga '.$vaga.' liberada com sucesso pelo usuário '.$this -> session -> uid, 'tb_vagas', $vaga);
            echo "
                                <script type=\"text/javascript\">
                                        alert('Vaga liberada para preenchimento público.');
                                        window.location='/Vagas/index';
                                </script>";
        } else {
            echo "
                                <script type=\"text/javascript\">
                                        alert('Insira as questões de todas as etapas do grupo de vagas relativas a essa vaga.');
                                        window.location='/Questoes/index/".$dados_vaga[0] -> es_grupoVaga."';
                                </script>";
        }
    }

    /*
    public function questoes()	{
            $this -> load -> helper('date');

            $pagina['menu1']='Vagas';
            $pagina['menu2']='index';
            $pagina['url']='Vagas/questoes';
            $pagina['nome_pagina']='Lista de questões';
            $pagina['icone']='fa fa-thumbtack';

            $dados=$pagina;
            $dados['adicionais'] = array('datatables' => true);
            $vaga = $this -> uri -> segment(3);

            $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');
            $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $vaga);

            $this -> load -> view('vagas', $dados);
    }
    public function createQuestoes(){
            $this -> load -> model('Usuarios_model');
            $this -> load -> model('Questoes_model');
            $this -> load -> library('MY_Form_Validation');

            $pagina['menu1']='Vagas';
            $pagina['menu2']='questoes';
            $pagina['url']='Vagas/questoes';
            $pagina['nome_pagina']='Definir questões';
            $pagina['icone']='fa fa-thumbtack';

            $dados=$pagina;
            //$dados['adicionais'] = array('pickers' => true);
            $dados_form = $this -> input -> post(null,true);
            $vaga = $this -> uri -> segment(3);
            if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                    $vaga = $dados_form['codigo'];
            }
            $dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
            //var_dump($dados_vaga);
            $dados['codigo'] = $vaga;
            $dados += (array) $dados_vaga[0];
            //$dados += $this -> input -> post(null,true);
            //var_dump($this -> input -> post(null,true));

            $this -> form_validation -> set_rules('nome', "'Nome'", 'required|min_length[10]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome\'.'));
            $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
            $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
            $this -> form_validation -> set_rules('grupo', "'Grupo da vaga'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Grupo da vaga\' é obrigatório.'));
            $this -> form_validation -> set_rules('inicio', "'Início das inscrições'", 'required|valida_data', array('required' => 'O campo \'Início das inscrições\' é obrigatório.', 'valida_data' => 'A data \'Início das inscrições\' inserida é inválida.'));
            $this -> form_validation -> set_rules('fim', "'Término das inscrições'", 'required|valida_data', array('required' => 'O campo \'Término das inscrições\' é obrigatório.', 'valida_data' => 'A data \'Término das inscrições\' inserida é inválida.'));

            if ($this -> form_validation -> run() == FALSE){
                    $dados['sucesso'] = '';
                    $dados['erro'] = validation_errors();
            }
            else{
                    $this -> Vagas_model -> update_vaga('vc_vaga', $dados_form['nome'], $vaga);
                    $this -> Vagas_model -> update_vaga('tx_descricao', $dados_form['descricao'], $vaga);
                    $this -> Vagas_model -> update_vaga('dt_inicio', show_sql_date($dados_form['inicio'], true), $vaga);
                    $this -> Vagas_model -> update_vaga('dt_fim', show_sql_date($dados_form['fim'], true), $vaga);
                    $this -> Vagas_model -> update_vaga('es_instituicao', $dados_form['instituicao'], $vaga);
                    $this -> Vagas_model -> update_vaga('es_grupoVaga', $dados_form['grupo'], $vaga);

                    $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Vaga {$vaga} editada com sucesso pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);

                    $dados['sucesso'] = 'Vaga editada com sucesso.<br/><br/><a href="'.base_url('Vagas/index').'" class="btn btn-light">Voltar</a>';
                    $dados['erro'] = '';
            }

            $dados['etapas'] = $this -> Questoes_model -> get_etapas();
            $dados['questoes_atuais'] = $this -> Questoes_model -> get_questoes('', $vaga);
            $dados['outras_questoes1'] = $this -> Questoes_model -> get_questoes('', '', 1, $vaga);
            $dados['outras_questoes2'] = $this -> Questoes_model -> get_questoes('', '', 2, $vaga);
            $dados['outras_questoes3'] = $this -> Questoes_model -> get_questoes('', '', 3, $vaga);
            $this -> load -> view('vagas', $dados);
    }
    public function selecionar_entrevista($vaga){
            $this -> load -> model('Candidaturas_model');

            $this -> load -> library('MY_Form_Validation');

            $pagina['menu1']='Vagas';
            $pagina['menu2']='selecionar_entrevista';
            $pagina['url']='Vagas/selecionar_entrevista/'.$vaga;
            $pagina['nome_pagina']='Selecionar candidatos para a entrevista';
            $pagina['icone']='fa fa-thumbtack';
            $dados=$pagina;

            $dados['adicionais'] = array(
                                        'datatables' => true);

            //$dados['codigo']=$id;
            $dados['sucesso'] = '';
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '',$vaga,'','7');
            $dados["candidaturas"]=array();
            foreach($candidaturas as $candidatura){
                 $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura->pr_candidatura,3);
                 if(isset($notas[0]->pr_nota)){
                        //$dados['selecao_entrevista'][$candidatura->es_vaga]=1;
                        $candidatura->in_nota=$notas[0]->in_nota;
                        $dados["candidaturas"][] = $candidatura;

                 }
            }

            $this -> load -> view('vagas', $dados);
    }
    public function visualizar_nota($vaga){
            $this -> load -> model('Candidaturas_model');

            $this -> load -> library('MY_Form_Validation');

            $pagina['menu1']='Vagas';
            $pagina['menu2']='visualizar_nota';
            $pagina['url']='Vagas/visualizar_nota/'.$vaga;
            $pagina['nome_pagina']='Visualização das notas';
            $pagina['icone']='fa fa-thumbtack';
            $dados=$pagina;

            $dados['adicionais'] = array(
                                        'datatables' => true);

            //$dados['codigo']=$id;
            $dados['sucesso'] = '';
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '',$vaga);
            $dados["candidaturas"]=array();
            foreach($candidaturas as $candidatura){
                 $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura->pr_candidatura);
                 if(isset($notas)){
                        //$dados['selecao_entrevista'][$candidatura->es_vaga]=1;
                        foreach($notas as $nota){
                                if($nota->es_etapa==3){

                                        $candidatura->in_nota3=$nota->in_nota;
                                }
                                if($nota->es_etapa==4){
                                        $candidatura->in_nota4=$nota->in_nota;
                                }
                        }


                 }
                 if(isset($candidatura->in_nota3)||isset($candidatura->in_nota4)){
                        $dados["candidaturas"][] = $candidatura;
                 }
            }

            $this -> load -> view('vagas', $dados);
    }

    public function aprovar_entrevista($candidatura){
            $this -> load -> model('Candidaturas_model');
            $this -> load -> model('Usuarios_model');
            $this -> Candidaturas_model -> update_candidatura('es_status', 9,  $candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura);

            $this -> Usuarios_model -> log('sucesso', 'Vagas/aprovar_entrevista', "Candidatura {$candidatura} aprovada para entrevista.", 'tb_candidaturas', $candidatura);

            redirect('Vagas/index');
    }

    public function reprovar_curriculo($candidatura){
            $this -> load -> model('Candidaturas_model');
            //$this -> load -> model('Candidatos_model');
            $this -> load -> model('Usuarios_model');
            $this -> Candidaturas_model -> update_candidatura('es_status', 8,  $candidatura);
            $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura);

            $candidaturas = $this -> Candidaturas_model -> get_candidaturas($candidatura);
            $candidato = $this -> Candidatos_model -> get_candidatos($candidaturas[0]->es_candidato);


            $this -> Usuarios_model -> log('sucesso', 'Vagas/aprovar_entrevista', "Candidatura {$candidatura} reprovada na análise curricular.", 'tb_candidaturas', $candidatura);
            //*********************
            /*$this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
            $this -> email -> to($candidato -> vc_email);
            $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação da análise curricular');
            $msg='Olá '.$entrevista_anterior[0] -> nome1.',<br/><br/>Obrigado por participar do Transforma Minas, mas foi reprovado da análise curricular:<br/>Data: '.show_date($entrevista_anterior[0] -> dt_entrevista, true).'<br/><br/>Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: <a href="'.base_url()."\">".base_url()."</a></body></html>";
            $this -> email -> message($msg);
            if(!$this -> email -> send()){
                    $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email1.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
            }*/
    /*
            //*********************
            redirect('Vagas/index');
    }
    */
    public function valida_unico1($avaliador)
    {
        //return true;
        $candidatura = $this -> input -> post('codigo');
        $tipo_entrevista = $this -> input -> post('tipo_entrevista');
        $data = show_sql_date($this -> input ->post('data'), true);
        $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
        if ((isset($entrevista_anterior[0]->es_avaliador1) && $entrevista_anterior[0]->es_avaliador1==$avaliador) || (isset($entrevista_anterior[0]->es_avaliador2) && $entrevista_anterior[0]->es_avaliador2==$avaliador)) {
            return true;
        }
        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '', '', '', $avaliador);

        if (isset($candidaturas)) {
            foreach ($candidaturas as $row) {
                if (substr($row -> dt_entrevista, 0, -3) == $data && $row -> pr_candidatura != $candidatura && ($avaliador == $row -> es_avaliador1 || $avaliador == $row -> es_avaliador2)) {
                    $this -> form_validation -> set_message('valida_unico1', 'Já existe uma entrevista marcada para essa data para esse avaliador.');
                    return false;
                }
            }
        }
        //$this -> form_validation -> set_message('valida_unico1', $avaliador);

        //return false;
        return true;
    }
    /*function valida_unico2($avaliador){
            $candidatura = $this -> input -> post('$codigo');
            $tipo_entrevista = $this -> input -> post('tipo_entrevista');
            $data = show_sql_date($this -> input ->post('data'));
            $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
            if(isset($entrevista_anterior[0]->es_avaliador2) && $entrevista_anterior[0]->es_avaliador2==$avaliador){
                    return true;
            }
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas ('', '', '', '', '', $avaliador);
            if(isset($candidaturas)){
                    foreach($candidaturas as $row){
                            if(substr($row -> dt_entrevista,0,-3) == $data){
                                    $this -> form_validation -> set_message('valida_unico2', 'Já existe uma entrevista marcada para essa data para o \'Avaliador 2\'.');
                                    return false;
                            }
                    }
            }

            return true;

    }*/

    public function data_maior($data)
    {
        $inicio = show_sql_date($data, true);
        $fim = show_sql_date($this -> input -> post('fim'), true);

        if (strtotime($inicio) >= strtotime($fim)) {
            $this -> form_validation -> set_message('data_maior', 'A data de Término deve ser maior que o \'Início das inscrições\'');
            return false;
        }
        return true;
    }

    public function data_fim($data)
    {
        $fim = show_sql_date($data, true);
        $atual = time();
        $this -> load -> model('Candidaturas_model');


        if (strtotime($fim) < $atual) {
            $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $this -> input -> post('codigo'));
            if (is_array($candidaturas)) {
                foreach ($candidaturas as $candidatura) {
                    //echo $fim."".$candidatura -> dt_realizada."<br />";
                    if ((strtotime($candidatura -> dt_candidatura) > strtotime($fim) && $candidatura -> es_status < 7 && $candidatura -> es_status <> 5) || ($candidatura -> es_status >= 7 and strtotime($candidatura -> dt_realizada) > strtotime($fim))) {
                        $this -> form_validation -> set_message('data_fim', 'A data de Término está menor que a de candidaturas pendentes.');
                        return false;
                    }
                }
            }
        }
        return true;
    }


    public function valida_unico3($data)
    {
        //return true;
        $data = show_sql_date($data, true);
        $candidatura = $this -> input -> post('codigo');
        $tipo_entrevista = $this -> input -> post('tipo_entrevista');



        $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
        //echo substr($entrevista_anterior[0] -> dt_entrevista,0,-3);
        if (isset($entrevista_anterior[0]->dt_entrevista) && substr($entrevista_anterior[0] -> dt_entrevista, 0, -3)==$data) {
            return true;
        }



        $candidaturas2 = $this -> Candidaturas_model -> get_candidaturas($candidatura);

        $candidato = $candidaturas2[0] -> es_candidato;

        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', $candidato, '', '', '', '', 1);
        //echo $this -> db -> last_query();
        if (isset($candidaturas)) {
            //echo $candidatura;
            foreach ($candidaturas as $row) {
                //echo substr($row -> dt_entrevista,0,-3);
                if (substr($row -> dt_entrevista, 0, -3) == $data && $row -> pr_candidatura != $candidatura && ($avaliador == $row -> es_avaliador1 || $avaliador == $row -> es_avaliador2)) {
                    $this -> form_validation -> set_message('valida_unico3', 'Já existe uma entrevista marcada para essa data para esse candidato.');
                    return false;
                }
            }
        }

        return true;
    }

    public function data_atual($data)
    {
        $data = show_sql_date($data);

        if (strtotime($data)<=strtotime(date('Y-m-d'))) {
            $this -> form_validation -> set_message('data_atual', 'A data de agendamento deve ser maior que a atual.');
            return false;
        }
        //return false;
        return true;
    }

    private function envio_email($candidatura, $vaga, $modelo, $tipo_entrevista, $data='', $hora='', $link='', $observacoes='')
    {
        $candidato = $this -> Candidatos_model -> get_candidatos($candidatura[0] -> es_candidato);
        $titulo = array('agendamento_entrevista'=>'] Entrevista Marcada','reagendamento_candidato'=>'] Alteração de data/horário de entrevista');

        $this->load->helper('emails');

        if ($modelo == 'agendamento_entrevista') {
            $msg['agendamento_entrevista']= loadAgendamentoDeEntrevistaHtml(
                $this->config->item('nome'),
                $this->config->item('subTituloPlataforma'),
                $tipo_entrevista,
                $candidato->vc_nome,
                $data,
                $hora,
                $vaga[0] -> vc_vaga,
                $link,
                $observacoes
            );
        } elseif ($modelo == 'reagendamento_candidato') {
            $msg['reagendamento_candidato']= loadReagendamentoDeEntrevistaHtml(
                $this->config->item('nome'),
                $this->config->item('subTituloPlataforma'),
                $candidato -> in_genero,
                $candidato->vc_nome,
                $data,
                $hora,
                $tipo_entrevista,
                $vaga[0] -> vc_vaga,
                $link
            );
        }


        $this->load->library('email');

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
        //$this -> email -> to($candidato -> vc_email);
        $email = $candidato -> vc_email;

        $this -> email -> to($email);
        $this -> email -> subject('['.$this -> config -> item('nome').$titulo[$modelo]);

        $this -> email -> message($msg[$modelo]);
        //echo $msg[$modelo];
        if (!$this -> email -> send()) {
            if ($modelo == 'agendamento_entrevista') {
                $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de entrevista do '.$candidato->vc_nome);
            } elseif ($modelo == 'reagendamento_candidato') {
                $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$candidato -> vc_email.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
            }
        } else {
            if ($modelo == 'agendamento_entrevista') {
                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de entrevista do '.$candidato->vc_nome.' pelo usuário '. $this -> session -> uid.' feita com sucesso.');
            } elseif ($modelo == 'reagendamento_candidato') {
                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$candidato -> vc_email.' pelo usuário '. $this -> session -> uid.' feita com sucesso.', 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
            }
        }
    }


    private function envio_email2($nome, $email, $nome_candidato, $candidatura, $data, $hora, $link, $tipo_email, $tipo_entrevista, $vaga)
    {
        $this->load->library('email');

        $this->load->helper('emails');
        $config = getEmailEnvConfigs();

        $this->email->initialize($config);

        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
        $this -> email -> to($email);
        //$tipo_email = 'agendamento_entrevista';
        if ($tipo_email == 'agendamento_entrevista') {
            $titulo = '] Entrevista Marcada';
            $msg = loadAgendamentoDeEntrevistaEntrevistadorHtml(
                $this->config->item('nome'),
                $this->config->item('subTituloPlataforma'),
                $nome,
                $nome_candidato,
                $data,
                $hora,
                $tipo_entrevista,
                $vaga[0] -> vc_vaga,
                $link
            );
        } elseif ($tipo_email == 'reagendamento') {
            $titulo = '] Alteração de data/horário de entrevista';
            $msg = loadReagendamentoDeEntrevistaEntrevistadorHtml(
                $this->config->item('nome'),
                $this->config->item('subTituloPlataforma'),
                $nome,
                $nome_candidato,
                $data,
                $hora,
                $tipo_entrevista,
                $vaga[0] -> vc_vaga,
                $link
            );
        } elseif ($tipo_email == 'reagendamento_cancelamento') {
            $titulo = '] Alteração de entrevista';
            $msg = loadParticipacaoEmEntrevistaCanceladaHtml(
                $this->config->item('nome'),
                $this->config->item('subTituloPlataforma'),
                $nome,
                $nome_candidato,
                $data,
                $hora,
                $tipo_entrevista,
                $vaga[0] -> vc_vaga,
                $link
            );
        }


        $this -> email -> subject('['.$this -> config -> item('nome').$titulo);


        $this -> email -> message($msg);
        //echo $msg;
        if (!$this -> email -> send()) {
            $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$email.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
        }
    }
}
