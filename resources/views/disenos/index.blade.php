@extends('layout.plantilla')

@section('title')
Dasboard
@endsection

@section('header')

@endsection

@section('base')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Diseños Pendientes</h6>
                </div>
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Nombre del proyecto</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ciudad</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Dirección</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">kW a instalar</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder"># paneles</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $list)
                            <tr>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->nombre_proyecto }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->ciudad }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->direccion }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">
                                        @php
                                        $kw = ($list->numero_paneles * $list->poder)/1000;
                                        @endphp
                                        {{ number_format($kw, 2, ',', '.') }}kW
                                    </p>

                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $list->numero_paneles }} paneles de {{ $list->poder }}W </p>
                                </td>

                                <td class="align-middle text-center">
                                    <button type="button" class=" btn btn-info" rel="tooltip" data-bs-toggle="modal" data-bs-target="#Diseno{{ $list->id }}">
                                        Subir Diseño
                                    </button>
                                </td>
                            </tr>
                            @include('disenos.crear')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>

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
            if (ciudad.dataset.departamento === departamentoSeleccionado || ciudad.dataset.departamento === undefined) {
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
            if (ciudad.dataset.departamento === departamentoSeleccionado || ciudad.dataset.departamento === undefined) {
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
@endsection