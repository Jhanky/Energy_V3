@extends('layout.plantilla')

@section('title')
    Ordenes de servicio
@endsection

@section('header')
    <style>
        .btn-spacing {
            margin-right: 10px;
            /* Espaciado entre botones */
        }

        .btn-spacing:last-child {
            margin-right: 0;
            /* Quita el margen del último botón */
        }
    </style>
@endsection

@section('base')
    <div class="row">
        @include('actas.crear_orden')
        @include('layout.msj')
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Ordenes de servicio</h6>
                        <div class="me-3">
                            <!-- Button trigger modal -->
                            @if (auth()->user()->hasRole('ADMINISTRADOR'))
                                <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal"
                                    data-bs-target="#agregarOrden">
                                    Crear orden
                                </button>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-xxs text-secondary font-weight-bolder text-center">Tipo
                                        de servicio</th>
                                    <th class="text-uppercase text-xxs text-secondary font-weight-bolder text-center">
                                        Responsables</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                        Dirección</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Fecha
                                        de ejecución</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Estado
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                        Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">Limpieza de paneles</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-spacing">Esneider</button>
                                        <button type="button" class="btn btn-info btn-spacing">Gian</button>
                                        <button type="button" class="btn btn-info btn-spacing">Torres</button>
                                        <button type="button" class="btn btn-info btn-spacing">Peres</button>
                                    </td>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">Carrera 12 #23-43</p>
                                    </td>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">09/11/2024</p>
                                    </td>
                                    <td class="fila_estado" style="text-align: center;">
                                        <button type="button" class="btn btn-secondary">Pendiente</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class="btn bg-gradient-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li style="margin-left: 30px; margin-right: 30px">
                                                <button type="submit" class="btn btn-info" rel="tooltip"
                                                    data-bs-toggle="modal">
                                                    Ver más<i class="material-icons opacity-10">visibility</i>
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">Montura de paneles</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-spacing">Torres</button>
                                    </td>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">Calle 9 #3B-22</p>
                                    </td>
                                    <td class="align-middle text-center ">
                                        <p class="text-xs font-weight-bold mb-0">15/12/2024</p>
                                    </td>
                                    <td class="fila_estado" style="text-align: center;">
                                        <button type="button" class="btn btn-secondary">Pendiente</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class="btn bg-gradient-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li style="margin-left: 30px; margin-right: 30px">
                                                <button type="submit" class="btn btn-info" rel="tooltip"
                                                    data-bs-toggle="modal">
                                                    DEscargar orden<i class="material-icons opacity-10">visibility</i>
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (auth()->user()->hasRole('COMERCIAL'))
                <div class="card my-4" style="display: flex; justify-content: center; align-items: center; height: 800px;">
                    <img src="{{ asset('img/bloqueo.svg') }}" class="img-fluid border-radius-lg" alt="Responsive image"
                        style="max-width: 1300px; max-height: 800px;">
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
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
        // Selecciona todos los botones dentro del contenedor
        const buttons = document.querySelectorAll('.d-flex button');

        // Agrega un evento 'click' a cada botón
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                // Verifica la clase actual y la alterna
                if (button.classList.contains('btn-secondary')) {
                    button.classList.remove('btn-secondary');
                    button.classList.add('btn-success');
                } else {
                    button.classList.remove('btn-success');
                    button.classList.add('btn-secondary');
                }
            });
        });
    </script>

    <script>
        function toggleInput() {
            const select = document.getElementById('tipo');
            const otraInputGroup = document.getElementById('otraInputGroup');
            if (select.value === "Otro") {
                otraInputGroup.style.display = "flex"; // Utilizar "flex" para mantener la estructura
            } else {
                otraInputGroup.style.display = "none";
            }
        }
    </script>
@endsection
