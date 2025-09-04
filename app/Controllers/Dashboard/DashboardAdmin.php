<?php
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardAdmin extends BaseController
{
    public function index()
    {
        echo view('layouts/main', ['title'=>'Admin Dashboard','content'=>view('dashboard/index')]);
    }
}
