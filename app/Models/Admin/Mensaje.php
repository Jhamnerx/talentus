<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Notifications\EnviarMensaje;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Mensaje extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sendMessage($message)
    {


        $users = User::role('admin')->get();

        foreach ($users as $user){

            $mensaje = Mensaje::create([
                'asunto' => $message["asunto"],
                'body' => $message["body"],
                'messageable_type' => User::class,
                'messageable_id' => $user->id,
                'action' => $message["accion"],
                'from_user_id' => auth()->id(),
            ]);
        }

        Notification::send($users, new EnviarMensaje($mensaje));
        
        return redirect()->back();


    }

        
    
}
