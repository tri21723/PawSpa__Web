<?php

namespace App\controllers\client;

class HomeController {
    public function index() {
        render_view('client/home/index');
    }

}