<?php

namespace Mmo\Guzzle\Middleware;

use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * A Guzzle middleware that add XDEBUG_SESSION to all requests. Useful for debugging.
 */
class XdebugMiddleware
{
    /**
     * @var string
     */
    private $xdebug_session_name;

    /**
     * @param string $xdebugSessionName
     */
    public function __construct($xdebugSessionName)
    {
        $this->xdebug_session_name = $xdebugSessionName;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function __invoke(RequestInterface $request)
    {
        if (!empty($this->xdebug_session_name)) {
            $request = $request->withUri(
                Uri::withQueryValue($request->getUri(), 'XDEBUG_SESSION', $this->xdebug_session_name)
            );
        }

        return $request;
    }

    /**
     * @param string $xdebugSessionName
     * @return XdebugMiddleware
     */
    public static function create($xdebugSessionName)
    {
        return Middleware::mapRequest(new static($xdebugSessionName));
    }
}