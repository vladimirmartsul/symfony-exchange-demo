<?php
declare(strict_types=1);

namespace App\Validator;

use App\Repository\PairRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use function is_string;

/**
 * Validator that provided currency exist in pairs table in the provided field
 */
class PairCurrencyExistValidator extends ConstraintValidator
{
    public function __construct(private readonly PairRepository $repository)
    {
    }


    /**
     * @throws UnexpectedValueException
     * @throws UnexpectedTypeException
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PairCurrencyExist) {
            throw new UnexpectedTypeException($constraint, PairCurrencyExist::class);
        }

        /* @var PairCurrencyExist $constraint */

        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $field = $constraint->field;

        if ($field === '') {
            $field = $this->context->getPropertyPath();
        }

        if (!$this->repository->isFieldValueExist($field, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
