<?php

namespace Sacramento\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SacramentoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('sacramentoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('sacramentoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_sacramento")->required(true)->label("Sacramento");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}