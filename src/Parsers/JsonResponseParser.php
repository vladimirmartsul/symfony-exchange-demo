<?php
declare(strict_types=1);

namespace App\Parsers;

use App\Contracts\ResponseParser;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * JSON response parser
 */
class JsonResponseParser implements ResponseParser
{
    public function parse(ResponseInterface $response): array
    {
        return $response->toArray();
    }
}
