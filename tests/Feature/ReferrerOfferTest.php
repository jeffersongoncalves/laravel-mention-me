<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\LaravelMentionMe\Exceptions\MentionMeException;
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

it('creates a referrer offer', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer-offer' => Http::response(['success' => true, 'referrer_id' => 'abc123'], 200),
    ]);

    expect(MentionMe::createReferrerOffer([
        'email' => 'jane@example.com',
        'firstname' => 'Jane',
        'lastname' => 'Doe',
        'order_number' => 'ORD-1',
        'order_total' => 99.5,
        'order_currency' => 'GBP',
    ]))->toBe(['success' => true, 'referrer_id' => 'abc123']);

    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->url() === 'https://api.mention-me.com/api/v2/referrer-offer'
        && $request->hasHeader('Authorization', 'Bearer fake-api-key')
        && $request->data()['email'] === 'jane@example.com'
        && $request->data()['order_total'] === 99.5);
});

it('throws a MentionMeException on a non-2xx response', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referrer-offer' => Http::response(['message' => 'Invalid API key.'], 401),
    ]);

    expect(fn () => MentionMe::createReferrerOffer(['email' => 'jane@example.com']))
        ->toThrow(MentionMeException::class, 'Invalid API key.');
});
