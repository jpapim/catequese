<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:45
 */

namespace Catequizando\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Etapa\Service\EtapaService;
use Sacramento\Service\SacramentoService;
use Zend\InputFilter\InputFilter;

class CatequizandoForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('catequizandoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('catequizandoform',$this,$this->inputFilter);

        ### ID
        $objForm->hidden("id")->required(false)->label("Id");
        ##### Endereço ######
        $objForm->hidden("id_endereco")->required(false);
        $objForm->text("nm_logradouro")->required(true)->label("*Logradouro");
        $objForm->text("nr_numero")->required(false)->label("Número");
        $objForm->text("nm_complemento")->required(false)->label("Complemento");
        $objForm->text("nm_bairro")->required(true)->label("*Bairro");
        $objForm->cep("nr_cep")->setAttribute('class', 'cep')->required(false)->label("*Cep");

        #FK - Naturalidade
        $objForm->hidden("id_naturalidade")->required(false);
        $objForm->text("nm_naturalidade")->required(false)->label("*Naturalidade");

        #FK - Cidades
        $objForm->text("nm_cidade")->required(true)->label("*Cidade onde Reside");

        #FK - Sexo
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(true)->label("*Sexo");

        #FK- Telefone Residencial
        $objForm->telefone("id_telefone_residencial")->setAttribute('class', 'telefone')->required(true)->label("*Telefone Residencial");

        #FK- Telefone Celular
        $objForm->text("id_telefone_celular")->setAttribute('class', 'celular')->required(false)->label("Telefone Celular");

        # SACRAMENTOS #
        #Resgatando as informações da tabela sacaramento
        #
        $oSacramento =  new SacramentoService();
        $colecaoSacramento = $oSacramento->fetchAll();
        $arrSacramentos=[];

        if(isset($options['arrSacramento']) && $options['arrSacramento']){
            foreach($colecaoSacramento as $key => $obSacramento){
                $arrSacramentos[]=[
                    'value'=>$obSacramento->getId(),
                    'name'=>'sacramento',
                    'label'=>$obSacramento->getNmSacramento(),
                    'selected'=>in_array($obSacramento->getId(),$options['arrSacramento'])? true: false,
                ];
            }

        }else{

            foreach($colecaoSacramento as $key => $obSacramento){
                $arrSacramentos[]=[
                    'value'=>$obSacramento->getId(),
                    'name'=>'sacramento',
                    'label'=>$obSacramento->getNmSacramento(),

                ];
            }
        }



        $objForm->multicheckbox('arrSacramento', $arrSacramentos)->required(false)->label('*Sacramentos que já recebeu');

        # ETAPA #
        #Resgatando as informações da tabela sacramento
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

        $objForm->multicheckbox('arrEtapa', $arrEtapa)->required(false)->label('*Etapas já frequentadas');



        #FK- Email
        $objForm->hidden("id_email")->required(false);
        $objForm->email("em_email")->required(true)->label("*E-mail");
        $objForm->email("em_email_confirm")->required(true)->label("*Confirme o e-mail")
            ->setAttribute('data-match', '#em_email')
            ->setAttribute('data-match-error', 'E-mails não correspondem');

        ### Nome do Catequizando
        $objForm->text("nm_catequizando")->required(true)->label("*Nome");
        ### Data de Nascimento
        $objForm->date("dt_nascimento")->required(true)->setAttribute('class', 'data')->label("*Data de nascimento");

        ### Matricula
        $objForm->text("nm_matricula")
            ->required(false)
            ->label("Matricula");

        ### Necessidade Especial
        $objForm->text("nm_necessidade_especial")
            ->required(false)
            ->label("Necessidade Especial");

        ### Observação
        $objForm->textarea("tx_observacao")
            ->required(false)
            ->label("Observações");

        # ID SITUACAO
        $objForm->hidden("id_situacao")->required(false);
        $objForm->text("ds_situacao")->required(false)->label("Descrição Situacao");

        ### [Radio] Necessidade Especial
        $objForm->radio("cs_necessidade_especial",['S'=>'Sim','N'=>'Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("*Possui necessidade especial?");

        ### [Radio] Estudante
        $objForm->radio("cs_estudante",['S'=>'Sim','N'=>'Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("*Inscrito Estuda?");

        ### [Radio] Participante de Movimento Pastoral
        $objForm->radio("cs_participa_movimento_pastoral",['S'=>'Sim','N'=>'Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("*Participante do Movimento Pastoral?");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 