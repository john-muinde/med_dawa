<?php
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'med_dawa');
define('BASE_URL', 'http://localhost:3000/admin/');
return [
    'driver' => 'mysql',
    'host' => DB_SERVER,
    'port' => '3306',
    'database' => DB_NAME,
    'username' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
];
