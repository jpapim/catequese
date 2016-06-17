<?php

namespace Permissao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PermissaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('controllerform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('controllerform',$this,$this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->combo("id_perfil", '\Perfil\Service\PerfilService','id','nm_perfil')->required(false)->label("Selecionar Perfil");

        $objForm->combo("id_modulo", '\Controller\Service\ControllerService','id','nm_controller')->required(false)->label("Selecione o Modulo");

        #$listActions = $this->sm()->get('Action/Service/ActionService')->fetchAll();
        #$listActions = $this->sm()->get('\Action\Service\ActionService')->fetchAll();
        #$obAction = new \Action\Service\ActionService();
        #$listActions = $obAction->fetchAll();
        #$actions = [];

        #foreach ($listActions as $key => $action) {
        #    $actions[] = [
        #        #'value' => \Estrutura\Helpers\Cript::enc($action->getId()),
        #        'value' => $action->getId(),
        #        'id' => 'id_action' . $key,
        #        'label' => $action->getNmAction(),
        #        #'selected' => in_array(\Estrutura\Helpers\Cript::enc($action->getId()), $options['actions']) ? true : false,
        #        'selected' => in_array($action->getId(), $options['actions']) ? true : false,
        #    ];
        #}
        #$objForm->multicheckbox('id_action2', $actions)->required(false)->label('Gostaria de receber suporte de mais empresas?');

        $objForm->checkbox('id_action', array())->required(false)->label('Gostaria de receber suporte de mais empresas?');


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}