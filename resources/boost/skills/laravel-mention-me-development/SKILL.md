---
name: laravel-mention-me-development
description: Build and work with the Laravel Mention Me package, covering referrer offers, referrals, share links, rewards and referees.
---

# Laravel Mention Me Development

## When to use this skill

Use this skill when:
- Integrating the Mention Me referral marketing API into a Laravel app
- Adding new Mention Me endpoints to this package
- Handling Mention Me API errors

## Core Concepts

### The `MentionMe` client

`JeffersonGoncalves\LaravelMentionMe\MentionMe` is a thin wrapper around Laravel's `Http` facade. It is registered as a singleton and resolved via the `MentionMe` facade (`JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe`). Every public method maps 1:1 to a Mention Me v2 endpoint and returns the decoded JSON body as an array — no DTOs.

```php
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;

MentionMe::getReferral('referral-id');
```

### Authentication

Every request is authenticated with `Http::withToken(config('mention-me.api_key'))`, sent as `Authorization: Bearer {token}`. The base URL comes from `config('mention-me.base_url')`, defaulting to `https://api.mention-me.com/api/v2`.

### Error handling

A non-2xx response throws `JeffersonGoncalves\LaravelMentionMe\Exceptions\MentionMeException`, carrying:
- `getMessage()` — the API's `message` field, or the raw response body as a fallback
- `statusCode` (public readonly int) — the HTTP status code

```php
try {
    MentionMe::redeemReward('customer-id', 'reward-id');
} catch (\JeffersonGoncalves\LaravelMentionMe\Exceptions\MentionMeException $e) {
    report($e);
}
```

## Common Patterns

### Adding a new endpoint

1. Add a public method to `src/MentionMe.php` calling the private `get()`/`post()` helpers.
2. Add a Feature test under `tests/Feature/` using `Http::fake()`.
3. Document the method in `README.md` under "Usage" and in this skill's API Reference.

```php
public function newEndpoint(string $id): array
{
    return $this->get("/new-endpoint/{$id}");
}
```

## Troubleshooting

### Error: `MentionMeException` with a generic status message

**Cause**: The Mention Me API returned a non-2xx response without a `message` field in the JSON body.

**Solution**: Inspect `$e->statusCode` and the raw response (log it before throwing, or catch and re-log) to diagnose — the fallback message is just the raw response body.

## API Reference

### `MentionMe::createReferrerOffer(array $data)`

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data['email']` | `string` | Referrer's email |
| `$data['firstname']` | `string` | Referrer's first name |
| `$data['lastname']` | `string` | Referrer's last name |
| `$data['order_number']` | `string` | Order reference |
| `$data['order_total']` | `float` | Order total |
| `$data['order_currency']` | `string` | Order currency (ISO 4217) |

**Returns**: `array<string, mixed>`

### `MentionMe::getReferral(string $id)`

**Returns**: `array<string, mixed>`

### `MentionMe::listReferrals(string $customerId)`

**Returns**: `array<string, mixed>`

### `MentionMe::getShareLinks(string $customerId)`

**Returns**: `array<string, mixed>`

### `MentionMe::getRewards(string $customerId)`

**Returns**: `array<string, mixed>`

### `MentionMe::redeemReward(string $customerId, ?string $rewardId = null, ?string $orderNumber = null)`

**Returns**: `array<string, mixed>`

### `MentionMe::createReferee(array $data)`

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data['email']` | `string` | Referee's email |
| `$data['firstname']` | `string` | Referee's first name |
| `$data['referrer_code']` | `string` | The referrer's code |
| `$data['order_number']` | `string` | Order reference |
| `$data['order_total']` | `float` | Order total |

**Returns**: `array<string, mixed>`
