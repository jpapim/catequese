<?php

namespace Situacao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SituacaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('situacaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('situacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_situacao")->required(false)->label("Situação");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}