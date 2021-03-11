<?php

declare(strict_types=1);

namespace App\Domain\Photos\Exceptions;

use App\Domain\DomainException\DomainException;

class NotImageException extends DomainException
{
    protected $message = 'Please upload a image';
}
