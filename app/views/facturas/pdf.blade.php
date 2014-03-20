<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Algo</title>

  <link rel="stylesheet" href="css/factura.css" />

</head>
<body>

  <div id="fecha">
    {{ strtoupper(BaseController::fechaLarga($factura->created_at)) }}
  </div>

  <div id="forma-de-pago">
    {{ $factura->formaDePago() }}
  </div>

  <div id="vencimiento">
    @if($factura->formaDePago() != 'CONTADO')
      {{ strtoupper(BaseController::fechaLarga($factura->vencimiento)) }}
    @endif
  </div>

  <div id="nombre">
    {{ $factura->cliente->nombre }}
  </div>

  <div id="nit">
    {{ $factura->cliente->nit }}
  </div>

  <div id="direccion">
    {{ $factura->cliente->direccion }}
  </div>

  <div id="telefono">
    {{ $factura->cliente->telefono }}
  </div>

  <div id="pedido">
    {{ $factura->pedido }}
  </div>

  <table id="items">
    @foreach($factura->items as $item)
      <tr>
        <td class="cantidad">
          {{ $item->cantidad }}
        </td>
        <td class="descripcion">
          {{ $item->articulo->nombre }}
        </td>
        <td class="valor-unitario">
          {{ number_format($item->precio, 2, ',', '.') }}
        </td>
        <td class="valor-total">
          {{ number_format(($item->precio * $item->cantidad), 2, ',', '.') }}
        </td>
      </tr>
    @endforeach
  </table>{{-- /#items --}}

  <div id="excento">
    {{ number_format($factura->calcularTotal('excento'), 2, ',', '.') }}
  </div>

  <div id="subtotal">
    {{ number_format($factura->calcularTotal('gravado'), 2, ',', '.') }}
  </div>

  <div id="iva">
    {{ number_format($factura->calcularTotal('iva'), 2, ',', '.') }}
  </div>

  <div id="total">
    {{ number_format($factura->calcularTotal('total'), 2, ',', '.') }}
  </div>

</body>
</html>