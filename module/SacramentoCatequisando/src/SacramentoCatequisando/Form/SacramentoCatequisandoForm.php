<?php

namespace SacramentoCatequisando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SacramentoCatequisandoForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('sacramentocatequisandoform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('sacramentocatequisandoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("id_catequisando", '\Catequisando\Service\CatequisandoService', 'id', 'nm_catequisando')->required(false)->label("Catequizando");
        $objForm->combo("id_sacramento", '\Sacramento\Service\SacramentoService', 'id', 'nm_sacramento')->required(false)->label("Sacramento");
        $objForm->combo("id_paroquia", '\Paroquia\Service\ParoquiaService', 'id', 'nm_paroquia')->required(false)->label("Paróquia");

        $arrOpcoes[] = array('value' => '', 'label' => '');
        $arrOpcoes[] = array('value' => 'S', 'label' => 'Sim');
        $arrOpcoes[] = array('value' => 'N', 'label' => 'Nao');
        $objForm->select("cs_comprovante_batismo", $arrOpcoes)->required(false)->label("Comprovante de Batismo");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
