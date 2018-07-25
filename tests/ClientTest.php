<?php

namespace Customerio\Tests;

use Labelary\Client as LabelaryClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
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
            'zpl' => '^xa^cfa,50^fo100,100^fdHello World^fs^xz',
        ]);
        foreach ($container as $transaction) {
            /** @var \GuzzleHttp\Psr7\Request $request */
            $request = $transaction['request'];
            $accept = $request->getHeaders()['Accept'][0];
            $this->assertTrue($accept == "image/png");
        }
    }
}
