<div class="modal fade" id="EditBateria{{ $bateria->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
            <form  id="myForm" method="POST" action="{{ route('baterias.actualizar', $bateria->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                            <div class="col-md-6">
                            <input type="text" name="codigo" value="{{ $codigoConSufijo }}" hidden>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca" value="{{ $bateria->marca }}" required>
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <select id="tipo" name="tipo" class="form-control">
                                        <option disabled selected value="{{ $bateria->tipo }}">{{ $bateria->tipo }}</option>
                                        <option value="Litio">Litio</option>
                                        <option value="Gel">Gel</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Voltaje</label>
                                    <input type="text" class="form-control" id="precio" name="voltaje" required value="{{ $bateria->voltaje }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Amperios hora</label>
                                    <input type="number" class="form-control" id="potencia" name="amperios_hora" required value="{{ $bateria->amperios_hora }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Precio</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="precio" required value="${{ number_format($bateria->precio, 0, ',', '.') }}">
                                </div>
                            </div>
                        </div>

                {{-- botones --}}
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success col-3">Guardar</button>
                </div>
                {{-- fin botones --}}
            </form>
            </div>
        </div>
    </div>
</div>