<?php

namespace JeffersonGoncalves\LaravelMentionMe;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\LaravelMentionMe\Exceptions\MentionMeException;

/**
 * Thin client for the Mention Me v2 REST API
 * (https://api.mention-me.com/api/v2). Every method returns the raw decoded
 * JSON response as an array and authenticates the request with a Bearer
 * token from `MENTIONME_API_KEY`.
 */
class MentionMe
{
    /**
     * Create a referrer offer, turning a customer into a referrer.
     *
     * @param  array{email?: string, firstname?: string, lastname?: string, order_number?: string, order_total?: float, order_currency?: string}  $data
     * @return array<string, mixed>
     */
    public function createReferrerOffer(array $data): array
    {
        return $this->post('/referrer-offer', $data);
    }

    /**
     * @return array<string, mixed>
     */
    public function getReferral(string $id): array
    {
        return $this->get("/referral/{$id}");
    }

    /**
     * @return array<string, mixed>
     */
    public function listReferrals(string $customerId): array
    {
        return $this->get("/referrer/{$customerId}/referrals");
    }

    /**
     * @return array<string, mixed>
     */
    public function getShareLinks(string $customerId): array
    {
        return $this->get("/referrer/{$customerId}/share-links");
    }

    /**
     * @return array<string, mixed>
     */
    public function getRewards(string $customerId): array
    {
        return $this->get("/referrer/{$customerId}/rewards");
    }

    /**
     * @return array<string, mixed>
     */
    public function redeemReward(string $customerId, ?string $rewardId = null, ?string $orderNumber = null): array
    {
        return $this->post("/referrer/{$customerId}/rewards/redeem", $this->filter([
            'reward_id' => $rewardId,
            'order_number' => $orderNumber,
        ]));
    }

    /**
     * Create a referee, recording a new customer referred by a referrer.
     *
     * @param  array{email?: string, firstname?: string, referrer_code?: string, order_number?: string, order_total?: float}  $data
     * @return array<string, mixed>
     */
    public function createReferee(array $data): array
    {
        return $this->post('/referee', $data);
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    private function get(string $uri, array $query = []): array
    {
        return $this->handle($this->http()->get($uri, $query));
    }

    /**
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     */
    private function post(string $uri, array $body = []): array
    {
        return $this->handle($this->http()->post($uri, $body));
    }

    private function http(): PendingRequest
    {
        return Http::withToken((string) config('mention-me.api_key'))
            ->baseUrl((string) config('mention-me.base_url', 'https://api.mention-me.com/api/v2'))
            ->acceptJson();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws MentionMeException
     */
    private function handle(Response $response): array
    {
        if ($response->failed()) {
            throw new MentionMeException($this->errorMessage($response), $response->status());
        }

        $data = $response->json();

        return is_array($data) ? $data : [];
    }

    private function errorMessage(Response $response): string
    {
        $data = $response->json();

        if (is_array($data) && is_string($data['message'] ?? null)) {
            return $data['message'];
        }

        return $response->body() !== ''
            ? $response->body()
            : "Mention Me API request failed with status {$response->status()}.";
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    private function filter(array $params): array
    {
        return array_filter($params, fn (mixed $value): bool => $value !== null);
    }
}
