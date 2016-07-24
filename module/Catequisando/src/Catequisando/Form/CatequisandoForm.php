<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:45
 */

namespace Catequisando\Form;


use Endereco\Form\EnderecoForm;
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

        $objForm->hidden("id")->required(false)->label("Id");

        ##### Endereço ######
        $objForm->combo("nm_logradouro", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Logradouro");
        $objForm->text("nr_numero")->required(true)->label("Número");
        $objForm->text("nm_complemento")->required(true)->label("Complemento");
        $objForm->text("nm_bairro")->required(true)->label("Bairro");
        $objForm->cep("nr_cep")->required(true)->label("Cep");

        #FK - Cidades
        $objForm->text("id_cidade")->required(false)->label("Cidade");

        #FK - Sexo
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");

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
        $objForm->multicheckbox('sacramento', $arrSacramentos)->required(false)->label('Sacramesntos que já recebeu');

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
        $objForm->multicheckbox('etapa', $arrEtapa)->required(false)->label('Etapas já frequentadas');


        #FK- Email
        $objForm->email("em_email")->required(true)->label("Email");
        $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
            ->setAttribute('data-match', '#em_email')
            ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");

            $objForm->text("nm_catequisando")
            ->setAttribute('maxlength','150')
            ->required(true)->label("Nome");
        $objForm->date("dt_nascimento")->required(true)->setAttribute('class', 'data')->label("Data de nascimento");

        $objForm->text("nm_matricula")
            ->setAttribute('maxlength','8')
            ->required(true)
            ->label("Matricula");

        $objForm->textarea("tx_observacao")
            ->required(false)
            ->label("Observações");

        $objForm->text("ds_situacao")->required(false)->label("Descrição Situacao");

        $objForm->radio("cs_necessidade_especial",['Sim','Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Possui necessidade especial?");

        $objForm->text("nm_necessidade_especial")->required(false)->label("Necessidade Especial");

        $objForm->radio("cs_estudante",['Sim','Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Inscrito Estuda?");

        $objForm->radio("cs_participante_movimento_pastoral",['S'=>'Sim','N'=>'Não'])
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