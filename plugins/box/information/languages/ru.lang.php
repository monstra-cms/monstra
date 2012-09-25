<?php

    return array(
        'information' => array(
            'Information' => 'Информация',
            'Debuging' => 'Дебагинг',
            'Name' => 'Название',
            'Value' => 'Значение',
            'Security' => 'Безопасность',
            'System' => 'Система',
            'on' => 'включен',
            'off'=> 'выключен', 
            'System version' => 'Версия системы',
            'System version ID' => 'Версия системы ID',
            'Security check results' => 'Результаты проверки безопасности',
            'The configuration file has been found to be writable. We would advise you to remove all write permissions on defines.php on production systems.' => 
            'Конфигурационный файл доступен для записи. Мы рекомендуем вам удалить права записи на файл defines.php на живом сайте.',
            'The Monstra core directory (":path") and/or files underneath it has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod -R a-w :path</code>' => 
            'Директория Monstra (":path") доступна для записи. Мы рекомендуем вам удалить права записи на директорию (":path") на живом сайте. <br/>  Вы можете сделать это на UNIX системах так: <code>chmod -R a-w :path</code>',
            'The Monstra .htaccess file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>' =>
            'Главный .htaccess доступен для записи. Мы рекомендуем вам удалить права записи на главный .htaccess файл. <br/> Вы можете сделать это на UNIX системах так: <code>chmod -R a-w :path</code>',
            'The Monstra index.php file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>' =>
            'Главный index.php файл доступен для записи. Мы рекомендуем вам удалить права записи на главный index.php файл. <br/> Вы можете сделать это на UNIX системах так: <code>chmod -R a-w :path</code>',
            'Due to the type and amount of information an error might give intruders when Core::$environment = Core::DEVELOPMENT, we strongly advise setting Core::PRODUCTION in production systems.' =>
            'Система работает в режиме Core::DEVELOPMENT Мы рекомендуем вам установить режим Core::PRODUCTION на живом сайте.',
        )
    );