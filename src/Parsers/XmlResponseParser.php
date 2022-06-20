<?php
declare(strict_types=1);

namespace App\Parsers;

use App\Contracts\ResponseParser;
use Exception;
use JsonException;
use SimpleXMLElement;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * XML response parser
 */
class XmlResponseParser implements ResponseParser
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws Exception
     */
    public function parse(ResponseInterface $response): array
    {
        $content = $response->getContent();

        return json_decode(
            json_encode(
                new SimpleXMLElement($content),
                JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
