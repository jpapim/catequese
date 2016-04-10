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

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}