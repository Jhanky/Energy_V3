@extends('layouts.main')

@section('title')
Presupuesto
@endsection

@section('base')
<main>
    <form action="{{ route('guardar_cotizacion') }}" method="post">
        @csrf
        <h1 class="mt-4" style="color: black;"><b>Cotizar</b></h1>
        <div class="row">
            <div class="col-md-6">
                <label for="NICoCC" class="form-label" style="color: black;"><b>NIC o CC</b></label>
                <input type="text" class="form-control" id="NICoCC" name="NICoCC" required>
                
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label" style="color: black;"><b>Nombre</b></label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered border-success" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success border-success">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Valor Unitario</th>
                            <th>Cantidad</th>
                            <th>IVA</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $product)
                        <tr>
                            <td>
                                {{ $product->tabla }} - {{ $product->marca }}
                                <input type="hidden" name="item[]" value="{{ $product->codigo }}">
                            </td>
                            <td>
                                {{ $product->marca }}
                            </td>
                            <td>
                                ${{ number_format($product->precio, 0) }}
                                <input type="hidden" name="precio[]" value="{{ $product->precio }}">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" class="form-control quantity" name="cantidad[]" min="0">
                                </div>
                            </td>
                            <td><select class="form-select iva" name="iva[]" id="ivaSelect">
                                    <option value="0">0%</option>
                                    <option value="19">19%</option>
                                </select></td>

                            <td>
                                <span class="total-value">$0.00</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><b>Total:</b></td>
                            <td><span id="total">$0.00</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success" style="margin-bottom: 20px;">Guardar</button>
        </div>
    </form>

    <script>
        document.getElementById('ivaSelect').addEventListener('change', function() {
            var selectedValue = this.value;
            if (selectedValue === '19') {
                selectedValue = '0.19';
            }
            document.querySelector('input[name="iva[]"]').value = selectedValue;
        });
    </script>
    <script>
        // Función para calcular el valor total
        function calcularValorTotal() {
            var filas = document.querySelectorAll('#dataTable tbody tr');
            var total = 0;

            filas.forEach(function(fila) {
                var cantidadInput = fila.querySelector('.quantity');
                var cantidad = cantidadInput.value.trim() === '' ? 0 : parseFloat(cantidadInput.value);
                var valorUnitario = parseFloat(fila.querySelector('td:nth-child(3) input').value);
                var iva = parseFloat(fila.querySelector('.iva').value); // Seleccionar el valor de IVA dentro de la fila actual
                var totalProducto = (valorUnitario * cantidad) * (1 + iva / 100);
                total += totalProducto;

                fila.querySelector('.total-value').textContent = '$' + totalProducto.toLocaleString('es-ES', {
                    maximumFractionDigits: 0
                }); // Formatear el valor total sin decimales y con separadores de miles
            });

            document.getElementById('total').textContent = '$' + total.toLocaleString('es-ES', {
                maximumFractionDigits: 0
            }); // Formatear el total general sin decimales y con separadores de miles
        }

        // Evento de cambio en cantidad o IVA
        document.querySelectorAll('.quantity, .iva').forEach(function(element) {
            element.addEventListener('input', function() {
                calcularValorTotal();
            });
        });

        // Calcular el valor total inicialmente
        calcularValorTotal();
    </script>


</main>
@endsection