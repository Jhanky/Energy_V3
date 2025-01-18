<div class="modal fade" id="EditUsuario{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>
            <div class="modal-body">
                {{-- formulario --}}
                <form action="{{ route('usuarios.actualizar', ['id' => $usuario->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group input-group-outline my-3 focused is-focused focused is-focused">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre" required
                            value="{{ $usuario->nombre }}">
                    </div>
                    <div class="input-group input-group-outline my-3 focused is-focused">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" required
                            value="{{ $usuario->telefono }}">
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
                        <input type="email" class="form-control" name="email" required
                            value="{{ $usuario->email }}">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password1_{{ $usuario->id }}" name="password" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation1_{{ $usuario->id }}"
                            name="password_confirmation" required>
                    </div>
                    <div id="mensajeError1_{{ $usuario->id }}" style="color: red;"></div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn bg-gradient-success" id="submitBtn_{{ $usuario->id }}">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
            var passwordField = document.getElementById('password1_{{ $usuario->id }}');
        var confirmPasswordField = document.getElementById('password_confirmation1_{{ $usuario->id }}');
        var submitBtn = document.getElementById('submitBtn_{{ $usuario->id }}');
        var mensajeError = document.getElementById('mensajeError1_{{ $usuario->id }}');

        function validatePasswords() {
            var password = passwordField.value;
            var confirmPassword = confirmPasswordField.value;
            if (password !== confirmPassword) {
                mensajeError.textContent = 'Las contraseñas no coinciden.';
                submitBtn.disabled = true;
            } else {
                mensajeError.textContent = '';
                submitBtn.disabled = false;
            }
        }

        passwordField.addEventListener('input', validatePasswords);
        confirmPasswordField.addEventListener('input', validatePasswords);

        document.querySelector('form').addEventListener('submit', function(e) {
            if (submitBtn.disabled) {
                e.preventDefault();
            }
        });
    });
</script>
