<div class="modal fade" id="Edit{{ $results->first()->id }}" tabindex="-1"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
                {{-- formulario --}}
                <form id="myForm" action="{{ route('presupuestos.editar', $results->first()->id) }}" method="POST" name="form-data" class="row needs-validation" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-8 mx-auto text-center">
                        <input type="nombre_proyecto" class="form-control form-control-lg" id="colFormLabelLg" placeholder="Nombre del proyecto" value="{{$results->first()->nombre_proyecto}}" required>
                        <div class="invalid-feedback">El nombre es obligatorio</div> <br>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                        <input type="text" name="valor_conductor_fotovoltaico" value="{{ $results->first()->valor_conductor_fotovoltaico }}" hidden>
                        <input type="text" name="codigo_propuesta" value="codigo" hidden>
                        <label for="potential_area" class="form-label" style="color: black;">Tipo sistema</label>
                        <select id="tipo_sistema" name="tipo_sistema" class="form-control" required>
                            <option disabled selected>{{ $results->first()->tipo_sistema }}</option>
                            <option value="Desconectado de la red">Desconectado de la red</option>
                            <option value="Conectado a la red">Conectado a la red</option>
                            <option value="Híbrido">Híbrido</option>
                        </select>
                        <div class="invalid-feedback">Seleccionar el tipo de sistema</div>
                        <div class="row">
                            <div class="col-7">
                                <label for="address" class="form-label" style="color: black;">Panel solar</label>
                                <select id="selectPanel" name="id_panel" class="form-control" required>
                                    <option disabled selected>{{ $results->first()->solar_panel_marca}} - {{ number_format($results->first()->poder, 0, ',', '.')}}W - ${{ number_format($results->first()->precio, 0, ',', '.') }}</option>
                                    @foreach ($paneles as $panel)
                                    <option value="{{ $panel->id }}" data-power="{{ $panel->poder }}">
                                        {{ $panel->marca}} - {{ number_format($panel->poder, 0, ',', '.')}}W - ${{ number_format($panel->precio, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Completa los datos</div>
                            </div>
                            <div class="col-5">
                                <!-- Campo de cantidad -->
                                <label for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                <input type="number" id="cantidad1" name="numero_paneles" class="form-control" value="{{ $results->first()->numero_paneles}}">
                                <div class="invalid-feedback">Ingrese la cantida</div>
                            </div>
                        </div>
                        <label for="name" class="form-label" style="color: black;">Material electrico</label>
                        <input type="text" class="form-control custom-input" id="current_consumptiom" name="valor_material_electrico" value="{{ number_format($results->first()->valor_material_electrico, 0,',', '.') }}" required>
                        <div class="invalid-feedback">Completa los datos</div>

                        <div class="row">
                            <div class="col-8 contenedor_bateria" style="display: block;">
                                <label id="label" for="id_bateria" class="form-label" style="color: black;">Batería</label>
                                <select id="bateria" name="id_bateria" class="form-control">
                                <option disabled selected>{{ $results->first()->solar_panel_marca}} - {{ number_format($results->first()->poder, 0, ',', '.')}}W - ${{ number_format($results->first()->precio, 0, ',', '.') }}</option>
                                    @foreach ($baterias as $bateria)
                                    <option value="{{ $bateria->id }}"> 
                                        {{ $bateria->marca}} - {{ $bateria->voltaje}}V - {{ $bateria->amperios_hora}}Ah - ${{ number_format($bateria->precio, 0, ',', '.') }} 
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 contenedor_bateria" style="display: block;">
                                <!-- Campo de cantidad -->
                                <label id="labelInput2" for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                <input id="input2" type="number" id="cantidad" name="numero_baterias" class="form-control">
                                <div class="invalid-feedback">Ingrese la cantidad</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tipoRed" class="form-label" style="color: black;">Tipo de red</label>
                        <select id="tipoRed" class="form-control">
                            <option disabled selected>Seleccionar tipo de red</option>
                            <option value="Monofásico - 110">Monofásico - 110</option>
                            <option value="Bifásico - 220">Bifásico - 220</option>
                            <option value="Trifásico - 220">Trifásico - 220</option>
                            <option value="Trifásico - 440">Trifásico - 440</option>
                        </select>
                        <div class="invalid-feedback">Completa los datos</div>
                        <div class="row">
                            <div class="col-8">
                                <label for="inversor" class="form-label" style="color: black;">Inversor</label>
                                <select id="inversor" name="id_inversor" class="form-control" required>
                                    <option value="" disabled selected>Seleccionar Inversor</option>
                                    @foreach ($inversores as $inversor)
                                    <option value="{{ $inversor->id }}" data-tipo-red="{{ $inversor->tipo_red }}" data-poder="{{$inversor->poder}}">
                                        {{ $inversor->marca}} - {{number_format($inversor->poder, 0, ',', '.')}}kW - ${{ number_format($inversor->precio, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <!-- Campo de cantidad -->
                                <label for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                <input type="number" id="cantidad" name="numero_inversores" class="form-control" required>
                                <div class="invalid-feedback">Ingrese la cantidad</div>
                            </div>
                        </div>
                        <div id="boton-container" style="text-align: center; margin-top: 20px;">
                            <button id="mostrar-contenido" class="btn btn-primary" type="button">Agregar otro inversor</button>
                        </div>
                        <div id="contenido-oculto" style="display: none;">
                            <div class="row">
                                <div class="col-8">
                                    <label for="inversor" class="form-label" style="color: black;">Inversor</label>
                                    <select id="inversor" name="id_inversor_2" class="form-control">
                                        <option value="" disabled selected>Seleccionar Inversor</option>
                                        @foreach ($inversores as $inversor)
                                        <option value="{{ $inversor->id }}" data-tipo-red="{{ $inversor->tipo_red }}" data-poder="{{$inversor->poder}}">
                                            {{ $inversor->marca}} - {{number_format($inversor->poder, 0, ',', '.')}}kW - ${{ number_format($inversor->precio, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <!-- Campo de cantidad -->
                                    <label for="cantidad" class="form-label" style="color: black;">Cantidad</label>
                                    <input type="number" id="cantidad" name="numero_inversores_2" class="form-control">
                                    <div class="invalid-feedback">Ingrese la cantidad</div>
                                </div>
                            </div>
                        </div>
                        <label for="potential_area" class="form-label" style="color: black;">Estructura</label>
                        <input type="text" class="form-control custom-input" id="fee" name="valor_estructura" value="$105,000" required>
                        <div class="invalid-feedback">Completa los datos</div>
                        <label for="current_consumptiom" class="form-label" style="color: black;">Mano de obra</label>
                        <input type="text" class="form-control custom-input" id="current_consumption" name="mano_obra" value="$200,000" required>
                        <div class="invalid-feedback">Completa los datos</div>
                        <br>
                    </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <b>Valor de Tramites y porcentajes</b>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <h5 style="color: black;">Ajustar segun sea el caso</h5>
                                <div class="container">
                                    <div>
                                        <label for="valor_tramites" class="form-label" style="color: black;">Valor de trámites</label>
                                        <input type="text" class="form-control custom-input" id="valor_tramites" name="valor_tramites" required value="7,000,000">
                                        <div class="invalid-feedback">Completa los datos</div>
                                        <br>
                                    </div>
                                    <hr class="sidebar-divider d-none d-md-block">
                                    <div class="row">
                                        <div class="col">
                                            <label for="cantidad" class="form-label" style="color: black;">Gestión comercial</label>
                                            <div class="input-group">
                                                <input type="number" id="valor_gestion_comercial" name="valor_gestion_comercial" value="2" class="form-control" placeholder="Ingrese el Porcentaje">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="invalid-feedback">Ingrese el Porcentaje</div>

                                            <label for="Administración" class="form-label" style="color: black;">Administración</label>
                                            <div class="input-group">
                                                <input type="number" id="valor_abministracion" name="valor_abministracion" class="form-control" value="8" placeholder="Ingrese el Porcentaje">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="invalid-feedback">Ingrese el Porcentaje</div>

                                            <label for="Imprevistos" class="form-label" style="color: black;">Imprevistos</label>
                                            <div class="input-group">
                                                <input type="number" id="valor_imprevisto" name="valor_imprevisto" class="form-control" value="2" placeholder="Ingrese el Porcentaje">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="invalid-feedback">Ingrese el Porcentaje</div>
                                        </div>
                                        <div class="col">
                                            <label for="Utilidad" class="form-label" style="color: black;">Utilidad</label>
                                            <div class="input-group">
                                                <input type="number" id="valor_utilidad" name="valor_utilidad" class="form-control" value="5" placeholder="Ingrese el Porcentaje">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="invalid-feedback">Ingrese el Porcentaje</div>

                                            <label for="Retención" class="form-label" style="color: black;">Retención</label>
                                            <div class="input-group">
                                                <input type="number" id="valor_retencion" name="valor_retencion" class="form-control" value="3.5" placeholder="Ingrese el Porcentaje">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <div class="invalid-feedback">Ingrese el Porcentaje</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
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