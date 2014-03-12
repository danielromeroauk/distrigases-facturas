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

    <div class="col-md-6">
      <div class="panel panel-primary">

        <div class="panel-heading" title="Registrado por {{ $factura->user->nombre }}">
          # {{ $factura->id }}
          <div class="pull-right">
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
                      0.00
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>{{-- /.panel-body --}}

        <div class="panel-footer">
          <span class="label label-default">
            Excento: {{ $factura->calcularTotal('excento') }}
          </span>
          <span class="label label-info">
            Gravado: {{ $factura->calcularTotal('gravado') }}
          </span>
          <span class="label label-success">
            IVA: {{ $factura->calcularTotal('iva') }}
          </span>
          <span class="label label-primary">
            Total: {{ $factura->calcularTotal('total') }}
          </span>
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