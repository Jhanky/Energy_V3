<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VisitaController extends Controller
{

    public function __construct() {}

    public function listar_visitas()
    {
        //$visitas = Visita::orderBy('id', 'desc')->get();
        $visitas = DB::select('SELECT v.*, u.name as nombre_usuario FROM `visitas` as v JOIN users as u ON v.id_user = u.id ORDER by id DESC;');
    
        return view('visitas.index', compact('visitas'));
    }
    

    public function formulario()
    {
        $departamentos = DB::select("SELECT `departamento` FROM `localidad` GROUP by departamento;");
        $ciudades = DB::select("SELECT departamento, municipio FROM `localidad` ORDER BY municipio ASC;");
        return view('visitas.crear', compact('departamentos', 'ciudades'));
    }

    public function crear(Request $request)
    {
        // Verifica si se han subido las imágenes
        $foto_techo_paths = $this->uploadFiles($request->file('foto_techo'), 'img/fotos');
        $foto_soporte_paths = $this->uploadFiles($request->file('foto_soporte'), 'img/fotos');
        $foto_bajante_paths = $this->uploadFiles($request->file('foto_bajante'), 'img/fotos');
        $foto_inversor_paths = $this->uploadFiles($request->file('foto_inversor'), 'img/fotos');
        $foto_tablero_paths = $this->uploadFiles($request->file('foto_tablero'), 'img/fotos');
    
        // Guarda los datos en la base de datos
        $visita = new Visita();
        $visita->fill($request->except([
            'foto_techo', 'foto_soporte', 'foto_bajante', 'foto_inversor', 'foto_tablero'
        ]));

        $visita->foto_techo = json_encode($foto_techo_paths);
        $visita->foto_soporte = json_encode($foto_soporte_paths);
        $visita->foto_bajante = json_encode($foto_bajante_paths);
        $visita->foto_inversor = json_encode($foto_inversor_paths);
        $visita->foto_tablero = json_encode($foto_tablero_paths);

    
        $visita->save();
    
        return redirect('/visitas')->with('rgcmessage', 'Visita registrada con éxito!');
    }
    
    private function uploadFiles($files, $path)
    {
        $filePaths = [];
        if (is_array($files)) { // Verifica si $files es un array
            foreach ($files as $file) {
                if ($file) { // Asegúrate de que el archivo no sea null
                    $filePaths[] = $file->store($path, 'public');
                }
            }
        } else {
            // Si solo se recibe un archivo (por algún motivo), también lo maneja
            if ($files) {
                $filePaths[] = $files->store($path, 'public');
            }
        }
        return $filePaths;
    }

    public function info($id)
    {
        $visita = Visita::find($id);
        //DD($visita);
        // Retornamos las variables a la vista
        return view('visitas.info', compact('visita'));
    }
         
}
