@extends('layouts.master')

@section('contenido')

  <div class="container">

    <h1>Facturas
      <button class="btn btn-info btn-sm" id="btnFiltrar">
          <span class="glyphicon glyphicon-filter"></span>
          Filtros
      </button>
    </h1>

    @include('facturas.filtros')

    @foreach($facturas as $factura)

    <div class="col-lg-6">
      <div class="panel panel-primary">

        <div class="panel-heading">
          # {{ $factura->id }}
          <div class="pull-right" title="Registrado por {{ $factura->user->nombre }}">
            Fecha: {{ $factura->created_at }}
          </div>
        </div>{{-- /.panel-heading --}}

        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <strong>Cliente:</strong> {{ $factura->cliente->nombre }}
            </li>
            @if($factura->notas != '')
              <li class="list-group-item">
                <strong>Notas:</strong> {{ $factura->notas }}
              </li>
            @endif
          </ul>
          <ul class="breadcrumb">
            <li class="active">
              <strong>Pedido:</strong> {{ $factura->pedido }}
            </li>
            <li>
              <strong>Vencimiento:</strong> {{ date_format(new DateTime($factura->vencimiento), 'Y-m-d') }}
            </li>
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
                  {{ $factura->calcularTotal('excento') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">Gravado:</td>
                <td class="derecha">
                  {{ $factura->calcularTotal('gravado') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">IVA:</td>
                <td class="derecha">
                  {{ $factura->calcularTotal('iva') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">Total:</td>
                <td class="derecha">
                  {{ $factura->calcularTotal('total') }}
                </td>
              </tr>
            </tfoot>
            <tbody>
              @foreach($factura->items as $item)
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
          <a href="{{ url('facturas/membrete/true/'. $factura->id) }}" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-send"></span>
            Con membrete
          </a>
          <a href="{{ url('facturas/membrete/false/'. $factura->id) }}" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-print"></span>
            Sin membrete
          </a>
          <a href="{{ url('carrito/desde-factura/'. $factura->id) }}" class="btn btn-info btn-sm">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            Artículos al carrito
          </a>
        </div>{{-- /.panel-footer --}}

      </div>{{-- /.panel --}}
    </div>{{-- /.col-md-4 --}}

    @endforeach

    @if(isset($input))
      {{ $facturas->appends(array_except($input, 'page'))->links(); }}
    @else
      {{ $facturas->links() }}
    @endif

  </div>{{-- /.container --}}

@stop