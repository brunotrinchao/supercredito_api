<?

namespace App\Lib;

class Helper
{
    public static function validaEmail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; 
        }
        return true;
    }

    public static function validaCPF($cpf)
    {

        // Verifiva se o número digitado contém todos os digitos
        $cpf = preg_replace('/[^0-9]/i', '', $cpf);

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return false;
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public static function formatarCPFCNPJ($campo, $formatado = true)
    {
        $codigoLimpo = ereg_replace("[' '-./ t]", '', $campo);
        $tamanho = (strlen($codigoLimpo) - 2);
        if ($tamanho != 9 && $tamanho != 12) {
            return false;
        }
        if ($formatado) {
            $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
            $indice = -1;
            for ($i = 0; $i < strlen($mascara); $i++) {
                if ($mascara[$i] == '#') {
                    $mascara[$i] = $codigoLimpo[++$indice];
                }
            }
            $retorno = $mascara;
        } else {
            $retorno = $codigoLimpo;
        }
        return $retorno;
    }

    public static function formatarTelefone($telefone = '')
    {
        $pattern = '/(\d{2})(\d{4})(\d*)/';
        $telefoneN = preg_replace($pattern, '($1) $2-$3', $telefone);

        return $telefoneN;
    }

    /**
     * Retirar os caracteres do telefone que não sejam numeros
     *
     * @param string $text
     * @return string
     */
    public static function desformatarTelefone($text) {
        return preg_replace('/[^0-9]/', '', $text);
    }

    public static function formatarCEP($campo, $formatado = true)
    {
        $codigoLimpo = preg_replace('/[^0-9]/', '', $campo);
        $tamanho = (strlen($codigoLimpo));
        if ($tamanho != 8) {
            return null;
        }
        if ($formatado) {
            $mascara = '#####-###';
            $indice = -1;
            for ($i = 0; $i < strlen($mascara); $i++) {
                if ($mascara[$i] == '#') {
                    $mascara[$i] = $codigoLimpo[++$indice];
                }
            }
            $retorno = $mascara;
        } else {
            $retorno = $codigoLimpo;
        }
        return $retorno;
    }

    public static function getTimezone($timezone = '')
    {
        $arrTz = Helpers::arrayTimezone();

        if (!empty($timezone)) {
            $timezone = 'America/Bahia';
            $offset = '-03:00';
        }

        $offset = $arrTz[$timezone]['offset'];

        $arrRetorno = array('tz' => $timezone, 'offset' => $offset);
        return $arrRetorno;
    }

    public static function arrayTimezone()
    {
        $arrTimezone['America/Araguaina'] = array('cc' => 'BR', 'name' => 'Tocantins', 'offset' => '-03:00', 'dst' => '-03:00');
        $arrTimezone['America/Bahia'] = array('cc' => 'BR', 'name' => 'Bahia', 'offset' => '-03:00', 'dst' => '-02:00');
        $arrTimezone['America/Belem'] = array('cc' => 'BR', 'name' => 'Amapá e Pará', 'offset' => '-03:00', 'dst' => '-03:00');
        $arrTimezone['America/Boa_Vista'] = array('cc' => 'BR', 'name' => 'Roraima', 'offset' => '-04:00', 'dst' => '-04:00');
        $arrTimezone['America/Campo_Grande'] = array('cc' => 'BR', 'name' => 'Mato Grosso do Sul', 'offset' => '-04:00', 'dst' => '-03:00');
        $arrTimezone['America/Cuiaba'] = array('cc' => 'BR', 'name' => 'Mato Grosso', 'offset' => '-04:00', 'dst' => '-03:00');
        $arrTimezone['America/Eirunepe'] = array('cc' => 'BR', 'name' => 'Amazonas', 'offset' => '-05:00', 'dst' => '-05:00');
        $arrTimezone['America/Fortaleza'] = array('cc' => 'BR', 'name' => 'Nordeste (MA, PI, CE, RN, PB)', 'offset' => '-03:00', 'dst' => '-03:00');
        $arrTimezone['America/Maceio'] = array('cc' => 'BR', 'name' => 'Alagoas, Sergipe', 'offset' => '-03:00', 'dst' => '-03:00');
        $arrTimezone['America/Manaus'] = array('cc' => 'BR', 'name' => 'Manaus', 'offset' => '-04:00', 'dst' => '-04:00');
        $arrTimezone['America/Noronha'] = array('cc' => 'BR', 'name' => 'Fernando de Noronha', 'offset' => '-02:00', 'dst' => '-02:00');
        $arrTimezone['America/Porto_Velho'] = array('cc' => 'BR', 'name' => 'Rondonia', 'offset' => '-04:00', 'dst' => '-04:00');
        $arrTimezone['America/Recife'] = array('cc' => 'BR', 'name' => 'Pernambuco', 'offset' => '-03:00', 'dst' => '-03:00');
        $arrTimezone['America/Rio_Branco'] = array('cc' => 'BR', 'name' => 'Acre', 'offset' => '-05:00', 'dst' => '-05:00');
        $arrTimezone['America/Santarem'] = array('cc' => 'BR', 'name' => 'W Para', 'offset' => '-03:00', 'dst' => '-05:00');
        $arrTimezone['America/Sao_Paulo'] = array('cc' => 'BR', 'name' => 'Sul e Sudeste (GO, DF, MG, ES, RJ, SP, PR, SC, RS)', 'offset' => '-03:00', 'dst' => '-02:00');
        $arrTimezone['Europe/Lisbon'] = array('cc' => 'PT', 'name' => 'Lisboa/Portugal', 'offset' => '+00:00', 'dst' => '+01:00');

        return $arrTimezone;
    }

    public static function primeiroUltimoNome($texto)
    {
        $arrTexto = explode(' ', $texto);
        $primeiro = $arrTexto[0];
        $ultimo = (count($arrTexto) > 1) ? $arrTexto[count($arrTexto)-1] : '';
        $retorno = trim($primeiro . ' ' . $ultimo);
        return $retorno;
    }

    public static function isEmptyParam($paramvalue)
    {
        return ($paramvalue == 'null' || $paramvalue == 'NULL' || $paramvalue == 'undefined' || empty($paramvalue));
    }
    /**
     * Formatar um número com 2 casas decimais após a virgula e ponto para diferenciar os milhares
     *
     * @param dec $numero
     * @param bool $color
     * @param bool $cash defaul: true inclui ou não o caractere de moeda
     * @param bool $signal default: true inclui ou não sinal para numeros negativos
     * @return type
     */
    public static function numberFormat($number, $color = false, $cash = true, $signal = true, $decimals = 2, $zeroDash = false)
    {
        $moeda = ($cash) ? 'R$ ' : '';
        $number = (!$signal) ? abs($number) : $number;
        $decimals = ($decimals === false) ? 2 : $decimals;

        if ($zeroDash && $number == 0) {
            return '-';
        } else {
            if ($color) {
                $cor = ($number >= 0) ? '' : '#E95D3C';
                $number = number_format($number, $decimals, ',', '.');
                return '<font color="' . $cor . '">' . $moeda . $number . '</font>';
            } else {
                return $moeda . number_format($number, $decimals, ',', '.');
            }
        }
    }

    /**
     * Formatar um número com 2 casas decimais após a virgula e ponto para diferenciar os milhares
     *
     * @param type $numero
     * @return type
     */
    public static function numberUnformat($number)
    {
        $ret = null;
        if (!empty($number)) {
            $ret = str_replace(',', '.', str_replace('.', '', $number));
            $ret = str_replace('R$ ', '', $ret);
            $ret = str_replace('% ', '', $ret);
        }
        return $ret;
    }

    /**
     * Retirar uma mascara utilizada pelo plugin jQuery.mask
     * Remove ".", "-" e "/"
     *
     * @param string $text
     * @return string
     */
    public static function removeMask($text)
    {
        return str_replace(array(".", "-", "/"), "", $text);
    }
}