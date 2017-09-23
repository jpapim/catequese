<?php
/**
 * Created by PhpStorm.
 * User: Yves Guilherme
 * Date: 14/09/2017
 * Time: 12:19
 */

namespace Auth\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class RedefinirEmailForm extends AbstractForm {
    public function __construct($options = []) {

        parent::__construct('redefiniremailForm');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject(
            'redefinirEmailForm', $this, $this->inputFilter
        );

        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->email("em_email")->required(true)->label("E-mail atual");
        $objForm->email("em_novo_email")->required(true)->label("Novo e-mail");
        $objForm->email("em_novo_email_confirm")->required(true)->label("Confirme o e-mail")
            ->setAttribute('data-match', '#em_novo_email')
            ->setAttribute('data-match-error', 'E-mails não correspondem');


        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }
}