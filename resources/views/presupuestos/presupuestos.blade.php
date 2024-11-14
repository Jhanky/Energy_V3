@extends('layouts.main')

@section('title')
Presupuestos
@endsection

@section('base')
<main>
    @include('presupuestos.inversor')
    @include('presupuestos.microinversor')
    <div class="row">
        <h4 style="color: black; margin-bottom: 20px;"><b>Información del cliente</b></h4>
        <br>
        <div class="col">
            <table>
                <tr>
                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">NIC</label></td>
                    <td><label style="color: black; border: none;">{{ $cliente->NIC }}</label></td>
                </tr>
                <tr>
                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Nombre</label></td>
                    <td><label style="color: black; border: none;">{{ $cliente->nombre }}</label></td>
                </tr>
                <tr>
                    <td style="padding-right: 10px;"><label class="font-weight-bold" style="color: black; border: none;">Tipo de cliente:</label></td>
                    <td><label style="color: black; border: none;">{{ $cliente->tipo_cliente }}</label></td>
                </tr>
            </table>
        </div>
        <div class="col">
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
        <div class="col">

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
    <br>

    <div class="row justify-content-center"> <!-- Centro las columnas -->
        <div class="col text-center"> <!-- Alineo el contenido al centro -->
            <div class="card mx-auto" style="width: 18rem;"> <!-- Añado la clase 'mx-auto' para centrar la tarjeta -->
                <img src="{{ asset('img/inversor.png') }}" class="card-img-top mx-auto" alt="..."> <!-- Alineo la imagen al centro -->
                <div class="card-body text-center"> <!-- Alineo el contenido a la derecha -->
                    <form class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success" rel="tooltip" data-bs-toggle="modal" data-bs-target="#CrearCotizacion" style="margin-bottom: 20px;" id="cotizar1">
                            Cotizar con Inversor centralizado
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col text-center"> <!-- Alineo el contenido al centro -->
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



    <br>
    @include('layouts.msj')
    <div class="table-responsive" id="tabla">
        <table class="table table-bordered border-success" id="dataTable" width="100%" cellspacing="0">
            <thead class="table-success border-success">
                <tr>
                    <th style="color: black;"><b>Código</b></th>
                    <th style="color: black;"><b>Nombre del proyecto</b></th>
                    <th style="color: black;"><b>Panel solar</b></th>
                    <th style="color: black;"><b>Inversor</b></th>
                    <th style="color: black;"><b>Bateria</b></th>
                    <th style="color: black;"><b>kW cotizado</b></th>
                    <th style="color: black;"><b>Presupuesto</b></th>
                    <th style="color: black; text-align: center;"><b>Estado</b></th>
                    <th style="color: black;"><b>Opciones</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                <tr>
                    <td style="color: black;">{{ $result->codigo_propuesta }}</td>
                    <td style="color: black;">{{ $result->nombre_proyecto }}</td>
                    <td style="color: black;">{{ $result->solar_panel_marca }}({{ $result->numero_paneles }})</td>
                    <td style="color: black;">{{ $result->investor_marca }}({{ $result->numero_inversores }})</td>
                    <td style="color: black;">{{ $result->batterie_marca ?? 'Sin bateria' }} ({{ $result->numero_baterias ?? '0' }}) </td>
                    <td style="color: black;">{{ number_format($result->instalada, 2, ',', '.') }}kW</td>
                    <td id="presupuesto" style="color: black; "><b> ${{ number_format($result->TOTAL_PROYECTO, 0, ',', '.') }} </b></td>
                    <td style="text-align: center;">
                        <select class="form-select estado @if($result->nombre_estado == 'PENDIENTE') btn-light
                                    @elseif($result->nombre_estado == 'DISEÑADA') btn-primary
                                    @elseif($result->nombre_estado == 'REVISIÓN') btn-secondary
                                    @elseif($result->nombre_estado == 'ENVIADO') btn-secondary
                                    @elseif($result->nombre_estado == 'NEGOCIACIONES') btn-warning
                                    @elseif($result->nombre_estado == 'AJUSTAR PROPUESTA') btn-info
                                    @elseif($result->nombre_estado == 'CONTRATADO') btn-success
                                    @elseif($result->nombre_estado == 'DESCARTADO') btn-danger
                                    @elseif($result->nombre_estado == 'PAUSADO') btn-dark
                                    @endif" aria-label="Default select example" onchange="actualizarEstado(this, '{{ $result->id }}')" data-csrf="{{ csrf_token() }}">
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
                    <td style="text-align: center;">
                        <form action="{{ route('presupuestos.eliminar', $result->id) }}" method="POST" style="display: inline-block;" id="eliminar">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" rel="tooltip" onclick="return confirm('Seguro que quiere eliminar este cliente?') ">
                                <i class="fas fa-trash-alt" title="Eliminar Registro"></i>
                            </button>
                        </form>

                        <form action="{{ route('presupuestos.info', ['id' => $result->id]) }}" method="POST" style="display: inline-block;" id="ver">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</main>
@endsection

@section('scripts')
<script>
    function actualizarEstado(selectElement, id) {
        var nuevoEstado = selectElement.value;
        var csrfToken = selectElement.dataset.csrf;

        var xhr = new XMLHttpRequest();
        var url = '/actualizar-estado/' + id;

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Estado actualizado exitosamente');
                // Actualizar el color del select
                actualizarColor(selectElement, nuevoEstado);
            } else {
                console.error('Error al actualizar el estado');
            }
        };

        var data = JSON.stringify({
            id_estado: nuevoEstado
        });

        xhr.send(data);

        // Mostrar u ocultar opciones según el estado seleccionado
        mostrarOpciones(selectElement, nuevoEstado);
    }

    function actualizarColor(selectElement, nuevoEstado) {
        // Remover todas las clases de estado
        selectElement.classList.remove('btn-primary', 'btn-secondary', 'btn-warning', 'btn-success', 'btn-danger');

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
            case 9: // DESCARTADO
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