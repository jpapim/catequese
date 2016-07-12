<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/07/2016
 * Time: 12:55
 */

namespace SituacaoConjugal\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SituacaoConjugalForm extends  AbstractForm {

    public function __construct()
    {
        parent::__construct('situacaoconjugalform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('situacaoconjugalform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("ds_situacao_conjugal")->required(false)->label("Situação Conjugal");

        $this->formObject = $objForm;
    }
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 