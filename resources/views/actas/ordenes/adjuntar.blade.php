<div class="modal fade" id="evidenciasModal{{ $orden->id }}" tabindex="-1"
    aria-labelledby="evidenciasModalLabel{{ $orden->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="evidenciasModalLabel{{ $orden->id }}">Subir
                    Evidencias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('evidencias.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="orden_id"
                        value="{{ $orden->id }}">
                    <div
                        class="input-group input-group-outline my-3 focused is-focused">
                        <label for="observaciones" class="form-label">Notas y
                            Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <div
                                class="input-group input-group-outline my-3 justify-content-center">
                                <label class="btn bg-gradient-info"
                                    for="formFile{{ $orden->id }}">Adjuntar
                                    fotos</label>
                                <input name="foto[]"
                                    class="form-control d-none" type="file"
                                    id="formFile{{ $orden->id }}" multiple>
                            </div>
                            <p id="fileName{{ $orden->id }}"></p>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul id="imageList{{ $orden->id }}"
                                    class="qq-upload-list"
                                    aria-label="Uploaded files"></ul>
                            </div>
                        </div>
                    </div>

                    <!-- Firma -->
                    <button type="submit" class="btn btn-primary">Subir
                        Evidencias</button>
                </form>
            </div>
        </div>
    </div>
</div>