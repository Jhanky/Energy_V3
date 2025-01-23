<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Presupuesto;
use App\Models\Panel_solar;
use App\Models\Inversor;
use App\Models\Bateria;
use App\Models\Cable;
use Illuminate\Http\Request;

use App\Models\Grafica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CotizacionesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {
        // Obtener los paneles solares ordenados por precio
        $paneles = Panel_solar::orderBy('precio', 'asc')->get();

        // Obtener los inversores ordenados por precio
        $inversores = Inversor::orderBy('precio', 'asc')->get();

        // Obtener las baterías (excepto la primera) ordenadas por precio
        $baterias = Bateria::where('id', '<>', 1)->orderBy('precio', 'asc')->get();

        // Obtener el conductor fotovoltaico
        $conductor_fotovoltaico = Cable::first();

        // Obtener el usuario autenticado y su rol
        $user = Auth::user();
        $id = $user->id;
        $rol = $user->roles->first()->id;

        // Consulta de presupuestos con relaciones cargadas
        $presupuestos = Presupuesto::with(['cliente', 'panelSolar', 'bateria', 'inversor', 'inversor2', 'estado', 'user'])
            ->select(
                'presupuestos.*',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                'inversors.marca AS investor_marca',
                'clientes.NIC',
                'clientes.nombre',
                'users.name',
                'clientes.tipo_cliente',
                'panel_solars.marca AS solar_panel_marca',
                'presupuestos.nombre_proyecto',
                'presupuestos.codigo_propuesta',
                'presupuestos.valor_conductor_fotovoltaico',
                'presupuestos.tipo_sistema',
                'presupuestos.valor_material_electrico',
                'baterias.marca AS batterie_marca',
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
                'presupuestos.descuento',
                'presupuestos.valor_gestion_comercial',
                'presupuestos.valor_administracion',
                'presupuestos.valor_imprevisto',
                'presupuestos.valor_utilidad',
                'inversors2.marca AS investor2_marca',
                'inversors2.poder AS poder2_investor',
                'inversors2.precio AS precio2_investor',
                'presupuestos.numero_inversores_2',
                'presupuestos.valor_retencion',
                'presupuestos.created_at',
                'presupuestos.updated_at',
                'presupuestos.presupuesto_total',
                'estados.nombre as nombre_estado',
                'presupuestos.valor_sobreestructura',

                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                DB::raw('((clientes.consumo_actual * 12)/1500) AS kwp1 '),
                DB::raw('(panel_solars.precio * presupuestos.numero_paneles) AS panel_cost'),
                DB::raw('(COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) AS battery_cost'),
                DB::raw('(inversors.precio * presupuestos.numero_inversores) AS investor_cost'),
                DB::raw('((panel_solars.precio * presupuestos.numero_paneles) * 1.25) + ((COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) * 1.25) + ((inversors.precio * presupuestos.numero_inversores) * 1.25) + (presupuestos.mano_obra * 1.25) + (presupuestos.valor_material_electrico * 1.25) + (presupuestos.valor_estructura * 1.25) + (presupuestos.valor_tramites * 1.05) AS Subtotal')
            )
            ->leftJoin('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->leftJoin('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->leftJoin('baterias', 'presupuestos.id_bateria', '=', 'baterias.id')
            ->leftJoin('inversors', 'presupuestos.id_inversor', '=', 'inversors.id')
            ->leftJoin('inversors AS inversors2', 'presupuestos.id_inversor_2', '=', 'inversors2.id')
            ->leftJoin('estados', 'presupuestos.id_estado', '=', 'estados.id')
            ->leftJoin('users', 'presupuestos.id_user', '=', 'users.id')
            ->where('presupuestos.financiado', '=', 0);
        // Aplicar condición adicional si el usuario no es administrador
        if ($rol != 1) {
            $presupuestos->where('presupuestos.id_user', $id);
        }
        $presupuestos = $presupuestos->orderBy('presupuestos.id', 'desc')->get();

        foreach ($presupuestos as $presupuesto) {
            $presupuesto->total_panel = $presupuesto->numero_paneles * $presupuesto->precio;
            $presupuesto->panel_gewinn = $presupuesto->total_panel * 0.25;
            $presupuesto->panel_total =  $presupuesto->total_panel + $presupuesto->panel_gewinn;

            $presupuesto->total_bateria = $presupuesto->numero_baterias * $presupuesto->precio_batterie;
            $presupuesto->bateria_gewinn = $presupuesto->total_bateria * 0.25;
            $presupuesto->bateria_total =  $presupuesto->total_bateria + $presupuesto->bateria_gewinn;

            $presupuesto->total_inversor = $presupuesto->numero_inversores * $presupuesto->precio_investor;
            $presupuesto->inversor_gewinn = $presupuesto->total_inversor * 0.25;
            $presupuesto->inversor_total =  $presupuesto->total_inversor + $presupuesto->inversor_gewinn;

            $presupuesto->total_inversor2 = $presupuesto->numero_inversores_2 * $presupuesto->precio2_investor;
            $presupuesto->inversor_gewinn2 = $presupuesto->total_inversor2 * 0.25;
            $presupuesto->inversor_total2 =  $presupuesto->total_inversor2 + $presupuesto->inversor_gewinn2;

            $presupuesto->total_estructura =  $presupuesto->valor_estructura / $presupuesto->numero_paneles;
            $presupuesto->estructura_p =  $presupuesto->valor_estructura;
            $presupuesto->estructura_gewinn =  $presupuesto->estructura_p * 0.25;
            $presupuesto->estructura_total =  $presupuesto->estructura_p + $presupuesto->estructura_gewinn;
            $presupuesto->total_sobreestructura =  $presupuesto->valor_sobreestructura;
            $presupuesto->sugerida = ($presupuesto->numero_paneles * $presupuesto->poder) / 1000;

            $presupuesto->material = $presupuesto->valor_material_electrico / $presupuesto->numero_paneles;
            $presupuesto->material_p = $presupuesto->valor_material_electrico;
            $presupuesto->material_gewinn = $presupuesto->material_p * 0.25;
            $presupuesto->material_total = $presupuesto->material_gewinn +  $presupuesto->material_p;

            $presupuesto->cable_m = $presupuesto->valor_conductor_fotovoltaico / (($presupuesto->numero_paneles * $presupuesto->poder / 1000));
            $presupuesto->cable_p = $presupuesto->valor_conductor_fotovoltaico;
            $presupuesto->cable_gewinn = $presupuesto->cable_p * 0.25;
            $presupuesto->cable_total = $presupuesto->cable_p + $presupuesto->cable_gewinn;

            $presupuesto->mano = $presupuesto->mano_obra / $presupuesto->numero_paneles;
            $presupuesto->mano_p = $presupuesto->mano_obra;
            $presupuesto->mano_gewinn = $presupuesto->mano_p * 0.25;
            $presupuesto->mano_total = $presupuesto->mano_p + $presupuesto->mano_gewinn;

            $presupuesto->tramite_gewinn = $presupuesto->valor_tramites * 0.05;
            $presupuesto->tramite_total = $presupuesto->valor_tramites +  $presupuesto->tramite_gewinn;

            $presupuesto->subtotal_p = $presupuesto->total_panel + $presupuesto->cable_p + $presupuesto->total_bateria + $presupuesto->total_inversor + $presupuesto->total_inversor2 + $presupuesto->estructura_p +  $presupuesto->material_p + $presupuesto->mano_p + $presupuesto->valor_tramites + $presupuesto->total_sobreestructura;

            $presupuesto->subtotal_gewinn = $presupuesto->panel_gewinn + $presupuesto->cable_gewinn + $presupuesto->bateria_gewinn + $presupuesto->inversor_gewinn + $presupuesto->inversor_gewinn2 + $presupuesto->estructura_gewinn + $presupuesto->material_gewinn + $presupuesto->mano_gewinn + $presupuesto->tramite_gewinn;
            $presupuesto->subtotal = $presupuesto->subtotal_p + $presupuesto->subtotal_gewinn;

            $presupuesto->comercial_poencentaje = $presupuesto->valor_gestion_comercial * 100;
            $presupuesto->comercial = $presupuesto->subtotal * $presupuesto->valor_gestion_comercial;

            $presupuesto->subtotal_2 = $presupuesto->subtotal + $presupuesto->comercial;
            $presupuesto->administracion_porcentaje = $presupuesto->valor_administracion * 100;
            $presupuesto->administracion = $presupuesto->subtotal_2 * $presupuesto->valor_administracion;
            $presupuesto->imprevisto_porcentaje = $presupuesto->valor_imprevisto * 100;
            $presupuesto->imprevisto = $presupuesto->subtotal_2 * $presupuesto->valor_imprevisto;
            $presupuesto->utilidad_porcentaje = $presupuesto->valor_utilidad * 100;
            $presupuesto->utilidad = $presupuesto->subtotal_2 * $presupuesto->valor_utilidad;
            $presupuesto->Iva = $presupuesto->utilidad * 0.19;
            $presupuesto->subtotal_3 = $presupuesto->subtotal_2 + $presupuesto->administracion + $presupuesto->imprevisto + $presupuesto->utilidad + $presupuesto->Iva;
            $presupuesto->retencion_porcentaje = $presupuesto->valor_retencion * 100;
            $presupuesto->retencion = $presupuesto->subtotal_3 *  $presupuesto->valor_retencion;
            $presupuesto->TOTAL_PROYECTO = $presupuesto->subtotal_3 + $presupuesto->retencion;

            //calculo por si hay porcentaje 
            $presupuesto->porcentaje_descuento = $presupuesto->descuento * 100;
            $presupuesto->valor_descuento = $presupuesto->descuento * $presupuesto->subtotal_2;
            $presupuesto->subtotal_2_1 = ($presupuesto->subtotal + $presupuesto->comercial) - $presupuesto->valor_descuento;
            $presupuesto->administracion_porcentaje_1 = $presupuesto->valor_administracion * 100;
            $presupuesto->administracion_1 = $presupuesto->subtotal_2_1 * $presupuesto->valor_administracion;
            $presupuesto->imprevisto_porcentaje_1 = $presupuesto->valor_imprevisto * 100;
            $presupuesto->imprevisto_1 = $presupuesto->subtotal_2_1 * $presupuesto->valor_imprevisto;
            $presupuesto->utilidad_porcentaje_1 = $presupuesto->valor_utilidad * 100;
            $presupuesto->utilidad_1 = $presupuesto->subtotal_2_1 * $presupuesto->valor_utilidad;
            $presupuesto->Iva_1 = $presupuesto->utilidad * 0.19;
            $presupuesto->subtotal_3_1 = $presupuesto->subtotal_2_1 + $presupuesto->administracion + $presupuesto->imprevisto + $presupuesto->utilidad + $presupuesto->Iva;
            $presupuesto->retencion_porcentaje_1 = $presupuesto->valor_retencion * 100;
            $presupuesto->retencion_1 = $presupuesto->subtotal_3_1 *  $presupuesto->valor_retencion;
            $presupuesto->TOTAL_PROYECTO_1 = $presupuesto->subtotal_3_1 + $presupuesto->retencion;

            //Total proyecto
            $presupuesto->presupuesto_total;

            // fin
            if ($presupuesto->presupuesto_total !== null) {
                $presupuesto->TOTAL_PROYECTO = $presupuesto->presupuesto_total;
            } else {
                if ($presupuesto->porcentaje_descuento > 0) {
                    // Calcula el total del proyecto con descuento
                    $presupuesto->TOTAL_PROYECTO =  $presupuesto->subtotal_3_1 + $presupuesto->retencion;
                } else {
                    // Calcula el total del proyecto sin descuento
                    $presupuesto->TOTAL_PROYECTO = $presupuesto->subtotal_3 + $presupuesto->retencion;
                }
            }
        }


        // Retornar la vista con los resultados

        return view('cotizaciones.index', compact('presupuestos', 'paneles', 'inversores', 'baterias', 'conductor_fotovoltaico'));
    }

    public function listarFinaciado()
    {
        // Obtener los paneles solares ordenados por precio
        $paneles = Panel_solar::orderBy('precio', 'asc')->get();

        // Obtener los inversores ordenados por precio
        $inversores = Inversor::orderBy('precio', 'asc')->get();

        // Obtener las baterías (excepto la primera) ordenadas por precio
        $baterias = Bateria::where('id', '<>', 1)->orderBy('precio', 'asc')->get();

        // Obtener el conductor fotovoltaico
        $conductor_fotovoltaico = Cable::first();

        // Obtener el usuario autenticado y su rol
        $user = Auth::user();
        $id = $user->id;
        $rol = $user->roles->first()->id;

        // Consulta de presupuestos con relaciones cargadas
        $presupuestos = Presupuesto::with(['cliente', 'panelSolar', 'bateria', 'inversor', 'inversor2', 'estado', 'user'])
            ->select(
                'presupuestos.*',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                'inversors.marca AS investor_marca',
                'clientes.NIC',
                'clientes.nombre',
                'users.name',
                'clientes.tipo_cliente',
                'panel_solars.marca AS solar_panel_marca',
                'presupuestos.nombre_proyecto',
                'presupuestos.codigo_propuesta',
                'presupuestos.valor_conductor_fotovoltaico',
                'presupuestos.tipo_sistema',
                'presupuestos.valor_material_electrico',
                'baterias.marca AS batterie_marca',
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
                'presupuestos.descuento',
                'presupuestos.valor_gestion_comercial',
                'presupuestos.valor_administracion',
                'presupuestos.valor_imprevisto',
                'presupuestos.valor_utilidad',
                'inversors2.marca AS investor2_marca',
                'inversors2.poder AS poder2_investor',
                'inversors2.precio AS precio2_investor',
                'presupuestos.numero_inversores_2',
                'presupuestos.valor_retencion',
                'presupuestos.created_at',
                'presupuestos.updated_at',
                'presupuestos.presupuesto_total',
                'estados.nombre as nombre_estado',
                'presupuestos.valor_sobreestructura',

                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                DB::raw('((clientes.consumo_actual * 12)/1500) AS kwp1 '),
                DB::raw('(panel_solars.precio * presupuestos.numero_paneles) AS panel_cost'),
                DB::raw('(COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) AS battery_cost'),
                DB::raw('(inversors.precio * presupuestos.numero_inversores) AS investor_cost'),
                DB::raw('((panel_solars.precio * presupuestos.numero_paneles) * 1.25) + ((COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) * 1.25) + ((inversors.precio * presupuestos.numero_inversores) * 1.25) + (presupuestos.mano_obra * 1.25) + (presupuestos.valor_material_electrico * 1.25) + (presupuestos.valor_estructura * 1.25) + (presupuestos.valor_tramites * 1.05) AS Subtotal')
            )
            ->leftJoin('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->leftJoin('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->leftJoin('baterias', 'presupuestos.id_bateria', '=', 'baterias.id')
            ->leftJoin('inversors', 'presupuestos.id_inversor', '=', 'inversors.id')
            ->leftJoin('inversors AS inversors2', 'presupuestos.id_inversor_2', '=', 'inversors2.id')
            ->leftJoin('estados', 'presupuestos.id_estado', '=', 'estados.id')
            ->leftJoin('users', 'presupuestos.id_user', '=', 'users.id')
            ->where('presupuestos.financiado', '=', 1);

        // Aplicar condición adicional si el usuario no es administrador
        if ($rol != 1) {
            $presupuestos->where('presupuestos.id_user', $id);
        }
        $presupuestos = $presupuestos->orderBy('presupuestos.id', 'desc')->get();

        foreach ($presupuestos as $presupuesto) {
            $presupuesto->total_panel = $presupuesto->numero_paneles * $presupuesto->precio;
            $presupuesto->panel_gewinn = $presupuesto->total_panel * 0.25;
            $presupuesto->panel_total =  $presupuesto->total_panel + $presupuesto->panel_gewinn;

            $presupuesto->total_bateria = $presupuesto->numero_baterias * $presupuesto->precio_batterie;
            $presupuesto->bateria_gewinn = $presupuesto->total_bateria * 0.25;
            $presupuesto->bateria_total =  $presupuesto->total_bateria + $presupuesto->bateria_gewinn;

            $presupuesto->total_inversor = $presupuesto->numero_inversores * $presupuesto->precio_investor;
            $presupuesto->inversor_gewinn = $presupuesto->total_inversor * 0.25;
            $presupuesto->inversor_total =  $presupuesto->total_inversor + $presupuesto->inversor_gewinn;

            $presupuesto->total_inversor2 = $presupuesto->numero_inversores_2 * $presupuesto->precio2_investor;
            $presupuesto->inversor_gewinn2 = $presupuesto->total_inversor2 * 0.25;
            $presupuesto->inversor_total2 =  $presupuesto->total_inversor2 + $presupuesto->inversor_gewinn2;

            $presupuesto->total_estructura =  $presupuesto->valor_estructura / $presupuesto->numero_paneles;
            $presupuesto->estructura_p =  $presupuesto->valor_estructura;
            $presupuesto->estructura_gewinn =  $presupuesto->estructura_p * 0.25;
            $presupuesto->estructura_total =  $presupuesto->estructura_p + $presupuesto->estructura_gewinn;

            $presupuesto->sugerida = ($presupuesto->numero_paneles * $presupuesto->poder) / 1000;

            $presupuesto->material = $presupuesto->valor_material_electrico / $presupuesto->numero_paneles;
            $presupuesto->material_p = $presupuesto->valor_material_electrico;
            $presupuesto->material_gewinn = $presupuesto->material_p * 0.25;
            $presupuesto->material_total = $presupuesto->material_gewinn +  $presupuesto->material_p;

            $presupuesto->cable_m = $presupuesto->valor_conductor_fotovoltaico / (($presupuesto->numero_paneles * $presupuesto->poder / 1000));
            $presupuesto->cable_p = $presupuesto->valor_conductor_fotovoltaico;
            $presupuesto->cable_gewinn = $presupuesto->cable_p * 0.25;
            $presupuesto->cable_total = $presupuesto->cable_p + $presupuesto->cable_gewinn;

            $presupuesto->mano = $presupuesto->mano_obra / $presupuesto->numero_paneles;
            $presupuesto->mano_p = $presupuesto->mano_obra;
            $presupuesto->mano_gewinn = $presupuesto->mano_p * 0.25;
            $presupuesto->mano_total = $presupuesto->mano_p + $presupuesto->mano_gewinn;

            $presupuesto->tramite_gewinn = $presupuesto->valor_tramites * 0.05;
            $presupuesto->tramite_total = $presupuesto->valor_tramites +  $presupuesto->tramite_gewinn;

            $presupuesto->subtotal_p = $presupuesto->total_panel + $presupuesto->cable_p + $presupuesto->total_bateria + $presupuesto->total_inversor + $presupuesto->total_inversor2 + $presupuesto->estructura_p +  $presupuesto->material_p + $presupuesto->mano_p + $presupuesto->valor_tramites + $presupuesto->total_sobreestructura;

            $presupuesto->subtotal_gewinn = $presupuesto->panel_gewinn + $presupuesto->cable_gewinn + $presupuesto->bateria_gewinn + $presupuesto->inversor_gewinn + $presupuesto->inversor_gewinn2 + $presupuesto->estructura_gewinn + $presupuesto->material_gewinn + $presupuesto->mano_gewinn + $presupuesto->tramite_gewinn;
            $presupuesto->subtotal = $presupuesto->subtotal_p + $presupuesto->subtotal_gewinn;

            $presupuesto->comercial_poencentaje = $presupuesto->valor_gestion_comercial * 100;
            $presupuesto->comercial = $presupuesto->subtotal * $presupuesto->valor_gestion_comercial;

            $presupuesto->subtotal_2 = $presupuesto->subtotal + $presupuesto->comercial;
            $presupuesto->administracion_porcentaje = $presupuesto->valor_administracion * 100;
            $presupuesto->administracion = $presupuesto->subtotal_2 * $presupuesto->valor_administracion;
            $presupuesto->imprevisto_porcentaje = $presupuesto->valor_imprevisto * 100;
            $presupuesto->imprevisto = $presupuesto->subtotal_2 * $presupuesto->valor_imprevisto;
            $presupuesto->utilidad_porcentaje = $presupuesto->valor_utilidad * 100;
            $presupuesto->utilidad = $presupuesto->subtotal_2 * $presupuesto->valor_utilidad;
            $presupuesto->Iva = $presupuesto->utilidad * 0.19;
            $presupuesto->subtotal_3 = $presupuesto->subtotal_2 + $presupuesto->administracion + $presupuesto->imprevisto + $presupuesto->utilidad + $presupuesto->Iva;
            $presupuesto->retencion_porcentaje = $presupuesto->valor_retencion * 100;
            $presupuesto->retencion = $presupuesto->subtotal_3 *  $presupuesto->valor_retencion;
            $presupuesto->TOTAL_PROYECTO = $presupuesto->subtotal_3 + $presupuesto->retencion;

            //calculo por si hay porcentaje 
            $presupuesto->porcentaje_descuento = $presupuesto->descuento * 100;
            $presupuesto->valor_descuento = $presupuesto->descuento * $presupuesto->subtotal_2;
            $presupuesto->subtotal_2_1 = ($presupuesto->subtotal + $presupuesto->comercial) - $presupuesto->valor_descuento;
            $presupuesto->administracion_porcentaje_1 = $presupuesto->valor_administracion * 100;
            $presupuesto->administracion_1 = $presupuesto->subtotal_2_1 * $presupuesto->valor_administracion;
            $presupuesto->imprevisto_porcentaje_1 = $presupuesto->valor_imprevisto * 100;
            $presupuesto->imprevisto_1 = $presupuesto->subtotal_2_1 * $presupuesto->valor_imprevisto;
            $presupuesto->utilidad_porcentaje_1 = $presupuesto->valor_utilidad * 100;
            $presupuesto->utilidad_1 = $presupuesto->subtotal_2_1 * $presupuesto->valor_utilidad;
            $presupuesto->Iva_1 = $presupuesto->utilidad * 0.19;
            $presupuesto->subtotal_3_1 = $presupuesto->subtotal_2_1 + $presupuesto->administracion + $presupuesto->imprevisto + $presupuesto->utilidad + $presupuesto->Iva;
            $presupuesto->retencion_porcentaje_1 = $presupuesto->valor_retencion * 100;
            $presupuesto->retencion_1 = $presupuesto->subtotal_3_1 *  $presupuesto->valor_retencion;
            $presupuesto->TOTAL_PROYECTO_1 = $presupuesto->subtotal_3_1 + $presupuesto->retencion;

            //Total proyecto
            $presupuesto->presupuesto_total;

            // fin
            if ($presupuesto->presupuesto_total !== null) {
                $presupuesto->TOTAL_PROYECTO = $presupuesto->presupuesto_total;
            } else {
                if ($presupuesto->porcentaje_descuento > 0) {
                    // Calcula el total del proyecto con descuento
                    $presupuesto->TOTAL_PROYECTO =  $presupuesto->subtotal_3_1 + $presupuesto->retencion;
                } else {
                    // Calcula el total del proyecto sin descuento
                    $presupuesto->TOTAL_PROYECTO = $presupuesto->subtotal_3 + $presupuesto->retencion;
                }
            }
        }
        // Retornar la vista con los resultados

        return view('cotizaciones.financiado', compact('presupuestos', 'paneles', 'inversores', 'baterias', 'conductor_fotovoltaico'));
    }

    public function crear(Request $request)
    {
        //DD($request);
        // Valores predeterminados
        $default_values = [
            'id_bateria' => 1,
            'numero_baterias' => 0,
            'financiado' => 0,
            'valor_sobreestructura' => 0,

            'valor_tramites' => 7000000,
            'mano_obra' => 200000,
            'valor_estructura' => 105000,
            'valor_material_electrico' => 180000,
            'valor_gestion_comercial' => 2,
            'valor_administracion' => 8,
            'valor_imprevisto' => 2,
            'valor_utilidad' => 5,
            'valor_retencion' => 3.5,
        ];

        // Obtener los datos del formulario excepto el token
        $input_values = $request->except('_token');

        // Si el valor "financiado" está presente en el formulario, ajusta el valor en $input_values
        if ($request->has('financiado')) {
            $input_values['financiado'] = 1; // Ajusta el valor en $input_values
        } else {
            $input_values['financiado'] = 0; // Usa el valor por defecto si no está presente
        }

        // Recorre los valores predeterminados para asegurarse de que se usen si no están en $input_values
        foreach ($default_values as $key => $value) {
            if (!isset($input_values[$key])) {
                $input_values[$key] = $value;
            }
        }

        // Limpiar el precio eliminando los caracteres no numéricos
        if (isset($input_values['valor_sobreestructura'])) {
            $input_values['valor_sobreestructura'] = preg_replace('/\D/', '', $input_values['valor_sobreestructura']);
        }

        if (isset($input_values['valor_material_electrico'])) {
            $input_values['valor_material_electrico'] = preg_replace('/\D/', '', $input_values['valor_material_electrico']);
        }
        if (isset($input_values['mano_obra'])) {
            $input_values['mano_obra'] = preg_replace('/\D/', '', $input_values['mano_obra']);
        }
        if (isset($input_values['valor_estructura'])) {
            $input_values['valor_estructura'] = preg_replace('/\D/', '', $input_values['valor_estructura']);
        }
        if (isset($input_values['valor_tramites'])) {
            $input_values['valor_tramites'] = preg_replace('/\D/', '', $input_values['valor_tramites']);
        }
        // Realizar la operación matemática con "valor_material_electrico", "mano_obra" y "valor_estructura"
        if (isset($input_values['valor_material_electrico'])) {
            $input_values['valor_material_electrico'] = $input_values['valor_material_electrico'] * $input_values['numero_paneles'];
        }
        if (isset($input_values['mano_obra'])) {
            $input_values['mano_obra'] = $input_values['mano_obra'] * $input_values['numero_paneles'];
        }
        if (isset($input_values['valor_estructura'])) {
            $input_values['valor_estructura'] = $input_values['valor_estructura'] * $input_values['numero_paneles'];
        }

        $data = DB::select("SELECT precio FROM cables LIMIT 1;");
        $primerResultado = $data[0];
        $valor_metro = $primerResultado->precio;

        // Verificar si 'valor_conductor_fotovoltaico' está presente en $input_values
        if (isset($input_values['valor_conductor_fotovoltaico'])) {
            // Multiplicar por el precio del metro de cable
            $input_values['valor_conductor_fotovoltaico'] *= $valor_metro;
        }

        $year = Carbon::now()->year;

        $ultimo_id = DB::select('SELECT id FROM presupuestos ORDER BY id DESC LIMIT 1;');

        if (!empty($ultimo_id)) {
            $primerResultado = $ultimo_id[0];
            $ultimoId = $primerResultado->id + 1;
        } else {
            // Si la consulta no devuelve resultados, asignar un valor inicial a $ultimoId
            $ultimoId = 1; // O cualquier otro valor predeterminado
        }

        // Inicializar la variable $version
        $version = 0;

        if (isset($input_values['id_cliente'])) {
            $valor_idCliente = $input_values['id_cliente'];
            $versiones = DB::select("SELECT COUNT(id_cliente) AS version FROM presupuestos WHERE id_cliente = '$valor_idCliente' GROUP BY id_cliente;");

            // Verificamos si se encontraron resultados
            if (!empty($versiones)) {
                // Accedemos al valor de 'version' en el primer resultado
                $version = $versiones[0]->version;
                // Ahora $version contiene el número de versiones para el cliente dado
            } else {
                // No se encontraron versiones para el cliente dado
                $version = 0;
            }
        }

        // Formatear el número de propuesta (sumando 1)
        $numero_propuesta = sprintf('%03d', $ultimoId);

        // Formatear la versión
        $version_formato = $version > 0 ? '-v' . ($version + 1) : '';

        // Construir la cadena final
        $cadena_final = $numero_propuesta . '-' . $year . $version_formato;
        $input_values['codigo_propuesta'] = $cadena_final;

        // Lista de campos que deben dividirse por 100
        $camposDividirPor100 = ['valor_gestion_comercial', 'valor_administracion', 'valor_imprevisto', 'valor_utilidad', 'valor_retencion'];

        // Iterar sobre los campos y dividir por 100
        foreach ($camposDividirPor100 as $campo) {
            if (isset($input_values[$campo])) {
                $input_values[$campo] = $input_values[$campo] / 100;
            }
        }

        // Insertar los datos en la tabla
        Presupuesto::insert($input_values);

        return redirect('/cotizaciones')->with('rgcmessage', 'Cotización realizada con éxito!');
    }

    public function descuento(Request $request, $id)
    {
        // Obtener todos los datos del request excepto los tokens de seguridad
        $valor_presupuesto = $request->except(['_token', '_method']);

        if (isset($valor_presupuesto['presupuesto_total'])) {
            $valor_presupuesto['presupuesto_total'] = preg_replace('/\D/', '', $valor_presupuesto['presupuesto_total']);
        }
        // Verificar si el valor de 'presupuesto_total' es 'NaN' y eliminarlo del array
        if (isset($valor_presupuesto['presupuesto_total']) && $valor_presupuesto['presupuesto_total'] === 'NaN') {
            unset($valor_presupuesto['presupuesto_total']);
        }
        // Actualizar el presupuesto en la base de datos
        Presupuesto::where('id', '=', $id)->update($valor_presupuesto);

        // Redirigir a la página de presupuestos con un mensaje de éxito
        return redirect('/cotizaciones')->with('rgcmessage', 'Valor aplicado correctamente');
    }

    public function info($id)
    {
        $paneles = DB::table('panel_solars')->select('id', 'marca', 'poder', 'precio')->orderBy('precio', 'asc')->get();
        $inversores = DB::table('inversors')->select('id', 'marca', 'tipo', 'tipo_red', 'poder', 'precio')->orderBy('precio', 'asc')->get();
        $baterias = DB::table('baterias')->select('id', 'marca', 'tipo', 'voltaje', 'amperios_hora', 'precio')->where('id', '<>', 1)->orderBy('precio', 'asc')->get();
        $precio_cable = DB::select("SELECT precio FROM cables LIMIT 1;");
        $primerResultado  = $precio_cable[0];
        $valor_cable = $primerResultado->precio;
        // consultar los datos ne la base de datos
        $cliente = DB::table('presupuestos')
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->where('presupuestos.id', $id)
            ->select('clientes.*')
            ->get();

        $primerResultado1  = $cliente[0];
        $ciudad = $primerResultado1->ciudad;

        $radiacionData = DB::select("SELECT radiacion FROM `localidad` WHERE municipio = '$ciudad';");
        $primerResultado2  = $radiacionData[0];
        $radiacion = $primerResultado2->radiacion;

        $potencia = DB::select("SELECT clientes.consumo_actual
            FROM presupuestos
            JOIN clientes ON presupuestos.id_cliente = clientes.NIC
            WHERE presupuestos.id = '$id'");

        $consumoActual = $potencia[0]->consumo_actual;

        // Potencia a instalar en kW
        $promedio = ($consumoActual * 12) / 1500;

        $presupuestos = DB::table('presupuestos')
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->leftJoin('baterias', 'presupuestos.id_bateria', '=', 'baterias.id')
            ->leftJoin('inversors', 'presupuestos.id_inversor', '=', 'inversors.id')
            ->leftJoin('inversors AS inversors2', 'presupuestos.id_inversor_2', '=', 'inversors2.id')
            ->where('presupuestos.id', $id) // Agregar condición para filtrar por NIC
            ->select(
                'presupuestos.id',
                'clientes.NIC',
                'clientes.nombre',
                'clientes.tipo_cliente',
                'panel_solars.marca AS solar_panel_marca',
                'presupuestos.tipo_sistema',
                'presupuestos.valor_material_electrico',
                'presupuestos.mano_obra',
                'presupuestos.nombre_proyecto',
                'presupuestos.valor_estructura',
                'presupuestos.valor_tramites',
                'presupuestos.valor_conductor_fotovoltaico',
                'inversors.marca AS investor_marca',
                'inversors2.marca AS investor2_marca',
                'panel_solars.poder',
                'inversors.poder AS poder_investor',
                'inversors2.poder AS poder2_investor',
                'baterias.id as id_bateria',
                'baterias.marca AS batterie_marca',
                'baterias.amperios_hora',
                'baterias.precio As precio_batterie',
                'panel_solars.precio',
                'inversors.precio AS precio_investor',
                'inversors2.precio AS precio2_investor',
                'presupuestos.numero_paneles',
                'presupuestos.numero_baterias',
                'presupuestos.numero_inversores',
                'presupuestos.numero_inversores_2',
                'presupuestos.descuento',
                'presupuestos.valor_gestion_comercial',
                'presupuestos.valor_administracion',
                'presupuestos.valor_imprevisto',
                'presupuestos.valor_utilidad',
                'presupuestos.valor_retencion',
                'presupuestos.presupuesto_total',
                'presupuestos.valor_sobreestructura',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                DB::raw('((clientes.consumo_actual * 12)/1500) AS kwp1 '),
                DB::raw('(panel_solars.precio * presupuestos.numero_paneles) AS panel_cost'),
                DB::raw('(COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) AS battery_cost'),
                DB::raw('(inversors.precio * presupuestos.numero_inversores) AS investor_cost'),
                DB::raw('((panel_solars.precio * presupuestos.numero_paneles) * 1.25) + ((COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) * 1.25) + ((inversors.precio * presupuestos.numero_inversores) * 1.25) + (presupuestos.mano_obra * 1.25) + (presupuestos.valor_material_electrico * 1.25) + (presupuestos.valor_estructura * 1.25) + (presupuestos.valor_tramites * 1.05) AS Subtotal')
            );

        $results = $presupuestos->get();

        // Calcular las columnas "total" y "presupuesto" solo para los resultados que cumplen la condición
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

            $item->total_sobreestructura =  $item->valor_sobreestructura;

            $item->instalada = ($item->numero_paneles * $item->poder) / 1000;

            $item->material = $item->valor_material_electrico / $item->numero_paneles;
            $item->material_p = $item->valor_material_electrico;
            $item->material_gewinn = $item->material_p * 0.25;
            $item->material_total = $item->material_gewinn +  $item->material_p;

            $item->cable_m = $item->valor_conductor_fotovoltaico / (($item->numero_paneles * $item->poder / 1000));
            $item->cable_p = round($item->valor_conductor_fotovoltaico);
            $item->cable_gewinn = $item->cable_p * 0.25;
            $item->cable_total = $item->cable_p + $item->cable_gewinn;

            $item->mano = $item->mano_obra / $item->numero_paneles;
            $item->mano_p = $item->mano_obra;
            $item->mano_gewinn = $item->mano_p * 0.25;
            $item->mano_total = $item->mano_p + $item->mano_gewinn;

            $item->tramite_gewinn = $item->valor_tramites * 0.05;
            $item->tramite_total = $item->valor_tramites +  $item->tramite_gewinn;

            $item->subtotal_p = $item->total_panel + $item->cable_p + $item->total_bateria + $item->total_inversor + $item->total_inversor2 + $item->estructura_p +  $item->material_p + $item->mano_p + $item->valor_tramites + $item->total_sobreestructura;

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
            $item->TOTAL_PROYECTO_cotizado = $item->subtotal_3 + $item->retencion;

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
            //Total proyecto
            $item->presupuesto_total;

            // fin
            if ($item->presupuesto_total !== null) {
                $item->TOTAL_PROYECTO = $item->presupuesto_total;
            } else {
                if ($item->porcentaje_descuento > 0) {
                    // Calcula el total del proyecto con descuento
                    $item->TOTAL_PROYECTO =  $item->subtotal_3_1 + $item->retencion;
                } else {
                    // Calcula el total del proyecto sin descuento
                    $item->TOTAL_PROYECTO = $item->subtotal_3 + $item->retencion;
                }
            }
        });

        $ahorro_anuales = $this->energia_anual($id);
        $degradacion_anual = $this->energia_anual($id);
        $energia_anual = $this->energia_anual($id);
        $primer_resultado = !empty($energia_anual) ? $energia_anual[0] : null;
        $energia = $primer_resultado['energia_anual'];
        $generacion_mensuales = $this->genracion_mensual($energia);
        $retorno_invercion = $this->retorno_inver($ahorro_anuales, $id);

        $ahorro = [];
        foreach ($ahorro_anuales as $ahorro_anual) {
            $ahorro[] = ['name' => $ahorro_anual['year'], 'y' => floatval($ahorro_anual['ahorro_anual'])];
        }
        $data = json_encode($ahorro);

        $degrada = [];
        foreach ($degradacion_anual as $degradacion) {
            $degrada[] = ['name' => $degradacion['year'], 'y' => floatval($degradacion['energia_anual'])];
        }
        $data2 = json_encode($degrada);

        $mensual = [];
        foreach ($generacion_mensuales as $generacion_mensual) {
            $mensual[] = ['name' => $generacion_mensual['mes'], 'y' => floatval($generacion_mensual['resultado'])];
        }
        $data3 = json_encode($mensual);

        $retorno = [];
        foreach ($retorno_invercion as $rinvercion) {
            $retorno[] = ['name' => $rinvercion['year'], 'y' => floatval($rinvercion['saldo_retorno'])];
        }
        $data4 = json_encode($retorno);

        //DD($results);
        // Retornamos las variables a la vista
        return view('cotizaciones.info', compact('cliente', 'promedio', 'results', 'data', 'data2', 'data3', 'data4', 'valor_cable', 'paneles', 'inversores', 'baterias', 'radiacion'));
    }

    public function eliminar($id)
    {
        // Eliminar registros relacionados en la tabla 'graficas', solo borra las rutas
        Grafica::where('id_presupuesto', $id)->delete();


        // Eliminar el presupuesto
        Presupuesto::where('id', $id)->delete();

        return redirect('/presupuestos')->with('msjdelete', 'Borrada correctamente!...');
    }

    public function grafica(Request $request, $id)
    {
        // Validar el formulario
        $request->validate([
            'imagenes.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener las imágenes del formulario
        $imagenes = $request->file('imagenes');

        // Iterar sobre cada imagen
        foreach ($imagenes as $index => $imagen) {
            // Generar un nombre único para la imagen
            $nombreImagen = time() . '_' . $index . '_' . $imagen->getClientOriginalName();

            // Mover la imagen a la carpeta public/img/graficos
            $imagen->move(public_path('img/graficos'), $nombreImagen);

            // Crear una nueva instancia de Grafica
            $grafica = new Grafica();

            $grafica->id_presupuesto = $id;
            $grafica->nombre = 'Imagen ' . ($index + 1); // Puedes personalizar el nombre según tus necesidades
            $grafica->ruta_imagen = 'img/graficos/' . $nombreImagen;
            $grafica->save();
        }

        // Si no hay imagen 5, asignar la imagen por defecto
        $imagen5 = $imagenes[4] ?? null; // Suponiendo que Imagen 5 es el quinto archivo en la carga
        if (!$imagen5) {
            $grafica5 = new Grafica();
            $grafica5->id_presupuesto = $id;
            $grafica5->nombre = 'Imagen 5';
            $grafica5->ruta_imagen = 'img/defecto/plantaSolar.png'; // Ruta de la imagen por defecto
            $grafica5->save();
        }

        // Redireccionar o hacer cualquier otra acción que desees
        return redirect('/cotizaciones')->with('rgcmessage', 'Imágenes subidas y registradas en la base de datos exitosamente.');

    }

    public function editar($id)
    {
        $datos = request()->except(['_token', '_method']);
        Presupuesto::where('id', '=', $id)->update($datos);
        Session::flash('msjupdate', '¡La cotización se a actualizado correctamente!...');
        return redirect('/presuouestos');
    }

    //Paras las graficas de Costo de la energia anualmente y degradacion de la energia
    public function energia_anual($id)
    {
        $yearsData = [];

        ///---------------------------------------------------
        $variable = DB::select("SELECT clientes.tarifa FROM presupuestos JOIN clientes ON presupuestos.id_cliente = clientes.NIC WHERE presupuestos.id = '$id'");
        $primerResultado  = $variable[0];
        $tarifa = $primerResultado->tarifa;

        $variable2 = DB::select("SELECT panel_solars.poder * presupuestos.numero_paneles AS potencia_w FROM panel_solars INNER JOIN presupuestos ON panel_solars.id = presupuestos.id_panel WHERE presupuestos.id = '$id'");
        $primerResultado2  = $variable2[0];
        $potencia = $primerResultado2->potencia_w / 1000;
        ///---------------------------------------------------

        $datos_ubic = DB::select("SELECT clientes.departamento, clientes.ciudad FROM presupuestos JOIN clientes ON presupuestos.id_cliente = clientes.NIC WHERE presupuestos.id = '$id'");
        $primerResultado  = $datos_ubic[0];
        $depa = $primerResultado->departamento;
        $segundoResultado  = $datos_ubic[0];
        $ciu = $segundoResultado->ciudad;

        $dato_radiacion = DB::table('localidad')->select('radiacion')->where('departamento', $depa)->where('municipio', $ciu)->first();

        if ($dato_radiacion) {
            $valor_radiacion = $dato_radiacion->radiacion;
        } else {
            $valor_radiacion = null; // o cualquier otro valor predeterminado
        }
        $currentEnergy = round($potencia * $valor_radiacion, 2);
        $ahorroAnual = round($currentEnergy * $tarifa, 2);
        for ($i = 1; $i <= 25; $i++) {
            // Redondear $currentEnergy y $ahorroAnual a dos decimales
            $currentEnergy = round($currentEnergy, 2);
            $ahorroAnual = round($ahorroAnual, 2);

            if ($i > 1) {
                $ahorroAnual = $ahorroAnual * (1 + 0.1);
            } else {
                $ahorroAnual;
            }

            if ($i >= 3) {
                $currentEnergy = $currentEnergy * (1 - 0.005);
            } elseif ($i >= 2) {
                $currentEnergy = $currentEnergy * (1 - 0.02);
            } else {
                $currentEnergy;
            }

            $yearsData[] = [
                'id_presupuesto' => $id,
                'year' => $i,
                'energia_anual' => $currentEnergy,
                'ahorro_anual' => $ahorroAnual,
            ];
        }
        //DD($yearsData);
        return $yearsData;
    }

    //Para la grafica de generacion promedio mensual
    public function genracion_mensual($energia)
    {
        $meses = [
            'ENERO' => 10.10,
            'FEBRERO' => 9.52,
            'MARZO' => 9.91,
            'ABRIL' => 8.38,
            'MAYO' => 7.72,
            'JUNIO' => 7.51,
            'JULIO' => 8.22,
            'AGOSTO' => 7.85,
            'SEPTIEMBRE' => 7.37,
            'OCTUBRE' => 7.10,
            'NOVIEMBRE' => 7.29,
            'DICIEMBRE' => 9.04,
        ];

        $resultados = [];

        foreach ($meses as $mes => $porcentaje) {
            $resultado = $energia * ($porcentaje / 100);

            $resultados[] = [
                'mes' => $mes,
                'porcentaje' => $porcentaje,
                'resultado' => $resultado,
            ];
        }
        return $resultados;
    }

    //Para la grafica de retorno de la invercion
    public function retorno_inver($ahorro_anuales, $id)
    {
        $presupuestos = DB::table('presupuestos')
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->leftJoin('baterias', 'presupuestos.id_bateria', '=', 'baterias.id')
            ->leftJoin('inversors', 'presupuestos.id_inversor', '=', 'inversors.id')
            ->leftJoin('inversors AS inversors2', 'presupuestos.id_inversor_2', '=', 'inversors2.id')
            ->where('presupuestos.id', $id) // Agregar condición para filtrar por NIC
            ->select(
                'presupuestos.valor_material_electrico',
                'presupuestos.mano_obra',
                'presupuestos.valor_estructura',
                'presupuestos.valor_tramites',
                'inversors.poder AS poder_investor',
                'presupuestos.valor_conductor_fotovoltaico',
                'baterias.amperios_hora',
                'panel_solars.precio',
                'panel_solars.poder',
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
                'presupuestos.descuento',
                'inversors2.marca AS investor2_marca',
                'inversors2.poder AS poder2_investor',
                'inversors2.precio AS precio2_investor',
                'presupuestos.numero_inversores_2',
                'presupuestos.presupuesto_total',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                DB::raw('((clientes.consumo_actual * 12)/1500) AS kwp1 '),
                DB::raw('(panel_solars.precio * presupuestos.numero_paneles) AS panel_cost'),
                DB::raw('(COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) AS battery_cost'),
                DB::raw('(inversors.precio * presupuestos.numero_inversores) AS investor_cost'),
                DB::raw('((panel_solars.precio * presupuestos.numero_paneles) * 1.25) + ((COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) * 1.25) + ((inversors.precio * presupuestos.numero_inversores) * 1.25) + (presupuestos.mano_obra * 1.25) + (presupuestos.valor_material_electrico * 1.25) + (presupuestos.valor_estructura * 1.25) + (presupuestos.valor_tramites * 1.05) AS Subtotal')
            );

        $results = $presupuestos->get();

        // Calcular las columnas "total" y "presupuesto" solo para los resultados que cumplen la condición
        $results->each(function ($item) {
            $item->total_panel = $item->numero_paneles * $item->precio;
            $item->panel_gewinn = ($item->numero_paneles * $item->precio) * 0.25;
            $item->panel_total =  $item->total_panel + $item->panel_gewinn;
            $item->total_bateria = $item->numero_baterias * $item->precio_batterie;
            $item->bateria_gewinn = ($item->numero_baterias * $item->precio_batterie) * 0.25;
            $item->bateria_total =  $item->total_bateria + $item->bateria_gewinn;
            $item->total_inversor = $item->numero_inversores * $item->precio_investor;
            $item->inversor_gewinn = ($item->numero_inversores * $item->precio_investor) * 0.25;
            $item->inversor_total =  $item->total_inversor + $item->inversor_gewinn;
            $item->total_inversor2 = $item->numero_inversores_2 * $item->precio2_investor;
            $item->inversor_gewinn2 = $item->total_inversor2 * 0.25;
            $item->inversor_total2 =  $item->total_inversor2 + $item->inversor_gewinn2;
            $item->total_estructura =  $item->valor_estructura / $item->numero_paneles;
            $item->estructura_p =  $item->valor_estructura;
            $item->estructura_gewinn =  $item->valor_estructura * 0.25;
            $item->estructura_total =  $item->estructura_p + $item->estructura_gewinn;
            $item->material = $item->valor_material_electrico / $item->numero_paneles;
            $item->material_p = $item->valor_material_electrico;
            $item->material_gewinn = $item->valor_material_electrico * 0.25;
            $item->material_total = $item->material_gewinn +  $item->material_p;
            $item->mano = $item->mano_obra / $item->numero_paneles;
            $item->mano_p = $item->mano_obra;
            $item->mano_gewinn = $item->mano_p * 0.25;
            $item->mano_total = $item->mano_p + $item->mano_gewinn;
            $item->cable_m = $item->valor_conductor_fotovoltaico / (($item->numero_paneles * $item->poder / 1000));
            $item->cable_p = round($item->valor_conductor_fotovoltaico);
            $item->cable_gewinn = $item->cable_p * 0.25;
            $item->cable_total = $item->cable_p + $item->cable_gewinn;
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
            $item->TOTAL_PROYECTO_1 = round($item->subtotal_3_1 + $item->retencion);
            // fin

            if ($item->presupuesto_total !== null) {
                $item->TOTAL_PROYECTO = $item->presupuesto_total;
            } else {
                if ($item->porcentaje_descuento > 0) {
                    // Calcula el total del proyecto con descuento
                    $item->TOTAL_PROYECTO =  $item->subtotal_3_1 + $item->retencion;
                } else {
                    // Calcula el total del proyecto sin descuento
                    $item->TOTAL_PROYECTO = $item->subtotal_3 + $item->retencion;
                }
            }
        });


        $valorDescuento = DB::select("SELECT descuento FROM presupuestos WHERE id ='$id'");
        $primerResultado = $valorDescuento[0];
        $descuento = $primerResultado->descuento;

        // Calcula el presupuesto total y redondea el resultado
        $presupuesto = round($results->sum('TOTAL_PROYECTO'));

        // Calcula el saldoRetorno dependiendo del descuento
        if ($descuento > 0) {
            $saldoRetorno = round($results->sum('TOTAL_PROYECTO_1') * -1);
        } else {
            $saldoRetorno = round($presupuesto * -1);
        }

        //$saldoRetorno = -48500000;

        $Data = [];
        $i = 1;
        $contador = 0; // Inicializar contador

        while ($contador < 5) {
            // Obtener el valor del año correspondiente
            $primerResultado = $ahorro_anuales[$i - 1] ?? null; // Manejar caso donde no hay resultados

            // Verificar si hay resultados
            if (!$primerResultado) {
                break; // Salir del bucle si no hay más datos de ahorro
            }

            // Modificar la línea para asignar el valor adecuado
            if ($saldoRetorno > 0) {
                $valor = $primerResultado['ahorro_anual'];
            } else {
                $valor = $saldoRetorno + $primerResultado['ahorro_anual'];
            }

            $Data[] = [
                'year' => $i,
                'saldo_retorno' => $valor,
            ];

            $saldoRetorno = $valor; // Actualizar el saldo para el próximo bucle
            $contador++;
            $i++;
        }
        return $Data;
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'id_estado' => 'required|numeric', // Ajusta la validación según el tipo de dato de tu columna
        ]);

        $nuevoEstado = $request->id_estado;

        $presupuesto = Presupuesto::find($id); // Ajusta el modelo según el nombre de tu tabla
        $presupuesto->id_estado = $nuevoEstado;
        $valor_final = $this->calcularPresupuesto($id);

        // Verificar si el nuevo estado es CONTRATADO (valor 7)
        if ($nuevoEstado == 7) {
            $presupuesto->presupuesto_total = $valor_final; // Asignar el nuevo valor de presupuesto_total
        }

        $presupuesto->save();

        return response()->json(['mensaje' => 'Estado actualizado correctamente'], 200);
    }

    public function calcularPresupuesto($id)
    {
        $paneles = DB::table('panel_solars')->select('id', 'marca', 'poder', 'precio')->orderBy('precio', 'asc')->get();
        $inversores = DB::table('inversors')->select('id', 'marca', 'tipo', 'tipo_red', 'poder', 'precio')->orderBy('precio', 'asc')->get();
        $baterias = DB::table('baterias')->select('id', 'marca', 'tipo', 'voltaje', 'amperios_hora', 'precio')->where('id', '<>', 1)->orderBy('precio', 'asc')->get();
        $precio_cable = DB::select("SELECT precio FROM cables LIMIT 1;");
        $primerResultado  = $precio_cable[0];
        $valor_cable = $primerResultado->precio;
        // consultar los datos ne la base de datos
        $cliente = DB::table('presupuestos')
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->where('presupuestos.id', $id)
            ->select('clientes.*')
            ->get();

        $primerResultado1  = $cliente[0];
        $ciudad = $primerResultado1->ciudad;

        $radiacionData = DB::select("SELECT radiacion FROM `localidad` WHERE municipio = '$ciudad';");
        $primerResultado2  = $radiacionData[0];
        $radiacion = $primerResultado2->radiacion;

        $potencia = DB::select("SELECT clientes.consumo_actual
            FROM presupuestos
            JOIN clientes ON presupuestos.id_cliente = clientes.NIC
            WHERE presupuestos.id = '$id'");

        $consumoActual = $potencia[0]->consumo_actual;

        // Potencia a instalar en kW
        $promedio = ($consumoActual * 12) / 1500;

        $presupuestos = DB::table('presupuestos')
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->leftJoin('baterias', 'presupuestos.id_bateria', '=', 'baterias.id')
            ->leftJoin('inversors', 'presupuestos.id_inversor', '=', 'inversors.id')
            ->leftJoin('inversors AS inversors2', 'presupuestos.id_inversor_2', '=', 'inversors2.id')
            ->where('presupuestos.id', $id) // Agregar condición para filtrar por NIC
            ->select(
                'presupuestos.id',
                'clientes.NIC',
                'clientes.nombre',
                'clientes.tipo_cliente',
                'panel_solars.marca AS solar_panel_marca',
                'presupuestos.tipo_sistema',
                'presupuestos.valor_material_electrico',
                'baterias.marca AS batterie_marca',
                'presupuestos.mano_obra',
                'presupuestos.nombre_proyecto',
                'presupuestos.valor_estructura',
                'presupuestos.valor_tramites',
                'presupuestos.valor_conductor_fotovoltaico',
                'inversors.marca AS investor_marca',
                'inversors2.marca AS investor2_marca',
                'panel_solars.poder',
                'inversors.poder AS poder_investor',
                'inversors2.poder AS poder2_investor',
                'baterias.amperios_hora',
                'panel_solars.precio',
                'baterias.amperios_hora',
                'baterias.precio As precio_batterie',
                'inversors.precio AS precio_investor',
                'inversors2.precio AS precio2_investor',
                'presupuestos.numero_paneles',
                'presupuestos.numero_baterias',
                'presupuestos.numero_inversores',
                'presupuestos.numero_inversores_2',
                'presupuestos.descuento',
                'presupuestos.valor_gestion_comercial',
                'presupuestos.valor_administracion',
                'presupuestos.valor_imprevisto',
                'presupuestos.valor_utilidad',
                'presupuestos.valor_retencion',
                'presupuestos.presupuesto_total',
                DB::raw('COALESCE(baterias.precio, 0) AS battery_precio'),
                DB::raw('((clientes.consumo_actual * 12)/1500) AS kwp1 '),
                DB::raw('(panel_solars.precio * presupuestos.numero_paneles) AS panel_cost'),
                DB::raw('(COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) AS battery_cost'),
                DB::raw('(inversors.precio * presupuestos.numero_inversores) AS investor_cost'),
                DB::raw('((panel_solars.precio * presupuestos.numero_paneles) * 1.25) + ((COALESCE(baterias.precio, 0) * COALESCE(presupuestos.numero_baterias, 0)) * 1.25) + ((inversors.precio * presupuestos.numero_inversores) * 1.25) + (presupuestos.mano_obra * 1.25) + (presupuestos.valor_material_electrico * 1.25) + (presupuestos.valor_estructura * 1.25) + (presupuestos.valor_tramites * 1.05) AS Subtotal')
            );

        $results = $presupuestos->get();

        // Calcular las columnas "total" y "presupuesto" solo para los resultados que cumplen la condición
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
            $item->cable_p = round($item->valor_conductor_fotovoltaico);
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
            $item->TOTAL_PROYECTO_cotizado = $item->subtotal_3 + $item->retencion;

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
            //Total proyecto
            $item->presupuesto_total;

            // fin
            if ($item->presupuesto_total !== null) {
                $item->TOTAL_PROYECTO = $item->presupuesto_total;
            } else {
                if ($item->porcentaje_descuento > 0) {
                    // Calcula el total del proyecto con descuento
                    $item->TOTAL_PROYECTO =  $item->subtotal_3_1 + $item->retencion;
                } else {
                    // Calcula el total del proyecto sin descuento
                    $item->TOTAL_PROYECTO = $item->subtotal_3 + $item->retencion;
                }
            }
        });

        $total_proyectos = intval($results->sum('TOTAL_PROYECTO'));

        // Retornamos las variables a la vista
        return $total_proyectos;
    }
}
