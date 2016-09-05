<?php

namespace Login\Service;

use \Login\Entity\LoginEntity as Entity;

class LoginService extends Entity{

      public function getLoginToArray($id_usuario) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('login')
            ->columns(array('id_login', 'pw_senha') )
                
                ->where([
                'login.id_usuario = ?' => $id_usuario
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
    
}