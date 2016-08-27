Guzzle Middleware that adds `XDEBUG_SESSION_START` query parameters to all requests
for a client.

## Usage

```php
$xdebugMiddleware = Mmo\Guzzle\Middleware\XdebugMiddleware::create('phpstorm');
$stack = GuzzleHttp\HandlerStack::create();
$stack->push($xdebugMiddleware);
$client = new GuzzleHttp\Client(['handler' => $stack]);
```

All requests made by the guzzle client above will include `XDEBUG_SESSION_START=phpstorm` in
the GET query.