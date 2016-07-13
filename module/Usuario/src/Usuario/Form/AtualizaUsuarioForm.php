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
        $objForm->number("nu_rg", 20)->required(true)->label("RG");
        $objForm->cpf("nu_cpf")->required(true)->label("CPF");
        $objForm->email("em_email")->required(false)->label("E-mail");
        $objForm->text("nm_profissao")->required(true)->label("Profissão");
        $objForm->text("nm_nacionalidade")->required(true)->label("Nacionalidade");
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(true)->label("Sexo");
        $objForm->combo("id_estado_civil", '\EstadoCivil\Service\EstadoCivilService', 'id', 'nm_estado_civil')->required(true)->label("EstadoCivil");
        $objForm->telefone("nr_telefone")->required(true)->label("Telefone");
        $objForm->telefone("id_telefone", '\Telefone\Service\TelefoneService', 'id', 'nr_telefone')->required(false)->label("Telefone");

        $objForm->text("nm_logradouro")->required(true)->label("Logradouro");
        $objForm->text("nr_numero")->required(true)->label("Número");
        $objForm->text("nm_complemento")->required(true)->label("Complemento");
        $objForm->text("nm_bairro")->required(true)->label("Bairro");
        $objForm->cep("nr_cep")->required(true)->label("Cep");

        $objForm->combo("id_estado", '\Estado\Service\EstadoService', 'id', 'nm_estado')->required(true)->label("Estado");
        $objForm->combo("id_cidade", '\Cidade\Service\CidadeService', 'id', 'nm_cidade', 'fetchAllEstado', ['id_estado' => NULL])->required(true)->label("Cidade");

        $objForm->combo("id_banco", '\Banco\Service\BancoService', 'id', 'nm_banco')->required(true)->label("Banco");
        $objForm->text("nr_agencia")->required(true)->label("Agência");
        $objForm->text("nr_conta")->required(true)->label("Conta");
        $objForm->combo("id_tipo_conta", '\TipoConta\Service\TipoContaService', 'id', 'nm_tipo_conta')->required(true)->label("Tipo de conta");

        $objForm->combo("id_endereco", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Endereco");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
