<?php

namespace Labelary;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;

class Client
{
    const API_ENDPOINT = 'http://api.labelary.com/v1/';

    /** @var BaseClient $httpClient */
    private $httpClient;

    /** @var Endpoint\Printers $events */
    public $printers;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->setDefaultClient();
        $this->printers = new Endpoint\Printers($this);
    }

    /**
     * Set default client
     */
    private function setDefaultClient()
    {
        $this->httpClient = new BaseClient();
    }

    /**
     * Sets GuzzleHttp client.
     * @param BaseClient $client
     */
    public function setClient($client)
    {
        $this->httpClient = $client;
    }

    /**
     * Sends POST request to Customer.io API.
     * @param string $endpoint
     * @param string $zpl
     * @param string $accept
     * @return mixed
     */
    public function post($endpoint, $zpl, $accept = 'application/png')
    {
        $response = $this->httpClient->request('POST', self::API_ENDPOINT.$endpoint, [
            'headers' => [
                'Accept' => $accept,
            ],
            'body' => $zpl,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param Response $response
     * @return mixed
     */
    private function handleResponse(Response $response)
    {
        $stream = stream_for($response->getBody());
        $data = json_encode(
            [
                'type' => $response->getHeaders()['Content-Type'][0],
                'label' => base64_encode($stream->getContents()),
            ]
        );

        return $data;
    }
}
