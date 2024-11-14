<div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Inversores</h6>
                    <div class="me-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#agregarPanel">
                            Agregar Inversor
                        </button>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="table-responsive">
                    <table id="dataTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Marca</th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Modelo</th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Tipo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Tipo de red</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Potencia</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Precio</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inversores as $inversor)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $inversor->marca }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $inversor->modelo }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $inversor->tipo }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $inversor->tipo_red }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ number_format($inversor->poder, 0, ',', '.') }}kW</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">$ {{ number_format($inversor->precio, 0, ',', '.') }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $inversor->id }}">
                                                Eliminar<i class="material-icons opacity-10">delete</i>
                                            </button>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="button" class=" btn btn-info" rel="tooltip" data-bs-toggle="modal" data-bs-target="#EditInversor{{ $inversor->id }}">
                                                Editar<i class="material-icons opacity-10">edit</i>
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-notification-{{ $inversor->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar el Inversor!</h4>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('inversores.eliminar', $inversor->id) }}" method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('inversores.editar')
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>