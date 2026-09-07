<?php

use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe as MentionMeFacade;
use JeffersonGoncalves\LaravelMentionMe\MentionMe;

it('registers the MentionMe singleton', function () {
    expect(app(MentionMe::class))->toBeInstanceOf(MentionMe::class);
});

it('resolves the facade to the MentionMe class', function () {
    expect(MentionMeFacade::getFacadeRoot())->toBeInstanceOf(MentionMe::class);
});

it('merges the mention-me config file', function () {
    expect(config('mention-me.base_url'))->toBe('https://api.mention-me.com/api/v2');
});
