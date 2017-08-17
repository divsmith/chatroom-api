<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$app->add(function($request, $response, $next) {
    $headers = $request->getHeaders();

    if ($headers['HTTP_TOKEN'][0] == "supersecrettoken")
    {
        return $next($request, $response);
    }

    //var_dump($headers);
    return $response->withStatus(401);
});