@extends('layouts.master')

@section('contenido')

<div class="container">
  <h1>Contenido del carrito</h1>
  <table class="table table-hover table-striped">
    <thead>
      <th>Id</th>
      <th>Artículo</th>
      <th>Cantidad</th>
      <th>Acción</th>
    </thead>
    <tbody>
      @foreach(Session::get('carrito') as $item)
          <tr>
              <td>
                {{ $item['articulo']->id }}
              </td>
              <td>
                {{ $item['articulo']->nombre }}
              </td>
              <td>
                {{ $item['cantidad'] }}
              </td>
              <td>
                <a href="{{ url('carrito/quitar-item/'. $item['articulo']->id) }}" class="btn btn-warning btn-xs">
                  <span class="glyphicon glyphicon-remove"></span>
                  Quitar
                </a>
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#factura" data-toggle="tab">Procesar como factura</a></li>
      <li><a href="#cotizacion" data-toggle="tab">Procesar como cotización</a></li>
    </ul>

    <div class="tab-content">

      <div class="tab-pane fade in active" id="factura">

        {{ Form::open(array('url' => 'facturas/nueva')) }}

          <div class="input-group">
            <span class="input-group-addon">Cliente: </span>
            {{ Form::text('nombre', (Session::has('cliente')) ? Session::get('cliente')->nombre : '', array('class' => 'form-control', 'placeholder' => 'Nombre completo o razón social', 'required', 'maxlength' => '255', 'disabled')) }}
            <span class="input-group-addon">
              <a href="{{ url('clientes/listado') }}">
                <span class="glyphicon glyphicon-search"></span>
                Examinar
              </a>
            </span>
          </div>

          <div class="input-group">
            <span class="input-group-addon">Vencimiento: </span>
            {{ Form::input('date', 'vencimiento',
              (isset($vencimiento)) ? $vencimiento : date('Y-m-d'),
              array('class' => 'form-control')) }}

            <span class="input-group-addon">Pedido: </span>
            {{ Form::input('number', 'pedido',
              (Session::has('cliente')) ? Session::get('cliente')->siguientePedido() : '',
              array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-success')) }}
            {{ Form::textarea('notas','', array('class' => 'form-control', 'placeholder' => 'Número de la factura física, etc.', 'maxlength' => '255', 'rows' => '3')) }}
          </div>

          <button type="submit" class="btn btn-success">
            Guardar factura
          </button>

          <a href="{{ url('facturas') }}" class="btn btn-danger">
            Cancelar
          </a>

        {{ Form::close() }}
      </div>{{-- /#factura --}}

      <div class="tab-pane fade" id="cotizacion">

        {{ Form::open(array('url' => 'cotizaciones/nueva')) }}

          <div class="input-group">
            <span class="input-group-addon">Cliente: </span>
            {{ Form::text('nombre', (Session::has('cliente')) ? Session::get('cliente')->nombre : '', array('class' => 'form-control', 'placeholder' => 'Nombre completo o razón social', 'required', 'maxlength' => '255', 'disabled')) }}
            <span class="input-group-addon">
              <a href="{{ url('clientes/listado') }}">
                <span class="glyphicon glyphicon-search"></span>
                Examinar
              </a>
            </span>
          </div>

          <div class="input-group">
            <span class="input-group-addon">Concepto: </span>
            {{ Form::text('concepto', 'En atención a su amable solicitud de cotización, me permito presentar mi propuesta comercial de la siguiente manera:', array('class' => 'form-control', 'placeholder' => 'Concepto', 'required', 'maxlength' => '255')) }}
          </div>

          <div class="form-group">
            {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-primary')) }}
            {{ Form::textarea('notas','', array('class' => 'form-control', 'placeholder' => 'Postdatas, caducidad de la cotización, etc.', 'maxlength' => '255', 'rows' => '3')) }}
          </div>

          <button type="submit" class="btn btn-primary">
            Guardar cotización
          </button>

          <a href="{{ url('cotizaciones') }}" class="btn btn-info">
            Cancelar
          </a>

        {{ Form::close() }}

      </div>{{-- /#cotizacion --}}

    </div>{{-- /.tab-content --}}

</div>{{-- /.container --}}

@stop
