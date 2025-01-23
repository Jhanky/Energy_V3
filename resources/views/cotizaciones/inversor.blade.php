<!-- Modal -->
<div class="modal fade" id="inversor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrar Panel</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="myForm" action="{{ route('cotizaciones.crear') }}" name="form-data"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="text" name="id_cliente" value="{{ $cliente->NIC }}" hidden>
                        <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                        <input type="text" name="valor_conductor_fotovoltaico"
                            value="{{ $conductor_fotovoltaico->precio }}" hidden>
                        <input type="text" name="codigo_propuesta" hidden>
                        <input type="hidden" name="latitud" id="latitud">
                        <input type="hidden" name="longitud" id="longitud">
                        <input type="hidden" id="created_at" name="created_at">
                        <div class="col-md-12">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Nombre del proyecto</label>
                                <input type="text" class="form-control" name="nombre_proyecto" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Potencia a cotizar</label>
                                <input type="text" class="form-control" id="cotizar" required>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group input-group-outline my-3">
                                <select id="tipo_sistema" name="tipo_sistema" class="form-control"
                                    onchange="checkTipoSistema(this)" required>
                                    <option disabled selected>Tipo de sistema</option>
                                    <option data-tipo="Off grid" value="Desconectado de la red">Desconectado de la red
                                    </option>
                                    <option data-tipo="On grid" value="Conectado a la red">Conectado a la red</option>
                                    <option data-tipo="Híbrido" value="Híbrido">Híbrido</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group input-group-outline my-3">
                                <select id="selectPanel" name="id_panel" class="form-control" required>
                                    <option disabled selected>Seleccionar panel</option>
                                    @foreach ($paneles as $panel)
                                        @php
                                            $cantidadNecesaria = floor($potenciaDeseada / $panel->poder);
                                        @endphp
                                        <option value="{{ $panel->id }}" data-power="{{ $panel->poder }}"
                                            data-cantidad="{{ $cantidadNecesaria }}">
                                            {{ $panel->marca }} - {{ number_format($panel->poder, 0, ',', '.') }}W
                                            @if (auth()->user()->hasRole('COMERCIAL'))
                                            @else
                                                - ${{ number_format($panel->precio, 0, ',', '.') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label"></label>
                                <input type="number" class="form-control" id="cantidad1" name="numero_paneles"
                                    required>
                                <div class="invalid-feedback">Ingrese la cantida</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group input-group-outline my-3">
                                <select id="tipoRed" class="form-control">
                                    <option disabled selected>Tipo de red</option>
                                    <option value="Monofásico - 110">Monofásico - 110</option>
                                    <option value="Bifásico - 220">Bifásico - 220</option>
                                    <option value="Trifásico - 220">Trifásico - 220</option>
                                    <option value="Trifásico - 440">Trifásico - 440</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group input-group-outline my-3">
                                <select id="inversor" name="id_inversor" class="form-control select-a-filtrar"
                                    required>
                                    <option value="" disabled selected>Seleccionar Inversor</option>
                                    @foreach ($inversores as $inversor)
                                        <option value="{{ $inversor->id }}"
                                            data-tipo-red="{{ $inversor->tipo_red }}"
                                            data-poder="{{ $inversor->poder }}" data-tipo="{{ $inversor->tipo }}">
                                            {{ $inversor->marca }} -
                                            {{ number_format($inversor->poder, 0, ',', '.') }}kW
                                            @if (auth()->user()->hasRole('COMERCIAL'))
                                            @else
                                                - ${{ number_format($inversor->precio, 0, ',', '.') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3" id="bateriaInput">
                                <select id="bateria" name="id_bateria" class="form-control">
                                    <option value="1" selected>Seleccionar batería</option>
                                    @foreach ($baterias as $bateria)
                                        <option value="{{ $bateria->id }}">
                                            {{ $bateria->marca }} - {{ $bateria->voltaje }}V -
                                            {{ $bateria->amperios_hora }}Ah
                                            @if (auth()->user()->hasRole('COMERCIAL'))
                                            @else
                                                - ${{ number_format($bateria->precio, 0, ',', '.') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" id="cantidad2" name="numero_inversores" class="form-control" required min="1" max="3">
                            </div>
                            <div class="input-group input-group-outline my-3" id="cantidadInput">
                                <label class="form-label">Cantidad</label>
                                <input type="number" id="cantidad" name="numero_baterias" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="financiado" type="checkbox" id="financiado" disabled>
                        <label class="form-check-label" for="financiado">¿Requiere financiamiento?</label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Valor de sobreestructura(Opcional)</label>
                                <input type="text" class="form-control custom-input" name="valor_sobreestructura">
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
                        <div class="row">
                            <h5 style="text-align: center;">Valores adicionales y porcentajes</h5>
                            <div class="col-md-12">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Valor de trámites</label>
                                    <input type="text" class="form-control custom-input" name="valor_tramites"
                                        required value="$7,000,000">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Mano de obra</label>
                                    <input type="text" class="form-control custom-input" name="mano_obra" required
                                        value="$200,000">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Estructura</label>
                                    <input type="text" class="form-control custom-input" name="valor_estructura"
                                        required value="$105,000">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Material E.</label>
                                    <input type="text" class="form-control custom-input"
                                        name="valor_material_electrico" required value="$180,000">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h5>Porcentajes</h5>
                            <div class="col-sm">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Gestión C.</label>
                                    <input type="number" id="valor_gestion_comercial" name="valor_gestion_comercial"
                                        value="2" class="form-control custom-porcentaje" required
                                        value="2">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Administración</label>
                                    <input type="number" id="valor_administracion" name="valor_administracion"
                                        class="form-control custom-porcentaje" required value="8">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Imprevistos</label>
                                    <input type="number" id="valor_imprevisto" name="valor_imprevisto"
                                        class="form-control custom-porcentaje" required value="2">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Utilidad</label>
                                    <input type="number" id="valor_utilidad" name="valor_utilidad"
                                        class="form-control custom-porcentaje" required value="5">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Retención</label>
                                    <input type="number" id="valor_retencion" name="valor_retencion"
                                        class="form-control custom-porcentaje" required value="3.5">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button id="btnGuardar" type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- fin Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inversoresSelects = document.querySelectorAll('select[id="inversor"]');
        var tipoRedSelect = document.getElementById('tipoRed');
        var tipoSistemaSelect = document.getElementById('tipo_sistema');

        tipoRedSelect.addEventListener('change', function() {
            filtrarInversores();
        });

        tipoSistemaSelect.addEventListener('change', function() {
            filtrarInversores();
        });

        function filtrarInversores() {
            var tipoRedSeleccionado = tipoRedSelect.value;
            var tipoSistemaSeleccionado = tipoSistemaSelect.options[tipoSistemaSelect.selectedIndex]
                .getAttribute('data-tipo');

            inversoresSelects.forEach(function(inversorSelect) {
                // Reinicia el select de inversores
                inversorSelect.selectedIndex = 0;

                // Oculta todos los inversores
                for (var i = 1; i < inversorSelect.options.length; i++) {
                    inversorSelect.options[i].style.display = 'none';
                }

                // Muestra solo los inversores que coinciden con los filtros seleccionados
                for (var i = 1; i < inversorSelect.options.length; i++) {
                    var tipoRedInversor = inversorSelect.options[i].getAttribute('data-tipo-red');
                    var tipoInversor = inversorSelect.options[i].getAttribute('data-tipo');
                    if ((tipoRedInversor === tipoRedSeleccionado || tipoRedSeleccionado === '') &&
                        (tipoInversor === tipoSistemaSeleccionado || tipoSistemaSeleccionado === '')) {
                        inversorSelect.options[i].style.display = '';
                    }
                }
            });
        }

        // Inicializar el filtrado al cargar la página
        filtrarInversores();
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
            var poderPanel = parseInt(poderPanelInput.options[poderPanelInput.selectedIndex].getAttribute(
                "data-power"));

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

            var poder = Math.round(selectPanel.options[selectPanel.selectedIndex].getAttribute(
                'data-power'));

            // Realiza el cálculo para obtener la cantidad sugerida ajustada
            var cantidadAjustada = Math.round(valorCotizar / poder);

            // Actualiza el placeholder del input con la cantidad sugerida ajustada
            cantidadInput.placeholder = cantidadAjustada + ' Paneles';
            cantidadInput.max = cantidadAjustada; // Establece el valor máximo permitido
        });

        cantidadInput.addEventListener('input', function() {
            var maxCantidad = parseInt(cantidadInput.max);
            if (parseInt(cantidadInput.value) > maxCantidad) {
                cantidadInput.value = maxCantidad;
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
    document.getElementById('cotizar').addEventListener('input', function() {
        const valorInput = parseFloat(this.value);
        const checkbox = document.getElementById('financiado');

        if (valorInput > 47) {
            checkbox.disabled = false;
        } else {
            checkbox.disabled = true;
            checkbox.checked = false; // Asegurarse de que el checkbox esté desmarcado si se deshabilita
        }
    });

    document.getElementById('miFormulario').addEventListener('submit', function(event) {
        // Aquí puedes agregar lógica para manejar el formulario antes de enviarlo
        const checkbox = document.getElementById('financiado');
        const valor = checkbox.checked ? 1 : 0;
        console.log('Valor del checkbox:', valor); // Verifica el valor del checkbox en la consola
        // Asegúrate de que el valor del checkbox se maneje correctamente en el servidor
    });
</script>

<script>
    function checkTipoSistema(select) {
        var tipoSeleccionado = select.options[select.selectedIndex];
        var bateriaInput = document.getElementById('bateriaInput').querySelector('select');
        var cantidadInput = document.getElementById('cantidadInput').querySelector('input');

        // Comprobar si la opción seleccionada tiene el valor deseado
        if (tipoSeleccionado.value === 'Conectado a la red') { // Se selecciona la opción deseada
            bateriaInput.disabled = true;
            cantidadInput.disabled = true;
        } else { // Para todas las demás opciones
            bateriaInput.disabled = false;
            cantidadInput.disabled = false;
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectPanel = document.getElementById('selectPanel');
        var cantidadPanelesInput = document.getElementById('cantidad1');
        var cotizarInput = document.getElementById('cotizar'); // Nuevo campo de entrada
        var form = document.getElementById('myForm');
        var selectInversor = document.getElementById('inversor');
        var cantidadInversoresInput = document.getElementById('cantidad2');

        selectPanel.addEventListener('change', function() {
            // Obtiene la cantidad sugerida del panel seleccionado
            var valorCotizar = parseInt(cotizarInput.value);
            var kw = parseInt(cotizarInput.value);

            // Multiplica el valor ingresado por 1000
            valorCotizar *= 1000;

            var poder = Math.round(selectPanel.options[selectPanel.selectedIndex].getAttribute(
                'data-power'));

            // Realiza el cálculo para obtener la cantidad sugerida ajustada
            var cantidadAjustada = Math.round(valorCotizar / poder);

            // Calcula el máximo permitido (cantidad sugerida * 1.3) y redondea al entero más cercano
            var maxCantidadPermitida = Math.ceil(cantidadAjustada * 1.3);

            // Actualiza el placeholder del input con la cantidad sugerida ajustada
            cantidadPanelesInput.placeholder = cantidadAjustada + ' Paneles';
            cantidadPanelesInput.max = maxCantidadPermitida; // Establece el valor máximo permitido
        });

        cantidadPanelesInput.addEventListener('input', function() {
            var maxCantidad = parseInt(cantidadPanelesInput.max);
            if (parseInt(cantidadPanelesInput.value) > maxCantidad) {
                cantidadPanelesInput.classList.add('is-invalid');
            } else {
                cantidadPanelesInput.classList.remove('is-invalid');
            }
        });

        selectInversor.addEventListener('change', function() {
            // Obtiene la potencia cotizada y la potencia del inversor seleccionado
            var potenciaCotizada = parseInt(cotizarInput.value);
            var potenciaInversor = parseInt(selectInversor.options[selectInversor.selectedIndex]
                .getAttribute('data-poder'));

            // Calcula la cantidad sugerida de inversores
            var cantidadSugerida = Math.ceil(potenciaCotizada / potenciaInversor);

            // Establece el valor máximo permitido (no puede ser mayor a 2)
            var maxCantidadInversores = 2;

            // Actualiza el placeholder del input con la cantidad sugerida
            cantidadInversoresInput.placeholder = Math.min(cantidadSugerida, maxCantidadInversores) + ' Inversores';
            cantidadInversoresInput.max = maxCantidadInversores; // Establece el valor máximo permitido
        });

        cantidadInversoresInput.addEventListener('input', function() {
            var maxCantidad = parseInt(cantidadInversoresInput.max);
            if (parseInt(cantidadInversoresInput.value) > maxCantidad) {
                cantidadInversoresInput.classList.add('is-invalid');
            } else {
                cantidadInversoresInput.classList.remove('is-invalid');
            }
        });

        form.addEventListener('submit', function(event) {
            var maxCantidadPaneles = parseInt(cantidadPanelesInput.max);
            var maxCantidadInversores = parseInt(cantidadInversoresInput.max);

            if (parseInt(cantidadPanelesInput.value) > maxCantidadPaneles) {
                event.preventDefault();
                alert('El número de paneles no puede ser mayor al permitido.');
            }

            if (parseInt(cantidadInversoresInput.value) > maxCantidadInversores) {
                event.preventDefault();
                alert('El número de inversores no puede ser mayor al permitido.');
            }
        });
    });
</script>
