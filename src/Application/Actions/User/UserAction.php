<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected UserRepository $userRepository;
    protected TaskRepository $tempRepo;
    protected CategoryRepository $categoryRepository;

    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        TaskRepository $tempRepo,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
        $this->tempRepo = $tempRepo;
        $this->categoryRepository = $categoryRepository;
    }
}
