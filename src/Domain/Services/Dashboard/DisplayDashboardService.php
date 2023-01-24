<?php

namespace App\Domain\Services\Dashboard;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\DisplayDashboardRequest;

interface DisplayDashboardService
{

    /**
     * @param DisplayDashboardRequest $request
     * @return array
     * @throws BadRequestException
     * @throws UserNotFoundException
     */
    public function display(DisplayDashboardRequest $request): array;
}
