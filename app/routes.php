<?php
declare(strict_types=1);

use App\Application\Actions\Dashboard\DisplayDashboardAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/home', function (Request $request, Response $response) {
        return $this->get('view')->render(
            $response,
            'home/components/content-page.twig',
            ['contents' => 'home']
        );
    });

    $app->get('/home-presentation', function (Request $request, Response $response) {
        return $this->get('view')->render(
            $response,
            'home/components/content-page.twig',
            ['contents' => 'presentation']
        );
    });

    $app->group('/account', function (Group $group) {
        $group->get('/login', function (Request $request, Response $response) {
            return $this->get('view')->render($response, 'account/login-page.twig');
        })->setName('account/login');

        $group->get('/register', function (Request $request, Response $response) {
            return $this->get('view')->render($response, 'account/signin-page.twig');
        });
    });

    $app->get('/account/logout', function (Request $request, Response $response) {
        return $this->get('view')->render($response, 'account/login-page.twig');
    })->add(AuthMiddleware::class);

    $app->get('/', DisplayDashboardAction::class);

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
