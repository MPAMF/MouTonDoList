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
use stdClass;

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
     * @param stdClass $category
     * @return Category
     * @throws CategoryNotFoundException
     */
    private function parseCategory(stdClass $category) : Category
    {
        if(empty($category))
        {
            throw new CategoryNotFoundException();
        }

        if (empty($category->parent_category_id)) {
            $category->parentCategory = null;
        } else {
            try {
                $category->parentCategory = $this->get($category->parent_category_id);
            } catch (CategoryNotFoundException) {
                $category->parentCategory = null;
            }
        }

        try {
            $category->owner = $this->userRepository->get($category->owner_id);
        } catch (UserNotFoundException) {
            $category->owner = null;
        }

        $parsed = new Category();
        // If there's a parsing error, just show the user a not found exception.
        try {
            $parsed->fromRow($category);
        } catch (Exception) {
            throw new CategoryNotFoundException();
        }

        return $parsed;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id): Category
    {
        $found = $this->getDB()->table('categories')->where('id', $id)->first();
        return $this->parseCategory($found);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Category $category) : bool
    {
        return $this->getDB()->table('categories')->updateOrInsert(
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

            try {
                $categories[] = $this->parseCategory($category);
            } catch (CategoryNotFoundException) {
                // do nothing
            }

        }

        return $categories;
    }
}
