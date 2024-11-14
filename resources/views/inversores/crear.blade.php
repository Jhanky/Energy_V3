    <!-- Modal -->
    <div class="modal fade" id="agregarPanel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrar inversor</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="myForm" action="{{ route('inversores.crear_inversor') }}" name="form-data" enctype="multipart/form-data">
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
                                <div class="input-group input-group-outline my-3">
                                    <select id="tipo" name="tipo" class="form-control">
                                        <option disabled selected>Tipo de inversor</option>
                                        <option value="Off grid">Off grid</option>
                                        <option value="On grid">On grid</option>
                                        <option value="Híbrido">Hibrído</option>
                                    </select>
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
                                <div class="input-group input-group-outline my-3">
                                    <select id="tipo" name="tipo_red" class="form-control">
                                        <option disabled selected>Tipo de red</option>
                                        <option value="Monofásico - 110">Monofásico - 110</option>
                                        <option value="Bifásico - 220">Bifásico - 220</option>
                                        <option value="Trifásico - 220">Trifásico - 220</option>
                                        <option value="Trifásico - 440">Trifásico - 440</option>
                                    </select>
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