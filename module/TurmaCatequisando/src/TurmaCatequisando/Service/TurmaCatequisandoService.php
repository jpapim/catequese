<?php

namespace TurmaCatequisando\Service;

use TurmaCatequisando\Entity\TurmaCatequisandoEntity as Entity;

class TurmaCatequisandoService extends Entity {

 
    public function getTurmaCatequisando($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('turma_catequisando')
             
               ->join(
                        'turma', 'turma.id_turma = turma_catequisando.id_turma'
                )
                  ->join(
                        'catequisando', 'catequisando.id_catequisando = turma_catequisando.id_catequisando'
                )
                
                  ->join(
                        'usuario', 'usuario.id_usuario = turma_catequisando.id_usuario'
                )
                  ->join(
                        'periodo_letivo', 'periodo_letido.id_periodo_letivo = turma_catequisando.id_periodo_letivo'
                )
      
                ->where([
            'turma_catequisando.id_turma_catequisando = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}

      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_turma_catequisando ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('turma_catequisando')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_turma_catequisando', "%{$like}%")
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
        $resultSet = new HydratingResultSet(new Reflection(), new \TurmaCatequisando\Entity\TurmaCatequisandoEntity());

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

  
    public function getTurmaCatequisandoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequisando')->columns([
            'id_turma',
            'id_periodo_letivo',
        ])->join('turma', 'turma.id_turma = turma_catequisando.id_turma', [
            'nm_turma'
        ])->join('periodo_letivo', 'periodo_letivo.id_periodo_letivo = turma_catequisando.id_periodo_letivo', [
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

        $select->where($where)->order(['id_turma_catequisando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    public function getTurmaCatequisandoInternoPaginator($id_turma, $id_periodo_letivo, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequisando')->columns([
            'id_turma_catequisando',
            'id_turma',
            'id_catequisando',
            'id_usuario',
            'id_periodo_letivo',
            'dt_cadastro',
            'cs_aprovado',
            'ds_motivo_reprovacao',
            'tx_observacoes',
        ])->join('turma', 'turma.id_turma = turma_catequisando.id_turma', [
            'nm_turma'
        ])->join('periodo_letivo', 'periodo_letivo.id_periodo_letivo = turma_catequisando.id_periodo_letivo', [
            'dt_ano_letivo'
        ])->join('catequisando', 'catequisando.id_catequisando = turma_catequisando.id_catequisando', [
            'nm_catequisando'
        ]);

        $where = [
            'turma_catequisando.id_turma'=>$id_turma,
            'turma_catequisando.id_periodo_letivo'=>$id_periodo_letivo,
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

        $select->where($where)->order(['id_catequisando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    