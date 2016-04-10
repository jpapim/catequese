<?php

namespace Auth\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EsqueciSenhaForm extends AbstractForm {

    public function __construct($options = []) {

        parent::__construct('esquecisenhaForm');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject(
                'esqueciSenhaForm', $this, $this->inputFilter
        );

        $objForm->email('email')->required(true)->label('Endereço de e-mail de cadastro');
        $objForm->captcha('captcha')->required(true);
        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
