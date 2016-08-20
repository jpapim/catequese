<?php

namespace SacramentoResponsavel\Service;

use SacramentoResponsavel\Entity\SacramentoResponsavelEntity as Entity;

class SacramentoResponsavelService extends Entity {

 
    public function getSacramentoResponsavel($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('sacramento_responsavel')
             
               ->join(
                        'sacramento', 'sacramento.id_sacramento = sacramento_responsavel.id_sacramento'
                )
          
                ->join(
                        'responsavel', 'responsavel.id_responsavel = sacramento_responsavel.id_responsavel'
                )
       
               
                ->where([
            'sacramento_responsavel.id_sacramento_responsavel = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoSacramentoResponsavelCadastro($configList) {

        //Busca os usuarios cadastrados
        $SacramentoResponsavelService = $this->getServiceLocator()->get('SacramentoResponsavel\Service\SacramentoResponsavelService');
        $resultSetSacramentoResponsavel = $SacramentoResponsavelService->filtrarObjeto();

    
    }

         public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_sacramento_responsavel ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('sacramento_responsavel')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_sacramento_responsavel', "%{$like}%")
                    ->or
                   ->like('id_sacramento', "%{$like}%")
                    ->or
                   ->like('id_responsavel', "%{$like}%");
                   
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \SacramentoResponsavel\Entity\SacramentoResponsavelEntity());

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

  
    public function getSacramentoResponsavelPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento_responsavel')->columns([
                   'id_sacramento_responsavel',
                    'id_sacramento',
                    'id_responsavel',
                   ])->join('sacramento', 'sacramento.id_sacramento = sacramento_responsavel.id_sacramento', [
            'nm_sacramento'
          ])->join('responsavel', 'responsavel.id_responsavel = sacramento_responsavel.id_responsavel', [
            'nm_responsavel'
        ]);
       
        $where = [
        ];
      

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

        $select->where($where)->order(['id_sacramento_responsavel DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
    
