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
                  {{ number_format($factura->calcularTotal('excento'), 2, ',', '.') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">Gravado:</td>
                <td class="derecha">
                  {{ number_format($factura->calcularTotal('gravado'), 2, ',', '.') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">IVA:</td>
                <td class="derecha">
                  {{ number_format($factura->calcularTotal('iva'), 2, ',', '.') }}
                </td>
              </tr>
              <tr>
                <th colspan="4" class="derecha">Total:</td>
                <td class="derecha">
                  {{ number_format($factura->calcularTotal('total'), 2, ',', '.') }}
                </td>
              </tr>
            </tfoot>
            <tbody>
              @foreach($factura->items as $item)
                <tr>
                  <td class="derecha">
                    {{ number_format( $item->cantidad, 2, ',', '.' ) }}
                  </td>
                  <td>
                    {{ $item->articulo->nombre }}
                  </td>
                  <td class="derecha">
                    {{ number_format($item->precio, 2, ',', '.') }}
                  </td>
                  <td class="derecha">
                    {{ is_numeric($item->iva) ? $item->iva . '%' : 'Excento' }}
                  </td>
                  <td class="derecha">
                    @if(is_numeric($item->iva))
                      {{ number_format( ($item->precio * $item->cantidad) * (1 + ($item->iva / 100)), 2, ',', '.' )}}
                    @else
                      {{ number_format( $item->precio * $item->cantidad, 2, ',', '.' ) }}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>{{-- /.panel-body --}}

        <div class="panel-footer">
          <a href="{{ url('facturas/pdf/'. $factura->id) }}" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-print"></span>
            PDF
          </a>
          <a href="{{ url('facturas/al-carrito/'. $factura->id) }}" class="btn btn-info btn-sm">
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