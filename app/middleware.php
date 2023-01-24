<?php
declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Order: Last in, first executed
return function (App $app) {
    $app->add(TwigMiddleware::createFromContainer($app, containerKey: Twig::class));
};
