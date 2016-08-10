<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:45
 */

namespace Catequisando\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Etapa\Service\EtapaService;
use Sacramento\Service\SacramentoService;
use Zend\InputFilter\InputFilter;

class CatequisandoForm extends  AbstractForm{

    public function __construct(){
        parent::__construct('catequisandoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('catequisandoform',$this,$this->inputFilter);

        ### ID
        $objForm->hidden("id")->required(false)->label("Id");
        ##### Endereço ######
        $objForm->hidden("id_endereco")->required(false);
        $objForm->text("nm_logradouro")->required(false)->label("Logradouro");
        $objForm->text("nr_numero")->required(true)->label("Número");
        $objForm->text("nm_complemento")->required(true)->label("Complemento");
        $objForm->text("nm_bairro")->required(true)->label("Bairro");
        $objForm->cep("nr_cep")->required(true)->label("Cep");

        #FK - Naturalidade
        $objForm->text("id_naturalidade")->required(false)->label("Naturalidade");

        #FK - Cidades
        $objForm->text("id_cidade")->required(false)->label("Cidade");

        #FK - Sexo
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(false)->label("Sexo");

        #FK- Telefone Residencial
        $objForm->telefone("id_telefone_residencial")->required(false)->label("Telefone Residencial");

        #FK- Telefone Celular
        $objForm->telefone("id_telefone_celular")->required(false)->label("Telefone Celular");

        # SACRAMENTOS #
        #Resgatando as informações da tabela sacaramento
        #
        $oSacramento =  new SacramentoService();
        $colecaoSacramento = $oSacramento->fetchAll();
        $arrSacramentos=[];

        foreach($colecaoSacramento as $key => $obSacramento){
            $arrSacramentos[]=[
                'value'=>$obSacramento->getId(),
                'name'=>'sacramento',
                'label'=>$obSacramento->getNmSacramento(),
            ];
        }
        $objForm->multicheckbox('arrSacramento', $arrSacramentos)->required(false)->label('Sacramentos que já recebeu');

        # ETAPA #
        #Resgatando as informações da tabela sacramento
        #

        $obEtapa =  new EtapaService();
        $colecaoEtapa = $obEtapa->fetchAll();
        $arrEtapa=[];

        foreach($colecaoEtapa as $key => $etapa){
            $arrEtapa[]=[
                'value'=>$etapa->getId(),
                'name'=>'etapa['.$etapa->getId().']',
                'label'=>$etapa->getNmEtapa(),
            ];
        }
        $objForm->multicheckbox('arrEtapa', $arrEtapa)->required(false)->label('Etapas já frequentadas');



        #FK- Email
        $objForm->hidden("id_email")->required(false);
        $objForm->email("em_email")->required(true)->label("Email");
        $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
            ->setAttribute('data-match', '#em_email')
            ->setAttribute('data-match-error', 'Email não correspondem');

        ### Nome do Catequizando
        $objForm->text("nm_catequisando")->required(true)->label("Nome");
        ### Data de Nascimento
        $objForm->date("dt_nascimento")->required(true)->setAttribute('class', 'data')->label("Data de nascimento");

        ### Matricula
        $objForm->text("nm_matricula")
            ->required(false)
            ->label("Matricula");

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
            ->label("Possui necessidade especial?");

        ### [Radio] Estudante
        $objForm->radio("cs_estudante",['S'=>'Sim','N'=>'Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Inscrito Estuda?");

        ### [Radio] Participante de Movimento Pastoral
        $objForm->radio("cs_participa_movimento_pastoral",['S'=>'Sim','N'=>'Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Participante do Movimento Pastoral");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 