<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class BaseTables extends AbstractMigration
{

    public function change()
    {
        // Create users table
        $users_table = $this->table('users');
        $users_table
            ->addColumn('email', 'string', ['limit' => 254, 'unique' => true])
            ->addColumn('username', 'string', ['limit' => 64])
            ->addColumn('password', 'string', ['limit' => 128])
            ->addColumn('image_path', 'text')
            ->addColumn('theme', 'string', ['limit' => 16])
            ->addColumn('language', 'string', ['limit' => 16])
            ->addTimestamps()
            ->create();

        // Create categories table
        $categories_table = $this->table('categories');
        $categories_table
            ->addColumn('name', 'string', ['limit' => 64])
            ->addColumn('color', 'string', ['limit' => 16])
            ->addColumn('position', 'integer', ['default' => 0])
            ->addColumn('archived', 'boolean')
            //
            ->addColumn('owner_id', 'integer')
            ->addForeignKey('owner_id', 'users', 'id', ['delete' => 'NO_ACTION'])
            //
            ->addColumn('parent_category_id', 'integer', ['null' => true, 'default' => null])
            ->addForeignKey('parent_category_id', 'categories', 'id', ['delete' => 'SET_NULL'])
            //
            ->addTimestamps()
            ->create();

        // Create user_categories table
        $user_categories_table = $this->table('user_categories');
        $user_categories_table
            ->addColumn('accepted', 'boolean')
            ->addColumn('can_edit', 'boolean')
            //
            ->addColumn('user_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
            //
            ->addColumn('category_id', 'integer')
            ->addForeignKey('category_id', 'categories', 'id', ['delete' => 'CASCADE'])
            //
            ->addTimestamps()
            ->create();

        // Create tasks table
        $tasks_table = $this->table('tasks');
        $tasks_table
            ->addColumn('name', 'string', ['limit' => 64])
            ->addColumn('description', 'text')
            ->addColumn('due_date', 'datetime')
            ->addColumn('checked', 'boolean')
            ->addColumn('position', 'integer', ['default' => 0])
            //
            ->addColumn('category_id', 'integer')
            ->addForeignKey('category_id', 'categories', 'id', ['delete' => 'CASCADE'])
            //
            ->addColumn('last_editor_id', 'integer', ['null' => true, 'default' => null])
            ->addForeignKey('last_editor_id', 'users', 'id', ['delete' => 'SET_NULL'])
            //
            ->addTimestamps()
            ->create();
    }

}
