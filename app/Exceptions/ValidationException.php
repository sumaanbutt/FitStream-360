<?php

namespace App\Exceptions;

class ValidationException extends ApiException
{
    public function __construct(
        string $message = 'Validation failed.',
        array $errors = []
    ) {
        parent::__construct(
            message: $message,
            statusCode: 422,
            errors: $errors
        );
    }
}
