<?php

namespace Jeffersongoncalves\LaravelMentionMe;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMentionMeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-mention-me')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
