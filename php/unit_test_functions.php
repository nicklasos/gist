<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Mockery\Matcher\AnyArgs;

if (!function_exists('fixture')) {
    function fixture(string $file): string
    {
        return file_get_contents(base_path('tests/fixtures/' . $file));
    }
};

if (!function_exists('fixture_json')) {
    function fixture_json(string $file): array
    {
        return json_decode(fixture($file), true);
    }
}

if (!function_exists('api')) {
    function api(string $url, string $v = 'v1')
    {
        return 'http://api.' . env('APP_DOMAIN') . ':' . env('APP_PORT') . "/$v/$url";
    }
}

if (!function_exists('accept_json')) {
    function accept_json(array $headers = []): array
    {
        return array_merge(['accept' => 'application/json'], $headers);
    }
}

if (!function_exists('mock_ip')) {
    function mock_ip(string $ip)
    {
        $_SERVER['REMOTE_ADDR'] = $ip;
    }
}

if (!function_exists('mock_guzzle')) {
    /**
     * @param \GuzzleHttp\Psr7\Response[] $responses
     * @return \GuzzleHttp\Client
     */
    function mock_guzzle(array $responses): \GuzzleHttp\Client
    {
        $mock = new MockHandler($responses);

        /** @var \GuzzleHttp\Client $client */
        $handler = HandlerStack::create($mock);

        return new \GuzzleHttp\Client(['handler' => $handler]);
    }
}

if (!function_exists('mock_guzzle_response')) {
    function mock_guzzle_response($content): \Psr\Http\Message\ResponseInterface
    {
        $mock = new MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], $content),
        ]);

        /** @var \GuzzleHttp\Client $client */
        $handler = HandlerStack::create($mock);

        $client = new \GuzzleHttp\Client(['handler' => $handler]);

        return $client->get('/');
    }
}

/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2016 Dave Marshall
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

if (!function_exists('mock')) {
    function mock(...$args)
    {
        return call_user_func_array([Mockery::class, "mock"], $args);
    }
}

if (!function_exists('spy')) {
    function spy(...$args)
    {
        return call_user_func_array([Mockery::class, "spy"], $args);
    }
}

if (!function_exists('namedMock')) {
    function namedMock(...$args)
    {
        return call_user_func_array([Mockery::class, "namedMock"], $args);
    }
}

if (!function_exists('any')) {
    function any()
    {
        return new AnyArgs();
    }
}
