<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ActaController extends Controller
{
    public function __construct(){

    }

    public function listar_visitas()
    {
        $visitas = DB::select("SELECT v.*, u.name as nombre_usuario FROM `visitas` as v JOIN users as u ON v.id_user = u.id ORDER by id DESC;");
        return view('actas.listar_visita', compact('visitas'));
    }

    public function listar_protocolo()
    {
        //$visitas = Visita::orderBy('id', 'desc')->get();
        $protocolo = DB::select('SELECT v.*, u.name as nombre_usuario FROM `visitas` as v JOIN users as u ON v.id_user = u.id ORDER by id DESC;');

        return view('actas.listar_protocolo', compact('protocolo'));
    }

    public function listar_entrega()
    {
        //$visitas = Visita::orderBy('id', 'desc')->get();
        $protocolo = DB::select('SELECT v.*, u.name as nombre_usuario FROM `visitas` as v JOIN users as u ON v.id_user = u.id ORDER by id DESC;');

        return view('actas.listar_entrega', compact('protocolo'));
    }

    public function listar_prestacion()
    {
        $tecnicos = DB::select('SELECT u.name FROM users AS u JOIN model_has_roles as m ON u.id = m.model_id WHERE m.role_id = 3;');
        $clientes = DB::select("SELECT * FROM `clientes` ORDER by id DESC;");
        //DD($clientes);
        return view('actas.listar_prestacion', compact('tecnicos', 'clientes'));
    }

    public function formulario_visita()
    {
        $departamentos = DB::select("SELECT `departamento` FROM `localidad` GROUP by departamento;");
        $ciudades = DB::select("SELECT departamento, municipio FROM `localidad` ORDER BY municipio ASC;");
        return view('actas.formulario_visita', compact('departamentos', 'ciudades'));
    }

    public function guardar_visita(Request $request)
    {
        // Validar datos y archivos
        $request->validate([
            'foto_techo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_soporte.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_bajante.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_inversor.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_tablero.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Subir imágenes y obtener rutas
        $foto_techo_paths = $this->uploadFiles($request->file('foto_techo'), 'img/fotos');
        $foto_soporte_paths = $this->uploadFiles($request->file('foto_soporte'), 'img/fotos');
        $foto_bajante_paths = $this->uploadFiles($request->file('foto_bajante'), 'img/fotos');
        $foto_inversor_paths = $this->uploadFiles($request->file('foto_inversor'), 'img/fotos');
        $foto_tablero_paths = $this->uploadFiles($request->file('foto_tablero'), 'img/fotos');

        // Crear una nueva instancia del modelo Visita
        $visita = new Visita();

        // Rellenar los campos permitidos en $fillable, excluyendo las fotos
        $visita->fill($request->except([
            'foto_techo',
            'foto_soporte',
            'foto_bajante',
            'foto_inversor',
            'foto_tablero'
        ]));

        // Asignar explícitamente el ID del usuario autenticado, si aplica
        $visita->id_user = $request->input('id_user');

        // Asegurarte de que los campos que podrían ser nulos o tienen valores predeterminados no causen errores
        $visita->notas_observaciones_tbl = $request->input('notas_observaciones_tbl', 'Sin observaciones');

        // Guardar la visita
        $visita->save();

        // Guardar las fotos asociadas
        $this->guardarFotos($visita->id, 'techo', $foto_techo_paths);
        $this->guardarFotos($visita->id, 'soporte', $foto_soporte_paths);
        $this->guardarFotos($visita->id, 'bajante', $foto_bajante_paths);
        $this->guardarFotos($visita->id, 'inversor', $foto_inversor_paths);
        $this->guardarFotos($visita->id, 'tablero', $foto_tablero_paths);

        // Redirigir con mensaje de éxito
        return redirect('/visitas')->with('rgcmessage', 'Visita registrada con éxito!');
    }

    private function guardarFotos($id_visita, $tipo, $fotos)
    {
        if (count($fotos) > 4) {
            $fotos = array_slice($fotos, 0, 4); // Limitar a un máximo de 4 fotos
        }

        foreach ($fotos as $foto) {
            Foto::create([
                'id_visita' => $id_visita,
                'tipo' => $tipo,
                'ruta' => $foto,
            ]);
        }
    }

    private function uploadFiles($files, $path)
    {
        $uploadedPaths = [];
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
