<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Dto\Rate;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Interface for all rates providers
 */
interface RatesProviderInterface
{
    public function __construct(HttpClientInterface $client, string $url, string $base);


    /**
     * Update all rates and write to database
     * @return Rate[]
     */
    public function __invoke(): array;
}
