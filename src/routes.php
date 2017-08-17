<?php
// Routes

use Domain\User;

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
        $response = $response->withHeader('Location', '/chatroom/' . $uuid);
        $response = $response->withHeader('UUID', $uuid);
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
        $response = $response->withHeader('Location', '/user/' . $email);
        return $response->withJson(['user' => '/user/' . $email], 201);
    } catch(\Domain\Exceptions\InvalidEmailException $e) {
        return $response->withJson(['error' => 'Invalid email address'], 406);
    }
});

// Update a given user
$app->put('/user/{email}', function($request, $response, $args) {
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

// Show all messages for the joined chatroom, optionally by a specified date.
$app->get('/user/{email}/chatroom/messages', function($request, $response, $args) {
    $userJack = $this->get('userjack');
    $email = $request->getAttribute('email');
    $user = $userJack->getByEmail($email);
    $start = $_GET['start'];
    $end = $_GET['end'];

    if ($user == null)
    {
        // User wasn't found
        return $response->withStatus(404);
    }

    $chatroomID = $user->chatRoomID();
    if ($chatroomID == null)
    {
        // User hasn't joined a chatroom
        return $response->withJson(['error' => 'Not joined to a chatroom'], 406);
    }

    $messageJack = $this->get('messagejack');
    // filter by date range if exists

    if ($start == null || $end == null)
    {
        $messages = $messageJack->getAll($chatroomID);
    }
    else
    {
        try {
            $start = new DateTime($start);
            $end = new DateTime($end);
        } catch (Exception $e)
        {
            return $response->withJson(['error' => 'Invalid start or end date'], 406);
        }

        $messages = $messageJack->getByDateRange($chatroomID, $start, $end);
    }

    $json = [];

    foreach ($messages as $message)
    {
        $json[] = ['email' => $message->email(), 'message' => $message->message(), 'created' => $message->created(), 'updated' => $message->updated(), 'uuid' => $message->uuid()];
    }

    return $response->withJson($json);
});

// Post a message to the joined chatroom.
$app->post('/user/{email}/chatroom/messages', function($request, $response, $args) {
    $userJack = $this->get('userjack');
    $email = $request->getAttribute('email');
    $message = $request->getParam('message');
    $user = $userJack->getByEmail($email);
    $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();


    if ($user == null)
    {
        // User wasn't found
        return $response->withStatus(404);
    }

    $chatroomID = $user->chatRoomID();
    if ($chatroomID == null)
    {
        // User hasn't joined a chatroom
        return $response->withJson(['error' => 'Not joined to a chatroom'], 406);
    }

    $messageJack = $this->get('messagejack');

    $message = new \Domain\Message($user->email(), $chatroomID, $message, new DateTime('now'), new DateTime('now'), $uuid);

    try {
        $messageJack->persist($message);
    } catch (Exception $e)
    {
        return $response->withStatus(500);
    }

    $response = $response->withHeader('Location', '/message/' . $uuid);
    $response = $response->withHeader('UUID', $uuid);
    return $response->withJson(['message' => '/message/' . $uuid], 201);
});

// View an individual message
$app->get('/message/{id}', function($request, $response, $args) {
    $id = $request->getAttribute('id');
    $jack = $this->get('messagejack');

    $message = $jack->getByID($id);

    if ($message == null)
    {
        return $response->withStatus(404);
    }

    return $response->withJson(['email' => $message->email(), 'chatroomID' => $message->chatRoomID(), 'message' => $message->message(), 'created' => $message->created(), 'updated' => $message->updated(), 'uuid' => $message->uuid()]);
});

