<?php
// Routes

use Domain\User;

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

// View all chatrooms
$app->get('/chatroom', function($request, $response, $args) {
    $jack = $this->get('chatroomjack');

    $rooms = $jack->getAll();

    $json = [];

    foreach ($rooms as $room)
    {
        $json[] = ['uuid' => $room->uuid(), 'name' => $room->name(), 'created' => $room->created(), 'updated' => $room->updated(), 'archived' => $room->archived()];
    }

    return $response->withJson($json);
});

// Create a chatroom
$app->post('/chatroom', function($request, $response, $args) {
    $jack = $this->get('chatroomjack');

    $name = $request->getParam('name');
    $uuid = \Ramsey\Uuid\Uuid::uuid4();
    $created = new DateTime('now');
    $updated = new DateTime('now');

    if ($jack->persist(new \Domain\ChatRoom($name, $created, $updated, $uuid)))
    {
        return $response->withJson(['chatroom' => '/chatroom/' . $uuid], 201);
    }

    return $response->withStatus(500);
});

// View a single chatroom
$app->get('/chatroom/{uuid}', function($request, $response, $args) {
    $jack = $this->get('chatroomjack');

    $room = $jack->getByID($request->getAttribute('uuid'));

    if ($room != null)
    {
        return $response->withJson(['uuid' => $room->uuid(), 'name' => $room->name(), 'created' => $room->created(), 'updated' => $room->updated(), 'archived' => $room->archived()]);
    }

    return $response->withStatus(404);
});

// Add a user
$app->post('/user', function($request, $response, $args) {
    $email = $request->getParam('email');
    $alias = $request->getParam('alias');

    $jack = $this->get('userjack');

    try {
        $jack->persist(new User($email, $alias));
        return $response->withJson(['user' => '/user/' . $email], 201);
    } catch(\Domain\Exceptions\InvalidEmailException $e) {
        return $response->withJson(['error' => 'Invalid email address'], 406);
    }
});

// Update a given user
$app->patch('/user/{email}', function($request, $response, $args) {
    $email = $request->getAttribute('email');
    $alias = $request->getParsedBodyParam('alias');
    $chatroomID = $request->getParsedBodyParam('chatroomID');

    $jack = $this->get('userjack');

    $user = $jack->getByEmail($email);

    if ($user == null)
    {
        return $response->withStatus(404);
    }

    $user->changeAlias($alias);
    $user->changeChatRoomID($chatroomID);

    $jack->persist($user);

    return $response->withStatus(206);
});

// View a user
$app->get('/user/{email}', function($request, $response, $args) {
    $email = $request->getAttribute('email');

    $jack = $this->get('userjack');

    $user = $jack->getByEmail($email);

    if ($user != null)
    {
        return $response->withJson(['email' => $user->email(), 'alias' => $user->alias(), 'chatroomID' => $user->chatRoomID()]);
    }

    return $response->withStatus(404);
});

$app->get('/user/{email}/chatroom/message', function() {
    // Return all messages for joined chatroom

    // filter by date range if exists
});

$app->post('/user/{email}/chatroom/message', function() {
   // Post a message to joined chatroom
});

