<!-- Modal -->
<div class="modal fade" id="agregarOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Crear orden de servicio</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" id="myForm" action="{{ route('ordenes.guardar') }}" name="form-data"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="input-group input-group-outline my-3">
                                <select id="tipo" name="tipo" class="form-control" onchange="toggleInput()">
                                    <option disabled selected>Tipo de orden</option>
                                    @foreach ($tipos_orden as $tipo)
                                        <option value="{{ $tipo->nombre }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                    <option value="Otro">Otra...</option>
                                </select>
                            </div>

                            <div id="otraInputGroup" class="input-group input-group-outline my-3"
                                style="display: none;">
                                <label class="form-label">¿Cuál?</label>
                                <input type="text" id="otraInput" class="form-control" name="tipo_otro">
                            </div>

                            <div class="d-flex justify-content-between">
                                @foreach ($tecnicos as $tec)
                                    <button type="button" class="btn btn-secondary flex-fill mx-1"
                                        onclick="toggleTecnico('{{ $tec->id ?? $tec->ID }}')">{{ $tec->name }}</button>
                                @endforeach
                            </div>
                            <input type="hidden" name="tecnicos_seleccionados" id="tecnicosSeleccionados">

                            <div class="input-group input-group-outline my-3">
                                <select id="cliente" name="id_cliente" class="form-control">
                                    <option disabled selected>Cliente</option>
                                    @foreach ($clientes as $cli)
                                        <option value="{{ $cli->NIC }}">{{ $cli->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion" required>
                            </div>

                            <div class="input-group input-group-static my-3">
                                <label>Agendar fecha y hora</label>
                                <input type="datetime-local" class="form-control" name="fecha_hora">
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-5">
                            <button type="submit" class="btn bg-gradient-success">
                                {{ __('Agendar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- fin Modal -->

<script>
    let tecnicosSeleccionados = [];

    function toggleTecnico(tecnicoId) {
        const index = tecnicosSeleccionados.indexOf(tecnicoId);
        if (index > -1) {
            tecnicosSeleccionados.splice(index, 1);
        } else {
            tecnicosSeleccionados.push(tecnicoId);
        }
        document.getElementById('tecnicosSeleccionados').value = tecnicosSeleccionados.join(',');
    }
</script>
