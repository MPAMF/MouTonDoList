<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                // Eloquent
                'db' => [
                    'driver' => 'mysql',
                    'host' => ($mysql_db = env('MYSQL_HOST')) ? $mysql_db : 'localhost',
                    'database' => ($mysql_db = env('MYSQL_DATABASE')) ? $mysql_db : 'database',
                    'username' => ($mysql_user = env('MYSQL_USER')) ? $mysql_user : 'user',
                    'password' => ($mysql_user = env('MYSQL_PASSWORD')) ? $mysql_user : 'pwd',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ]
            ]);
        }
    ]);
};
