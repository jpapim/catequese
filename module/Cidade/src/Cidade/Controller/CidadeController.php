<?php

namespace Cidade\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CidadeController extends AbstractCrudController
{
    /**
     * @var \Cidade\Service\Cidade
     */
    protected $service;

    /**
     * @var \Cidade\Form\Cidade
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
    
    public function obterCidadesAction()
    {
        
        $params = $this->getRequest()->getPost()->toArray();
        
        $form = new \Cidade\Form\CidadeEstadoForm(['params' => $params]);
        
        $dadosView = [
            'form' => $form,
            'controller' => $this->params('controller'),
        ];

        $view = new ViewModel($dadosView);
        return $view->setTerminal(true);
    }

    /**
     * Return AutoComplete stuff
     */
    public function autocompletecidadeAction()
    {
        $termo = $_GET['term'];
        $estados = new \Estado\Service\EstadoService();
        $cidades = new \Cidade\Service\CidadeService();
        $arrCidades = $cidades->getFiltrarCidadePorNomeToArray($termo);
        $arrCidadesFiltradas = array();
        foreach($arrCidades as $cidade){
            $obEstado = $estados->buscar($cidade['id_estado']);
            $arrCidadesFiltradas[] = $cidade['nm_cidade'] . ' ('. $obEstado->getSgEstado() . ')';
        }

        $valuesJson = new JsonModel( $arrCidadesFiltradas );
        return $valuesJson;
    }

}
