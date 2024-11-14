<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Diseno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DisenosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        $userID = Auth::id();
        $rol = DB::select("SELECT role_id FROM `model_has_roles` WHERE model_id = ?", [$userID]);
        $primerResultado = $rol[0];
        $id = $primerResultado->role_id;

        $clientes = DB::select("SELECT presupuestos.nombre_proyecto, presupuestos.id, presupuestos.numero_paneles, clientes.ciudad, clientes.direccion, panel_solars.poder FROM presupuestos JOIN clientes ON presupuestos.id_cliente = clientes.NIC JOIN panel_solars ON presupuestos.id_panel = panel_solars.id WHERE presupuestos.id_estado =1 ORDER BY presupuestos.id DESC");

        $departamentos = DB::select("SELECT `departamento` FROM `localidad` GROUP by departamento;");
        $ciudades = DB::select("SELECT departamento, municipio FROM `localidad` ORDER BY municipio ASC;");
        
        // Retornamos las variables a la vista
        return view('disenos.index', compact('clientes', 'departamentos', 'ciudades'));
    }

    public function crear(Request $request)
    {

        DD($request);
        // Validar los datos
        $validar_datos = $request->validate([
            'NIC' => 'required',
            'id_user' => 'required',
            'tipo_cliente' => 'required',
            'nombre' => 'required',
            'departamento' => 'required',
            'ciudad' => 'required',
            'direccion' => '',
            'area_potencial' => '',
            'consumo_actual' => '',
            'tarifa' => ''
        ]);
    
        // Filtrar solo los datos válidos para evitar errores al insertar
        $datos_validos = array_filter($validar_datos);
    
        // Insertar los datos válidos en la base de datos
        Cliente::create($datos_validos);
    
        return redirect('/clientes')->with('rgcmessage', 'Cliente registrado con éxito!');
    }    

    public function actualizar(Request $request, $id)
    {

        $datosCliente = request()->except(['_token', '_method']);
        Cliente::where('NIC', '=', $id)->update($datosCliente);

        Session::flash('msjupdate', '¡El Cliente se a actualizado correctamente!...');
        return redirect('/clientes');
    }
    
    public function eliminar($id)
    {
        Diseno::where('id_presupuesto', $id)->delete();
        // Eliminar el presupuesto
        
        Presupuesto::where('id', $id)->delete();
        Cliente::where('NIC', $id)->delete();
        return redirect('/clientes')->with('msjdelete', 'Cliente borrado correctamente!...');
    }

    public function info($NIC)
    {  
        $cliente = DB::table('clientes')->where('NIC', $NIC)->first();
        $ciudad = $cliente->ciudad;
        $consumoActual = $cliente->consumo_actual;

        $radiacionData = DB::select("SELECT radiacion FROM `localidad` WHERE municipio = '$ciudad';");
        $primerResultado2  = $radiacionData[0];
        $radiacion = $primerResultado2->radiacion;

        $potencia = DB::table('clientes')->where('NIC', $NIC)->value('consumo_actual');
        $paneles = DB::table('panel_solars')->select('id', 'marca', 'poder', 'precio')->orderBy('precio', 'asc')->get();
        $inversores = DB::table('inversors')->select('id', 'marca','tipo', 'tipo_red', 'poder', 'precio')->orderBy('precio', 'asc')->get();
        $baterias = DB::table('baterias')->select('id', 'marca', 'tipo', 'voltaje', 'amperios_hora', 'precio')->where('id', '<>', 1)->orderBy('precio', 'asc')->get();
        $conductor_fotovoltaico = DB::table('cables')->first();

        // Potencia a intalar en kW
        $promedio = ($consumoActual * 12) / 1500;

        // Potencia a intalar en W
        $potenciaDeseada = 20 * 1000;

        // Paneles sugeridos
        $panelesNecesarios = [];
        $potenciaRestante = $potenciaDeseada;

        foreach ($paneles as $panel) {
            $cantidadPaneles = round($potenciaRestante / $panel->poder);

            if ($cantidadPaneles > 0) {
                $panelesNecesarios[] = [
                    'id' => $panel->id,
                    'nombre' => $panel->marca,
                    'cantidad' => $cantidadPaneles,
                    'potencia_total' => $cantidadPaneles * $panel->poder,
                ];

                $potenciaRestante -= $cantidadPaneles * $panel->poder;
            }
        }

        $userID = Auth::id();
        $rol = DB::select("SELECT role_id FROM `model_has_roles` WHERE model_id = '.$userID.';");
        $primerResultado  = $rol[0];
        $id = $primerResultado->role_id;

        $presupuestos = DB::table('presupuestos')
            ->select(
                'presupuestos.id',
                'presupuestos.created_at',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                'inversors.marca AS investor_marca',
                'clientes.NIC',
                'clientes.nombre',
                'presupuestos.nombre_proyecto',
                'clientes.tipo_cliente',
                'presupuestos.codigo_propuesta',
                'panel_solars.marca AS solar_panel_marca',
                'presupuestos.tipo_sistema',
                'presupuestos.valor_material_electrico',
                'presupuestos.valor_conductor_fotovoltaico',
                'baterias.marca AS batterie_marca',
                'presupuestos.descuento',
                'presupuestos.mano_obra',
                'presupuestos.valor_estructura',
                'presupuestos.valor_tramites',
                'inversors.marca AS investor_marca',
                'presupuestos.valor_retencion',
                'panel_solars.poder',
                'inversors.poder AS poder_investor',
                'baterias.amperios_hora',
                'panel_solars.precio',
                'baterias.amperios_hora',
                'baterias.precio As precio_batterie',
                'inversors.precio AS precio_investor',
                'presupuestos.numero_paneles',
                'presupuestos.numero_baterias',
                'presupuestos.numero_inversores',
                'presupuestos.valor_gestion_comercial',
                'presupuestos.valor_administracion',
                'presupuestos.valor_imprevisto',
                'presupuestos.valor_utilidad',
                'presupuestos.valor_retencion',
                'inversors2.marca AS investor2_marca',
                'inversors2.poder AS poder2_investor',
                'inversors2.precio AS precio2_investor',
                'presupuestos.numero_inversores_2',
                'estados.nombre as nombre_estado',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                DB::raw('((clientes.consumo_actual * 12)/1500) AS kwp1 '),
                DB::raw('(panel_solars.precio * presupuestos.numero_paneles) AS panel_cost'),
                DB::raw('(COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) AS battery_cost'),
                DB::raw('(inversors.precio * presupuestos.numero_inversores) AS investor_cost'),
                DB::raw('((panel_solars.precio * presupuestos.numero_paneles) * 1.25) + ((COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) * 1.25) + ((inversors.precio * presupuestos.numero_inversores) * 1.25) + (presupuestos.mano_obra * 1.25) + (presupuestos.valor_material_electrico * 1.25) + (presupuestos.valor_estructura * 1.25) + (presupuestos.valor_tramites * 1.05) AS Subtotal')
            )
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->leftJoin('baterias', 'presupuestos.id_bateria', '=', 'baterias.id')
            ->leftJoin('inversors', 'presupuestos.id_inversor', '=', 'inversors.id')
            ->leftJoin('estados', 'presupuestos.id_estado', '=', 'estados.id')
            ->leftJoin('inversors AS inversors2', 'presupuestos.id_inversor_2', '=', 'inversors2.id')
            ->where('clientes.NIC', '=', $NIC);

        if ($id != 1) {
            $presupuestos->where('presupuestos.id_user', '=', $userID);  // Agrega esta línea para filtrar por el usuario actual
        }
        $results = $presupuestos->get();

        // Agregar la columna total al resultado
        $results->each(function ($item) {
            $item->total_panel = $item->numero_paneles * $item->precio;
            $item->panel_gewinn = $item->total_panel * 0.25;
            $item->panel_total =  $item->total_panel + $item->panel_gewinn;

            $item->total_bateria = $item->numero_baterias * $item->precio_batterie;
            $item->bateria_gewinn = $item->total_bateria * 0.25;
            $item->bateria_total =  $item->total_bateria + $item->bateria_gewinn;

            $item->total_inversor = $item->numero_inversores * $item->precio_investor;
            $item->inversor_gewinn = $item->total_inversor * 0.25;
            $item->inversor_total =  $item->total_inversor + $item->inversor_gewinn;

            $item->total_inversor2 = $item->numero_inversores_2 * $item->precio2_investor;
            $item->inversor_gewinn2 = $item->total_inversor2 * 0.25;
            $item->inversor_total2 =  $item->total_inversor2 + $item->inversor_gewinn2;

            $item->total_estructura =  $item->valor_estructura / $item->numero_paneles;
            $item->estructura_p =  $item->valor_estructura;
            $item->estructura_gewinn =  $item->estructura_p * 0.25;
            $item->estructura_total =  $item->estructura_p + $item->estructura_gewinn;

            $item->instalada = ($item->numero_paneles * $item->poder) / 1000;

            $item->material = $item->valor_material_electrico / $item->numero_paneles;
            $item->material_p = $item->valor_material_electrico;
            $item->material_gewinn = $item->material_p * 0.25;
            $item->material_total = $item->material_gewinn +  $item->material_p;

            $item->cable_m = $item->valor_conductor_fotovoltaico / (($item->numero_paneles * $item->poder / 1000));
            $item->cable_p = $item->valor_conductor_fotovoltaico;
            $item->cable_gewinn = $item->cable_p * 0.25;
            $item->cable_total = $item->cable_p + $item->cable_gewinn;

            $item->mano = $item->mano_obra / $item->numero_paneles;
            $item->mano_p = $item->mano_obra;
            $item->mano_gewinn = $item->mano_p * 0.25;
            $item->mano_total = $item->mano_p + $item->mano_gewinn;

            $item->tramite_gewinn = $item->valor_tramites * 0.05;
            $item->tramite_total = $item->valor_tramites +  $item->tramite_gewinn;

            $item->subtotal_p = $item->total_panel + $item->cable_p + $item->total_bateria + $item->total_inversor + $item->total_inversor2 + $item->estructura_p +  $item->material_p + $item->mano_p + $item->valor_tramites;
            $item->subtotal_gewinn = $item->panel_gewinn + $item->cable_gewinn + $item->bateria_gewinn + $item->inversor_gewinn + $item->inversor_gewinn2 + $item->estructura_gewinn + $item->material_gewinn + $item->mano_gewinn + $item->tramite_gewinn;
            $item->subtotal = $item->subtotal_p + $item->subtotal_gewinn;

            $item->comercial_poencentaje = $item->valor_gestion_comercial * 100;
            $item->comercial = $item->subtotal * $item->valor_gestion_comercial;

            $item->subtotal_2 = $item->subtotal + $item->comercial;
            $item->administracion_porcentaje = $item->valor_administracion * 100;
            $item->administracion = $item->subtotal_2 * $item->valor_administracion;
            $item->imprevisto_porcentaje = $item->valor_imprevisto * 100;
            $item->imprevisto = $item->subtotal_2 * $item->valor_imprevisto;
            $item->utilidad_porcentaje = $item->valor_utilidad * 100;
            $item->utilidad = $item->subtotal_2 * $item->valor_utilidad;
            $item->Iva = $item->utilidad * 0.19;
            $item->subtotal_3 = $item->subtotal_2 + $item->administracion + $item->imprevisto + $item->utilidad + $item->Iva;
            $item->retencion_porcentaje = $item->valor_retencion * 100;
            $item->retencion = $item->subtotal_3 *  $item->valor_retencion;
            $item->TOTAL_PROYECTO = $item->subtotal_3 + $item->retencion;

            //calculo por si hay porcentaje 
            $item->porcentaje_descuento = $item->descuento * 100;
            $item->valor_descuento = $item->descuento * $item->subtotal_2;
            $item->subtotal_2_1 = ($item->subtotal + $item->comercial) - $item->valor_descuento;
            $item->administracion_porcentaje_1 = $item->valor_administracion * 100;
            $item->administracion_1 = $item->subtotal_2_1 * $item->valor_administracion;
            $item->imprevisto_porcentaje_1 = $item->valor_imprevisto * 100;
            $item->imprevisto_1 = $item->subtotal_2_1 * $item->valor_imprevisto;
            $item->utilidad_porcentaje_1 = $item->valor_utilidad * 100;
            $item->utilidad_1 = $item->subtotal_2_1 * $item->valor_utilidad;
            $item->Iva_1 = $item->utilidad * 0.19;
            $item->subtotal_3_1 = $item->subtotal_2_1 + $item->administracion + $item->imprevisto + $item->utilidad + $item->Iva;
            $item->retencion_porcentaje_1 = $item->valor_retencion * 100;
            $item->retencion_1 = $item->subtotal_3_1 *  $item->valor_retencion;
            $item->TOTAL_PROYECTO_1 = $item->subtotal_3_1 + $item->retencion;
            // fin

            if ($item->porcentaje_descuento > 0) {
                // Calcula el total del proyecto con descuento
                $item->TOTAL_PROYECTO =  $item->subtotal_3_1 + $item->retencion;;
            } else {
                // Calcula el total del proyecto sin descuento
                $item->TOTAL_PROYECTO = $item->subtotal_3 + $item->retencion;
            }

            //  $item->tarjeta = $this->getListNameByCardName($item->nombre);
        });

        $userID = Auth::id();
        $rol_cliente = ($userID != 1);


        return view('clientes.info', compact('cliente', 'paneles', 'inversores', 'panelesNecesarios', 'potenciaDeseada', 'baterias', 'results', 'rol_cliente', 'conductor_fotovoltaico', 'radiacion', 'promedio'));
    }
}
