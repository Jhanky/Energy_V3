@extends('layout.plantilla')

@section('title')
    Cliente
@endsection

@section('header')
@endsection

@section('base')
    <div class="row">

        @include('layout.msj')
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Clientes</h6>
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
                                    <th class="text-center text-uppercase text-secondary  font-weight-bolder">Nombre</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder">Tipo
                                        de cliente</th>
                                    <th class="text-center text-uppercase text-secondary  font-weight-bolder">Ciudad
                                    </th>
                                    <th class="text-center text-uppercase text-secondary  font-weight-bolder">
                                        Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cables as $list)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $list->marca }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $list->modelo }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">${{ number_format($list->precio, 0, '.', ',') }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn bg-gradient-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Opciones
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li style="margin-left: 30px; margin-right: 30px">
                                                    <button type="button" class=" btn btn-info" rel="tooltip"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#EditCliente{{ $list->id }}">
                                                        Editar <i class="material-icons opacity-10">edit</i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @include('cable.editar', ['id' => $list->id])
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
