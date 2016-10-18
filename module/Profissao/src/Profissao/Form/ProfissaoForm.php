<?php


namespace Profissao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ProfissaoForm extends  AbstractForm {

    public function __construct()
    {
        parent::__construct('profissaoform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('profissaoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_profissao")->required(true)->label("Profissão");

        $this->formObject = $objForm;
    }
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 