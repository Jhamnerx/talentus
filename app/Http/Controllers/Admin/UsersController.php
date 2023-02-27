<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin.usuarios.index', ['only' => ['index']]);
        $this->middleware('permission:admin.usuarios.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.usuarios.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin.usuarios.delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $usuarios = User::paginate(10);

        return view('admin.usuarios.index', compact('usuarios'));
    }


    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.usuarios.create', compact('roles'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            // 'roles' => 'required',
        ]);

        $input = $request->all();
        //dd($validacion);

        // $user = User::create($input);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'tipo_documento' => $input['tipo_documento'],
            'numero_documento' => $input['numero_documento'],
            'telefonos' => $input['telefonos'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')->with('store', 'usuario registrado');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('admin.usuarios.edit', compact('user', 'roles', 'userRoles'));
    }


    public function update(Request $request, User $user)
    {


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'confirmed',
            // 'roles' => 'required',
        ]);


        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('admin.users.index')->with('update', 'usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.usuarios.index')->with('delete', 'usuario eliminado');
    }
}
