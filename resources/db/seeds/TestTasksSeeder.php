<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TestTasksSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'TestCategoriesSeeder',
        ];
    }

    private function generateRandomDate() : string
    {
        $date = new DateTime();
        try {
            $date->add(new DateInterval('P' . rand(1,14) . 'D'));
        } catch (Exception) {
            $date= new DateTime();
        }
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param $user_id int
     * @return array[]
     */
    private function generateTasks(int $user_id): array
    {
        $idx = ($user_id - 1) * 4 * 5 + 1;
        $passed = new DateTime();
        $passed->sub(new DateInterval('P2D'));
        $passed = $passed->format('Y-m-d H:i:s');

        return [
            // Maths
            [
                'category_id' => $idx + 1,
                'name' => 'Do homework',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'assigned_id' => $user_id,
                'due_date' => '2022-12-03'
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
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 2,
                'name' => 'Do learn CC2',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
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
                'category_id' => $idx + 6,
                'name' => 'Tartines nutella.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 6,
                'name' => 'Pain perdu',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 6,
                'name' => 'Oeuf a la coque.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 6,
                'name' => 'Fromage blanc fraises.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Lunch
            [
                'category_id' => $idx + 7,
                'name' => 'Tartiflette',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 7,
                'name' => 'Steak haché frites',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Diner
            [
                'category_id' => $idx + 8,
                'name' => 'Lasagnes',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],

            // Sunday lunch
            [
                'category_id' => $idx + 9,
                'name' => 'Cuisses de poulet et légumes rôtis au four',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 9,
                'name' => 'Pavé de saumon, sauce hollandaise',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],

            // Super U
            [
                'category_id' => $idx + 11,
                'name' => 'Nutella',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 11,
                'name' => 'Pain',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 11,
                'name' => 'Oeufs',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 11,
                'name' => 'Fromage blanc',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 11,
                'name' => 'Fromage blanc',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 4,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 11,
                'name' => 'Fromage blanc',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 5,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Ikea
            [
                'category_id' => $idx + 12,
                'name' => 'Lit',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 12,
                'name' => 'Coussins et couette',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 12,
                'name' => 'Verres à pied.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 12,
                'name' => 'Chaise de bureau.',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Local grocery
            [
                'category_id' => $idx + 13,
                'name' => 'Graines',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 13,
                'name' => 'Farine',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 13,
                'name' => 'Olives vertes.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
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
                'due_date' => $this->generateRandomDate()
            ],

            // Voyage to France
            [
                'category_id' => $idx + 16,
                'name' => 'VISA',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 16,
                'name' => 'Chaussettes',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 16,
                'name' => 'Book hotels.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 16,
                'name' => 'Buy plan tickets.',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Weekend at lake
            [
                'category_id' => $idx + 17,
                'name' => 'Serviette',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 17,
                'name' => 'Tuba',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 17,
                'name' => 'Maillot de bain',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 17,
                'name' => 'Pic-nic',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Voyage to Hell
            [
                'category_id' => $idx + 18,
                'name' => 'Hope',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 18,
                'name' => 'Angel',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 1,
                'last_editor_id' => null,
                'due_date' => $passed
            ],
            [
                'category_id' => $idx + 18,
                'name' => 'Snacks',
                'description' => 'This is a description',
                'checked' => true,
                'position' => 2,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
            [
                'category_id' => $idx + 18,
                'name' => 'Blood bag',
                'description' => 'This is a description',
                'checked' => false,
                'position' => 3,
                'last_editor_id' => null,
                'due_date' => $passed
            ],

            // Montreal
            [
                'category_id' => $idx + 19,
                'name' => 'Lot of winter cloths',
                'description' => 'Its really cold...',
                'checked' => false,
                'position' => 0,
                'last_editor_id' => null,
                'due_date' => $this->generateRandomDate()
            ],
        ];
    }

    public function run(): void
    {
        $tasks = $this->table('tasks');

        // Generate data for the 4 users
        for ($i = 1; $i <= 4; $i++) {
            $tasks->insert($this->generateTasks($i));
        }

        $tasks->saveData();
    }
}
