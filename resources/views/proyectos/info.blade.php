@extends('layout.plantilla')

@section('title')
Dasboard
@endsection

@section('header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
        google.charts.load('current', {
            'packages': ['gantt']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'ID de Tarea');
            data.addColumn('string', 'Nombre de la Tarea');
            data.addColumn('date', 'Fecha de Inicio');
            data.addColumn('date', 'Fecha de Fin');
            data.addColumn('number', 'Duración');  // Puede ser null
            data.addColumn('number', 'Porcentaje Completo');  // Puede ser null
            data.addColumn('string', 'Dependencias');  // Puede ser null

            // Fecha actual
            var today = new Date();
            
            // Función para calcular porcentaje completado
            function calculateCompletion(startDate, endDate) {
            var totalDuration = (new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24); // en días
            var elapsedDuration = (today - new Date(startDate)) / (1000 * 60 * 60 * 24); // en días
            var completionPercentage = (elapsedDuration / totalDuration) * 100;
            completionPercentage = Math.max(0, Math.min(100, completionPercentage)); // Asegura que esté entre 0 y 100
            return parseFloat(completionPercentage.toFixed(2)); // Limita a dos decimales
            }

            data.addRows([
                ['firma_contrato', 'Firma de contrato',
                    new Date({{ date('Y', strtotime($cronograma->firma_de_contrato_inicio)) }}, {{ date('m', strtotime($cronograma->firma_de_contrato_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->firma_de_contrato_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->firma_de_contrato_fin)) }}, {{ date('m', strtotime($cronograma->firma_de_contrato_fin)) - 1 }}, {{ date('d', strtotime($cronograma->firma_de_contrato_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->firma_de_contrato_inicio }}', '{{ $cronograma->firma_de_contrato_fin }}'),
                    null
                ],
                ['estudio_conexion', 'Estudio de conexión ante operador de red',
                    new Date({{ date('Y', strtotime($cronograma->estudio_de_conexion_ante_operadore_de_red_inicio)) }}, {{ date('m', strtotime($cronograma->estudio_de_conexion_ante_operadore_de_red_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->estudio_de_conexion_ante_operadore_de_red_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->estudio_de_conexion_ante_operadore_de_red_fin)) }}, {{ date('m', strtotime($cronograma->estudio_de_conexion_ante_operadore_de_red_fin)) - 1 }}, {{ date('d', strtotime($cronograma->estudio_de_conexion_ante_operadore_de_red_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->estudio_de_conexion_ante_operadore_de_red_inicio }}', '{{ $cronograma->estudio_de_conexion_ante_operadore_de_red_fin }}'),
                    null
                ],
                ['replanteo_proyecto', 'Replanteo del proyecto',
                    new Date({{ date('Y', strtotime($cronograma->replanteo_del_proyecto_inicio)) }}, {{ date('m', strtotime($cronograma->replanteo_del_proyecto_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->replanteo_del_proyecto_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->replanteo_del_proyecto_fin)) }}, {{ date('m', strtotime($cronograma->replanteo_del_proyecto_fin)) - 1 }}, {{ date('d', strtotime($cronograma->replanteo_del_proyecto_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->replanteo_del_proyecto_inicio }}', '{{ $cronograma->replanteo_del_proyecto_fin }}'),
                    null
                ],
                ['reunion_socializacion', 'Reunión de socialización del proyecto',
                    new Date({{ date('Y', strtotime($cronograma->reunion_socilaización_del_proyecto_inicio)) }}, {{ date('m', strtotime($cronograma->reunion_socilaización_del_proyecto_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->reunion_socilaización_del_proyecto_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->reunion_socilaización_del_proyecto_fin)) }}, {{ date('m', strtotime($cronograma->reunion_socilaización_del_proyecto_fin)) - 1 }}, {{ date('d', strtotime($cronograma->reunion_socilaización_del_proyecto_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->reunion_socilaización_del_proyecto_inicio }}', '{{ $cronograma->reunion_socilaización_del_proyecto_fin }}'),
                    null
                ],
                ['montaje_paneles', 'Montaje de paneles solares',
                    new Date({{ date('Y', strtotime($cronograma->montaje_paneles_solares_inicio)) }}, {{ date('m', strtotime($cronograma->montaje_paneles_solares_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->montaje_paneles_solares_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->montaje_paneles_solares_fin)) }}, {{ date('m', strtotime($cronograma->montaje_paneles_solares_fin)) - 1 }}, {{ date('d', strtotime($cronograma->montaje_paneles_solares_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->montaje_paneles_solares_inicio }}', '{{ $cronograma->montaje_paneles_solares_fin }}'),
                    null
                ],
                ['montaje_inversor', 'Montaje del inversor',
                    new Date({{ date('Y', strtotime($cronograma->montaje_inversor_inicio)) }}, {{ date('m', strtotime($cronograma->montaje_inversor_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->montaje_inversor_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->montaje_inversor_fin)) }}, {{ date('m', strtotime($cronograma->montaje_inversor_fin)) - 1 }}, {{ date('d', strtotime($cronograma->montaje_inversor_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->montaje_inversor_inicio }}', '{{ $cronograma->montaje_inversor_fin }}'),
                    null
                ],
                ['conexionado', 'Conexionado',
                    new Date({{ date('Y', strtotime($cronograma->conexionado_inicio)) }}, {{ date('m', strtotime($cronograma->conexionado_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->conexionado_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->conexionado_fin)) }}, {{ date('m', strtotime($cronograma->conexionado_fin)) - 1 }}, {{ date('d', strtotime($cronograma->conexionado_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->conexionado_inicio }}', '{{ $cronograma->conexionado_fin }}'),
                    null
                ],
                ['pruebas_conexion', 'Pruebas de conexión',
                    new Date({{ date('Y', strtotime($cronograma->pruebas_de_conexion_inicio)) }}, {{ date('m', strtotime($cronograma->pruebas_de_conexion_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->pruebas_de_conexion_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->pruebas_de_conexion_fin)) }}, {{ date('m', strtotime($cronograma->pruebas_de_conexion_fin)) - 1 }}, {{ date('d', strtotime($cronograma->pruebas_de_conexion_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->pruebas_de_conexion_inicio }}', '{{ $cronograma->pruebas_de_conexion_fin }}'),
                    null
                ],
                ['puesta_marcha', 'Puesta en marcha',
                    new Date({{ date('Y', strtotime($cronograma->puesta_en_marcha_inicio)) }}, {{ date('m', strtotime($cronograma->puesta_en_marcha_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->puesta_en_marcha_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->puesta_en_marcha_fin)) }}, {{ date('m', strtotime($cronograma->puesta_en_marcha_fin)) - 1 }}, {{ date('d', strtotime($cronograma->puesta_en_marcha_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->puesta_en_marcha_inicio }}', '{{ $cronograma->puesta_en_marcha_fin }}'),
                    null
                ],
                ['certificado_retie', 'Certificado RETIE',
                    new Date({{ date('Y', strtotime($cronograma->certificado_RETIE_inicio)) }}, {{ date('m', strtotime($cronograma->certificado_RETIE_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->certificado_RETIE_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->certificado_RETIE_fin)) }}, {{ date('m', strtotime($cronograma->certificado_RETIE_fin)) - 1 }}, {{ date('d', strtotime($cronograma->certificado_RETIE_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->certificado_RETIE_inicio }}', '{{ $cronograma->certificado_RETIE_fin }}'),
                    null
                ],
                ['visita_operador_red', 'Visita del operador de red',
                    new Date({{ date('Y', strtotime($cronograma->visita_operador_de_red_inicio)) }}, {{ date('m', strtotime($cronograma->visita_operador_de_red_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->visita_operador_de_red_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->visita_operador_de_red_fin)) }}, {{ date('m', strtotime($cronograma->visita_operador_de_red_fin)) - 1 }}, {{ date('d', strtotime($cronograma->visita_operador_de_red_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->visita_operador_de_red_inicio }}', '{{ $cronograma->visita_operador_de_red_fin }}'),
                    null
                ],
                ['instalacion_medidor', 'Instalación del medidor bidireccional',
                    new Date({{ date('Y', strtotime($cronograma->instalacion_medidor_bidireccional_inicio)) }}, {{ date('m', strtotime($cronograma->instalacion_medidor_bidireccional_inicio)) - 1 }}, {{ date('d', strtotime($cronograma->instalacion_medidor_bidireccional_inicio)) }}),
                    new Date({{ date('Y', strtotime($cronograma->instalacion_medidor_bidireccional_fin)) }}, {{ date('m', strtotime($cronograma->instalacion_medidor_bidireccional_fin)) - 1 }}, {{ date('d', strtotime($cronograma->instalacion_medidor_bidireccional_fin)) }}),
                    null,
                    calculateCompletion('{{ $cronograma->instalacion_medidor_bidireccional_inicio }}', '{{ $cronograma->instalacion_medidor_bidireccional_fin }}'),
                    null
                ]
            ]);
        

            var options = {
                height: 600,
                gantt: {
                    criticalPathEnabled: false, 
                    trackHeight: 30
                }
            };

            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            chart.draw(data, options);

            // Aplicar CSS después de renderizar el gráfico
            document.getElementById('chart_div').querySelectorAll('text').forEach(function(textElement) {
                textElement.setAttribute('text-anchor', 'start'); // Alineación a la izquierda
            });
        }
    </script>



<style>
        /* Opcional: Agrega estilos para ocultar el botón */
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('base')
@include('proyectos.crear')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <h4 class="font-weight-normal mt-3" style="text-align: center;">Información del Proyecto</h4>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">NIC:</label></td>
                                    <td><label style="color: black; border: none;">{{$C_NIC}}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Nombre:</label></td>
                                    <td><label style="color: black; border: none;">{{$C_nombre}}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Tipo de cliente:</label></td>
                                    <td><label style="color: black; border: none;">{{$C_tipo}}</label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Ciudad:</label></td>
                                    <td><label style="color: black; border: none;">{{$C_ciudad}}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Dirección:</label></td>
                                    <td><label style="color: black; border: none;">{{$C_direccion}}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Radiación:</label></td>
                                    <td><label style="color: black; border: none;">{{ number_format($L_radiacion, 0,',', '.') }}</label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Tarifa $/kWh:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($C_tarifa, 0,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Consumo actual $/kWh:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($C_vconsumo, 0,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">kW para el 100%:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{$P_kW}}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Valor consumo de energía $:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($C_consumo, 0,',', '.') }}</label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-4">
            <h4 class="font-weight-normal mt-3" style="text-align: center; color: black;">Cronograma del Proyecto</h4>
            <input type="text" name="id_propuesta" value="{{$codi}}" hidden>

            <input type="text" name="id_propuesta" id="id_propuesta" value="{{$codi}}" hidden>

    <div class="row" style="margin-bottom: 100px;">
        <div style="text-align: center;">
            <div>
                <div style="margin: 0 auto; display: inline-block; color: black;">
                    <button id="registerButton" type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#cronograma">
                        Registrar cronograma
                    </button>
                </div>
            </div>
        </div>
    </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div id="chart_div"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var idPropuesta = document.getElementById('id_propuesta').value;
            var registerButton = document.getElementById('registerButton');
            
            if (idPropuesta) {
                registerButton.classList.add('hidden');
            }
        });
    </script>
    @endsection