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
