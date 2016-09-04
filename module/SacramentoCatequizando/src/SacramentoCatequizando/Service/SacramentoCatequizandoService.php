<?php

namespace SacramentoCatequizando\Service;

use SacramentoCatequizando\Entity\SacramentoCatequizandoEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class SacramentoCatequizandoService extends Entity
{

    public function getSacramentoCatequizandoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento_catequizando')->columns([
            'id_sacramento_catequizando',
            'cs_comprovante_batismo',
        ])
            ->join(
                'catequizando', 'catequizando.id_catequizando = sacramento_catequizando.id_catequizando'
            )
            ->join(
                'sacramento', 'sacramento.id_sacramento = sacramento_catequizando.id_sacramento'
            )
            ->join(
                'paroquia', 'paroquia.id_paroquia = sacramento_catequizando.id_paroquia'
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

        $select->where($where)->order(['id_sacramento_catequizando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_sacramento_catequizando ASC', $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('sacramento_catequizando')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_sacramento_catequizando', "%{$like}%")
                ->or
                ->like('id_catequizando', "%{$like}%")
                ->or
                ->like('nm_sacramento', "%{$like}%")
                ->or
                ->like('nm_paroquia', "%{$like}%");
        }

        $resultSet = new HydratingResultSet(new Reflection(), new \SacramentoCatequizando\Entity\SacramentoCatequizandoEntity());

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

    public function getSacramentoCatequizandoToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento_catequizando')
            ->where([
                'sacramento_catequizando.id_sacramento_catequizando = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }


}
