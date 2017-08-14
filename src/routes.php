<?php
// Routes

$app->get('/redis', function($request, $response, $args) {
    $client = new Predis\Client('tcp://172.18.0.2:6379');
    $client->set('foo', 'bar');
    $client->del('foo');
    $client->del('fishes');
    $response->getBody()->write($client->get('foo'));
});

$app->get('/[{name}]', function ($request, $response, $args) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
});
