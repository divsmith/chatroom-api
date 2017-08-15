<?php
// Routes

$app->get('/redis', function($request, $response, $args) {
    $client = new Predis\Client('tcp://172.18.0.2:6379');
    $client->set('foo', 'bar');
    $client->del('foo');
    $client->del('fishes');
    //$response->getBody()->write($client->get('foo'));

});

$app->get('/mysql', function($request, $response, $args) {
    $db = new PDO('mysql:host=172.18.0.3;dbname=cs3620', 'alpine', 'supersecretpassword');
    $response->getBody()->write('test');
});

//$app->get('/[{name}]', function ($request, $response, $args) {
//    $name = $request->getAttribute('name');
//    $response->getBody()->write("Hello, $name");
//});

$app->get('/chatroom', function($request, $response, $args) {
    // Return all chatrooms
});

$app->post('/chatroom', function($request, $response, $args) {
   // Create a chat room
});

$app->post('/user', function($request, $response, $args) {
   // Create a user
});

$app->put('/user', function($request, $response, $args) {
   // Update user

    // join chat room

    // leave chat room
});

$app->get('/user/{email}/chatroom/message', function() {
    // Return all messages for joined chatroom

    // filter by date range if exists
});

$app->post('/user/{email}/chatroom/message', function() {
   // Post a message to joined chatroom
});

