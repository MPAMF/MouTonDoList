<?php
declare(strict_types=1);

use App\Domain\Services\Auth\LoginService;
use App\Domain\Services\Auth\LoginServiceImpl;
use App\Domain\Services\Auth\LogoutService;
use App\Domain\Services\Auth\LogoutServiceImpl;
use App\Domain\Services\Auth\RegisterUserService;
use App\Domain\Services\Auth\RegisterUserServiceImpl;
use App\Domain\Services\Auth\Token\TokenDecodeService;
use App\Domain\Services\Auth\Token\TokenDecodeServiceImpl;
use App\Domain\Services\Auth\Token\TokenGenService;
use App\Domain\Services\Auth\Token\TokenGenServiceImpl;
use App\Domain\Services\Auth\TokenLoginService;
use App\Domain\Services\Auth\TokenLoginServiceImpl;
use App\Domain\Services\Dashboard\DisplayDashboardService;
use App\Domain\Services\Dashboard\DisplayDashboardServiceImpl;
use App\Domain\Services\Models\Category\CreateCategoryService;
use App\Domain\Services\Models\Category\CreateCategoryServiceImpl;
use App\Domain\Services\Models\Category\DeleteCategoryService;
use App\Domain\Services\Models\Category\DeleteCategoryServiceImpl;
use App\Domain\Services\Models\Category\GetCategoryService;
use App\Domain\Services\Models\Category\GetCategoryServiceImpl;
use App\Domain\Services\Models\Category\UpdateCategoryService;
use App\Domain\Services\Models\Category\UpdateCategoryServiceImpl;
use App\Domain\Services\Models\Invitation\CreateInvitationService;
use App\Domain\Services\Models\Invitation\CreateInvitationServiceImpl;
use App\Domain\Services\Models\Invitation\DeleteInvitationService;
use App\Domain\Services\Models\Invitation\DeleteInvitationServiceImpl;
use App\Domain\Services\Models\Invitation\GetInvitationService;
use App\Domain\Services\Models\Invitation\GetInvitationServiceImpl;
use App\Domain\Services\Models\Invitation\ListInvitationService;
use App\Domain\Services\Models\Invitation\ListInvitationServiceImpl;
use App\Domain\Services\Models\Invitation\UpdateInvitationService;
use App\Domain\Services\Models\Invitation\UpdateInvitationServiceImpl;
use App\Domain\Services\Models\Task\CreateTaskService;
use App\Domain\Services\Models\Task\CreateTaskServiceImpl;
use App\Domain\Services\Models\Task\DeleteTaskService;
use App\Domain\Services\Models\Task\DeleteTaskServiceImpl;
use App\Domain\Services\Models\Task\GetTaskService;
use App\Domain\Services\Models\Task\GetTaskServiceImpl;
use App\Domain\Services\Models\Task\UpdateTaskService;
use App\Domain\Services\Models\Task\UpdateTaskServiceImpl;
use App\Domain\Services\Models\TaskComment\CreateTaskCommentService;
use App\Domain\Services\Models\TaskComment\CreateTaskCommentServiceImpl;
use App\Domain\Services\Models\TaskComment\DeleteTaskCommentService;
use App\Domain\Services\Models\TaskComment\DeleteTaskCommentServiceImpl;
use App\Domain\Services\Models\TaskComment\GetTaskCommentService;
use App\Domain\Services\Models\TaskComment\GetTaskCommentServiceImpl;
use App\Domain\Services\Models\TaskComment\UpdateTaskCommentService;
use App\Domain\Services\Models\TaskComment\UpdateTaskCommentServiceImpl;
use App\Domain\Services\Models\User\CreateUserService;
use App\Domain\Services\Models\User\CreateUserServiceImpl;
use App\Domain\Services\Models\User\DeleteUserService;
use App\Domain\Services\Models\User\DeleteUserServiceImpl;
use App\Domain\Services\Models\User\GetUserService;
use App\Domain\Services\Models\User\GetUserServiceImpl;
use App\Domain\Services\Models\User\UpdateUserService;
use App\Domain\Services\Models\User\UpdateUserServiceImpl;
use App\Domain\Services\Models\UserCategory\UserCategoryCheckPermissionService;
use App\Domain\Services\Models\UserCategory\UserCategoryCheckPermissionServiceImpl;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interfaces to their eloquent implementations
    $containerBuilder->addDefinitions([
        // Categories
        CreateCategoryService::class => autowire(CreateCategoryServiceImpl::class),
        UpdateCategoryService::class => autowire(UpdateCategoryServiceImpl::class),
        GetCategoryService::class => autowire(GetCategoryServiceImpl::class),
        DeleteCategoryService::class => autowire(DeleteCategoryServiceImpl::class),

        // Tasks
        CreateTaskService::class => autowire(CreateTaskServiceImpl::class),
        UpdateTaskService::class => autowire(UpdateTaskServiceImpl::class),
        GetTaskService::class => autowire(GetTaskServiceImpl::class),
        DeleteTaskService::class => autowire(DeleteTaskServiceImpl::class),

        // TaskComments
        CreateTaskCommentService::class => autowire(CreateTaskCommentServiceImpl::class),
        UpdateTaskCommentService::class => autowire(UpdateTaskCommentServiceImpl::class),
        GetTaskCommentService::class => autowire(GetTaskCommentServiceImpl::class),
        DeleteTaskCommentService::class => autowire(DeleteTaskCommentServiceImpl::class),

        // Users
        CreateUserService::class => autowire(CreateUserServiceImpl::class),
        UpdateUserService::class => autowire(UpdateUserServiceImpl::class),
        GetUserService::class => autowire(GetUserServiceImpl::class),
        DeleteUserService::class => autowire(DeleteUserServiceImpl::class),

        // Dashboard
        DisplayDashboardService::class => autowire(DisplayDashboardServiceImpl::class),

        // Auth
        RegisterUserService::class => autowire(RegisterUserServiceImpl::class),
        LoginService::class => autowire(LoginServiceImpl::class),
        TokenGenService::class => autowire(TokenGenServiceImpl::class),
        TokenDecodeService::class => autowire(TokenDecodeServiceImpl::class),

        // UserCategories
        UserCategoryCheckPermissionService::class => autowire(UserCategoryCheckPermissionServiceImpl::class),

        // Invitations
        CreateInvitationService::class => autowire(CreateInvitationServiceImpl::class),
        UpdateInvitationService::class => autowire(UpdateInvitationServiceImpl::class),
        ListInvitationService::class => autowire(ListInvitationServiceImpl::class),
        GetInvitationService::class => autowire(GetInvitationServiceImpl::class),
        DeleteInvitationService::class => autowire(DeleteInvitationServiceImpl::class),
    ]);
};
