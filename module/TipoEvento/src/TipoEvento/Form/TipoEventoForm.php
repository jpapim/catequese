<?php

namespace TipoEvento\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TipoEventoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('tipoeventoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tipoeventoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_tipo_evento")->required(false)->label("Tipo Evento");
        $objForm->textarea("ds_tipo_evento")->required(false)->label("Descrição do Evento");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}