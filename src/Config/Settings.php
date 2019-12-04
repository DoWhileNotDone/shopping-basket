<?php declare(strict_types=1);

return [
    //NOTE: The settings sub array is required for correct placement in the slim app when instantiated
    'settings' => [
        'addContentLengthHeader'            => false,
        'displayErrorDetails'               => filter_var(getenv('DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
        'determineRouteBeforeAppMiddleware' => true,
        'service_environment' => getenv('SERVICE_ENVIRONMENT'),
        'database'                          => [
            'driver'    => 'pgsql',
            'host'      => getenv('DB_URL'),
            'port'      => getenv('DB_PORT') ?: '5432',
            'database'  => getenv('DB_DATABASE'),
            'schema'    => getenv('DB_SCHEMA') ?: 'shoppingbasket',
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'logger' => [
            'name' => getenv('LOG_NAME') ?: 'shoppingbasket',
            'path' => getenv('LOG_PATH') ?: __DIR__ . '/../../var/logs/shoppingbasket.log',
            'level' => getenv('LOG_LEVEL') ?: \Psr\Log\LogLevel::DEBUG,
        ],
    ]
];
