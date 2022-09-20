<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
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

    $app->get('/home', function (Request $request, Response $response) {
        return $this->get('view')->render($response, 'home/home-page.twig');
    });

    $app->get('/', function (Request $request, Response $response) {
        $noms = [
            'Matthieu',
            'Quentin',
            'Victor',
            'Paul',
            'Mouton'];
        return $this->get('view')->render($response, 'profite.twig', ['noms' => $noms]);
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
