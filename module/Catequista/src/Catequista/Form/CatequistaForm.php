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
       // $objForm->text("id_usuario")->required(false)->label("Nome completo");
       // $objForm->text("id_endereco")->required(false)->label("Nome completo");
    // $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");
       // $objForm->text("id_naturalidade")->required(false)->label("Nome completo");
       // $objForm->text("id_telefone_residencial")->required(false)->label("Nome completo");
       // $objForm->text("id_telefone_celular")->required(false)->label("Nome completo");
        //$objForm->text("id_email")->required(false)->label("Nome completo");
       // $objForm->text("id_situacao")->required(false)->label("Nome completo");
       // $objForm->text("id_detalhe_formação")->required(false)->label("Nome completo");


////CAMPOS DA TABELA

       
       
          // $objForm->text("nm_catequista")->required(true)->label("Nome completo");
          // $objForm->text("nr_matricula")->required(true)->label("numero matricula");
         
           
            $objForm->email("em_email")->required(true)->label("Email");
        $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
                ->setAttribute('data-match', '#em_email')
                ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
           
           $objForm->date("dt_nascimento")->required(true)->label("Data de nascimento");
          // $objForm->date("dt_ingresso")->required(true)->label("Data de ingresso");
          // $objForm->textarea("tx_observacao")->required(true)->label("observacao");
          // $objForm->text("ds_situacao")->required(true)->label("Descricao da situacao");
           //$objForm->text("cs_cordenador")->required(true)->label("cs cordenador");

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
