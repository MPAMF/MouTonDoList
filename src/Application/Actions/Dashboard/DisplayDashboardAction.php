<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
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

    public function __construct(
        LoggerInterface          $logger,
        Twig                     $twig,
        ResponseFactoryInterface $responseFactory,
        Messages                 $messages,
        TranslatorInterface      $translator,
        ValidatorInterface       $validator,
        CategoryRepository       $categoryRepository)
    {
        parent::__construct($logger, $twig, $responseFactory, $messages, $translator, $validator);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $categories = collect($this->categoryRepository->getCategories($this->user()->getId(), with: ['user']));
        $category = $categories->sortByDesc('updated_at')->first();

        if (!isset($category)) {
            return $this->withError($this->translator->trans('DashboardCategoryNotFound'))->redirect('home');
        }

        $category->subCategories = [];

        return $this->respondWithView('pages/dashboard.twig',
            ['category' => $category, 'categories' => $categories]);
    }
}
