<?php

class CotizacionController extends BaseController
{
    public function getIndex()
    {
        return Redirect::to('cotizaciones/listado');
    }

    public function getListado()
    {
        $cotizaciones = Cotizacion::orderBy('id', 'desc')->paginate(2);

        return View::make('cotizaciones.listado')
            ->with(compact('cotizaciones'));
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

            return Redirect::to('cotizaciones/filtro-por-id/'. $cotizacion->id);

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

    } #guardarItems

    public function getFiltroPorId($idCotizacion=0)
    {
        try
        {
            if($idCotizacion == 0)
            {
                $idCotizacion = Input::get('idCotizacion');
            }

            $cotizaciones = Cotizacion::where('id', '=', $idCotizacion)->orderBy('id', 'desc')->paginate(1);
            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de la cotización '. $idCotizacion);

            return View::make('cotizaciones.listado')
                ->with(compact('cotizaciones'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar '. $idCotizacion);

            return Redirect::to('cotizaciones/listado');
        }

    } #getfiltroPorId

    public function getFiltroPorFechasDeCreacion()
    {
        try
        {
            $input = Input::all();

            $cotizaciones = Cotizacion::where('created_at', '>=', $input['fecha1'])
                ->where('created_at', '<=', $input['fecha2'])
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de cotizaciones creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return View::make('cotizaciones.listado')
                ->with(compact('cotizaciones', 'input'));

        } catch (Exception $e) {

             Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar cotizaciones creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return Redirect::to('cotizaciones/listado');
        }

    } #getFiltroPorFechasDeCreacion

    public function getFiltroPorFechasDeCreacionConCliente()
    {
        try
        {
            if(!Session::has('cliente'))
            {
                Session::flash('mensajeError', 'No fue posible realizar la búsqueda por cliente y rango de fechas de creación porque no especificaste el cliente.');

                return Redirect::to('cotizaciones/listado');
            }

            $input = Input::all();

            $cotizaciones = Cotizacion::where('cliente_id', '=', Session::get('cliente')->id)
                ->where('created_at', '>=', $input['fecha1'])
                ->where('created_at', '<=', $input['fecha2'])
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de cotizaciones del cliente '. Session::get('cliente')->nombre .' creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return View::make('cotizaciones.listado')
                ->with(compact('cotizaciones', 'input'));

        } catch (Exception $e) {

             Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar cotizaciones del cliente '. Session::get('cliente')->nombre .' creadas entre '. $input['fecha1'] .' y '. $input['fecha2']);

            return Redirect::to('cotizaciones/listado');
        }

    } #getFiltroPorFechasDeCreacionConCliente

    public function getFiltroPorNotas()
    {
        try
        {
            $input = Input::all();

            $cotizaciones = Cotizacion::where('notas', 'like', '%'. $input['notas'] .'%')
                ->orderBy('id', 'desc')->paginate(2);

            Session::flash('mensajeOk', 'Se ha realizado la búsqueda de cotizaciones que contienen <strong>'. $input['notas'] .'</strong> en las notas.');

            return View::make('cotizaciones.listado')
                ->with(compact('cotizaciones', 'input'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'Ha ocurrido un error al intentar mostrar cotizaciones con <strong>'. $input['notas'] .'</strong> en las notas.');

            return Redirect::to('cotizaciones/listado');
        }

    } #getFiltroPorNotas

    public function getAlCarrito($idCotizacion)
    {
        try
        {
            $cotizacion = Cotizacion::find($idCotizacion);
            $cotizacion->alCarrito();

            Session::flash('mensajeOk', 'Se han agregado al carrito los items de la cotización '. $idCotizacion);

            return Redirect::to('carrito');

        } catch (Exception $e) {

            Session::flash('mensajeError', 'No fue posible cargar el carrito con los items de la cotización '. $idCotizacion);

            return Redirect::to('cotizaciones/listado');
        }

    } #getAlCarrito

    public function getPdf($idCotizacion, $membrete=0)
    {
        try
        {
            $cotizacion = Cotizacion::find($idCotizacion);

            if($membrete == 1)
            {
                $html = View::make('cotizaciones.membrete')->with(compact('cotizacion'));

            } else {

                $html = View::make('cotizaciones.pdf')->with(compact('cotizacion'));
            }

            return PDF::load($html, 'Letter', 'portrait')->show();
            #return View::make('cotizaciones.pdf')->with(compact('cotizacion'));

        } catch (Exception $e) {

            Session::flash('mensajeError', 'No fue posible generar el PDF de la cotizacion '. $idCotizacion);

            return Redirect::to('cotizaciones/listado');
        }

    } #getConMembrete

} #CotizacionController
