<?php

namespace Usuario\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class UsuarioForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('usuarioform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject(
                'usuarioform', $this, $this->inputFilter
        );

        //add captcha element...
        $objForm->captcha('captcha')->required(true);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_usuario")->required(true)->label("Nome completo");
        $objForm->date("dt_nascimento")->required(true)->label("Data de nascimento");
        $objForm->number("nu_rg", 20)->required(false)->label("RG");
        $objForm->cpf("nu_cpf")->required(true)->label("CPF");
        $objForm->text("nm_profissao")->required(false)->label("Profissão");
        $objForm->text("nm_nacionalidade")->required(false)->label("Nacionalidade");
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(false)->label("Sexo");
        $objForm->combo("id_estado_civil", '\EstadoCivil\Service\EstadoCivilService', 'id', 'nm_estado_civil')->required(false)->label("EstadoCivil");
        $objForm->combo("id_tipo_usuario", '\TipoUsuario\Service\TipoUsuarioService', 'id', 'nm_tipo_usuario')->required(true)->label("Tipo de Usuário");
        $objForm->combo("id_situacao_usuario", '\SituacaoUsuario\Service\SituacaoUsuarioService', 'id', 'nm_situacao_usuario')->required(true)->label("Situação do Usuário");
        $objForm->email("em_email")->required(true)->label("Email");
        $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
                ->setAttribute('data-match', '#em_email')
                ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
        $objForm->telefone("nr_telefone")->required(true)->label("Telefone");
        $objForm->telefone("id_telefone", '\Telefone\Service\TelefoneService', 'id', 'nr_telefone')->required(true)->label("Telefone");
        $objForm->combo("id_endereco", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Endereco");

        $objForm->password("pw_senha")->required(true)->label("Senha");
        $objForm->password("pw_senha_confirm")->required(true)->label("Confirmar senha")
                ->setAttribute('data-match', '#pw_senha')
                ->setAttribute('data-match-error', 'Senhas não correspondem');

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
