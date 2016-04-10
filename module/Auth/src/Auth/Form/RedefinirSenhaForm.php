<?php

namespace Auth\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class RedefinirSenhaForm extends AbstractForm {

    public function __construct($options = []) {

        parent::__construct('redefinirsenhaForm');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject(
                'redefinirSenhaForm', $this, $this->inputFilter
        );

        $objForm->password("pw_senha")->required(true)->label("Senha atual");
        $objForm->password("pw_nova_senha")->required(true)->label("Nova senha");
        $objForm->password("pw_nova_senha_confirm")->required(true)->label("Confirmar senha")
                ->setAttribute('data-match', '#pw_nova_senha')
                ->setAttribute('data-match-error', 'Senhas não correspondem');

        $objForm->captcha('captcha')->required(true);
        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
