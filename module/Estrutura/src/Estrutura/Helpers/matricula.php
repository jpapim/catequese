<?php
namespace Estrutura\Helpers;
/**
 *
 * @author ronaldo
 *
 */
class matricula {


	/**
	 *
	 * @param string $cep
	 * @return string $cep
	 * Ex:
	 * $cep = 71.123-124
	 * $cep = Modulo_Helpers_Cep::cepFilter($cep); // retorna 71123124
	 */
	public static function matriculaFilter( $matricula ){

		return preg_replace('#[. -]#', '', $matricula);
	}


	/**
	 *
	 * @param int $cep
	 * @return string $cep
	 * Ex:
	 * $cep = 71123124
	 * $cep = Modulo_Helpers_Cep::cepMask($cep); // retorna 71.123-124
	 */
	public static function matriculaMask( $matricula ){

		if ($cep){

			return Utilities::mascaraformato('######', trim($matricula));
		}else{

			return null;
		}
	}
}