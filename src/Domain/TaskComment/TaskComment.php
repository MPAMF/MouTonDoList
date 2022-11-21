<?php
declare(strict_types=1);

namespace App\Domain\TaskComment;

use App\Domain\TimeStampedModel;
use DateTime;
use JsonSerializable;
use stdClass;

class TaskComment extends TimeStampedModel implements JsonSerializable
{
    private ?int $id;

    private string $content;


    public function __construct()
    {
        parent::__construct(new DateTime(), new DateTime());
        $this->id = null;
        $this->content = "";
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fromRow(stdClass $row): void
    {
        parent::fromRow($row);
        $this->id = $row->id;
        $this->email = $row->email;
        $this->username = $row->username;
        $this->password = $row->password;
        $this->image_path = $row->image_path;
        $this->theme = $row->theme;
        $this->language = $row->language;
    }

    /**
     * {@inheritdoc}
     */
    public function toRow(): array
    {
        $row = $this->jsonSerialize();
        $row['password'] = $this->password;
        return $row;
    }
}
