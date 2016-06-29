<?php

namespace Etapa\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EtapaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('etapform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('etapaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_etapa")->required(true)->label("Etapa");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}