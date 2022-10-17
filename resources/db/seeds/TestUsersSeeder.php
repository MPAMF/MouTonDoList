<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TestUsersSeeder extends AbstractSeed
{

    public function run(): void
    {
        $data = [
            [
                'email' => 'contact@schawnndev.fr',
                'username' => 'paul',
                'password' => 'paul',
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ], [
                'email' => 'contact@matthieu-freitag.com',
                'username' => 'matthieu',
                'password' => 'matthieu',
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ],[
                'email' => 'quentin.gerling@gmail.com',
                'username' => 'quentin',
                'password' => 'quentin',
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ],[
                'email' => 'victor.hahn@gmail.com',
                'username' => 'victor',
                'password' => 'victor',
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ],
        ];

        $posts = $this->table('users');
        $posts->insert($data)->saveData();
    }

}
