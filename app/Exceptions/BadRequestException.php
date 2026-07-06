<?php

namespace App\Exceptions;

class BadRequestException extends ApiException
{
    public function __construct(
        string $message = 'Bad request.'
    ) {
        parent::__construct(
            message: $message,
            statusCode: 400
        );
    }
}
