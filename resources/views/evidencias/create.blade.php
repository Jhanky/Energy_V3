@extends('layout.plantilla')

@section('title', 'Subir Evidencias')

@section('base')
    <div class="container">
        <div class="row">
            <h2>Subir Evidencias para la Orden #{{ $orden->id }}</h2>
            <div class="col-md-6">
                <form action="{{ route('evidencias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="orden_id" value="{{ $orden->id }}">
                    <div class="input-group input-group-outline my-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" required></textarea>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="fotos" class="form-label">Fotos</label>
                        <input class="form-control" type="file" id="fotos" name="fotos[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Evidencias</button>
                </form>
            </div>
        </div>
    </div>
@endsection
