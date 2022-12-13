<?php
declare(strict_types=1);

use App\Application\Middleware\Auth\AuthMiddleware;
use Slim\App;
use Slim\Csrf\Guard as CsrfMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Order: Last in, first executed
return function (App $app) {
    $app->add(AuthMiddleware::class);
    $app->add(CsrfMiddleware::class);
    $app->add(TwigMiddleware::createFromContainer($app, containerKey: Twig::class));
    // Session or token set in router level to manage rest api with token auth
    // $app->add(SessionMiddleware::class);
    // $app->add(TokenMiddleware::class);
};
