<?php


use Phinx\Seed\AbstractSeed;

class TestUserCategoriesSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'TestUsersSeeder',
            'TestCategoriesSeeder',
        ];
    }

    public function run(): void
    {

        $data = [
            // Paul
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 1,
                'category_id' => 1
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 1,
                'category_id' => 6
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 1,
                'category_id' => 11
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 1,
                'category_id' => 16
            ],
            // Matthieu
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 21
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 26
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 31
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 36
            ],
            // Quentin
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 41
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 46
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 51
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 56
            ],
            // Victor
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 61
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 66
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 71
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 76
            ],
            // Create shared tasks
            // Paul => Matthieu
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 1,
                'category_id' => 26
            ],
            // All without Paul => Paul
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 2,
                'category_id' => 1
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 3,
                'category_id' => 1
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 4,
                'category_id' => 1
            ],
            // Create notifications
            // Paul => Matthieu
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 31
            ],
            // All without Paul => Paul
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 6
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 6
            ], [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 6
            ],

        ];

        $userCategories = $this->table('user_categories');
        $userCategories->insert($data)->saveData();
    }
}
