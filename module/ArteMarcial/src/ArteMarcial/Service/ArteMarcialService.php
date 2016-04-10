<?php

namespace ArteMarcial\Service;

use \ArteMarcial\Entity\ArteMarcialEntity as Entity;

class ArteMarcialService extends Entity{

    public function getArteMarcialToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('arte_marcial')
            ->where([
                'arte_marcial.id_arte_marcial = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}