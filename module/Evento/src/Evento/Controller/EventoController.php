<?php

namespace Evento\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\JsonModel;

class EventoController extends AbstractCrudController
{
    /**
     * @var \Evento\Service\Evento
     */
    protected $service;

    /**
     * @var \Evento\Form\Evento
     */
    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        $atributos = array();
        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'lista' => $this->service->fetchAllEventosAtivosToArray(),
            'controller' => $this->params('controller'),
            'atributos' => $atributos
        ];
        return new ViewModel($dadosView);

    }

    public function gravarAction()
    {
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
            #################################################################
            # Inicio da Customizaçao dos Valores antes de gravar no banco
            $cidade = new \Cidade\Service\CidadeService();
            $arrCidade = $cidade->getIdCidadePorNomeToArray($post['id_cidade']);
            $post['id_cidade'] = $arrCidade['id_cidade'];
            $post['dt_evento'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_evento']);
            # Fim da Customizaçao dos Valores antes de gravar no banco
            #################################################################

            #print_r($post);
            #die;

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

    public function realizarinscricoesAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            $nm_atleta = $this->params()->fromPost('nm_atleta');
            $id_evento = $this->params()->fromPost('id_evento');

            $atleta = new \Atleta\Service\AtletaService();
            $arrAtleta = $atleta->getIdAtletaPorNomeToArray($this->params()->fromPost('nm_atleta'));
            $realizar_inscricao = new \InscricoesEvento\Service\InscricoesEventoService();

            //TODO - Implementar Validador para certificar que o Atleta ainda nao esta na base.
            if($realizar_inscricao->checarSeAtletaEstaInscritoNoEvento($arrAtleta['id_atleta'],$id_evento)){
                $valuesJson = new JsonModel( array('sucesso'=>false, 'nm_atleta'=>$nm_atleta) );
            }else{
                $id_inserido = $realizar_inscricao->getTable()->salvar(array('id_evento'=>$id_evento, 'id_atleta'=>$arrAtleta['id_atleta']), null);
                $valuesJson = new JsonModel( array('id_inserido'=>$id_inserido, 'sucesso'=>true, 'nm_atleta'=>$nm_atleta) );
            }

            return $valuesJson;
        } else { //Se for requisição normal
            $id = Cript::dec($this->params('id'));
            $post = $this->getPost();
            #Alysson - Se for Alterar
            if ($id) {
                #$this->form->setData($this->service->buscar($id)->toArray());
            }
            #Alysson - Submissao do Formulario de alteraçao
            if (!empty($post)) {
                $this->form->setData($post);
            }
            $evento = new \Evento\Service\EventoService();
            $dadosEvento = $evento->getEventoToArray($id);

            $inscricoes = new \InscricoesEvento\Service\InscricoesEventoService();
            $dadosInscricoes = $inscricoes->fetchAllEventos(array('id_evento' => $dadosEvento['id_evento']));

            $dadosView = [
                'service' => $this->service,
                'form' => $this->form,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'dados_evento' => $dadosEvento,
                'lista_inscritos' => $dadosInscricoes
            ];

            return new ViewModel($dadosView);
        }
    }

}
