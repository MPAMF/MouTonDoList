<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddCommentTable extends AbstractMigration
{

    public function change()
    {
        $tasks_table = $this->table('tasks');
        $tasks_table
            ->addColumn('assigned_id', 'integer', ['null' => true, 'default' => null, 'signed' => false])
            ->addForeignKey('assigned_id', 'users', 'id', ['delete' => 'SET_NULL'])
            ->update();

        $task_comments_table = $this->table('task_comments');
        $task_comments_table
            ->addColumn('content', 'text')
            //
            ->addColumn('author_id', 'integer', ['null' => true, 'default' => null, 'signed' => false])
            ->addForeignKey('author_id', 'users', 'id', ['delete' => 'SET_NULL'])
            //
            ->addColumn('task_id', 'integer', ['signed' => false])
            ->addForeignKey('task_id', 'tasks', 'id', ['delete' => 'CASCADE'])
            //
            ->addTimestamps()
            ->create();
    }

}
