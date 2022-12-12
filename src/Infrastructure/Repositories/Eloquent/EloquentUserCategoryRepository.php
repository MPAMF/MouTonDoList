<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\DbCacheInterface;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\Repository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use App\Infrastructure\Repositories\UserRepository;
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
     * @param stdClass|null $userCategory
     * @param array|null $with
     * @return UserCategory
     * @throws UserCategoryNotFoundException
     */
    private function parseUserCategory(stdClass|null $userCategory, array|null $with = ['user']): UserCategory
    {
        if (!isset($userCategory)) {
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
        $found = $this->dbCache->load($this->tableName, $id) ?? $this->getTable()->where('id', $id)->first();
        if (is_array($found)) $found = (object)$found;
        return $this->parseUserCategory($found, $with);
    }

    /**
     * {@inheritdoc}
     */
    public function save(UserCategory $userCategory): bool
    {
        // Create
        if ($userCategory->getId() == null) {
            $id = $this->getTable()->insertGetId($userCategory->toRow());
            $userCategory->setId($id);
            return $id != 0;
        }

        return $this->getTable()->where('id', $userCategory->getId())
                ->update($userCategory->toRow()) != 0;
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
        if (isset($accepted)) $foundCategories = $foundCategories->where('accepted', $accepted);
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

    /**
     * {@inheritDoc}
     */
    public function getUsers(int|Category $category, array|null $with = null): array
    {
        $id = $category instanceof Category ? $category->getId() : $category;
        $foundUserCategories = $this->getTable()->where('category_id', $id)->where('accepted', true)->get();

        if (!isset($with)) {
            $with = ['user'];
        } else if (!array_key_exists('user', $with)) {
            $with[] = 'user';
        }

        $users = [];

        foreach ($foundUserCategories as $userCategory) {

            try {
                $users[] = $this->parseUserCategory($userCategory, $with);
            } catch (UserCategoryNotFoundException) {
                // do nothing
            }

        }

        return $users;
    }

    public function exists(?int $id, ?int $categoryId = null, ?int $userId = null, ?bool $accepted = null, ?bool $canEdit = null): bool
    {
        $builder = $this->getTable();
        if (isset($id)) $builder = $builder->where('id', $id);
        if (isset($categoryId)) $builder = $builder->where('category_id', $categoryId);
        if (isset($userId)) $builder = $builder->where('user_id', $userId);
        if (isset($accepted)) $builder = $builder->where('accepted', $accepted);
        if (isset($canEdit)) $builder = $builder->where('can_edit', $canEdit);
        return $builder->exists();
    }

}
