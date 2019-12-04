<?php

// load our environment files - used to store credentials & configuration
Dotenv\Dotenv::create(__DIR__)->overload();

$_ENV['DB_SCHEMA'] = $_ENV['DB_SCHEMA'] ?? 'shoppingbasket';
$_ENV['DB_PORT'] = $_ENV['DB_PORT'] ?? '5432';

$settings =
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/scripts/db/phinx/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/scripts/db/phinx/seeds',
        ],
        'environments' =>
            [
                'default_database' => 'development',
                'default_migration_table' => $_ENV['DB_SCHEMA'].'.phinxlog',
                'development'      =>
                    [
                        'adapter' => 'pgsql',
                        'host' => $_ENV['DB_URL'],
                        'name' => $_ENV['DB_DATABASE'],
                        'user' => $_ENV['DB_USERNAME'],
                        'pass' => $_ENV['DB_PASSWORD'],
                        'port' => $_ENV['DB_PORT'],
                        'charset' => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                    ],
            ],
    ];

return $settings;
