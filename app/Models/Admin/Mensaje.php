<?php

namespace App\Models\Admin;

use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\Mantenimiento;
use App\Models\User;
use App\Notifications\EnviarMensaje;
use App\Notifications\EnviarMensajeCobro;
use App\Notifications\Mantenimientos\NotifyAdmin;
use App\Notifications\Mantenimientos\NotifyClient;
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
            return $e->getMessage();
        } finally {

            return redirect()->back();
        }
    }


    public function sendCobroMessage($mensaje, Cobros $cobro)
    {

        $users = User::role('admin')->get();

        // foreach ($users as $user){
        //     $mensaje = Mensaje::create([
        //         'asunto' => $message["asunto"],
        //         'body' => $message["body"],
        //         'messageable_type' => User::class,
        //         'messageable_id' => $user->id,
        //         'action' => $message["accion"],
        //         'to_user_id ' => $user->id,
        //         'from_user_id' => auth()->id(),
        //     ]);
        // }

        Notification::send($users, new EnviarMensajeCobro($mensaje, $cobro));

        //return redirect()->back();


    }


    public function sendMantenimientoMessageAdmin($data, Mantenimiento $mantenimiento)
    {
        $users = User::role('admin')->get();

        Notification::send($users, new NotifyAdmin($data, $mantenimiento));
    }

    public function sendMantenimientoMessageClient($data, Mantenimiento $mantenimiento, Clientes $cliente)
    {

        $cliente->notify(new NotifyClient($data, $mantenimiento));
    }
}
