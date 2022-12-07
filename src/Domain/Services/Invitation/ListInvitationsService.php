<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\AnswerInvitationRequest;
use App\Domain\Requests\Invitation\ListInvitationsRequest;

interface ListInvitationsService
{

    /**
     * @param ListInvitationsRequest $request
     * @return array
     */
    public function list(ListInvitationsRequest $request): array;

}