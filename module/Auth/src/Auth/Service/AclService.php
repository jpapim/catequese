<?php

namespace Auth\Service;

use Auth\Entity\AclEntity as Entity;

class AclService extends Entity {

    public function getDbRoles() {

        $cache = $this->getServiceLocator()->get('Zend\Cache\Storage\Filesystem');

        $queryCache = $cache->getItem('aclServiceGetDbRoles', $success);

        if (!$success) {

            $results = $this->fetchAll();

            $roles = array();
            foreach ($results as $result) {

                $roles[$result->getIdPerfil()][] = $result->getNmResource();
            }
            $cache->addItem('aclServiceGetDbRoles', $roles);

            return $roles;
        }

        /*
         * se existir damos um decode no cache
         * se adicionarmos o segundo parâmetro como true geramos um array
         * se não adicionar o segundo parâmetro gera um objeto
         */
        return $queryCache;
    }

}
