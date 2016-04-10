<?php

namespace Atleta\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AtletaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('atletaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('atletaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrador");

        $objForm->text("id_academia")->required(true)->label("Academia");
        $objForm->text("nm_atleta")->required(true)->label("Atleta");
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(true)->label("Sexo");

        ###################################################################
        #Recuperando Todos os Dados das Graduaçoes
        $graduacao = new \Graduacao\Service\GraduacaoService();
        $arrGraduacao = $graduacao->fetchAll()->toArray();
        $arrGraduacaoTratado = array();
        foreach($arrGraduacao as $valor){
            $arrGraduacaoTratado[]=array('value'=>$valor['id_graduacao'], 'label'=>'__'.$valor['nm_graduacao'].' -');
        }
        $objForm->radio('id_graduacao', $arrGraduacaoTratado)->required(false)->label("Graduaçao");

        $objForm->text("nr_peso")->required(true)->label("Peso");
        $objForm->date("dt_nascimento")->required(true)->setAttribute('class', 'data')->label("Data de nascimento");
        $objForm->text("id_cidade")->required(false)->label("Cidade");
        $objForm->text("tx_endereco")->required(false)->label("Endereço");
        $objForm->text("tx_complemento")->required(false)->label("Complemento");
        $objForm->cep("nr_cep")->required(false)->setAttribute('class', 'cep')->label("CEP");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}