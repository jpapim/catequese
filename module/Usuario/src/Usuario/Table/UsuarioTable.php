<?php

namespace Usuario\Table;

use Estrutura\Table\AbstractEstruturaTable;

class UsuarioTable extends AbstractEstruturaTable{

    public $table = 'usuario';
    public $campos = [
        'id_usuario'=>'id', 
        'nm_usuario'=>'nm_usuario', 
        'dt_nascimento'=>'dt_nascimento', 
        'nu_rg'=>'nu_rg', 
        'nu_cpf'=>'nu_cpf', 
        'nm_profissao'=>'nm_profissao', 
        'nm_nacionalidade'=>'nm_nacionalidade', 
        'id_sexo'=>'id_sexo', 
        'id_estado_civil'=>'id_estado_civil', 
        'id_tipo_usuario'=>'id_tipo_usuario', 
        'id_situacao_usuario'=>'id_situacao_usuario', 
        'id_email'=>'id_email', 
        'id_telefone'=>'id_telefone', 
        'id_endereco'=>'id_endereco', 
        

    ];

}