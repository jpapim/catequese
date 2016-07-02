<?php

namespace TurmaCatequisando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class TurmaCatequisandoForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('turmacatequisandoform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('turmacatequisandoform',$this,$this->inputFilter);
       $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 
       $objForm->combo("id_turma", '\Turma\Service\TurmaService', 'id', 'nm_turma')->required(false)->label("Turma");
      
 #MODULO CATEQUISANDO AINDA NAO IMPLEMENTADO -> $objForm->combo("id_catequisando", '\Catequisando\Service\CatequisandoService', 'id', 'nm_catequisando')->required(false)->label("catequisando");
       $objForm->combo("id_usuario", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuario");
       $objForm->combo("id_periodo_letivo", '\PeriodoLetivo\Service\PeriodoLetivoService', 'id', 'dt_ano_letivo')->required(false)->label("Periodo Letivo");
  
      //######################################################################################### 
  
////CAMPOS DA TABELA

           $objForm->date("dt_cadastro")->required(true)->value(date('d-m-y'))->label("Data cadastro");          
           $objForm->textarea("cs_aprovado")->required(true)->label("Cs Aprovado");
           $objForm->text("ds_motivo_reprovacao")->required(true)->label("Motivo da Reprovação");
           $objForm->text("tx_observacoes")->required(true)->label("Observações");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
