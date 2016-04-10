<?php

namespace InscricoesEvento\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;

class InscricoesEventoController extends AbstractCrudController
{
    /**
     * @var \InscricoesEvento\Service\InscricoesEvento
     */
    protected $service;

    /**
     * @var \InscricoesEvento\Form\InscricoesEvento
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

            print_r($post);

            #################################################################
            # Inicio da Customizaçao dos Valores antes de gravar no banco
            $atleta = new \Atleta\Service\AtletaService();
            $arrAtleta= $atleta->getIdAtletaPorNomeToArray($post['id_atleta']);
            $post['id_atleta'] = $arrAtleta['id_atleta'];
            #$post['dt_inscricao'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_inscricao']);
            # Fim da Customizaçao dos Valores antes de gravar no banco
            #################################################################

            #var_dump($post);
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

    public function realizarinscricaoeventoajaxAction()
    {
        $request = $this->getRequest();
        var_dump($request);
        die;
    }
}
