<?php

namespace Infra\Controller;

use Estrutura\Controller\AbstractEstruturaController;

class InfraController extends AbstractEstruturaController
{

    public function indexAction()
    {
        \Estrutura\Helpers\Cache::limparCacheDoSistema();
        $this->addSuccessMessage('As pastas Cache foram limpas com sucesso!');
        $this->redirect()->toRoute('navegacao', array('controller' => 'principal-principal', 'action' => 'index'));
    }

}
