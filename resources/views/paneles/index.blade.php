@extends('layout.plantilla')

@section('title')
Usuarios
@endsection

@section('header')

@endsection

@section('base')
<div class="row">
    @include('paneles.crear')
    @include('layout.msj')
    <div class="col-12">
        @if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
        @include('paneles.admin_index')
        @endif

        @if(auth()->user()->hasRole('COMERCIAL'))
        <div class="card my-4" style="display: flex; justify-content: center; align-items: center; height: 800px;">
            <img src="{{ asset('img/bloqueo.svg') }}"
                class="img-fluid border-radius-lg" alt="Responsive image"
                style="max-width: 1300px; max-height: 800px;">
        </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Función para agregar puntos cada tres dígitos y el signo de dólar
    function formatCurrency(number) {
        return '$' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Obtén todos los elementos con la clase 'custom-input'
    var inputElements = document.querySelectorAll('.custom-input');

    // Itera sobre cada input y agrega un escuchador de eventos 'input'
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('input', function(event) {
            // Elimina el signo de dólar y las comas actuales antes de formatear
            var unformattedValue = event.target.value.replace(/\$|,/g, '');

            // Formatea el valor con el signo de dólar y comas cada tres dígitos
            var formattedValue = formatCurrency(unformattedValue);

            // Asigna el valor formateado de vuelta al input
            event.target.value = formattedValue;
        });
    });

    // Agrega un evento 'submit' al formulario para limpiar los valores antes de enviar
    var myForm = document.getElementById('myForm');
    myForm.addEventListener('submit', function() {
        inputElements.forEach(function(inputElement) {
            inputElement.value = inputElement.value.replace(/\$|,/g, '');
        });
    });
</script>

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");

        // Recorre todas las filas de la tabla
        for (i = 0; i < tr.length; i++) {
            tdMarca = tr[i].getElementsByTagName("td")[0]; // Columna de NIC
            tdNombre = tr[i].getElementsByTagName("td")[1]; // Columna de Nombre
            tdTipoCliente = tr[i].getElementsByTagName("td")[2]; // Columna de Tipo de Cliente

            if (tdNombre || tdTipoCliente || tdMarca) {
                txtValueMarca = tdMarca.textContent || tdNombre.innerText;
                txtValueNombre = tdNombre.textContent || tdNombre.innerText;
                txtValueTypeCliente = tdTipoCliente.textContent || tdTipoCliente.innerText;

                // Compara el valor de búsqueda con los textos en ambas columnas
                if (txtValueNombre.toUpperCase().indexOf(filter) > -1 || txtValueTypeCliente.toUpperCase().indexOf(filter) > -1 || txtValueMarca.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    document.getElementById("searchInput").addEventListener("keyup", filterTable);
</script>
@endsection