<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\CreateInvitationRequest;
use App\Domain\Services\Invitation\CreateInvitationService;
use App\Infrastructure\Services\Invitation\CreateInvitationServiceImpl;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Tests\TestCase;

class CreateInvitationServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private CreateInvitationService $createInvitationService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->createInvitationService = new CreateInvitationServiceImpl();
        $this->createInvitationService->categoryRepository = $this->categoryRepository;
        $this->createInvitationService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testCreateInvitation(): void
    {
        $expected = new UserCategory();
        $expected->setId(1);
        $expected->setUserId(1);
        $expected->setCategoryId(1);
        $expected->setAccepted(True);

        $data = [
            'user_id' => 1,
            'category_id' => 1,
            'accepted' => True,
        ];

        $request = new CreateInvitationRequest(1, $data);

        $this->categoryRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->expectException(CategoryNotFoundException::class);
        $this->createInvitationService->create($request);
    }
}
