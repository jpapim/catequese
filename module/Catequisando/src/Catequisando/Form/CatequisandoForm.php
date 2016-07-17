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
use Zend\InputFilter\InputFilter;

class CatequisandoForm extends  AbstractForm{


    public function __construct(){
        parent::__construct('catequisandoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('catequisandoform',$this,$this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");

        #FK - Endereço ######################################################
        $objForm->combo("id_endereco", '\Endereco\Service\EnderecoService', 'id', 'nm_logradouro')->required(false)->label("Endereco");

        #FK - Sexo ######################################################
        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')->required(FALSE)->label("Sexo");

        #FK- Telefone Residencial #######################################
        $objForm->text("id_telefone_residencial")->required(false)->label("Telefone Residencial");
        #FK- Telefone Celular ###########################################
        $objForm->text("id_telefone_celular")->required(false)->label("Telefone Celular");

        #FK- Email#####################################################
        $objForm->email("em_email")->required(true)->label("Email");
        $objForm->email("em_email_confirm")->required(true)->label("Confirme o email")
            ->setAttribute('data-match', '#em_email')
            ->setAttribute('data-match-error', 'Email não correspondem');
        $objForm->combo("id_email", '\Email\Service\EmailService', 'id', 'em_email')->required(false)->label("Email");
        $objForm->combo('id_situacao','\Situacao\Service\SituacaoService','id','nm_situacao')->required(false)->label("Situacao");

      #FK -  Situacao
        $objForm->hidden("id_situacao")->required(false)->label("ID Situacao");
        #FK - Turno
        $objForm->hidden("id_turno")->required(false)->label("ID Turno");
        #FK- Movimento Pastoral
        $objForm->hidden("id_movimento_pastoral")->required(false)->label("ID Movimento Pastoral");

        $objForm->text("nm_catequisando")
            ->setAttribute('maxlength','150')
            ->required(true)->label("Nome");

        $objForm->date("dt_nascimento")->required(true)->setAttribute('class', 'data')->label("Data de nascimento");
        $objForm->hidden("dt_ingresso")->required(true)->setAttribute('class', 'data')->label("Data de Ingresso");

        $objForm->text("nm_matricula")
            ->setAttribute('maxlength','8')
            ->required(true)
            ->label("Matricula");

        $objForm->textarea("tx_observacao")
            ->setAttribute('maxlength','8')
            ->required(false)
            ->label("Observações");

        $objForm->text("ds_situacao")->required(false)->label("Descrição Situacao");

        $objForm->radio("cs_necessidade_especial",['Sim','Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Possui necessidade especial?
");

        $objForm->text("nm_necessidade_especial")->required(false)->label("Necessidade Especial");

        $objForm->radio("cs_estudante",['Sim','Não'])
            ->setAttribute('style',' text-transform: uppercase')
            ->required(true)
            ->label("Inscrito Estuda?");

        $objForm->checkbox("cs_participante_movimento_pastoral",['Sim','Não'], true)
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