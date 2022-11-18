<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Csrf\Guard as CsrfMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Order: Last in, first executed
return function (App $app) {
    $app->add(CsrfMiddleware::class);
    $app->add(TwigMiddleware::createFromContainer($app, containerKey: Twig::class));
    $app->add(SessionMiddleware::class);
};
