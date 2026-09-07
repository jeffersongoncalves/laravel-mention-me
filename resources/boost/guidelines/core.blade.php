## Laravel Mention Me

This package provides a fluent `MentionMe` facade for the [Mention Me](https://mention-me.com) referral marketing API: referrer offers, referrals, share links, rewards and referees.

### Installation

@verbatim
<code-snippet name="Install the package" lang="bash">
composer require jeffersongoncalves/laravel-mention-me
</code-snippet>
@endverbatim

Set `MENTIONME_API_KEY` in `.env`. Optionally override `MENTIONME_BASE_URL`.

### Features

- **Referrer offers**: `MentionMe::createReferrerOffer(array $data)` turns a customer into a referrer.
- **Referrals**: `MentionMe::getReferral(string $id)` and `MentionMe::listReferrals(string $customerId)`.
- **Share links**: `MentionMe::getShareLinks(string $customerId)`.
- **Rewards**: `MentionMe::getRewards(string $customerId)` and `MentionMe::redeemReward(string $customerId, ?string $rewardId, ?string $orderNumber)`.
- **Referees**: `MentionMe::createReferee(array $data)` records a new customer referred by a referrer.

@verbatim
<code-snippet name="Create a referrer offer" lang="php">
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

MentionMe::createReferrerOffer([
    'email' => 'jane@example.com',
    'firstname' => 'Jane',
    'order_number' => 'ORD-1',
    'order_total' => 99.50,
]);
</code-snippet>
@endverbatim

### Configuration

@verbatim
<code-snippet name="Config example" lang="php">
// config/mention-me.php
return [
    'api_key' => env('MENTIONME_API_KEY'),
    'base_url' => env('MENTIONME_BASE_URL', 'https://api.mention-me.com/api/v2'),
];
</code-snippet>
@endverbatim

### Best Practices

- Every method returns the raw decoded JSON response as an array — there are no DTOs to keep the client thin.
- Always wrap calls in a `try`/`catch` for `\JeffersonGoncalves\LaravelMentionMe\Exceptions\MentionMeException` — it is thrown on any non-2xx response and carries the API's message plus the HTTP status code.
