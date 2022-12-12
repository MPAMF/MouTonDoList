<?php
declare(strict_types=1);

use App\Application\Actions\Auth\Login\DisplayLoginAction;
use App\Application\Actions\Auth\Login\LoginAction;
use App\Application\Actions\Auth\Logout\LogoutAction;
use App\Application\Actions\Auth\Register\DisplayRegisterAction;
use App\Application\Actions\Auth\Register\RegisterAction;
use App\Application\Actions\Categories\CreateCategoryAction;
use App\Application\Actions\Categories\DeleteCategoryAction;
use App\Application\Actions\Categories\ReadCategoryAction;
use App\Application\Actions\Categories\UpdateCategoryAction;
use App\Application\Actions\Dashboard\DisplayDashboardAction;
use App\Application\Actions\Invitations\CreateInvitationAction;
use App\Application\Actions\Invitations\DeleteInvitationAction;
use App\Application\Actions\Invitations\ListInvitationAction;
use App\Application\Actions\Invitations\ReadInvitationAction;
use App\Application\Actions\Invitations\UpdateInvitationAction;
use App\Application\Actions\TaskComments\CreateTaskCommentAction;
use App\Application\Actions\TaskComments\DeleteTaskCommentAction;
use App\Application\Actions\TaskComments\ReadTaskCommentAction;
use App\Application\Actions\TaskComments\UpdateTaskCommentAction;
use App\Application\Actions\Tasks\CreateTaskAction;
use App\Application\Actions\Tasks\DeleteTaskAction;
use App\Application\Actions\Tasks\ReadTaskAction;
use App\Application\Actions\Tasks\UpdateTaskAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Actions\User\ViewUserAction;
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

    $app->group('/account', function (Group $group) {
        $group->post('/logout', LogoutAction::class)->setName('account.logout');
    })->add(UserConnectedMiddleware::class);

    $app->group('/dashboard[/{id}]', function (Group $group) {
        $group->get('', DisplayDashboardAction::class)->setName('dashboard');
    })->add(UserConnectedMiddleware::class);

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/actions', function (Group $group) {
        $group->group('/categories', function (Group $group) {
            $group->post('', CreateCategoryAction::class)->setName('actions.categories.create');
            $group->get('/{id}', ReadCategoryAction::class)->setName('actions.categories.read');
            $group->put('/{id}', UpdateCategoryAction::class)->setName('actions.categories.update');
            $group->delete('/{id}', DeleteCategoryAction::class)->setName('actions.categories.delete');
        });

        $group->group('/tasks', function (Group $group) {
            $group->post('', CreateTaskAction::class)->setName('actions.tasks.create');
            $group->get('/{id}', ReadTaskAction::class)->setName('actions.tasks.read');
            $group->put('/{id}', UpdateTaskAction::class)->setName('actions.tasks.update');
            $group->delete('/{id}', DeleteTaskAction::class)->setName('actions.tasks.delete');
        });

        $group->group('/comments', function (Group $group) {
            $group->post('', CreateTaskCommentAction::class)->setName('actions.comments.create');
            $group->get('/{id}', ReadTaskCommentAction::class)->setName('actions.comments.read');
            $group->put('/{id}', UpdateTaskCommentAction::class)->setName('actions.comments.update');
            $group->delete('/{id}', DeleteTaskCommentAction::class)->setName('actions.comments.delete');
        });

        $group->group('/invitations', function (Group $group) {
            $group->post('', CreateInvitationAction::class)->setName('actions.invitations.create');
            $group->get('', ListInvitationAction::class)->setName('actions.invitations.list');
            $group->get('/{id}', ReadInvitationAction::class)->setName('actions.invitations.read');
            $group->put('/{id}', UpdateInvitationAction::class)->setName('actions.invitations.answer');
            $group->delete('/{id}', DeleteInvitationAction::class)->setName('actions.invitations.delete');
        });

        $group->group('/users', function (Group $group) {
            $group->map(['PUT', 'PATCH'], '/{id}', UpdateUserAction::class)->setName('actions.users.update');
        });

    })->add(UserConnectedMiddleware::class);
};
