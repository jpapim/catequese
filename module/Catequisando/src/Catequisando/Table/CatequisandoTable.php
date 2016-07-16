<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:45
 */

namespace Catequisando\Table;


use Estrutura\Table\AbstractEstruturaTable;

class CatequisandoTable  extends  AbstractEstruturaTable{

    public $table="catequisando";
    public $campos=[
        'id_catequisando'=>'id',
        'id_endereco'=>'id_endereco',
        'id_sexo'=>'id_sexo',
        'id_naturalidade'=>'id_naturalidade',
        'id_telefone_residencial'=>'id_telefone_residencial',
        'id_telefone_celular'=>'id_telefone_celular',
        'id_email'=>'id_email',
       'id_situacao'=>'id_situacao',
        'id_turno'=>'id_turno',
        'id_movimento_pastoral'=>'id_movimento_pastoral',
       'nm_catequisandonr_matricula'=>'nm_catequisandonr_matricula',
        'dt_nascimento'=>'dt_nascimento',
        'dt_ingresso'=>'dt_ingresso',
       'tx_observacao'=>'tx_observacao',
        'ds_situacao'=>'ds_situacao',
        'cs_necessidade_especial'=>'cs_necessidade_especial',
        'nm_necessidade_especial'=>'nm_necessidade_especial',
        'cs_estudante'=>'cs_estudante',
        'cs_participa_movimento_pastoral'=>'cs_participa_movimento_pastoral',
    ];
} 