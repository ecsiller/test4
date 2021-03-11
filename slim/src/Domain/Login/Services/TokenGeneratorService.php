<?php

declare(strict_types=1);

namespace App\Domain\Login\Services;

use Exception;

class TokenGeneratorService
{
    /**
     * @return string
     * @throws Exception
     */
    public function getToken(): string
    {
        return bin2hex(random_bytes(10));
    }
}