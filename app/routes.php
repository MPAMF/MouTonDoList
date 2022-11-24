<?php
declare(strict_types=1);

use App\Application\Actions\Auth\Login\DisplayLoginAction;
use App\Application\Actions\Auth\Login\LoginAction;
use App\Application\Actions\Auth\Logout\DisplayLogoutAction;
use App\Application\Actions\Auth\Logout\LogoutAction;
use App\Application\Actions\Auth\Register\DisplayRegisterAction;
use App\Application\Actions\Auth\Register\RegisterAction;
use App\Application\Actions\Dashboard\DisplayDashboardAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Middleware\Auth\AuthMiddleware;
use App\Application\Middleware\Auth\UserConnectedMiddleware;
use App\Application\Middleware\Auth\UserDisconnectedMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        return $this->get(Twig::class)->render($response, 'home/content.twig');
    })->setName('home');

    $app->group('/account', function (Group $group) {
        $group->get('/login', DisplayLoginAction::class)->setName('account.login');
        $group->post('/login', LoginAction::class);

        $group->get('/register', DisplayRegisterAction::class)->setName('account.register');
        $group->post('/register', RegisterAction::class);
    })->add(UserDisconnectedMiddleware::class);

    $app->group('/account', function (Group $group){
        $group->post('/logout', LogoutAction::class)->setName('account.logout');
    })->add(UserConnectedMiddleware::class);

    $app->group('/dashboard[/{id}]', function (Group $group) {
        $group->get('', DisplayDashboardAction::class)->setName('dashboard');
    })->add(UserConnectedMiddleware::class);

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
