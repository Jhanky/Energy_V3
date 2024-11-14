@extends('layout.plantilla')

@section('title')
Información
@endsection

@section('header')

@endsection

@section('base')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <h2 class="font-weight-normal mt-3" style="text-align: center; color:black;">Cotización de <b>{{ number_format($results->first()->instalada, 2,',', '.') }}kW</b> para <b>{{$results->first()->nombre_proyecto}}</b></h2>
            <div class="card-body">
                @include('cotizaciones.modificar')
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">NIC:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->first()->NIC }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Nombre:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->first()->nombre }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Tipo de cliente:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->first()->tipo_cliente }}</label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
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
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Tarifa $/kWh:</label></td>
                                    <td style="color: black;"><label style="color: black;">{{ number_format($cliente->first()->tarifa, 0,',', '.') }}</label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Consumo actual $/kWh:</label></td>
                                    <td style="text-align: right; color: black;"><label style="color: black;">{{ number_format($cliente->first()->consumo_actual, 0,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">kW para el 100%:</label></td>
                                    <td style="text-align: right; color: black;"><label style="color: black;">{{ number_format($promedio, 2,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Potencia cotizada kW:</label></td>
                                    <td style="text-align: right; color: black;"><label style="color: black;">{{ number_format($results->first()->instalada, 2,',', '.') }}</label></td>
                                </tr>
                                @php
                                $valor_luz = $cliente->first()->tarifa * $cliente->first()->consumo_actual
                                @endphp
                                <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Paga en luz $:</label></td>
                                <td style="text-align: right;"><label style="color: black;">{{ number_format($valor_luz, 0,',', '.') }}</label></td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
        @include('cotizaciones.admin_info')
        @endif

        @if(auth()->user()->hasRole('COMERCIAL'))
        @include('cotizaciones.comercial_info')
        @endif

        <div class="card my-4">
            <div class="card-body">
                <div class="container">
                    @php
                    $total_proyecto_cotizado = $results->first()->TOTAL_PROYECTO_cotizado;
                    $total_proyecto = $results->first()->TOTAL_PROYECTO;
                    @endphp

                    @if ($total_proyecto_cotizado > $total_proyecto)
                    {{-- No mostrar nada --}}
                    @else
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
                    @endif

                    <div class="row">
                        <div class="col">
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
                </div>
            </div>
        </div>
        </>
    </div>
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
            credits: {
                enabled: false
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
            credits: {
                enabled: false
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
            credits: {
                enabled: false
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
        document.addEventListener('DOMContentLoaded', function() {
            const descuentoSelect = document.getElementById('descuentoSelect');
            const valorConDescuento = document.getElementById('valorConDescuento');
            const valorProyecto = {
                {
                    $results - > first() - > subtotal_2
                }
            };

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

    <script>
        // Función para agregar puntos cada tres dígitos y el signo de dólar
        function formatCurrency(number) {
            return '$' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        // Obtén todos los elementos con la clase 'custom-input'
        var inputElements = document.querySelectorAll('.custom-input');
        // Itera sobre cada input y agrega un escuchador de eventos 'input'
        inputElements.forEach(function(inputElement) {
            inputElement.addEventListener('input', function(event) {
                // Elimina el signo de dólar y las comas actuales antes de formatear
                var unformattedValue = event.target.value.replace(/\$|,/g, '');
                // Formatea el valor con el signo de dólar y comas cada tres dígitos
                var formattedValue = formatCurrency(unformattedValue);
                // Asigna el valor formateado de vuelta al input
                event.target.value = formattedValue;
            });
        });
        // Agrega un evento 'submit' al formulario para limpiar los valores antes de enviar
        var myForm = document.getElementById('myForm');
        myForm.addEventListener('submit', function() {
            inputElements.forEach(function(inputElement) {
                inputElement.value = inputElement.value.replace(/\$|,/g, '');
            });
        });
    </script>
    @endsection