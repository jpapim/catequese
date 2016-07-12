<?php

namespace SacramentoCatequisando\Service;

use SacramentoCatequisando\Entity\SacramentoCatequisandoEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class SacramentoCatequisandoService extends Entity
{

    public function getSacramentoCatequisandoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento_catequisando')->columns([
            'id_sacramento_catequisando',
            'cs_comprovante_batismo',
        ])
            ->join(
                'catequisando', 'catequisando.id_catequisando = sacramento_catequisando.id_catequisando'
            )
            ->join(
                'sacramento', 'sacramento.id_sacramento = sacramento_catequisando.id_sacramento'
            )
            ->join(
                'paroquia', 'paroquia.id_paroquia = sacramento_catequisando.id_paroquia'
            );

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

        $select->where($where)->order(['id_sacramento_catequisando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_sacramento_catequisando ASC', $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('sacramento_catequisando')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_sacramento_catequisando', "%{$like}%")
                ->or
                ->like('id_catequisando', "%{$like}%")
                ->or
                ->like('nm_sacramento', "%{$like}%")
                ->or
                ->like('nm_paroquia', "%{$like}%");
        }

        $resultSet = new HydratingResultSet(new Reflection(), new \SacramentoCatequisando\Entity\SacramentoCatequisandoEntity());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->getAdapter(),
            $resultSet
        );

        return (new Paginator($paginatorAdapter))
            ->setCurrentPageNumber((int)$pagina)
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getSacramentoCatequisandoToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento_catequisando')
            ->where([
                'sacramento_catequisando.id_sacramento_catequisando = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }


}
