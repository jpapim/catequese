<?php

namespace CategoriaIdade\Service;

use \CategoriaIdade\Entity\CategoriaIdadeEntity as Entity;

class CategoriaIdadeService extends Entity{

    public function getCategoriaIdadeToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('categoria_idade')
            ->where([
                'categoria_idade.id_categoria_idade = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}