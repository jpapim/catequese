<?php

return array(
    'modules' => array(
        'Application',
        'Auth',
        'Estrutura', //Tem que vir antes dos demais módulos
        'Banco',
        'Principal',
        'Email',
        'Usuario',
        'Perfil',
        'EsqueciSenha',
        'Config',
        'Cidade',
        'Estado',
        'Sexo',
        'EstadoCivil',
        'TipoUsuario',
        'SituacaoUsuario',
        'Endereco',
        'ArteMarcial',
        'Estilo',
        'Graduacao',
        'TipoEvento',
        'Evento',
        'Academia',
        'Atleta',
        'CategoriaPeso',
        'CategoriaIdade',
        'RegrasLutas',
        'DetalhesRegrasLuta',
        'InscricoesEvento',
        'ChavesLuta',
        'CompactAsset', //Compacta o Javascript e CSS para retornar em apenas uma requisição (Responsável pela minificar o css e js: compila os arquivos em um só)
        #'ContaBancaria',
        #'DOMPDFModule',
        //Ronaldo 02/03/2016 - Responsável por melhorar o desempenho da aplicação
        'EdpSuperluminal', //http://dev.competicaotkd.com.br/?EDPSUPERLUMINAL_CACHE - Execute isso na URL para compilar os arquivos e ficar mais rapido - em cada requisição, em vês de baixar em tempo de execução cada require do autoload, ele salva um unico arquivo, minificado, com todas as classes dentro
        #'Gerador',
        #'Login',
        #'PhpBoletoZf2',
        #'Situacao',
        #'Telefone',
        #'TipoConta',
        #'TipoTelefone',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,' . APPLICATION_ENV . '}.php'            
        ),
    ) 
);
