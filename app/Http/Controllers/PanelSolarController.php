<?php

namespace App\Http\Controllers;

use App\Models\Panel_solar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PanelSolarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        $paneles = Panel_solar::all();
        $dato = DB::select("SELECT id FROM panel_solars ORDER BY id DESC LIMIT 1;");
    
        // Verificar si hay algún resultado
        if (!empty($dato)) {
            $primerResultado = $dato[0];
            $codigo = $primerResultado->id + 1;
        } else {
            $codigo = 1; // Si no hay registros, empezar desde 1
        }
    
        $codigoConSufijo = $codigo . '-P';
    
        return view('paneles.index', compact('paneles', 'codigoConSufijo'));
    }
    

    public function crear(Request $request)
    {
        // Validar datos
        $validateData = $request->validate([
            'marca' => 'required',
            'codigo' => 'required',
            'modelo' => 'required',
            'poder' => 'required',
            'precio' => 'required'
        ]);

        // Insertar datos en la tabla Paneles
        Panel_solar::create($validateData);

        // Redirigir con un mensaje
        return redirect('/paneles')->with('rgcmessage', 'Panel cargado con éxito...');
    }

    public function actualizar($id)
    {
        $datosCliente = request()->except(['_token', '_method']);
        // Limpiar el precio eliminando los caracteres no numéricos
        if (isset($datosCliente['precio'])) {
            $datosCliente['precio'] = preg_replace('/\D/', '', $datosCliente['precio']);
        }
        Panel_solar::where('id', '=', $id)->update($datosCliente);
        Session::flash('msjupdate', '¡El panel se ha actualizado correctamente!...');
        return redirect('/paneles');
    }
    

    public function eliminar($id)
    {
        Panel_solar::destroy($id);
         return redirect('/paneles')->with('msjdelete', 'Panel borrado correctamente!...');
    }
}
