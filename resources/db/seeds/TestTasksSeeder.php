<?php
declare(strict_types=1);

use App\Domain\Category\Category;
use App\Domain\User\User;
use Phinx\Seed\AbstractSeed;

class TestTasksSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'TestCategoriesSeeder',
        ];
    }

    /**
     * @param $user_id int
     * @return array[]
     */
    private function generateTasks(int $user_id): array
    {
        $idx = ($user_id - 1) * 4 * 4;
        $passed = new DateTime();
        $passed->sub(new DateInterval('P2D'));
        // TODO:
        return [
            // Maths
            [
                'category_id' => $idx + 1,
                'name' => 'Do homework',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 1,
                'name' => 'Do TP1',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 1,
                'name' => 'Do learn CC1',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 1,
                'name' => 'Do search wikipedia about Gauss',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            // Physics
            [
                'category_id' => $idx + 2,
                'name' => 'Do homework',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 2,
                'name' => 'Do learn CC2',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 2,
                'name' => 'Do search google about Nuclear plots',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            // Sport
            [
                'category_id' => $idx + 3,
                'name' => 'Running shoes in the bag.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 3,
                'name' => 'Learn basics of gym',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 3,
                'name' => 'Chose music for dance course.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 3,
                'name' => 'Football training.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            // French
            [
                'category_id' => $idx + 4,
                'name' => 'Chose a book to read.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 4,
                'name' => 'Correct sentences',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 4,
                'name' => 'Read letter of Matthieu.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 4,
                'name' => 'Search about Baudelaire.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Breakfast
            [
                'category_id' => $idx + 5,
                'name' => 'Tartines nutella.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 5,
                'name' => 'Pain perdu',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 5,
                'name' => 'Oeuf a la coque.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 5,
                'name' => 'Fromage blanc fraises.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Lunch
            [
                'category_id' => $idx + 6,
                'name' => 'Tartiflette',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 6,
                'name' => 'Steak haché frites',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Diner
            [
                'category_id' => $idx + 7,
                'name' => 'Lasagnes',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],

            // Sunday lunch
            [
                'category_id' => $idx + 8,
                'name' => 'Cuisses de poulet et légumes rôtis au four',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 8,
                'name' => 'Pavé de saumon, sauce hollandaise',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],

            // Super U
            [
                'category_id' => $idx + 9,
                'name' => 'Nutella',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 9,
                'name' => 'Pain',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 9,
                'name' => 'Oeufs',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 9,
                'name' => 'Fromage blanc',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 9,
                'name' => 'Fromage blanc',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 4,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 9,
                'name' => 'Fromage blanc',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 5,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Ikea
            [
                'category_id' => $idx + 10,
                'name' => 'Lit',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 10,
                'name' => 'Coussins et couette',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 10,
                'name' => 'Verres à pied.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 10,
                'name' => 'Chaise de bureau.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Local grocery
            [
                'category_id' => $idx + 11,
                'name' => 'Graines',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 11,
                'name' => 'Farine',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 12,
                'name' => 'Olives vertes.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 13,
                'name' => 'Fromage frais.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Bakery
            [
                'category_id' => $idx + 14,
                'name' => 'Baguettes fraiches',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 14,
                'name' => '2 croissants',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 14,
                'name' => '4 petits pains au chocolat',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],

            // Voyage to France
            [
                'category_id' => $idx + 15,
                'name' => 'VISA',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 15,
                'name' => 'Chaussettes',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 15,
                'name' => 'Book hotels.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 15,
                'name' => 'Buy plan tickets.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Weekend at lake
            [
                'category_id' => $idx + 16,
                'name' => 'Serviette',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 16,
                'name' => 'Tuba',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 16,
                'name' => 'Maillot de bain',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => new DateTime()
            ],
            [
                'category_id' => $idx + 16,
                'name' => 'Pic-nic',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Voyage to Hell
            // Montreal
        ];
    }

    public function run(): void
    {
        $data = [
            [
                'body' => 'foo',
                'created' => date('Y-m-d H:i:s'),
            ], [
                'body' => 'bar',
                'created' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('posts');
        $posts->insert($data)
            ->saveData();
    }
}
