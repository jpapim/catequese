<?php
return array(
    'db' => array(
		'username' => 'usuario',
        'password' => 'senha',
        'dsn' => 'mysql:dbname=banco;host=localhost',
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'smtp_options' => array(
        'no-reply' => array(
            'name' => 'no-reply',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => 'email@gmail.com',
                'password' => 'senha'
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
