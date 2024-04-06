<?php
$env = json_decode(file_get_contents(__DIR__.'/../.env.json'));

const SERVERNAME = 'localhost';
define('DB_USERNAME', $env->DB_USERNAME);
define('DB_PASSWORD', $env->DB_PASSWORD);
define('DB_NAME', $env->DB_NAME);

?>