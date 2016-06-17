<?php

namespace Permissao\Service;

use \Permissao\Entity\PermissaoEntity as Entity;

class PermissaoService extends Entity {

    public function getPermissaoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('perfil_controller_action')
            ->where([
                'perfil_controller_action.id_perfil_controller_action = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getPermissaoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('perfil_controller_action')->columns([
            'id_perfil_controller_action',
            'id_controller',
            'id_action',
            'id_perfil',
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

        $select->where($where)->order(['id_controller ASC']);
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    public function preSave() {

    }

    public function posSave() {

    }


}
