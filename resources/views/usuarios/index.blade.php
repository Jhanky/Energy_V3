@extends('layout.plantilla')

@section('title')
Usuarios
@endsection

@section('header')


@endsection

@section('base')
<div class="row">
    @include('usuarios.crear')
    @include('layout.msj')
    <div class="col-12">
    @if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
        @include('usuarios.admin_index')
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
    // Función para verificar si las contraseñas coinciden
    function verificarCoincidencia() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("password_confirmation").value;
        var mensajeError = document.getElementById("mensajeError");

        if (password !== confirmPassword) {
            mensajeError.innerHTML = "Las contraseñas no coinciden.";
        } else {
            mensajeError.innerHTML = "";
        }
    }

    // Agregar un evento 'input' a los campos de contraseña para llamar a la función verificarCoincidencia()
    document.getElementById("password").addEventListener("input", verificarCoincidencia);
    document.getElementById("password_confirmation").addEventListener("input", verificarCoincidencia);
</script>

<script>
    // Función para verificar si las contraseñas coinciden
    function verificarCoincidencia() {
        var password = document.getElementById("password1").value;
        var confirmPassword = document.getElementById("password_confirmation1").value;
        var mensajeError = document.getElementById("mensajeError1");

        if (password !== confirmPassword) {
            mensajeError.innerHTML = "Las contraseñas no coinciden.";
        } else {
            mensajeError.innerHTML = "";
        }
    }

    // Agregar un evento 'input' a los campos de contraseña para llamar a la función verificarCoincidencia()
    document.getElementById("password1").addEventListener("input", verificarCoincidencia);
    document.getElementById("password_confirmation1").addEventListener("input", verificarCoincidencia);
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
            var tdMarca = tr[i].getElementsByTagName("td")[0];
            var tdModelo = tr[i].getElementsByTagName("td")[1];

            if (tdMarca && tdModelo) {
                var txtValueMarca = tdMarca.textContent || tdMarca.innerText;
                var txtValueModelo = tdModelo.textContent || tdModelo.innerText;

                // Compara el valor de búsqueda con los textos en todas las columnas
                if (txtValueMarca.toUpperCase().indexOf(filter) > -1 ||
                    txtValueModelo.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    document.getElementById("searchInput").addEventListener("keyup", filterTable);
</script>

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
@endsection