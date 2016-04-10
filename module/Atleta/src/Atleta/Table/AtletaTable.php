<?php

namespace Atleta\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AtletaTable extends AbstractEstruturaTable{

    public $table = 'atleta';
    public $campos = [
        'id_atleta'=>'id', 
        'nm_atleta'=>'nm_atleta',
        'id_sexo'=>'id_sexo',
        'id_graduacao'=>'id_graduacao',
        'nr_peso'=>'nr_peso',
        'dt_nascimento'=>'dt_nascimento',
        'id_academia'=>'id_academia',
        'id_cidade'=>'id_cidade',
        'tx_endereco'=>'tx_endereco',
        'tx_complemento'=>'tx_complemento',
        'nr_cep'=>'nr_cep',
        'id_usuario'=>'id_usuario',
        'id_usuario_cadastro'=>'id_usuario_cadastro'
    ];

}