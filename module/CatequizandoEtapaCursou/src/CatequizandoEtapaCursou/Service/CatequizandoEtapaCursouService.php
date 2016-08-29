<?php

namespace CatequisandoEtapaCursou\Service;

use CatequisandoEtapaCursou\Entity\CatequisandoEtapaCursouEntity as Entity;

class CatequisandoEtapaCursouService extends Entity {

 
    public function getCatequisandoEtapaCursou($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('catequisando_etapa_cursou')
             
               ->join(
                        'etapa', 'etapa.id_etapa = catequisando_etapa_cursou.id_etapa'
                )
                  ->join(
                        'catequisando', 'catequisando.id_catequisando = catequisando_etapa_cursou.id_catequisando'
                )
            
      
                ->where([
            'catequisando_etapa_cursou.id_catequisando_etapa_cursou = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}
 public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_catequisando_etapa_cursou ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequisando_etapa_cursou')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_catequisando_etapa_cursou', "%{$like}%")
                  ->or
                   ->like('id_etapa', "%{$like}%")
                    ->or
                   ->like('id_catequisando', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \CatequisandoEtapaCursou\Entity\CatequisandoEtapaCursouEntity());

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

  
    public function getCatequisandoEtapaCursouPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

       $select = $sql->select('catequisando_etapa_cursou')->columns([
           'id_catequisando_etapa_cursou', 
           'id_etapa',
           'id_catequisando',
                 ])->join('catequisando', 'catequisando.id_catequisando = catequisando_etapa_cursou.id_catequisando', [
            'nm_catequisando'
                ]) ->join('etapa', 'etapa.id_etapa = catequisando_etapa_cursou.id_etapa', [
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

        $select->where($where)->order(['id_catequisando_etapa_cursou DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
