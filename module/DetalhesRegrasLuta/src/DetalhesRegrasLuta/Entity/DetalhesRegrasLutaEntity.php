<?php

namespace DetalhesRegrasLuta\Entity;

use Estrutura\Service\AbstractEstruturaService;

class DetalhesRegrasLutaEntity extends AbstractEstruturaService{
        protected $id;
        protected $id_regra_luta;
        protected $id_categoria_idade;
        protected $id_categoria_peso;
        protected $id_usuario_cadastro;
        protected $id_graduacao_inicial;
        protected $id_graduacao_final;
        protected $nr_idade_inicial;
        protected $nr_idade_final;
        protected $nr_peso_inicial;
        protected $nr_peso_final;
        protected $id_sexo;
}