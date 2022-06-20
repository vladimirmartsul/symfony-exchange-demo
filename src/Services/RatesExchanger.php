<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\Exchange;
use App\Entity\Pair;
use App\Exceptions\NonExistingtRateException;
use Doctrine\Persistence\ManagerRegistry;
use Litipk\BigNumbers\Decimal;

/**
 * Rates converter
 */
class RatesExchanger
{
    public function __construct(private readonly ManagerRegistry $doctrine)
    {
    }


    /**
     * Convert $amount $from $to
     */
    public function __invoke(Exchange $exchange): string
    {
        $pair = $this->doctrine->getRepository(Pair::class)->findOneBy([
                'base' => $exchange->from,
                'currency' => $exchange->to,
            ]
        );

        if (!$pair instanceof Pair) {
            throw new NonExistingtRateException();
        }

        return (string)Decimal::fromString($pair->getRate())->mul(Decimal::fromString($exchange->amount), 8);
    }
}
