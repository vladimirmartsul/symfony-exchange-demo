<?php
declare(strict_types=1);

namespace App\Providers;

use JsonException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;
use function date;
use function json_encode;

/**
 * Own fake rates
 */
final class FakeRatesProvider extends RatesProvider
{
    /**
     * @inheritDoc
     * @throws JsonException
     */
    protected function fetch(string $url): ResponseInterface
    {
        $body = [
            ['date' => date('Y-m-d'), 'base' => 'EUR', 'rate' => '2', 'currency' => 'USD'],
            ['date' => date('Y-m-d'), 'base' => 'USD', 'rate' => '0.002', 'currency' => 'BTC'],
        ];

        $info = ['response_headers' => ['content-type' => 'application/json']];

        return (new MockHttpClient(new MockResponse(json_encode($body, JSON_THROW_ON_ERROR), $info)))->request('GET', '/');
    }
}
