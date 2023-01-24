<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Services\Models\Invitation\DeleteInvitationService;
use App\Domain\Services\Models\Invitation\DeleteInvitationServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use Tests\TestCase;

class DeleteInvitationServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private DeleteInvitationService $deleteInvitationService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->deleteInvitationService = new DeleteInvitationServiceImpl();
        $this->deleteInvitationService->categoryRepository = $this->categoryRepository;
        $this->deleteInvitationService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testDeleteInvitation(): void
    {
        $this->categoryRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->expectException(CategoryNotFoundException::class);
        $this->deleteInvitationService->delete(new DeleteInvitationRequest(1, 1, 1));
    }
}