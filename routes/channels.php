<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('whatsapp.empresa.{empresaId}', function ($user, $empresaId) {
    return (int) session('empresa', 1) === (int) $empresaId;
});

Broadcast::channel('whatsapp.conversation.{uuid}', function ($user, $uuid) {
    $conversation = \App\Models\WhatsFleep\WhatsappConversation::where('uuid', $uuid)->first();

    if ($conversation === null) {
        return false;
    }

    if ((int) $conversation->empresa_id !== (int) session('empresa', 1)) {
        return false;
    }

    return $user->can('view', $conversation);
});
