<?php

namespace ResponsavelCatequizando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class ResponsavelCatequizandoForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('responsavelcatequizandoform');

        $this->inputFilter = new InputFilter();

        // CAMPOS DE FKS

        $objForm = new FormObject('responsavelcatequizandoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");

        ##############----BUSCANDO CAMPOS-- ####################
        $objForm->combo("id_catequizando", '\Catequizando\Service\CatequizandoService', 'id', 'nm_catequizando')->required(false)->label("Catequizando");
        $objForm->combo("id_responsavel", '\Responsavel\Service\ResponsavelService', 'id', 'nm_Responsavel')->required(false)->label("Responsável");
        $objForm->combo("id_grau_parentesco", '\GrauParentesco\Service\GrauParentescoService', 'id', 'nm_grau_parentesco')->required(false)->label("Grau de Parentesco");
        $objForm->combo("id_situacao_conjugal", '\SituacaoConjugal\Service\SituacaoConjugalService', 'id', 'ds_situacao_conjugal')->required(false)->label("Situaçao Conjugal");

        ########################################################

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
