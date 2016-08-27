<?php

namespace Middleware;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Mmo\Guzzle\Middleware\XdebugMiddleware;

class XdebugMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    public function testSetSessionName()
    {
        $queryParams = ['a' => 'c'];
        $sessionName = 'phpstorm';
        $this->assertSame(
            http_build_query($queryParams + ['XDEBUG_SESSION_START' => $sessionName]),
            $this->performWith($sessionName, $queryParams)
        );
    }

    public function testNoSessionName()
    {
        $queryParams = ['a' => 'b'];
        $sessionName = '';
        $this->assertSame(
            http_build_query($queryParams),
            $this->performWith($sessionName, $queryParams)
        );
    }

    public function testOverwriteSessionStartParam()
    {
        $queryParams = ['XDEBUG_SESSION_START' => 'b'];
        $sessionName = 'phpstorm';
        $this->assertSame(
            http_build_query(['XDEBUG_SESSION_START' => $sessionName]),
            $this->performWith($sessionName, $queryParams)
        );
    }

    /**
     * @param array $params
     * @return Client
     */
    protected function performWith($xdebugSessionName, array $originalQuery = [])
    {
        $history = [];
        $handler = new MockHandler([new Response()]);
        $stack = HandlerStack::create($handler);
        $stack->push(XdebugMiddleware::create($xdebugSessionName));
        $stack->push(Middleware::history($history));
        $client = new Client(['handler' => $stack]);
        $client->get('/', ['query' => $originalQuery]);
        return $history[0]['request']->getUri()->getQuery();
    }
}
