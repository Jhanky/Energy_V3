@extends('layout.plantilla')

@section('title')
Cliente
@endsection

@section('header')

@endsection

@section('base')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card">
                <div class="table-responsive">
                    <table id="dataTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">Usuario</th>
                                <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">Fecha</th>
                                <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">Hola de inicio</th>
                                <th class="text-center text-uppercase text-xxs text-secondary font-weight-bolder">Hola de cierre</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Duración(Minutos)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $session)
                            <tr>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $session->user->name }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $session->date }}</p>
                                </td>
                                <td class="align-middle text-center  text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $session->created_at->format('H:i:s') }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $session->updated_at ? $session->updated_at->format('H:i:s') : 'En curso' }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ is_numeric($session->duration) ? $session->duration . ' minutos' : $session->duration }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection