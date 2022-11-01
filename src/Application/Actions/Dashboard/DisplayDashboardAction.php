<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Application\Actions\User\UserAction;
use App\Domain\Category\CategoryRepository;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class DisplayDashboardAction extends DashboardAction
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

        return $this->twig->render($this->response, 'pages/dashboard.twig');
        //return $this->respondWithData("");
    }
}
