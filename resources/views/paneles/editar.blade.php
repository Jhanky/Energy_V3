<div class="modal fade" id="EditPanel{{ $panel->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>

            <div class="modal-body">
                {{-- formulario --}}
                <form id="edit" action="{{ route('panel.actualizar', ['id' =>$panel->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca" required value="{{ $panel->marca }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Modelo</label>
                                    <input type="text" class="form-control" name="modelo" required value="{{ $panel->modelo }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Potencia (W)</label>
                                    <input type="number" class="form-control" id="potencia" name="poder" required value="{{ $panel->poder }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Precio</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="precio" required value="$ {{ number_format($panel->precio, 0, ',', '.') }}">
                                </div>
                            </div>
                        </div>
                    {{-- botones --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success col-3">Guardar</button>
                    </div>
                    {{-- fin botones --}}
                </form>
                {{-- fin formulario --}}
            </div>
        </div>
    </div>
</div>