<?php

namespace JeffersonGoncalves\LaravelMentionMe\Exceptions;

use RuntimeException;

/**
 * Raised when the Mention Me API answers a request with a non-2xx HTTP
 * status. Carries the response's error message (falling back to the raw
 * body) and the HTTP status code.
 */
class MentionMeException extends RuntimeException
{
    public function __construct(string $message, public readonly int $statusCode)
    {
        parent::__construct($message, $statusCode);
    }
}
