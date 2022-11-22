<?php
declare(strict_types=1);

namespace App\Domain\TaskComment;

use App\Domain\Task\Task;
use App\Domain\TimeStampedModel;
use App\Domain\User\User;
use DateTime;
use JsonSerializable;
use stdClass;

class TaskComment extends TimeStampedModel implements JsonSerializable
{
    private ?int $id;
    private string $content;
    private int $task_id;
    private ?Task $task;
    private ?int $author_id;
    private ?User $author;

    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->content = "";
        $this->author = null;
        $this->author_id = null;
        $this->task = null;
        $this->task_id = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param User|null $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
        $this->author_id = $author?->getId();
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param Task $task
     */
    public function setTask(Task $task): void
    {
        $this->task = $task;
        $this->task_id = $task->getId();
    }

    /**
     * @return Task|null
     */
    public function getTask(): ?Task
    {
        return $this->task;
    }

    /**
     * @param int $task_id
     */
    public function setTaskId(int $task_id): void
    {
        $this->task_id = $task_id;
    }

    /**
     * @param int|null $author_id
     */
    public function setAuthorId(?int $author_id): void
    {
        $this->author_id = $author_id;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'author_id' => $this->author_id,
            'author' => isset($this->author) ? $this->author->jsonSerialize() : null,
            'task_id' => $this->task_id,
            'task' => isset($this->task) ? $this->task->jsonSerialize() : null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->content = $row->content;
        $this->author = $row->author ?? null;
        $this->author_id = $row->author_id ?? null;
        $this->task_id = $row->task_id;
        $this->task = $row->task ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $result = $this->jsonSerialize();
        unset($result['author']);
        unset($result['task']);
        return $result;
    }
}
