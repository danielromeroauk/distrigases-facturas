<div class="container">
    @if(Session::has('mensajeError'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('mensajeError') }}
        </div>
    @endif
    @if(Session::has('mensajeOk'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('mensajeOk') }}
        </div>
    @endif
</div>