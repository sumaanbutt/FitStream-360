<?php

namespace App\Exceptions;

class BusinessException extends ApiException
{
    public function __construct(
        string $message = 'Business rule violated.'
    ) {
        parent::__construct(
            message: $message,
            statusCode: 422
        );
    }
}
