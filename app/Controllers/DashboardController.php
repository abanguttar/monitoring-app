<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $title = 'Dashboard';
        $message = 'Hallo, selamat datang ';
        $username = $this->auth->user()->username;
        return view('dashboard', compact('title', 'message', 'username'));
    }
}
