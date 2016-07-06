<?php

namespace ResponsavelCatequisando\Service;

use ResponsavelCatequisando\Entity\ResponsavelCatequisandoEntity as Entity;

class ResponsavelCatequisandoService extends Entity {

 
    public function getResponsavelCatequisando($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('responsavel_catequisando')
             
               ->join(
                        'responsavel', 'responsavel.id_responsavel = responsavel_catequisando.id_responsavel'
                )
                  ->join(
                        'catequisando', 'catequisando.id_catequisando = responsavel_catequisando.id_catequisando'
                )
                
                  ->join(
                        'grau_parentesco', 'grau_parentesco.id_grau_parentesco = responsavel_catequisando.id_grau_parentesco'
                )
                
      
                ->where([
            'responsavel_catequisando.id_responsavel_catequisando = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}

      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_responsavel_catequisando ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('responsavel_catequisando')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_responsavel_catequisando', "%{$like}%")
                    ->or
                   ->like('id_responsavel', "%{$like}%")
                    ->or
                   ->like('id_catequisando', "%{$like}%")
                    ->or
                   ->like('id_grau_parentesco', "%{$like}%");
              
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \ResponsavelCatequisando\Entity\ResponsavelCatequisandoEntity());

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

  
    public function getResponsavelCatequisandoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('responsavel_catequisando')->columns([
                    'id_responsavel_catequisando',
                   'id_responsavel',
                   'id_catequisando',
                   'id_grau_parentesco',     
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

        $select->where($where)->order(['id_responsavel_catequisando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    