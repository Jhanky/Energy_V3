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

        .qq-upload-list {
            list-style-type: none;
            padding: 0;
        }

        .qq-upload-list li {
            display: block;
            /* Cambiar a block para que cada imagen se muestre en una nueva línea */
            align-items: center;
            margin-bottom: 10px;
        }
        .custom-modal .modal-body {
  text-align: left;
}

    </style>
@endsection

@section('base')
    <div class="row">
        @include('actas.ordenes.crear_orden')
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
                                @php
                                    $tecnicosCollection = collect($tecnicos);
                                @endphp
                                @foreach ($ordenes as $orden)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $orden->tipo }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            @foreach (explode(',', $orden->tecnicos_seleccionados) as $tecnicoId)
                                                @php
                                                    $tecnico = $tecnicosCollection->firstWhere('id', $tecnicoId);
                                                @endphp
                                                @if ($tecnico)
                                                    <button type="button"
                                                        class="btn btn-info btn-spacing">{{ $tecnico->name }}</button>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $orden->direccion }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $orden->fecha_hora }}</p>
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
                                                    <button type="button" class="btn bg-gradient-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detallesModal{{ $orden->id }}">
                                                        Ver detalles
                                                    </button>
                                                </li>
                                                <li style="margin-left: 30px; margin-right: 30px">
                                                    <button type="button" class="btn bg-gradient-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#evidenciasModal{{ $orden->id }}">
                                                        Subir evidencias
                                                    </button>
                                                </li>
                                                <li style="margin-left: 30px; margin-right: 30px">
                                                    <button type="button" class="btn bg-gradient-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#verEvidenciasModal{{ $orden->id }}">
                                                        Ver evidencias
                                                    </button>
                                                </li>
                                                <li style="margin-left: 30px; margin-right: 30px">
                                                    <button type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $orden->id }}">
                                                        Eliminar orden
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="modal fade custom-modal" id="detallesModal{{ $orden->id }}" tabindex="-1"
                                                aria-labelledby="detallesModalLabel{{ $orden->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detallesModalLabel{{ $orden->id }}">Detalles de la Orden</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Observaciones:</strong> {{ $orden->observaciones }}</p>
                                                            <h5 class="modal-title" id="detallesModalLabel{{ $orden->id }}">Lista de herramientas</h5>
                                                            <ul>
                                                                <li>Taladro</li>
                                                                <li>Taladro</li>
                                                                <li>Taladro</li>
                                                                <li>Taladro</li>
                                                                <li>Taladro</li>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Modal Evidencias -->
                                            <div class="modal fade" id="evidenciasModal{{ $orden->id }}" tabindex="-1"
                                                aria-labelledby="evidenciasModalLabel{{ $orden->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="evidenciasModalLabel{{ $orden->id }}">Subir
                                                                Evidencias</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('evidencias.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="orden_id"
                                                                    value="{{ $orden->id }}">
                                                                <div
                                                                    class="input-group input-group-outline my-3 focused is-focused">
                                                                    <label for="observaciones" class="form-label">Notas y
                                                                        Observaciones</label>
                                                                    <textarea name="observaciones" class="form-control" rows="4"></textarea>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col text-center">
                                                                        <div
                                                                            class="input-group input-group-outline my-3 justify-content-center">
                                                                            <label class="btn bg-gradient-info"
                                                                                for="formFile{{ $orden->id }}">Adjuntar
                                                                                fotos</label>
                                                                            <input name="foto[]" type="file"
                                                                                id="formFile{{ $orden->id }}" multiple style="display: none;">

                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <ul id="imageList{{ $orden->id }}"
                                                                                class="qq-upload-list"
                                                                                aria-label="Uploaded files"></ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Firma -->
                                                                <button type="submit" class="btn btn-primary">Subir
                                                                    Evidencias</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Ver Evidencias -->
                                            <div class="modal fade" id="verEvidenciasModal{{ $orden->id }}"
                                                tabindex="-1"
                                                aria-labelledby="verEvidenciasModalLabel{{ $orden->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="verEvidenciasModalLabel{{ $orden->id }}">Evidencias
                                                                de la Orden</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-start"><strong>Detalles de la orden:</strong> {{ $orden->observaciones }}</p>
                                                            <p class="text-start"><strong>Notas de la orden:</strong> {{ $orden->notas }}</p>
                                                            @if (isset($orden->evidencias) &&
                                                                    is_array(json_decode($orden->evidencias)) &&
                                                                    count(json_decode($orden->evidencias)) > 0)
                                                                <div id="carouselEvidencias{{ $orden->id }}"
                                                                    class="carousel slide" data-bs-ride="carousel">
                                                                    <div class="carousel-inner">
                                                                        @foreach (json_decode($orden->evidencias) as $index => $evidencia)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img src="{{ asset('storage/' . $evidencia) }}" class="d-block w-100" alt="Evidencia {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                    
                                                                    </div>
                                                                    <button class="carousel-control-prev" type="button"
                                                                        data-bs-target="#carouselEvidencias{{ $orden->id }}"
                                                                        data-bs-slide="prev">
                                                                        <span class="carousel-control-prev-icon"
                                                                            aria-hidden="true"></span>
                                                                        <span class="visually-hidden">Previous</span>
                                                                    </button>
                                                                    <button class="carousel-control-next" type="button"
                                                                        data-bs-target="#carouselEvidencias{{ $orden->id }}"
                                                                        data-bs-slide="next">
                                                                        <span class="carousel-control-next-icon"
                                                                            aria-hidden="true"></span>
                                                                        <span class="visually-hidden">Next</span>
                                                                    </button>
                                                                </div>
                                                                <p>Evidencias fotograficas</p>
                                                            @else
                                                                <p>No hay evidencias disponibles.</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modal-notification-{{ $orden->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="py-3 text-center">
                                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar esta orden!</h4>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="{{ route('ordenes.eliminar', $orden->id) }}" method="POST" style="display: inline-block; margin-right: 5px;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (auth()->user()->hasRole('COMERCIAL'))
                <div class="card my-4"
                    style="display: flex; justify-content: center; align-items: center; height: 800px;">
                    <img src="{{ asset('img/bloqueo.svg') }}" class="img-fluid border-radius-lg" alt="Responsive image"
                        style="max-width: 1300px; max-height: 800px;">
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Manejo de imágenes para diferentes inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(event) {
                const ordenId = this.id.replace('formFile', '');
                console.log('Archivos seleccionados:', event.target.files
                .length); // Ver cuántos archivos fueron seleccionados
                handleFileChange(event, `imageList${ordenId}`, this.id);
            });
        });


        // Función genérica para manejar el cambio de archivos
        function handleFileChange(event, imageListId, inputId) {
            const inputFile = document.getElementById(inputId);
            const imageList = document.getElementById(imageListId);

            const files = Array.from(event.target.files);

            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const li = document.createElement('li');
                        li.className = 'qq-upload-success';
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'qq-upload-img-container';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.className = 'img-thumbnail';
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        imgContainer.appendChild(img);

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-danger btn-sm ms-2';
                        deleteButton.textContent = 'Eliminar';
                        deleteButton.onclick = function() {
                            li.remove();
                        };
                        li.appendChild(imgContainer);
                        li.appendChild(deleteButton);

                        // Agregar la nueva imagen al principio de la lista
                        imageList.insertBefore(li, imageList.firstChild);
                    };
                    reader.readAsDataURL(file);
                }
            });
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
