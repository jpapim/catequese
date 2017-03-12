<?php

namespace Turma\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class TurmaForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('turmaform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('turmaform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");


        $objForm->combo("id_etapa", '\Etapa\Service\EtapaService', 'id', 'nm_etapa')->required(true)->label("Etapa");
        $objForm->text("cd_turma")->required(true)->label("Código da Turma");
        $objForm->text("nm_turma")->required(true)->label("Nome da Turma");


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
