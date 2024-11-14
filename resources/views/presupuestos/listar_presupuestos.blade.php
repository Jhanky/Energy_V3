@extends('layouts.main')

@section('title')
Presupuesto
@endsection

@section('base')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4" style="color: black;"><b>Cotizaciones</b></h1>
        @include('layouts.msj')
        @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
        @endif
        <div class="row">
            <div class="table-responsive" id="tabla">
                <!-- Contenedor de la animación de carga y mensaje de éxito -->

                <table id="dataTable" class="table table-bordered border-success datatable" width="100%" cellspacing="0">
                    <thead class="table-success border-success">
                        <tr>
                            <th style="color: black;"><b>Código</b></th>
                            <th style="color: black;"><b>Nombre del proyecto</b></th>
                            <th style="color: black;"><b>Tipo de cliente</b></th>
                            <th style="color: black;"><b>kW cotizado</b></th>
                            <th style="color: black;"><b>Presupuesto</b></th>
                            <th style="color: black;"><b>Estado</b></th>
                            @php
                            $userRoles = auth()->user()->roles->pluck('name')->toArray(); // Obtener los roles del usuario actual
                            @endphp
                            @unless(in_array('COMERCIAL', $userRoles))
                            <th style="color: black;"><b>Responsable</b></th>
                            @endunless
                            <th style="color: black; text-align: center"><b>Fecha</b></th>
                            <th style="color: black; text-align: center;"><b>Opciones</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $result)
                        <tr>
                            <td style="color: black;">{{ $result->codigo_propuesta }}</td>
                            <td style="color: black;">{{ $result->nombre_proyecto }}</td>
                            <td style="color: black;">{{ $result->tipo_cliente }}</td>
                            <td style="color: black;">{{ number_format($result->sugerida, 2, ',', '.') }}kW</td>
                            <td id="presupuesto" style="color: black;"><b> $ {{ number_format($result->TOTAL_PROYECTO, 0, ',', '.') }}</b></td>
                            <td class="fila_estado_{{ $result->tarjeta }}" style="text-align: center;">
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
                            @unless(in_array('COMERCIAL', $userRoles))
                            <td style="color: black; text-align: center;"><b>{{ $result->name }}</b></td>
                            @endunless
                            <td style="color: black; text-align: center;">
                                {{ $result->updated_at ? $result->updated_at->format('d/m/Y') : $result->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <form action="{{ route('presupuestos.eliminar', $result->id) }}" method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item btn btn-danger" onclick="return confirm('¿Seguro que quiere eliminar este presupuesto?') ">
                                                <i class="fas fa-trash-alt delete-icon" title="Eliminar Registro"></i> Eliminar
                                            </button>
                                        </form>

                                        <form action="{{ route('pdf.pdf', ['id' => $result->id]) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="dropdown-item btn btn-primary">
                                                <i class="fa fa-download pdf-icon" aria-hidden="true"></i> Descargar PDF
                                            </button>
                                        </form>
                                        <button type="button" class="dropdown-item btn btn-info" data-bs-toggle="modal" data-bs-target="#grafica{{ $result->id }}">
                                            <i class="fa-solid fa-image subir-icon" aria-hidden="true"></i> Subir Gráficas
                                        </button>
                                        <form action="{{ route('presupuestos.info', ['id' => $result->id]) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="dropdown-item btn btn-success">
                                                <i class="fa-solid fa-eye view-icon"></i> Ver Detalles
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @include('presupuestos.graficas')
                        @endforeach

                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
</main>
@endsection

@section('scripts')
<script>
    function actualizarEstado(selectElement, id) {
        var nuevoEstado = selectElement.value;
        var csrfToken = selectElement.dataset.csrf;

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
        selectElement.classList.remove('btn-light', 'btn-primary', 'btn-secondary', 'btn-warning', 'btn-info', 'btn-success', 'btn-danger', 'btn-dark');

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

<script>
    window.onload = function() {
        // Cierra el modal de carga
        $('#modal-carga').modal('hide');
    };
</script>

<script>
    $('.button').click(function() {
        var buttonId = $(this).attr('id');
        $('#modal-container').removeAttr('class').addClass(buttonId);
        $('body').addClass('modal-active');
    })

    $('#modal-container').click(function() {
        $(this).addClass('out');
        $('body').removeClass('modal-active');
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

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "paging": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "pageLength": 10,
            "searching": true,
            "ordering": true,
            "order": [
                [0, "desc"]
            ], // Ordena la segunda columna (índice 1) de manera descendente al cargar la página
            "info": true,
            "autoWidth": false,
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "info": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)"
            }
        });

        $('#filtroEstado').change(function() {
            var estadoSeleccionado = this.value;
            table.column(5).search(estadoSeleccionado).draw();
        });
    });
</script>

<script>
    document.getElementById('calcular').addEventListener('click', function() {
        // Obtener el valor del input
        const valorCotizar = document.getElementById('cotizar').value;

        // Obtener el panel seleccionado y su poder
        const selectPanel = document.getElementById('selectPanel');
        const selectedOption = selectPanel.options[selectPanel.selectedIndex];
        const panelPower = selectedOption.getAttribute('data-power');

        // Verificar que se haya seleccionado un panel y se haya ingresado un valor
        if (valorCotizar && panelPower) {
            // Convertir valores a números
            const valorCotizarNum = parseFloat(valorCotizar);
            const panelPowerNum = parseFloat(panelPower);

            // Realizar el cálculo
            const resultado = Math.round((valorCotizarNum * 1000) / panelPowerNum);

            // Mostrar el resultado
            document.getElementById('resultado').innerText = resultado;
        } else {
            alert('Por favor, ingrese un valor y seleccione un panel.');
        }
    });
</script>

<!-- CSS de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
@endsection