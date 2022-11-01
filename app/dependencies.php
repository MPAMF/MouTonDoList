<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use Illuminate\Database\Capsule\Manager;
use DI\ContainerBuilder;
use Illuminate\Database\DatabaseManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Symfony\Component\Translation\Translator;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Manager::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $capsule = new Manager;
            $capsule->addConnection($settings->get('db'));

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        },
        DatabaseManager::class => function (ContainerInterface $c) {
            $capsule = $c->get(Manager::class);
            return $capsule->getDatabaseManager();
        },
    ]);
};
