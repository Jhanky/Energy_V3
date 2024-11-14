<div class="modal fade" id="grafica{{ $result->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color: black;" class="modal-title" id="exampleModalLabel">Graficas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- formulario --}}
                <form id="myForm" action="{{ route('imagen.grafica', $result->id) }}" method="POST" name="form-data" class="row needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="imagen1" class="form-label" style="color: black;">Costo de la energia desplazada anualmente</label>
                                <input class="form-control" type="file" name="imagenes[]" id="imagen1" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen2" class="form-label" style="color: black;">Energia generada vs degradacion</label>
                                <input class="form-control" type="file" name="imagenes[]" id="imagen2" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen3" class="form-label" style="color: black;">Generacion promedio mensual</label>
                                <input class="form-control" type="file" name="imagenes[]" id="imagen3" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen4" class="form-label" style="color: black;">Retorno de la inversion</label>
                                <input class="form-control" type="file" name="imagenes[]" id="imagen4" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen5" class="form-label" style="color: black;">Diseño da la planta</label>
                                <input class="form-control" type="file" name="imagenes[]" id="imagen5" accept="image/*" required>
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