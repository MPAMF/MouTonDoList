<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\DbCacheInterface;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Repositories\CategoryRepository;
use App\Domain\Repositories\UserRepository;
use App\Infrastructure\Repositories\Repository;
use Exception;
use stdClass;

class EloquentCategoryRepository extends Repository implements CategoryRepository
{

    /**
     * @Inject()
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @Inject()
     * @var DbCacheInterface
     */
    private DbCacheInterface $dbCache;

    public function __construct()
    {
        parent::__construct('categories');
    }

    /**
     * @param stdClass|null $category
     * @param array|null $with
     * @return Category
     * @throws CategoryNotFoundException
     */
    private function parseCategory(stdClass|null $category, array|null $with = ['parentCategory', 'owner']): Category
    {
        if (!isset($category)) {
            throw new CategoryNotFoundException();
        }

        if (empty($category->parent_category_id) || $with == null || !in_array('parentCategory', $with)) {
            $category->parentCategory = null;
        } else {
            try {
                $category->parentCategory = $this->get($category->parent_category_id, $with);
            } catch (CategoryNotFoundException) {
                $category->parentCategory = null;
            }
        }

        if ($with == null || !in_array('owner', $with)) {
            $category->owner = null;
        } else {
            try {
                $category->owner = $this->userRepository->get($category->owner_id, $with);
            } catch (UserNotFoundException) {
                $category->owner = null;
            }
        }

        $parsed = new Category();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($category);
        } catch (Exception) {
            throw new CategoryNotFoundException();
        }

        $this->dbCache->save($this->tableName, $parsed->getId(), $parsed->toRow());

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, array|null $with = null): Category
    {
        $found = $this->dbCache->load($this->tableName, $id) ?? $this->getTable()->where('id', $id)->first();
        if(is_array($found)) $found = (object) $found;
        return $this->parseCategory($found, $with);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Category $category): bool
    {
        // Create
        if ($category->getId() == null) {
            $id = $this->getTable()->insertGetId($category->toRow());
            $category->setId($id);
            return $id != 0;
        }

        return $this->getTable()->where('id', $category->getId())
                ->update($category->toRow()) != 0;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Category $category): int
    {
        return $this->getDB()->table('categories')->delete($category->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories($user_id, array|null $with = ['parentCategory', 'owner']): array
    {
        $categories = [];

        $foundCategories = $this->getDB()->table('categories')
            ->where('owner_id', $user_id)
            ->where('parent_category_id', null) // no sub-categories
            ->orderBy('position')
            ->get();

        foreach ($foundCategories as $category) {

            try {
                $categories[] = $this->parseCategory($category, $with);
            } catch (CategoryNotFoundException) {
                // do nothing
            }

        }

        return $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubCategories($parentCategoryId, array|null $with = null): array
    {
        $categories = [];

        $foundCategories = $this->getDB()->table('categories')
            ->where('parent_category_id', $parentCategoryId)
            ->orderBy('position')
            ->get();

        foreach ($foundCategories as $category) {

            try {
                $categories[] = $this->parseCategory($category, $with);
            } catch (CategoryNotFoundException) {
                // do nothing
            }

        }

        return $categories;
    }

    public function getLastUpdatedCategory(int $user_id, ?array $with = null): ?Category
    {
        $found = $this->getDB()->table('categories')
            ->where('owner_id', $user_id)
            ->where('parent_category_id', null) // no sub-categories
            ->latest('updated_at')
            ->first();

        try {
            return $this->parseCategory($found, $with);
        } catch (CategoryNotFoundException) {
            return null;
        }

    }

    /**
     * {@inheritDoc}
     */
    public function exists(?int $id, ?int $parentCategoryId = null): bool
    {
        $builder = $this->getTable();
        if (isset($id)) $builder = $builder->where('id', $id);
        if (isset($parentCategoryId)) $builder = $builder->where('parent_category_id', $parentCategoryId);
        return $builder->exists();
    }
}
