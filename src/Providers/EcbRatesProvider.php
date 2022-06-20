<?php
declare(strict_types=1);

namespace App\Providers;

use App\Dto\Rate;
use function array_map;

/**
 * Various ECB rates provider in EUR
 */
final class EcbRatesProvider extends RatesProvider
{
    /**
     * @inheritDoc
     */
    protected function transform(array $data): array
    {
        $root = $data['Cube']['Cube'];

        $date = $root['@attributes']['time'];
        $base = $this->base;

        $rates = $root['Cube'];

        return array_map(
            static fn(array $rate): Rate => new Rate(
                $rate['@attributes']['currency'],
                $base,
                (string)$rate['@attributes']['rate'],
                $date
            ),
            $rates
        );
    }
}
