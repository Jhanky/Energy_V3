<div class="modal fade" id="EditCliente{{ $list->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
                <form class="" method="POST" action="{{ route('cable.actualizar', $list->id) }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
           
                        <div class="col">
                            <div class="input-group input-group-outline my-3 focused is-focused">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="marca" required value="{{ $list->marca }}">
                            </div>
                            <div class="input-group input-group-outline my-3 focused is-focused">
                                <label class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="potencia" name="modelo" required value="{{ $list->modelo }}">
                            </div>
                            <div class="input-group input-group-outline my-3 focused is-focused">
                                <label class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="potencia" name="descripcion" required value="{{ $list->descripcion }}">
                            </div>
                            <div class="input-group input-group-outline my-3 focused is-focused">
                                <label class="form-label">Precio</label>
                                <input type="text" class="form-control custom-input" id="precio" name="precio" required value="{{ number_format($list->precio, 0, '.', ',') }}">
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