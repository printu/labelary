<?php

namespace Labelary\Tests;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Labelary\Client as LabelaryClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testBasicClient()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'image/png'], "1234"),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $stack = HandlerStack::create($mock);
        $stack->push($history);
        $http_client = new Client(['handler' => $stack]);
        $client = new LabelaryClient();
        $client->setClient($http_client);

        $client->printers->labels([
            'rotate' => 180,
            'zpl' => '^xa^cfa,50^fo100,100^fdHello World^fs^xz',
        ]);
        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            $accept = $request->getHeaders()['Accept'][0];
            $this->assertTrue($accept == "image/png");
        }
    }

    public function testBasicClientMissingZpl()
    {
        $this->expectException(GuzzleException::class);
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'image/png'], "1234"),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $stack = HandlerStack::create($mock);
        $stack->push($history);
        $http_client = new Client(['handler' => $stack]);
        $client = new LabelaryClient();
        $client->setClient($http_client);

        $client->printers->labels([
            'rotate' => 180,
        ]);
        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            $accept = $request->getHeaders()['Accept'][0];
            $this->assertTrue($accept == "image/png");
        }
    }
}
