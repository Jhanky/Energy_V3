    <!-- Modal -->
    <div class="modal fade" id="agregarPanel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrar Panel</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="myForm" action="{{ route('panel.crear_panel') }}" name="form-data" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                            <input type="text" name="codigo" value="{{ $codigoConSufijo }}" hidden>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca" required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Modelo</label>
                                    <input type="text" class="form-control" name="modelo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Potencia (W)</label>
                                    <input type="number" class="form-control" id="potencia" name="poder" required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Precio</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="precio" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn bg-gradient-success">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- fin Modal -->