<?php
declare(strict_types=1);

namespace App\Parsers;

use App\Contracts\ResponseParser;
use App\Exceptions\UnparsableResponseException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Nothing-to-do response parser
 */
class NullResponseParser implements ResponseParser
{
    /**
     * @throws UnparsableResponseException
     */
    public function parse(ResponseInterface $response): array
    {
        throw new UnparsableResponseException();
    }
}
