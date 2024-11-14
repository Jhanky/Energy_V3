<div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de usuarios</h6>
                    <div class="me-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Agregar usuario
                        </button>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="table-responsive">
                    <table id="dataTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telefono</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="https://img.icons8.com/?size=100&id=JE8NQVLQ0pGe&format=png&color=000000" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">{{ $usuario->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $usuario->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $usuario->nombre }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $usuario->telefono }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-notification-{{ $usuario->id }}">
                                                Eliminar<i class="material-icons opacity-10">delete</i>
                                            </button>
                                        </li>
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <button type="button" class="btn btn-info" rel="tooltip" data-bs-toggle="modal" data-bs-target="#EditUsuario{{ $usuario->id }}">
                                                Editar<i class="material-icons opacity-10">edit</i>
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-notification-{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="py-3 text-center">
                                                <img src="{{ asset('img/icons/flags/borrar.gif') }}" alt="Eliminar_icono" style="max-width: 90px; max-height: 90px;">
                                                <h4 class="text-gradient text-danger mt-4">¡Desea eliminar este usuario!</h4>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST" style="display: inline-block; margin-right: 5px;" id="eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn bg-gradient-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('usuarios.editar')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>