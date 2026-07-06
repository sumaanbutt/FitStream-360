<?php

namespace App\Exceptions;

class ForbiddenException extends ApiException
{
    public function __construct(
        string $message = 'Forbidden.'
    ) {
        parent::__construct(
            message: $message,
            statusCode: 403
        );
    }
}
