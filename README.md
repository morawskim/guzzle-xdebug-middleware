[![Build Status](https://travis-ci.com/morawskim/guzzle-xdebug-middleware.svg?branch=master)](https://travis-ci.com/morawskim/guzzle-xdebug-middleware)


Guzzle Middleware that adds `XDEBUG_SESSION_START` query parameters to all requests
for a client.

## Install (add to existing project)
``` bash
composer require mmo/guzzle-xdebug-middleware
Using version ^1.0 for mmo/guzzle-xdebug-middleware
./composer.json has been updated
Loading composer repositories with package information
Updating dependencies (including require-dev)
  - Installing mmo/guzzle-xdebug-middleware (v1.0.0)
    Cloning 4078657e79d1cd2ab8728eacee5ad824c11cf79f from cache
....
```

## Usage

```php
$xdebugMiddleware = Mmo\Guzzle\Middleware\XdebugMiddleware::create('phpstorm');
$stack = GuzzleHttp\HandlerStack::create();
$stack->push($xdebugMiddleware);
$client = new GuzzleHttp\Client(['handler' => $stack]);
```

All requests made by the guzzle client above will include `XDEBUG_SESSION_START=phpstorm` in
the GET query.