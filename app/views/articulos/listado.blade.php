@extends('layouts.master')

@section('head')
  @parent

  {{ HTML::script('js/cambiar-imagen.js') }}

@stop

@section('contenido')

<div class="container">

  <h1>Artículos</h1>


  {{ Form::open(array('url' => 'articulos/filtro', 'class' => 'form-inline', 'role' => 'form', 'method' => 'get')) }}

    <div class="buscador col-md-6 col-sm-9 col-xs-10 col-lg-10">

      <div class="input-group">

        <span class="input-group-addon input-sm">
          {{ Form::radio('filtro', 'notas') }}
          Código de barras
        </span>

        <span class="input-group-addon input-sm">
          {{ Form::radio('filtro', 'nombre', array('checked')) }}
          Nombre
        </span>

        {{ Form::text('buscar', '', array('class' => 'form-control input-sm', 'placeholder' => 'Buscar...')) }}

      </div>{{-- /.input-group --}}

    </div>{{-- /.col-xs-* --}}

    <button type="submit" class="btn btn-primary btn-sm">
      <span class="glyphicon glyphicon-search"></span>
      Buscar
    </button>

    <a href="{{ url('articulos/nuevo') }}" class="btn btn-success btn-sm">
      <span class="glyphicon glyphicon-plus"></span>
      Nuevo
    </a>

  {{ Form::close() }}

  <p> </p>

  @foreach($articulos as $articulo)
    <div class="col-sm-6 col-md-4">

    <ul class="list-group">

      <div class="imagen">
        <div class="preview thumbnail">
          <span class="file-info" id="div-{{$articulo->id}}" data-articulo="{{$articulo->id}}"></span>
          <a href="#" class="btn btn-default file-select" data-articulo="{{$articulo->id}}">Cambiar imagen</a>
          @if($articulo->imagen)
            <img src="{{ url('img/articulos/'. $articulo->imagen->ruta) }}" id="img-{{$articulo->id}}" />
          @else
            <img src="http://placehold.it/640x360" id="img-{{$articulo->id}}" />
          @endif
        </div>

        {{ Form::open(array('url' => 'articulos/cambiar-imagen/'.$articulo->id, 'class' => 'file-submit', 'files' => true)) }}
            <input id="file-{{$articulo->id}}" name="imagen" type="file" data-articulo="{{$articulo->id}}" />
        {{ Form::close() }}
      </div>{{-- /.imagen --}}

      <li class="list-group-item">
        <h2>
          {{ $articulo->nombre }}

        </h2>
      </li>

      @if($articulo->notas != '')
        <li class="list-group-item">
          {{ $articulo->notas }}
        </li>
      @endif

      <li class="list-group-item">
        <h3>
          COP$
          @if(is_numeric($articulo->iva))
            {{ number_format($articulo->precio * (1 + ($articulo->iva / 100)), 2, ',', '.') }}
            <small>
              IVA del {{ $articulo->iva }}% incluido
            </small>
          @else
            {{ $articulo->precio }}
            <small>
              Excento de IVA
            </small>
          @endif
        </h3>
      </li>

      <li class="list-group-item">

        {{ Form::open(array('url' => 'carrito/agregar', 'role' => 'form')) }}

          {{ Form::hidden('id', $articulo->id) }}

          {{ Form::input('number', 'cantidad', '1', array('class' => 'numero form-control input-sm', 'min' => '0.01', 'step' => '0.01', 'max' => '99999999999999.99', 'title' => 'Cantidad', 'required')) }}

          <button class="btn btn-sm btn-info">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            Añadir
          </button>

          <a href="{{ url('articulos/editar/'. $articulo->id) }}" class="btn btn-sm btn-default">
            <span class="glyphicon glyphicon-edit"></span>
            Editar
          </a>

        {{ Form::close() }}
      </li>

    </ul>

    </div>{{-- /.col-sm-6.col-md-4 --}}
  @endforeach

  @if(isset($input))
    {{ $articulos->appends(array_except($input, 'page'))->links(); }}
  @else
    {{ $articulos->links() }}
  @endif

</div>{{-- /.container --}}

@stop