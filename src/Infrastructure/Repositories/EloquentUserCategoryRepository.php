<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\DbCacheInterface;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryNotFoundException;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Exception;
use stdClass;

class EloquentUserCategoryRepository extends Repository implements UserCategoryRepository
{
    /**
     * @Inject
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @Inject
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var DbCacheInterface
     */
    private DbCacheInterface $dbCache;

    public function __construct()
    {
        parent::__construct('user_categories');
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
                $userCategory->user = $this->userRepository->get($userCategory->user_id, $with);
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

        $this->dbCache->save($this->tableName, $parsed->getId(), $parsed->toRow());

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, array|null $with = null): UserCategory
    {
        $found = $this->dbCache->load($this->tableName, $id) ?? $this->getDB()->table('categories')->where('id', $id)->first();
        return $this->parseUserCategory($found, $with);
    }

    /**
     * {@inheritdoc}
     */
    public function save(UserCategory $userCategory): bool
    {
        return $this->getTable()->updateOrInsert(
            $userCategory->toRow()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(UserCategory $userCategory): int
    {
        return $this->getTable()->delete($userCategory->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories(User|int $user, ?bool $accepted = null, array|null $with = null): array
    {
        $categories = [];
        $id = $user instanceof User ? $user->getId() : $user;
        $foundCategories = $this->getTable()->where('user_id', $id);
        if(isset($accepted)) $foundCategories = $foundCategories->where('accepted', $accepted);
        $foundCategories = $foundCategories->latest('updated_at')->get();

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
