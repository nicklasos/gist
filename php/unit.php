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
