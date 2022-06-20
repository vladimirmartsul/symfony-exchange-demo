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
    #[Assert\AmountRequirements]
    public readonly string $amount;


    public function __construct(
        #[Assert\ExchangeCurrencyRequirements(options: ['field' => 'base'])] public readonly string $from,
        #[Assert\ExchangeCurrencyRequirements(options: ['field' => 'currency'])] public readonly string $to,
        string $amount,
    ) {
        $this->amount = (string)Decimal::create($amount, 8);
    }
}
