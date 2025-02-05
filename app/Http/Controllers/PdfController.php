<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function descargarPDF(Request $request, $id)
    {
        Carbon::setLocale('es');
        // consultar los datos ne la base de datos
        $cliente = DB::table('presupuestos')
            ->join('clientes', 'presupuestos.id_cliente', '=', 'clientes.NIC')
            ->where('presupuestos.id', $id)
            ->select('clientes.*')
            ->get();

        $potencia = DB::select("SELECT clientes.consumo_actual
            FROM presupuestos
            JOIN clientes ON presupuestos.id_cliente = clientes.NIC
            WHERE presupuestos.id = '$id'");

        $consumoActual = $potencia[0]->consumo_actual;

        // Potencia a instalar en kW
        $instalar = ($consumoActual * 12) / 1500;

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
                'clientes.ciudad',
                'clientes.departamento',
                'clientes.tipo_cliente',
                'clientes.tarifa',
                'panel_solars.marca AS solar_panel_marca',
                'presupuestos.codigo_propuesta',
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
                'panel_solars.modelo',
                'inversors.poder AS poder_investor',
                'inversors2.poder AS poder2_investor',
                'baterias.id as id_bateria',
                'baterias.amperios_hora',
                'baterias.marca AS batterie_marca',
                'baterias.tipo',
                'panel_solars.precio',
                'baterias.voltaje',
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

            $item->sugerida = ($item->numero_paneles * $item->poder) / 1000;

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

        
        $mensajesErrores = [];

        // Imagen 1
        $ahorro_grafica_1 = DB::select("SELECT ruta_imagen FROM graficas WHERE id_presupuesto = '$id' AND nombre = 'Imagen 1';");

        if (empty($ahorro_grafica_1)) {
            $mensajesErrores[] = 'La ruta de la Imagen 1 no está disponible.';
        } else {
            $primerResultado_1 = $ahorro_grafica_1[0];
            $grafica_1 = $primerResultado_1->ruta_imagen;
        }

        // Imagen 2
        $ahorro_grafica_2 = DB::select("SELECT ruta_imagen FROM graficas WHERE id_presupuesto = '$id' AND nombre = 'Imagen 2';");

        if (empty($ahorro_grafica_2)) {
            $mensajesErrores[] = 'La ruta de la Imagen 2 no está disponible.';
        } else {
            $primerResultado_2 = $ahorro_grafica_2[0];
            $grafica_2 = $primerResultado_2->ruta_imagen;
        }

        // Imagen 3
        $ahorro_grafica_3 = DB::select("SELECT ruta_imagen FROM graficas WHERE id_presupuesto = '$id' AND nombre = 'Imagen 3';");

        if (empty($ahorro_grafica_3)) {
            $mensajesErrores[] = 'La ruta de la Imagen 3 no está disponible.';
        } else {
            $primerResultado_3 = $ahorro_grafica_3[0];
            $grafica_3 = $primerResultado_3->ruta_imagen;
        }

        // Imagen 4
        $ahorro_grafica_4 = DB::select("SELECT ruta_imagen FROM graficas WHERE id_presupuesto = '$id' AND nombre = 'Imagen 4';");

        if (empty($ahorro_grafica_4)) {
            $mensajesErrores[] = 'La ruta de la Imagen 4 no está disponible.';
        } else {
            $primerResultado_4 = $ahorro_grafica_4[0];
            $grafica_4 = $primerResultado_4->ruta_imagen;
        }

        // Imagen 5
        $design = DB::select("SELECT ruta_imagen FROM graficas WHERE id_presupuesto = '$id' AND nombre = 'Imagen 5';");

        if (empty($design)) {
            $mensajesErrores[] = 'La ruta de la Imagen 5 no está disponible.';
        } else {
            $primerResultado_5 = $design[0];
            $design_5 = $primerResultado_5->ruta_imagen;
        }

        // Verificar si hay mensajes de error
        if (!empty($mensajesErrores)) {
            // Redirigir a la página anterior con los mensajes de error
            return Redirect::back()->with('mensajesErrores', $mensajesErrores);
        }

        // Verificar si las variables necesarias están definidas
        if (!isset($grafica_1, $grafica_2, $grafica_3, $grafica_4, $design_5)) {
            return Redirect::back()->with('error', 'Faltan datos necesarios para generar el PDF.');
        }

        $ahorro_anuales = $this->energia_anual($id);
        $energia_anual = $this->energia_anual($id);
        $primer_resultado = !empty($energia_anual) ? $energia_anual[0] : null;
        $energia = $primer_resultado['energia_anual'];
        $generacion_mensuales = $this->genracion_mensual($energia);

        $total = 0;
        foreach ($generacion_mensuales as $mes) {
            $total += $mes['resultado'];
        }

        $pro = $total / count($generacion_mensuales);

        $promedio = round($pro);
        $dato3 = DB::select("SELECT tarifa FROM clientes INNER JOIN presupuestos ON clientes.NIC = presupuestos.id_cliente WHERE presupuestos.id = '$id';");
        $primerResultado_3 = $dato3[0];
        $valor = $primerResultado_3->tarifa;

        $ahorro =  $promedio * $valor;
        $ahorro_letra = $this->convertirNumeroALetras($ahorro);

        $primer_resultado1 = !empty($energia_anual) ? $energia_anual[0] : null;
        $anual = $primer_resultado1['energia_anual'];

        $retorno_invercion = $this->retorno_inver($ahorro_anuales, $id);
        $primer_resultado2 = !empty($retorno_invercion) ? $retorno_invercion[0] : null;
        $retorno1 = $primer_resultado2['saldo_retorno'] * -1;

        $retorno_invercion2 = $this->retorno_inver($ahorro_anuales, $id);
        $valor_year = null;
        $year = null;
        foreach ($retorno_invercion2 as $resultado) {
            if ($resultado['saldo_retorno'] > 0) {
                $valor_year = $resultado['saldo_retorno'];
                $year = $resultado['year'];
                break;
            }
        }
        $retorno_invercion3 = $this->retorno_inver($ahorro_anuales, $id);
        $primer_resultado3 = !empty($retorno_invercion3) ? $retorno_invercion3[4] : null;
        $year_5 = $primer_resultado3['saldo_retorno'];

        $tarifa = public_path('img/Tarifa.png');

        $year_letras = $this->convertirNumeroALetras($year_5);

        $valor_redondeado = round($results->first()->TOTAL_PROYECTO);

        $presupuesto_letra = $this->convertirNumeroALetras($valor_redondeado);

        //DD($grafica_1);
        $pdf = PDF::loadView('pdf.pdf', [
            'cliente' => $cliente,
            'grafica_1' => $grafica_1,
            'grafica_2' => $grafica_2,
            'grafica_3' => $grafica_3,
            'grafica_4' => $grafica_4,
            'design_5' => $design_5,
            'instalar' => $instalar,
            'results' => $results,
            'promedio' => $promedio,
            'anual' => $anual,
            'tarifa' => $tarifa,
            'ahorro' => $ahorro,
            'retorno1' => $retorno1,
            'year' => $year,
            'valor_year' => $valor_year,
            'year_5' => $year_5,
            'ahorro_letra' => $ahorro_letra,
            'presupuesto_letra' => $presupuesto_letra,
            'year_letras' => $year_letras
        ]);

        $nombre = $results->first()->nombre_proyecto;
        // Guardar grafica en drive
        // necesito guardarlo y no visualizarlo
        return $pdf->download($nombre. '.pdf');
    }

    public function convertirNumeroALetras($numero)
    {
        // Array con las palabras para los números del 0 al 19
        $unidades = array('cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve');

        // Array con las palabras para las decenas
        $decenas = array('', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');

        // Array con las palabras para las centenas
        $centenas = array('', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');

        $resultado = '';

        if ($numero < 20) {
            // Si el número es menor que 20, simplemente usamos las palabras del array $unidades
            $resultado .= $unidades[$numero];
        } elseif ($numero < 100) {
            // Si el número está entre 20 y 99, usamos las palabras del array $decenas y $unidades
            $resultado .= $decenas[floor($numero / 10)];
            if ($numero % 10 != 0) {
                $resultado .= ' y ' . $unidades[$numero % 10];
            }
        } elseif ($numero < 1000) {
            // Si el número está entre 100 y 999, usamos las palabras del array $centenas, $decenas y $unidades
            $resultado .= $centenas[floor($numero / 100)];

            // Si hay decenas y unidades, agregamos la palabra "y"
            if ($numero % 100 != 0) {
                $resultado .= ' ';
                $resultado .= $this->convertirNumeroALetras($numero % 100);
            }
        } elseif ($numero < 1000000) {
            // Si el número está entre 1000 y 999999, convertimos las unidades de miles y las unidades restantes
            $resultado .= $this->convertirNumeroALetras(floor($numero / 1000)) . ' mil';
            if ($numero % 1000 != 0) {
                $resultado .= ' ' . $this->convertirNumeroALetras($numero % 1000);
            }
        } else {
            // Si el número es mayor o igual a 1000000, convertimos las unidades de millones y las unidades restantes
            $resultado .= $this->convertirNumeroALetras(floor($numero / 1000000)) . ' millon';
            if (floor($numero / 1000000) > 1) {
                $resultado .= 'es'; // plural de "millón" si es mayor a uno
            }
            if ($numero % 1000000 != 0) {
                $resultado .= ' ' . $this->convertirNumeroALetras($numero % 1000000);
            }
        }
        //DD($resultado);
        return $resultado;
    }

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

        $currentEnergy = round($potencia * 1420, 2);
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
        //DD($Data);
        return $Data;
    }
}
