<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 03/11/2016
 * Time: 23:41
 */

class Nota {


    public static function notaFilter( $nota ){

        return preg_replace('#[.]#', '', $nota);
    }


    /**
     *
     * @param int $cep
     * @return string $cep
     * Ex:
     * $cep = 71123124
     * $cep = Modulo_Helpers_Cep::cepMask($cep); // retorna 71.123-124
     */
    public static function notaMask( $nota ){

        if ($nota){

            return Utilities::mascaraformato('##.##', trim($nota));
        }else{

            return null;
        }
    }
}