@extends('layout.plantilla')

@section('title')
Dasboard
@endsection

@section('header')
<style>
    .input-group {
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>
@endsection

@section('base')
<div class="row">
    @include('cotizaciones.inversor')
    <div class="col-12">
        <div class="card my-4">
            <h4 class="font-weight-normal mt-3" style="text-align: center;">Información del cliente</h4>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">NIC:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->NIC }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Nombre:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->nombre }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Tipo de cliente:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->tipo_cliente }}</label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Ciudad:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->ciudad }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Dirección:</label></td>
                                    <td><label style="color: black; border: none;">{{ $cliente->direccion }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Radiación:</label></td>
                                    <td><label style="color: black; border: none;">{{ number_format($radiacion, 0,',', '.') }}</label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
                            <table>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Tarifa $/kWh:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($cliente->tarifa, 0,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Consumo actual $/kWh:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($cliente->consumo_actual, 0,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">kW para el 100%:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($promedio, 2,',', '.') }}</label></td>
                                </tr>
                                <tr>
                                    @php
                                    $valor_luz = $cliente->tarifa * $cliente->consumo_actual
                                    @endphp
                                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black;">Valor consumo de energía $:</label></td>
                                    <td style="text-align: right;"><label style="color: black;">{{ number_format($valor_luz, 0,',', '.') }}</label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center"> <!-- Agregamos la clase justify-content-center para centrar el contenido horizontalmente -->
                <div class="col-sm">
                    <div class="card mx-auto" style="width: 18rem;"> <!-- Añado la clase 'mx-auto' para centrar la tarjeta -->
                        <img src="{{ asset('img/inversor.png') }}" class="card-img-top mx-auto" alt="..."> <!-- Alineo la imagen al centro -->
                        <div class="card-body text-center"> <!-- Alineo el contenido a la derecha -->
                            <form class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success" rel="tooltip" data-bs-toggle="modal" data-bs-target="#inversor" style="margin-bottom: 20px;" id="cotizar1">
                                    Cotizar con Inversor centralizado
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card mx-auto" style="width: 18rem;"> <!-- Añado la clase 'mx-auto' para centrar la tarjeta -->
                        <img src="{{ asset('img/microinversor.png') }}" class="card-img-top mx-auto" alt="..."> <!-- Alineo la imagen al centro -->
                        <div class="card-body text-center"> <!-- Alineo el contenido a la derecha -->
                            <form class="d-flex justify-content-center">
                                <button disabled type="button" class="btn btn-success" rel="tooltip" data-bs-toggle="modal" data-bs-target="#microinversor" style="margin-bottom: 20px;" id="cotizar2">
                                    Cotizar con Micro inversores
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0" style="text-align: center;">Cotizaciones del cliente</h6>
                </div>
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Nombre del proyecto</th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Panel</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inversor</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Batería</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">kW cotizado</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Presupuesto</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $result->nombre_proyecto }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $result->solar_panel_marca }} ({{$result->numero_paneles}})</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $result->investor_marca }} ({{$result->numero_inversores}})</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"><b>{{ $result->batterie_marca }} ({{$result->numero_baterias ?? 0}})</b></p>
                                </td>

                                <td class="align-middle text-center text-sm">
                                    @php
                                    $kw = ($result->numero_paneles * $result->poder)/1000;
                                    @endphp
                                    <p class="text-xs font-weight-bold mb-0">{{ number_format($kw, 2, ',', '.') }}kW</p>
                                </td>

                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"><b>$ {{ number_format($result->TOTAL_PROYECTO, 0, ',', '.') }}</b></p>
                                </td>

                                <td class="fila_estado" style="text-align: center;">
                                    <select class="estado @if($result->nombre_estado == 'PENDIENTE')btn btn-light
        @elseif($result->nombre_estado == 'DISEÑADA')btn btn-info
        @elseif($result->nombre_estado == 'REVISIÓN')btn btn-secondary
        @elseif($result->nombre_estado == 'ENVIADO')btn btn-secondary
        @elseif($result->nombre_estado == 'NEGOCIACIONES')btn btn-warning
        @elseif($result->nombre_estado == 'AJUSTAR PROPUESTA')btn btn-info
        @elseif($result->nombre_estado == 'CONTRATADO')btn btn-success
        @elseif($result->nombre_estado == 'DESCARTADO')btn btn-danger
        @elseif($result->nombre_estado == 'PAUSADO')btn btn-dark
        @endif" aria-label="Default select example" onchange="actualizarEstado(this, '{{ $result->id }}')" data-csrf="{{ csrf_token() }}" data-total-proyecto="{{ $result->TOTAL_PROYECTO }}">
                                        <option value="1" @if($result->nombre_estado == 'PENDIENTE') selected @endif>PENDIENTE</option>
                                        <option value="2" @if($result->nombre_estado == 'DISEÑADA') selected @endif>DISEÑADA</option>
                                        <option value="3" @if($result->nombre_estado == 'REVISIÓN') selected @endif>REVISIÓN</option>
                                        <option value="4" @if($result->nombre_estado == 'ENVIADO') selected @endif>ENVIADO</option>
                                        <option value="5" @if($result->nombre_estado == 'NEGOCIACIONES') selected @endif>NEGOCIACIONES</option>
                                        <option value="6" @if($result->nombre_estado == 'AJUSTAR PROPUESTA') selected @endif>AJUSTAR PROPUESTA</option>
                                        <option value="7" @if($result->nombre_estado == 'CONTRATADO') selected @endif>CONTRATADO</option>
                                        <option value="8" @if($result->nombre_estado == 'DESCARTADO') selected @endif>DESCARTADO</option>
                                        <option value="9" @if($result->nombre_estado == 'PAUSADO') selected @endif>PAUSADO</option>
                                    </select>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $result->nombre_proyecto }}">
                                                Eliminar<i class="material-icons opacity-10">delete</i>
                                            </button>
                                        </li>

                                        <li style="margin-left: 30px; margin-right: 30px">
                                        <form action="{{ route('pdf.pdf', ['id' => $result->id]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">
                                                    Descargar<i class="material-icons opacity-10">download</i>
                                                </button>
                                            </form>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <form action="{{ route('cotizaciones.info', ['id' => $result->id]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-info" rel="tooltip" data-bs-toggle="modal" data-bs-target="#EditInversor{{ $result->id }}">
                                                    Ver más<i class="material-icons opacity-10">visibility</i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-notification-{{ $result->nombre_proyecto }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar el Inversor!</h4>
                                                <p>Si borra el cable todos los proyectos se veran afectados</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('presupuestos.eliminar', $result->id) }}" method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        function actualizarEstado(selectElement, id) {
            var nuevoEstado = selectElement.value;
            var csrfToken = selectElement.dataset.csrf;
            var totalProyecto = selectElement.dataset.totalProyecto; // Obtener el valor de TOTAL_PROYECTO

            var xhr = new XMLHttpRequest();
            var url = '/public/actualizar-estado/' + id;

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Estado actualizado exitosamente');
                    // Actualizar el color del select
                    actualizarColor(selectElement, nuevoEstado);
                    // Mostrar u ocultar opciones según el estado seleccionado
                    mostrarOpciones(selectElement, nuevoEstado);

                    // Si el nuevo estado es CONTRATADO, actualizar presupuesto_total en la base de datos
                    if (nuevoEstado === '7') { // '7' es el valor para CONTRATADO
                        actualizarPresupuestoTotal(id, totalProyecto);
                    }
                } else {
                    console.error('Error al actualizar el estado');
                }
            };

            var data = JSON.stringify({
                id_estado: nuevoEstado,
                presupuesto_total: totalProyecto // Enviar presupuesto_total cuando se selecciona CONTRATADO
            });

            xhr.send(data);
        }

        function actualizarColor(selectElement, nuevoEstado) {
            // Remover todas las clases de estado
            selectElement.classList.remove('btn-light', 'btn-info', 'btn-secondary', 'btn-warning', 'btn-primary', 'btn-success', 'btn-danger', 'btn-dark');

            // Agregar la clase de estado correspondiente al nuevo estado
            switch (parseInt(nuevoEstado)) {
                case 1:
                    selectElement.classList.add('btn-light');
                    break;
                case 2:
                    selectElement.classList.add('btn-primary');
                    break;
                case 3:
                    selectElement.classList.add('btn-secondary');
                    break;
                case 4:
                    selectElement.classList.add('btn-secondary');
                    break;
                case 5:
                    selectElement.classList.add('btn-warning');
                    break;
                case 6:
                    selectElement.classList.add('btn-info');
                    break;
                case 7:
                    selectElement.classList.add('btn-success');
                    break;
                case 8:
                    selectElement.classList.add('btn-danger');
                    break;
                case 9:
                    selectElement.classList.add('btn-dark');
                    break;
                default:
                    break;
            }
        }

        function mostrarOpciones(selectElement, nuevoEstado) {
            var opciones = selectElement.querySelectorAll('option');

            // Ocultar todas las opciones
            opciones.forEach(function(opcion) {
                opcion.style.display = 'none';
            });

            // Mostrar solo las opciones correspondientes al nuevo estado
            switch (parseInt(nuevoEstado)) {
                case 1: // PENDIENTE
                    mostrarOpcion(selectElement, ['2']);
                    break;
                case 2: // DISEÑADA
                    mostrarOpcion(selectElement, ['4']);
                    break;
                case 3: // REVISIÓN
                    mostrarOpcion(selectElement, ['4']);
                    break;
                case 4: // ENVIADO
                    mostrarOpcion(selectElement, ['5']);
                    break;
                case 5: // NEGOCIACIONES
                    mostrarOpcion(selectElement, ['6', '7', '8', '9']);
                    break;
                case 6: // AJUSTAR
                    mostrarOpcion(selectElement, ['3']);
                    break;
                case 7: // CONTRATADO
                    break;
                case 8: // DESCARTADO
                    break;
                case 9: // PAUSADO
                    mostrarOpcion(selectElement, ['5', '8']);
                    break;
                default:
                    break;
            }
        }

        function mostrarOpcion(selectElement, valores) {
            valores.forEach(function(valor) {
                var opcion = selectElement.querySelector('option[value="' + valor + '"]');
                if (opcion) {
                    opcion.style.display = 'block';
                }
            });
        }

        // Ejecutar la función de inicialización al cargar el DOM
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener todos los elementos select con la clase "estado"
            var selectElements = document.querySelectorAll('.estado');

            // Iterar sobre cada elemento select
            selectElements.forEach(function(selectElement) {
                // Ejecutar la función mostrarOpciones al cargar el DOM
                mostrarOpciones(selectElement, selectElement.value);
            });
        });
    </script>
    @endsection