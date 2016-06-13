<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:53
 */

namespace PeriodoLetivo\Entity;


use Estrutura\Service\AbstractEstruturaService;

class PeriodoLetivoEntity extends AbstractEstruturaService {

        protected $id;
        protected $dt_inicio;
        protected $dt_fim;
        protected $dt_ano_letivo;
} 