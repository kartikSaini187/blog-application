<?php
return new \Phalcon\Config([
    'database' =>[
        'adapter'     => 'Mysql',
        'host'        => 'mysql-server',
        'username'    => 'root',
        'password'    => 'secret',
        'dbname'      => 'blog_db',
        'charset'     => 'utf8',
    ],
   
]);
$aware = new Aware();