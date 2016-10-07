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
        $objForm->number("nu_rg", 20)->required(false)->label("RG");
        $objForm->cpf("nu_cpf")->required(false)->label("CPF");
        $objForm->email("em_email")->required(true)->label("E-mail");
        $objForm->text("nm_profissao")->required(false)->label("Profissão");
        $objForm->text("nm_nacionalidade")->required(false)->label("Nacionalidade");
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(true)->label("Sexo");
        $objForm->combo("id_estado_civil", '\EstadoCivil\Service\EstadoCivilService', 'id', 'nm_estado_civil')->required(false)->label("EstadoCivil");
        $objForm->telefone("nr_telefone")->required(true)->label("Telefone");
        $objForm->telefone("id_telefone", '\Telefone\Service\TelefoneService', 'id', 'nr_telefone')->required(false)->label("Telefone");

        $objForm->text("nm_logradouro")->required(false)->label("Logradouro");
        $objForm->text("nr_numero")->required(false)->label("Número");
        $objForm->text("nm_complemento")->required(false)->label("Complemento");
        $objForm->text("nm_bairro")->required(false)->label("Bairro");
        $objForm->cep("nr_cep")->required(false)->label("Cep");

        $objForm->combo("id_estado", '\Estado\Service\EstadoService', 'id', 'nm_estado')->required(false)->label("Estado");
        $objForm->combo("id_cidade", '\Cidade\Service\CidadeService', 'id', 'nm_cidade', 'fetchAllEstado', ['id_estado' => NULL])->required(false)->label("Cidade");

        $objForm->combo("id_banco", '\Banco\Service\BancoService', 'id', 'nm_banco')->required(false)->label("Banco");
        $objForm->text("nr_agencia")->required(false)->label("Agência");
        $objForm->text("nr_conta")->required(false)->label("Conta");
        $objForm->combo("id_tipo_conta", '\TipoConta\Service\TipoContaService', 'id', 'nm_tipo_conta')->required(false)->label("Tipo de conta");

        $objForm->combo("id_endereco", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Endereco");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
