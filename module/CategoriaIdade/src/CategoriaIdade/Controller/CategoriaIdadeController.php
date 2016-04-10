<?php

namespace CategoriaIdade\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\JsonModel;

class CategoriaIdadeController extends AbstractCrudController
{
    /**
     * @var \CategoriaIdade\Service\CategoriaIdade
     */
    protected $service;

    /**
     * @var \CategoriaIdade\Form\CategoriaIdade
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function gravarAction(){
        #Alysson
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function carregarsugestaoidadeporcategoriaAction()
    {
        $id_categoria_idade = $_GET['termo'];
        $categoria_idade = new \CategoriaIdade\Service\CategoriaIdadeService();
        $arrCategoriaIdade = $categoria_idade->getCategoriaIdadeToArray($id_categoria_idade);

        $valuesJson = new JsonModel( $arrCategoriaIdade );

        return $valuesJson;
    }

}
