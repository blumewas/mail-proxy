<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->get('heartbeat', 'ApiController@heartbeat');

    $router->group(['prefix' => 'mail'], function () use ($router) {
        $router->put('/', 'MailController@send');
    });
});

