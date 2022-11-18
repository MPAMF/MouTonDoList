<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Application\Actions\User\UserAction;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\TaskRepository;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class DisplayDashboardAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $this->logger->info("Dashboard action was viewed.");
        /*
                try {
                    $user = $this->userRepository->logUser('iperskill@gmail.com', 'test');
                } catch (UserNotFoundException $e) {
                    return $this->respondWithData($e);
                }*/

        $category = new Category();
        $category->setId(2);
        $category->setOwner(new User());
        $category->setName("Voyage en Corée");
        $category->setColor("#FFFFFF");
        $category->setPosition(0);
        $category->setArchived(false);

        return $this->respondWithView('pages/dashboard.twig',
                ['category' => $category]);
    }
}