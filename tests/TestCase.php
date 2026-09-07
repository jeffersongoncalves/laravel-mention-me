<?php

namespace Jeffersongoncalves\LaravelMentionMe\Tests;

use Jeffersongoncalves\LaravelMentionMe\LaravelMentionMeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelMentionMeServiceProvider::class,
        ];
    }
}
