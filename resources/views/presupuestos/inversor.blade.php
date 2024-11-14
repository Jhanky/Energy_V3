<div class="modal fade" id="CrearCotizacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color: black;" class="modal-title" id="exampleModalLabel">Cotización para <b>{{ number_format($promedio, 2) }}kW</b> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- formulario --}}
                <form id="myForm" action="{{ route('presupuestos.crear_presupuesto') }}" method="POST" name="form-data" class="row needs-validation" enctype="multipart/form-data">
                    @csrf

                    <div class="col-8 mx-auto text-center">
                        <input name="nombre_proyecto" class="form-control form-control-lg" id="colFormLabelLg" placeholder="Nombre del proyecto" required>
                        <div class="invalid-feedback">El nombre es obligatorio</div> <br>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="id_cliente" value="{{ $cliente->NIC }}" hidden>
                        <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                        <input type="text" name="valor_conductor_fotovoltaico" value="{{ $conductor_fotovoltaico->precio }}" hidden>
                        <input type="text" name="codigo_propuesta" hidden>
                        <input type="hidden" name="latitud" id="latitud">
                        <input type="hidden" name="longitud" id="longitud">
                        <input type="hidden" id="created_at" name="created_at">

                        <label for="name" class="form-label" style="color: black;">Potencia a cotizar</label>
                            <input type="number" class="form-control" id="cotizar" required>
                            <div class="invalid-feedback">Completa los datos</div>
                        <label for="potential_area" class="form-label" style="color: black;">Tipo sistema</label>
                        <select id="tipo_sistema" name="tipo_sistema" class="form-control" required>
                            <option disabled selected>Seleccionar el tipo de sistema</option>
                            <option value="Desconectado de la red">Desconectado de la red</option>
                            <option value="Conectado a la red">Conectado a la red</option>
                            <option value="Híbrido">Híbrido</option>
                        </select>
                        <div class="invalid-feedback">Seleccionar el tipo de sistema</div>
                        <div class="row">
                            <div class="col-7">
                                <label for="address" class="form-label" style="color: black;">Panel solar</label>
                                <select id="selectPanel" name="id_panel" class="form-control" required>
                                    <option value="" disabled selected>Seleccionar panel</option>
                                    @foreach ($paneles as $panel)
                                    @php
                                    $cantidadNecesaria = floor($potenciaDeseada / $panel->poder);
                                    @endphp
                                    <option value="{{ $panel->id }}" data-power="{{ $panel->poder }}" data-cantidad="{{ $cantidadNecesaria }}">
                                        {{ $panel->marca}} - {{ number_format($panel->poder, 0, ',', '.')}}W
                                        @if(auth()->user()->hasRole('COMERCIAL'))

                                        @else
                                        - ${{ number_format($panel->precio, 0, ',', '.') }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Completa los datos</div>
                            </div>
                            <div class="col-5">
                                <!-- Campo de cantidad -->
                                <label for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                <input type="number" id="cantidad1" name="numero_paneles" class="form-control" placeholder="# de paneles" required>
                                <div class="invalid-feedback">Ingrese la cantida</div>
                            </div>
                        </div>
                        <div @if($rol_cliente) hidden @endif>
                            <label for="name" class="form-label" style="color: black;">Material electrico</label>
                            <input type="text" class="form-control custom-input" id="current_consumptiom" name="valor_material_electrico" value="$180,000" required>
                            <div class="invalid-feedback">Completa los datos</div>
                        </div>

                        <div class="row">
                            <div class="col-8 contenedor_bateria" style="display: block;">
                                <label id="label" for="id_bateria" class="form-label" style="color: black;">Batería</label>
                                <select id="bateria" name="id_bateria" class="form-control">
                                    <option value="1" selected>Seleccionar batería</option>
                                    @foreach ($baterias as $bateria)
                                    <option value="{{ $bateria->id }}">
                                        {{ $bateria->marca}} - {{ $bateria->voltaje}}V - {{ $bateria->amperios_hora}}Ah
                                        @if(auth()->user()->hasRole('COMERCIAL'))

                                        @else
                                        - ${{ number_format($bateria->precio, 0, ',', '.') }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 contenedor_bateria" style="display: block;">
                                <!-- Campo de cantidad -->
                                <label id="labelInput2" for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                <input id="input2" type="number" id="cantidad" name="numero_baterias" class="form-control">
                                <div class="invalid-feedback">Ingrese la cantidad</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tipoRed" class="form-label" style="color: black;">Tipo de red</label>
                        <select id="tipoRed" class="form-control">
                            <option disabled selected>Seleccionar tipo de red</option>
                            <option value="Monofásico - 110">Monofásico - 110</option>
                            <option value="Bifásico - 220">Bifásico - 220</option>
                            <option value="Trifásico - 220">Trifásico - 220</option>
                            <option value="Trifásico - 440">Trifásico - 440</option>
                        </select>
                        <div class="invalid-feedback">Completa los datos</div>
                        <div class="row">
                            <div class="col-8">
                                <label for="inversor" class="form-label" style="color: black;">Inversor</label>
                                <select id="inversor" name="id_inversor" class="form-control" required>
                                    <option value="" disabled selected>Seleccionar Inversor</option>
                                    @foreach ($inversores as $inversor)
                                    <option value="{{ $inversor->id }}" data-tipo-red="{{ $inversor->tipo_red }}" data-poder="{{$inversor->poder}}">
                                        {{ $inversor->marca}} - {{number_format($inversor->poder, 0, ',', '.')}}kW
                                        @if(auth()->user()->hasRole('COMERCIAL'))

                                        @else
                                        - ${{ number_format($inversor->precio, 0, ',', '.') }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <!-- Campo de cantidad -->
                                <label for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                <input type="number" id="cantidad" name="numero_inversores" class="form-control" required>
                                <div class="invalid-feedback">Ingrese la cantidad</div>
                            </div>
                        </div>
                        <div id="boton-container" style="text-align: center; margin-top: 20px;">
                            <button id="mostrar-contenido" class="btn btn-primary" type="button">Agregar otro inversor</button>
                        </div>
                        <div id="contenido-oculto" style="display: none;">
                            <div class="row">
                                <div class="col-8">
                                    <label for="inversor" class="form-label" style="color: black;">Inversor</label>
                                    <select id="inversor" name="id_inversor_2" class="form-control">
                                        <option value="" disabled selected>Seleccionar Inversor</option>
                                        @foreach ($inversores as $inversor)
                                        <option value="{{ $inversor->id }}" data-tipo-red="{{ $inversor->tipo_red }}" data-poder="{{$inversor->poder}}">
                                            {{ $inversor->marca}} - {{number_format($inversor->poder, 0, ',', '.')}}kW
                                            @if(auth()->user()->hasRole('COMERCIAL'))

                                            @else
                                            - ${{ number_format($inversor->precio, 0, ',', '.') }}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <!-- Campo de cantidad -->
                                    <label for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                    <input type="number" id="cantidad" name="numero_inversores_2" class="form-control">
                                    <div class="invalid-feedback">Ingrese la cantidad</div>
                                </div>
                            </div>
                        </div>
                        <div @if($rol_cliente) hidden @endif>
                            <label for="potential_area" class="form-label" style="color: black;">Estructura</label>
                            <input type="text" class="form-control custom-input" id="fee" name="valor_estructura" value="$105,000" required>
                            <div class="invalid-feedback">Completa los datos</div>
                            <label for="current_consumptiom" class="form-label" style="color: black;">Mano de obra</label>
                            <input type="text" class="form-control custom-input" id="current_consumption" name="mano_obra" value="$200,000" required>
                            <div class="invalid-feedback">Completa los datos</div>
                        </div>

                        <br>
                    </div>
                    <div class="accordion" id="accordionExample" @if($rol_cliente) hidden @endif>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <b>Valor de Tramites y porcentajes</b>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h5 style="color: black;">Ajustar segun sea el caso</h5>
                                    <div class="container">
                                        <div>
                                            <label for="valor_tramites" class="form-label" style="color: black;">Valor de trámites</label>
                                            <input type="text" class="form-control custom-input" id="valor_tramites" name="valor_tramites" required value="7,000,000">
                                            <div class="invalid-feedback">Completa los datos</div>
                                            <br>
                                        </div>
                                        <hr class="sidebar-divider d-none d-md-block">
                                        <div class="row">
                                            <div class="col">
                                                <label for="cantidad" class="form-label" style="color: black;">Gestión comercial</label>
                                                <div class="input-group">
                                                    <input type="number" id="valor_gestion_comercial" name="valor_gestion_comercial" value="2" class="form-control" placeholder="Ingrese el Porcentaje">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <div class="invalid-feedback">Ingrese el Porcentaje</div>

                                                <label for="Administración" class="form-label" style="color: black;">Administración</label>
                                                <div class="input-group">
                                                    <input type="number" id="valor_abministracion" name="valor_abministracion" class="form-control" value="8" placeholder="Ingrese el Porcentaje">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <div class="invalid-feedback">Ingrese el Porcentaje</div>

                                                <label for="Imprevistos" class="form-label" style="color: black;">Imprevistos</label>
                                                <div class="input-group">
                                                    <input type="number" id="valor_imprevisto" name="valor_imprevisto" class="form-control" value="2" placeholder="Ingrese el Porcentaje">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <div class="invalid-feedback">Ingrese el Porcentaje</div>
                                            </div>
                                            <div class="col">
                                                <label for="Utilidad" class="form-label" style="color: black;">Utilidad</label>
                                                <div class="input-group">
                                                    <input type="number" id="valor_utilidad" name="valor_utilidad" class="form-control" value="5" placeholder="Ingrese el Porcentaje">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <div class="invalid-feedback">Ingrese el Porcentaje</div>

                                                <label for="Retención" class="form-label" style="color: black;">Retención</label>
                                                <div class="input-group">
                                                    <input type="number" id="valor_retencion" name="valor_retencion" class="form-control" value="3.5" placeholder="Ingrese el Porcentaje">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <div class="invalid-feedback">Ingrese el Porcentaje</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    {{-- botones --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button id="btnGuardar" type="submit" class="btn btn-success col-3">Guardar</button>
                    </div>
                    {{-- fin botones --}}
                </form>
                {{-- fin formulario --}}
            </div>
        </div>
    </div>
</div>

<script>
    // Obtener el formulario
    var form = document.getElementById('myForm');

    // Agregar un listener para el evento submit del formulario
    form.addEventListener('submit', function() {
        // Mostrar la pantalla de carga
        document.body.classList.add('loading');

        // Deshabilitar el botón de guardar para evitar envíos múltiples
        document.getElementById('btnGuardar').disabled = true;
    });

    // Listener para ocultar la pantalla de carga después de que se complete la carga de la página
    window.addEventListener('load', function() {
        // Ocultar la pantalla de carga
        document.body.classList.remove('loading');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener el formulario
        var form = document.getElementById('myForm');

        // Agregar un listener para el evento submit del formulario
        form.addEventListener('submit', function() {
            // Mostrar la pantalla de carga
            document.body.classList.add('loading');
        });

        // Listener para ocultar la pantalla de carga después de que se complete la carga de la página
        window.addEventListener('load', function() {
            // Ocultar la pantalla de carga
            document.body.classList.remove('loading');
        });
    });
</script>

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
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los elementos del DOM
        var selectInversor = document.getElementById('inversor');
        var inputCantidad = document.getElementById('cantidad');

        // Manejar el evento onChange del select
        selectInversor.addEventListener('change', function() {
            // Obtener el valor de poder del inversor seleccionado
            var poderInversor = parseFloat(selectInversor.options[selectInversor.selectedIndex].getAttribute('data-poder'));

            // Obtener el valor de la variable $instalar
            var instalar = parseFloat("{{ $promedio }}");

            // Calcular la cantidad de inversores requeridos
            var cantidadRequerida = Math.ceil(instalar / poderInversor);

            // Actualizar el placeholder con la cantidad sugerida
            inputCantidad.placeholder = "Sugerencia: " + cantidadRequerida;
        });
    });
</script>

<script>
    function obtenerUbicacion() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;

                    // Asignar los valores de latitud y longitud a los campos ocultos
                    document.getElementById('latitud').value = latitud;
                    document.getElementById('longitud').value = longitud;
                },
                function(error) {
                    console.error('Error al obtener la ubicación:', error.message);
                }
            );
        } else {
            console.error('Geolocalización no es compatible en este navegador.');
        }
    }

    // Llamar a la función obtenerUbicacion al cargar la página
    window.onload = obtenerUbicacion;
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
    document.addEventListener('DOMContentLoaded', function() {
        var botonMostrarContenido = document.getElementById('mostrar-contenido');
        var contenidoOculto = document.getElementById('contenido-oculto');

        botonMostrarContenido.addEventListener('click', function() {
            contenidoOculto.style.display = 'block';
            botonMostrarContenido.style.display = 'none';
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inversoresSelects = document.querySelectorAll('select[id="inversor"]');

        inversoresSelects.forEach(function(inversorSelect) {
            var tipoRedSelect = document.getElementById('tipoRed');

            tipoRedSelect.addEventListener('change', function() {
                var tipoRedSeleccionado = tipoRedSelect.value;

                // Reinicia el select de inversores
                inversorSelect.selectedIndex = 0;

                // Oculta todos los inversores
                for (var i = 1; i < inversorSelect.options.length; i++) {
                    inversorSelect.options[i].style.display = 'none';
                }

                // Muestra solo los inversores que coinciden con el tipo de red seleccionado
                for (var i = 1; i < inversorSelect.options.length; i++) {
                    var tipoRedInversor = inversorSelect.options[i].getAttribute('data-tipo-red');
                    if (tipoRedInversor === tipoRedSeleccionado || tipoRedSeleccionado === '') {
                        inversorSelect.options[i].style.display = '';
                    }
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tipoSistemaSelect = document.getElementById('tipo_sistema');
        var contenedoresBateria = document.querySelectorAll('.contenedor_bateria');

        tipoSistemaSelect.addEventListener('change', function() {
            if (tipoSistemaSelect.value === 'Conectado a la red') {
                contenedoresBateria.forEach(function(contenedor) {
                    contenedor.style.display = 'none';
                });
            } else {
                contenedoresBateria.forEach(function(contenedor) {
                    contenedor.style.display = 'block';
                });
            }
        });
    });
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
            cantidadInput.placeholder = 'Para ' + kw + 'kW: ' + cantidadAjustada + ' Paneles';
        });
    });
</script>

