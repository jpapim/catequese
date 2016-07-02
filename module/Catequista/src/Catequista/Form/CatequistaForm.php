<?php

namespace Catequista\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class CatequistaForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('catequistaform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('catequistaform',$this,$this->inputFilter);
       $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 
       $objForm->combo("id_usuario", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuario");
       $objForm->combo("id_cidade", '\Cidade\Service\CidadeService', 'id', 'nm_cidade')->required(false)->label("Cidade");
       $objForm->combo("id_endereco", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Endereco");
       $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");
       //$objForm->text("id_naturalidade")->required(false)->label("Nome completo");
       $objForm->email("em_email")->required(true)->label("Email");
            $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
                ->setAttribute('data-match', '#em_email')
                ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
        $objForm->combo('id_situacao','\Situacao\Service\SituacaoService','id','nm_situacao')->required(false)->label("Situacao");      
       
        // $objForm->text("id_telefone_residencial")->required(false)->label("Nome completo");
       // $objForm->text("id_telefone_celular")->required(false)->label("Nome completo");
      //######################################################################################### 
  
////CAMPOS DA TABELA

           $objForm->text("nm_catequista")->required(true)->label("Nome completo");
           $objForm->text("nr_matricula")->required(true)->label("numero matricula");
           $objForm->date("dt_nascimento")->required(true)->label("Data de nascimento");
           $objForm->date("dt_ingresso")->required(true)->label("Data de ingresso");
           $objForm->textarea("tx_observacao")->required(true)->label("observacao");
           $objForm->text("ds_situacao")->required(true)->label("Descricao da situacao");
           $objForm->text("cs_coordenador")->required(true)->label("cs cordenador");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
