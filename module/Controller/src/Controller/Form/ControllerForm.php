<?php

namespace Controller\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ControllerForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('controllerform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('controllerform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_controller")->required(false)->label("Controller");

        $objForm->text("nm_modulo")->required(false)->label("Módulo");

        $objForm->checkbox('cs_exibir_combo', array(), true)->required(false)->label("Exibir Módulos nos Combos?");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}