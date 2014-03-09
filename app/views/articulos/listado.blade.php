@extends('layouts.master')

@section('contenido')

<div class="container">

  <h1>Artículos</h1>


  {{ Form::open(array('url' => 'articulos/filtro', 'class' => 'form-inline', 'role' => 'form', 'method' => 'get')) }}

    <div class="buscador col-md-6 col-sm-9 col-xs-10 col-lg-10">

      <div class="input-group">

        <span class="input-group-addon input-sm">
          {{ Form::radio('filtro', 'id') }}
          Id
        </span>

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
    <h3>
      {{ $articulo->nombre }}
      <a href="{{ url('articles/editar/'. $articulo->id) }}" class="btn btn-xs btn-warning">
        <span class="glyphicon glyphicon-edit"></span>
        Editar
      </a>
    </h3>
    <ul class="list-group">
      <li class="list-group-item">
        Id: {{ $articulo->id }}
      </li>
      @if($articulo->notas != '')
        <li class="list-group-item">
          {{ $articulo->notas }}
        </li>
      @endif
      <li class="list-group-item">
        Precio: {{ $articulo->precio }}
      </li>
      <li class="list-group-item">
        IVA:
        @if(is_numeric($articulo->iva))
          {{ $articulo->iva }}%
        @else
          Excento
        @endif
      </li>
      <li class="list-group-item">

        {{ Form::open(array('url' => 'carrito/agregar', 'role' => 'form')) }}

          {{ Form::hidden('id', $articulo->id) }}

          {{ Form::input('number', 'cantidad', '1', array('class' => 'numero form-control input-sm', 'min' => '0.01', 'step' => '0.01', 'max' => '99999999999999.99', 'title' => 'Cantidad', 'required')) }}

          <button class="btn btn-sm btn-info">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            Añadir
          </button>

        {{ Form::close() }}
      </li>
    </ul>
    </div>
  @endforeach

  @if(isset($input))
    {{ $articulos->appends(array_except($input, 'page'))->links(); }}
  @else
    {{ $articulos->links() }}
  @endif

</div>{{-- /.container --}}

@stop