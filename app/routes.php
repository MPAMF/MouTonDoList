<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
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
        return $this->get('view')->render($response, 'home/content.twig', ['content' => 'home']);
    });

    $app->get('/login', function (Request $request, Response $response) {
        return $this->get('view')->render($response, 'home/content.twig', ['content' => 'login']);
    });

    $app->get('/signin', function (Request $request, Response $response) {
        return $this->get('view')->render($response, 'home/content.twig', ['content' => 'signin']);
    });

    $app->get('/', function (Request $request, Response $response) {
        return $this->get('view')->render($response, 'pages/dashboard.twig', ['category' => new \App\Domain\Category\Category(
            2, new \App\Domain\User\User(), null, "Voyage en Corée", "#FFFFFF", 0, false, new DateTime(),  new DateTime()
        )]);
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
