<?php

namespace Check\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class CheckForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('controllerform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('controllerform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->combo("id_perfil", '\Perfil\Service\PerfilService','id','nm_perfil')->required(false)->label("Selecionar Perfil");

        $objForm->combo("id_modulo", '\Controller\Service\ControllerService','id','nm_controller')->required(false)->label("Selecione o Modulo");

        ###################################################################
        #Recuperando Todos os Dados das Gradua�oes
        #$controller = new \Controller\Service\ControllerService();
        #$arrController = $controller->fetchAll()->toArray();

        #$arrControllerTratado = array();
        #foreach($arrController as $valor){
        #    $arrControllerTratado[] = array('value'=>$valor['id_controller'], 'label'=>$valor['nm_controller']);
        #}
        #$objForm->checkbox('id_controller', $arrControllerTratado)->required(false)->label("Controller");
        $objForm->checkbox('id_action', array(array('value'=>'', 'label'=>'')) )->required(false)->label("Actions");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}