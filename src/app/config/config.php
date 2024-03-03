<?php
$t=time();

return  [
    'app' => [
        'baseUri'  => getenv('APP_BASE_URI'),
        'env'      => getenv('APP_ENV'),
        'name'     => 'APP_NAME',
        'timezone' => date("d-m-y"),
        'url'      => getenv('APP_URL'),
        'version'  => getenv('VERSION'),
        'time'     => date("d-m-y h:i a"),
    ],
    'database' =>[
        'adapter'     => 'Mysql',
        'host'        => 'mysql-server',
        'username'    => 'root',
        'password'    => 'secret',
        'dbname'      => 'blog_db',
        'charset'     => 'utf8',
    ],

];