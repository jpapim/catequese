<?php

namespace EsqueciSenha\Entity;

use Estrutura\Service\AbstractEstruturaService;

class EsqueciSenhaEntity extends AbstractEstruturaService {

    protected $id;
    protected $id_usuario;
    protected $tx_identificacao;
    protected $id_situacao;
    protected $dt_solicitacao;
    protected $dt_alteracao;

}
