<?php

    return array(
        'information' => array(
            'Information' => '情報',
            'Debugging' => 'デバッグモード',
            'Name' => '名前',
            'Value' => '値',
            'Security' => 'セキュリティ',
            'System' => 'システム',
            'on' => 'オン',
            'off'=> 'オフ',
            'Server' => 'サーバー',
            'PHP version' => 'PHPバージョン',
            'SimpleXML module' => 'SimpleXMLモジュール',
            'DOM module' => 'DOMモジュール',
            'Installed' => 'インストール済み',
            'Not Installed' => '未インストール',
            'Security check results' => 'セキュリティチェックの結果',
            'The configuration file has been found to be writable. We would advise you to remove all write permissions on defines.php on production systems.' =>
            '設定ファイルが書き込み可能になっています。システムを公開する場合はすべての defines.php から書き込み権限を除去することをおすすめします。',

            'The Monstra core directory (":path") and/or files underneath it has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod -R a-w :path</code>' =>
            'The Monstra core directory (":path") and/or files underneath it has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod -R a-w :path</code>',

            'The Monstra .htaccess file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>' => 
			'Monstraの .htaccess ファイルが書き込み可能になっています。書き込み権限を除去することをおすすめします。<br/>Linuxシステムでは次のように除去できます: <code>chmod a-w :path</code>',

            'The Monstra index.php file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>' =>
            'Monstraの index.php ファイルが書き込み可能になっています。書き込み権限を除去することをおすすめします。<br/>Linuxシステムでは次のように除去できます: <code>chmod a-w :path</code>',

            'Due to the type and amount of information an error might give intruders when Monstra::$environment = Monstra::DEVELOPMENT, we strongly advise setting Monstra::PRODUCTION in production systems.' =>
            'Due to the type and amount of information an error might give intruders when Monstra::$environment = Monstra::DEVELOPMENT, we strongly advise setting Monstra::PRODUCTION in production systems.',

            'Monstra version' => 'Monstraのバージョン',
            'Directory Permissions' => 'ディレクトリの権限',
            'Directory' => 'ディレクトリ',
            'Writable' => '書き込み可能',
            'Unwritable' => '書き込み不可能',
            'Status' => 'ステータス',
            'PHP Built On' => 'PHP構成システム',
            'Web Server' => 'Webサーバ',
            'WebServer to PHP Interface' => 'Webサーバの提供するPHPインターフェイス',
        )
    );
