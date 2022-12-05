<?php
declare(strict_types=1);

use App\Domain\Models\Category\Services\CreateCategoryService;
use App\Infrastructure\Services\Category\CreateCategoryServiceImpl;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interfaces to their eloquent implementations
    $containerBuilder->addDefinitions([
        CreateCategoryService::class => autowire(CreateCategoryServiceImpl::class),
    ]);
};
