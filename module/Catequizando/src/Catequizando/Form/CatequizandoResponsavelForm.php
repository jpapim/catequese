<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/10/2016
 * Time: 12:32
 */

namespace Catequizando\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

class CatequizandoResponsavelForm  extends  AbstractForm{

    public function __construct(){
        parent::__construct('catequizandoresponsavelform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('catequizandoresponsavelform',$this,$this->inputFilter);

        ### ID
        $objForm->hidden("id")->required(false)->label("ID");
        $objForm->hidden("id_catequizando")->required(false)->label("ID CATEQUIZANDO");

        $objForm->text("id_responsavel")->required(true)->label("Responsável");
        $objForm->combo('id_grau_parentesco','\GrauParentesco\Service\GrauParentescoService','id','nm_grau_parentesco')
            ->required(true)
            ->label('Grau de Parentesco');
        $objForm->combo('id_situacao_conjugal','\SituacaoConjugal\Service\SituacaoConjugalService','id','ds_situacao_conjugal')
            ->required(true)
            ->label('Situação Conjugal');

        //##############----BUSCANDO CAMPOS-- ####################

        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");
        $objForm->text("id_telefone_celular")->required(FALSE)->label("Telefone Celular");
        $objForm->text("id_telefone_residencial")->required(FALSE)->label("Telefone Residencial");

        $objForm->email("em_email")->required(true)->label("Email");
        $objForm->email("em_email_confirm")->required(true)->label("Confirme o Email")
            ->setAttribute('data-match', '#em_email')
            ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
        $objForm->combo('id_situacao','\Situacao\Service\SituacaoService','id','nm_situacao')->required(false)->label("Situação");
        # $objForm->combo("id_profissao", '\Profissao\Service\ProfissaoService', 'id', 'nm_profissao')->required(false)->label("Profissao");
        $objForm->combo("id_movimento_pastoral", '\MovimentoPastoral\Service\MovimentoPastoralService', 'id', 'nm_movimento_pastoral')->required(false)->label("Movimento Pastoral");
        $objForm->combo("id_profissao", '\Profissao\Service\ProfissaoService', 'id', 'nm_profissao')->required(false)->label("Profissao");

        //#########################################################################################

////CAMPOS DA TABELA

        $objForm->text("nm_responsavel")->required(true)->label("Nome Completo");
        $objForm->textarea("tx_observacao")->required(true)->label("Observação");
        $objForm->text("cs_participa_movimento_pastoral")->required(true)->label("Participa de Movimento Pastoral");


        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 