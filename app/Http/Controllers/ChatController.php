<?php

namespace App\Http\Controllers;

use App\Models\Diseno;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChatController extends Controller
{


    public function chat()
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
        return view('chat.index', compact('usuarios', 'roles', 'role_usuario'));
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
            Diseno::where('id_presupuesto', $p_id)->delete();

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
            'password' => 'nullable|string|min:8', // Se requiere solo si se proporciona una nueva contraseña
            // Agregar más reglas de validación según tus necesidades
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
        //DD($usuario);
        // Guardar los cambios en la base de datos
        $usuario->save();

        // Redireccionar con un mensaje de éxito
        return redirect()->route('usuarios.listar')->with('rgcmessage', 'Datos actualizados con éxito...');
    }
}
