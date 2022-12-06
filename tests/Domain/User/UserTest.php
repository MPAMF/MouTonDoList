<?php
declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\Models\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider()
    {
        return [
            [1, 'paul', 'contact@schawnndev.fr', 'bla', 'fr', 'pomme', 'dark'],
            [2, 'matthieu', 'contact@matthieu-freitag.com', 'bla', 'en', 'poire', 'dark'],
            [3, 'quentin', 'contact@quentin-gerling.fr', 'bla', 'fr', 'moi', 'dark'],
            [4, 'victor', 'contact@victor-hahn.fr', 'bla', 'fr', 'letsgo', 'dark'],
        ];
    }

    /**
     * @dataProvider userProvider
     */
    public function testGetters(int $id, string $username, string $email, string $imagePath, string $language, string $password, string $theme): void
    {
        $user = new User();
        $user->setId($id);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setImagePath($imagePath);
        $user->setLanguage($language);
        $user->setPassword($password);
        $user->setTheme($theme);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($imagePath, $user->getImagePath());
        $this->assertEquals($language, $user->getLanguage());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($theme, $user->getTheme());
    }

    /**
     * @dataProvider userProvider
     */
    public function testJsonSerialize(int $id, string $username, string $email, string $imagePath, string $language, string $password, string $theme)
    {
        $user = new User();
        $user->setId($id);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setImagePath($imagePath);
        $user->setLanguage($language);
        $user->setPassword($password);
        $user->setTheme($theme);

        $expectedPayload = json_encode([
            'id' => $id,
            'email' => $email,
            'username' => $username,
            'image_path' => $imagePath,
            'theme' => $theme,
            'language' => $language,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
