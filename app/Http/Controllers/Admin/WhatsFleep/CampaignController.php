<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    public function index()
    {
        return view('admin.whats-fleep.campaigns.index');
    }

    public function create()
    {
        return view('admin.whats-fleep.campaigns.create');
    }
}
