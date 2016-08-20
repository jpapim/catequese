<?php

namespace Catequista\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class CatequistaDetalheForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('catequistaDetalheform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('catequistadetalheform',$this,$this->inputFilter);
       $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 
       $objForm->hidden("id_usuario")->required(false)->label("Usuario");
       $objForm->hidden("id_cidade")->required(false)->label("Cidade");
       $objForm->hidden("id_endereco")->required(false)->label("Endereco");
       $objForm->hidden("id_sexo")->required(FALSE)->label("Sexo");
       //$objForm->hidden("id_naturalidade")->required(false)->label("Nome completo");
      
        $objForm->hidden("id_email")->required(false)->label("Email");
        $objForm->hidden('id_situacao')->required(false)->label("Situacao");      
       
        // $objForm->text("id_telefone_residencial")->required(false)->label("Nome completo");
       // $objForm->text("id_telefone_celular")->required(false)->label("Nome completo");
      //######################################################################################### 
  
////CAMPOS DA TABELA

           $objForm->hidden("nm_catequista")->required(true)->label("Nome completo");
           $objForm->hidden("nr_matricula")->required(true)->label("numero matricula");
           $objForm->date("dt_nascimento")->required(true)->label("Data de nascimento");
           $objForm->date("dt_ingresso")->required(true)->label("Data de ingresso");
           $objForm->hidden("tx_observacao")->required(true)->label("observacao");
           $objForm->hidden("ds_situacao")->required(true)->label("Descricao da situacao");
           $objForm->hidden("cs_coordenador")->required(true)->label("cs cordenador");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
