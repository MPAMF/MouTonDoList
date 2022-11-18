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
                'password' => password_hash('paul', PASSWORD_DEFAULT),
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ], [
                'email' => 'contact@matthieu-freitag.com',
                'username' => 'matthieu',
                'password' => password_hash('matthieu', PASSWORD_DEFAULT),
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ],[
                'email' => 'quentin.gerling@gmail.com',
                'username' => 'quentin',
                'password' => password_hash('quentin', PASSWORD_DEFAULT),
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ],[
                'email' => 'victor.hahn@gmail.com',
                'username' => 'victor',
                'password' => password_hash('victor', PASSWORD_DEFAULT),
                'image_path' => '',
                'theme' => '',
                'language' => '',
            ],
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }

}
