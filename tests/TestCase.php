<?php

namespace JeffersonGoncalves\LaravelMentionMe\Tests;

use JeffersonGoncalves\LaravelMentionMe\LaravelMentionMeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelMentionMeServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('mention-me.api_key', 'fake-api-key');
        $app['config']->set('mention-me.base_url', 'https://api.mention-me.com/api/v2');
    }
}
