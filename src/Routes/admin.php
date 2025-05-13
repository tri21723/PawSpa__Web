<?php

$router->mount('/admin', function () use ($router) {

    // Define routes
    $router->get('/dashboard', function () {
        echo 'Dashboard Page!';
    });

    $router->get('/products', function () {
        echo 'Products Page!';
    });

    $router->get('users', 'App\controllers\admin\UserController@index');
    $router->get('/users/create', 'App\controllers\admin\UserController@create');
    $router->post('/users/create', 'App\controllers\admin\UserController@handleCreate');

    $router->get('orders', function () {
        echo 'Orders Page!';
    });
});
