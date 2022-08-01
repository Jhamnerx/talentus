<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|eliminar-rol', ['only' => ['index']]);
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-rol', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.permisos.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permisos = Permission::get();
        return view('admin.permisos.roles.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:roles',
            'permission' => 'required',
        ]);

        $rol = Role::create(['name' => $request->input('name')]);
        $rol->syncPermissions($request->input('permission'));
        return redirect()->route('admin.ajustes.roles');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Role::find($id);
        $permisos = Permission::get();
        $rolPermisos = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
        ->all();

        return view('admin.permisos.roles.edit', compact('rol', 'permisos', 'rolPermisos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $rol = Role::find($id);
        $rol->name = $request->input('name');
        $rol->save();

        $rol->syncPermission($request->input('permission'));
        return redirect()->route('admin.permisos.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('admin.permisos.roles.index');
    }
}
