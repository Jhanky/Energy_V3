@extends('layout.plantilla')

@section('title')
    Proyectos
@endsection

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('base')
    <div class="row">
        @include('layout.msj')
        @foreach ($listas as $lista)
            <div class="col-3">
                <div class="card mt-4" style="background-color: #d7d7d8;">
                    <div class="card-body">
                        <h6 class="mb-0" style="font-size: 0.9rem;">{{ $lista['name'] }}</h6>

                        <!-- Verificar si hay tarjetas en la lista -->
                        @if (!empty($lista['cards']) && count($lista['cards']) > 0)
                            @php $card = $lista['cards'][0]; @endphp
                            <!-- Card con imagen de portada de la primera tarjeta -->
                            <div class="card mt-1" onclick="disenos('{{ $lista['pos'] }}')">
                                <div class="card-body" style="font-size: 0.85rem;">
                                    <!-- Mostrar la imagen de portada si existe -->
                                    @if (!empty($card['coverUrl']))
                                        <img src="https://immodo.es/wp-content/uploads/2023/06/planta-solar-2048x1151.jpg"
                                            style="display: block; width: 100%; height: auto;"
                                            alt="Portada de {{ $lista['name'] }}">
                                    @else
                                        <img src="URL_DE_IMAGEN_POR_DEFECTO" class="card-img" alt="Imagen por defecto">
                                    @endif
                                    <h6 class="mb-0" style="font-size: 0.9rem;">Diseño</h6>
                                    <p class="mb-2" style="color: black">
                                        <b>{{ $card['completedCheckItems'] }}/{{ $card['totalCheckItems'] }}</b>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                            width="20px" fill="#5f6368" style="color: black">
                                            <path
                                                d="M216-144q-29.7 0-50.85-21.15Q144-186.3 144-216v-528q0-29.7 21.15-50.85Q186.3-816 216-816h528.25q7.54 0 14.15 2 6.6 2 12.6 4l-66 66H216v528h528v-233l72-72v305q0 29.7-21.15 50.85Q773.7-144 744-144H216Zm265-144L265-505l51-51 165 166 333-332 51 51-384 383Z" />
                                        </svg>
                                    </p>
                                </div>
                            </div>
                        @else
                            <!-- Mensaje o imagen por defecto si no hay tarjetas -->
                            <div class="card mt-1">
                                <div class="card-body" style="font-size: 0.85rem;">
                                    <img src="URL_DE_IMAGEN_POR_DEFECTO" class="img-fluid border-radius-lg"
                                        alt="No hay tarjetas disponibles">
                                    <h6 class="mb-0" style="font-size: 0.9rem;">No hay tarjetas disponibles</h6>
                                </div>
                            </div>
                        @endif
                        <!-- Modal planeación y diseño-->
                        <div class="modal fade" id="diseno-{{ $lista['pos'] }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $lista['name'] }}</h5>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($lista['cards'] as $card)
                                            <h6>{{ $card['name'] }}</h6>
                                            <input type="hidden" name="cardId" value="{{ $card['id'] }}">
                                            <!-- Agregar cardId -->
                                            @foreach ($card['checklists'] as $checklist)
                                                <h6>{{ $checklist['name'] }}</h6>
                                                @foreach ($checklist['checkItems'] as $checkItem)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="check_{{ $checkItem['id'] }}"
                                                            name="checkItems[{{ $checkItem['id'] }}]"
                                                            {{ $checkItem['state'] === 'complete' ? 'checked' : '' }}
                                                            onchange="updateChecklistItem('{{ $card['id'] }}', '{{ $checkItem['id'] }}', this.checked)">
                                                        <label class="custom-control-label"
                                                            for="check_{{ $checkItem['id'] }}">
                                                            {{ $checkItem['name'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        function disenos(pos) {
            $('#diseno-' + pos).modal('show');
        }
    </script>

    <script>
        function updateChecklistItem(cardId, checkItemId, isChecked) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            const state = isChecked ? 'complete' : 'incomplete';
            fetch(`/update-checklist-item/${cardId}/${checkItemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    },
                    body: JSON.stringify({
                        state: state
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Checklist item updated successfully');
                    } else {
                        console.error('Error updating checklist item:', data.message);
                    }
                })
                .catch(error => console.error('Request failed', error));
        }
    </script>

    <!-- Bootstrap JS and jQuery (para hacer funcionar el modal) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
