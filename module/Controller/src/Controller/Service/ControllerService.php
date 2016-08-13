<?php

namespace Controller\Service;

use \Controller\Entity\ControllerEntity as Entity;

class ControllerService extends Entity {

    public function getEstadoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('controller')
            ->where([
                'controller.id_controller = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getControllerPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('controller')->columns([
            'id_controller',
            'nm_controller',
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

        $select->where($where)->order(['nm_controller ASC']);
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    /**
     * Método criado para Sobrescrever o método utilizado para carregar os combos
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAllModulos() {
        return $this->select();
    }

}
