<?php

namespace App\Http\Controllers;

use App\Models\Bateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class BateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listar()
    {
        // Obtener todas las baterías excepto la que tiene ID igual a 1
        $baterias = Bateria::where('id', '<>', 1)->get();
        $dato = DB::select("SELECT id FROM baterias ORDER BY id DESC LIMIT 1;");
        $primerResultado  = $dato[0];
        $codigo = $primerResultado->id + 1;
        $codigoConSufijo = $codigo . '-P';
    
        return view('baterias.index', compact('baterias', 'codigoConSufijo'));
    }

    public function crear(Request $request)
    {
        // Validar datos
        $validateData = $request->validate([
            'marca' => 'required',
            'codigo' => 'required',
            'tipo' => 'required',
            'voltaje' => 'required',
            'amperios_hora' => 'required',
            'precio' => 'required'
        ]);

        Bateria::create($validateData);

        // Redirigir con un mensaje
        return redirect('/baterias')->with('rgcmessage', 'Bateria registrada con éxito...');
    }

    public function actualizar($id)
    {
        $datosCliente = request()->except(['_token', '_method']);
        //DD( $datosCliente );
        if (isset($datosCliente['precio'])) {
            $datosCliente['precio'] = preg_replace('/\D/', '', $datosCliente['precio']);
        }
        Bateria::where('id', '=', $id)->update($datosCliente);
        Session::flash('msjupdate', '¡La bateria se a actualizado correctamente!...');
        return redirect('/baterias');
    }

    public function eliminar($id)
    {
        Bateria::destroy($id);
         return redirect('/baterias')->with('msjdelete', 'Bateria borrada correctamente!...');
    }
}
