<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\DisplayDashboardRequest;
use App\Domain\Services\Dashboard\DisplayDashboardService;
use Psr\Http\Message\ResponseInterface as Response;

class DisplayDashboardAction extends Action
{

    /**
     * @Inject
     * @var DisplayDashboardService
     */
    private DisplayDashboardService $displayDashboardService;

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = array_key_exists('id', $this->args) ? intval($this->args['id']) : null;
        // Access to service
        $request = new DisplayDashboardRequest(id: $id, user: $this->user());

        try {
            $data = $this->displayDashboardService->display($request);
        } catch (BadRequestException | UserNotFoundException $e) {
            return $this->withError($e->getMessage())->respondWithView('home/content.twig');
        }

        return $this->respondWithView('pages/dashboard.twig', $data);
    }

}
