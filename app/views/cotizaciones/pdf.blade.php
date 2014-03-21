<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotización</title>
  <link rel="stylesheet" href="css/cotizacion.css" />
  <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" /> -->
</head>
<body>


  <div id="fecha">
    <p class="derecha" id="consecutivo"><strong>Cotizaci&oacute;n No. {{ $cotizacion->id }}</strong></p>
    <p>Arauca, {{ strtolower(BaseController::fechaLarga( date('Y-m-d') )) }}</p>
  </div>

  <p id="cliente">
    {{ utf8_decode('Señores:') }} <br />
    {{ utf8_decode($cotizacion->cliente->nombre) }} <br />
    La ciudad
  </p>

  <p id="concepto"> {{ utf8_decode($cotizacion->concepto) }} </p>

  <div id="items">
    <table>
      <tr>
        <th class="cantidad derecha">Cantidad</th>
        <th class="descripcion">{{ utf8_decode('Artículo') }}</th>
        <th class="valor-unitario">Precio</th>
        <th>IVA</th>
        <th class="valor-total">Total</th>
      </tr>

      @foreach($cotizacion->items as $item)
        <tr>
          <td class="derecha">
            {{ number_format( $item->cantidad, 2, ',', '.' ) }}
          </td>
          <td>
            {{ utf8_decode($item->articulo->nombre) }}
          </td>
          <td class="derecha">
            {{ number_format( $item->precio, 2, ',', '.' ) }}
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

      <tr>
        <td colspan="2" class="invisible">&nbsp;</td>
        <th colspan="2" class="derecha">Excento</th>
        <td class="derecha">
          {{ number_format( $cotizacion->calcularTotal('excento'), 2, ',', '.' ) }}
        </td>
      </tr>
      <tr>
        <td colspan="2" class="invisible">&nbsp;</td>
        <th colspan="2" class="derecha">Gravado</th>
        <td class="derecha">
          {{ number_format( $cotizacion->calcularTotal('gravado'), 2, ',', '.' ) }}
        </td>
      </tr>
      <tr>
        <td colspan="2" class="invisible">&nbsp;</td>
        <th colspan="2" class="derecha">IVA</th>
        <td class="derecha">
          {{ number_format( $cotizacion->calcularTotal('iva'), 2, ',', '.' ) }}
        </td>
      </tr>
      <tr>
        <td colspan="2" class="invisible">&nbsp;</td>
        <th colspan="2" class="derecha">Total</th>
        <td class="derecha">
          {{ number_format( $cotizacion->calcularTotal('total'), 2, ',', '.' ) }}
        </td>
      </tr>
    </table>
  </div>


  <p id="notas"> {{ utf8_decode($cotizacion->notas) }} </p>



  <p id="atentamente">Atentamente,</p>

  <p id="firma">
    <span>LUCERO SANCHEZ</span> <br />
    Gerente comercial
  </p>


</body>
</html>