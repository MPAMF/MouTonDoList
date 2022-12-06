<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\AnswerInvitationRequest;

interface AnswerInvitationService
{

    /**
     * @param AnswerInvitationRequest $request
     * @return UserCategory
     */
    public function answer(AnswerInvitationRequest $request): UserCategory;

}