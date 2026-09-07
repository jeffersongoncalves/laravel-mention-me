<div class="filament-hidden">

![Laravel Mention Me](https://raw.githubusercontent.com/jeffersongoncalves/laravel-mention-me/main/art/jeffersongoncalves-laravel-mention-me.png)

</div>

# Laravel Mention Me

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-mention-me.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-mention-me)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-mention-me/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-mention-me/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-mention-me/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-mention-me/actions?query=workflow%3A%22Fix+PHP+code+styling%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-mention-me.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-mention-me)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-mention-me.svg?style=flat-square)](LICENSE.md)

A Laravel client for the [Mention Me](https://mention-me.com) referral marketing API. A fluent `MentionMe` facade covers referrer offers, referrals, share links, rewards and referees, authenticates every request with a Bearer token, and throws a `MentionMeException` on a non-2xx response instead of returning a silent error array.

## Features

- **Referrer Offers** — `createReferrerOffer()`
- **Referrals** — `getReferral()`, `listReferrals()`
- **Share Links** — `getShareLinks()`
- **Rewards** — `getRewards()`, `redeemReward()`
- **Referees** — `createReferee()`
- **Thin by design** — every method returns the raw decoded JSON response as an array, no DTOs
- **Fails loud** — a non-2xx API response throws `MentionMeException` carrying the API's error message and HTTP status code

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-mention-me
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="mention-me-config"
```

## Configuration

Add to your `.env`:

```env
MENTIONME_API_KEY=your-api-key
```

### Config Options

```php
// config/mention-me.php
return [
    'api_key' => env('MENTIONME_API_KEY'),
    'base_url' => env('MENTIONME_BASE_URL', 'https://api.mention-me.com/api/v2'),
];
```

## Usage

```php
use JeffersonGoncalves\LaravelMentionMe\Exceptions\MentionMeException;
use JeffersonGoncalves\LaravelMentionMe\Facades\MentionMe;
```

### Create a referrer offer

Turn a customer into a referrer.

```php
MentionMe::createReferrerOffer([
    'email' => 'jane@example.com',
    'firstname' => 'Jane',
    'lastname' => 'Doe',
    'order_number' => 'ORD-1',
    'order_total' => 99.50,
    'order_currency' => 'GBP',
]);
```

### Get a referral

```php
MentionMe::getReferral('referral-id');
```

### List a referrer's referrals

```php
MentionMe::listReferrals('customer-id');
```

### Get a referrer's share links

```php
MentionMe::getShareLinks('customer-id');
```

### Get a referrer's rewards

```php
MentionMe::getRewards('customer-id');
```

### Redeem a reward

```php
MentionMe::redeemReward('customer-id', rewardId: 'reward-id', orderNumber: 'ORD-2');
```

### Create a referee

Record a new customer referred by a referrer.

```php
MentionMe::createReferee([
    'email' => 'john@example.com',
    'firstname' => 'John',
    'referrer_code' => 'REF-1',
    'order_number' => 'ORD-3',
    'order_total' => 42.00,
]);
```

### Handling errors

```php
try {
    $result = MentionMe::getReferral('referral-id');
} catch (MentionMeException $e) {
    // $e->getMessage()  — the API's error message, or the raw response body
    // $e->statusCode    — the HTTP status code returned by Mention Me
}
```

## Testing

```bash
composer test
```

## Static Analysis

```bash
composer analyse
```

## Code Formatting

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
