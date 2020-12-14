<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once '/../../system/libraries/Form_validation.php';
class MY_Form_Validation extends CI_Form_Validation {
	public function __construct()
	{
		parent::__construct();
	}
        function verificaCPF($cpf) {
                //$CI =& get_instance();

                $cpf= str_replace('.', '', $cpf);
                $cpf= str_replace('_', '', $cpf);
                if(strlen($cpf)==11){
                        $cpf= substr($cpf, 0, 9).'-'.substr($cpf, 9);
                }
                if (strlen($cpf) <> 12){
                        return 0;
                }
                $soma1 = ($cpf[0] * 10) +
                                        ($cpf[1] * 9) +
                                        ($cpf[2] * 8) +
                                        ($cpf[3] * 7) +
                                        ($cpf[4] * 6) +
                                        ($cpf[5] * 5) +
                                        ($cpf[6] * 4) +
                                        ($cpf[7] * 3) +
                                        ($cpf[8] * 2);
                $resto = $soma1 % 11;
                $digito1 = $resto < 2 ? 0 : 11 - $resto;

                $soma2 = ($cpf[0] * 11) +
                                        ($cpf[1]  * 10) +
                                        ($cpf[2]  * 9) +
                                        ($cpf[3]  * 8) +
                                        ($cpf[4]  * 7) +
                                        ($cpf[5]  * 6) +
                                        ($cpf[6]  * 5) +
                                        ($cpf[7]  * 4) +
                                        ($cpf[8]  * 3) +
                                        ($cpf[10] * 2);
                $resto = $soma2 % 11;
                $digito2 = $resto < 2 ? 0 : 11 - $resto;

                return (($cpf[10] == $digito1) && ($cpf[11] == $digito2));
        }
        function verificaCGC($cgc) {
                //$CI =& get_instance();

                if (strlen($cgc) <> 18) return 0;
                $soma1 = ($cgc[0] * 5) +
                                        ($cgc[1] * 4) +
                                        ($cgc[3] * 3) +
                                        ($cgc[4] * 2) +
                                        ($cgc[5] * 9) +
                                        ($cgc[7] * 8) +
                                        ($cgc[8] * 7) +
                                        ($cgc[9] * 6) +
                                        ($cgc[11] * 5) +
                                        ($cgc[12] * 4) +
                                        ($cgc[13] * 3) +
                                        ($cgc[14] * 2);
                $resto = $soma1 % 11;
                $digito1 = $resto < 2 ? 0 : 11 - $resto;

                $soma2 = ($cgc[0] * 6) +
                                        ($cgc[1] * 5) +
                                        ($cgc[3] * 4) +
                                        ($cgc[4] * 3) +
                                        ($cgc[5] * 2) +
                                        ($cgc[7] * 9) +
                                        ($cgc[8] * 8) +
                                        ($cgc[9] * 7) +
                                        ($cgc[11] * 6) +
                                        ($cgc[12] * 5) +
                                        ($cgc[13] * 4) +
                                        ($cgc[14] * 3) +
                                        ($cgc[16] * 2);
                $resto = $soma2 % 11;
                $digito2 = $resto < 2 ? 0 : 11 - $resto;

                return (($cgc[16] == $digito1) && ($cgc[17] == $digito2));
        }
        function maior_que_zero($valor){ //callback de validação customizada do formulário de cadsatro
                //$CI =& get_instance();

                return ($valor > 0);
        }
        function minus_maius($texto){ //callback de validação customizada do formulário de cadsatro
                //$CI =& get_instance();

                if(strlen($texto) > 0){
                        if(strtoupper($texto) == $texto){
                                //echo '2';
                                //$CI -> form_validation -> set_message('minus_maius', utf8_encode('Não insira seu nome utilizando somente caracteres maiúsculos.'));
                                return false;
                        }
                        if(strtolower($texto) == $texto){
                                //echo '3';
                                //$CI -> form_validation -> set_message('minus_maius', utf8_encode('Não insira seu nome utilizando somente caracteres minúsculos.'));
                                return false;
                        }
                }
                return true;
        }
        function valida_data($date){ //callback de validação customizada do formulário de cadsatro
                //$CI =& get_instance();

                if(strstr($date, '/')){
                        $data=explode('/', $date);
                        $day = (int) $data[0];
                        $month = (int) $data[1];
                        $year = (int) $data[2];
                }
                else if(strstr($date, '-')){
                        $data=explode('-', $date);
                        $day = (int) $data[2];
                        $month = (int) $data[1];
                        $year = (int) $data[0];
                }
                else{
                        $day = (int) substr($date, 0, 2);
                        $month = (int) substr($date, 3, 2);
                        $year = (int) substr($date, 6, 4);
                }
                if($year<1900){
                        return false;
                }
                return checkdate($month, $day, $year);
        }
}
?>