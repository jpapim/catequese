<?php

namespace CatequistaTurma\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class CatequistaTurmaForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('catequistaturmaform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('catequistaturmaform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_turma", '\Turma\Service\TurmaService', 'id', 'nm_turma')->required(false)->label("Turma");              
        $objForm->combo("id_catequista", '\Catequista\Service\CatequistaService', 'id', 'nm_catequista')->required(false)->label("Catequista");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
