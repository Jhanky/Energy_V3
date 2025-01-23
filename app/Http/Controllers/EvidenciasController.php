<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Evidencia;

class EvidenciasController extends Controller
{
    public function create($id)
    {
        $orden = Orden::findOrFail($id);
        return view('evidencias.create', compact('orden'));
    }

    public function store(Request $request)
    {
        // ...existing code...

        $request->validate([
            'orden_id' => 'required|exists:ordenes,id',
            'observaciones' => 'required|string',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $evidencia = new Evidencia();
        $evidencia->orden_id = $request->orden_id;
        $evidencia->observaciones = $request->observaciones;
    
        if ($request->hasFile('foto')) {
            $fotos = [];
            
            // Verificar si los archivos han sido cargados correctamente
            foreach ($request->file('foto') as $index => $foto) {
                if ($foto->isValid()) {
                    // Almacenar el archivo
                    $path = $foto->store('evidencias', 'public');
                    $fotos[] = $path;
                } else {
                    // Manejar el caso en que un archivo no es válido
                    return back()->withErrors(['foto' => 'Hubo un error con uno o más archivos.']);
                }
            }
    
            // Guardar las rutas de las fotos en la base de datos
            $evidencia->ruta = json_encode($fotos);
        } else {
            $evidencia->ruta = json_encode([]); // Sin fotos
        }
    
        $evidencia->save();
    
        // Actualizar el estado de la orden
        $orden = Orden::findOrFail($request->orden_id);
        $orden->estado = 2;
        $orden->save();
    
        return redirect()->route('orden.listar')->with('success', 'Evidencias subidas y orden terminada.');
    }
    
}
