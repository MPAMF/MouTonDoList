<?php
declare(strict_types=1);

use App\Domain\Services\Category\CreateCategoryService;
use App\Domain\Services\Category\CreateCategoryServiceImpl;
use App\Domain\Services\Category\DeleteCategoryService;
use App\Domain\Services\Category\DeleteCategoryServiceImpl;
use App\Domain\Services\Category\GetCategoryService;
use App\Domain\Services\Category\GetCategoryServiceImpl;
use App\Domain\Services\Category\UpdateCategoryService;
use App\Domain\Services\Category\UpdateCategoryServiceImpl;
use App\Domain\Services\DisplayDashboardService;
use App\Domain\Services\DisplayDashboardServiceImpl;
use App\Domain\Services\Invitation\CreateInvitationService;
use App\Domain\Services\Invitation\CreateInvitationServiceImpl;
use App\Domain\Services\Invitation\DeleteInvitationService;
use App\Domain\Services\Invitation\DeleteInvitationServiceImpl;
use App\Domain\Services\Invitation\GetInvitationService;
use App\Domain\Services\Invitation\GetInvitationServiceImpl;
use App\Domain\Services\Invitation\ListInvitationService;
use App\Domain\Services\Invitation\ListInvitationServiceImpl;
use App\Domain\Services\Invitation\UpdateInvitationService;
use App\Domain\Services\Invitation\UpdateInvitationServiceImpl;
use App\Domain\Services\Task\CreateTaskService;
use App\Domain\Services\Task\CreateTaskServiceImpl;
use App\Domain\Services\Task\DeleteTaskService;
use App\Domain\Services\Task\DeleteTaskServiceImpl;
use App\Domain\Services\Task\GetTaskService;
use App\Domain\Services\Task\GetTaskServiceImpl;
use App\Domain\Services\Task\UpdateTaskService;
use App\Domain\Services\Task\UpdateTaskServiceImpl;
use App\Domain\Services\TaskComment\CreateTaskCommentService;
use App\Domain\Services\TaskComment\CreateTaskCommentServiceImpl;
use App\Domain\Services\TaskComment\DeleteTaskCommentService;
use App\Domain\Services\TaskComment\DeleteTaskCommentServiceImpl;
use App\Domain\Services\TaskComment\GetTaskCommentService;
use App\Domain\Services\TaskComment\GetTaskCommentServiceImpl;
use App\Domain\Services\TaskComment\UpdateTaskCommentService;
use App\Domain\Services\TaskComment\UpdateTaskCommentServiceImpl;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionService;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionServiceImpl;
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
        // TODO:
        // CreateUserService::class => autowire(CreateUserServiceImpl::class),
        // UpdateUserService::class => autowire(UpdateUserServiceImpl::class),
        // GetUserService::class => autowire(GetUserServiceImpl::class),
        // DeleteUserService::class => autowire(DeleteUserServiceImpl::class),

        // Dashboard
        DisplayDashboardService::class => autowire(DisplayDashboardServiceImpl::class),

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
