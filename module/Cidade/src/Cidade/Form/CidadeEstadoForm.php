<?php

namespace Cidade\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class CidadeEstadoForm extends AbstractForm {

    public function __construct($options = []) {
        
        parent::__construct('cidadeEstadoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('cidadeEstadoform', $this, $this->inputFilter);
        $objForm->combo("id_cidade", '\Cidade\Service\CidadeService', 'id', 'nm_cidade', 'fetchAllEstado', $options['params'])->required(true)->label("Cidade");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
