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
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\Validator;

class CreateInvitationServiceTest extends TestCase
{
    private UserCategoryRepository $userCategoryRepository;
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private CreateInvitationService $createInvitationService;
    private TranslatorInterface $translator;

    public function setUp(): void
    {
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->createInvitationService = new CreateInvitationServiceImpl(new Validator(), $this->translator);
        $this->createInvitationService->userCategoryRepository = $this->userCategoryRepository;
        $this->createInvitationService->categoryRepository = $this->categoryRepository;
        $this->createInvitationService->userRepository = $this->userRepository;
    }

    public function testCreateInvitation(): void
    {
        $this->userCategoryRepository->expects($this->once())
            ->method('save');
        $this->userCategoryRepository->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $expected = new UserCategory();
        $expected->setId(1);
        $expected->setUserId(1);
        $expected->setCategoryId(1);
        $expected->setAccepted(false);
        $expected->setCanEdit(false);

        $data = [
            'user_id' => 1,
            'category_id' => 1,
            'accepted' => false,
            'can_edit' => false,
        ];

        $request = new CreateInvitationRequest(1, $data);

        $this->categoryRepository->expects($this->once())
            ->method('get')
            ->willReturn(new Category());

        $this->userRepository->expects($this->once())
            ->method('get')
            ->willReturn(new User());

        $createdInvitation = $this->createInvitationService->create($request);

        $this->assertEquals($createdInvitation, $expected);
    }
}