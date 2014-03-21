<?php

class FacturaController extends BaseController
{
    public function getIndex()
    {
        return Redirect::to('facturas/listado');
    }

    public function getListado()
    {
        $facturas = Factura::orderBy('id', 'desc')->paginate(2);

        return View::make('facturas.listado')
            ->with(compact('facturas'));
    }

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

            return Redirect::to('facturas/filtro-por-id/'. $factura->id);

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

    } #guardarItems

    public function getFiltroPorId($idFactura=0)
    {
        try
        {
            if($idFactura == 0)
            {
                $idFactura = Input::get('idFactura');
            }

            $facturas = Factura::where('id', '=', $idFactura)->orderBy('id', 'desc')->paginate(1);
            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de la factura '. $idFactura);

            return View::make('facturas.listado')
                ->with(compact('facturas'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar '. $idFactura);

            return Redirect::to('facturas/listado');
        }

    } #getfiltroPorId

    public function getFiltroPorFechasDeCreacion()
    {
        try
        {
            $input = Input::all();

            $facturas = Factura::where('created_at', '>=', $input['fecha1'])
                ->where('created_at', '<=', $input['fecha2'])
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de facturas creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return View::make('facturas.listado')
                ->with(compact('facturas', 'input'));

        } catch (Exception $e) {

             Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar facturas creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return Redirect::to('facturas/listado');
        }

    } #getFiltroPorFechasDeCreacion

    public function getFiltroPorFechasDeVencimiento()
    {
        try
        {
            $input = Input::all();

            $facturas = Factura::where('vencimiento', '>=', $input['fecha1'])
                ->where('vencimiento', '<=', $input['fecha2'])
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de facturas con fecha de vencimiento entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return View::make('facturas.listado')
                ->with(compact('facturas', 'input'));

        } catch (Exception $e) {

             Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar facturas con fecha de vencimiento entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return Redirect::to('facturas/listado');
        }

    } #getFiltroPorFechasDeVencimiento

    public function getFiltroPorFechasDeCreacionConCliente()
    {
        try
        {
            if(!Session::has('cliente'))
            {
                Session::flash('mensajeError', 'No fue posible realizar la búsqueda por cliente y rango de fechas de creación porque no especificaste el cliente.');

                return Redirect::to('facturas/listado');
            }

            $input = Input::all();

            $facturas = Factura::where('cliente_id', '=', Session::get('cliente')->id)
                ->where('created_at', '>=', $input['fecha1'])
                ->where('created_at', '<=', $input['fecha2'])
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de facturas del cliente '. Session::get('cliente')->nombre .' creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return View::make('facturas.listado')
                ->with(compact('facturas', 'input'));

        } catch (Exception $e) {

             Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar facturas del cliente '. Session::get('cliente')->nombre .' creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return Redirect::to('facturas/listado');
        }

    } #getFiltroPorFechasDeCreacionConCliente

    public function getFiltroPorFechasDeVencimientoConCliente()
    {
        try
        {
            if(!Session::has('cliente'))
            {
                Session::flash('mensajeError', 'No fue posible realizar la búsqueda por cliente y rango de fechas de vencimiento porque no especificaste el cliente.');

                return Redirect::to('facturas/listado');
            }

            $input = Input::all();

            $facturas = Factura::where('cliente_id', '=', Session::get('cliente')->id)
                ->where('vencimiento', '>=', $input['fecha1'])
                ->where('vencimiento', '<=', $input['fecha2'])
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de facturas del cliente '. Session::get('cliente')->nombre .' con fecha de vencimiento entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return View::make('facturas.listado')
                ->with(compact('facturas', 'input'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar facturas del cliente '. Session::get('cliente')->nombre .' con fechas de vencimiento entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return Redirect::to('facturas/listado');
        }

    } #getFiltroPorFechasDeVencimientoConCliente

    public function getFiltroPorNotas()
    {
        try
        {
            $input = Input::all();

            $facturas = Factura::where('notas', 'like', '%'. $input['notas'] .'%')
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de facturas que contienen <strong>'. $input['notas'] .'</strong> en las notas.');

            return View::make('facturas.listado')
                ->with(compact('facturas', 'input'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar facturas con <strong>'. $input['notas'] .'</strong> en las notas.');

            return Redirect::to('facturas/listado');
        }

    } #getFiltroPorNotas

    public function getPdf($idFactura)
    {
        try
        {
            $factura = Factura::find($idFactura);

            $html = View::make('facturas.pdf')->with(compact('factura'));

            return PDF::load($html, 'Letter', 'portrait')->show();
            #return View::make('facturas.pdf')->with(compact('factura'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'No fue posible generar el PDF de la factura '. $idFactura);

            return Redirect::to('facturas/listado');
        }

    } #getPdf

    public function getAlCarrito($idFactura)
    {
        try
        {
            $factura = Factura::find($idFactura);
            $factura->alCarrito();

            Session::flash('mensajeOk', 'Se han agregado al carrito los items de la factura '. $idFactura);

            return Redirect::to('carrito');

        } catch (Exception $e) {

            Session::flash('mensajeError', 'No fue posible cargar el carrito con los items de la factura '. $idFactura);

            return Redirect::to('facturas/listado');
        }

    } #getAlCarrito

} #FacturaController
