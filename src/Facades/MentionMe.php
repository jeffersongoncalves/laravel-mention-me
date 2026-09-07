<?php

namespace JeffersonGoncalves\LaravelMentionMe\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\LaravelMentionMe\MentionMe as MentionMeClient;

/**
 * @see MentionMeClient
 */
class MentionMe extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MentionMeClient::class;
    }
}
