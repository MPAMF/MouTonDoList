<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\DisplayDashboardRequest;
use App\Domain\Services\DisplayDashboardService;
use Illuminate\Support\Collection;
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
        $data = $this->displayDashboardService->display($request);

        return $this->respondWithView('pages/dashboard.twig', $data);
    }


}
