<?php

namespace App\Controllers\Admin;

class ServiceTypeController
{
  public function index()
  {
    render_view('admin/service-type/service-type-management', [], 'admin');
  }

  public function showAddService() {
    render_view('admin/service-type/add-service-type', [], 'admin');  // Đường dẫn của file
  }

  public function showUpdateService($id) {
    render_view('admin/service-type/update-service-type', [], 'admin');   // Đường dẫn của file
  }

}
