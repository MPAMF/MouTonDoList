<?php
declare(strict_types=1);

namespace App\Domain\TaskComment;

use App\Domain\DomainException\DomainRecordNotFoundException;

class TaskCommentNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The task comment you requested does not exist.';
}
