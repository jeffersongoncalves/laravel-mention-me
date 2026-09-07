<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

it('gets a referral', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referral/ref-1' => Http::response(['id' => 'ref-1', 'status' => 'pending'], 200),
    ]);

    expect(MentionMe::getReferral('ref-1'))->toBe(['id' => 'ref-1', 'status' => 'pending']);
});

it('lists a referrer\'s referrals', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer/cust-1/referrals' => Http::response(['referrals' => []], 200),
    ]);

    expect(MentionMe::listReferrals('cust-1'))->toBe(['referrals' => []]);
});
