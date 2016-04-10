<?php

namespace Auth\Service;

Use Auth\Entity\AuthEntity as Entity;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AuthService extends Entity
{
    public function autenticar()
    {
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $dbTableAuthAdapter = new DbTableAuthAdapter(
            $dbAdapter, 'auth', 'em_email', 'pw_senha', 'MD5(?)'
        );                    

        $authService = new AuthenticationService();
        $authService->setAdapter($dbTableAuthAdapter);
        $authService->setStorage($this->getServiceLocator()->get('Auth\Table\MyAuth'));
        
        return $authService;        
    }    
}
