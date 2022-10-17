<?php
declare(strict_types=1);

use App\Domain\Category\CategoryRepository;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Repositories\EloquentCategoryRepository;
use App\Infrastructure\Repositories\EloquentTaskRepository;
use App\Infrastructure\Repositories\EloquentUserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interfaces to their eloquent implementations
    $containerBuilder->addDefinitions([
        UserRepository::class => autowire(EloquentUserRepository::class),
        TaskRepository::class => autowire(EloquentTaskRepository::class),
        CategoryRepository::class => autowire(EloquentCategoryRepository::class)
    ]);
};
