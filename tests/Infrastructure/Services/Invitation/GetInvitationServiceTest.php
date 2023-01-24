<?php

namespace Tests\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Domain\Services\Models\Invitation\GetInvitationService;
use App\Domain\Services\Models\Invitation\GetInvitationServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use App\Infrastructure\Repositories\UserRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class GetInvitationServiceTest extends TestCase
{
    private UserCategoryRepository $userCategoryRepository;
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private GetInvitationService $getInvitationService;
    private TranslatorInterface $translator;

    public function setUp(): void
    {
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->getInvitationService = new GetInvitationServiceImpl(new Validator(), $this->translator);
        $this->getInvitationService->userCategoryRepository = $this->userCategoryRepository;
        $this->getInvitationService->categoryRepository = $this->categoryRepository;
        $this->getInvitationService->userRepository = $this->userRepository;
    }

    public function testGetInvitation(): void
    {
        $expected = new UserCategory();
        $expected->setId(1);
        $expected->setUserId(1);
        $expected->setCategoryId(1);
        $expected->setAccepted(true);
        $expected->setCanEdit(true);

        $this->userCategoryRepository->expects($this->once())
            ->method('get')->with(1, ['category', 'user'])->willReturn($expected);

        $request = new GetInvitationRequest(1, 1,Null);

        $result = $this->getInvitationService->get($request);

        $this->assertEquals($result, $expected);
    }
}
