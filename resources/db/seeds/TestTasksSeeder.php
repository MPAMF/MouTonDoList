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
        $idx = ($user_id-1) * 5*4;
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
            ]
            /**
             *
             *    private ?int $id;
            private Category $category;
            private string $description;
            private DateTime $due_date;
            private bool $checked;
            private int $position;
            private ?User $last_editor;
            */
            // Physics
            // Sport
            // French

            // Breakfast
            // Lunch
            // Diner
            // Sunday lunch

            // Super U
            // Ikea
            // Local grocery
            // Bakery

            // Voyage to France
            // Weekend at lake
            // Voyage to Hell
            // Montreal
        ];
    }

    public function run(): void
    {
        $data = [
            [
                'body'    => 'foo',
                'created' => date('Y-m-d H:i:s'),
            ],[
                'body'    => 'bar',
                'created' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('posts');
        $posts->insert($data)
            ->saveData();
    }
}
