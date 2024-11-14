<div class="modal fade" id="modificar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <h5 style="color: black; margin: 0 auto;" class="modal-title" id="exampleModalLabel">Modificar o aplicar descuento</h5>
            </div>
            <div class="modal-body">
                {{-- formulario --}}

                <form id="descuento" action="{{ route('cotizaciones.descuento', ['id' => $results->first()->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $results->first()->id }}">
                    <div id="seccionOcultable">
                        <div class="input-group input-group-outline my-3">
                            <label for="exampleFormControlInput1" class="form-label">Valor de proyecto(${{ number_format($results->first()->TOTAL_PROYECTO, 0, ',', '.') }})</label>
                            <input type="text" name="presupuesto_total" class="form-control custom-input" id="presupuesto_total">
                        </div>
                    </div>
                    <div class="input-group input-group-outline my-3" id="divDescuento">
                        <select class="form-select" aria-label="Default select example" name="descuento" id="descuentoSelect">
                            <option value="" selected>Seleccionar % de descuento</option>
                            <option value="0.01">1%</option>
                            <option value="0.02">2%</option>
                            <option value="0.03">3%</option>
                            <option value="0.04">4%</option>
                            <option value="0.05">5%</option>
                            <option value="0.06">6%</option>
                            <option value="0.07">7%</option>
                            <option value="0.08">8%</option>
                            <option value="0.09">9%</option>   
                            <option value="0.1">10%</option>
                            <!-- Agrega las opciones restantes aquí -->
                        </select><br>
                    </div>
                    <label>Se descontara: <b><span id="valorConDescuento" style="color: black;"></span></b> del subtotal 2</label>
                    {{-- botones --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button id="btnGuardar" type="submit" class="btn btn-success col-3">Guardar</button>
                    </div>
                    {{-- fin botones --}}
                </form>
                {{-- fin formulario --}}
            </div>
        </div>
    </div>
</div>