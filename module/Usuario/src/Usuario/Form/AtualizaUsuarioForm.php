<?php

namespace Usuario\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AtualizaUsuarioForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('usuarioform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject(
                'usuarioform', $this, $this->inputFilter
        );

        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_usuario")->required(true)->label("Nome completo");
        $objForm->email("em_email")->required(false)->label("E-mail");
        $objForm->text("nm_funcao")->required(true)->label("Função");
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(true)->label("Sexo");
        $objForm->telefone("nr_telefone")->required(false)->label("Telefone");
        $objForm->telefone("id_telefone", '\Telefone\Service\TelefoneService', 'id', 'nr_telefone')->required(false)->label("Telefone");
        $objForm->select("id_situacao_usuario", array('1'=> 'Ativo', '2' => 'Inativo'))->required(true)->label("Situação do Usuário");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
