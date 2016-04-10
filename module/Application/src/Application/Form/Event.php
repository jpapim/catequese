<?php

namespace Application\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class Event extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('event');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('event',$this,$this->inputFilter);
        $objForm->hidden('Code')->required(false)->label('Código');
        $objForm->text('Titulo')->required(true)->label('Título');
        $objForm->textarea('Descricao')->required(true)->label('Descrição');
        $objForm->urgency('Urgencia')->required(true)->label('Urgência');
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 