<?php

class FacturaController extends BaseController
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
            $factura = new Factura();
            $factura->cliente_id = Session::get('cliente')->id;
            $factura->vencimiento = $input['vencimiento'];
            $factura->pedido = $input['pedido'];
            $factura->estado = 'pendiente';
            $factura->notas = $input['notas'];
            $factura->user_id = Auth::user()->id;
            $factura->save();

            if(self::guardarItems($factura->id) === false)
            {
                $factura->delete();
                Session::flash('mensajeError', 'No fue posible guardar la factura.');

                return Redirect::to('carrito');
            }

            Session::forget('carrito');
            Session::forget('cliente');
            Session::flash('mensajeOk', 'Has creado la factura '. $factura->id .' con éxito.');

            return Redirect::to('/');

        } catch (Exception $e) {

            Session::flash('mensajeError', 'No fue posible guardar la factura.');

            return Redirect::to('carrito');
        }

    } #postNueva

    private function guardarItems($idFactura)
    {
        try
        {
            if(Session::has('carrito'))
            {
                $carrito = Session::get('carrito');

                if(empty($carrito))
                {
                    $filasAfectadas = FacturaItem::where('factura_id', '=', $idFactura)->delete();

                    return false;
                }

                foreach ($carrito as $item) {
                    $fi = new FacturaItem();
                    $fi->factura_id = $idFactura;
                    $fi->articulo_id = $item['articulo']->id;
                    $fi->cantidad = $item['cantidad'];
                    $fi->precio = $item['articulo']->precio;
                    $fi->iva = $item['articulo']->iva;
                    $fi->save();
                }

                return true;
            }

        } catch (Exception $e) {

            $filasAfectadas = FacturaItem::where('factura_id', '=', $idFactura)->delete();

            return false;
        }
    }
}
