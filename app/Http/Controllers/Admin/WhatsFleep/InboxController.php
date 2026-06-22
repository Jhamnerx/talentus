<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class InboxController extends Controller
{
    public function index(): View
    {
        return view('admin.whatsapp.inbox');
    }
}
