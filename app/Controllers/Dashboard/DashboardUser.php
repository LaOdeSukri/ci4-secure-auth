<?php
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardUser extends BaseController
{
    public function index()
    {
        echo view('layouts/main', ['title'=>'Dashboard','content'=>view('dashboard/index')]);
    }
}
