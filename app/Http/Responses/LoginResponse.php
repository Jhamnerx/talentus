<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Spatie\Permission\Models\Role;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {

        $role = Auth::user()->roles;

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->route($role[0]->route_redirect);
    }
}
