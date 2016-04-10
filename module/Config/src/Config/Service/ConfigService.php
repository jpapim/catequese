<?php

namespace Config\Service;

use \Config\Entity\ConfigEntity as Entity;

class ConfigService extends Entity {

    private $_configList;

    public function getConfigList() {

        if (!$this->_configList) {

            $cache = $this->getServiceLocator()->get('Zend\Cache\Storage\Filesystem');

            /*
             * verificando se existe o cache da lista de produtos
             * o segundo parâmetro retorna true se existir cache ou false se não existir
             */
            $queryCache = $cache->getItem('configServiceGetConfigList', $success);

            if (!$success) {

                $this->_configList = [];
                $configListDb = $this->filtrarObjeto();

                foreach ($configListDb as $config) {

                    $this->_configList[$config->getNmConfig()] = $config->getNmValor();
                }
                $cache->addItem('configServiceGetConfigList', $this->_configList);
            } else {

                /*
                 * se existir damos um decode no cache
                 * se adicionarmos o segundo parâmetro como true geramos um array
                 * se não adicionar o segundo parâmetro gera um objeto
                 */
                $this->_configList = $queryCache;
            }
        }
        return $this->_configList;
    }

}
