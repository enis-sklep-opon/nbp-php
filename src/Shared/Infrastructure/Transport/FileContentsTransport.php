<?php

declare(strict_types=1);

namespace MaciejSz\Nbp\Shared\Infrastructure\Transport;

use MaciejSz\Nbp\Shared\Infrastructure\Transport\Exception\TransportException;

class FileContentsTransport implements Transport
{
    /** @var string */
    private $baseUri;

    public function __construct(string $baseUri)
    {
        $this->baseUri = $baseUri;
    }

    public function request(string $path): array
    {
        $path = trim($path, '/');
        $uri = "{$this->baseUri}/{$path}?format=json";
        $contents = file_get_contents($uri);
        $data = json_decode($contents, true);
        if (null === $data) {
            throw new TransportException("Cannot decode JSON data from {$uri}");
        }

        return $data;
    }
}
