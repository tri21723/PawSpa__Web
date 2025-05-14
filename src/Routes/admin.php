<?php

$router->mount('/admin', function () use ($router) {

    // Define routes
    $router->get('/dashboard', 'App\controllers\admin\DashboardController@index');

    // Service
    $router->get('/service', 'App\controllers\admin\ServiceController@index');
    $router->get('/service/add', 'App\controllers\admin\ServiceController@showAddService');
    $router->get('/service/update/{id}', 'App\controllers\admin\ServiceController@showUpdateService');

    // ServiceType
    $router->get('/service-type', 'App\controllers\admin\ServiceTypeController@index');
    $router->get('/service-type/add', 'App\controllers\admin\ServiceTypeController@showAddServiceType');
    $router->get('/service-type/update/{id}', 'App\controllers\admin\ServiceTypeController@showUpdateServiceType');

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
