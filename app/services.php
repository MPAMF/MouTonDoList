<?php
declare(strict_types=1);

use App\Domain\Models\Category\Services\CreateCategoryService;
use App\Domain\Models\Category\Services\DeleteCategoryService;
use App\Domain\Models\Category\Services\GetCategoryService;
use App\Domain\Models\Category\Services\UpdateCategoryService;
use App\Infrastructure\Services\Category\CreateCategoryServiceImpl;
use App\Infrastructure\Services\Category\DeleteCategoryServiceImpl;
use App\Infrastructure\Services\Category\GetCategoryServiceImpl;
use App\Infrastructure\Services\Category\UpdateCategoryServiceImpl;
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
    ]);
};
