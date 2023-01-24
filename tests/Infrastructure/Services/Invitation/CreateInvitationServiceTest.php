<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\Category\Category;
use App\Domain\Models\User\User;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\CreateInvitationRequest;
use App\Domain\Services\Models\Invitation\CreateInvitationService;
use App\Domain\Services\Models\Invitation\CreateInvitationServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use App\Infrastructure\Repositories\UserRepository;
use Symfony\Component\Translation\Translator;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class CreateInvitationServiceTest extends TestCase
{
    private UserCategoryRepository $userCategoryRepository;
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private CreateInvitationService $createInvitationService;
    private Translator $translator;

    public function setUp(): void
    {
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->translator = $this->createMock(Translator::class);
        $this->user = $this->createMock(User::class);
        $this->createInvitationService = new CreateInvitationServiceImpl(new Validator(), $this->translator);
        $this->createInvitationService->userCategoryRepository = $this->userCategoryRepository;
        $this->createInvitationService->categoryRepository = $this->categoryRepository;
        $this->createInvitationService->userRepository = $this->userRepository;
    }

    public function testCreateInvitation(): void
    {
        $userCategory = new UserCategory();
        $userCategory->setId(1);
        $userCategory->setUserId(1);
        $userCategory->setUser($this->createMock(User::class));
        $userCategory->setCategoryId(1);
        $userCategory->setCategory($this->createMock(Category::class));
        $userCategory->setAccepted(false);
        $userCategory->setCanEdit(false);

        $data = [
            'user_id' => 1,
            'category_id' => 1,
            'accepted' => false,
            'can_edit' => false,
        ];

        $request = new CreateInvitationRequest(1, $data);

        $this->userCategoryRepository->expects($this->once())
            ->method('save')->with(self::callback(function (UserCategory $c) {
                $c->setId(1);
                return true;
            }))->willReturn(true);

        $createdInvitation = $this->createInvitationService->create($request);

        // Ignore dates
        $createdInvitation->setCreatedAt($userCategory->getCreatedAt());
        $createdInvitation->setUpdatedAt($userCategory->getUpdatedAt());

        $this->assertEquals($createdInvitation, $userCategory);
    }
}
