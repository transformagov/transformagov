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
                                                        <div class=\"card-block\">
                                                            <div class=\"row sub-title navbar-fixed\" style=\"letter-spacing:0px\">
                                                                <div class=\"col-xl-8 col-lg-6\">
                                                                    <h4><i class=\"$icone\"></i> &nbsp; {$nome_pagina}</h4>
                                                                </div>
                                                            </div>
                                                            <div class=\"row\">
                                                                <div class=\"col-md-12\">
                                                                    <div id='calendar'></div>
                                                                    <p>
                                                                        <br/><span class=\"bolder\">Legenda:</span><br/>
                                                                        Dia final dos prazos: <span class=\"alert-danger\">vermelho</span><br/>
                                                                        Feriado nacional: <span class=\"alert-success\">verde</span><br/>
                                                                        Feriado municipal: <span class=\"alert-warning\">amarelo</span><br/>
                                                                        Ponto facultativo: <span class=\"alert-info\">azul</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
//var_dump($pht);
$pagina['js'] = "
        
        <script type=\"text/javascript\">
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    locale: 'pt-br',
                    header: {
                        left: '',
                        center: 'title'
                    },
                    events: [";

//feriados
foreach ($feriados as $linha){
        if($linha -> en_tipo =='nacional' && $pht[0] -> bl_feriados=='1'){
                $data=explode('-', $linha -> dt_feriado );
                //$data[1]--;
                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#93BE52',
                            textColor: '#fff'
                        }, ";
                if($linha -> bl_repeticaoanual =='1'){
                        $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#93BE52',
                            textColor: '#fff'
                        }, ";
                        for($i=1;$i<=3;$i++){
                                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '".($data[0]+$i)."-{$data[1]}-{$data[2]}',
                            backgroundColor: '#93BE52',
                            textColor: '#fff'
                        }, ";
                        }
                }
        }
        else if($linha -> en_tipo =='municipal' && $pht[0] -> bl_feriados=='1' && $linha -> es_municipio_cep ==$this -> session -> municipio){
                $data=explode('-', $linha -> dt_feriado );
                $data[1]--;
                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#FFB64D',
                            textColor: '#fff'
                        }, ";
                if($linha -> bl_repeticaoanual =='1'){
                        $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#FFB64D',
                            textColor: '#fff'
                        }, ";
                        for($i=1;$i<=3;$i++){
                                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '".($data[0]+$i)."-{$data[1]}-{$data[2]}',
                            backgroundColor: '#FFB64D',
                            textColor: '#fff'
                        }, ";
                        }
                }
        }
        else if($linha -> en_tipo == 'facultativo' && $pht[0] -> bl_pfacultativo=='1'){
                $data=explode('-', $linha -> dt_feriado );
                $data[1]--;
                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$data[0]}-{$data[1]}-{$data[2]}',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, ";
                if($linha -> bl_repeticaoanual =='1'){
                        $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, ";
                        for($i=1;$i<=3;$i++){
                                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '".($data[0]+$i)."-{$data[1]}-{$data[2]}',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, ";
                        }
                }
        }
        else if($linha -> en_tipo =='facultativomunicipal' && $pht[0] -> bl_pfacultativo=='1' && $linha -> es_municipio_cep == $this -> session -> municipio){
                $data=explode('-', $linha -> dt_feriado );
                $data[1]--;
                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, ";
                if($linha -> bl_repeticaoanual =='1'){
                        $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, ";
                        for($i=1;$i<=3;$i++){
                                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '".($data[0]+$i)."-{$data[1]}-{$data[2]}',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, ";
                        }
                }
        }
        else if($linha -> en_tipo =='rodizio'){
                $data=explode('-', $linha -> dt_feriado );
                $data[1]--;
                $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_feriado}',
                            backgroundColor: '#FFB64D',
                            textColor: '#fff'
                        }, ";
        }
}

//ausencias
foreach ($ausencias as $linha){
        if(strlen($linha -> dt_fim_alterado)>0){
                $fim = $linha -> dt_fim_alterado;
        }
        else{
                $fim = $linha -> dt_fim;
        }
        $pagina['js'] .= "
                        {
                            title: '{$linha -> vc_descricao }',
                            start: '{$linha -> dt_inicio}',
                            end: '{$fim}',
                            backgroundColor: '#FFB64D',
                            textColor: '#fff'
                        }, ";
}

//prazos de fechamento
for($i=-3;$i<=3;$i++){
        if($this -> session -> diafechamento == 31){ //padrão de fechamento no fim do mês
                $fechamento1=dias_uteis(date('d/m/Y', mktime(0, 0, 0, date('m')+$i, 1, date('Y'))), '', $prazo1, false, $this -> session -> municipio);
                //echo "$fechamento1=dias_uteis(".date('d/m/Y', mktime(0, 0, 0, date('m')+$i, 1, date('Y'))).", '', $prazo1, false, {$this -> session -> municipio});<br>";
                $fechamento1+=2;
                //echo "fechamento1: $fechamento1<br>";
                $fechamento2=dias_uteis(date('d/m/Y', mktime(0, 0, 0, date('m')+$i, 1, date('Y'))), '', $prazo2, false, $this -> session -> municipio);
                $fechamento2++;
                $fechamento3=dias_uteis(date('d/m/Y', mktime(0, 0, 0, date('m')+$i, 1, date('Y'))), '', $prazo3, false, $this -> session -> municipio);
                $fechamento3++;
        }
        else{
                if($this -> session -> situacaofuncional == 444 && $this -> session -> instituicao == 2011){ //estagiários do IPSEMG
                        $prazo1=1;
                        $prazo2=2;
                        $prazo3=3;
                }
                else if($this -> session -> situacaofuncional == 444 && $this -> session -> instituicao == 1271){ //estagiários da SEC
                        $prazo1=2;
                        $prazo2=3;
                        $prazo3=4;
                }
                $fechamento1 = $this -> session -> diafechamento + dias_uteis(date('d/m/Y', mktime(0, 0, 0, date('m')+$i, $this -> session -> diafechamento+1, date('Y'))), '', $prazo1, false, $this -> session -> municipio);
                $fechamento1++;
                $fechamento2 = $this -> session -> diafechamento + dias_uteis(date('d/m/Y', mktime(0, 0, 0, date('m')+$i, $this -> session -> diafechamento+1, date('Y'))), '', $prazo2, false, $this -> session -> municipio);
                $fechamento2++;
                $fechamento3 = $this -> session -> diafechamento + dias_uteis(date('d/m/Y', mktime(0, 0, 0, date('m')+$i, $this -> session -> diafechamento+1, date('Y'))), '', $prazo3, false, $this -> session -> municipio);
                $fechamento3++;
        }
        //echo "title: 'Fechamento do servidor $fechamento1', start: '".date('Y-m-d', mktime(0, 0, 0, date('m')-1+$i, $fechamento1, date('Y')))."',<br>";
        $pagina['js'] .= " 
                        {
                            title: 'Fechamento do servidor',
                            start: '".date('Y-m-d', mktime(0, 0, 0, date('m')-1+$i, $fechamento1, date('Y')))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, 
                        {
                            title: 'Assinatura da chefia',
                            start: '".date('Y-m-d', mktime(0, 0, 0, date('m')-1+$i, $fechamento2, date('Y')))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, 
                        {
                            title: 'Assinatura do servidor',
                            start: '".date('Y-m-d', mktime(0, 0, 0, date('m')-1+$i, $fechamento3, date('Y')))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, 
                        {
                            title: 'Fecham. à revelia',
                            start: '".date('Y-m-d', mktime(0, 0, 0, date('m')-1+$i, $fechamento3, date('Y')))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";
}
$pagina['js'] .= " 
                        {
                            title: 'Marcação de férias 2020',
                            start: '2019-10-14',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, 
                        {
                            title: 'Aprovação de marcação de férias 2020',
                            start: '2019-10-30',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";

//fechamentos de folha
foreach($fechamentos as $linha){
        $data=explode('-', $linha -> dt_fechamento);
        $data[1]=(int)$data[1];
        $pagina['js'] .= " 
                        {
                            title: 'Prazo para remarc. férias',
                            start: '".date('Y-m-d', mktime(0, 0, 0, $data[1], ($data[2]-6), $data[0]))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";
        if($this -> session -> administrador){
                $pagina['js'] .= " 
                        {
                            title: 'Fechamento da taxação',
                            start: '".date('Y-m-d', mktime(0, 0, 0, $data[1], $data[2], $data[0]))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";
                            $diasuteis=dias_uteis("01/{$data[1]}/{$data[0]}", "{$data[2]}/{$data[1]}/{$data[0]}");
                            $diasuteis++;
                            $data[2]= dias_uteis("01/{$data[1]}/{$data[0]}", '', $diasuteis);
                            $pagina['js'] .= "
                        {
                            title: 'Acerto de atrasadas',
                            start: '".date('Y-m-d', mktime(0, 0, 0, $data[1], $data[2], $data[0]))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";
                            $data[2]= 15+dias_uteis("15/{$data[1]}/{$data[0]}", '', 2);
                            $pagina['js'] .= "
                        {
                            title: 'Revelia estag. IPSEMG',
                            start: '".date('Y-m-d', mktime(0, 0, 0, $data[1], $data[2], $data[0]))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";
                            $data[2]= 20+dias_uteis("20/{$data[1]}/{$data[0]}", '', 8);
                            $pagina['js'] .= "
                        {
                            title: 'Revelia estag. ESP',
                            start: '".date('Y-m-d', mktime(0, 0, 0, $data[1], $data[2], $data[0]))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";
                            /*
                            $data[2]= 31+dias_uteis("20/{$data[1]}/{$data[0]}", '', 8);
                            $pagina['js'] .= "
                        {
                            title: 'Revelia estag. SEC',
                            start: '".date('Y-m-d', mktime(0, 0, 0, $data[1], $data[2], $data[0]))."',
                            backgroundColor: '#FC6180',
                            textColor: '#fff'
                        }, ";*/
        }
}

//substituições de PHT
foreach($substituicoes as $linha){
        $pagina['js'] .= " 
                        {
                            title: '{$linha -> vc_planotrabalho}',
                            start: '{$linha -> dt_data}',
                            backgroundColor: '#000',
                            textColor: '#fff'
                        }, ";
}
/*
$pagina['js'] .= "
                        {
                            title: 'Business Lunch',
                            start: '2019-09-03T13:00:00',
                            constraint: 'businessHours',
                                borderColor: '#FC6180',
                                backgroundColor: '#FC6180',
                                textColor: '#fff'
                        }, {
                            title: 'Meeting',
                            start: '2019-09-13T11:00:00',
                            constraint: 'availableForMeeting',
                            editable: true,
                            borderColor: '#4680ff',
                            backgroundColor: '#4680ff',
                            textColor: '#fff'
                        }, {
                            title: 'Conference',
                            start: '2019-09-18',
                            end: '2019-09-20',
                                            borderColor: '#93BE52',
                                            backgroundColor: '#93BE52',
                                            textColor: '#fff'
                        }, {
                            title: 'Party',
                            start: '2019-09-29',
                                            borderColor: '#FFB64D',
                                            backgroundColor: '#FFB64D',
                                            textColor: '#fff'
                        },

                        // areas where \"Meeting\" must be dropped
                        {
                            id: 'availableForMeeting',
                            start: '2019-09-11T10:00:00',
                            end: '2019-09-11T16:00:00',
                            rendering: 'background',
                                            borderColor: '#ab7967',
                                            backgroundColor: '#ab7967',
                                            textColor: '#fff'
                        }, {
                            id: 'availableForMeeting',
                            start: '2019-09-13T10:00:00',
                            end: '2019-09-13T16:00:00',
                            rendering: 'background',
                                            borderColor: '#39ADB5',
                                            backgroundColor: '#39ADB5',
                                            textColor: '#fff'
                        },

                        // red areas where no events can be dropped
                        {
                            start: '2019-09-24',
                            end: '2019-09-28',
                            overlap: false,
                            rendering: 'background',
                                            borderColor: '#FFB64D',
                                            backgroundColor: '#FFB64D',
                            color: '#d8d6d6'
                        }, {
                            start: '2019-09-06',
                            end: '2019-09-08',
                            overlap: false,
                            rendering: 'background',
                                            borderColor: '#ab7967',
                                            backgroundColor: '#ab7967',
                            color: '#d8d6d6'
                        }";
*/
$pagina['js'] .= "
                    ]
                });
            });
        </script>";

$this->load->view('templates/internaRodape', $pagina);

?>