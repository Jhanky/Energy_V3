@extends('layout.plantilla')

@section('title')

Info - Visita
@endsection

@section('header')
<style>
    .carousel-inner>.carousel-item>img {
        max-width: 100%;
        max-height: 600px;
        width: auto;
        height: auto;
        margin: auto;
    }

    .carousel {
        max-width: 1000px;
        margin: 0 auto;
        /* Centra el carrusel horizontalmente */
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: #000;
        border-radius: 50%;
        padding: 10px;
    }

    .carousel-item {
        text-align: center;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('base')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="container">
                    <h1>Detalles de la Visita</h1>
                    <div class="row">
                        <div class="col">
                            <h3>Información del Cliente</h3>
                            <ul class="list-unstyled">
                                <li><strong>Nombre:</strong> {{ $visita->nombre }}</li>
                                <li><strong>NIC:</strong> {{ $visita->NIC }}</li>
                                <li><strong>Teléfono:</strong> {{ $visita->telefono }}</li>
                                <li><strong>Departamento:</strong> {{ $visita->departamento }}</li>
                                <li><strong>Ciudad:</strong> {{ $visita->ciudad }}</li>
                                <li><strong>Dirección:</strong> {{ $visita->direccion }}</li>
                            </ul>
                            <br>
                            <h3>Área de Instalación de los Paneles</h3>
                            <ul class="list-unstyled">
                                <li><strong>Tipo de Superficie:</strong> {{ $visita->tipo_superficie }}</li>
                                <li><strong>Ancho:</strong> {{ $visita->ancho }} m</li>
                                <li><strong>Largo:</strong> {{ $visita->largo }} m</li>
                                <li><strong>Observaciones:</strong> {{ $visita->notas_observaciones ?? 'N/A' }}</li>
                            </ul>

                            @if($visita->foto_techo)
                            <h4>Fotos del Techo</h4>
                            <div id="carouselTecho" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach(json_decode($visita->foto_techo) as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100" alt="Foto del Techo">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselTecho" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselTecho" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                            @endif

                            <br>
                            <h3>Soporte del Techo o Sobre Estructura</h3>
                            <ul class="list-unstyled">
                                <li><strong>Notas sobre el Soporte del Techo:</strong> {{ $visita->notas_soporte_tejado ?? 'N/A' }}</li>
                                <li><strong>Refuerzos:</strong> {{ $visita->refuerzo }}</li>
                                <li><strong>Sobre Estructura:</strong> {{ $visita->sobre_estructura }}</li>
                            </ul>

                            @if($visita->foto_soporte)
                            <h4>Fotos del Soporte</h4>
                            <div id="carouselSoporte" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach(json_decode($visita->foto_soporte) as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100" alt="Foto del Soporte">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselSoporte" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselSoporte" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                            @endif

                            <br>
                            <h3>Opciones para los Bajantes</h3>
                            <ul class="list-unstyled">
                                <li><strong>Opción 1:</strong> {{ $visita->opcion_1 }} ({{ $visita->distancia_1 }} m)</li>
                                <li><strong>Opción 2:</strong> {{ $visita->opcion_2 }} ({{ $visita->distancia_2 }} m)</li>
                                <li><strong>Opción 3:</strong> {{ $visita->opcion_3 }} ({{ $visita->distancia_3 }} m)</li>
                                <li><strong>Observaciones sobre los Bajantes:</strong> {{ $visita->notas_observaciones_bajantes ?? 'N/A' }}</li>
                            </ul>

                            @if($visita->foto_bajante)
                            <h4>Ubicación de los Posibles Bajantes</h4>
                            <div id="carouselBajante" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach(json_decode($visita->foto_bajante) as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100" alt="Foto del Bajante">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselBajante" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselBajante" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                            @endif

                            <br>
                            <h3>Área Disponible para la Instalación del Inversor</h3>
                            <ul class="list-unstyled">
                                <li><strong>Distancia al Tablero Fotovoltaico:</strong> {{ $visita->distancia_tfv }} m</li>
                                <li><strong>Observaciones:</strong> {{ $visita->notas_observaciones_tbl ?? 'N/A' }}</li>
                            </ul>

                            @if($visita->foto_inversor)
                            <h4>Ubicación del Inversor</h4>
                            <div id="carouselInversor" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach(json_decode($visita->foto_inversor) as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100" alt="Foto del Inversor">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselInversor" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselInversor" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                            @endif

                            <br>
                            <h3>Información del Tablero Eléctrico</h3>
                            <ul class="list-unstyled">
                                <li><strong>Tipo de Red:</strong> {{ $visita->tipo_red }}</li>
                                <li><strong>Espacio para Breaker:</strong> {{ $visita->espacio_breaker }}</li>
                                <li><strong>Espacio para el Breaker de Inyección Solar:</strong> {{ $visita->espacio_ct }}</li>
                                <li><strong>Puesta a Tierra:</strong> {{ $visita->departamento }}</li>
                                <li><strong>Calibre del Cable:</strong> {{ $visita->ciudad }}</li>
                                <li><strong>Totalizador:</strong> {{ $visita->totalizador }}</li>
                            </ul>

                            @if($visita->foto_tablero)
                            <h4>Fotos del Tablero Eléctrico</h4>
                            <div id="carouselTablero" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach(json_decode($visita->foto_tablero) as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100" alt="Foto del Tablero">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselTablero" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselTablero" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (opcional, para la funcionalidad del carrusel) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('scripts')

@endsection