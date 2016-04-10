<?php

namespace InscricoesEvento\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class InscricoesEventoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('inscricoeseventoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('inscricoeseventoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_evento", '\Evento\Service\EventoService', 'id', 'nm_evento')->required(false)->label("Evento");
        $objForm->text("id_atleta")->required(false)->label("Atleta");
        #$objForm->date("dt_inscricao")->required(true)->setAttribute('class', 'data')->label("Data da Inscrição");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}