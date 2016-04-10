<?php

namespace ChavesLuta\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ChavesLutaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('chaveslutaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('chaveslutaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_evento", '\Evento\Service\EventoService', 'id', 'nm_evento')->required(true)->label("Evento");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}