<?php
declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;
use Litipk\BigNumbers\Decimal;

/**
 * Rate DTO for interacting with rates providers
 */
class Rate
{
    private readonly DateTimeImmutable $date;
    private readonly string $rate;


    public function __construct(string $date, private readonly string $base, string $rate, private readonly string $currency)
    {
        $this->date = new DateTimeImmutable($date);
        $this->rate = (string)Decimal::create($rate, 8);
    }


    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }


    public function getBase(): string
    {
        return $this->base;
    }


    public function getRate(): string
    {
        return $this->rate;
    }


    public function getCurrency(): string
    {
        return $this->currency;
    }
}
