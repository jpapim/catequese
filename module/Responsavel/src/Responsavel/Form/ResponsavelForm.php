<?php

namespace Responsavel\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class ResponsavelForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('responsavelform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('responsavelform',$this,$this->inputFilter);
       $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 

       $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");
    # $objForm->combo("id_telefone_celular", '\TelefoneCelular\Service\TelefoneCelularService', 'id', 'nm_telefone_celular')->required(FALSE)->label("Fone Cel");
      #$objForm->combo("id_telefone_residencial", '\TelefoneResidencial\Service\TelefoneResidencialService', 'id', 'nm_telefone_residencial')->required(FALSE)->label("Fone Cel");  
     
     $objForm->email("em_email")->required(true)->label("Email");
            $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
                ->setAttribute('data-match', '#em_email')
                ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
        $objForm->combo('id_situacao','\Situacao\Service\SituacaoService','id','nm_situacao')->required(false)->label("Situacao");      
      # $objForm->combo("id_profissao", '\Profissao\Service\ProfissaoService', 'id', 'nm_profissao')->required(false)->label("Profissao");
      $objForm->combo("id_movimento_pastoral", '\MovimentoPastoral\Service\MovimentoPastoralService', 'id', 'nm_movimento_pastoral')->required(false)->label("MovimentoPastoral");  
     
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
