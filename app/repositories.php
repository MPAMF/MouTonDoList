<?php
declare(strict_types=1);

use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\Eloquent\EloquentCategoryRepository;
use App\Infrastructure\Repositories\Eloquent\EloquentTaskCommentRepository;
use App\Infrastructure\Repositories\Eloquent\EloquentTaskRepository;
use App\Infrastructure\Repositories\Eloquent\EloquentUserCategoryRepository;
use App\Infrastructure\Repositories\Eloquent\EloquentUserRepository;
use App\Infrastructure\Repositories\TaskCommentRepository;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use App\Infrastructure\Repositories\UserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interfaces to their eloquent implementations
    $containerBuilder->addDefinitions([
        UserRepository::class => autowire(EloquentUserRepository::class),
        TaskRepository::class => autowire(EloquentTaskRepository::class),
        CategoryRepository::class => autowire(EloquentCategoryRepository::class),
        UserCategoryRepository::class => autowire(EloquentUserCategoryRepository::class),
        TaskCommentRepository::class => autowire(EloquentTaskCommentRepository::class),
    ]);
};
