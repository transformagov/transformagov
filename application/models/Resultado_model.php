<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Resultado_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public static function finaliza_vaga($menu2, $vagas, $perfil)
    {
        return $menu2 == 'resultado' && $vagas[0] -> bl_finalizado != '1' && $perfil != 'avaliador';
    }

    public static function verifica_resultado_do_candidato($menu2, $vagas, $candidaturas, $perfil) 
    {
            $reprovado = false;
            $agendado = false;
            $finalizado = false;
            $aprovado = false;
            if (isset($candidaturas)) {
                foreach ($candidaturas as $linha) {
                    if ($linha -> es_status == 8) {
                        $reprovado = true;
                    }
                    $validacao_reprovado = ($linha ->es_status == 10 || $linha ->es_status == 11 || $linha ->es_status == 12 || $linha ->es_status == 14 || $linha ->es_status == 16);
                    if ($reprovado && $validacao_reprovado) {
                        $agendado = true;
                        $finalizado = true;
                    } elseif ($validacao_reprovado) {
                        $finalizado = true;
                    }
                }
                foreach ($candidaturas as $linha) {
                    if ($finalizado && $linha ->es_status == 19) {
                        $aprovado = true;
                    }
                    if ($aprovado) {
                        break;
                    }
                }
            }
            return array($reprovado, $agendado, $finalizado, $aprovado);
        }
}
