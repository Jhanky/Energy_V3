<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Evidencia;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EvidenciasController extends Controller
{
    public function create($id)
    {
        $orden = Orden::findOrFail($id);
        return view('evidencias.create', compact('orden'));
    }

    public function store(Request $request)
    {
        //DD($request->all());
        $request->validate([
            'orden_id' => 'required|exists:ordenes,id',
            'observaciones' => 'required|string',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $evidencia = new Evidencia();
        $evidencia->orden_id = $request->orden_id;
        $evidencia->observaciones = $request->observaciones;
    
        if ($request->hasFile('foto')) {
            $fotos = $this->uploadFiles($request->file('foto'), 'evidencias');
            $evidencia->ruta = json_encode($fotos);
        } else {
            $evidencia->ruta = json_encode([]); // Sin fotos
        }
    
        $evidencia->save();
    
        // Actualizar el estado de la orden
        $orden = Orden::findOrFail($request->orden_id);
        $orden->estado = 2;
        $orden->save();
    
        return redirect()->route('orden.listar')->with('rgcmessage', 'Evidencias subidas y orden terminada.');
    }

    private function uploadFiles($files, $path)
    {
        $uploadedPaths = [];

        // Crear la carpeta si no está creada
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $uploadedPaths[] = $file->store($path, 'public');
            }
        } elseif ($files) { // Manejo de un solo archivo (por si no es un array)
            $uploadedPaths[] = $files->store($path, 'public');
        }
        return $uploadedPaths;
    }
    
}
