<?php
declare(strict_types=1);

namespace App\Domain\Models\TaskComment;

use App\Domain\Models\Task\Task;
use App\Domain\Models\TimeStampedModel;
use App\Domain\Models\User\User;
use App\Domain\Models\ValidatorModel;
use DateTime;
use JsonSerializable;
use Respect\Validation\Validator;
use stdClass;

class TaskComment extends TimeStampedModel implements JsonSerializable, ValidatorModel
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

    public static function getValidatorRules(): array
    {
        return [
            'content' => Validator::stringType()->length(min: 1),
            'author_id' => Validator::intType(),
            'assigned_id' => Validator::intType()
        ];
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
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
        $this->author_id = $author?->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Task|null
     */
    public function getTask(): ?Task
    {
        return $this->task;
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
     * @return int|null
     */
    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    /**
     * @param int|null $author_id
     */
    public function setAuthorId(?int $author_id): void
    {
        $this->author_id = $author_id;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->task_id;
    }

    /**
     * @param int $task_id
     */
    public function setTaskId(int $task_id): void
    {
        $this->task_id = $task_id;
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->author = $row->author ?? null;
        $this->task = $row->task ?? null;
        $this->fromValidator($row);
    }

    public function fromValidator(object|array $data): void
    {
        $this->content = $data->content;
        $this->author_id = isset($data->author_id) ? intval($data->author_id) : null;
        $this->task_id = isset($data->task_id) ? intval($data->task_id) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $result = $this->jsonSerialize();
        unset($result['author']);
        unset($result['task']);
        unset($result['date']);
        return $result;
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
            'date' => $this->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }
}
