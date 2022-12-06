<?php

namespace App\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\AnswerInvitationRequest;
use App\Domain\Services\Invitation\AnswerInvitationService;

class AnswerInvitationServiceImpl implements AnswerInvitationService
{

    public function answer(AnswerInvitationRequest $request): UserCategory
    {
        // TODO: Implement answer() method.
        return new UserCategory();
    }

}