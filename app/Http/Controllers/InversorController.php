<?php

namespace App\Http\Controllers;

use App\Models\Inversor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class InversorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        $inversores = Inversor::all();
        $dato = DB::select("SELECT id FROM inversors ORDER BY id DESC LIMIT 1;");

        // Verificar si hay algún resultado
        if (!empty($dato)) {
            $primerResultado = $dato[0];
            $codigo = $primerResultado->id + 1;
        } else {
            $codigo = 1; // Si no hay registros, empezar desde 1
        }

        $codigoConSufijo = $codigo . '-P';

        return view('inversores.index', compact('inversores', 'codigoConSufijo'));
    }

    public function crear(Request $request)
    {

        $validateData = $request->validate([
            'marca' => 'required',
            'codigo' => 'required',
            'modelo' => 'required',
            'tipo_red' => 'required',
            'poder' => 'required',
            'tipo' => 'required',
            'precio' => 'required'
        ]);
        // Insertar datos en la tabla Investor
        Inversor::create($validateData);

        // Redirigir con un mensaje
        return redirect('/inversores')->with('rgcmessage', 'Inversor cargado con éxito...');
    }

    public function actualizar($id)
    {
        $datosCliente = request()->except(['_token', '_method']);
        // Limpiar el precio eliminando los caracteres no numéricos
        if (isset($datosCliente['precio'])) {
            $datosCliente['precio'] = preg_replace('/\D/', '', $datosCliente['precio']);
        }
        Inversor::where('id', '=', $id)->update($datosCliente);
        Session::flash('msjupdate', '¡El inversor se a actualizado correctamente!...');
        return redirect('/inversores');
    }

    public function eliminar($id)
    {
        Inversor::destroy($id);
        return redirect('/inversores')->with('msjdelete', 'inversor borrado correctamente!...');
    }
}
