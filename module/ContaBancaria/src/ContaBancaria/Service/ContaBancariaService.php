<?php

namespace ContaBancaria\Service;

use \ContaBancaria\Entity\ContaBancariaEntity as Entity;

class ContaBancariaService extends Entity {

    public function getContaBancaria($auth) {


        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('conta_bancaria')
                ->join(
                        'banco', 'banco.id_banco = conta_bancaria.id_banco'
                )
                ->where(
                [
                    'conta_bancaria.id_usuario' => $auth->id_usuario,
                ]
        );

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}
