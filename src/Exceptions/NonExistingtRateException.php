<?php
declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use UnexpectedValueException;

/**
 * Non-existingt rate exception
 */
class NonExistingtRateException extends UnexpectedValueException
{
    /**
     * @inheritDoc
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?: 'No exchange rate for this currencies';

        parent::__construct($message, $code, $previous);
    }
}
