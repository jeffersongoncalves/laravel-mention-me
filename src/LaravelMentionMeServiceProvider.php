<?php

namespace JeffersonGoncalves\LaravelMentionMe;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMentionMeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mention-me')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(MentionMe::class);
    }
}
