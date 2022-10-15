<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TestCategoriesSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'TestUsersSeeder',
        ];
    }

    /**
     * @param $user_id int
     * @return array[]
     */
    private function generateCategories(int $user_id): array
    {
        $idx = ($user_id-1) * 5*4;
        return [
            // Categories

            // University
            [
                'name' => 'University',
                'color' => '#FF5733',
                'position' => 0,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => null
            ], [
                'name' => 'Maths',
                'color' => '#2BB9C4',
                'position' => 0,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 1
            ], [
                'name' => 'Physics',
                'color' => '#185843',
                'position' => 1,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 1
            ], [
                'name' => 'Sport',
                'color' => '#DAF7A6',
                'position' => 2,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 1
            ], [
                'name' => 'French',
                'color' => '#FFC300',
                'position' => 3,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 1
            ],

            // Receipts
            [
                'name' => 'Receipts',
                'color' => '#FFC300',
                'position' => 1,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => null
            ], [
                'name' => 'Breakfast',
                'color' => '#2BB9C4',
                'position' => 0,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 6
            ], [
                'name' => 'Lunch',
                'color' => '#185843',
                'position' => 1,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 6
            ], [
                'name' => 'Diner',
                'color' => '#DAF7A6',
                'position' => 2,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 6
            ], [
                'name' => 'Sunday lunch',
                'color' => '#FFC300',
                'position' => 3,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 6
            ],

            // Shopping list
            [
                'name' => 'Shopping list',
                'color' => '#900C3F',
                'position' => 2,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => null
            ], [
                'name' => 'Super U',
                'color' => '#2BB9C4',
                'position' => 0,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 11
            ], [
                'name' => 'Ikea',
                'color' => '#185843',
                'position' => 1,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 11
            ], [
                'name' => 'Local grocery',
                'color' => '#DAF7A6',
                'position' => 2,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 11
            ], [
                'name' => 'Bakery',
                'color' => '#FFC300',
                'position' => 3,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 11
            ],

            // Suitcase
            [
                'name' => 'Suitcase',
                'color' => '#581845',
                'position' => 3,
                'archived' => true,
                'owner_id' => $user_id,
                'parent_category_id' => null
            ], [
                'name' => 'Voyage to France',
                'color' => '#2BB9C4',
                'position' => 0,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 16
            ], [
                'name' => 'Week-end at lake',
                'color' => '#185843',
                'position' => 1,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 16
            ], [
                'name' => 'Voyage to Hell',
                'color' => '#DAF7A6',
                'position' => 2,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 16
            ], [
                'name' => 'Montreal',
                'color' => '#FFC300',
                'position' => 3,
                'archived' => false,
                'owner_id' => $user_id,
                'parent_category_id' => $idx + 16
            ],
        ];
    }

    public function run(): void
    {
        $data = [];
        // Generate data for the 4 users
        for ($i = 1; $i <= 4; $i++)
            $data[] = $this->generateCategories($i);

        $posts = $this->table('categories');
        $posts->insert($data)->saveData();
    }
}
