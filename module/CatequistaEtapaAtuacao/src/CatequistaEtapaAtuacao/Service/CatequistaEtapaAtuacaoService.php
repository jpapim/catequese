<?php

namespace CatequistaEtapaAtuacao\Service;

use CatequistaEtapaAtuacao\Entity\CatequistaEtapaAtuacaoEntity as Entity;

class CatequistaEtapaAtuacaoService extends Entity {

 
    public function getCatequistaEtapaAtuacao($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('catequista_etapa_atuacao')
             
               ->join(
                        'etapa', 'etapa.id_etapa = catequista_etapa_atuacao.id_etapa'
                )
                  ->join(
                        'catequista', 'catequista.id_catequista = catequista_etapa_atuacao.id_catequista'
                )
            
      
                ->where([
            'catequista_etapa_atuacao.id_catequista_etapa_atuacao = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}
 public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_catequista_etapa_atuacao ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequista_etapa_atuacao')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_catequista_etapa_atuacao', "%{$like}%")
                  ->or
                   ->like('id_etapa', "%{$like}%")
                    ->or
                   ->like('id_catequista', "%{$like}%");
                 
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \catequista_etapa_atuacao\Entity\Ccatequista_etapa_atuacaoEntity());

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

  
    public function getcatequistaEtapaAtuacaoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

       $select = $sql->select('catequista_etapa_atuacao')->columns([
           'id_catequista_etapa_atuacao', 
           'id_etapa',
           'id_catequista',
        
                 ])->join('catequista', 'catequista.id_catequista = catequista_etapa_atuacao.id_catequista', [
            'nm_catequista'
                ]) ->join('etapa', 'etapa.id_etapa = catequista_etapa_atuacao.id_etapa', [
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

        $select->where($where)->order(['id_catequista_etapa_atuacao DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
