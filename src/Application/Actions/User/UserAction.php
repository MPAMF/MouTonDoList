<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected UserRepository $userRepository;
    protected TaskRepository $tempRepo;
    protected CategoryRepository $categoryRepository;

    public function __construct(
        LoggerInterface    $logger,
        UserRepository     $userRepository,
        TaskRepository     $tempRepo,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
        $this->tempRepo = $tempRepo;
        $this->categoryRepository = $categoryRepository;
    }
}
