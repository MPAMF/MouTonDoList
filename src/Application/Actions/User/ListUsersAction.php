<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $this->logger->info("Users list was viewed.");

        try {
            $user = $this->userRepository->logUser('iperskill@gmail.com', 'test');
        } catch (UserNotFoundException $e) {
            return $this->respondWithData($e);
        }

        return $this->respondWithData($user);
    }
}
