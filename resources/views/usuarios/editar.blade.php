<div class="modal fade" id="EditUsuario{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
                {{-- formulario --}}
                <form action="{{ route('usuarios.actualizar', ['id' =>$usuario->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group input-group-outline my-3 focused is-focused focused is-focused">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" required value="{{ $usuario->nombre }}">
                        </div>
                        <div class="input-group input-group-outline my-3 focused is-focused">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" required value="{{ $usuario->telefono }}">
                        </div>
                        <div class="input-group input-group-outline my-3 focused is-focused">
                            <label class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" name="name" required value="{{ $usuario->name }}">
                        </div>
                        <div class="input-group input-group-outline my-3 focused is-focused">
                            <label for="exampleFormControlSelect1" class="ms-0"></label>
                            <select name="rol_id" class="form-control" id="exampleFormControlSelect1">
                            <option disabled selected>{{ $usuario->ROL }}</option>
                                @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="input-group input-group-outline my-3 focused is-focused">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{ $usuario->email }}">
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password1" name="password" require>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation1" name="password_confirmation" require>
                        </div>
                        <div id="mensajeError1" style="color: red;"></div>
                        <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn bg-gradient-success">
                                {{ __('Actualizar') }}
                            </button>
                        </div>
                    </div>
                </form>
                {{-- fin formulario --}}
            </div>
        </div>
    </div>
</div>
