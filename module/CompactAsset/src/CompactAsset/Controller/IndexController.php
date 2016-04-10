<?php

namespace CompactAsset\Controller;

use Estrutura\Controller\AbstractEstruturaController;

class IndexController extends AbstractEstruturaController {

    /**
     * 
     */
    public function compactJsAction() {

        $cache = true;
        $cachedir = BASE_PATCH . '/public/assets/cache';
        $jsdir = BASE_PATCH . '/public/assets/js';

        $base = realpath($jsdir);
        $elements = explode(',', str_replace('|', '/', $this->params('id')));

        // Determinar a data da última modificação dos arquivos
        $lastmodified = 0;

        while (list(, $element) = each($elements)) {

            $path = realpath($base . '/' . $element);
            $lastmodified = max($lastmodified, filemtime($path));
        }

        // Enviar ETag hash
        $hash = $lastmodified . '-' . md5(implode(',', $elements));

        header('Etag: "' . $hash . '"');

        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&
                stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"') {

            // Retorna sem modificações, por isso não envia nada
            header('HTTP/1.0 304 Not Modified');
            header('Content-Length: 0');
            exit;
        } else {

            // Primeira visita vez ou arquivos foram modificados
            if ($cache) {
                // Determinar o método de compressão suportados
                $gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
                $deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');
                // Determinar o método de compressão utilizado
                $encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');
                
                // Verificar se há versões com bugs do Internet Explorer
                if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') &&
                        preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
                    $version = floatval($matches[1]);
                    if ($version < 6) {
                        $encoding = 'none';
                    }
                    if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) {
                        $encoding = 'none';
                    }
                }

                // EXPERIMENTE A PRIMEIRA CACHE PARA VER SE OS ARQUIVOS JÁ FORAM COMBINADAS GERADAS
                $cachefile = 'cache-' . $hash . '.js' . ($encoding != 'none' ? '.' . $encoding : '');
                if (file_exists($cachedir . '/' . $cachefile)) {

                    if ($fp = fopen($cachedir . '/' . $cachefile, 'rb')) {

                        if ($encoding != 'none') {

                            header('Content-Encoding: ' . $encoding);
                        }
                        header('Content-Type: text/js');
                        header('Content-Length: ' . filesize($cachedir . '/' . $cachefile));
                        fpassthru($fp);
                        fclose($fp);
                        exit;
                    }
                }
            }

            // Recebe o conteúdo dos arquivos
            $contents = '';

            reset($elements);

            while (list(, $element) = each($elements)) {

                $path = realpath($base . '/' . $element);

                $compactAssetService = new \CompactAsset\Service\CompactAssetService(file_get_contents($path), 'Normal', true, false);
                $contents .= "\n" . $compactAssetService->pack();
            }

            // Envia Content-Type
            header('Content-Type: text/js');
            if (isset($encoding) && $encoding != 'none') {

                // Envia contents compressado
                $contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
                header('Content-Encoding: ' . $encoding);
                header('Content-Length: ' . strlen($contents));
                echo $contents;
            } else {

                // Send regular contents
                header('Content-Length: ' . strlen($contents));
                echo $contents;
            }

            // Store cache
            if ($cache) {
                if ($fp = fopen($cachedir . '/' . $cachefile, 'wb')) {
                    fwrite($fp, $contents);
                    fclose($fp);
                }
            }
        }
        exit;
    }

    /**
     * 
     */
    public function compactCssAction() {

        $cache = true;
        $cachedir = BASE_PATCH . '/public/assets/cache';
        $cssdir = BASE_PATCH . '/public/assets/css';

        $base = realpath($cssdir);
        $elements = explode(',', str_replace('|', '/', $this->params('id')));

        // Determinar a data da última modificação dos arquivos
        $lastmodified = 0;

        while (list(, $element) = each($elements)) {

            $path = realpath($base . '/' . $element);
            $lastmodified = max($lastmodified, filemtime($path));
        }
        // Enviar ETag hash
        $hash = $lastmodified . '-' . md5(implode(',', $elements));

        header('Etag: "' . $hash . '"');

        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&
                stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"') {

            // Retorna sem modificações, por isso não envie nada
            header('HTTP/1.0 304 Not Modified');
            header('Content-Length: 0');
            exit;
        } else {

            // Primeira visita vez ou arquivos foram modificados
            if ($cache) {
                // Determinar o método de compressão suportados
                $gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
                $deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');
                // Determinar o método de compressão utilizado
                $encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');
                
                // Verificar se há versões com bugs do Internet Explorer
                if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') &&
                        preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
                    $version = floatval($matches[1]);
                    if ($version < 6) {
                        $encoding = 'none';
                    }
                    if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) {
                        $encoding = 'none';
                    }
                }

                // EXPERIMENTE A PRIMEIRA CACHE PARA VER SE OS ARQUIVOS JÁ FORAM COMBINADAS GERADAS
                $cachefile = 'cache-' . $hash . '.css' . ($encoding != 'none' ? '.' . $encoding : '');
                if (file_exists($cachedir . '/' . $cachefile)) {

                    if ($fp = fopen($cachedir . '/' . $cachefile, 'rb')) {

                        if ($encoding != 'none') {

                            header('Content-Encoding: ' . $encoding);
                        }
                        header('Content-Type: text/css');
                        header('Content-Length: ' . filesize($cachedir . '/' . $cachefile));
                        fpassthru($fp);
                        fclose($fp);
                        exit;
                    }
                }
            }

            // Recebe o conteúdo dos arquivos
            $contents = '';

            reset($elements);

            while (list(, $element) = each($elements)) {

                $path = realpath($base . '/' . $element);
                $contents .= "\n" . $this->comprimirCss(file_get_contents($path));
            }

            // Envia Content-Type
            header('Content-Type: text/css');
            if (isset($encoding) && $encoding != 'none') {

                // Envia contents compressado
                $contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
                header('Content-Encoding: ' . $encoding);
                header('Content-Length: ' . strlen($contents));
                echo $contents;
            } else {

                // Send regular contents
                header('Content-Length: ' . strlen($contents));
                echo $contents;
            }

            // Store cache
            if ($cache) {
                if ($fp = fopen($cachedir . '/' . $cachefile, 'wb')) {
                    fwrite($fp, $contents);
                    fclose($fp);
                }
            }
        }
        exit;
    }

    /**
     * 
     * @param type $css
     * @return type
     */
    public function comprimirCss($css) {

        return strtr(preg_replace('#[ ]*([,:;\{\}])[ ]*#', '$1', preg_replace('#(\r|\n|\t)#', '', preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css))), array(
            ';}' => '}'
        ));
    }

}
