<?php

namespace App\Models\Admin;

use App\Models\Cobros;
use App\Models\User;
use App\Notifications\EnviarMensaje;
use App\Notifications\EnviarMensajeCobro;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Mensaje extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sendMessage($data)
    {
       
        $users = User::role('admin')->get();


        // foreach ($users as $user){

        //     $mensaje = Mensaje::create([

        //         'asunto' => $data["asunto"],
        //         'body' => $data["body"],
        //         'url' => $data["url"],
        //         'id_certificado' => $data["id_certificado"],
        //         'messageable_type' => User::class,
        //         'messageable_id' => $user->id,
        //         'action' => $data["accion"],
        //         'to_user_id ' => $user->id,
        //         'from_user_id' => auth()->id(),

        //     ]);
            
        // }

        try {

            Notification::send($users, new EnviarMensaje($data));

        } catch (Exception $e) {
            
            //dd($e);

        }finally{
        
            return redirect()->back();
        }
       



    }


    public function sendCobroMessage($message, Cobros $cobro)
    {


        $users = User::role('admin')->get();

        foreach ($users as $user){

            $mensaje = Mensaje::create([
                'asunto' => $message["asunto"],
                'body' => $message["body"],
                'messageable_type' => User::class,
                'messageable_id' => $user->id,
                'action' => $message["accion"],
                'to_user_id ' => $user->id,
                'from_user_id' => auth()->id(),
            ]);
        }

        // Notification::send($users, new EnviarMensajeCobro($mensaje, $cobro));
        
        // return redirect()->back();


    }

        
    
}
