<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryRepository;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\ValidatorInterface;

class DisplayDashboardAction extends Action
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;

    public function __construct(
        LoggerInterface          $logger,
        Twig                     $twig,
        ResponseFactoryInterface $responseFactory,
        Messages                 $messages,
        TranslatorInterface      $translator,
        ValidatorInterface       $validator,
        CategoryRepository       $categoryRepository,
        UserCategoryRepository   $userCategoryRepository)
    {
        parent::__construct($logger, $twig, $responseFactory, $messages, $translator, $validator);
        $this->categoryRepository = $categoryRepository;
        $this->userCategoryRepository = $userCategoryRepository;
    }

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
            $category = $categories->sort(
                fn(UserCategory $a, UserCategory $b) => $a->getCategory()->getUpdatedAt() <=> $b->getCategory()->getUpdatedAt()
            )->first();
        }

        if (!isset($category)) {
            return $this->withError($this->translator->trans('DashboardCategoryNotFound'))->redirect('home');
        }

        if (!$category->isAccepted()) {
            // TODO: Send message : accept invite and redirect maybe to notifications page ?
        }

        $category->subCategories = $this->categoryRepository->getSubCategories($category->getCategory()->getId());

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
