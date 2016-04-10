<?php

namespace Estilo\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EstiloForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('estiloform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('estiloform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_estilo")->required(false)->label("Estilo");
        $objForm->textarea("ds_estilo")->required(false)->label("Descriçao");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}