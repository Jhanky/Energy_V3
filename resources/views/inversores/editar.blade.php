<div class="modal fade" id="EditInversor{{ $inversor->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
                <form class="" method="POST" action="{{ route('inversores.actualizar', ['id' =>$inversor->id]) }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="codigo" value="{{ $codigoConSufijo }}" hidden>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca" required value="{{ $inversor->marca }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Modelo</label>
                                    <input type="text" class="form-control" name="modelo" required value="{{ $inversor->modelo }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <select id="tipo" name="tipo" class="form-control">
                                        <option disabled selected value="{{ $inversor->tipo }}">{{ $inversor->tipo }}</option>
                                        <option value="Off grid">Off grid</option>
                                        <option value="On grid">On grid</option>
                                        <option value="Hibrído">Hibrído</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Potencia (W)</label>
                                    <input type="number" class="form-control" id="potencia" name="poder" required value="{{ $inversor->poder }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <label class="form-label">Precio</label>
                                    <input type="text" class="form-control custom-input" id="precio" name="precio" required value="{{ $inversor->precio }}">
                                </div>
                                <div class="input-group input-group-outline my-3 focused is-focused">
                                    <select id="tipo" name="tipo_red" class="form-control">
                                        <option disabled selected value="{{ $inversor->tipo_red }}">{{ $inversor->tipo_red }}</option>
                                        <option value="Monofásico - 110">Monofásico - 110</option>
                                        <option value="Bifásico - 220">Bifásico - 220</option>
                                        <option value="Trifásico - 220">Trifásico - 220</option>
                                        <option value="Trifásico - 440">Trifásico - 440</option>
                                    </select>
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