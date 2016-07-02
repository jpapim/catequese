<?php
namespace Estrutura\Helpers;
/**
 *
 * @author ronaldo
 *
 */
class Arquivo
{

    /**
     * Converte array multidimencional $_FILE por atributos (tmp_name, size...)
     * em um array multidimencional por arquivo
     * @param unknown_type $files
     * @return array
     */
    public static function converterMultiplosArquivos($files)
    {
        $ret = array();
        if (isset($files['tmp_name']) &&
            is_array($files['tmp_name'])
        ) {
            foreach ($files['name'] as $idx => $name) {
                $ret[$idx] = array('name' => $name,
                    'tmp_name' => $files['tmp_name'][$idx],
                    'size' => $files['size'][$idx],
                    'type' => $files['type'][$idx],
                    'error' => $files['error'][$idx]);
            }
        } else {
            $ret = $files;
        }
        return $ret;
    }

    /**
     * Pega o tamanho do arquivo no servidor
     * @param string $caminhoArquivo
     * @return string
     */
    public static function tamanhoArquivo($caminhoArquivo)
    {
        if (file($caminhoArquivo)) {
            $nSize = filesize($caminhoArquivo);
            if ($nSize < 1024) {
                return strval($nSize) . ' bytes';
            }
            if ($nSize < pow(1024, 2)) {
                return ((int)($nSize / 1024)) . ' KB';
            }
            if ($nSize < pow(1024, 3)) {
                return ((int)($nSize / pow(1024, 2))) . ' MB';
            }
            if ($nSize < pow(1024, 4)) {
                return ((int)($nSize / pow(1024, 3))) . ' GB';
            }
            return '';
        }
    }

    /**
     *
     * @param string $nomeArquivo => nome do arquivo
     * @return string extencao
     */
    public static function extensaoArquivo($nomeArquivo)
    {
        $nomeArray = explode(".", $nomeArquivo);
        return strtolower(end($nomeArray));
    }

    /**
     * Método utilizado para apagar um diretório e todos os arquivos dentro dele.
     * @param type $directory
     * @return type
     */
    public static function delTree($directory)
    {
        $files = array_diff(scandir($directory), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$directory/$file")) ? self::delTree("$directory/$file") : unlink("$directory/$file");
        }
        return rmdir($directory);
    }

    /**
     * @author Alysson Vicuña
     * Método que apaga todos os arquivos dentro do diretório passada por parametro.
     * @param type $directory
     * @return type
     */
    public static function deletarTodosArquivosNoDiretorio($directory)
    {
        $files = array_diff(scandir($directory), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$directory/$file")) ? self::delTree("$directory/$file") : unlink("$directory/$file");
        }
        return $directory;
    }

    /**
     * @author Alysson Vicuña
     * Método apaga todos os arquivos dentro de um diretório informado, exceto os arquivos que estão com o nome contido no array  $excecao
     * @param $directory Diretório
     * @param array $excecao [] Array que armazena a lista de arquivos que não devem ser apagados
     * @return mixed
     */
    public static function deletarArquivosNoDiretorioComExcecao($directory, $excecao = array())
    {
        $files = array_diff(scandir($directory), array('.', '..'));
        foreach ($files as $file) {
            if (!in_array($file, $excecao)) {
                (is_dir("$directory/$file")) ? self::delTree("$directory/$file") : unlink("$directory/$file");
            }

        }
        return $directory;
    }

}
