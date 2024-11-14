    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrar Usuario</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuarios.crear') }}">
                        @csrf
                        <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label for="exampleFormControlSelect1" class="ms-0"></label>

                            <select name="rol_id" class="form-control" id="selectRol1">
                                <option disabled selected>Seleccionar rol</option>
                                @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">
                                    {{ $rol->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Meta comercial</label>
                            <input type="text" class="form-control custom-input" name="meta" required>
                        </div>

                        <hr>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" require>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" require>
                        </div>
                        <div id="mensajeError" style="color: red;"></div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn bg-gradient-success">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- fin Modal -->