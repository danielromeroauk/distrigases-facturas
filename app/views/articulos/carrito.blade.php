@extends('layouts.master')

@section('contenido')

<div class="container">
  <h1>Contenido del carrito</h1>
  <table class="table table-hover table-striped">
    <thead>
      <th>Acción</th>
      <th class="derecha">Cantidad</th>
      <th>Artículo</th>
      <th class="derecha">Precio</th>
      <th class="derecha">IVA</th>
      <th class="derecha">Total</th>
    </thead>
    <tbody>
      @foreach(Session::get('carrito') as $item)
          <tr>
              <td>
                <a href="{{ url('carrito/quitar-item/'. $item['articulo']->id) }}" class="btn btn-warning btn-xs">
                  <span class="glyphicon glyphicon-remove"></span>
                  Quitar
                </a>
              </td>
              <td class="derecha">
                {{ number_format($item['cantidad'], 2, ',', '.') }}
              </td>
              <td>
                {{ $item['articulo']->nombre }}
              </td>
              <td class="derecha">
                {{ $item['articulo']->precio }}
              </td>
              <td class="derecha">
                {{ is_numeric($item['articulo']->iva) ? $item['articulo']->iva . '%' : 'Excento' }}
              </td>
              <td class="derecha">
                @if(is_numeric($item['articulo']->iva))
                  {{ number_format( ($item['articulo']->precio * $item['cantidad']) * (1 + ($item['articulo']->iva / 100)), 2, ',', '.' )}}
                @else
                  {{ number_format( $item['articulo']->precio * $item['cantidad'], 2, ',', '.' ) }}
                @endif
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#totales" data-toggle="tab">Totales</a></li>
      <li><a href="#factura" data-toggle="tab">Procesar como factura</a></li>
      <li><a href="#cotizacion" data-toggle="tab">Procesar como cotización</a></li>
    </ul>

    <div class="tab-content">

      <div class="tab-pane fade in active" id="totales">
        <ul class="list-group">
          <li class="list-group-item derecha">
            Excento:
            {{ number_format( CarritoController::calcularTotal('excento'), 2, ',', '.' ) }}
          </li>
          <li class="list-group-item derecha">
            Gravado:
            {{ number_format( CarritoController::calcularTotal('gravado'), 2, ',', '.' ) }}
          </li>
          <li class="list-group-item derecha">
            IVA: {{ number_format( CarritoController::calcularTotal('iva'), 2, ',', '.' ) }}
          </li>
          <li class="list-group-item derecha">
            <strong>
              Total: COP$ {{ number_format( CarritoController::calcularTotal('total'), 2, ',', '.' ) }}
            </strong>
          </li>
        </ul>
      </div> {{-- /#totales --}}

      <div class="tab-pane fade" id="factura">

        {{ Form::open(array('url' => 'facturas/nueva')) }}

          <div class="input-group">
            <span class="input-group-addon">Cliente: </span>
            {{ Form::text('nombre', (Session::has('cliente')) ? Session::get('cliente')->nombre : '', array('class' => 'form-control', 'placeholder' => 'Nombre completo o razón social', 'required', 'maxlength' => '255', 'disabled')) }}
            <span class="input-group-addon">
              <a href="{{ url('clientes/listado?url=carrito') }}">
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
              <a href="{{ url('clientes/listado?url=carrito') }}">
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
