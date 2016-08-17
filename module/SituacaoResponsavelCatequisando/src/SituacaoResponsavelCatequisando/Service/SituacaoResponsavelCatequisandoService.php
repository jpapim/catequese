<?php

namespace SituacaoResponsavelCatequisando\Service;

use SituacaoResponsavelCatequisando\Entity\SituacaoResponsavelCatequisandoEntity as Entity;

class SituacaoResponsavelCatequisandoService extends Entity {

 
    public function getSituacaoResponsavelCatequisando($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('situacao_responsavel_catequisando')
             
               ->join(
                       'situacao_responsavel', 'situacao_responsavel.id_situacao_responsavel = situacao_responsavel_catequisando.id_situacao_responsavel'
                )
          
                ->join(
                        'catequisando', 'catequisando.id_catequisando = situacao_responsavel_catequisando.id_catequisando'
                )
       
               
                ->where([
            'situacao_responsavel_catequisando.id_situacao_responsavel_catequisando = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoSituacaoResponsavelCatequisandoCadastro($configList) {

        //Busca os usuarios cadastrados
        $SituacaoResponsavelCatequisandoService = $this->getServiceLocator()->get('SituacaoResponsavelCatequisando\Service\SituacaoResponsavelCatequisandoService');
        $resultSetSituacaoResponsavelCatequisando = $SituacaoResponsavelCatequisandoService->filtrarObjeto();

    
    }

         public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_situacao_responsavel_catequisando ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('situacao_responsavel_catequisando')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_situacao_responsavel_catequisando', "%{$like}%")
                    ->or
                   ->like('id_situacao_responsavel', "%{$like}%")
                    ->or
                   ->like('id_catequisando', "%{$like}%");
                   
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \SituacaoResponsavelCatequisando\Entity\SituacaoResponsavelCatequisandoEntity());

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

  
    public function getSituacaoResponsavelCatequisandoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_responsavel_catequisando')->columns([
                   'id_situacao_responsavel_catequisando',
                    'id_situacao_responsavel',
                    'id_catequisando',
                   ])->join('situacao_responsavel', 'situacao_responsavel.id_situacao_responsavel = situacao_responsavel_catequisando.id_situacao_responsavel', [
            'ds_situacao_responsavel'
          ])->join('catequisando', 'catequisando.id_catequisando = situacao_responsavel_catequisando.id_catequisando', [
            'nm_catequisando'
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

        $select->where($where)->order(['id_situacao_responsavel_catequisando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
    
