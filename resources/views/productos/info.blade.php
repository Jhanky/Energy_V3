@extends('layouts.main')

@section('title')
Cotizacion por producto
@endsection

@section('base')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4" style="color: black;"><b>Informacion</b></h1>
        @foreach ($datos as $dato)
        <b><p style="color: black;">Nombre: {{ $dato->nombre }}</p></b>
        <b><p style="color: black;">NICoCC: {{ $dato->NICoCC }}</p></b>
        @endforeach
        @include('layouts.msj')
        @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
        @endif
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered border-success" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success border-success">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Valor Unitario</th>
                            <th>Cantidad</th>
                            <th>IVA</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td style="color: black;">{{ $item->marca }}</td>
                            <td style="color: black;">{{ $item->modelo }}</td>
                            <td style="color: black;">${{ number_format($item->precio, 0, ',', '.') }}</td>
                            <td style="color: black;">{{ $item->cantida }}</td>
                            <td style="color: black;">{{ $item->IVA }}</td>
                            <td style="color: black;">$<span class="valor-total">0.00</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><b>Total:</b></td>
                            <td id="total">$0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
</main>
@endsection

@section('scripts')
<script>
    // Función para calcular el valor total por fila y actualizar el total general
    function calcularTotales() {
        var totalGeneral = 0;
        var filas = document.querySelectorAll('#dataTable tbody tr');
        filas.forEach(function(fila) {
            var valorUnitario = parseFloat(fila.querySelector('td:nth-child(3)').textContent.replace('$', '').replace(/\./g, '').replace(',', '.'));
            var cantidad = parseInt(fila.querySelector('td:nth-child(4)').textContent);
            var iva = parseInt(fila.querySelector('td:nth-child(5)').textContent);
            var valorTotal = (valorUnitario * cantidad) + (valorUnitario * cantidad * (iva / 100));
            fila.querySelector('.valor-total').textContent = Math.round(valorTotal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            totalGeneral += valorTotal;
        });
        document.getElementById('total').textContent = '$' + Math.round(totalGeneral).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Llamar a la función al cargar la página para calcular los totales iniciales
    window.onload = function() {
        calcularTotales();
    };
</script>
@endsection