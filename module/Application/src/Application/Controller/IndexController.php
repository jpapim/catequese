<?php

namespace Application\Controller;

use Estrutura\Controller\AbstractEstruturaController;
use Modulo\Service\ApiSession;
use Modulo\Service\RiskManager;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractEstruturaController {

    public function indexAction() {

        //return $this->redirect()->toRoute('navegacao', ['controller' => 'mcnetwork-index', 'action' => 'index']);
        //Alysson
        return $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'index']);
    }

    public function infoAction() {

        phpinfo();
        die;
    }

}
