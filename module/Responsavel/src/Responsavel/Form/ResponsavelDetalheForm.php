<?php

namespace Responsavel\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class ResponsavelDetalheForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('responsavelDetalheform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('responsaveldetalheform',$this,$this->inputFilter);
       $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 

       $objForm->hidden("id_sexo")->required(false)->label("Sexo");
    # $objForm->combo("id_telefone_celular", '\TelefoneCelular\Service\TelefoneCelularService', 'id', 'nm_telefone_celular')->required(FALSE)->label("Fone Cel");
      #$objForm->combo("id_telefone_residencial", '\TelefoneResidencial\Service\TelefoneResidencialService', 'id', 'nm_telefone_residencial')->required(FALSE)->label("Fone Cel");
     
    
       $objForm->hidden("id_email")->required(false)->label("Id");
        $objForm->hidden('id_situacao')->required(false)->label("Situacao");
      # $objForm->combo("id_profissao", '\Profissao\Service\ProfissaoService', 'id', 'nm_profissao')->required(false)->label("Profissao");
      $objForm->hidden("id_movimento_pastoral")->required(false)->label("MovimentoPastoral");  
     
        //######################################################################################### 
  
////CAMPOS DA TABELA

           $objForm->text("nm_responsavel")->required(true)->label("Nome completo");
           $objForm->textarea("tx_observacao")->required(true)->label("observacao"); 
           $objForm->text("cs_participa_movimento_pastoral")->required(true)->label("Participa de Movimento Pastoral");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}