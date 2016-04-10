<?php

return array(
    'db' => array(
        'username' => '',
        'password' => '',
        'dsn'      => 'mysql:dbname=;host=',
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'smtp_options' => array(
        'no-reply' => array(
            'name' => 'no-reply',
            'host' => '',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => '',
                'password' => ''
            ),
        ),
        'contato' => array(
            'name' => 'contato',
            'host' => '',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => '',
                'password' => ''
            ),
        ),
    )
);