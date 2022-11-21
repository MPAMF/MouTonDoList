<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryNotFoundException;
use App\Domain\UserCategory\UserCategoryRepository;
use Exception;
use Illuminate\Database\DatabaseManager;
use stdClass;

class EloquentUserCategoryRepository extends Repository implements UserCategoryRepository
{
    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;

    /**
     * @param DatabaseManager $db
     * @param UserRepository $userRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(DatabaseManager $db, UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct($db);
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param stdClass $userCategory
     * @param array|null $with
     * @return UserCategory
     * @throws UserCategoryNotFoundException
     */
    private function parseUserCategory(stdClass $userCategory, array|null $with = ['user']): UserCategory
    {
        if (empty($userCategory)) {
            throw new UserCategoryNotFoundException();
        }

        if ($with == null || !in_array('user', $with)) {
            $userCategory->user = null;
        } else {
            try {
                $userCategory->user = $this->userRepository->get($userCategory->user_id);
            } catch (UserNotFoundException) {
                // Should never happen.
                throw new UserCategoryNotFoundException();
            }
        }

        try {
            $userCategory->category = $this->categoryRepository->get($userCategory->category_id, $with);
        } catch (CategoryNotFoundException) {
            // Should never happen.
            throw new UserCategoryNotFoundException();
        }

        $parsed = new UserCategory();
        // If there's a parsing error, just show the usercategory a not found exception.
        try {
            $parsed->fromRow($userCategory);
        } catch (Exception) {
            throw new UserCategoryNotFoundException();
        }

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, array|null $with = ['user']): UserCategory
    {
        $found = $this->getDB()->table('categories')->where('id', $id)->first();
        return $this->parseUserCategory($found, $with);
    }

    /**
     * {@inheritdoc}
     */
    public function save(UserCategory $userCategory): bool
    {
        return $this->getDB()->table('user_categories')->updateOrInsert(
            $userCategory->toRow()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(UserCategory $userCategory) : int
    {
        return $this->getDB()->table('user_categories')->delete($userCategory->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories(User|int $user, array|null $with = null) : array
    {
        $categories = [];
        $id = $user instanceof User ? $user->getId() : $user;
        $foundCategories = $this->getDB()->table('user_categories')
            ->where('user_id', $id)
            ->get();

        foreach ($foundCategories as $category) {

            try {
                $categories[] = $this->parseUserCategory($category, $with);
            } catch (UserCategoryNotFoundException) {
                // do nothing
            }

        }

        return $categories;
    }

}
