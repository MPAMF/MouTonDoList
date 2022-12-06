<?php

namespace App\Infrastructure\Services;

use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\DisplayDashboardRequest;
use App\Domain\Services\DisplayDashboardService;
use Illuminate\Support\Collection;

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
            if (!$category->isAccepted()) {
                // TODO: Send message : accept invite and redirect maybe to notifications page ?
            }

            $category->getCategory()->subCategories = $this->categoryRepository
                ->getSubCategories($category->getCategory()->getId());

            foreach ($category->getCategory()->subCategories as $subCategory) {
                $subCategory->tasks = $this->taskRepository->getTasks($subCategory->getId(), ['assigned']);

                foreach ($subCategory->tasks as $task) {
                    $task->comments = $this->taskCommentRepository->getTaskComments($task->getId(), ['author']);
                }
            }
        }

        // Filter categories: archives / normal
        // TODO: utile de faire deux collections?
        $categories->each(function (UserCategory $a) {
            $a->members = $this->userCategoryRepository->getUsers($a->getCategoryId());
        });
        $archivedCategories = $categories->filter(fn(UserCategory $a) => $a->getCategory()->isArchived());
        $categories = $categories->filter(fn(UserCategory $a) => !$a->getCategory()->isArchived());

        // Get current member
        $category->members = $this->userCategoryRepository->getUsers($category->getCategoryId());
        $canEdit = $category->getCategory()->getOwnerId() == $userId || collect($category->members)
                ->contains(fn(UserCategory $a) => $a->getUserId() == $this->get()->getId() && $a->isCanEdit());

        // TODO: delete notifications => to rest get request
        $notifications = collect($this->userCategoryRepository->getCategories($userId, accepted: false));

        return [
            'category' => $category,
            'categories' => $categories,
            'archivedCategories' => $archivedCategories,
            'user' => $request->getUser(),
            'canEdit' => $canEdit,
            'notifications' => $notifications
        ];
    }

}