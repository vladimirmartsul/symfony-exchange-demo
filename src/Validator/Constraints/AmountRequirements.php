<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

/**
 * Amount to exchange should be a number above zero
 */
#[Attribute]
class AmountRequirements extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\Type(type: 'numeric', message: 'The value {{ value }} is not a valid {{ type }}'),
            new Assert\Positive(),
        ];
    }
}
