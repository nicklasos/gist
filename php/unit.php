<?php

// Mock Guzzle

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

$mock = new MockHandler([
    new Response(200, [], Fixture::load('steam_inventory_csgo.json')),
    new Response(200, [], '{"total_inventory_count":0,"success":1,"rwgrsn":-2}'),
    new Response(200, [], '[]'),
    new Response(200, [], '[]'),
]);

$client = new Client([
    'handler' => HandlerStack::create($mock),
]);


if (!function_exists('private_field')) {
    /**
     * Only for unit tests
     *
     * @param $object
     * @param string $field
     * @return mixed
     */
    function private_field($object, string $field)
    {
        $reflection = new \ReflectionProperty(get_class($object), $field);
        $reflection->setAccessible(true);

        return $reflection->getValue($object);
    }
}

if (!function_exists('private_method')) {
    /**
     * $class = new Class();
     * $result = private_method($class, function() {
     *     return $this->privateMethod();
     * });
     */
    function private_method($object, \Closure $call)
    {
        return $call->call($object);
    }   
}
