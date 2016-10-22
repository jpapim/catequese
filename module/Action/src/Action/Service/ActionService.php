<?php

namespace Action\Service;

use \Action\Entity\ActionEntity as Entity;

class ActionService extends Entity {

    public function getEstadoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('action')
            ->where([
                'action.id_action = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getActionsPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('action')->columns([
            'id_action',
            'nm_action',
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

        $select->where($where)->order(['nm_action ASC']);
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    /**
     * Método criado para Sobrescrever o método utilizado para carregar os combos
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAllActions() {
        $select = new \Zend\Db\Sql\Select('action');
        $select->order(['nm_action ASC']);
        return $this->getTable()->getTableGateway()->selectWith($select);
    }
}
