<?php

namespace ResponsavelCatequisando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class ResponsavelCatequisandoForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('responsavelcatequisandoform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('responsavelcatequisandoform',$this,$this->inputFilter);
       $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 
     
#MODULOS  AINDA NAO IMPLEMENTADOS 
//  $objForm->combo("id_responsavel", '\Responsavel\Service\ResponsavelService', 'id', 'nm_Responsavel')->required(false)->label("Responsavel");   
 // $objForm->combo("id_catequisando", '\Catequisando\Service\CatequisandoService', 'id', 'nm_catequisando')->required(false)->label("catequisando");
      
       
       $objForm->combo("id_grau_parentesco", '\GrauParentesco\Service\GrauParentescoService', 'id', 'nm_grau_parentesco')->required(false)->label("Grau Parentesco");
       
  
      //######################################################################################### 
  

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
