 <!-- Modal para editar proyecto -->
 <div class="modal fade" id="editarProyectoModal{{ $proyecto->id }}" tabindex="-1" aria-labelledby="editarProyectoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarProyectoModalLabel">Editar Proyecto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('proyectos.actualizar', $proyecto->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="nombre" class="form-label">Nombre</label>
                                                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $proyecto->nombre }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="descripcion" class="form-label">Descripción</label>
                                                            <textarea class="form-control" id="descripcion" name="descripcion">{{ $proyecto->descripcion }}</textarea>
                                                        </div>
                                                        <button type="submit" class="btn bg-gradient-primary">Actualizar</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>