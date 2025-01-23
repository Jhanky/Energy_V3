<div class="col-lg-12">
    <!---msj de registrado correctamente -->
    @if(session()->has('rgcmessage'))
    <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
        <span class="alert-icon align-middle">
          <span class="material-icons text-md">
          thumb_up_off_alt
          </span>
        </span>
        <span class="alert-text">{{ session()->get('rgcmessage') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!--msj de registro eliminado correctamente --->
    @if(session()->has('msjdelete'))
        <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
        <span class="alert-icon align-middle">
          <span class="material-icons text-md">
          thumb_up_off_alt
          </span>
        </span>
        <span class="alert-text">{{ session()->get('msjdelete') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!---msjs de actualizar registro correctamente-->
    @if(session()->has('msjupdate'))
    <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
        <span class="alert-icon align-middle">
          <span class="material-icons text-md">
          thumb_up_off_alt
          </span>
        </span>
        <span class="alert-text">{{ session()->get('msjupdate') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!---msjs de error en la validación de archivos-->
    @if($errors->has('foto'))
    <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
        <span class="alert-icon align-middle">
          <span class="material-icons text-md">
          error_outline
          </span>
        </span>
        <span class="alert-text">{{ $errors->first('foto') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
</div>
