<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Message;
use App\Models\User;
use App\Notifications\EnviarMensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    public  function show(Message $mensaje)
    {
        return view('mensajes.show', compact('mensaje'));
    }

    public function sendMessage($message, $type)
    {

        if($type == 'to_user'){

            $mensaje = Message::create([
                'asunto' => $message->asunto,
                'body' => $message->body,
                'from_user_id' => auth()->id(),
                'to_user_id' => $message->to,
            ]);

            $user = User::find($message->to);
            $user->notify(new EnviarMensaje($mensaje));
        }else{
            
        }


        //return redirect()->back();
    }
}
