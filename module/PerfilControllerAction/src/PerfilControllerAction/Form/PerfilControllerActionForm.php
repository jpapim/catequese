<?php

namespace PerfilControllerAction\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PerfilControllerActionForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('perfilcontrolleractionform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('perfilcontrolleractionform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->combo("id_controller", '\Controller\Service\ControllerService', 'id', 'nm_controller')->required(true)->label("id controller");  
        $objForm->combo("id_action", '\Action\Service\ActionService', 'id', 'nm_action')->required(true)->label("id action");  
        $objForm->combo("id_perfil", '\Perfil\Service\PerfilService', 'id', 'nm_perfil')->required(true)->label("id perfil");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}