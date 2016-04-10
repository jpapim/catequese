<?php

namespace Cidade\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class CidadeForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('cidadeform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('cidadeform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_estado", '\Estado\Service\EstadoService', 'id', 'nm_estado')->required(true)->label("Estado");
        $objForm->text("nm_cidade")->required(false)->label("Cidade");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
