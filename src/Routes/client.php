<?php

$router->get('/', 'App\Controllers\Client\HomeController@index');
$router->get('/cart', 'App\Controllers\Client\CartController@index');
$router->get('/cart/info', 'App\Controllers\Client\CartController@info');
$router->get('/cart/staff', 'App\Controllers\Client\CartController@staff');
$router->get('/cart/finish', 'App\Controllers\Client\CartController@finish');
$router->get('/cart/finish/success', 'App\Controllers\Client\CartController@success');
$router->get('/booking', 'App\Controllers\Client\BookingController@index');

$router->get('/about', function () {
    echo 'Giới thiệu client!';
});

$router->get('/contact', function () {
    echo 'Liên hệ client!';
});
