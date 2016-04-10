<?php

namespace TipoConta\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TipoContaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('tipocontaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tipocontaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_tipo_conta")->required(false)->label("Tipo conta");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}