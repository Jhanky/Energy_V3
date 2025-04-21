<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Pdf_actasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function visita(Request $request, $id)
    {
        set_time_limit(300);
        Carbon::setLocale('es');

        // Consultar el cliente específico por ID
        $visita = DB::select("SELECT * FROM `visitas` WHERE id ='$id'");
        $fotos = DB::select("SELECT tipo, ruta FROM `fotos` WHERE id_visita = '$id'");

        if (!$visita) {
            return redirect()->back()->withErrors('Cliente no encontrado.');
        }
        $datos = $visita[0];

        // Asegurarse de que las rutas de las fotos sean correctas
        foreach ($fotos as $foto) {
            $foto->ruta = 'storage/' . $foto->ruta;
        }

        //DD($fotos);
        // Generar el PDF cargando la vista y pasando los datos
        $pdf = Pdf::loadView('pdf.acta_visita', [
            'visita' => $datos,
            'fotos' => $fotos,
        ]);

        // Descargar el PDF con un nombre dinámico
        return $pdf->stream('Acta_de_visita_' . $id . '.pdf');
    }

    public function entrega(Request $request, $id)
    {
        Carbon::setLocale('es');

        // Consultar el cliente específico por ID
        $cliente = DB::table('clientes')
            ->select('*')
            ->where('id', $id)
            ->first(); // Para obtener un solo cliente
        if (!$cliente) {
            return redirect()->back()->withErrors('Cliente no encontrado.');
        }  

        // Generar el PDF cargando la vista y pasando los datos
        $pdf = Pdf::loadView('pdf.acta_entrega', [
            'cliente' => $cliente,
        ]);

        // Descargar el PDF con un nombre dinámico
        return $pdf->download('Acta_de_entrega_de_proyecto_' . $id . '.pdf');
    }
}
