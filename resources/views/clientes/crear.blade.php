    <!-- Modal -->
    <div class="modal fade" id="agregarPanel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrar cliente</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="myForm" action="{{ route('cliente.crear') }}" name="form-data" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">NIC</label>
                                    <input type="text" class="form-control" id="marca" name="NIC" required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="tipo" name="tipo_cliente" class="form-control">
                                        <option disabled selected>Tipo de cliente</option>
                                        <option value="Residencial">Residencial</option>
                                        <option value="Comercial">Comercial</option>
                                        <option value="Industrial">Industrial</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="selectDepartamentos" name="departamento" class="form-control" required onchange="filtrarCiudades()">
                                        <option disabled selected>Departamento</option>
                                        @foreach ($departamentos as $depa)
                                        <option value="{{ $depa->departamento }}" data-departamento="{{$depa->departamento}}">
                                            {{ $depa->departamento}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="selectCiudades" name="ciudad" class="form-control" required>
                                        <option disabled selected>Ciudad</option>
                                        @foreach ($ciudades as $ciudad)
                                        <option value="{{ $ciudad->municipio }}" data-departamento="{{$ciudad->departamento}}">
                                            {{ $ciudad->municipio}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="potencia" name="direccion" required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Consumo actual kWh/mes</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="consumo_actual" required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Tarifa $/kWh</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="tarifa" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
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