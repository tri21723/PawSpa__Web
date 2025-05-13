<?php

namespace App\controllers\admin;

class UserController {
    public function index() {
        render_view('admin/users/index', ['username' => 'admin12345']);
    }

    public function create() {
        render_view('admin/users/create');
    }

    public function handerCreate() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
    }
}