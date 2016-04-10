<?php

namespace TipoTelefone\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TipoTelefoneForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('tipotelefoneform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tipotelefoneform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_tipo_telefone")->required(false)->label("Tipo telefone");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}