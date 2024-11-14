<div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tabla De Baterías</h6>
                    <div class="me-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#agregarPanel">
                            Agregar Batería
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
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo de bateria</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Voltaje</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amperios hora</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($baterias as $bateria)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $bateria->marca }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $bateria->tipo }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $bateria->voltaje }}V</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $bateria->amperios_hora }}Ah</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">$ {{ number_format($bateria->precio, 0, ',', '.') }}</p>
                                </td>

                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $bateria->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $bateria->id }}">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $bateria->id }}">
                                                Eliminar<i class="material-icons opacity-10">delete</i>
                                            </button>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="button" class=" btn btn-info" rel="tooltip" data-bs-toggle="modal" data-bs-target="#EditBateria{{ $bateria->id }}">
                                                Editar<i class="material-icons opacity-10">edit</i>
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-notification-{{ $bateria->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar la bateía!</h4>
                                                <p>Si borra el cable todos los proyectos se veran afectados</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('baterias.eliminar', $bateria->id) }}" method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('baterias.editar')
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>