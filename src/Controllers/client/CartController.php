<?php

namespace App\controllers\client;

class CartController {
    public function index() {
        render_view('client/cart/index', [], 'client');
    }

    public function info() {
        render_view('client/cart/info', [], 'client');
    }

    public function staff() {
        render_view('client/cart/staff', [], 'client');
    }

    public function finish() {
        render_view('client/cart/finish', [], 'client');
    }

}