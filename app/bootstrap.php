<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        App::class => function (ContainerInterface $container) {
            AppFactory::setContainer($container);
            return AppFactory::create();
        },
        ResponseFactoryInterface::class => function (ContainerInterface $container) {
            return $container->get(App::class)->getResponseFactory();
        },
    ]);
};
