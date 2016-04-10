<?php

namespace TipoUsuario\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TipoUsuarioForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('tipousuarioform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tipousuarioform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_tipo_usuario")->required(false)->label("Tipo usuário");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}