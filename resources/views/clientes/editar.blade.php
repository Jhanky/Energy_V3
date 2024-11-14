<div class="modal fade" id="EditCliente{{ $list->NIC }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
                <form class="" method="POST" action="{{ route('cliente.actualizar', $list->NIC) }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">NIC</label>
                                    <input type="text" class="form-control" id="marca" name="NIC" required value="{{ $list->NIC }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <select id="tipo" name="tipo_cliente" class="form-control">
                                        <option disabled selected>{{ $list->tipo_cliente }}</option>
                                        <option value="Residencial">Residencial</option>
                                        <option value="Comercial">Comercial</option>
                                        <option value="Industrial">Industrial</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <select id="selectDepartamentos_e" name="departamento" class="form-control" required onchange="filtrarCiudades2()">
                                        <option disabled selected value="{{ $list->departamento }}">{{ $list->departamento }}</option>
                                        @foreach ($departamentos as $depa)
                                        <option value="{{ $depa->departamento }}" data-departamento="{{$depa->departamento}}">
                                            {{ $depa->departamento}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <select id="selectCiudades_e" name="ciudad" class="form-control" required>
                                        <option disabled selected value="{{ $list->ciudad }}">{{ $list->ciudad }}</option>
                                        @foreach ($ciudades as $ciudad)
                                        <option value="{{ $ciudad->municipio }}" data-departamento="{{$ciudad->departamento}}">
                                            {{ $ciudad->municipio}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required value="{{ $list->nombre }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="potencia" name="direccion" required value="{{ $list->direccion }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Consumo actual kWh/mes</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="consumo_actual" required value="{{ $list->consumo_actual }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Tarifa $/kWh</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="tarifa" required value="{{ $list->tarifa }}">
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