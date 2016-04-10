<?php

namespace Login\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class LoginForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('loginform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('loginform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("pw_senha")->required(false)->label("Senha");  
        $objForm->text("nr_tentativas")->required(false)->label("NrTentativas");  
        $objForm->text("dt_visita")->required(false)->label("Data da última visita");  
        $objForm->text("dt_registro")->required(false)->label("Data de Registro");  
        $objForm->combo("id_usuario", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(true)->label("Usuario");  
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(true)->label("Email");  
        $objForm->combo("id_situacao", '\Situacao\Service\SituacaoService', 'id', 'nm_situacao')->required(true)->label("Situacao");  
        $objForm->combo("id_perfil", '\Perfil\Service\PerfilService', 'id', 'nm_perfil')->required(true)->label("Perfil");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}