<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\Category;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;
use App\Domain\Services\Models\Invitation\UpdateInvitationService;
use App\Domain\Services\Models\Invitation\UpdateInvitationServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use Symfony\Component\Translation\Translator;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class UpdateInvitationServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private UpdateInvitationService $updateInvitationService;
    private Translator $translator;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->translator = $this->createMock(Translator::class);
        $this->updateInvitationService = new UpdateInvitationServiceImpl(new Validator(), $this->translator);
        $this->updateInvitationService->categoryRepository = $this->categoryRepository;
        $this->updateInvitationService->userCategoryRepository = $this->userCategoryRepository;
    }

    public function testUpdateInvitation(): void
    {
        $this->userCategoryRepository->expects($this->once())
            ->method('save');

        $expected = new UserCategory();
        $expected->setId(1);
        $expected->setCategoryId(1);
        $expected->setUserId(1);
        $expected->setCanEdit(false);
        $expected->setAccepted(false);
        $data = [
            'category_id' => 1,
            'user_id' => 1,
            'can_edit' => false,
            'accepted' => false,
        ];

        $request = new UpdateInvitationRequest(1, 1, $data);

        $this->categoryRepository->expects($this->once())
            ->method('save')
            ->with(1)
            ->willReturn(true);

        $updatedInvitation = $this->updateInvitationService->update($request);

        $expected->setCreatedAt($updatedInvitation->getCreatedAt());
        $expected->setUpdatedAt($updatedInvitation->getUpdatedAt());

        $this->assertEquals($updatedInvitation, $expected);
    }
}