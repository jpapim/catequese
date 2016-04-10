<?php

namespace Gerador\Service;

use Estrutura\Helpers\String;

class Gerador {

    protected $mapa;
    protected $controllers;

    public function __construct($mapa) {
        $this->mapa = $mapa;
    }

    public function gerar() {
        foreach ($this->mapa as $tabela => $campos) {

            $nameSpace = $this->getNameSpace($tabela);
            $this->criarPastas($nameSpace);
            $this->gerarTable($nameSpace, $tabela, $campos);
            $this->gerarEntitys($nameSpace, $tabela, $campos);
            $this->gerarServices($nameSpace, $tabela);
            $this->gerarForms($nameSpace, $tabela, $campos);
            $this->gerarControllers($nameSpace, $tabela, $campos);
        }

        foreach ($this->controllers as $nameSpace => $item) {
            $string = '';
            foreach ($item as $controller) {
                $lower = strtolower($nameSpace);
                $class = strtolower($controller);
                $string .= '            \'' . $lower . '-' . $class . '\' => \'' . $nameSpace . '\Controller\\' . ucfirst($class) . 'Controller\',' . "\r\n";
            }

            $this->gerarConfigNameSpace($nameSpace, $string);
        }
    }

    public function gerarTable($nameSpace, $tabela, $campos) {
        $stringCampos = $this->gerarTabelaCampos($campos);
        $modelo = $this->getModelo('Table');
        $classe = $this->getClasseName($nameSpace, $tabela);

        $arquivo = $this->tratarModelo(['namespace' => String::underscore2Camelcase($nameSpace), 'classe' => $classe, 'tabela' => $tabela, 'stringCampos' => $stringCampos], $modelo);

        $location = $this->getLocation($nameSpace, 'Table', $classe . 'Table');
        $this->escreverArquivo($location['file'], $arquivo);
    }

    public function getNameSpace($tabela) {
        $tabela = strtolower($tabela);
        //$dadosTabela = explode('_',$tabela);
        return ucfirst($tabela);
    }

    private function gerarTabelaCampos($campos) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
        foreach ($campos as $item) {

            if (strcasecmp($item->getDataType(), 'int') == 0 &&
                    preg_match('/auto_increment/', $item->getExtra())) {

                $string .= "        '{$item->getColumnName()}'=>'id', \r\n";
            } else {

                $string .= "        '{$item->getColumnName()}'=>'{$item->getColumnName()}', \r\n";
            }
        }

        return $string;
    }

    private function gerarEntityCampos($campos) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
        foreach ($campos as $item) {

            if (strcasecmp($item->getDataType(), 'int') == 0 &&
                    preg_match('/auto_increment/', $item->getExtra())) {

                $string .= "        " . 'protected $' . "id; \r\n";
            } else {

                $string .= "        " . 'protected $' . "{$item->getColumnName()}; \r\n";
            }
        }

        return $string;
    }

    private function gerarEntityGetset($campos) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
//        foreach($campos as $item){
//            $campo = $this->tratarNome($item->getColumnName());
//            $string .= "        ".'public function get'."{$campo}()
//            {
//                return ".'$this->'."{$campo};
//            } \r\n";
//
//            $string .= "        ".'public function set'."{$campo}(".'$'."{$campo})
//            {
//                return ".'$this->'."{$campo} = ".'$'."{$campo};
//            } \r\n";
//        }

        return $string;
    }

    public function getModelo($modelo) {
        $file = __DIR__ . '/../Modelo/' . $modelo . '.modelo';
        return file_get_contents($file);
    }

    private function getClasseName($nameSpace, $tabela) {
        $nameSpace = strtolower($nameSpace);
        $tabela = strtolower($tabela);
        $principal = str_replace($nameSpace . '_', '', $tabela);
        return $this->tratarNome($principal);
    }

    private function tratarNome($principal) {
        $principal = strtolower($principal);
        $dados = explode('_', $principal);
        $string = '';
        foreach ($dados as $item) {
            $string .= ucfirst($item);
        }
        return $string;
    }

    private function getLocation($nameSpace, $tipo = false, $classe = '') {
        $gerador = require(BASE_PATCH . '/config/autoload/gerador.php');

        if (!$tipo) {

            return $gerador['location'] . String::underscore2Camelcase($nameSpace);
        }

        $caminho = $gerador['location'] . String::underscore2Camelcase($nameSpace) . '/src/' . String::underscore2Camelcase($nameSpace) . '/' . $tipo . '/';
        $dados = [
            'file' => $caminho . $classe . '.php',
            'folder' => $caminho
        ];

        return $dados;
    }

    private function gerarConfigNamespace($nameSpace, $controllers) {
        $folder = $this->getLocation($nameSpace);

        /// Module.php
        $modelo = $this->getModelo('Module');
        $module = $this->tratarModelo(
                [
            'nameSpace' => String::underscore2Camelcase($nameSpace)
                ], $modelo);
        $this->escreverArquivo($folder . '/Module.php', $module);

        /// module.config.php
        $folder = $folder . '/config';
        $modelo = $this->getModelo('Module.Config');
        $module = $this->tratarModelo(
                [
            'invokables' => $controllers,
            'namespace' => String::underscore2Camelcase($nameSpace),
            'route' => strtolower($nameSpace)
                ], $modelo);
        $this->escreverArquivo($folder . '/module.config.php', $module);
    }

    public function tratarModelo($array, $modelo) {
        $modeloArray = [];
        foreach ($array as $name => $item) {
            $modeloArray[] = '{{' . $name . '}}';
        }

        $tratado = str_replace($modeloArray, array_values($array), $modelo);
        return $tratado;
    }

    public function escreverArquivo($arquivo, $conteudo) {
        if (!file_exists($arquivo)) {
            $handle = fopen($arquivo, 'x+');
            fwrite($handle, $conteudo);
            fclose($handle);
        };
    }

    private function criarPastas($nameSpace) {
        $pastas = ['config',
            'view/' . str_replace('_', '-', strtolower($nameSpace)),
            'src/' . String::underscore2Camelcase($nameSpace) . '/Controller',
            'src/' . String::underscore2Camelcase($nameSpace) . '/Service',
            'src/' . String::underscore2Camelcase($nameSpace) . '/Table',
            'src/' . String::underscore2Camelcase($nameSpace) . '/Entity',
            'src/' . String::underscore2Camelcase($nameSpace) . '/Form'];

        $folder = $this->getLocation($nameSpace);

        foreach ($pastas as $pasta) {
            if (!file_exists($folder . '/' . $pasta)) {
                mkdir($folder . '/' . $pasta, 0777, true);
            }
        }
    }

    private function gerarEntitys($nameSpace, $tabela, $campos) {
        $stringCampos = $this->gerarEntityCampos($campos);
        $stringGetSet = $this->gerarEntityGetset($campos);

        $modelo = $this->getModelo('Entity');
        $classe = $this->getClasseName($nameSpace, $tabela);

        $arquivo = $this->tratarModelo(
                [
            'namespace' => String::underscore2Camelcase($nameSpace),
            'classe' => $classe,
            'campos' => $stringCampos,
            'getAndSet' => $stringGetSet
                ], $modelo);

        $location = $this->getLocation($nameSpace, 'Entity', $classe . 'Entity');
        $this->escreverArquivo($location['file'], $arquivo);
    }

    private function gerarServices($nameSpace, $tabela) {
        $modelo = $this->getModelo('Service');
        $classe = $this->getClasseName($nameSpace, $tabela);

        $arquivo = $this->tratarModelo(['namespace' => String::underscore2Camelcase($nameSpace), 'classe' => $classe], $modelo);

        $location = $this->getLocation($nameSpace, 'Service', $classe . 'Service');
        $this->escreverArquivo($location['file'], $arquivo);
    }

    private function gerarForms($nameSpace, $tabela, $campos) {
        $stringCampos = $this->gerarFormCampos($campos, $nameSpace);
        $modelo = $this->getModelo('Form');
        $classe = $this->getClasseName($nameSpace, $tabela);

        $arquivo = $this->tratarModelo([
            'namespace' => String::underscore2Camelcase($nameSpace),
            'classe' => $classe,
            'campos' => $stringCampos,
            'formName' => strtolower($classe . 'Form')], $modelo);

        $location = $this->getLocation($nameSpace, 'Form', $classe . 'Form');
        $this->escreverArquivo($location['file'], $arquivo);
    }

    private function gerarFormCampos($campos, $nameSpace) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
        foreach ($campos as $item) {

            $type = $this->getTypeForm($item);

            if ($type == 'hidden') {

                $item->setIsNullable('YES');
            }

            $name = $item->getColumnName();
            $label = str_replace('_', ' ', $item->getColumnName());

            $comment = json_decode($item->getColumnComment(), true);
            if (isset($comment['label'])) {

                $label = $comment['label'];
            }

            $nulo = ($item->getIsNullable() == 'YES') ? 'false' : 'true';

            if ($type == 'combo') {

                $service = str_ireplace('ID_', '', $item->getColumnName());
                $serviceTratado = $this->tratarNome($service);
                $string .= "        " . '$objForm->' . $type . '("' . $name . '", \'\\' . $serviceTratado . '\Service\\' . $serviceTratado . 'Service\', \'id\', \'nm_' . strtolower(String::camelcase2underscore($service)) . '\')->required(' . $nulo . ')->label("' . $label . '");' . "  \r\n";
            } else {

                if (strcasecmp($item->getDataType(), 'int') == 0 &&
                        preg_match('/auto_increment/', $item->getExtra())) {

                    $string .= "        " . '$objForm->' . $type . '("id")->required(' . $nulo . ')->label("Id");' . "  \r\n";
                } else {

                    $string .= "        " . '$objForm->' . $type . '("' . $name . '")->required(' . $nulo . ')->label("' . $label . '");' . "  \r\n";
                }
            }
        }

        return $string;
    }

    private function getTypeForm($item) {
        switch ($item->getDataType()) {
            case 'int':
                if (preg_match('/auto_increment/', $item->getExtra())) {
                    $tipo = 'hidden';
                } else {
                    $tipo = 'combo';
                }
                break;
            case 'text':
                $tipo = 'textarea';
                break;
            default:
                $tipo = 'text';
                break;
        }

        return $tipo;
    }

    private function gerarControllers($nameSpace, $tabela, $campos) {
        $modelo = $this->getModelo('Controller');
        $classe = $this->getClasseName($nameSpace, $tabela);

        $arquivo = $this->tratarModelo(['namespace' => String::underscore2Camelcase($nameSpace), 'classe' => $classe], $modelo);

        $location = $this->getLocation($nameSpace, 'Controller', $classe . 'Controller');
        $this->escreverArquivo($location['file'], $arquivo);

        $location = $this->folderView($nameSpace, $classe);

        /// Index
        $modelo = $this->getModelo('Index');
        $th = $this->gerarIndexTh($campos);
        $td = $this->gerarIndexTd($campos);

        $arquivo = $this->tratarModelo(['th' => $th, 'td' => $td, 'namespace' => String::underscore2Camelcase($nameSpace), 'classe' => $classe], $modelo);

        $this->escreverArquivo($location . '/index.phtml', $arquivo);

        /// Cadastro
        $modelo = $this->getModelo('Cadastro');
        $stringCampos = $this->gerarCadastroCampos($campos);
        $arquivo = $this->tratarModelo(['campos' => $stringCampos, 'namespace' => String::underscore2Camelcase($nameSpace), 'classe' => $classe, 'route' => strtolower($nameSpace)], $modelo);

        $this->escreverArquivo($location . '/cadastro.phtml', $arquivo);

        $this->controllers[$nameSpace][] = $classe;
    }

    private function folderView($namespace, $classe) {
        $location = $this->getLocation($namespace);

        $view = $location . '/view/' . str_replace('_', '-', strtolower($namespace . '/' . String::camelcase2underscore($classe)));

        if (!file_exists($view)) {

            mkdir($view, 0777, true);
        }

        return $view;
    }

    private function gerarCadastroCampos($campos) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
        foreach ($campos as $item) {

            $tipo = $this->getTypeForm($item);
            if ($tipo == 'hidden') {
                continue;
            }

            $html = '<div class="form-group">
                    <div class="col-md-4">
                        <?=$this->formRow($form->get(\'' . $item->getColumnName() . '\'))?>
                    </div>
                </div>';
            $string .= $html;
        }

        return $string;
    }

    private function gerarIndexTh($campos) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
        foreach ($campos as $item) {

            if (strcasecmp($item->getDataType(), 'int') != 0 &&
                    !(preg_match('/auto_increment/', $item->getExtra()))) {

                $comment = $label = json_decode($item->getColumnComment(), true);
                if (isset($comment['label'])) {

                    $label = $comment['label'];
                }

                $html = "<th>{$label}</th> \r\n                                ";
                $string .= $html;
            }
        }

        return $string;
    }

    private function gerarIndexTd($campos) {
        $string = '';
        /** @var $item \Gerador\Service\GeradorColuna */
        foreach ($campos as $item) {

            if (strcasecmp($item->getDataType(), 'int') != 0 &&
                    !(preg_match('/auto_increment/', $item->getExtra()))) {

                $name = $this->tratarNome($item->getColumnName());
                $html = '<td><?=$item->get' . $name . '()?></td> ' . "\r\n" . '                                ';
                $string .= $html;
            }
        }

        return $string;
    }

}
