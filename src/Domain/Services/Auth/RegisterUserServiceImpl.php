<?php

namespace App\Domain\Services\Auth;

use App\Domain\Auth\AuthInterface;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\User\User;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Auth\RegisterRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use App\Infrastructure\Repositories\UserRepository;
use Respect\Validation\Validator;

class RegisterUserServiceImpl extends Service implements RegisterUserService
{

    /**
     * @Inject
     * @var UserRepository
     */
    public UserRepository $userRepository;

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var AuthInterface
     */
    private AuthInterface $auth;

    /**
     * {@inheritDoc}
     */
    public function register(RegisterRequest $request): User
    {
        $validator = $this->validator->validate($request->getData(), [
            'email' => Validator::notBlank()->email()->length(0, 254),
            'username' => Validator::notBlank()->length(0, 64),
            'password' => Validator::notBlank()->regex('/[A-Z]/')->regex('/[a-z]/')
                ->regex('/[1-9]/')->regex('/[-_*.!?#@&]/')->length(6, 128),
            'password-conf' => Validator::equals($request->getPassword()),
        ]);

        if (!$validator->isValid()) {
            throw new BadRequestException($this->translator->trans('AuthRegisterFailed'));
        }

        $data = $validator->getValues();

        if ($this->userRepository->exists(email: $data['email'])) {
            throw new BadRequestException($this->translator->trans('AuthRegisterUserExist'));
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        if (!($this->userRepository->save($user))) {
            throw new RepositorySaveException($this->translator->trans('AuthRegisterFailed'));
        }

        // Create an example category for user
        $category = new Category();
        $category->setOwner($user);
        $category->setName("Example category");

        if (!$this->categoryRepository->save($category)) {
            throw new RepositorySaveException($this->translator->trans('AuthRegisterFailed'));
        }

        $userCategory = new UserCategory();
        $userCategory->setAccepted(true);
        $userCategory->setCanEdit(true);
        $userCategory->setCategory($category);
        $userCategory->setUser($user);

        if (!$this->userCategoryRepository->save($userCategory)) {
            throw new RepositorySaveException($this->translator->trans('AuthRegisterFailed'));
        }

        // Set user to session
        $this->auth->setUser($user);

        return $user;
    }
}