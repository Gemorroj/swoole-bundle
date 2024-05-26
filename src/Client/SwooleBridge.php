<?php

namespace Cesurapp\SwooleBundle\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class SwooleBridge implements HttpClientInterface
{
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $client = SwooleClient::create($url)->setMethod($method)->setOptions($options);

        if (isset($options['headers'])) {
            $client->setHeaders($options['headers']);
        }
        if (isset($options['json'])) {
            $client->setJsonData($options['json']);
        }
        if (isset($options['body'])) {
            $client->setData($options['body']);
        }
        if (isset($options['query'])) {
            $client->setQuery($options['query']);
        }

        return new SwooleResponse($client->execute(), $url);
    }

    public function stream(ResponseInterface|iterable $responses, ?float $timeout = null): ResponseStreamInterface
    {
        throw new \Exception('Swoole bridge stream not configured!');
    }

    public function withOptions(array $options): static
    {
        return $this;
    }
}
