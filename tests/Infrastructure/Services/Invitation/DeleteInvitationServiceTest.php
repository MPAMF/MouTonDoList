<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Domain\Services\Models\Invitation\DeleteInvitationService;
use App\Domain\Services\Models\Invitation\DeleteInvitationServiceImpl;
use App\Domain\Services\Models\Invitation\GetInvitationService;
use App\Infrastructure\Repositories\UserCategoryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteInvitationServiceTest extends TestCase
{

    private $userCategoryRepository;
    private $getInvitationService;
    private $deleteInvitationService;

    public function setUp(): void
    {
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->getInvitationService = $this->createMock(GetInvitationService::class);
        $this->deleteInvitationService = new DeleteInvitationServiceImpl();
        $this->deleteInvitationService->userCategoryRepository = $this->userCategoryRepository;
        $this->deleteInvitationService->getInvitationService = $this->getInvitationService;
    }

    public function testDeleteInvitation(): void
    {
        $invitation = new UserCategory();
        $invitation->setId(1);
        $invitation->setUserId(1);
        $invitation->setCategoryId(1);
        $invitation->setAccepted(false);
        $invitation->setCanEdit(false);

        $this->getInvitationService->expects($this->once())
            ->method('get')->with(new GetInvitationRequest(1, 1))->willReturn($invitation);

        $this->userCategoryRepository->expects($this->once())
            ->method('delete')->with($invitation)->willReturn(1);

        $request = new DeleteInvitationRequest(1, 1);
        $this->assertTrue($this->deleteInvitationService->delete($request));
    }
}
