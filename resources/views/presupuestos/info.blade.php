@extends('layouts.main')

@section('title')
Información
@endsection

@section('base')
<main>
    <div class="container-fluid px-4">
        <h1 style="text-align: center; color: black; margin-bottom: 20px;"><b>Presupuesto para {{$results->first()->nombre_proyecto}}</b></h1>
        @include('layouts.msj')
        @include('presupuestos.modificar')
        <div>
            <div id="info">
                <div class="row">
                    <h4 style="color: black; margin-bottom: 20px;"><b>Información del cliente</b></h4>

                    <br>
                    <div class="col">
                        <table>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">NIC</label></td>
                                <td><label style="color: black; border: none;">{{ $cliente->first()->NIC }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Nombre</label></td>
                                <td><label style="color: black; border: none;">{{ $cliente->first()->nombre }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Tipo de cliente:</label></td>
                                <td><label style="color: black; border: none;">{{ $cliente->first()->tipo_cliente }}</label></td>
                            </tr>
                        </table>

                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Ciudad:</label></td>
                                <td><label style="color: black; border: none;">{{ $cliente->first()->ciudad }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Dirección:</label></td>
                                <td><label style="color: black; border: none;">{{ $cliente->first()->direccion }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Radiación:</label></td>
                                <td><label style="color: black; border: none;">{{ number_format($radiacion, 0,',', '.') }}</label></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Tarifa $/kWh:</label></td>
                                <td style="text-align: right;"><label style="color: black;">{{ number_format($cliente->first()->tarifa, 0,',', '.') }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Consumo actual $/kWh:</label></td>
                                <td style="text-align: right;"><label style="color: black;">{{ number_format($cliente->first()->consumo_actual, 0,',', '.') }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">kW para el 100%:</label></td>
                                <td style="text-align: right;"><label style="color: black;">{{ number_format($promedio, 2,',', '.') }}</label></td>
                            </tr>
                            <tr>
                                @php
                                $valor_luz = $cliente->first()->tarifa * $cliente->first()->consumo_actual
                                @endphp
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Paga en luz $:</label></td>
                                <td style="text-align: right;"><label style="color: black;">{{ number_format($valor_luz, 0,',', '.') }}</label></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Potencia cotizada kW:</label></td>
                                <td style="text-align: right;"><label style="color: black;">{{ number_format($results->first()->instalada, 2,',', '.') }}</label></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <h4 style="color: black; margin-bottom: 20px;"><b>Información de la cotización </b></h4>
            @php
            $userRoles = auth()->user()->roles->pluck('name')->toArray();
            @endphp
            <div class="table-responsive" id="tabla">
                @include('presupuestos.editar_presupuesto')
                <table class="table table-bordered border-success" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-secondary border-success">
                        <tr>
                            <th style="color: black;"><b>Equipos</b></th>
                            <th style="color: black;"><b>Modelo</b></th>
                            <th style="color: black;"><b>Cantidad</b></th>
                            <th style="color: black;"><b>Potencia</b></th>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <th style="color: black;"><b>Precio Unitario</b></th>
                            <th style="color: black;"><b>Valor parcial</b></th>
                            <th style="color: black;"><b>% Gewinn</b></th>
                            <th style="color: black;"><b>Gewinn</b></th>
                            <th style="color: black;"><b>Valor + IVA</b></th>
                            @endunless
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Combina las celdas "Panel", "Batería" e "Inversor" en una sola fila -->
                        <tr>
                            <td class="table-success border-success" style="color: black;"><b>Panel</b></td>
                            <td>{{ $results->first()->solar_panel_marca }}</td>
                            <td style="text-align: right;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                            <td style="text-align: right;">{{ number_format($results->first()->poder, 0,',', '.') }}W</td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($results->first()->precio, 0, ',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->total_panel, 0,',', '.') }}</td>
                            <td style="text-align: right;">25%</td>
                            <td style="text-align: right;">${{ number_format($results->first()->panel_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->panel_total, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-success border-success" style="color: black;"><b>Bateria</b></td>
                            <td>{{ $results->first()->batterie_marca ?? 'Sin bateria'}}</td>
                            <td style="text-align: right;">{{ number_format($results->first()->numero_baterias, 0, ',', '.' ?? '0') }}</td>
                            <td style="text-align: right;">{{ number_format($results->first()->amperios_hora, 0, ',', '.' ?? '0') }}Ah</td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($results->first()->precio_batterie, 0, ',', '.' ?? '0') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->total_bateria, 0,',', '.') }}</td>
                            <td style="text-align: right;">25%</td>
                            <td style="text-align: right;">${{ number_format($results->first()->bateria_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->bateria_total, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-success border-success" style="color: black;"><b>Inversor</b></td>
                            <td>
                                @if ($results->first()->investor_marca)
                                {{ $results->first()->investor_marca }}
                                @endif
                                <br>
                                @if ($results->first()->investor2_marca)
                                {{ $results->first()->investor2_marca }}
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if ($results->first()->numero_inversores)
                                {{ number_format($results->first()->numero_inversores, 0,',', '.') }}
                                @endif
                                <br>
                                @if ($results->first()->numero_inversores_2)
                                {{ number_format($results->first()->numero_inversores_2, 0,',', '.') }}
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if ($results->first()->poder_investor)
                                {{ number_format($results->first()->poder_investor, 0,',', '.') }}kW
                                @endif
                                <br>
                                @if ($results->first()->poder2_investor)
                                {{ number_format($results->first()->poder2_investor, 0,',', '.') }}kW
                                @endif
                            </td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">
                                @if ($results->first()->precio_investor)
                                ${{ number_format($results->first()->precio_investor, 0, ',', '.') }}
                                @endif
                                <br>
                                @if ($results->first()->precio2_investor)
                                ${{ number_format($results->first()->precio2_investor, 0, ',', '.') }}
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if ($results->first()->total_inversor)
                                ${{ number_format($results->first()->total_inversor, 0,',', '.') }}
                                @endif
                                <br>
                                @if ($results->first()->total_inversor2)
                                ${{ number_format($results->first()->total_inversor2, 0,',', '.') }}
                                @endif
                            </td>
                            <td style="text-align: right;">
                                25%</td>
                            <td style="text-align: right;">
                                @if ($results->first()->inversor_gewinn)
                                ${{ number_format($results->first()->inversor_gewinn, 0,',', '.') }}
                                @endif
                                <br>
                                @if ($results->first()->inversor_gewinn2)
                                ${{ number_format($results->first()->inversor_gewinn2, 0,',', '.') }}
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if ($results->first()->inversor_total)
                                ${{ number_format($results->first()->inversor_total, 0,',', '.') }}
                                @endif
                                <br>
                                @if ($results->first()->inversor_total2)
                                ${{ number_format($results->first()->inversor_total2, 0,',', '.') }}
                                @endif
                            </td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-danger border-success" style="color: black;"><b>Material electrico</b></td>
                            <td></td>
                            <td style="text-align: right;">{{ number_format($results->first()->numero_inversores, 0,',', '.') }}</td>
                            <td></td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($results->first()->material, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->material_p, 0, ',', '.') }}</td>
                            <td style="text-align: right;">25%</td>
                            <td style="text-align: right;">${{ number_format($results->first()->material_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->material_total, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-danger border-success" style="color: black;"><b>Estructura</b></td>
                            <td></td>
                            <td style="text-align: right;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                            <td></td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($results->first()->total_estructura, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->estructura_p, 0, ',', '.') }}</td>
                            <td style="text-align: right;">25%</td>
                            <td style="text-align: right;">${{ number_format($results->first()->estructura_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->estructura_total, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-danger border-success" style="color: black;"><b>Conductor fotovoltaico(mts)</b></td>
                            @php
                            $mt = round($results->first()->cable_p / $valor_cable);
                            $precio_unitario = $mt * $valor_cable;
                            $gewinn = $precio_unitario * 0.25;
                            $total_cable = $precio_unitario + $gewinn;
                            @endphp
                            <td></td>
                            <td style="text-align: right;">{{ number_format($mt, 0,',', '.') }}</td>
                            <td></td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($valor_cable, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($precio_unitario, 0, ',', '.') }}</td>
                            <td style="text-align: right;">25%</td>
                            <td style="text-align: right;">${{ number_format($gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($total_cable, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-danger border-success" style="color: black;"><b>Mano de obra</b></td>
                            <td></td>
                            <td style="text-align: right;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                            <td></td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($results->first()->mano, 0, ',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->mano_p, 0,',', '.') }}</td>
                            <td style="text-align: right;">25%</td>
                            <td style="text-align: right;">${{ number_format($results->first()->mano_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->mano_total, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td class="table-primary border-success" style="color: black;"><b>Tramites(certificados retie, medidor bidireccional, Estudio de conexion)</b></td>
                            <td></td>
                            <td style="text-align: right;">1</td>
                            <td></td>
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="text-align: right;">${{ number_format($results->first()->valor_tramites, 0, ',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->valor_tramites, 0,',', '.') }}</td>
                            <td style="text-align: right;">5%</td>
                            <td style="text-align: right;">${{ number_format($results->first()->tramite_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->tramite_total, 0,',', '.') }}</td>
                            @endunless
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        @unless(in_array('COMERCIAL', $userRoles))
                        <tr>
                            <td class="negrita" colspan="5" style="text-align: left;"><b>Subtotal</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->subtotal_p, 0,',', '.') }}</td>
                            <td></td>
                            <td style="text-align: right;">${{ number_format($results->first()->subtotal_gewinn, 0,',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($results->first()->subtotal, 0,',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="table-danger border-success" colspan="8" style="color: black;"><b>Gestion comercial ({{$results->first()->comercial_poencentaje}}%)</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->comercial, 0,',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="negrita" colspan="8" style="text-align: left;"><b>Subtotal 2</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->subtotal_2, 0,',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="table-danger border-success" colspan="8" style="color: black;"><b>Administracion ({{ $results->first()->administracion_porcentaje }}%)</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->administracion, 0,',', '.') }}</td>

                        </tr>
                        <tr>
                            <td class="table-danger border-success" colspan="8" style="color: black;"><b>Imprevistos ({{ $results->first()->imprevisto_porcentaje }}%)</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->imprevisto, 0,',', '.') }}</td>

                        </tr>
                        <tr>
                            <td class="table-danger border-success" colspan="8" style="color: black;"><b>Utilidad ({{ $results->first()->utilidad_porcentaje }}%)</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->utilidad, 0,',', '.') }}</td>

                        </tr>
                        <tr>
                            <td class="table-danger border-success" colspan="8" style="color: black;"><b>IVA sobre la utilidad (19%)</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->Iva, 0,',', '.') }}</td>
                        </tr>
                        @endunless
                        @php
                        $userRoles = auth()->user()->roles->pluck('name')->toArray(); // Obtener los roles del usuario actual
                        $colspanValue = in_array('COMERCIAL', $userRoles) ? 3 : 8; // Determinar el valor de colspan
                        @endphp
                        <tr>
                            <td class="negrita" colspan="{{ $colspanValue }}" style="text-align: left;"><b>Subtotal @unless(in_array('COMERCIAL', $userRoles))3 @endunless</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->subtotal_3, 0,',', '.') }}</td>
                        </tr>
                        @unless(in_array('COMERCIAL', $userRoles))
                        <tr>
                            <td class="negrita" colspan="{{ $colspanValue }}" style="text-align: left;"><b>Retenciones ({{ $results->first()->retencion_porcentaje }}%)</b></td>
                            <td style="text-align: right;">${{ number_format($results->first()->retencion, 0,',', '.') }}</td>
                        </tr>
                        @endunless
                        <tr>
                            <td class="negrita" colspan="{{ $colspanValue }}" style="text-align: left;"><b>Cotización del proyecto</b></td>
                            <td style="text-align: right;"><b>${{ number_format($results->first()->TOTAL_PROYECTO_cotizado, 0, ',', '.') }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td class="negrita" colspan="{{ $colspanValue }}" style="text-align: right;"><b>VALOR TOTAL</b></td>
                            <td style="text-align: right;">
                                <h4>
                                    {{ number_format($results->first()->TOTAL_PROYECTO, 0, ',', '.') }}
                                </h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="container">
                @unless(in_array('COMERCIAL', $userRoles))
                <div class="row" style="margin-bottom: 100px;">
                    <div style="text-align: center;">
                        <br>
                        <br>
                        <div class="sin-descuento" id="
                                    @if($results->first()->presupuesto_total !== null)
                                        {{ number_format($results->first()->presupuesto_total, 0, ',', '.') }}
                                    @else
                                        {{ $results->first()->porcentaje_descuento }}
                                    @endif
                                ">
                            @csrf
                            <input type="hidden" name="id" value="{{ $results->first()->id }}"> <!-- Agrega un campo oculto para enviar el ID -->
                            <h4 style="color: black;">Modificar o aplicar descuento</h4>
                            <div style="margin: 0 auto; display: inline-block; color: black;">
                                <button type="button" class="btn btn-success" rel="tooltip" data-bs-toggle="modal" data-bs-target="#modificar" style="margin-bottom: 20px;" id="cotizar">
                                    Modificar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endunless
                <br>

                <div id="ahorro">
                    <figure class="highcharts-figure">
                        <!-- Agrega un estilo al contenedor para limitar el tamaño -->
                        <div id="ahorro_anual"></div>
                    </figure>
                    <br>
                </div>

                <div id="anual">
                    <figure class="highcharts-figure">
                        <!-- Agrega un estilo al contenedor para limitar el tamaño -->
                        <div id="degradacion_anual"></div>
                    </figure>
                    <br>
                </div>

                <div id="mensual">
                    <figure class="highcharts-figure">
                        <!-- Agrega un estilo al contenedor para limitar el tamaño -->
                        <div id="generacion_mensual"></div>
                    </figure>
                    <br>
                </div>

                <div id="retorno">
                    <figure class="highcharts-figure">
                        <!-- Agrega un estilo al contenedor para limitar el tamaño -->
                        <div id="retorno"></div>
                    </figure>
                </div>
            </div>
        </div>
</main>
@endsection
@section('scripts')

<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
    Highcharts.chart('ahorro_anual', {
        chart: {
            type: 'column',
            borderWidth: 1, // Agregar un borde de 1 píxel
            borderColor: 'black', // Color del borde negro
            backgroundColor: '#f2f2f2', // Color de fondo gris claro
            borderRadius: 5, // Redondear las esquinas (ajusta el valor según lo deseado)
            height: 600, // Ajusta la altura de la gráfica según sea necesario para mostrar todas las etiquetas
            marginTop: 50 // Espacio entre el título y el resto de la gráfica
        },
        exporting: {
            chartOptions: {
                chart: {
                    width: 800, // Especifica el ancho deseado para la gráfica exportada en píxeles
                    height: 600 // Especifica la altura deseada para la gráfica exportada en píxeles
                }
            }
        },
        title: {
            text: 'Costo de la energía desplazada anualmente'
        },
        xAxis: {
            type: 'category',
            labels: {
                autoRotation: [-45, -90],
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            tickInterval: 1 // Forzar que se muestre cada etiqueta del eje x
        },
        yAxis: {
            min: 0,
            title: {
                text: 'KW'
            }
        },
        legend: {
            enabled: false
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: new Date().getFullYear(), // Obtener el año actual
                animation: false
            }
        },

        series: [{
            name: 'Population',
            colors: ['#4551d5'],
            colorByPoint: true,
            groupPadding: 0,
            data: <?= $data ?>,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#000000',
                inside: true,
                verticalAlign: 'top',
                formatter: function() {
                    // Formatear el valor con comas cada tres dígitos
                    return Highcharts.numberFormat(this.y, 0, '.', '.');
                },
                y: -90, // Mover las etiquetas hacia arriba
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
</script>

<script>
    Highcharts.chart('degradacion_anual', {
        chart: {
            type: 'column',
            borderWidth: 1,
            borderColor: 'black',
            backgroundColor: {
                linearGradient: [0, 0, 0, 400],
                stops: [
                    [0, '#ffffff'],
                    [1, '#f2f2f2']
                ]
            },
            borderRadius: 5,
            marginTop: 50,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 15,
                depth: 50
            }
        },
        exporting: {
            chartOptions: {
                chart: {
                    width: 800, // Especifica el ancho deseado para la gráfica exportada en píxeles
                    height: 600 // Especifica la altura deseada para la gráfica exportada en píxeles
                }
            }
        },
        title: {
            text: 'Energía generada VS Degradación(kW)'
        },
        xAxis: {
            type: 'category',
            labels: {
                autoRotation: [-45, -90],
                style: {
                    fontSize: '14px',
                    fontFamily: 'Verdana, sans-serif'
                },
                overflow: 'justify'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'KW'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    rotation: -90,
                    verticalAlign: 'top',
                    inside: true,
                    formatter: function() {
                        return Highcharts.numberFormat(this.y, 0, '.', '.');
                    },
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                animation: {
                    duration: 1000
                }
            }
        },
        series: [{
            name: 'Population',
            colors: ['#4551d5'],
            colorByPoint: true,
            groupPadding: 0,
            data: <?= $data2 ?>,
        }]
    });
</script>

<script>
    Highcharts.chart('generacion_mensual', {
        chart: {
            type: 'column',
            borderWidth: 1,
            borderColor: 'black',
            backgroundColor: {
                linearGradient: [0, 0, 0, 400],
                stops: [
                    [0, '#ffffff'],
                    [1, '#f2f2f2']
                ]
            },
            borderRadius: 5,
            marginTop: 50,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 15,
                depth: 50
            }
        },
        exporting: {
            chartOptions: {
                chart: {
                    width: 800, // Especifica el ancho deseado para la gráfica exportada en píxeles
                    height: 600 // Especifica la altura deseada para la gráfica exportada en píxeles
                }
            }
        },
        title: {
            text: 'Generación promedio mensual(kW)'
        },
        xAxis: {
            type: 'category',
            labels: {
                autoRotation: [-45, -90],
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                },
                overflow: 'justify'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'KW'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Genero: <b>{point.y:.0f}</b>'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: new Date().getFullYear(),
                animation: false
            },
            column: {
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    rotation: -90,
                    verticalAlign: 'top',
                    inside: true,
                    formatter: function() {
                        return Highcharts.numberFormat(this.y, 0, '.', '.');
                    },
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                animation: {
                    duration: 1000
                }
            }
        },
        series: [{
            name: 'Population',
            colors: ['#4551d5'],
            colorByPoint: true,
            groupPadding: 0,
            data: <?= $data3 ?>,
        }]
    });
</script>

<script>
    var nombreArchivo = "nombre_dinamico";
    Highcharts.chart('retorno', {
        chart: {
            type: 'column',
            borderWidth: 1,
            borderColor: 'black',
            backgroundColor: '#f2f2f2',
            borderRadius: 5,
            height: 450,
            marginTop: 50,
        },
        title: {
            text: 'Retorno de la inversión'
        },
        xAxis: {
            categories: ['Año 1', 'Año 2', 'Año 3', 'Año 4', 'Año 5', 'Año 6', 'Año 7', 'Año 8', 'Año 9', 'Año 10', 'Año 11', 'Año 12', 'Año 13', 'Año 14', 'Año 15', 'Año 16', 'Año 17', 'Año 18', 'Año 19', 'Año 20'],
            labels: {
                autoRotation: [-45, -90],
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                },
                overflow: 'justify'
            },
            tickInterval: 1
        },
        yAxis: {
            title: {
                text: 'Millones de pesos'
            },
            plotLines: [{
                color: '#000000',
                width: 1,
                value: 0,
                zIndex: 4
            }]
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            column: {
                colorByPoint: true,
                zones: [{
                    value: 0,
                    color: '#FF0000'
                }, {
                    color: '#00FF00'
                }],
                dataLabels: {
                    enabled: true,
                    align: 'center',
                    formatter: function() {
                        return '$ ' + (this.y < 0 ? '-' : '') + Highcharts.numberFormat(Math.abs(this.y), 0, '.', '.');
                    },
                    y: 0,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                animation: {
                    duration: 1000
                }
            }
        },
        exporting: {
            chartOptions: {
                chart: {
                    width: 700, // Especifica el ancho deseado para la gráfica exportada en píxeles
                    height: 450 // Especifica la altura deseada para la gráfica exportada en píxeles
                }
            }
        },
        series: [{
            name: 'Años',
            data: <?= $data4 ?>,
        }]
    });
</script>

<script>
    // Obtener todas las celdas de la columna "Valor parcial"
    var celdasValorParcial = document.querySelectorAll('#dataTable tbody td:nth-child(6)');

    // Variable para almacenar la suma
    var suma = 0;

    // Iterar sobre las celdas de la columna "Valor parcial" y sumar los valores
    for (var i = 0; i < celdasValorParcial.length; i++) {
        var valor = parseFloat(celdasValorParcial[i].textContent.replace('$', '').replace(',', ''));
        if (!isNaN(valor)) {
            suma += valor;
        }
    }

    // Mostrar el resultado en la celda con id "subtotal"
    document.getElementById('subtotal').textContent = '$' + suma.toLocaleString();
</script>

<script>
    function applyDiscount() {
        var discountValue = document.getElementById("discountInput").value;
        if (discountValue === "" || isNaN(discountValue) || parseInt(discountValue) < 0 || parseInt(discountValue) > 10) {
            alert("Ingrese un valor numérico válido entre 0 y 10.");
            return;
        }
        console.log("Descuento aplicado:", discountValue);
    }
</script>

<script>
    // Obtener el div por su id
    var div = document.querySelector('.sin-descuento');

    // Obtener el id del div
    var id = div.getAttribute('id');

    // Convertir el id a un número
    var idNumero = parseInt(id);

    // Verificar si el id es mayor que 0
    if (idNumero > 0) {
        // Ocultar todo el contenido dentro del div
        div.style.display = 'none';
    }
</script>

<script>
    // Obtener el div por su clase
    var div = document.querySelector('.con-descuento');

    // Obtener el id del div
    var id = div.getAttribute('id');

    // Convertir el id a un número
    var idNumero = parseInt(id);

    // Verificar si el id es igual a 0
    if (idNumero === 0) {
        // Ocultar todo el contenido dentro del div
        div.style.display = 'none';
    }
</script>

<script>
    // Obtener el input de valor de proyecto
    var inputValorProyecto = document.getElementById("presupuesto_total");
    // Obtener el select de descuento
    var selectDescuento = document.getElementById("descuentoSelect");
    // Obtener el div que quieres ocultar o mostrar
    var divDescuento = document.getElementById("divDescuento");
    // Obtener el div que envuelve la sección
    var seccionOcultable = document.getElementById("seccionOcultable");

    // Agregar evento input al input de valor de proyecto
    inputValorProyecto.addEventListener("input", function() {
        // Verificar si el valor del input está vacío
        if (inputValorProyecto.value.trim() !== "") {
            // Ocultar el select y el div
            selectDescuento.style.display = "none";
            divDescuento.style.display = "none";
        } else {
            // Mostrar el select y el div
            selectDescuento.style.display = "block";
            divDescuento.style.display = "block";
        }
    });

    // Agregar evento change al select de descuento
    selectDescuento.addEventListener("change", function() {
        // Verificar si la opción seleccionada es la opción predeterminada
        if (selectDescuento.value !== "0") {
            // Ocultar la sección
            seccionOcultable.style.display = "none";
        } else {
            // Mostrar la sección
            seccionOcultable.style.display = "block";
        }
    });
</script>

<script>
    // Función para agregar puntos cada tres dígitos y el signo de dólar
    function formatCurrency(number) {
        return '$' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Función para eliminar el formato y convertir a número
    function unformatCurrency(value) {
        return parseFloat(value.replace(/\$|,/g, ''));
    }

    // Obtén el input del valor del proyecto
    var inputValorProyecto = document.getElementById("presupuesto_total");

    // Agrega un escuchador de eventos 'input' al input
    inputValorProyecto.addEventListener("input", function(event) {
        // Elimina el signo de dólar y las comas actuales antes de formatear
        var unformattedValue = unformatCurrency(event.target.value);

        // Formatea el valor con el signo de dólar y comas cada tres dígitos
        var formattedValue = formatCurrency(unformattedValue);

        // Asigna el valor formateado de vuelta al input
        event.target.value = formattedValue;
    });

    // Agrega un evento 'submit' al formulario para limpiar los valores antes de enviar
    var myForm = document.getElementById('descuento');
    myForm.addEventListener('submit', function() {
        // Formatea el valor del campo "Valor de proyecto" antes de enviar
        var inputValue = inputValorProyecto.value;
        var unformattedValue = unformatCurrency(inputValue);
        inputValorProyecto.value = unformattedValue;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const descuentoSelect = document.getElementById('descuentoSelect');
        const valorConDescuento = document.getElementById('valorConDescuento');
        const valorProyecto = {{$results->first()->subtotal_2}};

        descuentoSelect.addEventListener('change', function() {
            const descuento = parseFloat(this.value);
            if (isNaN(descuento)) {
                valorConDescuento.textContent = 'N/A';
            } else {
                const valorDescuento = valorProyecto * descuento;
                valorConDescuento.textContent = '$' + valorDescuento.toLocaleString('es-ES', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
        });
    });
</script>
@endsection