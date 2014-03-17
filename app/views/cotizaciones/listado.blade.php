@extends('layouts.master')

@section('contenido')

  <div class="container">

    <h1>Cotizaciones
      <button class="btn btn-info btn-sm" id="btnFiltrar">
          <span class="glyphicon glyphicon-filter"></span>
          Filtros
      </button>
    </h1>

    @include('cotizaciones.filtros')

    @foreach($cotizaciones as $cotizacion)

    <div class="col-lg-6">
      <div class="panel panel-success">

        <div class="panel-heading">
          # {{ $cotizacion->id }}
          <div class="pull-right" title="Registrado por {{ $cotizacion->user->nombre }}">
            Fecha: {{ $cotizacion->created_at }}
          </div>
        </div>{{-- /.panel-heading --}}

        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <strong>Cliente:</strong> {{ $cotizacion->cliente->nombre }}
            </li>
            @if($cotizacion->concepto != '')
              <li class="list-group-item">
                <strong>Concepto:</strong> {{ $cotizacion->concepto }}
              </li>
            @endif
            @if($cotizacion->notas != '')
              <li class="list-group-item">
                <strong>Notas:</strong> {{ $cotizacion->notas }}
              </li>
            @endif
          </ul>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="derecha">Cantidad</th>
                <th>Artículo</th>
                <th class="derecha">Precio</th>
                <th class="derecha">IVA</th>
                <th class="derecha">Total</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th colspan="4" class="derecha">Excento:</td>
                <td class="derecha">
                  {{ $cotizacion->calcularTotal('excento') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">Gravado:</td>
                <td class="derecha">
                  {{ $cotizacion->calcularTotal('gravado') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">IVA:</td>
                <td class="derecha">
                  {{ $cotizacion->calcularTotal('iva') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">Total:</td>
                <td class="derecha">
                  {{ $cotizacion->calcularTotal('total') }}
                </td>
              </tr>
            </tfoot>
            <tbody>
              @foreach($cotizacion->items as $item)
                <tr>
                  <td class="derecha">
                    {{ $item->cantidad }}
                  </td>
                  <td>
                    {{ $item->articulo->nombre }}
                  </td>
                  <td class="derecha">
                    {{ $item->precio }}
                  </td>
                  <td class="derecha">
                    {{ is_numeric($item->iva) ? $item->iva . '%' : 'Excento' }}
                  </td>
                  <td class="derecha">
                    @if(is_numeric($item->iva))
                      {{ ($item->precio * $item->cantidad) * (1 + ($item->iva / 100)) }}
                    @else
                      {{ $item->precio * $item->cantidad }}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>{{-- /.panel-body --}}

        <div class="panel-footer">
          <a href="{{ url('cotizaciones/membrete/true/'. $cotizacion->id) }}" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-send"></span>
            Con membrete
          </a>
          <a href="{{ url('cotizaciones/membrete/false/'. $cotizacion->id) }}" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-print"></span>
            Sin membrete
          </a>
          <a href="{{ url('carrito/desde-cotizacion/'. $cotizacion->id) }}" class="btn btn-info btn-sm">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            Artículos al carrito
          </a>
        </div>{{-- /.panel-footer --}}

      </div>{{-- /.panel --}}
    </div>{{-- /.col-md-4 --}}

    @endforeach

    @if(isset($input))
      {{ $cotizaciones->appends(array_except($input, 'page'))->links(); }}
    @else
      {{ $cotizaciones->links() }}
    @endif

  </div>{{-- /.container --}}

@stop