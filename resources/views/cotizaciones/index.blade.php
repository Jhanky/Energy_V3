@extends('layout.plantilla')

@section('title')
Cotizaciones
@endsection

@section('header')

@endsection

@section('base')
<div class="row">
    @include('layout.msj')
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Cotizaciones</h6>
                </div>
            </div>
            <div class="card">
                @if (session('mensajesErrores'))
                <div class="modal fade show" id="modal-graphics-error" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-modal="true" style="display: block;">
                    <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <img src="{{ asset('img/icons/flags/warning.png') }}" alt="Icono de error" style="max-width: 90px; max-height: 90px;">
                                    <h4 class="text-gradient text-danger mt-4">¡Faltan las gráficas!</h4>
                                </div>
                                <div class="row mb-0">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal" onclick="closeModal()">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="table-responsive">
                    <table id="dataTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Nombre del proyecto</th>
                                <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">Tipo de cliente</th>
                                <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">kW Cotizados</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Presupuesto</th>
                                @if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Responsable</th>
                                @endif
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Estado</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Fecha</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presupuestos as $result)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $result->nombre_proyecto }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $result->tipo_cliente }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ number_format($result->sugerida, 2, ',', '.') }}kW</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"><b> $ {{ number_format($result->TOTAL_PROYECTO, 0, ',', '.') }}</b></p>
                                </td>
                                @if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $result->name }}</p>
                                </td>
                                @endif
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
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $result->updated_at ? $result->updated_at->format('d/m/Y') : $result->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $result->id }}">
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
                                            <button type="button" class=" btn btn-info" data-bs-toggle="modal" data-bs-target="#grafica{{ $result->id }}">
                                                Subir Gráficas<i class="material-icons opacity-10">upload</i>
                                            </button>
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
                            <div class="modal fade" id="modal-notification-{{ $result->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar la propuesta!</h4>
                                                <p>Si confirma se eliminara el proyecto <b>{{ $result->nombre_proyecto }}</b></p>
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
                            @include('cotizaciones.graficas')

                            @endforeach
                        </tbody>
                    </table>
                </div>

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

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");

        // Recorre todas las filas de la tabla
        for (i = 0; i < tr.length; i++) {
            tdNIC = tr[i].getElementsByTagName("td")[0]; // Columna de NIC
            tdNombre = tr[i].getElementsByTagName("td")[1]; // Columna de Nombre
            tdTipoCliente = tr[i].getElementsByTagName("td")[2]; // Columna de Tipo de Cliente
            tdResponsable = tr[i].getElementsByTagName("td")[4]; // Columna de Tipo de Cliente

            if (tdNombre || tdTipoCliente || tdNIC || tdResponsable) {
                txtValueNIC = tdNIC.textContent || tdNombre.innerText;
                txtValueNombre = tdNombre.textContent || tdNombre.innerText;
                txtValueTypeCliente = tdTipoCliente.textContent || tdTipoCliente.innerText;
                txtValueResponsable = tdResponsable.textContent || tdTipoResponsable.innerText;

                // Compara el valor de búsqueda con los textos en ambas columnas
                if (txtValueNombre.toUpperCase().indexOf(filter) > -1 || txtValueTypeCliente.toUpperCase().indexOf(filter) > -1 || txtValueNIC.toUpperCase().indexOf(filter) > -1 || txtValueResponsable.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    document.getElementById("searchInput").addEventListener("keyup", filterTable);
</script>

<script>
    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('modal-graphics-error').style.display = 'none';
    }
</script>

@endsection