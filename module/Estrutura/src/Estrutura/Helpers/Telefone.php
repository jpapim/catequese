<?php
namespace Estrutura\Helpers;
/**
 *
 * @author ronaldo
 *
 */
class Telefone
{
    /**
     *
     * @param string $telefone
     * @return string $telefone
     * Ex:
     * $tel = (61) 9161-3193
     * $tel = Modulo_Helpers_Telefone::telefoneFilter($tel); // retorna 6191613193
     */
    public static function telefoneFilter($telefone)
    {
        return preg_replace('#[() -]#', '', $telefone);
    }
    /**
     *
     * @param int $telefone
     * @return string $telefone
     * Ex:
     * $tel = 6191613193
     * $tel = Modulo_Helpers_Telefone::telefoneMask($tel); // retorna (61) 9161-3193
     */
    public static function telefoneMask($telefone)
    {
        if ($telefone) {
            switch (strlen($telefone)) {
                //55554444
                case 8:
                    return substr($telefone, 0, 4) . '-' . substr($telefone, 4, 4);
                //555544444
                case 9:
                    return substr($telefone, 0, 4) . '-' . substr($telefone, 4, 5);
                //6155554444
                case 10:
                    return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
                //61555544444
                case 11:
                    return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 5);
                default:
                    return $telefone;
            }
        } else {
            return NULL;
        }
    }

    public static function celularMask($telefone)
    {
        if ($telefone) {
            switch (strlen($telefone)) {
                //955554444
                case 8:
                    return substr($telefone, 0, 1) . ' ' . substr($telefone, 1, 4) . '-' . substr($telefone, 5, 4);
                //9555544444
                case 9:
                    return substr($telefone, 0, 1) . ' ' . substr($telefone, 1, 4) . '-' . substr($telefone, 5, 5);
                //61955554444
                case 10:
                    return '(' . substr($telefone, 0, 2) . ') ' .substr($telefone, 0, 1) . ' ' . substr($telefone, 2,1, 4) . '-' . substr($telefone, 7, 4);
                //619555544444
                case 11:
                    return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 0, 1) . ' ' . substr($telefone, 2,1, 4) . '-' . substr($telefone, 7, 5);
                default:
                    return $telefone;
            }
        } else {
            return NULL;
        }
    }
    public static function getDDD($telefoneComMascara)
    {
        $telefone = trim($telefoneComMascara);
        if (!strpos($telefone, ')') === false) {
            return substr($telefone, 1, 2);
        }
        return NULL;
    }
    public static function getTelefone($telefoneComMascara)
    {
        $telefone = trim($telefoneComMascara);
        if (!strpos($telefone, ')') === false) {
            if (!strpos($telefone, '-') === false) {
                return str_replace('-', '', substr($telefone, 5, strlen($telefone)));
            } else {
                return substr($telefone, 4, 8);
            }
        } else {
            if (!strpos($telefone, '-') === false) {
                return str_replace('-', '', $telefone);
            } else {
                return $telefone;
            }
        }
    }

    public static function getCelular($celularComMascara)
    {
        $celular = trim($celularComMascara);
        if (!strpos($celular, ')') === false) {
            if (!strpos($celular, '-') === false) {
                return str_replace('-', '', substr($celular, 5, strlen($celular)));
            } else {
                return substr($celular, 5, 8);
            }
        } else {
            if (!strpos($celular, '-') === false) {
                return str_replace('-', '', $celular);
            } else {
                return $celular;
            }
        }
    }
}