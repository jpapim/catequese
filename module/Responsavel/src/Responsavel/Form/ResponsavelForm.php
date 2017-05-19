<?php

namespace Responsavel\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class ResponsavelForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('responsavelform');

        $this->inputFilter = new InputFilter();

        // CAMPOS DE FKS

        $objForm = new FormObject('responsavelform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        //##############----BUSCANDO CAMPOS-- ####################

        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(true)->label("*Sexo");

        $objForm->email("em_email")->required(false)->label("*E-mail");
        $objForm->email("em_email_confirm")->required(false)->label("*Confirme o E-mail")
            ->setAttribute('data-match', '#em_email')
            ->setAttribute('data-match-error', 'E-mails não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
        $objForm->combo('id_situacao', '\Situacao\Service\SituacaoService', 'id', 'nm_situacao')->required(false)->label("Situação");
        $objForm->combo("id_profissao", '\Profissao\Service\ProfissaoService', 'id', 'nm_profissao')->required(false)->label("Profissão");
        $objForm->combo("id_movimento_pastoral", '\MovimentoPastoral\Service\MovimentoPastoralService', 'id', 'nm_movimento_pastoral')->required(false)->label("*Movimento Pastoral");

        //#########################################################################################

        // Campo  participante do Movimento Pastoral
        $objForm->radio("cs_participa_movimento_pastoral", ['S' => 'Sim', 'N' => 'Não'])
            ->setAttribute('style', ' text-transform: uppercase')
            ->required(false)
            ->label("* Participa de Movimento Pastoral");

        ////CAMPOS DA TABELA

        $objForm->text("nm_responsavel")->required(true)->label("*Nome Completo");
        $objForm->textarea("tx_observacao")->required(false)->label("Observação");


        //Campo de TELEFONE RESIDENCIAL E TELEFONE CELULAR
        $objForm->telefone("id_telefone_residencial")->setAttribute('class', 'telefone')->required(false)->label("Telefone Residencial");
        $objForm->text("id_telefone_celular")->setAttribute('class', 'celular')->required(false)->label("Telefone Celular");


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
