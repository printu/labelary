<?php

declare(strict_types=1);

namespace Labelary;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;

class Client
{
    const API_ENDPOINT = 'http://api.labelary.com/v1/';

    /** @var BaseClient $httpClient */
    private BaseClient $httpClient;

    /** @var Endpoint\Printers $events */
    public Endpoint\Printers $printers;

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
    private function setDefaultClient(): void
    {
        $this->httpClient = new BaseClient();
    }

    /**
     * Sets GuzzleHttp client.
     * @param BaseClient $client
     */
    public function setClient(BaseClient $client): void
    {
        $this->httpClient = $client;
    }

    /**
     * Sends POST request to Customer.io API.
     * @param string $endpoint
     * @param string $zpl
     * @param array $headers
     * @return mixed
     * @throws GuzzleException
     */
    public function post(string $endpoint, string $zpl, array $headers = [])
    {
        $response = $this->httpClient->request('POST', self::API_ENDPOINT.$endpoint, [
            'headers' => $headers,
            'body' => $zpl,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    private function handleResponse(ResponseInterface $response)
    {
        $stream = Utils::streamFor($response->getBody());

        return json_encode(
            [
                'type' => $response->getHeaders()['Content-Type'][0],
                'label' => base64_encode($stream->getContents()),
            ]
        );
    }
}
