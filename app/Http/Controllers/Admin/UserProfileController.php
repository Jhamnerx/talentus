<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('admin.usuarios.profile', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
