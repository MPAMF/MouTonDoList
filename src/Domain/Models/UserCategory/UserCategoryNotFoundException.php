<?php
declare(strict_types=1);

namespace App\Domain\Models\UserCategory;

use App\Domain\DomainException\DomainRecordNotFoundException;

class UserCategoryNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user category you requested does not exist.';
}
