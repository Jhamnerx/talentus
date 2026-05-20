<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;

class MessageHistoryController extends Controller
{
    public function index()
    {
        return view('admin.whats-fleep.messages.history');
    }
}
