<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
});
