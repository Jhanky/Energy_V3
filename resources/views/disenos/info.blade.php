@extends('layout.plantilla')

@section('title')
Dasboard
@endsection

@section('header')

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
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">$</p>
                                </td>

                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal">
                                                Eliminar<i class="material-icons opacity-10">delete</i>
                                            </button>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="button" class=" btn btn-info" rel="tooltip" data-bs-toggle="modal">
                                                Editar<i class="material-icons opacity-10">edit</i>
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar este panel solar!</h4>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener referencias a las entradas relevantes del formulario
        var numPanelesInput = document.getElementById("cantidad1");
        var poderPanelInput = document.getElementById("selectPanel");

        var conductorFotovoltaicoInput = document.getElementsByName("valor_conductor_fotovoltaico")[0];

        // Escuchar el evento 'change' en el número de paneles y el poder del panel
        numPanelesInput.addEventListener("change", calcularValorConductorFotovoltaico);
        poderPanelInput.addEventListener("change", calcularValorConductorFotovoltaico);

        // Función para calcular el valor del conductor fotovoltaico
        function calcularValorConductorFotovoltaico() {
            // Obtener los valores seleccionados
            var numPaneles = parseInt(numPanelesInput.value);
            var poderPanel = parseInt(poderPanelInput.options[poderPanelInput.selectedIndex].getAttribute("data-power"));

            // Calcular el valor de X en kW (numPaneles * poderPanel / 1000)
            var x_kW = (numPaneles * poderPanel) / 1000 * 0.6;

            // Calcular el valor del conductor fotovoltaico según la fórmula
            var valorConductorFotovoltaico = (x_kW * 110) / 10;

            // Actualizar el valor en el input oculto
            conductorFotovoltaicoInput.value = valorConductorFotovoltaico.toFixed(2);
        }
    });
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
    // Script para actualizar el placeholder del input al cambiar la opción seleccionada en el select
    document.addEventListener('DOMContentLoaded', function() {
        var selectPanel = document.getElementById('selectPanel');
        var cantidadInput = document.getElementById('cantidad1');
        var cotizarInput = document.getElementById('cotizar'); // Nuevo campo de entrada

        selectPanel.addEventListener('change', function() {
            // Obtiene la cantidad sugerida del panel seleccionado
          
            
            // Obtiene el valor ingresado en el campo de cotizar y lo convierte a entero
            var valorCotizar = parseInt(cotizarInput.value);
            var kw = parseInt(cotizarInput.value);

            // Multiplica el valor ingresado por 1000
            valorCotizar *= 1000;

            var poder = Math.round(selectPanel.options[selectPanel.selectedIndex].getAttribute('data-power'));

            // Realiza el cálculo para obtener la cantidad sugerida ajustada
            var cantidadAjustada = Math.round(valorCotizar / poder);

            // Actualiza el placeholder del input con la cantidad sugerida ajustada
            cantidadInput.placeholder = cantidadAjustada + ' Paneles';
        });
    });
</script>
<script>
        function duplicarBloque() {
            var bloqueOriginal = document.getElementById('bloqueOriginal');
            var nuevoBloque = bloqueOriginal.cloneNode(true);
            bloqueOriginal.parentNode.appendChild(nuevoBloque);
        }
    </script>
    @endsection