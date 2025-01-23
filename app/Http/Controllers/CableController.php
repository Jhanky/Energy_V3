<?php

namespace App\Http\Controllers;

use App\Models\Cable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        $cables = Cable::all();
        //DD($cables);
        $verificar = DB::select("SELECT id FROM cables LIMIT 1;");

        return view('cable.index', compact('cables', 'verificar'));
    }

    public function crear(Request $request)
    {
        // Validar datos
        $validateData = $request->validate([
            'marca' => 'required',
            'precio' => 'required'
        ]);
        
        // Insertar datos en la tabla Paneles
        Cable::create($validateData);

        // Redirigir con un mensaje
        return redirect('/cables')->with('rgcmessage', 'Cable cargado con éxito...');
    }

    public function actualizar($id)
    {
        $datosCliente = request()->except(['_token', '_method']);
        if (isset($datosCliente['precio'])) {
            $datosCliente['precio'] = preg_replace('/\D/', '', $datosCliente['precio']);
        }
        Cable::where('id', '=', $id)->update($datosCliente);
        Session::flash('msjupdate', '¡El Cable se a actualizado correctamente!...');
        return redirect('/cables');
    }

    public function eliminar($id)
    {
        DD($id);
        Cable::destroy($id);
         return redirect('/cables')->with('msjdelete', 'Cable borrado correctamente!...');
    }
}
