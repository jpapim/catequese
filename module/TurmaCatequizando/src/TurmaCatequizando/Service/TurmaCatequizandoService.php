<?php

namespace TurmaCatequizando\Service;

use TurmaCatequizando\Entity\TurmaCatequizandoEntity as Entity;

class TurmaCatequizandoService extends Entity {

 
    public function getTurmaCatequizando($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('turma_catequizando')
             
               ->join(
                        'turma', 'turma.id_turma = turma_catequizando.id_turma'
                )
                  ->join(
                        'catequizando', 'catequizando.id_catequizando = turma_catequizando.id_catequizando'
                )
                
                  ->join(
                        'usuario', 'usuario.id_usuario = turma_catequizando.id_usuario'
                )
                  ->join(
                        'periodo_letivo', 'periodo_letido.id_periodo_letivo = turma_catequizando.id_periodo_letivo'
                )
      
                ->where([
            'turma_catequizando.id_turma_catequizando = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}

      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_turma_catequizando ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('turma_catequizando')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_turma_catequizando', "%{$like}%")
                    ->or
                   ->like('dt_cadastro', "%{$like}%")
                    ->or
                   ->like('cs_aprovado', "%{$like}%")
                    ->or
                   ->like('cs_motivo_reprovacao', "%{$like}%")
                    ->or
                   ->like('tx_observacoes', "%{$like}%")
                   
                   
                   
                   ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \TurmaCatequizando\Entity\TurmaCatequizandoEntity());

        // criar um objeto adapter paginator
        $paginatorAdapter = new DbSelect(
                // nosso objeto select
                $select,
                // nosso adapter da tabela
                $this->getAdapter(),
                // nosso objeto base para ser populado
                $resultSet
        );

        // resultado da paginacao
        return (new Paginator($paginatorAdapter))
                        // pagina a ser buscada
                        ->setCurrentPageNumber((int) $pagina)
                        // quantidade de itens na página
                        ->setItemCountPerPage((int) $itensPagina)
                        ->setPageRange((int) $itensPaginacao);
    }

  
    public function getTurmaCatequizandoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequizando')->columns([
            'id_turma',
            'id_periodo_letivo',
            'nr_sala',
        ])->join('turma', 'turma.id_turma = turma_catequizando.id_turma', [
            'nm_turma'
        ])->join('periodo_letivo', 'periodo_letivo.id_periodo_letivo = turma_catequizando.id_periodo_letivo', [
            'dt_ano_letivo'
        ]);
        $select->quantifier('DISTINCT');
        $where = [
        ];

        if (!empty($filter)) {

            foreach ($filter as $key => $value) {

                if ($value) {

                    if (isset($camposFilter[$key]['mascara'])) {

                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }

                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
                }
            }
        }

        $select->where($where)->order(['id_turma_catequizando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    public function getTurmaCatequizandoInternoPaginator($id_turma=null, $id_periodo_letivo = null, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequizando')->columns([
            'id_turma_catequizando',
            'id_turma',
            'id_catequizando',
            'id_usuario',
            'id_periodo_letivo',
            'dt_cadastro',
            'cs_aprovado',
            'ds_motivo_reprovacao',
            'tx_observacoes',
        ])->join('turma', 'turma.id_turma = turma_catequizando.id_turma', [
            'nm_turma'
        ])->join('periodo_letivo', 'periodo_letivo.id_periodo_letivo = turma_catequizando.id_periodo_letivo', [
            'dt_ano_letivo'
        ])->join('catequizando', 'catequizando.id_catequizando = turma_catequizando.id_catequizando', [
            'nm_catequizando'
        ]);

        if(!empty($id_turma) && !empty($id_periodo_letivo)){
            $where = [
                 'turma_catequizando.id_turma'=>$id_turma,
                'turma_catequizando.id_periodo_letivo'=>$id_periodo_letivo,
            ];
        }else{
            $where = [
               
            ];
        }

        if (!empty($filter)) {

            foreach ($filter as $key => $value) {

                if ($value) {

                    if (isset($camposFilter[$key]['mascara'])) {

                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }

                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';

                }
            }
        }

        $select->where($where)->order(['id_catequizando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getTurmaCatequizandoIdArray($id_turma)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('turma_catequizando')
            ->where([
                'turma_catequizando.id_turma'=> $id_turma
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
     
    public function getAprovacaoCatequizandoPaginator($id_turma, $id_etapa, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequizando')->columns([
            'id_turma_catequizando',
            'id_turma',
            'id_catequizando',
            'id_usuario',
            'id_periodo_letivo',
            'dt_cadastro',
            'cs_aprovado',
            'ds_motivo_reprovacao',
            'tx_observacoes',
      
            
        ])->join('turma', 'turma.id_turma = turma_catequizando.id_turma', [
            'nm_turma','id_etapa'
        ])    
        ->join('catequizando', 'catequizando.id_catequizando = turma_catequizando.id_catequizando', [
            'nm_catequizando'
        ]);

        $where = [
            'turma_catequizando.id_turma'=>$id_turma,
            'turma.id_etapa'=>$id_etapa,
        ];

        if (!empty($filter)) {

            foreach ($filter as $key => $value) {

                if ($value) {

                    if (isset($camposFilter[$key]['mascara'])) {

                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }

                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
                }
            }
        }

        $select->where($where)->order(['id_catequizando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }
    
    
    
    
}

    