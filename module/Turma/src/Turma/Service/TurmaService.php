<?php

namespace Turma\Service;

use Turma\Entity\TurmaEntity as Entity;

class TurmaService extends Entity {

    /**
     * 
     * @param type $auth
     * @param type $nivel
     * @return type
     */
    public function getTurma($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('turma')
             
               ->join(
                        'etapa', 'etapa.id_etapa = turma.id_etapa'
                )
      
                ->where([
            'turma.id_turma = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
   
        
        
        
    }
    
     public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_turma ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('turma')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_turma', "%{$like}%")
                    ->or
                    ->like('nm_turma', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Turma\Entity\TurmaEntity());

        // criar um objeto adapter paginator
        $paginatorAdapter = new DbSelect(
                // nosso objeto select
                $select,
                // nosso adapter da tabela
                $this->getAdapter(),
                // nosso objeto base para ser populado
                $resultSet
        );

        # var_dump($paginatorAdapter);
        #die;
        // resultado da pagina��o
        return (new Paginator($paginatorAdapter))
                        // pagina a ser buscada
                        ->setCurrentPageNumber((int) $pagina)
                        // quantidade de itens na p�gina
                        ->setItemCountPerPage((int) $itensPagina)
                        ->setPageRange((int) $itensPaginacao);
    }

  
    public function getTurmaPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma')->columns([
                    'id_turma',
                    'nm_turma',
                    
               
        ]);

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

        $select->where($where)->order(['nm_turma DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    public function getTurmaToArray($id)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('turma')
            ->where([
                'turma.id_turma'=> $id
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
    
    
}

    
    
    
    

    /**
     * 
     * @return type
     */

    
    
    
    
    


