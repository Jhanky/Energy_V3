<div class="modal fade" id="Diseno{{ $list->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Subir diseño
                </h6>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('disenos.crear', $list->id) }}" novalidate>
                    @csrf

                    <!-- Contenido del formulario -->
                    <div class="row">
                        <div class="col">
                            <div class="input-group input-group-outline my-3">
                                <label for="formFile" class="form-label"></label>
                                <input class="form-control" type="file" id="formFile" name="diseno">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="enviar">
                        <button type="submit" class="btn btn-success" style="margin: 10px;">Guardar</button>
                    </div>
                    </div>
                 
                </form>
            </div>
        </div>
    </div>
</div>