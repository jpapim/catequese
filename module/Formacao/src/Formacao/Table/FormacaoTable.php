<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 30/06/2016
 * Time: 21:53
 */

namespace Formacao\Table;


use Estrutura\Table\AbstractEstruturaTable;

class FormacaoTable  extends  AbstractEstruturaTable{
        public $table ='formacao';
        public $campos =[
            'id_formacao'=>'id',
            'nm_formacao'=>'nm_formacao'
        ];
} 