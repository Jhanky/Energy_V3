<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userID = Auth::id();
        $rol = DB::select("SELECT role_id FROM `model_has_roles` WHERE model_id = ?", [$userID]);
        $primerResultado = $rol[0];
        $id = $primerResultado->role_id;


        if ($id == 3) {
            $clientes = DB::table('clientes')->where('id_user', $userID)->count();
        } else {
            $clientes = DB::table('clientes')->count();
        }

        if ($id == 3) {
            $presupuestos = DB::table('presupuestos')->where('id_user', $userID)->count();
        } else {
            $presupuestos = DB::table('presupuestos')->count();
        }

        $comerciales = DB::table('model_has_roles')->where('role_id', 3)->count();

        $resultado = DB::table('presupuestos')
            ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
            ->where('presupuestos.id_estado', 7)
            ->selectRaw('SUM(presupuestos.numero_paneles * panel_solars.poder) as total')
            ->first();

        $totalkW = $resultado->total / 1000;

        if ($id == 3) {
            $monthlyData = DB::table('presupuestos')
                ->select(DB::raw('MONTHNAME(created_at) as mes, COUNT(*) as total'))
                ->whereYear('created_at', date('Y')) // Filtrar por el año actual
                ->where('id_user', $userID)
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                ->get()
                ->map(function ($item) {
                    $item->total = (int) $item->total; // Convertir a número
                    return $item;
                });
        } else {
            // Obtener datos mensuales
            $monthlyData = DB::table('presupuestos')
                ->select(DB::raw('MONTHNAME(created_at) as mes, COUNT(*) as total'))
                ->whereYear('created_at', date('Y')) // Filtrar por el año actual
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                ->get()
                ->map(function ($item) {
                    $item->total = (int) $item->total; // Convertir a número
                    return $item;
                });
        }

        // Traducir los nombres de los meses a español
        $monthlyData = $monthlyData->map(function ($item) {
            $item->mes = $this->translateMonth($item->mes);
            return $item;
        });

        // Obtener datos semanales
        if ($id == 3) {
            $weeklyData1 = DB::table('presupuestos')
                ->select(DB::raw('MONTHNAME(created_at) as mes, WEEK(created_at) as semana, COUNT(*) as total'))
                ->whereYear('created_at', date('Y')) // Filtrar por el año actual
                ->where('id_user', $userID)
                ->groupBy(DB::raw('MONTHNAME(created_at)'), DB::raw('WEEK(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                ->orderBy(DB::raw('WEEK(created_at)'), 'asc')
                ->get()
                ->map(function ($item) {
                    $item->total = (int) $item->total; // Convertir a número
                    return $item;
                })
                ->groupBy('mes');
        } else {
            $weeklyData1 = DB::table('presupuestos')
                ->select(DB::raw('MONTHNAME(created_at) as mes, WEEK(created_at) as semana, COUNT(*) as total'))
                ->whereYear('created_at', date('Y')) // Filtrar por el año actual
                ->groupBy(DB::raw('MONTHNAME(created_at)'), DB::raw('WEEK(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'), 'asc')
                ->orderBy(DB::raw('WEEK(created_at)'), 'asc')
                ->get()
                ->map(function ($item) {
                    $item->total = (int) $item->total; // Convertir a número
                    return $item;
                })
                ->groupBy('mes');
        }

        // Traducir los nombres de los meses en los datos semanales
        $weeklyData1 = $weeklyData1->mapWithKeys(function ($value, $key) {
            return [$this->translateMonth($key) => $value];
        });

        if ($id == 3) {
            $tiposClientes = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->select(DB::raw('clientes.tipo_cliente as tipo, (SUM(presupuestos.numero_paneles * panel_solars.poder)/1000) as total_kW'))
                ->where('presupuestos.id_user', $userID)
                ->groupBy('clientes.tipo_cliente')
                ->get();
        } else {
            $tiposClientes = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->select(DB::raw('clientes.tipo_cliente as tipo, (SUM(presupuestos.numero_paneles * panel_solars.poder)/1000) as total_kW'))
                ->groupBy('clientes.tipo_cliente')
                ->get();
        }


        if ($id == 3) {
            $tipoResidencial = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->selectRaw('(SUM(presupuestos.numero_paneles * panel_solars.poder) / 1000) as total_kW')
                ->where('clientes.tipo_cliente', 'Residencial')
                ->where('presupuestos.id_user', $userID)
                ->first();
        } else {
            $tipoResidencial = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->selectRaw('(SUM(presupuestos.numero_paneles * panel_solars.poder) / 1000) as total_kW')
                ->where('clientes.tipo_cliente', 'Residencial')
                ->first();
        }

        $total_kW_residencial = $tipoResidencial->total_kW;


        if ($id == 3) {
            $tipoComercial = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->selectRaw('(SUM(presupuestos.numero_paneles * panel_solars.poder) / 1000) as total_kW2')
                ->where('clientes.tipo_cliente', 'Comercial')
                ->where('presupuestos.id_user', $userID)
                ->first();
        } else {
            $tipoComercial = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->selectRaw('(SUM(presupuestos.numero_paneles * panel_solars.poder) / 1000) as total_kW2')
                ->where('clientes.tipo_cliente', 'Comercial')
                ->first();
        }

        $total_kW_Comercial = $tipoComercial->total_kW2;

        if ($id == 3) {
            $tipoindustrial = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->selectRaw('(SUM(presupuestos.numero_paneles * panel_solars.poder) / 1000) as total_kW3')
                ->where('presupuestos.id_user', $userID)
                ->where('clientes.tipo_cliente', 'Industrial')
                ->first();
        } else {
            $tipoindustrial = DB::table('presupuestos')
                ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
                ->join('panel_solars', 'presupuestos.id_panel', '=', 'panel_solars.id')
                ->selectRaw('(SUM(presupuestos.numero_paneles * panel_solars.poder) / 1000) as total_kW3')
                ->where('clientes.tipo_cliente', 'Industrial')
                ->first();
        }

        $total_kW_Industrial = $tipoindustrial->total_kW3;

        if ($id == 3) {
            $monthlyClients = DB::table('clientes')
                ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('COUNT(*) as total'))
                ->where('id_user', $userID)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'))
                ->get()
                ->map(function ($item) {
                    $item->total = (int) $item->total; // Convertir a número
                    return $item;
                });
        } else {
            $monthlyClients = DB::table('clientes')
                ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('COUNT(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy(DB::raw('MONTH(created_at)'))
                ->get()
                ->map(function ($item) {
                    $item->total = (int) $item->total; // Convertir a número
                    return $item;
                });
        }

        // Formatear datos mensuales para la gráfica
        $monthlyLineData = [
            ['Mes', 'Clientes', ['role' => 'annotation']]
        ];

        $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        //DD($monthlyClients);
        foreach ($monthlyClients as $client) {
            $monthlyLineData[] = [
                $months[$client->mes - 1],
                $client->total,
                (string) $client->total
            ];
        }

        // Obtener datos semanales
        $weeklyLineData = [];

        foreach ($months as $index => $month) {
            if ($id == 3) {
                $weeklyData = DB::table('clientes')
                    ->select(DB::raw('WEEK(created_at) as semana'), DB::raw('COUNT(*) as total'))
                    ->where('id_user', $userID)
                    ->whereMonth('created_at', $index + 1)
                    ->groupBy(DB::raw('WEEK(created_at)'))
                    ->orderBy(DB::raw('WEEK(created_at)'))
                    ->get()
                    ->map(function ($item) {
                        $item->total = (int) $item->total; // Convertir a número
                        return $item;
                    });
            } else {
                $weeklyData = DB::table('clientes')
                    ->select(DB::raw('WEEK(created_at) as semana'), DB::raw('COUNT(*) as total'))
                    ->whereMonth('created_at', $index + 1)
                    ->groupBy(DB::raw('WEEK(created_at)'))
                    ->orderBy(DB::raw('WEEK(created_at)'))
                    ->get()
                    ->map(function ($item) {
                        $item->total = (int) $item->total; // Convertir a número
                        return $item;
                    });
            }

            $weeklyLineData[$month] = [['Semana', 'Clientes', ['role' => 'annotation']]];

            foreach ($weeklyData as $data) {
                $weeklyLineData[$month][] = [
                    'Semana ' . $data->semana,
                    $data->total,          // Ya se asegura que es un número
                    (string) $data->total  // Convertir a cadena para la anotación
                ];
            }
        }

        if ($id == 2) {
            $metas_comerciales = DB::select('SELECT users.nombre, users.meta, SUM(presupuestos.presupuesto_total) AS total_presupuesto,(SUM(presupuestos.presupuesto_total) / users.meta) * 100 AS porcentaje_avance FROM presupuestos JOIN users ON presupuestos.id_user = users.id WHERE presupuestos.id_estado = 7 AND presupuestos.id_user = ' . $userID . ' GROUP BY users.nombre, users.meta;');
        } else {
            $metas_comerciales = DB::select('SELECT users.nombre, users.meta, SUM(presupuestos.presupuesto_total) AS total_presupuesto,(SUM(presupuestos.presupuesto_total) / users.meta) * 100 AS porcentaje_avance FROM presupuestos JOIN users ON presupuestos.id_user = users.id WHERE presupuestos.id_estado = 7 GROUP BY users.nombre, users.meta;');
        }   

        $primerResultado = $metas_comerciales[0];
        //DD($primerResultado);
        $avance = $primerResultado->total_presupuesto;

        $porcentaje = ($avance * 100) / $primerResultado->meta;

        // Ejecutar la consulta para obtener los conteos por estado
        if ($id == 3) {
            $estadisticas = DB::table('presupuestos')
                ->join('estados', 'presupuestos.id_estado', '=', 'estados.id')
                ->select('estados.nombre', DB::raw('COUNT(*) AS total_registros'))
                ->where('presupuestos.id_user', $userID)
                ->groupBy('estados.nombre', 'presupuestos.id_estado')
                ->get()
                ->keyBy('nombre');
        } else {
            $estadisticas = DB::table('presupuestos')
                ->join('estados', 'presupuestos.id_estado', '=', 'estados.id')
                ->select('estados.nombre', DB::raw('COUNT(*) AS total_registros'))
                ->groupBy('estados.nombre', 'presupuestos.id_estado')
                ->get()
                ->keyBy('nombre'); // Agrupa el resultado por nombre del estado para fácil acceso
        }

        // Inicializa los conteos con valores por defecto
        $pendientes = $estadisticas->get('PENDIENTE')->total_registros ?? 0;
        $disenadas = $estadisticas->get('DISEÑADA')->total_registros ?? 0;
        $enviadas = $estadisticas->get('ENVIADO')->total_registros ?? 0;
        $negociaciones = $estadisticas->get('NEGOCIACIONES')->total_registros ?? 0;
        $descargatas = $estadisticas->get('DESCARGADAS')->total_registros ?? 0;
        $contratadas = $estadisticas->get('CONTRATADO')->total_registros ?? 0;

        return view('home', compact(
            'contratadas',
            'pendientes',
            'disenadas',
            'enviadas',
            'negociaciones',
            'descargatas',
            'clientes',
            'presupuestos',
            'comerciales',
            'totalkW',
            'monthlyData',
            'weeklyData',
            'weeklyData1',
            'tiposClientes',
            'total_kW_residencial',
            'total_kW_Comercial',
            'total_kW_Industrial',
            'monthlyLineData',
            'weeklyLineData',
            'metas_comerciales',
            'porcentaje',
            'avance'
        ));
    }

    private function translateMonth($month)
    {
        $months = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];

        return $months[$month] ?? $month;
    }
}
