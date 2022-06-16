<?php
declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Constraint that provided currency exist in pairs table in the provided field
 */
#[Attribute]
class PairCurrencyExist extends Constraint
{
    public string $message = 'No currency "{{ value }}" for exchange';

    public string $field = '';
}
