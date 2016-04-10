<?php

/**
 * Classe de abstração para as controllers de crud do sistema
 * Define as funções principais dos cruds do sistema
 */

namespace Estrutura\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Cript;

abstract class AbstractCrudController extends AbstractEstruturaController
{

    public function index($service, $form, $atributos = [])
    {
        $dadosView = [
            'service' => $service,
            'form' => $form,
            'lista' => $service->filtrarObjeto(),
            'controller' => $this->params('controller'),
            'atributos' => $atributos
        ];
        return new ViewModel($dadosView);
    }

    public function cadastro($service, $form, $atributos = [])
    {
        $id = Cript::dec($this->params('id'));        
        $post = $this->getPost();
        
        if ($id) {
            $form->setData($service->buscar($id)->toArray());
        }

        if (!empty($post)) {
            
            $form->setData($post);
        }
        
        $dadosView = [
            'service' => $service,
            'form' => $form,
            'controller' => $this->params('controller'),
            'atributos' => $atributos
        ];

        return new ViewModel($dadosView);
    }

    public function gravar($service, $form)
    {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();

            if (!$request->isPost()) {
                throw new \Exception('Dados Inválidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());
            
            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }
            
            $service->exchangeArray($form->getData());
            return $service->salvar();
            
        } catch (\Exception $e) {
            
            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function excluir($service, $form, $atributos = [])
    {
        try {
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');

            $id = Cript::dec($this->params('id'));
            $service->setId($id);

            $dados = $service->filtrarObjeto()->current();

            if (!$dados) {
                throw new \Exception('Registro não encontrado');
            }

            $service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        } catch (\Exception $e) {
            if( strstr($e->getMessage(), '1451') ) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir a academia voce deve excluir todos os atletas da academia. Verifique!');
            }else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }
    }

    public function uploadFile($files, $local = './data/arquivos')
    {
        $retorno = [];
        foreach ($files as $name => $file) {
            $filter = new \Zend\Filter\File\RenameUpload(array(
                'target' => $local,
                'randomize' => true,
            ));
            $filter->setUseUploadName(true);
            $filter->setOverwrite(true);
//            $filter->filter($file);
            $retorno[$name] = $filter->filter($file);
        }
        return $retorno;
    }

}
