<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\Category;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\ListInvitationRequest;
use App\Domain\Services\Models\Invitation\ListInvitationService;
use App\Domain\Services\Models\Invitation\ListInvitationServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use Tests\TestCase;

class ListInvitationServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private ListInvitationService $listInvitationService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->listInvitationService = new ListInvitationServiceImpl();
        $this->listInvitationService->categoryRepository = $this->categoryRepository;
        $this->listInvitationService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testListInvitation(): void
    {
        $this->categoryRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(new Category());

        $this->userCategoryRepository->expects($this->once())
            ->method('findByCategoryAndUser')
            ->with(1, 1)
            ->willReturn(new UserCategory());

        $invitations = $this->listInvitationService->list(new ListInvitationRequest(1, 1));
        $this->assertIsArray($invitations);
        $this->assertEmpty($invitations);
    }
}