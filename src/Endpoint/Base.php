<?php

namespace Labelary\Endpoint;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Labelary\Client;

class Base
{
    /** @var Client */
    protected Client $client;

    /**
     * Base constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param $message
     * @param $method
     */
    protected function mockException($message, $method): void
    {
        throw new RequestException($message, (new Request($method, '/')));
    }
}
