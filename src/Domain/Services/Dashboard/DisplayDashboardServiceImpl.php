<?php

namespace App\Domain\Services\Dashboard;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\DisplayDashboardRequest;
use App\Domain\Services\Auth\Token\TokenGenService;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\TaskCommentRepository;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;

class DisplayDashboardServiceImpl implements DisplayDashboardService
{

    /**
     * @Inject
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    private UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @Inject
     * @var TaskCommentRepository
     */
    private TaskCommentRepository $taskCommentRepository;

    /**
     * @Inject
     * @var TokenGenService
     */
    private TokenGenService $tokenGenService;

    /**
     * {@inheritDoc}
     */
    public function display(DisplayDashboardRequest $request): array
    {
        $userId = $request->getUser()->getId();
        $categories = collect($this->userCategoryRepository->getCategories($userId, accepted: true));

        if ($request->getId() != null) {
            $category = $categories->filter(fn(UserCategory $a) => $a->getCategory()->getId() == $request->getId())
                ->first();
        }

        if (!isset($category)) {
            $category = $categories->first();
        }

        if (isset($category)) {

            $category->getCategory()->subCategories = $this->categoryRepository
                ->getSubCategories($category->getCategory()->getId());

            foreach ($category->getCategory()->subCategories as $subCategory) {
                $subCategory->tasks = $this->taskRepository->getTasks($subCategory->getId(), ['assigned']);

                foreach ($subCategory->tasks as $task) {
                    $task->comments = $this->taskCommentRepository->getTaskComments($task->getId(), ['author']);
                }
            }

            // Filter categories: archives / normal
            $categories->each(function (UserCategory $a) {
                $a->members = $this->userCategoryRepository->getUsers($a->getCategoryId());
            });
            $archivedCategories = $categories->filter(fn(UserCategory $a) => $a->getCategory()->isArchived());
            $categories = $categories->filter(fn(UserCategory $a) => !$a->getCategory()->isArchived());

            // Get current member
            $category->members = $this->userCategoryRepository->getUsers($category->getCategoryId());
            $canEdit = $category->getCategory()->getOwnerId() == $userId || collect($category->members)
                    ->contains(fn(UserCategory $a) => $a->getUserId() == $userId && $a->isCanEdit());

        }

        // TODO: delete notifications => to rest get request
        $notifications = collect($this->userCategoryRepository->getCategories($userId, accepted: false));

        $apiToken = $this->tokenGenService->generate($request->getUser());

        return [
            'category' => $category,
            'categories' => $categories ?? collect(),
            'archivedCategories' => $archivedCategories ?? collect(),
            'user' => $request->getUser(),
            'canEdit' => $canEdit ?? false,
            'notifications' => $notifications,
            'apiToken' => $apiToken
        ];
    }
}
