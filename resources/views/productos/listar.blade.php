@extends('layouts.main')

@section('title')
Cotizacion por producto
@endsection

@section('base')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4" style="color: black;"><b>Cotizaciones por productos</b></h1>
        <div>
            <div>
                <form action="{{ route('productos.crear') }}" method="get" class="d-flex ms-auto">
                    <button type="submit" class="btn btn-success" rel="tooltip" style="margin-bottom: 20px;">
                        Realizar cotizacion </button>
                </form>
            </div>
        </div>
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
                            <th style="color: black;"><b>NIC o CC</b></th>
                            <th style="color: black;"><b>Nombre</b></th>
                            <th style="color: black;"><b>Fecha de creación</b></th>
                            <th style="color: black; text-align: center"><b>Total</b></th>
                            <th style="color: black; text-align: center;"><b>Opciones</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consulta as $item)
                        <tr>
                            <td style="color: black;">{{ $item->NICoCC }}</td>
                            <td style="color: black;">{{ $item->nombre }}</td>
                            <td style="color: black;">{{ $item->created_at }}</td>
                            <td style="color: black;">${{ number_format($item->total, 0, ',', '.') }}</td>
                            <td style="text-align: center;">
                                <form action="{{ route('item.eliminar', $item->NICoCC) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" rel="tooltip" onclick="return confirm('Seguro que quiere eliminar este cliente?')">
                                        <i class="fas fa-trash-alt" title="Eliminar Registro"></i>
                                    </button>
                                </form>

                                <form action="{{ route('item.info', ['id' => $item->NICoCC]) }}" method="POST"  style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
</main>
@endsection

