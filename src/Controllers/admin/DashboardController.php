<?php

namespace App\Controllers\Admin;

class DashboardController
{
  public function index()
  {
    render_view('admin/dashboard/index', [], 'admin');
  }
}
