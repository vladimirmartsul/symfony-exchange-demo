<?php
declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use UnexpectedValueException;

/**
 * Unparsable response exception
 */
class UnparsableResponseException extends UnexpectedValueException
{
    /**
     * @inheritDoc
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?: "Can't parse response";

        parent::__construct($message, $code, $previous);
    }
}
