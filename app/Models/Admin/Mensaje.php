<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Notifications\EnviarMensaje;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sendMessage($message, $type)
    {

        if($type == 'to_user'){

            $mensaje = Mensaje::create([
                'asunto' => $message["asunto"],
                'body' => $message["body"],
                'accion' => $message["accion"],
                'from_user_id' => auth()->id(),
                'to_user_id' => $message["to"],
            ]);

            $user = User::find($message["to"]);

            $user->notify(new EnviarMensaje($mensaje));
            return redirect()->back();


        }else if($type == 'to_client'){
            
        }


        
    }
}
