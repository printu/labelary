<?php

namespace Labelary\Endpoint;

use Labelary\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class Base
{
    /** @var Client */
    protected $client;

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
    protected function mockException($message, $method)
    {
        throw new RequestException($message, (new Request($method, '/')));
    }
}
