<?php
declare(strict_types=1);

namespace App\Dto;

use App\Validator\Constraints as Assert;
use Litipk\BigNumbers\Decimal;

/**
 * Exchange DTO for interacting with rates converter
 */
class Exchange
{
    private readonly string $amount;


    public function __construct(string $amount, private readonly string $from, private readonly string $to)
    {
        $this->amount = (string)Decimal::create($amount, 8);
    }


    #[Assert\AmountRequirements]
    public function getAmount(): string
    {
        return $this->amount;
    }


    #[Assert\ExchangeCurrencyRequirements(options: ['field' => 'base'])]
    public function getFrom(): string
    {
        return $this->from;
    }


    #[Assert\ExchangeCurrencyRequirements(options: ['field' => 'currency'])]
    public function getTo(): string
    {
        return $this->to;
    }
}
