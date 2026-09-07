<?php

namespace Jeffersongoncalves\LaravelMentionMe\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\LaravelMentionMe\LaravelMentionMe
 */
class LaravelMentionMe extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-mention-me';
    }
}
