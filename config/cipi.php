<?php

return [

    'ssh_port' => env('CIPI_SSH_SERVER_PORT', '22'),
    'ssh_host' => env('CIPI_SSH_SERVER_HOST', '127.0.0.1'),
    'ssh_user' => env('CIPI_SSH_SERVER_USER', 'cipi'),
    'ssh_pass' => env('CIPI_SSH_SERVER_PASS'),

    'db_user' => env('CIPI_SQL_DBROOT_USER', 'cipi'),
    'db_pass' => env('CIPI_SQL_DBROOT_PASS'),

    'username_prefix' => env('CIPI_USERNAME_PREFIX', 'cp'),

    'php_versions' => [
        '8.2',
        '8.1',
    ],

];
