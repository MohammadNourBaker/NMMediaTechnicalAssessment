<?php

namespace App\Controllers\Client\Chat;

use App\Controllers\BaseController;

class ChatController extends BaseController
{
    public function index()
    {
        $data = [];

        return view('client/chat', $data);
    }
}
