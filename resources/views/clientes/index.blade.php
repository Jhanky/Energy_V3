@extends('layout.plantilla')

@section('title')
    Cliente
@endsection

@section('header')
@endsection

@section('base')
    <div class="row">
        @include('clientes.crear')
        @include('layout.msj')
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Clientes</h6>
                    <div class="me-3">
                        <!-- Button trigger modal -->
                            <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                data-bs-target="#agregarPanel">
                                Agregar cliente
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    @if (session('duplicateNIC'))
                        <div class="modal fade show" id="modal-duplicate-nic" tabindex="-1" role="dialog"
                            aria-labelledby="modal-notification" aria-modal="true" style="display: block;">
                            <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="py-3 text-center">
                                            <img src="{{ asset('img/icons/alerta.png') }}" alt="Icono de error"
                                                style="max-width: 90px; max-height: 90px;">
                                            <h4 class="text-gradient text-danger mt-4">¡El NIC ya está registrado!</h4>

                                        </div>
                                        <div class="row mb-0">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <button type="button" class="btn bg-gradient-secondary"
                                                    data-bs-dismiss="modal" onclick="closeModal()">Cerrar</button>
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
                                    <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">NIC
                                    </th>
                                    <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Nombre</th>
                                    <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">Tipo
                                        de cliente</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ciudad
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                        Consumo actual $/kWh</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Tarifa
                                    </th>
                                    @if (auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Responsable</th>
                                    @endif
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                        Opciones</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($clientes as $list)
                            <tr>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->NIC }}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->nombre }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->tipo_cliente }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->ciudad }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ number_format($list->consumo_actual, 0, ',', '.') }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">$ {{ number_format($list->tarifa, 0, ',', '.') }}</p>
                                </td>
                                @if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->name }}</p>
                                </td>
                                @endif
                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $list->id }}">
                                                Eliminar <i class="material-icons opacity-10">delete</i>
                                            </button>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="button" class=" btn btn-info" rel="tooltip" data-bs-toggle="modal" data-bs-target="#EditCliente{{ $list->NIC }}">
                                                Editar <i class="material-icons opacity-10">edit</i>
                                            </button>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <form action="{{ route('cliente.informacion', ['id' => $list->NIC]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class=" btn btn-info">
                                                    ver mas <i class="material-icons opacity-10">visibility</i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-notification-{{ $list->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar este cliente!</h4>
                                                <p>Si borra el cliente todos los proyectos del cliente se borraran</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('cliente.eliminar', $list->NIC) }}" method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('clientes.editar')
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
                tdResponsable = tr[i].getElementsByTagName("td")[6]; // Columna de Tipo de Cliente

                if (tdNombre || tdTipoCliente || tdNIC || tdResponsable) {
                    txtValueNIC = tdNIC.textContent || tdNIC.innerText;
                    txtValueNombre = tdNombre.textContent || tdNombre.innerText;
                    txtValueTypeCliente = tdTipoCliente.textContent || tdTipoCliente.innerText;
                    txtValueResponsable = tdResponsable.textContent || tdResponsable.innerText;

                    // Compara el valor de búsqueda con los textos en ambas columnas
                    if (txtValueNombre.toUpperCase().indexOf(filter) > -1 || txtValueTypeCliente.toUpperCase().indexOf(
                            filter) > -1 || txtValueNIC.toUpperCase().indexOf(filter) > -1 || txtValueResponsable
                        .toUpperCase().indexOf(filter) > -1) {
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
        document.addEventListener("DOMContentLoaded", function() {
            // Obtiene la fecha actual
            var fechaActual = new Date();
            // Formatea la fecha en el formato deseado (AAAA-MM-DD)
            var fechaFormateada = formatDate(fechaActual);
            // Establece el valor del campo de entrada oculto
            document.getElementById("created_at").value = fechaFormateada;
        });
        // Función para formatear la fecha en el formato AAAA-MM-DD
        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');

            return year + '-' + month + '-' + day;
        }
    </script>

    <script>
        function seleccionarDepartamento() {
            var ciudadSeleccionada = document.getElementById("selectCiudades_e").value;
            var departamentoSelect = document.getElementById("selectDepartamentos_e");

            // Buscar la opción correspondiente al departamento de la ciudad seleccionada
            var opcionesDepartamento = departamentoSelect.options;
            for (var i = 0; i < opcionesDepartamento.length; i++) {
                var ciudadDepartamento = opcionesDepartamento[i].getAttribute('data-ciudades');
                if (ciudadDepartamento && ciudadDepartamento.includes(ciudadSeleccionada)) {
                    departamentoSelect.selectedIndex = i;
                    break;
                }
            }
        }

        function filtrarCiudades2() {
            var departamentoSeleccionado = document.getElementById("selectDepartamentos_e").value;
            var ciudades = document.querySelectorAll("#selectCiudades_e option");

            ciudades.forEach(function(ciudad) {
                if (ciudad.dataset.departamento === departamentoSeleccionado || ciudad.dataset.departamento ===
                    undefined) {
                    ciudad.style.display = "block";
                } else {
                    ciudad.style.display = "none";
                }
            });

            // Habilitar la primera opción válida
            var primeraOpcionVisible = document.querySelector("#selectCiudades_e option[style='display: block;']");
            primeraOpcionVisible.selected = true;

            // Seleccionar automáticamente el departamento correspondiente a la ciudad seleccionada
            seleccionarDepartamento();
        }

        // Llamar a la función filtrarCiudades al cargar la página para establecer el estado inicial
        filtrarCiudades2();
    </script>

    <script>
        function seleccionarDepartamento() {
            var ciudadSeleccionada2 = document.getElementById("selectCiudades").value;
            var departamentoSelect2 = document.getElementById("selectDepartamentos");

            // Buscar la opción correspondiente al departamento de la ciudad seleccionada
            var opcionesDepartamento = departamentoSelect2.options;
            for (var i = 0; i < opcionesDepartamento.length; i++) {
                var ciudadDepartamento = opcionesDepartamento[i].getAttribute('data-ciudades');
                if (ciudadDepartamento && ciudadDepartamento.includes(ciudadSeleccionada2)) {
                    departamentoSelect2.selectedIndex = i;
                    break;
                }
            }
        }

        function filtrarCiudades() {
            var departamentoSeleccionado = document.getElementById("selectDepartamentos").value;
            var ciudades = document.querySelectorAll("#selectCiudades option");

            ciudades.forEach(function(ciudad) {
                if (ciudad.dataset.departamento === departamentoSeleccionado || ciudad.dataset.departamento ===
                    undefined) {
                    ciudad.style.display = "block";
                } else {
                    ciudad.style.display = "none";
                }
            });

            // Habilitar la primera opción válida
            var primeraOpcionVisible = document.querySelector("#selectCiudades option[style='display: block;']");
            primeraOpcionVisible.selected = true;

            // Seleccionar automáticamente el departamento correspondiente a la ciudad seleccionada
            seleccionarDepartamento();
        }

        // Llamar a la función filtrarCiudades al cargar la página para establecer el estado inicial
        filtrarCiudades();
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                "pageLength": 10,
                "searching": true,
                "ordering": false, // Desactiva el ordenamiento
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
        function closeModal() {
            document.getElementById('modal-duplicate-nic').style.display = 'none';
        }
    </script>

    <script>
        let page = 1;

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                page++;
                loadMoreData(page);
            }
        });

        function loadMoreData(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: 'get',
                    beforeSend: function() {
                        $('#loader').show();
                    }
                })
                .done(function(data) {
                    if (data == "") {
                        $('#loader').html("No hay más clientes disponibles");
                        return;
                    }
                    $('#loader').hide();
                    $("#clienteData").append(data);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log("Error al cargar datos", thrownError);
                });
        }
    </script>
@endsection
