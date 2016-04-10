<?php

namespace Endereco\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EnderecoTable extends AbstractEstruturaTable{

    public $table = 'endereco';
    public $campos = [
        'id_endereco'=>'id', 
        'nm_logradouro'=>'nm_logradouro', 
        'nr_numero'=>'nr_numero', 
        'nm_complemento'=>'nm_complemento', 
        'nm_bairro'=>'nm_bairro', 
        'nr_cep'=>'nr_cep', 
        'id_cidade'=>'id_cidade', 

    ];

}