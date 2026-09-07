<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

it('gets a referrer\'s rewards', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer/cust-1/rewards' => Http::response(['rewards' => []], 200),
    ]);

    expect(MentionMe::getRewards('cust-1'))->toBe(['rewards' => []]);
});

it('redeems a reward', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer/cust-1/rewards/redeem' => Http::response(['redeemed' => true], 200),
    ]);

    expect(MentionMe::redeemReward('cust-1', 'reward-1', 'ORD-2'))->toBe(['redeemed' => true]);

    Http::assertSent(fn (Request $request) => $request->data()['reward_id'] === 'reward-1'
        && $request->data()['order_number'] === 'ORD-2');
});

it('redeems a reward without optional parameters', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer/cust-1/rewards/redeem' => Http::response(['redeemed' => true], 200),
    ]);

    expect(MentionMe::redeemReward('cust-1'))->toBe(['redeemed' => true]);

    Http::assertSent(fn (Request $request) => $request->data() === []);
});
