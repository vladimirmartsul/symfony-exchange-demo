<?php
declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;
use Exception;
use Litipk\BigNumbers\Decimal;

/**
 * Rate DTO for interacting with rates providers
 */
class Rate
{
    public readonly DateTimeImmutable $date;
    public readonly string $rate;


    /**
     * @throws Exception
     */
    public function __construct(
        public readonly string $currency,
        public readonly string $base,
        string $rate,
        string $date
    )
    {
        $this->rate = (string)Decimal::create($rate, 8);
        $this->date = new DateTimeImmutable($date);
    }
}
