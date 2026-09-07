<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

it('creates a referee', function () {
    Http::fake([
        'api.mention-me.com/api/v2/referee' => Http::response(['success' => true], 200),
    ]);

    expect(MentionMe::createReferee([
        'email' => 'john@example.com',
        'firstname' => 'John',
        'referrer_code' => 'REF-1',
        'order_number' => 'ORD-3',
        'order_total' => 42.0,
    ]))->toBe(['success' => true]);

    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->data()['referrer_code'] === 'REF-1');
});
