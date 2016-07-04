<?php
namespace Estrutura\Helpers;

use Estrutura\Helpers\Arquivo;

/**
 *
 * @author Alysson Vicuña
 *
 */
class Cache
{

    /**
     * Limpa as pastas de Cache do Sistema
     * @return bool
     */
    public static function limparCacheDoSistema()
    {
        try {
            $arExcecoes = array();
            $arExcecoes[] = 'leia-me.txt';
            $arExcecoes[] = 'classes.php.cache';
            \Estrutura\Helpers\Arquivo::deletarArquivosNoDiretorioComExcecao('data\cache', $arExcecoes);
            \Estrutura\Helpers\Arquivo::deletarArquivosNoDiretorioComExcecao('public\assets\cache', $arExcecoes);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
}
