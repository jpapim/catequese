<?php

namespace Email\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EmailForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('emailform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('emailform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("em_email")->required(false)->label("E-mail");
        $objForm->combo("id_situacao", '\Situacao\Service\SituacaoService', 'id', 'nm_situacao')->required(true)->label("Situacao");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
