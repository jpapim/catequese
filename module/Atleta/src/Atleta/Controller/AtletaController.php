<?php

namespace Atleta\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AtletaController extends AbstractCrudController
{
    /**
     * @var \Atleta\Service\Atleta
     */
    protected $service;

    /**
     * @var \Atleta\Form\Atleta
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
    
        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }
    
    public function indexPaginationAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        
        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "atleta.nm_atleta LIKE ?",
            ],
            '1' => [
                'filter' => "academias.nm_academia LIKE ?",
            ],
            '2' => [
                'filter' => "sexo.nm_sexo LIKE ?",
            ],
            '3' => [
                'filter' => "atleta.nr_peso LIKE ?",
            ],
            '4' => [
                'filter' => "CAST( (TO_DAYS(NOW())- TO_DAYS(dt_nascimento)) / 365.25 AS SIGNED) = ?",
            ],            
            '6' => NULL,
        ];
        
        
        $paginator = $this->service->getAtletasPaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
                current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
                        current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }
    
    
    
    

    public function gravarAction() {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inv�lidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }
            #################################################################
            # Inicio da Customiza�ao dos Valores antes de gravar no banco
            $academia = new \Academia\Service\AcademiaService();
            $arrCidade = $academia->getIdAcademiaPorNomeToArray($post['id_academia']);
            $post['id_academia'] = $arrCidade['id_academia'];

            $cidade = new \Cidade\Service\CidadeService();
            $arrCidade = $cidade->getIdCidadePorNomeToArray($post['id_cidade']);
            $post['id_cidade'] = $arrCidade['id_cidade'];

            $post['dt_nascimento'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']);
            # Fim da Customiza�ao dos Valores antes de gravar no banco
            #################################################################

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

    public function gravarviaacademiaAction() {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inv�lidos');
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

            $post['dt_nascimento'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']);

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastroviaacademia', 'id'=>Cript::enc($post['id_academia'])));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $this->redirect()->toRoute('navegacao', array('controller' => 'academia-academia', 'action' => 'cadastrocustomizado', 'id'=>Cript::enc($post['id_academia'])));
            return $service->salvarviaacademia($post);

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastroviaacademia', 'id'=>Cript::enc($post['id_academia'])));
            return false;
        }
    }

    public function gravaralteracaoviaacademiaAction() {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inv�lidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            #var_dump($post);
            #die;
            if (isset($post['id']) && $post['id']) {
                #$post['id'] = Cript::dec($post['id']);
            }

            $cidade = new \Cidade\Service\CidadeService();
            $arrCidade = $cidade->getIdCidadePorNomeToArray($post['id_cidade']);
            $post['id_cidade'] = $arrCidade['id_cidade'];
            $post['dt_nascimento'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']);

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastroviaacademia', 'id'=>$post['id_academia']));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $this->redirect()->toRoute('navegacao', array('controller' => 'academia-academia', 'action' => 'cadastrocustomizado', 'id'=>Cript::enc($post['id_academia'])));
            #die('dedededede');
            return $service->salvaralterarviaacademia($post);

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastroviaacademia', 'id'=>$post['id_academia']));
            return false;
        }
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function cadastroviaacademiaAction()
    {
        $id_academia = $this->params('id');
        $post = $this->getPost();

        if (!empty($post)) {
            $this->form->setData($post);
        }

        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_academia' =>$id_academia
        ];

        return new ViewModel($dadosView);
    }

    public function alterarviaacademiaAction()
    {
        $id_atleta = $this->params('id');
        $atleta = new \Atleta\Service\AtletaService();
        #Recupera os Dados do Bancopara Preencher o Formulario
        $arrAtletas = $atleta->getAtletaToArray($id_atleta);
        $id_academia = $arrAtletas['id_academia'];
        $post = $this->getPost();

        #print_r($post);
        if (!empty($post)) {
            $this->form->setData($post);
        }

        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_academia' =>$id_academia,
            'id_atleta' =>$id_atleta,
            'nm_atleta' =>$arrAtletas['nm_atleta'],
            'id_sexo' =>$arrAtletas['id_sexo'],
            'id_graduacao' =>$arrAtletas['id_graduacao'],
            'nr_peso' =>$arrAtletas['nr_peso'],
            'dt_nascimento' =>$arrAtletas['dt_nascimento'],
            'tx_endereco' =>$arrAtletas['tx_endereco'],
            'tx_complemento' =>$arrAtletas['tx_complemento'],
            'nr_cep' =>$arrAtletas['nr_cep'],
            'id_cidade' =>$arrAtletas['id_cidade']
        ];

        return new ViewModel($dadosView);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function excluirviaacademiaAction()
    {
        try {
            $request = $this->getRequest();

            if ($request->isPost()) {
                return new JsonModel();
            }

            $id_atleta = $this->params('id');
            $this->service->setId($id_atleta);

            $dados = $this->service->filtrarObjeto()->current();

            if (!$dados) {
                throw new \Exception('Registro n�o encontrado');
            }

            $atleta = new \Atleta\Service\AtletaService();
            $arrAtletas = $atleta->getAtletaToArray($id_atleta);
            $id_academia = $arrAtletas['id_academia'];

            $this->service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', ['controller' => 'academia-academia', 'action' => 'cadastrocustomizado', 'id'=>Cript::enc($id_academia)]);
        } catch (\Exception $e) {

            $this->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('navegacao', ['controller' => 'academia-academia', 'action' => 'cadastrocustomizado', 'id'=>Cript::enc($id_academia)]);
        }
    }

    public function autocompleteatletaAction()
    {
        $termo = $_GET['term'];
        $academias = new \Academia\Service\AcademiaService();
        $atletas = new \Atleta\Service\AtletaService();
        $cidades = new \Cidade\Service\CidadeService();
        $estados = new \Estado\Service\EstadoService();
        $arrAtletas = $atletas->getFiltrarAtletaPorNomeToArray($termo);
        $arrAtletasFiltradas = array();
        foreach($arrAtletas as $atleta){
            $obAcademia = $academias->buscar($atleta['id_academia']);
            $obCidade = $cidades->buscar($obAcademia->getIdCidade());
            $obEstado = $estados->buscar($obCidade->getIdEstado());
            $arrAtletasFiltradas[] = $atleta['nm_atleta'] . ' (' . $obAcademia->getNmAcademia() . ' - ' . $obCidade->getNmCidade() . ', ' . $obEstado->getNmEstado(). ')';
        }

        $valuesJson = new JsonModel( $arrAtletasFiltradas );
        return $valuesJson;
    }

    public function xxxAction()
    {

    }



}
