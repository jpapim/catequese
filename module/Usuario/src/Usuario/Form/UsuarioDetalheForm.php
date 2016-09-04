<?php

namespace Usuario\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class UsuarioDetalheForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('usuariodetalheform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject(
                'usuariodetalheform', $this, $this->inputFilter
        );

        //add captcha element...
        #$objForm->captcha('captcha')->required(true);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_usuario")->required(true)->label("Nome completo");
        $objForm->date("dt_nascimento")->required(true)->label("Data de nascimento");
        $objForm->text("id_nacionalidade")->required(false)->label("Nacionalidade");
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(false)->label("Sexo");
        $objForm->text("id_tipo_usuario")->required(true)->label("Tipo de Usuário");
        $objForm->text("id_situacao_usuario")->required(true)->label("Situação do Usuário");
        
        $objForm->text("id_email")->required(false)->label("Email");
        
        $objForm->telefone("id_telefone")->required(true)->label("Telefone");

       
       
        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
