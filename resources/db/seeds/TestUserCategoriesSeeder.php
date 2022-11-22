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
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 1,
                'category_id' => 1
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 1,
                'category_id' => 6
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 1,
                'category_id' => 11
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 1,
                'category_id' => 16
            ],
            // Matthieu
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 2,
                'category_id' => 21
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 2,
                'category_id' => 26
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 2,
                'category_id' => 31
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 2,
                'category_id' => 36
            ],
            // Quentin
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 3,
                'category_id' => 41
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 3,
                'category_id' => 46
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 3,
                'category_id' => 51
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 3,
                'category_id' => 56
            ],
            // Victor
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 4,
                'category_id' => 61
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 4,
                'category_id' => 66
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 4,
                'category_id' => 71
            ], [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 4,
                'category_id' => 76
            ],
            // Create shared categories
            // Paul => Matthieu
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 1,
                'category_id' => 26 // Matthieu
            ],
            // Matthieu => Paul
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 2,
                'category_id' => 1
            ],
            // Quentin => Victor
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 3,
                'category_id' => 66
            ],
            // Victor => Quentin
            [
                'accepted' => true,
                'can_edit' => true,
                'user_id' => 4,
                'category_id' => 41
            ],
            // Accepted readonly
            // Paul => Victor
            [
                'accepted' => true,
                'can_edit' => false,
                'user_id' => 1,
                'category_id' => 76 // Victor
            ],
            // Matthieu => Quentin
            [
                'accepted' => true,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 41
            ],
            // Quentin => Matthieu
            [
                'accepted' => true,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 21
            ],
            // Victor => Paul
            [
                'accepted' => true,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 1
            ],
            // Create notifications
            // Paul => Matthieu
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 1,
                'category_id' => 31
            ],
            // Matthieu => Paul
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 2,
                'category_id' => 6
            ],
            // Quentin => Victor
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 3,
                'category_id' => 61
            ],
            // Victor => Quentin
            [
                'accepted' => false,
                'can_edit' => false,
                'user_id' => 4,
                'category_id' => 71
            ],

        ];

        $userCategories = $this->table('user_categories');
        $userCategories->insert($data)->saveData();
    }
}
