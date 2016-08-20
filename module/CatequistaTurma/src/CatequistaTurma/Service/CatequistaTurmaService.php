<?php

namespace CatequistaTurma\Service;

use CatequistaTurma\Entity\CatequistaTurmaEntity as Entity;

class CatequistaTurmaService extends Entity {

 
    public function getCatequistaTurma($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('catequista_turma')
             
               ->join(
                        'turma', 'turma.id_turma = catequista_turma.id_turma'
                )
                  ->join(
                        'catequista', 'catequista.id_catequista = catequista_turma.id_catequista'
                )
            
      
                ->where([
            'catequista_turma.id_catequista_turma = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}
 public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_catequista_turma ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequista_turma')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('catequista_turma', "%{$like}%")
                    ->or
                   ->like('id_turma', "%{$like}%")
                    ->or
                   ->like('id_catequista', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \CatequistaTuma\Entity\CatequistaTurmaEntity());

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

  
    public function getCatequistaTurmaPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequista_turma')->columns([
            'id_catequista_turma',
            'id_turma',
            'id_catequista',
        ])->join('turma', 'turma.id_turma = catequista_turma.id_turma', [
            'nm_turma'
        ])->join('catequista', 'catequista.id_catequista = catequista_turma.id_catequista', [
            'nm_catequista'
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

        $select->where($where)->order(['id_catequista_turma DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }
#######################################################################################################

public function getCatequistaTurmaInternoPaginator($id_turma, $id_catequista, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequista_turma')->columns([
            'id_catequista_turma',
            'id_turma',
            'id_catequista',
            
        ])->join('turma', 'turma.id_turma = catequista_turma.id_turma', [
            'nm_turma'
        ])->join('catequista', 'catequista.id_catequista = catequista_turma.id_catequista', [
            'nm_catequista'
       
        ]);

        $where = [
            'catequista_turma.id_turma'=>$id_turma,
            'catequista_turma.id_catequista'=>$id_catequista,
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

        $select->where($where)->order(['id_catequista_turma DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}