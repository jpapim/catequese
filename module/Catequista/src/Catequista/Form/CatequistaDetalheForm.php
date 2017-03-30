<?php

namespace Catequista\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Etapa\Service\EtapaService;
use Zend\InputFilter\InputFilter;



class CatequistaDetalheForm extends AbstractForm {

    public function __construct($options = []) {
        parent::__construct('catequistaDetalheform');

             $this->inputFilter = new InputFilter();
             
             // CAMPOS DE FKS
             
       $objForm = new FormObject('catequistadetalheform',$this,$this->inputFilter);
      $objForm->hidden("id")->required(false)->label("Id");
      //##############----BUSCANDO CAMPOS-- #################### 
       $objForm->combo("id_usuario", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(false)->label("Usuario");
       $objForm->combo("id_cidade", '\Cidade\Service\CidadeService', 'id', 'nm_cidade')->required(false)->label("Cidade");
       $objForm->combo("id_endereco", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Endereco");
       $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");
      
       
        $objForm->combo('id_situacao','\Situacao\Service\SituacaoService','id','nm_situacao')->required(false)->label("Situacao");      
       $objForm->combo("id_detalhe_formacao", '\DetalheFormacao\Service\DetalheFormacaoService', 'id', 'id_detalhe_formacao')->required(false)->label("Formação Acadêmica");
       
#FK- Email
        $objForm->hidden("id_email")->required(false);
        $objForm->text("em_email")->required(true)->label("*Email");
        $objForm->text("em_email_confirm")->required(false)->label("*Confirme o email");
           
##### Endereço ######
   
        $objForm->hidden("id_endereco")->required(false);
        $objForm->text("nm_logradouro")->required(false)->label("*Endereço");
        $objForm->text("nr_numero")->required(false)->label("Número");
        $objForm->text("nm_complemento")->required(false)->label("Complemento");
        $objForm->text("nm_bairro")->required(false)->label("Bairro");
        $objForm->cep("nr_cep")->setAttribute('class', 'cep')->required(true)->label("*Cep");
        #FK - Cidade de Origem
        $objForm->text("nm_naturalidade")->required(false)->label("*Cidade de Origem");
        $objForm->text("id_naturalidade")->required(false)->label("*Cidade de Origem");
        #FK - Cidades
        $objForm->text("nm_cidade")->required(false)->label("*Cidade Atual");
        
        
        #FK- Telefone Residencial
        $objForm->hidden("id_telefone_residencial")->required(false);
        $objForm->telefone("telefone_residencial")->setAttribute('class', 'telefone')->required(false)->label("*Telefone Residencial");
        #FK- Telefone Celular
        $objForm->text("telefone_celular")->setAttribute('class', 'celular')->required(false)->label("*Telefone Celular");
        $objForm->hidden("id_telefone_celular")->required(false);
      
        # ETAPA #
        #Resgatando as informações da tabela etapa
        #
        $obEtapa =  new EtapaService();
        $colecaoEtapa = $obEtapa->fetchAll();
        $arrEtapa=[];
        if(isset($options['arrEtapa']) && $options['arrEtapa']){
            foreach($colecaoEtapa as $key => $etapa){
                $arrEtapa[]=[
                    'value'=>$etapa->getId(),
                    'name'=>'etapa['.$etapa->getId().']',
                    'label'=>$etapa->getNmEtapa(),
                    'selected'=>in_array($etapa->getId(),$options['arrEtapa'])? true: false,
                ];
            }
        }else{
            foreach($colecaoEtapa as $key => $etapa){
                $arrEtapa[]=[
                    'value'=>$etapa->getId(),
                    'name'=>'etapa['.$etapa->getId().']',
                    'label'=>$etapa->getNmEtapa(),
                ];
            }
        }
        $objForm->multicheckbox('arrEtapa', $arrEtapa)->required(false)->label('Etapas que já Atuou');
        
 $objForm->multicheckbox('arrEtapa', $arrEtapa)->required(false)->label('Etapas que já Atuou');
        
        $objForm->radio("cs_coordenador",['S'=>'Sim','N'=>'Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Exerce função de Coordenador?");
////CAMPOS DA TABELA
          
           $objForm->text("nm_catequista")->required(true)->label("*Nome completo");
           $objForm->text("nr_matricula")->required(true)->label("*Nº matrícula (até 6 digitos)");
           $objForm->date("dt_nascimento")->setAttribute('class', 'data')->required(true)->label("*Data de nascimento");
           $objForm->date("dt_ingresso")->setAttribute('class', 'data')->required(true)->label("*Data de ingresso");
           $objForm->textarea("tx_observacao")->required(true)->label("observacao");
           $objForm->textarea("ds_situacao")->required(false)->label("Descricao da situacao");
          
           $objForm->hidden("id_perfil" )->required(true)->label("perfil");
           $objForm->hidden("id_tipo_usuario")->required(true)->label("tp usuario");
           $objForm->hidden("id_situacao_usuario")->required(true)->label("situa usuario");
           $objForm->text("nm_usuario")->required(false)->label("*Usuário (seu email)");
           $objForm->password("pw_a_senha")->required(false)->label("*Senha Atual");
           $objForm->password("pw_senha")->required(false)->label("*Nova Senha (Mínimo 8 digitos)");
           
           $objForm->password("pw_senha_confirm")->required(false)->label("*Confirmar senha")
                ->setAttribute('data-match', '#pw_senha')
                ->setAttribute('data-match-error', 'Senhas não correspondem');
       
        
           
           $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
