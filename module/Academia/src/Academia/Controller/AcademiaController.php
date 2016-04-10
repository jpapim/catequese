<?php

namespace Academia\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\JsonModel;
use Estrutura\Helpers\Cript;
use Zend\View\Model\ViewModel;

class AcademiaController extends AbstractCrudController
{
    /**
     * @var \Academia\Service\Academia
     */
    protected $service;

    /**
     * @var \Academia\Form\Academia
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function gravarAction() {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

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
            $cidade = new \Cidade\Service\CidadeService();
            $arrCidade = $cidade->getIdCidadePorNomeToArray($post['id_cidade']);
            $post['id_cidade'] = $arrCidade['id_cidade'];

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            return $service->salvar();

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }

    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    /**
     * Return AutoComplete stuff
     */
    public function autocompleteacademiaAction()
    {
        $termo = $_GET['term'];
        $cidades = new \Cidade\Service\CidadeService();
        $estados = new \Estado\Service\EstadoService();
        $academias = new \Academia\Service\AcademiaService();
        $arrAcademias = $academias->getFiltrarAcademiaPorNomeToArray($termo);
        $arrAcademiasFiltradas = array();
        foreach($arrAcademias as $academia){
            $obCidade = $cidades->buscar($academia['id_cidade']);
            $obEstado = $estados->buscar($obCidade->getIdEstado());
            $arrAcademiasFiltradas[] = $academia['nm_academia'] . ' (' . $obCidade->getNmCidade() . ', ' . $obEstado->getNmEstado() . ')';
        }
        $valuesJson = new JsonModel( $arrAcademiasFiltradas );
        return $valuesJson;
    }

    public function cadastrocustomizadoAction()
    {
        $id = Cript::dec($this->params('id'));
        $post = $this->getPost();

        #Alysson - Se for Alterar
        if ($id) {
        #    $this->form->setData($this->service->buscar($id)->toArray());
        }

        #Alysson - Submissao do Formulario de alteraçao
        if (!empty($post)) {
            $this->form->setData($post);
        }

        $academia = new \Academia\Service\AcademiaService();
        $dadosAcademia = $academia->getAcademiaToArray($id);

        $atletas = new \Atleta\Service\AtletaService();
        $dadosAtletas = $atletas->fetchAllAcademia(array('id_academia'=>$dadosAcademia['id_academia']) );

        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'dados_academia' => $dadosAcademia,
            'lista_atletas' => $dadosAtletas
        ];

        return new ViewModel($dadosView);
    }

}
