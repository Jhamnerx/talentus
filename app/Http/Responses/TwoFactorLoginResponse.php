<?php

namespace App\Http\Responses;

use Laravel\Fortify\Fortify;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {

        $role = Auth::user()->roles;

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->route($role[0]->route_redirect);
    }
}
