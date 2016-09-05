<?php

namespace CatequizandoEtapaCursou\Service;

use CatequizandoEtapaCursou\Entity\CatequizandoEtapaCursouEntity as Entity;

class CatequizandoEtapaCursouService extends Entity {

 
    public function getCatequizandoEtapaCursou($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('catequizando_etapa_cursou')
             
               ->join(
                        'etapa', 'etapa.id_etapa = catequizando_etapa_cursou.id_etapa'
                )
                  ->join(
                        'catequizando', 'catequizando.id_catequizando = catequizando_etapa_cursou.id_catequizando'
                )
            
      
                ->where([
            'catequizando_etapa_cursou.id_catequizando_etapa_cursou = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}
 public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_catequizando_etapa_cursou ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequizando_etapa_cursou')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_catequizando_etapa_cursou', "%{$like}%")
                  ->or
                   ->like('id_etapa', "%{$like}%")
                    ->or
                   ->like('id_catequizando', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \CatequizandoEtapaCursou\Entity\CatequizandoEtapaCursouEntity());

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

  
    public function getCatequizandoEtapaCursouPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

       $select = $sql->select('catequizando_etapa_cursou')->columns([
           'id_catequizando_etapa_cursou',
           'id_etapa',
           'id_catequizando',
                 ])->join('catequizando', 'catequizando.id_catequizando = catequizando_etapa_cursou.id_catequizando', [
            'nm_catequizando'
                ]) ->join('etapa', 'etapa.id_etapa = catequizando_etapa_cursou.id_etapa', [
            'nm_etapa'
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

        $select->where($where)->order(['id_catequizando_etapa_cursou DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
