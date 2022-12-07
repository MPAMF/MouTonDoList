<?php

namespace App\Domain\Services;

use App\Domain\Requests\DisplayDashboardRequest;

interface DisplayDashboardService
{

    /**
     * @param DisplayDashboardRequest $request
     * @return array
     */
    public function display(DisplayDashboardRequest $request): array;
}
