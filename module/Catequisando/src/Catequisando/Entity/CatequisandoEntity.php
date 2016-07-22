<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:46
 */

namespace Catequisando\Entity;


use Estrutura\Service\AbstractEstruturaService;

class CatequisandoEntity extends  AbstractEstruturaService{

    protected $id_catequisando;
    protected $id_endereco;
    protected $id_sexo;
    protected $id_naturalidade;
    protected $id_telefone_residencial;
    protected $id_telefone_celular;
    protected  $id_email;
    protected  $id_situacao;
    protected  $id_turno;
    protected  $id_movimento_pastoral;
    protected  $nm_catequisando;
    protected  $nr_matricula;
    protected  $dt_nascimento;
    protected  $dt_ingresso;
    protected  $tx_observacao;
    protected  $ds_situacao;
    protected  $cs_necessidade_especial;
    protected  $nm_necessidade_especial;
    protected  $cs_estudante;
    protected  $cs_participa_movimento_pastoral;
} 