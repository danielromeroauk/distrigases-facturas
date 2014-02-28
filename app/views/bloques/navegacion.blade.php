<nav class="navbar navbar-default" role="navigation" id="menu-top">
  <div class="container-fluid">
    {{-- <!-- Brand and toggle get grouped for better mobile display --> --}}
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">Mostrar/Ocultar navegación</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}">
        <img title="Distrigases" alt="Distrigases" src="{{ url('img/logo-distrigases.png') }}" />
        <span>SISTEMA DE FACTURACIÓN</span>
      </a>
    </div>

    {{-- <!-- Collect the nav links, forms, and other content for toggling --> --}}
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">

        @if(Auth::check())

            @if(Auth::user()->rol == 'administrador')

                <li>
                    <a href="{{ url('users/listado') }}">
                        <span class="glyphicon glyphicon-cog"></span>
                        Usuarios
                    </a>
                </li>

            @endif

          <li>
              <a href="{{ url('articles/listado') }}">
                  <span class="glyphicon glyphicon-shopping-cart"></span>
                  Artículos
              </a>
          </li>

          <li>
              <a href="{{ url('clients/listado') }}">
                  <span class="glyphicon glyphicon-phone-alt"></span>
                  Clientes
              </a>
          </li>

          <li>
              <a href="#">
                  <span class="glyphicon glyphicon-folder-open"></span>&nbsp;
                  Cotizaciones
              </a>
          </li>

          <li>
              <a href="#">
                  <span class="glyphicon glyphicon-briefcase"></span>
                  Facturas
              </a>
          </li>

          <li>
            @if(Session::has('cart'))

              <a href="{{ url('carrito/index') }}">
                Carrito
                <span class="badge">{{ count(Session::get('cart')) }}</span>
              </a>

            @endif
        </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="glyphicon glyphicon-user"></span>
              {{ strtoupper(Auth::user()->nombre) }} <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
              <li>
                <a href="{{ url('users/cambiar-password') }}">
                  <span class="glyphicon glyphicon-lock"></span>
                  Cambiar password</a>
              </li>
              <li>
                <a href="{{ url('users/modificar-perfil') }}">
                <span class="glyphicon glyphicon-wrench"></span>
                Modificar mi perfil</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="{{ url('logout') }}">
                  <span class="glyphicon glyphicon-off"></span>
                  Cerrar sesión</a>
              </li>
            </ul>
          </li>

        @else

          <div class="col-xs-12">
            {{ Form::open(array('url' => 'users/index', 'method' => 'post', 'class' => 'navbar-form navbar-right')) }}
              <div class="form-group">
                {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'Email', 'required', 'autofocus')) }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
                {{ Form::submit('Entrar', array('class' => 'btn btn-default')) }}
              </div>
            {{ Form::close() }}
          </div>

        @endif

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
