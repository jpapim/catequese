<?php

namespace Paroquia\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ParoquiaForm extends AbstractForm
{
    public function __construct($options = [])
    {
        parent::__construct('Paroquiaform');
        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('Paroquiaform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrado");
        
        $objForm->text("nm_paroquia")->required(true)->label("Nome da Paróquia");
        $objForm->text("id_cidade")->required(false)->label("Cidade");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}