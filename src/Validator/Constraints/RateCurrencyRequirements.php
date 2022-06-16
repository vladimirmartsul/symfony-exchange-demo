<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

/**
 * Currency in exchange rates should be one of ISO 4217 or BTC
 */
#[Attribute]
class RateCurrencyRequirements extends Compound
{
    private const ADDITIONAL_CURRENCIES = ['BTC'];


    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\AtLeastOneOf([
                new Assert\Currency(message: 'The value {{ value }} is not a valid currency'),
                new Assert\Choice(self::ADDITIONAL_CURRENCIES),
            ]),
        ];
    }
}
