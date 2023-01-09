<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Domain\Services\Invitation\GetInvitationService;
use App\Infrastructure\Services\Invitation\GetInvitationServiceImpl;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Tests\TestCase;

class GetInvitationServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private GetInvitationService $getInvitationService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->getInvitationService = new GetInvitationServiceImpl();
        $this->getInvitationService->categoryRepository = $this->categoryRepository;
        $this->getInvitationService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testGetInvitation(): void
    {
        $this->categoryRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->expectException(CategoryNotFoundException::class);
        $this->getInvitationService->get(new GetInvitationRequest(1, 1, 1));
    }
}