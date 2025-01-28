<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Foto;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActaController extends Controller
{
    public function __construct() {}

    public function guardarOrden(Request $request)
    {
        // Validar datos
        $request->validate([
            'tipo' => 'required|string|max:255',
            'id_cliente' => 'required|integer',
            'direccion' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'observaciones' => 'nullable|string',
            'tecnicos_seleccionados' => 'nullable|string',
        ]);

        // Crear una nueva instancia del modelo Orden
        $orden = new Orden();
        $orden->tipo = $request->input('tipo');
        $orden->id_cliente = $request->input('id_cliente');
        $orden->direccion = $request->input('direccion');
        $orden->fecha_hora = $request->input('fecha_hora');
        $orden->observaciones = $request->input('observaciones');
        $orden->tecnicos_seleccionados = $request->input('tecnicos_seleccionados');

        // Guardar la orden
        $orden->save();

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('rgcmessage', 'Orden de servicio creada con éxito!');
    }

    public function listar_ordenes()
    {
        $user = Auth::user();
        $id = $user->id;
        $rol = $user->roles->first()->id;
        if ($rol == 1) {
            $ordenes = DB::select("SELECT o.*, c.nombre AS nombre_cliente, (SELECT GROUP_CONCAT(e.ruta) FROM evidencias e WHERE e.orden_id = o.id) AS evidencias, (SELECT GROUP_CONCAT(e.observaciones) FROM evidencias e WHERE e.orden_id = o.id) AS notas, (SELECT GROUP_CONCAT(h.nombre SEPARATOR ', ') FROM tipo_orden_herramienta toh JOIN herramientas h ON toh.herramienta_id = h.id JOIN tipo_orden tor ON toh.tipo_orden_id = tor.id WHERE tor.nombre = o.tipo) AS herramientas FROM `ordenes` AS o JOIN clientes AS c ON o.id_cliente = c.NIC ORDER BY o.id DESC;");
        } else {
            $ordenes = DB::select("SELECT o.*, c.nombre AS nombre_cliente, (SELECT GROUP_CONCAT(e.ruta) FROM evidencias e WHERE e.orden_id = o.id) AS evidencias, (SELECT GROUP_CONCAT(e.observaciones) FROM evidencias e WHERE e.orden_id = o.id) AS notas, (SELECT GROUP_CONCAT(h.nombre SEPARATOR ', ') FROM tipo_orden_herramienta toh JOIN herramientas h ON toh.herramienta_id = h.id JOIN tipo_orden tor ON toh.tipo_orden_id = tor.id WHERE tor.nombre = o.tipo) AS herramientas FROM `ordenes` AS o JOIN clientes AS c ON o.id_cliente = c.NIC WHERE FIND_IN_SET($id, o.tecnicos_seleccionados) > 0 ORDER BY o.id DESC;");
        }

        $tecnicos = DB::select('SELECT u.id, u.name FROM users AS u JOIN model_has_roles as m ON u.id = m.model_id WHERE m.role_id = 3;');
        $clientes = DB::select("SELECT * FROM `clientes` ORDER by id DESC;");

        $tipos_orden = DB::select("SELECT * FROM `tipo_orden` ORDER BY nombre ASC;");
        
        //DD($ordenes);
        return view('actas.ordenes.listar_orden', compact('tecnicos', 'clientes', 'ordenes', 'tipos_orden'));
    }

    public function eliminarOrden($id)
    {
        $orden = Orden::findOrFail($id);
        $orden->delete();

        return redirect()->route('orden.listar')->with('msjdelete', 'Orden eliminada con éxito.');
    }

    public function listar_visitas()
    {
        $user = Auth::user();
        $id = $user->id;
        $rol = $user->roles->first()->id;
        if ($rol == 1) {
            $visitas = DB::select("SELECT v.*, u.name as nombre_usuario FROM `visitas` as v JOIN users as u ON v.id_user = u.id ORDER by id DESC;");
        } else {
            $visitas = DB::select("SELECT v.*, u.name as nombre_usuario FROM `visitas` as v JOIN users as u ON v.id_user = $id ORDER by id DESC;");
        }

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
