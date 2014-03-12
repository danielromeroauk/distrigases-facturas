<?php

class CotizacionController extends BaseController
{
    public function postNueva()
    {
        try
        {
            if(!Session::has('cliente'))
            {
                Session::flash('mensajeError', 'Debes seleccionar un cliente para continuar.');

                return Redirect::to('carrito');
            }

            $input = Input::all();
            $cotizacion = new Cotizacion();
            $cotizacion->cliente_id = Session::get('cliente')->id;
            $cotizacion->concepto = $input['concepto'];
            $cotizacion->notas = $input['notas'];
            $cotizacion->user_id = Auth::user()->id;
            $cotizacion->save();

            if(self::guardarItems($cotizacion->id) === false)
            {
                $cotizacion->delete();
                Session::flash('mensajeError', 'No fue posible guardar la cotización por uno de sus items.');

                return Redirect::to('carrito');
            }

            Session::forget('carrito');
            Session::forget('cliente');
            Session::flash('mensajeOk', 'Has creado la cotizacion '. $cotizacion->id .' con éxito.');

            return Redirect::to('/');

        } catch (Exception $e) {

            Session::flash('mensajeError', 'No fue posible guardar la nueva cotización.');

            return Redirect::to('carrito');
        }

    } #postNueva

    private function guardarItems($idCotizacion)
    {
        try
        {
            if(Session::has('carrito'))
            {
                $carrito = Session::get('carrito');

                if(empty($carrito))
                {
                    $filasAfectadas = CotizacionItem::where('cotizacion_id', '=', $idCotizacion)->delete();

                    return false;
                }

                foreach ($carrito as $item) {
                    $ci = new CotizacionItem();
                    $ci->cotizacion_id = $idCotizacion;
                    $ci->articulo_id = $item['articulo']->id;
                    $ci->cantidad = $item['cantidad'];
                    $ci->precio = $item['articulo']->precio;
                    $ci->iva = $item['articulo']->iva;
                    $ci->save();
                }

                return true;
            }

        } catch (Exception $e) {

            $filasAfectadas = CotizacionItem::where('cotizacion_id', '=', $idCotizacion)->delete();

            return false;
        }
    }
}
