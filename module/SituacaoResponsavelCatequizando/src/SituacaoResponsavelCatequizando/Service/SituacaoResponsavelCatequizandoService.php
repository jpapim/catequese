<?php

namespace SituacaoResponsavelCatequizando\Service;

use SituacaoResponsavelCatequizando\Entity\SituacaoResponsavelCatequizandoEntity as Entity;

class SituacaoResponsavelCatequizandoService extends Entity {

 
    public function getSituacaoResponsavelCatequizando($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('situacao_responsavel_catequizando')
             
               ->join(
                       'situacao_responsavel', 'situacao_responsavel.id_situacao_responsavel = situacao_responsavel_catequizando.id_situacao_responsavel'
                )
          
                ->join(
                        'catequizando', 'catequizando.id_catequizando = situacao_responsavel_catequizando.id_catequizando'
                )
       
               
                ->where([
            'situacao_responsavel_catequizando.id_situacao_responsavel_catequizando = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoSituacaoResponsavelCatequizandoCadastro($configList) {

        //Busca os usuarios cadastrados
        $SituacaoResponsavelCatequizandoService = $this->getServiceLocator()->get('SituacaoResponsavelCatequizando\Service\SituacaoResponsavelCatequizandoService');
        $resultSetSituacaoResponsavelCatequizando = $SituacaoResponsavelCatequizandoService->filtrarObjeto();

    
    }

         public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_situacao_responsavel_catequizando ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('situacao_responsavel_catequizando')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_situacao_responsavel_catequizando', "%{$like}%")
                    ->or
                   ->like('id_situacao_responsavel', "%{$like}%")
                    ->or
                   ->like('id_catequizando', "%{$like}%");
                   
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \SituacaoResponsavelCatequizando\Entity\SituacaoResponsavelCatequizandoEntity());

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
                        // quantidade de itens na página
                        ->setItemCountPerPage((int) $itensPagina)
                        ->setPageRange((int) $itensPaginacao);
    }

  
    public function getSituacaoResponsavelCatequizandoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_responsavel_catequizando')->columns([
                   'id_situacao_responsavel_catequizando',
                    'id_situacao_responsavel',
                    'id_catequizando',
                   ])->join('situacao_responsavel', 'situacao_responsavel.id_situacao_responsavel = situacao_responsavel_catequizando.id_situacao_responsavel', [
            'ds_situacao_responsavel'
          ])->join('catequizando', 'catequizando.id_catequizando = situacao_responsavel_catequizando.id_catequizando', [
            'nm_catequizando'
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

        $select->where($where)->order(['id_situacao_responsavel_catequizando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
    
