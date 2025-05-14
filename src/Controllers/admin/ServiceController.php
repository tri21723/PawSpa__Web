<?php

namespace App\Controllers\Admin;

class ServiceController
{
  public function index()
  {
    render_view('admin/service/service-management', [], 'admin');
  }

  public function showAddService() {
    render_view('admin/service/add-service', [], 'admin');  // Đường dẫn của file
  }

  public function showUpdateService($id) {
    render_view('admin/service/update-service', [], 'admin');   // Đường dẫn của file
  }

}
