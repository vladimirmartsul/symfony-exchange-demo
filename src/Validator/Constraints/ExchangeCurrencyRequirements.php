<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator as AppAssert;
use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Currency for exchange should exist in pairs table
 */
#[Attribute]
class ExchangeCurrencyRequirements extends Compound
{
    public string $field = '';


    /**
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     * @throws MissingOptionsException
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            new AppAssert\PairCurrencyExist(options: $options),
        ];
    }
}
