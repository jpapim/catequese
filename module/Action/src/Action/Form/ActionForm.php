<?php

namespace Action\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ActionForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('actionform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('actionform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_action")->required(false)->label("Ação");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}