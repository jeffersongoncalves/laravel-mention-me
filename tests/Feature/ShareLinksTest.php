<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

it('gets a referrer\'s share links', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer/cust-1/share-links' => Http::response(['share_links' => ['email' => 'https://mention-me.com/m/e/xyz']], 200),
    ]);

    expect(MentionMe::getShareLinks('cust-1'))->toBe(['share_links' => ['email' => 'https://mention-me.com/m/e/xyz']]);
});
