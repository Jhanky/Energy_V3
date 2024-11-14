<?php

namespace App\Http\Controllers;

use App\Models\Diseno;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Grafica;


class UserController extends Controller
{
    public function crearUsuario(Request $request)
    {
        // Validación de datos
        $validar_datos = $request->validate([
            'id_user' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'meta' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'rol_id' => 'required|exists:roles,id',
        ]);

        if (isset($validar_datos['meta'])) {
            $validar_datos['meta'] = preg_replace('/\D/', '', $validar_datos['meta']);
        }
        // Hash de la contraseña
        $validar_datos['password'] = Hash::make($validar_datos['password']);

        // Crear usuario
        $usuario = User::create($validar_datos);

        // Asignar rol al usuario
        $usuario->roles()->attach($validar_datos['rol_id']);

        // Redirigir con mensaje de éxito
        return redirect('/usuarios')->with('rgcmessage', 'Usuario creado exitosamente');
    }

    public function listarUsuarios()
    {
        $id_usuario = Auth::user()->id;
        $role_usuario = DB::table('model_has_roles')->where('model_id', $id_usuario)->value('role_id');
        if ($role_usuario == 3) {
            // Filtra los usuarios por el id del usuario logueado
            $usuarios = DB::select("SELECT t1.*, t3.name as ROL, t3.id as rol_id 
                                    FROM users AS t1 
                                    JOIN model_has_roles AS t2 ON t1.id = t2.model_id 
                                    JOIN roles AS t3 ON t2.role_id = t3.id 
                                    WHERE t1.id_user = ?", [$id_usuario]);
        } else {
            // Consulta normal sin filtrar por el id del usuario logueado
            $usuarios = DB::select("SELECT t1.*, t3.name as ROL, t3.id as rol_id 
                                    FROM users AS t1 
                                    JOIN model_has_roles AS t2 ON t1.id = t2.model_id 
                                    JOIN roles AS t3 ON t2.role_id = t3.id;");
        }
        $roles = DB::select("SELECT * FROM roles;");
        return view('usuarios.index', compact('usuarios', 'roles', 'role_usuario'));
    }

    public function eliminar($id)
    {
        // Obtener el ID del presupuesto del usuario
        $presupuesto = Presupuesto::where('id_user', $id)->pluck('id');

        // Verificar si hay algún presupuesto asociado al usuario
        if (!$presupuesto->isEmpty()) {
            // Obtener el primer ID de presupuesto
            $p_id = $presupuesto[0];

            // Eliminar registros relacionados en la tabla 'graficas'
            Grafica::where('id_presupuesto', $p_id)->delete();


            // Eliminar los presupuestos del usuario
            Presupuesto::where('id_user', $id)->delete();
        }

        // Eliminar al usuario
        User::findOrFail($id)->delete();

        return redirect('/usuarios')->with('msjdelete', 'Usuario borrado correctamente!...');
    }

    public function actualizar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',

        ]);

        // Buscar el usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualizar los datos del usuario
        $usuario->nombre = $request->nombre;
        $usuario->name = $request->name;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;

        // Actualizar la contraseña si se proporciona una nueva
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        // Redireccionar con un mensaje de éxito
        if ($usuario->save()) {
            return redirect()->route('usuarios.listar')->with('rgcmessage', 'Datos actualizados con éxito...');
        } else {
            return back()->with(['msjdelete' => 'No se pudo actualizar el usuario']);
        }
    }
}
