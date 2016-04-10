<?php

namespace Estrutura\Helpers;

/**
 *
 * @author ronaldo
 *
 */
class Cript {

    /**
     * @var int
     */
    public static $chave = 97;

    /**
     * @var string
     */
    public static $add_text = "projeto";

    /**
     * @param string $word
     * @return string
     */
    public static function enc($word)
    {
        $word .= md5(sha1(Cript::$add_text));
        $s = strlen($word) + 1;
        $nw = "";
        $n = Cript::$chave;
        for ($x = 1; $x < $s; $x++) {
            $m = $x * $n;
            if ($m > $s) {
                $nindex = $m % $s;
            } else if ($m < $s) {
                $nindex = $m;
            }
            if ($m % $s == 0) {
                $nindex = $x;
            }
            $nw = $nw . $word[$nindex - 1];
        }
        return $nw;
    }

    /**
     * @param string $word
     * @return string
     */
    public static function dec($word)
    {

        $word = trim($word);
        $s = strlen($word) + 1;
        $nw = "";
        $n = Cript::$chave;
        for ($y = 1; $y < $s; $y++) {
            $m = $y * $n;
            if ($m % $s == 1) {
                $n = $y;
                break;
            }
        }
        for ($x = 1; $x < $s; $x++) {
            $m = $x * $n;
            if ($m > $s) {
                $nindex = $m % $s;
            } else if ($m < $s) {
                $nindex = $m;
            }
            if ($m % $s == 0) {
                $nindex = $x;
            }
            $nw = $nw . $word[$nindex - 1];
        }
        $t = strlen($nw) - strlen(md5(sha1(Cript::$add_text)));
        return substr($nw, 0, $t);
    }

    /**
     * encripitar o texto
     * @param string $texto
     * @return 	string $textocript
     */
    public static function encCod($texto)
    {
        $senha = Cript::$chave;
        $textocrypt = '';
        for ($i = 1; $i <= strlen($texto); $i = $i + 1) {
            $caractersenha = ord(substr($senha, $i - 1, 1));
            $caractertexto = ord(substr($texto, $i - 1, 1));
            $caracter = $caractertexto + $caractersenha;
            $textocrypt = $textocrypt . chr($caracter);
        }
        return $textocrypt;
    }

    /**
     * decripitar o texto
     * @param	string $textocrypt
     * @return 	string $textodript
     */
    public static function decCod($textocrypt)
    {
        $senha = Cript::$chave;
        $textodecrypt = '';
        for ($i = 1; $i <= strlen($textocrypt); $i = $i + 1) {
            $caractersenha = (ord(substr($senha, $i - 1, 1)));
            $caractertexto = ord(substr($textocrypt, $i - 1, 1));
            $caracter = $caractertexto - $caractersenha;
            $textodecrypt = $textodecrypt . chr($caracter);
        }
        return $textodecrypt;
    }

}
