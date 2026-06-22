<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(User $user): RedirectResponse
    {
        /** @var \App\Models\User $impersonator */
        $impersonator = Auth::user();

        abort_unless($impersonator->can('admin.usuarios.impersonate'), 403);

        $reason = $impersonator->cannotImpersonateReason($user);
        if ($reason !== null) {
            return back()->with('error', $reason);
        }

        session(['impersonator_id' => $impersonator->id]);
        Auth::login($user);
        session()->put('empresa', 1);

        activity()
            ->causedBy($impersonator)
            ->performedOn($user)
            ->log('Inició sesión como usuario (impersonación)');

        $redirect = optional($user->roles->first())->route_redirect ?: 'admin.home';

        return redirect()->route($redirect);
    }

    public function leave(): RedirectResponse
    {
        abort_unless(session()->has('impersonator_id'), 403);

        $originalId = session('impersonator_id');
        Auth::loginUsingId($originalId);
        session()->forget('impersonator_id');
        session()->put('empresa', 1);

        activity()->log('Finalizó la impersonación');

        return redirect()->route('admin.users.index');
    }
}
