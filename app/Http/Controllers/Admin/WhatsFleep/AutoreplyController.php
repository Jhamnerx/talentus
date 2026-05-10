<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;

class AutoreplyController extends Controller
{
    public function index()
    {
        return view('admin.whats-fleep.autoreplies.index');
    }
}
