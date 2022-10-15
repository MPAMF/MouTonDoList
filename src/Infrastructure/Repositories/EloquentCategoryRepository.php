<?php
declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Exception;
use Illuminate\Database\DatabaseManager;

class EloquentCategoryRepository extends Repository implements CategoryRepository
{

    private UserRepository $userRepository;

    /**
     * @param DatabaseManager $db
     * @param UserRepository $userRepository
     */
    public function __construct(DatabaseManager $db, UserRepository $userRepository)
    {
        parent::__construct($db);
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id): Category
    {
        $found = $this->getDB()->table('categories')->where('id', $id)->first();

        if (empty($found)) {
            throw new CategoryNotFoundException();
        }

        if (empty($found->parent_category_id)) {
            $found->parentCategory = null;
        } else {
            try {
                $found->parentCategory = $this->get($found->parent_category_id);
            } catch (CategoryNotFoundException) {
                $found->parentCategory = null;
            }
        }

        try {
            $found->owner = $this->userRepository->get($found->owner_id);
        } catch (UserNotFoundException) {
            $found->owner = null;
        }

        $parsed = new Category();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($found);
        } catch (Exception) {
            throw new CategoryNotFoundException();
        }

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Category $category)
    {
        $this->getDB()->table('categories')->updateOrInsert(
            $category->toRow()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Category $category)
    {
        $this->getDB()->table('categories')->delete($category->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories($user_id): array
    {
        $categories = [];

        $foundCategories = $this->getDB()->table('categories')
            ->where('owner_id', $user_id)
            ->where('parent_category_id', null) // no sub-categories
            ->orderBy('position')
            ->get();

        foreach ($foundCategories as $category) {
            $catInstance = new Category();
            try {
                $catInstance->fromRow($category);
            } catch (Exception) {
                continue;
            }
            $categories[] = $catInstance;
        }

        return $categories;
    }
}
