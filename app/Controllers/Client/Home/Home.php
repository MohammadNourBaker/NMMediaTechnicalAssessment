<?php

namespace App\Controllers\Client\Home;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRequired());
        }
        return view('welcome_message');
    }
}
