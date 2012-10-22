<?php

    return array(
        'information' => array(
            'Information' => 'Informação',
            'Debugging' => 'Debugando',
            'Name' => 'Nome',
            'Value' => 'Valor',
            'Security' => 'Segurança',
            'System' => 'System',
            'on' => 'on',
            'off'=> 'off',
            'Server' => 'Servidor',
            'PHP version' => 'Versão do PHP',
            'SimpleXML module' => 'Módulo SimpleXML',
            'DOM module' => 'Módulo DOM',
            'Installed' => 'Instalado',
            'Not Installed' => 'Não instalado',
            'System version' => 'Versão do sistema',
            'System version ID' => 'ID (longo) da versão',
            'Security check results' => 'Resultados da verificação de segurança',
            'The configuration file has been found to be writable. We would advise you to remove all write permissions on defines.php on production systems.' => 
            'O arquivo de configuração está com permissões de escrita. Para melhor segurança, você deve remover as permissões de escrita do arquivo defines.php em sistemas de produções.',
            'The Monstra core directory (":path") and/or files underneath it has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod -R a-w :path</code>' => 
            'O diretório núcleo do Monstra (":path") e/ou arquivos dentro do diretório estão com permissões de escrita. Para melhor segurança, você deve remover as permissões de escritas. <br/>Você pode fazer isso em sistemas UNIX com: <code>chmod -R a-w :path</code>',
            'The Monstra .htaccess file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>' =>
            'O arquivo .htaccess da pasta de instalação do Monstra está com permissões de escrita. Para sua melhor segurança, você deve remover as permissões de escritas. <br/>Você pode fazer isso em sistemas UNIX com: <code>chmod a-w :path</code>',
            'The Monstra index.php file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>' =>
            'O arquivo index.php do diretório de instalação do Monstra está com permissões de escrita. Para sua melhor segurança, você deve remover as permissões de escritas. <br/>Vocês pode fazer isso em sistemas UNIX com: <code>chmod a-w :path</code>',
            'Due to the type and amount of information an error might give intruders when Core::$environment = Core::DEVELOPMENT, we strongly advise setting Core::PRODUCTION in production systems.' =>
            'Devide ao tipo e quantidade de informações, um erro pode trazer possíveis intrusos se a variável Core::$environment for igual à Core::DEVELOPMENT, para isso nós recomendamos fortemente que você sete a variável para o seguinte valor: Core::PRODUCTION em sistemas de produção.',
        )
    );