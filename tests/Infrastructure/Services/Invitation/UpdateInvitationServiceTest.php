<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\Category;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;
use App\Domain\Services\Invitation\UpdateInvitationService;
use App\Infrastructure\Services\Invitation\UpdateInvitationServiceImpl;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Tests\TestCase;

class UpdateInvitationServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private UpdateInvitationService $updateInvitationService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->updateInvitationService = new UpdateInvitationServiceImpl();
        $this->updateInvitationService->categoryRepository = $this->categoryRepository;
        $this->updateInvitationService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testUpdateInvitation(): void
    {
        $this->userCategoryRepository->expects($this->once())
            ->method('update');

        $expected = new UserCategory();
        $expected->setId(1);
        $expected->setCategoryId(1);
        $expected->setUserId(1);
        $expected->setRole('test');
        $expected->setArchived(false);
        $data = [
            'category_id' => 1,
            'user_id' => 1,
            'role' => 'test',
            'archived' => false,
        ];

        $request = new UpdateInvitationRequest(1, 1, $data);

        $this->categoryRepository->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn(new Category());

        $this->userCategoryRepository->expects($this->once())
            ->method('getById')
            ->with(1, 1)
            ->willReturn($expected);

        $updatedInvitation = $this->updateInvitationService->update($request);

        $expected->setCreatedAt($updatedInvitation->getCreatedAt());
        $expected->setUpdatedAt($updatedInvitation->getUpdatedAt());

        $this->assertEquals($updatedInvitation, $expected);
    }
}