<?php

namespace RegrasLutas\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class RegrasLutasForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('regraslutasform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('regraslutasform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_regra_luta")->required(false)->label("Regras de Luta");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}