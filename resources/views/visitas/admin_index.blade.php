<div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tabla de Visitas</h6>
                    <div class="me-3">
                        <!-- Button trigger modal -->

                        <a class="btn bg-gradient-info"  href="/public/visitas/formulario">Registrar visita</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">NIC</th>
                                <th class="text-uppercase text-xxs text-secondary font-weight-bolder">Nombre</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ciudad</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Dirección</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Responsable</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($visitas as $visita)
                        <tr>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{$visita->NIC}}</p>
                                </td>
                                <td class="align-middle text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{$visita->nombre}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{$visita->ciudad}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{$visita->direccion}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{$visita->nombre_usuario}}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li style="margin-left: 30px; margin-right: 30px">
                                            <form method="POST" action="{{ route('visita.info', ['id' => $visita->id]) }}" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class=" btn btn-info">
                                                    ver mas <i class="material-icons opacity-10">visibility</i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>             
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>