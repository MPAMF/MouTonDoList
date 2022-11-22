<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\TaskRepository;
use App\Domain\TaskComment\TaskCommentRepository;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as Response;

class DisplayDashboardAction extends Action
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

    private function getArgsCategory(Collection $categories): ?UserCategory
    {
        if (!array_key_exists('id', $this->args))
            return null;

        $id = intval($this->args['id']);

        if ($id > 0) {
            return $categories->filter(fn(UserCategory $a) => $a->getCategory()->getId() == $id)->first();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $categories = collect($this->userCategoryRepository->getCategories($this->user()));
        $category = $this->getArgsCategory($categories);

        if (!isset($category)) {
            $category = $categories->first();
        }

        if (isset($category)) {

            if (!$category->isAccepted()) {
                // TODO: Send message : accept invite and redirect maybe to notifications page ?
            }

            $category->getCategory()->subCategories = $this->categoryRepository->getSubCategories($category->getCategory()->getId());

            foreach ($category->getCategory()->subCategories as $subCategory) {
                $subCategory->tasks = $this->taskRepository->getTasks($subCategory->getId());

                foreach ($subCategory->tasks as $task) {
                    $task->comments = $this->taskCommentRepository->getTaskComments($task->getId(), ['user']);
                }

            }

        }

        // Filter categories: archives / normal
        // TODO: utile de faire deux collections?
        $archivedCategories = $categories->filter(fn(UserCategory $a) => $a->getCategory()->isArchived());
        $categories = $categories->filter(fn(UserCategory $a) => !$a->getCategory()->isArchived());

        return $this->respondWithView('pages/dashboard.twig', [
            'category' => $category,
            'categories' => $categories,
            'archivedCategories' => $archivedCategories
        ]);
    }
}
